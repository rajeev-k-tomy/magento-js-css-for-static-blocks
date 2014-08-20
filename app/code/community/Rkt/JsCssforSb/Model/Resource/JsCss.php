<?php
/**
 * Resource for jscss
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Model_Resource_JsCss extends Mage_Core_Model_Resource_Db_Abstract {

	/**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('rkt_jscssforsb/jsCss', 'jscss_id');
    }

}