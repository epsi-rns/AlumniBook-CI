<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class ACerti extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'acerti';
		$this->manageview	= 'entry/acertifications';
		$this->editview		= 'entry/editacerti';	
	
		$this->load->model('entry/acerti_model', 'dbm');
	}		
	
	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'Certification'	=> $_POST['certification'],
			'Institution'		=> $_POST['institution']
		);		
	}

} // class

?>