<?php
/**
 * Jscss Block
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Block_Jscss extends Mage_Core_Block_Template {

	/**
	  *
	  * Retrieve jscss entity
	  *
	  * @param  int | $id
	  * @return Rkt_JsCssforSb_Model_JsCss 
	  *
	  */
	public function getJscssEntity($id){

		return Mage::getModel('rkt_jscssforsb/jsCss')->load($id);
	}

}