<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Alumna, Experience Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Intitusi/ Organization</label></td>
				<td><input type="text" class="inputbox"  
				name="org" value="<?=$row['ORGANIZATION'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Tahun Masuk</label></td>
				<td><input type="text" class="inputbox"  
				name="yearin" value="<?=$row['YEARIN'];?>"></td>
			</tr>			
			<tr>
				<td width="150" class="key"><label>Tahun Keluar</label></td>
				<td><input type="text" class="inputbox"  
				name="yearout" value="<?=$row['YEAROUT'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Jabatan</label></td>
				<td><input type="text" class="inputbox"  
				name="jobpos" value="<?=$row['JOBPOSITION'];?>"></td>
			</tr>
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
	MaskInput(f.yearin,		"9999");
	MaskInput(f.yearout,	"9999");	
		
	function submitbutton(task) {
		if (task== 'cancel') {	submitform( task );	return;	}		

		if (trim(f.org.value) == "")	{	
			alert( "You must provide an institution/ organization." );
		}	else	{ submitform( task ) ; return; }
	}	

    //]]>
	</SCRIPT>
	

