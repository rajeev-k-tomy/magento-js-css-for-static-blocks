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
	  *
	  * Use to trim unwanted spaces, new lines from passed data
	  *
	  * @param  string $data
	  * @return string  
	  *
	  */
	public function modifyData($data)
	{
		if ($data != '') {
			$trimed_data = str_replace(array(" ", "\n", "\t", "'"), array("", "", "", '"'), trim($data));	
			return preg_replace('/\s+/', '', $trimed_data);
		}

		return '';
	}
}
