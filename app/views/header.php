<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

 $islogin = (bool)$this->session->userdata('username'); 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<?php $this->load->view('panel/htmlhead'); ?>
<?php if (! empty($xajax_js)) echo $xajax_js;?>
</head>

<body>
<?php $this->load->view('panel/precontent'); ?>

<table id="verlauf" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
  <tr>
    <td class="sidespacer"><div id="sidespacer"></div></td>
    <td>
      <div id="header">
        <div id="top-top">
<?php $this->load->view('panel/topmenu'); ?>
        </div>      
        <div id="top-bottom">
          <a href="index.php"> 
          <img  alt="logo" 
		lowsrc="./theme/img/logoiluni-h80.gif" border="0" height="80" 
		src="./theme/img/makara-anim.gif" border="0" height="80" 
	  /> 
          </a>
        </div>
        <div id="banner"><div id="sitename">
<?php if(!empty($bannertype)) : ?>
          I L U N I - F T U I <div id="slogan">Ikatan Alumni Fakultas Teknik Universitas Indonesia</div> 
<?php else : ?>
		  <img src="./theme/img/banner-train.jpg" />	
<?php endif; ?>
        </div></div>
        <div class="clr"></div>
      </div>
      <table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
        <tr>
			<td id="leftdoc" style="width:20px; left:-20px;"><span id="leftmenu" style="display:block;">
			</span></td>
          <td id="maindoc"> 
<?php $this->load->view('panel/themeselect'); ?>
				<div id="pathway"></div>		
             <div class="clr"></div>
             <div class="content"><a name="content"></a>

<!-- Beginning of Content -->