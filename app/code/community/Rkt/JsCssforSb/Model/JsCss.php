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
 * Model for jscss
 *
 * @category   Rkt
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Model_JsCss extends Mage_Core_Model_Abstract 
{

	/**
	 * constructor
	 * 
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('rkt_jscssforsb/jsCss');
	}

	/**
	 * Use to get jscss entry based on static block id
	 * 
	 * @param  int $id
	 * @return Rkt_JsCssforSb_Model_JsCss
	 */
	public function getJsCssByStaticBlockId($id)
	{
		return $this->load($id, 'block_id'); 
	}
}