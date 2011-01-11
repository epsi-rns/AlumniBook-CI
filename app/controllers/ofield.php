<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_org.php");

class OField extends Generic_org {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'ofield';
		$this->manageview	= 'entry/ofields';
		$this->editview		= 'entry/editofield';	
		
		$this->load->model('entry/ofield_model', 'dbm');
	}		
	
	public function edit($MasterID=null, $ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, array('selectFields',	&$this,	'selectFields'));
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}

	protected function mapPostData($MasterID) {
		return array(
			'OID'				=> $MasterID,
			'FieldID'		=> $_POST['id_field'],
			'Description'	=> $_POST['desc']
		);		
	}
	
	//-- XAJAX's Function   
    public function selectFields($orig_val) {
		$pairs	=& $this->dbm->getFields();
		$content = form_dropdown( 'id_field', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("FieldsID","innerHTML", $content);
        return $objResponse;
    }		

} // class

?>