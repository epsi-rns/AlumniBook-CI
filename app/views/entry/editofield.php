<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Organization, Field Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Bidang Usaha</label></td>
				<td><div id="FieldsID"></div>
			</td></tr>
			<tr>
				<td width="150" class="key"><label>Keterangan</label></td>
				<td><input type="text" class="inputbox"
					name="desc" value="<?=$row['DESCRIPTION'];?>"></td>
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

		if (f.id_field.value == "")	{	
			alert( "You must provide a business field type." );
		}	else	{ submitform( task ) ; return; }
	}	

	xajax_selectFields	(<?=$row['FIELDID'];?>);			//-- init

    //]]>
	</SCRIPT>
	

