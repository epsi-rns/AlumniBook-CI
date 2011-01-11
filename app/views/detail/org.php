<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	$this->load->view('browse/header'); 	
	// title = "Lihat de... ".strtolower($this->ref->salute($alumna))
	$k = 0;		
?>
	    <table align="center" border="0">
	      <tr><td>
		<!-- Begin Document -->

		<h3><?=$one->ORGANIZATION;?></h3>
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tbody id="OrganizationID"></tbody>  
<?php	foreach ($mids as $mid)  { ?>
	    <tr class="<?php echo $this->item->css.($k+1); ?>"
		title="Lihat detail dari alumna ini">
	      <td vAlign="top"><?php echo $this->lang->line('item_alumna'); ?></td>
	      <td><div id="MID<?=$mid;?>"></div></td>
	    </tr>				
<?php $k = 1 - $k; } ?> 
		</table>
		
  	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
	xajax_showLeftMenu();	
	xajax_showOrg	(<?=$oid;?>);	
<?php	foreach ($mids as $mid): ?>
	xajax_showAlumnaInOrg	(<?=$mid;?>);
<?php endforeach; ?>
    //]]>
	</SCRIPT>

		<!-- End Document --> 
	      </td></tr>
	    </table>