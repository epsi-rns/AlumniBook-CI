<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("generic_org.php");

class OMap extends Generic_org {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'omap';
		$this->manageview	= 'entry/omaps';
		$this->editview		= 'entry/editomap';	
		
		$this->load->model('entry/omap_model', 'dbm');
	}		
	
	public function edit($MasterID=null, $ID=null) {
		require_once( APPPATH.'libraries/xajax_plugins/response/modalWindow.inc.php');			

		$this->xajax->register(XAJAX_FUNCTION,	array('modalAlumni',	&$this,	'modalAlumni'));	
		$this->xajax->register(XAJAX_FUNCTION,	array('tablePersons',	&$this,	'tablePersons'));			
		$this->xajax->register(XAJAX_FUNCTION,	array('pickAlumna',		&$this,	'pickAlumna'));					
		$this->xajax->register(XAJAX_FUNCTION,	array('selectJobPosition',	&$this,	'selectJobPosition'));
		$this->xajax->register(XAJAX_FUNCTION,	array('selectJobType',	&$this,	'selectJobType'));	
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}
	
	protected function mapPostData($MasterID) {
		return array(
			'OID'	=> $MasterID,
			'AID'	=> $_POST['id_alumna'],
			'JobTypeID'		=> $_POST['id_occup'],
			'Department'	=> $_POST['dept'],
			'JobPositionID'	=> $_POST['id_pos'],
			'Description'		=> $_POST['desc'],
			'Struktural'		=> $_POST['struktural'],
			'Fungsional'		=> $_POST['fungsional']
		);		
	}

	//-- XAJAX's Function   
	public function modalAlumni() {	
		$objResponse = new xajaxResponse();
		$data['modaltitle'] = "Alumni Query";
		$content = $this->load->view('entry/modalsearch', $data, true);
		$objResponse->plugin( 'clsmodalWindow', 'addWindow', $content, '#000000', 20 );		
		return $objResponse;
	}
	
    public function tablePersons($like) {
		$data['rows']	=& $this->dbm->getPersonsName($like);	
		$content = $this->load->view('entry/tableperson', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("TableID","innerHTML", $content);
        return $objResponse;
    }		
	
    public function pickAlumna($AID) {
		if (empty($AID)) $content = '<i style="color:red">Please select!</i>';
		else $content =	'<b>'.$this->dbm->getAlumnaName($AID).'</b>';

		$content .=	'<input type="hidden" name="id_alumna" 	value="'.$AID.'" />';		

        $objResponse = new xajaxResponse();
        $objResponse->Assign("AlumnaID","innerHTML", $content);
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