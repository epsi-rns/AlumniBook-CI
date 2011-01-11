<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Alumna, Degree Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Strata</label></td>
				<td><?php echo form_dropdown( 'id_strata', $strata, $row['STRATAID']); ?>
			</td></tr>
			<tr>
				<td width="150" class="key"><label>Tahun Diterima</label></td>
				<td><input type="text" class="inputbox"  
				name="yearin" value="<?=$row['ADMITTED'];?>"></td>
			</tr>			
			<tr>
				<td width="150" class="key"><label>Tahun Lulus</label></td>
				<td><input type="text" class="inputbox"  
				name="yearout" value="<?=$row['GRADUATED'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Gelar</label></td>
				<td><input type="text" class="inputbox"  
				name="degree" value="<?=$row['DEGREE'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Intitusi/ University</label></td>
				<td><input type="text" class="inputbox"  
				name="institution" value="<?=$row['INSTITUTION'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Major/ Fakultas</label></td>
				<td><input type="text" class="inputbox"  
				name="major" value="<?=$row['MAJOR'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Minor/ Jurusan</label></td>
				<td><input type="text" class="inputbox"  
				name="minor" value="<?=$row['MINOR'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Konsentrasi/ Program Studi</label></td>
				<td><input type="text" class="inputbox"  
				name="concentration" value="<?=$row['CONCENTRATION'];?>"></td>
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

		if (trim(f.institution.value) == "")	{	
			alert( "You must provide an institution." );
		} else if (f.id_strata.value == "")	{	
			alert( "You must provide strata type." );
		}	else	{ submitform( task ) ; return; }
	}	

    //]]>
	</SCRIPT>
	

