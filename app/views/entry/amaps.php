<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>
<div><a href="person/edit/<?=$alumna->AID;?>.html"><?=$alumna->NAME;?></a></div>

<form method="post" name="adminForm">
<table class="adminlist" cellpadding="1">
<thead>
	<tr>
		<th width="2%" class="title">#</th>
		<th width="5%" class="title" colspan="2">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($rows);?>);" />
		<th class="title">Occupation</th>			
	    <th class="title">Organization</th>
	    <th class="title">Department</th>
		<th class="title">Job Position</th>
		<th class="title">Keterangan</th>
		<th class="title">Struktural</th>
		<th class="title">Fungsional</th>

		</th>
	</tr>
</thead>	
<tbody>
<?php  foreach($rows as $i=>$row)	:	$id	= $row->MID; ?>
	<tr class="row<?=($i%2);?>">
		<td><?=$i+1;?></td>
		<td><input type="checkbox" name="cid[]" 
					id="cb<?=$i;?>" value="<?=$id;?>" 
					onclick="isChecked(this.checked);" />	</td>
		<td><a href="<?=$segment;?>/edit/<?=$MasterID;?>/<?=$id;?>.html" title="edit">Edit</a>	</td>	
		<td><?=$row->JOBTYPE;?></td>		
	    <td><?=$row->ORGANIZATION;?></td>
	    <td><?=$row->DEPARTMENT;?></td>
		<td><?=$row->JOBPOSITION;?></td>
		<td><?=$row->DESCRIPTION;?></td>
		<td><?=$row->STRUKTURAL;?></td>
		<td><?=$row->FUNGSIONAL;?></td>
	</tr>
<?php endforeach; ?>	
</tbody>
</table>		

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

<?php	$this->load->view('entry/js_onsubmit');	?>