<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$orig_key = $row['PROPINSIID'];
	if (empty($orig_key)) $orig_key = 0;	

	$orig_val = $row['WILAYAHID'];
	if (empty($orig_val)) $orig_val = 0;	
	
	$this->load->view('panel/toolbar', $data);		
?>

<form method="post" name="adminForm" autocomplete="off">

<div>
	<fieldset class="adminform">
	<legend>Organization, Address Detail</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Kawasan</label></td>
				<td><input type="text" class="inputbox"
				name="kawasan" value="<?=$row['KAWASAN'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Gedung</label></td>
				<td><input type="text" class="inputbox"
				name="gedung" value="<?=$row['GEDUNG'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Jalan</label></td>
				<td><input type="text" class="inputbox"
				name="jalan" value="<?=$row['JALAN'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>PostalCode</label></td>
				<td><input type="text" class="inputbox"
				name="postalcode" value="<?=$row['POSTALCODE'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Negara</label></td>
				<td><div id="NegaraID"></div>
			</td></tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Propinsi</label></td>
				<td><div id="PropinsiID"></div>
			</td></tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Wilayah</label></td>
				<td><div id="WilayahID"></div>
			</td></tr>
		</table>
	</fieldset>
</div>

	<input type="hidden" name="task" 	value="" />
</form>

	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[

	function submitbutton(task) {
		submitform(task); 
	}
	
	function cdl() {
		m = document.adminForm.id_propinsi;
		key = m.options[m.selectedIndex].value;	

		xajax_selectWilayah(<?=$orig_val;?>, key);		
	}			
	
	//-- init 
	xajax_selectNegara	(<?=$row['NEGARAID'];?>);	
	xajax_selectPropinsi	(<?=$row['PROPINSIID'];?>);
	xajax_selectWilayah	(<?=$orig_val;?>, <?=$orig_key;?>);		


    //]]>
	</SCRIPT>
	

