<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar');	
?>
<br/>

<form method="post" name="adminForm" autocomplete="off">

<div class="col70">
	<fieldset class="adminform">
	<legend>Organization Basic Data</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key" vAlign="top"><label>Source</label></td>
				<td><div id="SourceID"></div>					
				</td>
			</tr>		
			<tr>
				<td width="150" class="key"><label>Organization/ Company</label></td>
				<td><input type="text" class="inputbox" name="org" value="<?=$row['ORGANIZATION'];?>"></td>
			</tr>			
			<tr>
				<td width="150" class="key"><label>Product</label></td>
				<td><input type="text" class="inputbox" name="product" value="<?=$row['PRODUCT'];?>"></td>
			</tr>
		</table>
	</fieldset>
</div>

<?php if (!empty($row['OID'])): ?>
<div class="col30">
	<fieldset class="adminform">
	<legend>Organization Details Link</legend>
		<table class="admintable" cellspacing="1">
<?php foreach($links as $key => $textval): ?>
			<tr><td width="150" class="key" align="center">&#x00bb;
				<a href="org/detail/<?=$key;?>/<?=$row['OID'];?>.html" title="edit <?=strtolower($textval);?>">
				<?=$textval;?></a>
			&#x00ab;</td></tr>
<?php endforeach; ?>
		</table>				
	</fieldset>
</div>
<?php endif; ?>

	<input type="hidden" name="task" 	value="" />
</form>

	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
	var f = document.adminForm;	
	
	function submitbutton(task) {
		if (task== 'cancel') {	submitform( task );	return;	}		

		if (trim(f.org.value) == "")	{	
			alert( "You must provide a name for organization/ company/ institution." );
		} else if (f.id_source.value == "")	{	
			alert( "You must provide source." );			
		}	else	{ submitform( task ) ; return; }
	}	
	
	xajax_selectSources	(<?=$row['SOURCEID'];?>);	//-- init 	

    //]]>
	</SCRIPT>