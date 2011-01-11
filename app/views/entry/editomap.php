<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$orig_val = (empty($row['AID'])) ? 0: $row['AID'];
	$this->load->view('panel/toolbar', $data);		
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Organization, Map Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key" vAlign="top"><label>Occupation</label></td>
				<td><div id="JobTypeID"></div>
			</td></tr>	
			<tr>
				<td width="150" class="key"><label>Alumna</label></td>
				<td><div id="AlumnaID"></div>
				<input type="button" onclick="xajax_modalAlumni();" value="Select..." /></td>
			</tr>			
			<tr>
				<td width="150" class="key"><label>Department</label></td>
				<td><input type="text" class="inputbox"
				name="dept" value="<?=$row['DEPARTMENT'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Jabatan</label></td>
				<td><div id="JobPositionID"></div>
			</td></tr>		
			<tr>
				<td width="150" class="key"><label>Keterangan</label></td>
				<td><input type="text" class="inputbox"
				name="desc" value="<?=$row['DESCRIPTION'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Jabatan Struktural</label></td>
				<td><input type="text" class="inputbox"
				name="struktural" value="<?=$row['STRUKTURAL'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Jabatan Fungsional</label></td>
				<td><input type="text" class="inputbox"
				name="fungsional" value="<?=$row['FUNGSIONAL'];?>"></td>
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

		if (f.id_alumna.value == "0")	{	
			alert( "You must provide an alumna." );	
		}	else	{ submitform( task ) ; return; }
	}		
	
	function runQuery() {
		var f = document.modalForm;			
		search = trim(f.namesearchquery.value);
		if (search!="") {	xajax_tablePersons(f.namesearchquery.value); }
	}	
	
	function pick(aid) {
		xajax_pickAlumna(aid);
		xajax.closeWindow();
	}

	//-- init		
	xajax_selectJobPosition	(<?=$row['JOBPOSITIONID'];?>);	
	xajax_selectJobType			(<?=$row['JOBTYPEID'];?>);	
	xajax_pickAlumna				(<?=$orig_val;?>);
	
    //]]>
	</SCRIPT>
