<?php
/**
 * Rkt_JsCssforSb extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_JSSB.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Rkt
 * @package        Rkt_JsCssforSb
 * @copyright      Copyright (c) 2015   
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */ 

/**
 * Cms Template Filter Model
 *
 * @category    Rkt
 * @package     Rkt_JsCssforSb
 * @author      programmer-RKT
 */
class Rkt_JsCssforSb_Model_Template_Filter extends Mage_Cms_Model_Template_Filter
{
   	
   	protected $_allowedFilterDirectives = array(
   		'blockDirective', 'layoutDirective'
   	);

   	/**
     * Filter the string to find the static block directives.
     *
     * @param string $value
     * @return array
     */
    public function filter($value)
    {
    	$blocks = array(); 
    	$staticblocks = array();
        if(preg_match_all(Varien_Filter_Template::CONSTRUCTION_PATTERN, 
        	$value, $constructions, PREG_SET_ORDER)
        ) {
            foreach ($constructions as $index => $construction) {
            	/**
            	 * @var $construction = array[3]
				 *               $construction[0] = (string) {{block id="test-sb"}}
				 *               $construction[1] = (string) block
				 *               $construction[2] = (string)  id="test-sb"
            	 */
            	$filterDirective = $construction[1] . 'Directive';
                $callback = array($this, $filterDirective);
                if (!is_callable($callback) 
                	|| !$this->isAllowedFilterDirective($filterDirective)
                ) {
                    continue;
                }
                try {
                    $callbackOutput = call_user_func($callback, $construction);
                } catch (Exception $e) {
                    throw $e;
                }

                if (count($blocks) == 0) {
                	$blocks = $this->_filterStaticBlocks($callbackOutput);
                	$staticblocks = $blocks;
                } else {
	                $staticblocks = array_merge(
	                	$blocks, 
	                	$this->_filterStaticBlocks($callbackOutput)
	                );
	            }
                
            }
        }
        return $staticblocks;
    }

    /**
     * Retrieve Block html directive
     *
     * @param array $construction
     * @return string
     */
    public function blockDirective($construction)
    {	
    	$block = '';
        $skipParams = array('type', 'id', 'output');
        $blockParameters = $this->_getIncludeParameters($construction[2]);
        $layout = Mage::app()->getLayout();

        if (isset($blockParameters['type'])) {
            $type = $blockParameters['type'];
            if ($type == 'cms/block') {
            	$block = $layout->createBlock($type, null, $blockParameters);
            }
            
        } elseif (isset($blockParameters['id'])) {
            $block = $layout->createBlock('cms/block');
            if ($block) {
                $block->setBlockId($blockParameters['id']);
            }
        }

        return $block;
    }

    /**
     * Retrieve layout html directive
     *
     * @param array $construction
     * @return array
     */
    public function layoutDirective($construction)
    {
    	$staticblocks = array();
        $skipParams = array('handle', 'area');

        $params = $this->_getIncludeParameters($construction[2]);
        $layout = Mage::getModel('core/layout');
        /* @var $layout Mage_Core_Model_Layout */
        if (isset($params['area'])) {
            $layout->setArea($params['area']);
        }
        else {
            $layout->setArea(Mage::app()->getLayout()->getArea());
        }

        $layout->getUpdate()->addHandle($params['handle']);
        $layout->getUpdate()->load();

        $layout->generateXml();
        $layout->generateBlocks();

        foreach ($layout->getAllBlocks() as $blockName => $block) {
            /* @var $block Mage_Core_Block_Abstract */
            if (Mage::helper('rkt_jscssforsb')->isStaticBlock($block)) {
            	$staticblocks[] = $block;
            }
           
        }

        return $staticblocks;
    }

    /**
     * check whether passed directive filter is allowed
     * 
     * @param  string  $directive
     * @return boolean
     */
    public function isAllowedFilterDirective($directive)
    {
    	$condition = in_array($directive, $this->_allowedFilterDirectives);
    	if ($condition) {
    		return true;
    	} else {
    		return false;
    	}
    }

    /**
     * Use to filter out items which are instance of cms block
     * 
     * @param  mixed $callbackOutput
     * @return array $staticblocks
     */
    protected function _filterStaticBlocks($callbackOutput)
    {	$staticblocks = array();
    	$jscssHelper = Mage::helper('rkt_jscssforsb');
        if ($jscssHelper->isStaticBlock($callbackOutput)) {
            $staticblocks[$callbackOutput->getBlockId()] = $callbackOutput;
        } elseif (is_array($callbackOutput)) {
            foreach ($callbackOutput as $block) {
        		if ($jscssHelper->isStaticBlock($block)) {
                	$staticblocks[$block->getBlockId()] = $block;
            	}
        	}
        }

        return $staticblocks;
    }

}
