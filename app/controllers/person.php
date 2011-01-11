<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("generic_table.php");

class Person extends Generic_table {

	function __construct () { 
		parent::__construct(); 	
		
		$allowedgroup = array('user', 'entry', 'admin');
		$group = $this->session->userdata('group');
		if (!in_array($group, $allowedgroup))	// Trap any request			
			show_error('Sorry. You are not authorized to manage alumni.');
			
		$this->segment		= 'person';
		$this->manageview	= 'entry/alumnus';
		$this->editview		= 'entry/editalumna';	
		$this->icon48			= 'icon-48-categories';		
		
		$this->load->model('entry/alumni_model', 'dbm');
		$this->load->helper('form');
	}	
	
	public function manage() {
		if ($this->input->post('task') == 'refresh') unset($_POST['task']);
		
		if (empty($_POST['task'])) {
			$this->initDateParams();	
			$this->filterParams();
		}	
		
		parent::manage();
	}	
	
	protected function onBeforeManage(&$data) {
		$data['sources']	=& $this->dbm->getSources();
		$data['progs']	=& $this->dbm->getProgs();
		$data['depts']	=& $this->dbm->getDepts();	
		$data['stdt']	= $this->session->userdata('stdta');
		$data['endt']	= $this->session->userdata('endta');				
	}		
	
	public function edit($ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, array('selectSources',	&$this,	'selectSources'));
		$this->xajax->register(XAJAX_FUNCTION, array('selectRels',	&$this,	'selectRels'));		
        $this->xajax->processRequest();

		parent::edit($ID);
	}	
	
	protected function onBeforeEdit(&$data, $ID=null) {
		$data['genders']	= array('M'=>'Male', 'F'=>'Female');
	
		$data['links'] = array(
			4 => 'Communities',	
			1 => 'Map',
			2 => 'Homes',
			3 => 'Contacts',
			5 => 'Degrees',
			6 => 'Experiences',
			7 => 'Competencies',
			8 => 'Certifications'  
		);				
	}	

	protected function mapPostData($ID=null) {
		return array(
			'SourceID'	=> $_POST['id_source'],
			'Name'			=> $_POST['name'],
			'Prefix'			=> $_POST['prefix'],
			'Suffix'			=> $_POST['suffix'],
			'Gender'		=> $_POST['gender'],
			'BirthPlace'	=> $_POST['birthplace'],
			'BirthDate'	=> $_POST['birthdate'],
			'ReligionID'	=> $_POST['id_rel']
		);
	}
	
	// class extension
	public function detail($taskID, $MasterID=null) {	// URL method
		if (empty($MasterID)) { show_404(); return; }

		$details = array(	
			1 => 'amap',		2 => 'ahome',		3 => 'acontact',			4 => 'acomy',			
			5 => 'adegree',	6 => 'aexpi',		7 => 'acompy',			8 => 'acerti'		);	
		$keyID = array_keys($details);
		
		if (in_array($taskID, $keyID))
			redirect($details[$taskID].'/manage/'.$MasterID);
		else show_404();
	}	
	
	private function initDateParams() {		
		// Validate
		$stdt	=	$this->input->post('stdt');
		$endt	=	$this->input->post('endt');
			
		if (empty($stdt) && empty($endt)) {				
			$stdt	=	$this->session->userdata('stdta');
			$endt	=	$this->session->userdata('endta');
		}

		// Get Default Value
		if (empty($stdt) && empty($endt)) {
			$date	= $this->dbm->getLastUpdate();		
			
			$time1	= strtotime($date);
			$time2	= strtotime('+1 days', $time1);

			$stdt	= strftime("%d.%m.%y", $time1);
			$endt	= strftime("%d.%m.%y", $time2);
		}			
			
		// Save for further use
		$_POST['stdt']	=	$stdt;
		$_POST['endt']	=	$endt;
		$this->session->set_userdata('stdta', $stdt);
		$this->session->set_userdata('endta', $endt);	
	}	
	
	private function filterParams() {
		if (isset($_POST['id_source']))
			$this->session->set_userdata('id_source', intval($_POST['id_source'])) ;
			
		if (isset($_POST['id_prog']))
			$this->session->set_userdata('id_prog', intval($_POST['id_prog']) );
			
		if (isset($_POST['id_dept']))
			$this->session->set_userdata('id_dept', intval($_POST['id_dept']) );
			
		if (isset($_POST['year'])) {
			$year = intval($_POST['year']);
			if (($year < 1964) or ($year > 2015)) $year = '';
			$this->session->set_userdata('year', $year);				
		}	
		
		if (isset($_POST['name']))
			$this->session->set_userdata('name', addslashes(trim($_POST['name'])) );		
	}	
	
	//-- XAJAX's Function   
    public function selectSources($orig_val) {
		$pairs	=& $this->dbm->getSources();
		$content = form_dropdown( 'id_source', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("SourceID","innerHTML", $content);
        return $objResponse;
    }		
	
	//-- XAJAX's Function   
    public function selectRels($orig_val) {
		$pairs	=& $this->dbm->getRels();
		$content = form_dropdown( 'id_rel', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("ReligionID","innerHTML", $content);
        return $objResponse;
    }	

} // class

?>