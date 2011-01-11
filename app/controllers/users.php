<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_table.php");

class Users extends Generic_table {
	
	function __construct () { 
		parent::__construct(); 	
		
		if ($this->session->userdata('group')!='admin')		// Trap any request
			show_404('page');
			
		$this->segment		= 'users';
		$this->manageview	= 'admin/users';
		$this->editview		= 'admin/edituser';	
		$this->icon48			= 'icon-48-user';
		
		$this->load->model('admin/users_model', 'dbm');	
	}		
		
	protected function save($ID=null) {
		// Override parent's method		
		$data = array(
				'username'	=> 	$_POST['username'],
				'gruppe'		=> 	$_POST['group']  );

		if (empty($ID)) {
			$data['password'] = md5($_POST['password_new']);
			$this->dbm->insert($data);				
			$this->NewID = $this->dbm->getID($_POST['username']);
		} else {						
			if (!empty($_POST['password_new']))		// using simple javascript validation
				$data['password']	= md5($_POST['password_new']);
				
			$this->dbm->update($ID, $data);
		}
	}

} // class

?>