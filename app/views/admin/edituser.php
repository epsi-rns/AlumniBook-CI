<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$groups = array('', 'guest', 'user', 'entry', 'admin');

	$this->load->view('panel/toolbar');	
?>
<br/>

<form method="post" name="adminForm" autocomplete="off">

<div class="col70">
	<fieldset class="adminform">
	<legend>User Details</legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label for="username">Username</label></td>
				<td><input type="text" class="inputbox"  name="username" value="<?=$row['username'];?>"></td>
			</tr>
			<tr>
				<td width="150" class="key" vAlign="top"><label>Group</label></td>
				<td vAlign="top">
				<select name="group" size="2"> 
<?php foreach($groups as $group): $selected =  ($group==$row['gruppe']) ? " selected" : ""; ?>
					<option value="<?=$group;?>"<?=$selected;?>><?=$group;?></option>
<?php endforeach; ?>
				</select>
				</td>
			</tr>
			<tr>
				<td width="150" class="key"><label>New Password:</label></td>
				<td><input type="password" class="inputbox"  name="password_new"></td>
			</tr>
			<tr>
				<td width="150" class="key"><label>Verify Password:</label></td>
				<td><input type="password" class="inputbox"  name="password_confirm"></td>
			</tr>
			
		</table>
	</fieldset>
</div>

	<input type="hidden" name="task" value="" />
</form>

	<SCRIPT LANGUAGE="JavaScript"><!-- 
	function submitbutton(task) {
		var f = document.adminForm;	

		if (task== 'cancel') {	submitform( task );	return;	}		
		
		if (trim(f.username.value) == "")	{	
			alert( "You must provide a name." );
		} else if (f.password_new.value != f.password_confirm.value)	{	
			alert("Passwords do not match."); 
		}	else	{ submitform( task ) ; return; }
	}
    --></SCRIPT>