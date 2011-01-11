<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Alumna, Competency Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Competency</label></td>
				<td><div id="CompetenciesID"></div>					
			</td></tr>
			<tr>
				<td width="150" class="key"><label>Description</label></td>
				<td><input type="text" class="inputbox"  name="desc" value="<?=$row['DESCRIPTION'];?>"></td>
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

		if (trim(f.id_compy.value) == "")	{	
			alert( "You must provide a competency." );
		}	else	{ submitform( task ) ; return; }
	}	
	
	xajax_selectCompetencies	(<?=$row['COMPETENCYID'];?>);			//-- init		

    //]]>
	</SCRIPT>
	

