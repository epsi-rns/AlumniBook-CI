<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class AExpi extends Generic_alumni{

	function __construct () { 
		parent::__construct(); 	
		
		$this->segment		= 'aexpi';
		$this->manageview	= 'entry/aexperiences';
		$this->editview		= 'entry/editaexperience';	
		
		$this->load->model('entry/aexperience_model', 'dbm');
	}	
	
	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'Organization'	=> $_POST['org'],
			'JobPosition'		=> $_POST['jobpos'],
			'YearIn'				=> $_POST['yearin'],
			'YearOut'			=> $_POST['yearout'],
			'Description'		=> $_POST['desc'],
		);
	}

} // class

?>