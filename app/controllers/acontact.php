<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class AContact extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'acontact';
		$this->manageview	= 'entry/acontacts';
		$this->editview		= 'entry/editacontact';	
		
		$this->load->model('entry/acontact_model', 'dbm');
	}		
	
	protected function onBeforeEdit(&$data, $ID) {
		$data['contacttypes']	=& $this->dbm->getContactTypes();
	}	

	protected function mapPostData($MasterID) {
		return array(
			'LID'			=> $MasterID,
			'LinkType'	=> 'A',
			'CTID'		=> $_POST['id_ct'],
			'Contact'	=> $_POST['contact']
		);		
	}

} // class

?>