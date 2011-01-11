<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("generic_alumni.php");

class AMap extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'amap';
		$this->manageview	= 'entry/amaps';
		$this->editview		= 'entry/editamap';	
		
		$this->load->model('entry/amap_model', 'dbm');
	}		
	
	public function edit($MasterID=null, $ID=null) {
		require_once( APPPATH.'libraries/xajax_plugins/response/modalWindow.inc.php');			

		$this->xajax->register(XAJAX_FUNCTION,	array('modalOrg',	&$this,	'modalOrg'));	
		$this->xajax->register(XAJAX_FUNCTION,	array('tableOrg',		&$this,	'tableOrg'));			
		$this->xajax->register(XAJAX_FUNCTION,	array('pickOrg',		&$this,	'pickOrg'));					
		$this->xajax->register(XAJAX_FUNCTION,	array('selectJobPosition',	&$this,	'selectJobPosition'));
		$this->xajax->register(XAJAX_FUNCTION,	array('selectJobType',	&$this,	'selectJobType'));	
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}
	
	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'OID'	=> $_POST['id_org'],
			'JobTypeID'		=> $_POST['id_occup'],
			'Department'	=> $_POST['dept'],
			'JobPositionID'	=> $_POST['id_pos'],
			'Description'		=> $_POST['desc'],
			'Struktural'		=> $_POST['struktural'],
			'Fungsional'		=> $_POST['fungsional']
		);		
	}
	
	//-- XAJAX's Function   
	public function modalOrg() {	
		$objResponse = new xajaxResponse();
		$data['modaltitle'] = "Organization Query";
		$content = $this->load->view('entry/modalsearch', $data, true);
		$objResponse->plugin( 'clsmodalWindow', 'addWindow', $content, '#000000', 20 );		
		return $objResponse;
	}
	
    public function tableOrg($like) {
		$data['rows']	=& $this->dbm->getOrgsName($like);	
		$content = $this->load->view('entry/tableorg', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("TableID","innerHTML", $content);
        return $objResponse;
    }		
	
    public function pickOrg($OID) {
		if (empty($OID)) $content = '<i style="color:red">Please select!</i>';
		else $content =	'<b>'.$this->dbm->getOrgName($OID).'</b>';

		$content .=	'<input type="hidden" name="id_org" 	value="'.$OID.'" />';		

        $objResponse = new xajaxResponse();
        $objResponse->Assign("OrganizationID","innerHTML", $content);
        return $objResponse;
    }			
	
    public function selectJobPosition($orig_val) {
		$pairs	=& $this->dbm->getJobPosition();	
		$content = form_dropdown( 'id_pos', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("JobPositionID","innerHTML", $content);
        return $objResponse;
    }		

    public function selectJobType($orig_val) {
		$pairs	=& $this->dbm->getJobType();	
		$content = form_dropdown( 'id_occup', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("JobTypeID","innerHTML", $content);
        return $objResponse;
    }			

} // class

?>