<?php
/**
 * Collection for jscss
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Model_Resource_JsCss_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {

	protected function _construct(){

		$this->_init('rkt_jscssforsb/jsCss');
	}
}