<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_org.php");

class OContact extends Generic_org {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'ocontact';
		$this->manageview	= 'entry/ocontacts';
		$this->editview		= 'entry/editocontact';	
		
		$this->load->model('entry/ocontact_model', 'dbm');
	}		

	protected function onBeforeEdit(&$data, $ID=null) {
		$data['contacttypes']	=& $this->dbm->getContactTypes();		
	}

	protected function mapPostData($MasterID) {
		return array(
			'LID'			=> $MasterID,
			'LinkType'	=> 'O',
			'CTID'		=> $_POST['id_ct'],
			'Contact'	=> $_POST['contact']
		);		
	}
} // class

?>