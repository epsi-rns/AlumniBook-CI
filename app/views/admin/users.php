<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar');	
?>
<form method="post" name="adminForm">

<table class="adminlist" cellpadding="1">
<thead>
	<tr>
		<th width="2%" class="title">
			#		</th>
		<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($rows);?>);" />
		<th class="title">Username</th>
		<th class="title">Group</th>
		</th>
	</tr>
</thead>	
<tbody>
<?php  foreach($rows as $i=>$row):?>
	<tr class="row<?=($i%2);?>">
		<td><?=$row->ID;?></td>
		<td><input type="checkbox" id="cb<?=$i;?>" 
					name="cid[]" value="<?=$row->ID;?>" 
					onclick="isChecked(this.checked);" />	</td>
		<td><a href="<?=$segment;?>/edit/<?=$row->ID;?>.html" title="edit">
				<?=$row->username;?></a>	</td>
		<td><?=$row->gruppe;?></td>
	</tr>
<?php endforeach; ?>	
</tbody>
</table>		

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

	<SCRIPT LANGUAGE="JavaScript"><!-- 
	function submitbutton(task) {
		var f = document.adminForm;	
		
		if (f.boxchecked.value==0) {
			switch (task) {
				case 'edit'	: alert('Please select a User from the list to Edit'); break;
				case 'del'	: alert('Please select a User from the list to Delete'); break;
				default		: submitform( task );
			}
		}	else { submitform( task );	}
	}	
    --></SCRIPT>
