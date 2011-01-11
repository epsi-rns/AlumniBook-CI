<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_table.php");

class Org extends Generic_table {

	function __construct () { 
		parent::__construct(); 	
		
		$allowedgroup = array('user', 'entry', 'admin');
		$group = $this->session->userdata('group');
		if (!in_array($group, $allowedgroup))	// Trap any request			
			show_error('Sorry. You are not authorized to manage organization.');
			
		$this->segment		= 'org';
		$this->manageview	= 'entry/orgs';
		$this->editview		= 'entry/editorg';	
		$this->icon48			= 'icon-48-categories';		
		
		$this->load->model('entry/org_model', 'dbm');
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
		$data['stdt']	= $this->session->userdata('stdto');
		$data['endt']	= $this->session->userdata('endto');		
	}	
	
	public function edit($ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, array('selectSources',	&$this,	'selectSources'));
        $this->xajax->processRequest();

		parent::edit($ID);
	}	
	
	protected function onBeforeEdit(&$data, $ID=null) {
		$data['links'] = array(
			1 => 'Map',
			2 => 'Offices',
			3 => 'Contacts',
			4 => 'Bidang Usaha'
		);				
	}	

	protected function mapPostData($ID=null) {
		return array(
			'SourceID'		=> $_POST['id_source'],
			'Organization'	=> $_POST['org'],
//			'ParentID'			=> $_POST['id_parent'],			
//			'HasBranch'		=> $_POST['hasbranch'],
			'Product'			=> $_POST['product']
		);		
	}
	
	// class extension
	public function detail($taskID, $MasterID=null) {	// URL method
		if (empty($MasterID)) { show_404(); return; }

		$details = array(	1 => 'omap',	2 => 'ooffice',	3 => 'ocontact',	4 => 'ofield',	);	
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
			$stdt	=	$this->session->userdata('stdto');
			$endt	=	$this->session->userdata('endto');
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
		$this->session->set_userdata('stdto', $stdt);
		$this->session->set_userdata('endto', $endt);	
	}	
	
	private function filterParams() {
		if (isset($_POST['orgname']))
			$this->session->set_userdata('orgname', addslashes(trim($_POST['orgname'])) );		
	}	
	
	//-- XAJAX's Function   
    public function selectSources($orig_val) {
		$pairs	=& $this->dbm->getSources();
		$content = form_dropdown( 'id_source', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("SourceID","innerHTML", $content);
        return $objResponse;
    }		

} // class

?>