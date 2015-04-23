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
 * Observer that adds new fieldsets for cms -> static blocks
 *
 * @category   Rkt
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */

class Rkt_JsCssforSb_Model_Observer 
{

	/**
	 *
	 * Use to set jsscss fieldsets in cms_block
	 *
	 * @param  Varien_Event_Observer | $observer
	 * @return Rkt_JsCssforSb_Model_Observer
	 */
	public function addNewFieldsetForCmsBlock(Varien_Event_Observer $observer) 
	{ 
		$block = $observer->getEvent()->getBlock();
		
		//check whether block is cms_block_form
	    if ($block instanceof Mage_Adminhtml_Block_Cms_Block_Edit_Form) {
	         
	        //get cms_block form
	        $form = $block->getForm();
	        $jscssModel = Mage::getModel('rkt_jscssforsb/jsCss');

	        //get jscss values
	        $js_value = ''; $css_value = '';
	        $block_id = (int) Mage::registry('cms_block')->getBlockId();
	        $cms_block = $jscssModel->getJsCssByStaticBlockId($block_id);

	        //get values if entity exist
	        if ($cms_block) {
	        	$js_value = $cms_block->getJscssJs();
	        	$css_value = $cms_block->getJscssCss();
	        }

	        //add jscss fieldsets and its fields
	    	$fieldset = $form->addFieldset('jscss_fieldset', array(
	            'legend'=>Mage::helper('rkt_jscssforsb')->__('Js/Css Section'), 
	            'class' => 'fieldset-wide')
	        );
		    $fieldset->addField('jscss_js', 'textarea', array(
	            'name'      => 'jscss_js',
	            'label'     => Mage::helper('rkt_jscssforsb')->__('Insert Javascript'),
	            'title'     => Mage::helper('rkt_jscssforsb')->__('Insert Javascript'),
	            'required'  => false,
	            'value'		=> Mage::helper('rkt_jscssforsb')->__($js_value),
	            
	        ));
	        $fieldset->addField('jscss_css', 'textarea', array(
	            'name'      => 'jscss_css',
	            'label'     => Mage::helper('rkt_jscssforsb')->__('Insert CSS'),
	            'title'     => Mage::helper('rkt_jscssforsb')->__('Insert CSS'),
	            'required'  => false,
	            'value'		=> Mage::helper('rkt_jscssforsb')->__($css_value),
	            
	        ));
		}

		return $this;
	}

	/**
	 *
	 * Use to save js and css for cms_block
	 *
	 * @param  Varien_Event_Observer | $observer
	 * @return Rkt_JsCssforSb_Model_Observer
	 */
	public function saveJsCss(Varien_Event_Observer $observer) 
	{

		//get object
		$cms_block = $observer->getEvent()->getObject();

        //retrieve essential datas to store
		$block_id = (int) $cms_block->getBlockId();
		$js = $cms_block->getJscssJs();
		$css = $cms_block->getJscssCss();

		if ($js != '' || $css != '') { 

			//prepare data to save
			$data = array(
				'block_id' => $block_id,
				'jscss_js' => $js,
				'jscss_css'  => $css,
			);

			//model
			$model = Mage::getModel('rkt_jscssforsb/jsCss');

			//saves data if cms block is new
			if (!$model->getJsCssByStaticBlockId($block_id)) {
				$model->addData($data);
				$model->save();

			} else { //saves data if entry already exist
				$exist_block = $model->getJsCssByStaticBlockId($block_id);
				$exist_block->addData($data);
				$exist_block->save();
			}
		}
		return $this;
	}

	/**
	 *
	 * Apply css and js to static blocks
	 *
	 * @param  Varien_Event_Observer | $observer
	 * @return Rkt_JsCssforSb_Model_Observer
	 */
	public function applyJsCssToCMSBlocks(Varien_Event_Observer $observer) 
	{
		$flag = 0; 
		$jscss_ids = array();
		$pageHelper = Mage::helper('rkt_jscssforsb/page');
		$jscssHelper = Mage::helper('rkt_jscssforsb');

		$layout = $observer->getEvent()->getLayout();

		foreach ($layout->getAllBlocks() as $block) {
			
			//look static blocks in layouts. If static blocks are
			//there, then collect corresponding js css entry.
			if ($jscssHelper->isStaticBlock($block)) {
				$flag = 1;
				$jscss = $this->_getJsCss($block);
				if ((int)$jscss->getJscssId() > 0) {
					$jscss_ids[] = (int)$jscss->getJscssId();
				}
			}

			//There may be static blocks that are included via CMS Page
			//content section as block directive or layout directive. 
			//In that case, find them and collect the js css entry.
			if ($block instanceof Mage_Cms_Block_Page) {
				$flag = 1;

				$page = $block->getPage();
				$content = $page->getContent();

				$cmsStaticBlocks = $pageHelper->findStaticBlocks($content);
				foreach ($cmsStaticBlocks as $sb) {
					if ($jscssHelper->isStaticBlock($sb)) {
						$jscss = $this->_getJsCss($sb);
						if ((int)$jscss->getJscssId() > 0) {
							$jscss_ids[] = (int)$jscss->getJscssId();
						}
					}
				}
			}
		}

		//if jscss entity exist for any of the static block that is included
		//in the requested  page, then include those js and css files into the
		//layout.
		if ($flag == 1 && count($jscss_ids) > 0) {
	     	$jscssBlock = $layout->createBlock('rkt_jscssforsb/jscss', 'jscss_block');
			$jscssBlock->setActiveJsCss($jscss_ids);
			$layout->getBlock('head')->append($jscssBlock);
		}

		return $this;	
	}

	/**
	 * Use to get jscss entity corresponding to the static block passed
	 * 
	 * @param  Mage_Cms_Block_Block $block
	 * @return Rkt_JsCssforSb_Model_JsCss $jscss
	 */
	protected function _getJsCss(Mage_Cms_Block_Block $block)
	{
		$CMSBlockModel = Mage::getModel('cms/block');
		$jscssModel = Mage::getModel('rkt_jscssforsb/jsCss');

		/** @var  $sb->getBlockId() returns static block identifier */
		$staticBlock = $CMSBlockModel->load($block->getBlockId(), 'identifier');
		$id = (int)$staticBlock->getBlockId();
		$jscss = $jscssModel->getJsCssByStaticBlockId($id);

		return $jscss;
	}
}