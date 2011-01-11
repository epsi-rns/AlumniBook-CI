<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	$birthdate	= empty($row['BIRTHDATE']) ? '' : strftime("%d.%m.%Y", strtotime($row['BIRTHDATE']));	

	$this->load->view('panel/toolbar');	
?>
<br/>

<form method="post" name="adminForm" autocomplete="off">

<div class="col70">
	<fieldset class="adminform">
	<legend>Alumna Basic Data</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key" vAlign="top"><label>Source</label></td>
				<td><div id="SourceID"></div>		
				</td>
			</tr>		
			<tr>
				<td width="150" class="key"><label>Name</label></td>
				<td><input type="text" class="inputbox" name="name" value="<?=$row['NAME'];?>"></td>
			</tr>			
			<tr>
				<td width="150" class="key"><label>Prefix</label></td>
				<td><input type="text" class="inputbox" name="prefix" value="<?=$row['PREFIX'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Suffix</label></td>
				<td><input type="text" class="inputbox" name="suffix" value="<?=$row['SUFFIX'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Gender</label></td>
				<td><?php echo form_dropdown( 'gender', $genders, $row['GENDER'] ); ?>	
				</td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Birth Place</label></td>
				<td><input type="text" class="inputbox" name="birthplace" value="<?=$row['BIRTHPLACE'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Birth Date</label></td>
				<td><input type="text" class="inputbox"  name="birthdate" id="my_date" readonly="1"
							value="<?=$birthdate;?>" />
						<button type="reset" id="my_trigger">...</button>		
						<input type="button" value="X" onclick="emptydate();">
				</td>
			</tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Religion</label></td>
				<td><div id="ReligionID"></div>	
				</td>
			</tr>			
		</table>
	</fieldset>
</div>

<?php if (!empty($row['AID'])): ?>
<div class="col30">
	<fieldset class="adminform">
	<legend>Alumna Details Link</legend>
		<table class="admintable" cellspacing="1">
<?php foreach($links as $key => $textval): ?>
			<tr><td width="150" class="key" align="center">&#x00bb;
				<a href="person/detail/<?=$key;?>/<?=$row['AID'];?>.html" title="edit <?=strtolower($textval);?>">
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
	
	function emptydate() {	f.birthdate.value='';	}
	
	function submitbutton(task) {
		if (task== 'cancel') {	submitform( task );	return;	}		

		if (trim(f.name.value) == "")	{	
			alert( "You must provide a name for alumna." );
		} else if (f.id_source.value == "")	{	
			alert( "You must provide source." );			
		}	else	{ submitform( task ) ; return; }
	}	

    Calendar.setup({
        inputField		: "my_date",		// id of the input field
        ifFormat		: "%d.%m.%Y",	// format of the input field
        showsTime	: false,				// will display a time selector
        button			: "my_trigger",	// trigger for the calendar (button ID)
        singleClick	: false,				// double-click mode
        step				: 1,					// show all years in drop-down boxes (instead of every other year as default)
        firstDay		: 0
    });	

	//-- init 	
	xajax_selectSources	(<?=$row['SOURCEID'];?>);
	xajax_selectRels	(<?=$row['RELIGIONID'];?>);	

    //]]>
	</SCRIPT>