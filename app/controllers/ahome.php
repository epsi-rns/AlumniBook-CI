<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class AHome extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'ahome';
		$this->manageview	= 'entry/ahomes';
		$this->editview		= 'entry/editahome';	
		
		$this->load->model('entry/ahome_model', 'dbm');
	}		
	
	public function edit($MasterID=null, $ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, array('selectNegara',	&$this,	'selectNegara'));
		$this->xajax->register(XAJAX_FUNCTION, array('selectPropinsi',	&$this,	'selectPropinsi'));		
		$this->xajax->register(XAJAX_FUNCTION, array('selectWilayah',	&$this,	'selectWilayah'));		
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}

	protected function mapPostData($MasterID) {
		return array(
			'LID'				=> $MasterID,
			'LinkType'		=> 'A',
			'Kawasan'		=> $_POST['kawasan'],
			'Gedung'		=> $_POST['gedung'],
			'Jalan'			=> $_POST['jalan'],
			'PostalCode'	=> $_POST['postalcode'],
			'NegaraID'	=> $_POST['id_negara'],
			'PropinsiID'	=> $_POST['id_propinsi'],
			'WilayahID'	=> $_POST['id_wilayah']
		);		
	}
	
	//-- XAJAX's Function   
    public function selectNegara($orig_val) {
		$pairs	=& $this->dbm->getNegara();
		$content = form_dropdown( 'id_negara', $pairs, $orig_val, 'size="3"');

        $objResponse = new xajaxResponse();
        $objResponse->Assign("NegaraID","innerHTML", $content);
        return $objResponse;
    }	
	
    public function selectPropinsi($orig_val) {
		$pairs	=& $this->dbm->getPropinsi();
		$content = form_dropdown( 'id_propinsi', $pairs, $orig_val, 'size="3" onChange="cdl();"');

        $objResponse = new xajaxResponse();
        $objResponse->Assign("PropinsiID","innerHTML", $content);
        return $objResponse;
    }		
	
    public function selectWilayah($key, $orig_val) {
		$pairs	=& $this->dbm->getLimitedWilayah($key);
		$content = form_dropdown( 'id_wilayah', $pairs, $orig_val, 'size="3"');	

        $objResponse = new xajaxResponse();
        $objResponse->Assign("WilayahID","innerHTML", $content);
        return $objResponse;
    }	

} // class

?>