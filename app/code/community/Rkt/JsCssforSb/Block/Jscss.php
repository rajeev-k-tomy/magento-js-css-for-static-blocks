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
	 * Hold jscss entities which are related to static blocks which are 
	 * involved in the current request.
	 * 
	 * @var array
	 */
	protected $_jscss = array();

	/**
     * Initialize template
     *
     */
    protected function _construct()
    {
        $this->setTemplate('rkt_jscssforsb/jscss.phtml');
    }

	/**
	 * Use to set jscss entities
	 * 
	 * @param array $ids
	 */
	public function setActiveJsCss($ids)
	{	
		
		foreach ($ids as $id) {
			$model = Mage::getModel('rkt_jscssforsb/jsCss');
			$this->_jscss[] = $model->load((int)$id);
			unset($model);
		}

		return $this;
	}

	/**
	 * to get jscss enities
	 * @return array
	 */
	public function getActiveJsCss()
	{
		return $this->_jscss;
	}

	/**
	 * Use to get all css related to  static blocks
	 * 
	 * @return array $css an array of stdClass object.
	 */
	public function getAllStyles()
	{
		$css = array();
		foreach ($this->_jscss as $entity) {
			$cssObject = new \stdClass();
			$cssObject->type = 'text/css';
			$cssObject->content = trim($entity->getJscssCss());
			$css[] = $cssObject;
		}

		return $css;
	}

	/**
	 * Use to get all js related to  static blocks
	 * 
	 * @return array $js an array of stdClass object.
	 */
	public function getAllScripts()
	{
		$js = array(); $jscontent = array();
		foreach ($this->_jscss as $entity) {
			$jsObject = new \stdClass();
			$jsObject->type = 'text/javascript';
			$jsObject->content = trim($entity->getJscssJs());
			$js[] = $jsObject;
			$jscontent[] = $entity->getJscssJs();
		}

		return $js;
	}
}