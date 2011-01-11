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
		<th width="5%" class="title">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($rows);?>);" />
		<th class="title">Strata</th>	
	    <th class="title">Admitted</th>
		<th class="title">Graduated</th>
		<th class="title">Degree</th>
		<th class="title">Institution</th>
		<th class="title">Major</th>
		<th class="title">Minor</th>
		<th class="title">Concentration</th>
		</th>
	</tr>
</thead>	
<tbody>
<?php  foreach($rows as $i=>$row)	:	$id	= $row->DID; ?>
	<tr class="row<?=($i%2);?>">
		<td><?=$i+1;?></td>
		<td><input type="checkbox" name="cid[]" 
					id="cb<?=$i;?>" value="<?=$id;?>" 
					onclick="isChecked(this.checked);" />	</td>		
		<td><?=$row->STRATA;?></td>
		<td><?=$row->ADMITTED;?></td>
		<td><?=$row->GRADUATED;?></td>
		<td><?=$row->DEGREE;?></td>
		<td><?=$row->INSTITUTION;?></td>
		<td><?=$row->MAJOR;?></td>
		<td><?=$row->MINOR;?></td>
		<td><?=$row->CONCENTRATION;?></td>
	</tr>
<?php endforeach; ?>	
</tbody>
</table>		

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

<?php	$this->load->view('entry/js_onsubmit');	?>