<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Organization, Contact Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Contact Type</label></td>
				<td><?php echo form_dropdown( 'id_ct', $contacttypes, $row['CTID']); ?>
			</td></tr>
			<tr>
				<td width="150" class="key"><label>Contact</label></td>
				<td><input type="text" class="inputbox"  name="contact" value="<?=$row['CONTACT'];?>"></td>
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

		if (trim(f.contact.value) == "")	{	
			alert( "You must provide a contact." );
		} else if (f.id_ct.value == "")	{	
			alert( "You must provide contact type." );			
		}	else	{ submitform( task ) ; return; }
	}	

    //]]>
	</SCRIPT>
	

