<?php
/**
 * Observer that adds new fieldsets for cms -> static blocks
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */

class Rkt_JsCssforSb_Model_Observer {

	/**
	  *
	  * Use to set jsscss fieldsets in cms_block
	  *
	  * @param  Varien_Event_Observer | $observer
	  *
	  */
	public function addNewFieldsetForCmsBlock($observer) { 

		 $block = $observer->getEvent()->getBlock();
		
		//check whether block is cms_block_form
	    if ($block instanceof Mage_Adminhtml_Block_Cms_Block_Edit_Form) {
	         
	        //get cms_block form
	        $form = $block->getForm();

	        //get jscss values
	        $js_value = ''; $css_value = '';
	        $block_id = (int)Mage::registry('cms_block')->getBlockId();
	        $cms_block = $this->getJsCssEntity($block_id);

	        //get values if entity exist
	        if($cms_block){

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

		return;
	}

	/**
	  *
	  * Use to save js and css for cms_block
	  *
	  * @param  Varien_Event_Observer | $observer
	  *
	  */
	public function saveJsCss($observer) {

		//get object
		$cms_block = $observer->getEvent()->getObject();

        //retrieve essential datas to store
		$block_id = (int)$cms_block->getBlockId();
		$js = Mage::helper('rkt_jscssforsb')->modifyData($cms_block->getJscssJs());
		$css = Mage::helper('rkt_jscssforsb')->modifyData($cms_block->getJscssCss());

		if($js != '' || $css != ''){ 
			
			//prepare data to save
			$data = array(
				'block_id' => $block_id,
				'jscss_js' => $js,
				'jscss_css'  => $css,
			);

			//model
			$model = Mage::getModel('rkt_jscssforsb/jsCss');

			//saves data if cms block is new
			if(!$this->getJsCssEntity($block_id)){

				$model->addData($data);
				$model->save();
			}

			//saves data if entry already exist
			else {

				$exist_block = $this->getJsCssEntity($block_id);
				$exist_block->addData($data);
				$exist_block->save();

			}
		}

	}

	/**
	  *
	  * Apply css and js to static blocks
	  *
	  * @param  Varien_Event_Observer | $observer
	  *
	  */
	public function applyJsCssToCMSBlocks($observer) {

		//set default values to variables
		$flag = 0; $jscss_ids = array();

		$layout = $observer->getEvent()->getLayout();

		foreach ($layout->getAllBlocks() as $block) {
		
			if ($block instanceof Mage_Cms_Block_Block) {

				$flag = 1;
				//get cms block id
				$block_identifier = $block->getBlockId();
				$block_id = (int)Mage::getModel('cms/block')->getCollection()
				 			->addFieldToSelect('block_id')
				 			->addFieldToFilter('identifier', array('eq' => $block_identifier))
				 			->load()
				 			->getFirstItem()
				 			->getBlockId();
				

	     		//check for any entry that is correspond for cms block
	     		if($cms_block = $this->getJsCssEntity($block_id)){

	     			//store jscss ids
	     			$jscss_ids[] = (int)$cms_block->getJscssId();

	     			
	     		}
				
			}
		}
		//print_r($jscss_ids);die();
		if($flag == 1){

			//create a custom block to insert js and css correspond to cms block
	     	$new_block = $layout->createBlock(

				'Rkt_JsCssforSb_Block_Jscss',
				'jscss_block',
				array(

					'template' => 'rkt_jscssforsb/jscss.phtml',
					'jscss_ids' => Mage::helper('rkt_jscssforsb')->__(implode(",",$jscss_ids)),
			));
			$layout->getBlock('content')->append($new_block);

		}
		
	}

	/**
	  *
	  * Use to get jscss entity correspond to cms > block that is editing currently
	  *
	  * @param  int | $block_id
	  * @return boolean or Rkt_JsCssforSb_Model_JsCss | false or $item
	  *
	  */
	public function getJsCssEntity($block_id){

		//loads collection
		$collection = Mage::getModel('rkt_jscssforsb/jsCss')->getCollection()
						->addFieldToSelect('*')
	        			->addFieldToFilter('block_id', array('eq' => $block_id))		
	        			->load();
	    //ensure an item exist
	    if(count($collection->getFirstItem()->getData())){

	    	return $collection->getFirstItem();
	    }
	    
	    return false;
	}
}
//http://stackoverflow.com/questions/17832914/how-do-i-extend-cms-block-on-save-event-of-magento
?>

