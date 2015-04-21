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
 * Jscss Block
 *
 * @category   Rkt
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Block_Jscss extends Mage_Core_Block_Template 
{

	/**
	  *
	  * Retrieve jscss entity
	  *
	  * @param  int | $id
	  * @return Rkt_JsCssforSb_Model_JsCss 
	  *
	  */
	public function getJscssEntity($id)
	{

		return Mage::getModel('rkt_jscssforsb/jsCss')->load($id);
	}

}