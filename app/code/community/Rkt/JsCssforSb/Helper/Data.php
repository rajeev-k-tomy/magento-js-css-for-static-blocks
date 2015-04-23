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
 * Helper 
 *
 * @category   Rkt
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Helper_Data extends Mage_Core_Helper_Abstract 
{
	
	/**
	 * Use to check whether the passed variable is a static block instance
	 * 
	 * @param  mixed  $block 
	 * @return boolean
	 */
	public function isStaticBlock($block)
	{
		if ($block instanceof Mage_Cms_Block_Block) {
			return true;
		} else {
			return false;
		}
	}
}
