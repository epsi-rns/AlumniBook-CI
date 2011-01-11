<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class ADegree extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'adegree';
		$this->manageview	= 'entry/adegrees';
		$this->editview		= 'entry/editadegree';	
		
		$this->load->model('entry/adegree_model', 'dbm');	
	}		
	
	protected function onBeforeEdit(&$data, $ID) {
		$data['strata']	=& $this->dbm->getStrata();
	}		

	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'StrataID'		=> $_POST['id_strata'],
			'Admitted'	=> $_POST['yearin'],
			'Graduated'	=> $_POST['yearout'],
			'Degree'		=> $_POST['degree'],
			'Institution'	=> $_POST['institution'],
			'Major'			=> $_POST['major'],
			'Minor'			=> $_POST['minor'],
			'Concentration'	=> $_POST['concentration']
		);
	}
} // class

?>