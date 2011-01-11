<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class User extends Controller {

	function __construct () { 
		parent::__construct(); 	
		
		$this->load->model('init_model');	// loaded first
	}		
	
	public function index()	{	
		$data['task'] = 'in';		
		$this->theme->view('front/auth', $data);		
	}
	
	public function in()	{
		$data['task'] = 'in';
		
		if( isset($_POST['username']) ) {
			$isLogin = $this->auth->checkPost();
			if ($isLogin)	redirect('main/index');
			else $data['message'] = 'login failed.';
		}	
		
		$this->theme->view('front/auth', $data);		
	}	
	
	public function out()	{
		$data['task'] = 'out';
		$data['username'] = $this->session->userdata('username');
		$this->auth->logout();	// After get username

		$this->theme->view('front/auth', $data);		
	}		
	
	public function cpass()	{
		$data['task'] = 'cpass';
		$data['username'] = $this->session->userdata('username');	
		
		if( isset($_POST['password_old']) ) {
			$pass = $this->auth->getDBAuth($data['username']);
			$auth = ($pass==md5($_POST['password_old']));
	
			$confirmed = ($_POST['password_new'] == $_POST['password_confirm']);
	
			$mess = array();
			if (!$auth) $mess[] = 'old password does not match.';
			if (!$confirmed) $mess[] = 'new passwords do not match.';			
			if (!empty($mess)) $data['message'] = implode ('<br/>', $mess);
	
			if ($auth && $confirmed) {
				$this->auth->changepassword($data['username'], $_POST['password_new']);
				$data['task'] = 'passchanged';
			}	
		}

		$this->theme->view('front/auth', $data);		
	}			
} // class

?>