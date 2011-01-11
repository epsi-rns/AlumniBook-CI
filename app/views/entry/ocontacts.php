<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$this->load->view('panel/toolbar', $data);	
?>
<div><a href="org/edit/<?=$org->OID;?>.html"><?=$org->ORGANIZATION;?></a></div>

<form method="post" name="adminForm">
<table class="adminlist" cellpadding="1">
<thead>
	<tr>
		<th width="2%" class="title">#</th>
		<th width="5%" class="title">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($rows);?>);" />
		<th class="title">Type</th>	
	    <th class="title">Contact</th>
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
		<td><?=$row->CONTACTTYPE;?></td>
		<td><a href="<?=$segment;?>/edit/<?=$MasterID;?>/<?=$id;?>.html" title="edit"><?=$row->CONTACT;?></a>	</td>					
	</tr>
<?php endforeach; ?>	
</tbody>
</table>		

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

<?php	$this->load->view('entry/js_onsubmit');	?>