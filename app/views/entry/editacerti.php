<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Alumna, Certification Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Certification</label></td>
				<td><input type="text" class="inputbox"  name="certification" value="<?=$row['CERTIFICATION'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Institution</label></td>
				<td><input type="text" class="inputbox"  name="institution" value="<?=$row['INSTITUTION'];?>"></td>
			</tr>
		</table>
	</fieldset>
</div>

	<input type="hidden" name="task" 	value="" />
</form>

	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
	var f = document.adminForm;	
		
	function submitbutton(task) {
		if (task== 'cancel') {	submitform( task );	return;	}		

		if (trim(f.certification.value) == "")	{	
			alert( "You must provide a certification name." );
		}	else	{ submitform( task ) ; return; }
	}	

    //]]>
	</SCRIPT>
	

