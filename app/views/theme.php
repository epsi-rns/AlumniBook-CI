<?php  
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	/* 
	Yay = Yet Another Yats
	Inspired by The YATS :p
	*/
	
	$theme = $this->theme->dataTheme;
	$theme['data'] =& $data;

//	$config =& get_config();
//	$themedir =...
	
	$this->load->view('header', $theme );		
	$this->load->view($this->theme->view, $data );
	$this->load->view('panel/langswitch', $theme);	
	$this->load->view('footer');
?>