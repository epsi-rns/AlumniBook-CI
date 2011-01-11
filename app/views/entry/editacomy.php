<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Alumna, Community Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Community</label></td>
				<td><div id="CommunitiesID"></div>				
			</td></tr>
			<tr>
				<td width="150" class="key"><label>Tahun Angkatan</label></td>
				<td><input type="text" class="inputbox"  name="year" value="<?=$row['ANGKATAN'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Angkatan Khusus</label></td>
				<td><input type="text" class="inputbox"  name="special" value="<?=$row['KHUSUS'];?>"></td>
			</tr>
		</table>
	</fieldset>
</div>

	<input type="hidden" name="task" 	value="" />
</form>

	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
	var f = document.adminForm;	
	MaskInput(f.year, "9999");
		
	function submitbutton(task) {
		submitform(task); 
	}
	
	xajax_selectCommunities	(<?=$row['CID'];?>);			//-- init	

    //]]>
	</SCRIPT>
	

