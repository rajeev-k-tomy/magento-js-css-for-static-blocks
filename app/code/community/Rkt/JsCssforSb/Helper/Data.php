<?php
/**
 * Helper 
 *
 * @category   Extension
 * @package    Rkt_JsCssforSb
 * @author     Programmer-RKT
 */
class Rkt_JsCssforSb_Helper_Data extends Mage_Core_Helper_Abstract {
	
	/**
	  *
	  * Use to trim unwanted spaces, new lines from passed data
	  *
	  * @param  string | $data
	  * @return string  
	  *
	  */
	public function modifyData($data){
		if($data != '')
			$trimed_data = str_replace(array(" ","\n","\t","'"),array("","","",'"'),trim($data));	

			return preg_replace('/\s+/','',$trimed_data	);
		}

		return '';
	}
}