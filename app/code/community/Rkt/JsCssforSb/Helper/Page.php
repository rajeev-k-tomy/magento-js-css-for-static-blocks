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
 * CMS Page Helper 
 *
 * @category   Rkt
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Helper_Page extends Mage_Core_Helper_Abstract 
{
	
	/**
     * Retrieve Template processor for Page Content
     *
     * @return Varien_Filter_Template
     */
    public function getPageTemplateProcessor()
    {
        return Mage::getModel('rkt_jscssforsb/template_filter');
    }

    /**
     * Use to find static blocks which is included in the cms page
     * content section
     * 
     * @return array
     */
    public function findStaticBlocks($cmsContent)
    {
        $processor = $this->getPageTemplateProcessor();
        $blocks = $processor->filter($cmsContent);
        return $blocks;
    }
}
