<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class init_model extends Model {
	
	function __construct () { 
		parent::__construct();	
		
		$this->output->enable_profiler(TRUE);			
		
		$this->initLang();
		$this->lang->load('alumni', $this->config->item('language') );

		$this->load->library('theme');
		$this->load->library('xajax');		
		
		$this->load->model('auth_model', 'auth');		
		$this->load->model('main_model');	
	}	
	
	private function initLang() {
		$lang = $this->input->post('lang');
		if (!$lang) $lang = $this->session->userdata('lang');
	
		switch ($lang) { 
			case 'id':	$language	= "indonesia"; break;
			default:	$language	= "english"; $lang='en';
		}
		$this->config->set_item('language', $language);
		$this->session->set_userdata('lang', $lang);
	}	

}	// class

?>