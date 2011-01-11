<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class auth_model extends Model {
	private $allowedtime = 600;	//	3600;	// in seconds, one hour login
	private $dbauth;
	
	function __construct () { 	
		parent::__construct();	
		$this->dbauth	= $this->load->database('auth', TRUE);	// sqlite driver

		// for 1.6, 1.5 use $this->uri->router->class		
		if ($this->uri->rsegments[1] != 'user')		// Trap any request
			if (!$this->checkSession())	redirect('user/in');			
	}	
	
	public function checkSession() { 
		$this->checkTime();
		return (bool)$this->session->userdata('username'); 
	}
	
	public function checkTime() { 
		$last = $this->session->userdata('last_activity');
		$test = (bool)(time()-$last > $this->allowedtime);
		if ($test) $this->logout();
	}	
	
	public function getDBAuth($username) {
		$sql		= "SELECT password from auth where username='$username'";
		return $this->dbauth->query($sql)->row()->password;
	}	
	
	public function getGroup($username) {
		$sql		= "SELECT gruppe from auth where username='$username'";
		return $this->dbauth->query($sql)->row()->gruppe;
	}		
	
	public function checkPost () {
		$auth = false;
		
		if (!empty($_POST['username']) && !empty($_POST['password']))
		{
			$password = $_POST['password'];
			unset($_POST['password']); // wipe any traceof password;
			$pass = $this->getDBAuth($_POST['username']);
			$auth = ($pass==md5($password));
		}			
		
		if ($auth) {
			$this->session->set_userdata('username', $_POST['username']);
			$this->session->set_userdata('group', $this->getGroup($_POST['username']));			
		}	
		
		return $auth;
	}	
	
	public function logout () {	
		$this->session->set_userdata('username', null); 
		$this->session->set_userdata('group', null); 
	}	
	
	public function changepassword($username, $password) {
		$this->dbauth->where("username = '$username' ");
		$this->dbauth->update('auth', array('password' => md5($password))); 
	}		
	
}	// class

?>