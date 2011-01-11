<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$data['morebuttons'] = array('refresh' => 'Refresh');
	$this->load->view('panel/toolbar', $data);	
?>
<form method="post" name="adminForm">
<fieldset class="adminform">
	<legend>Filter Organization List</legend>
<table class="admintable" cellspacing="1">
	<tr title="Click Refresh to update">
		<td width="150" class="key" vAlign="top"><label>Last Update</label></td>
		<td><?php $this->load->view('entry/selectdate'); ?>
		</td></tr>
	<tr>
		<td width="150" class="key"><label>Source</label></td>
		<td><?php echo form_dropdown( 'id_source', $sources, $this->session->userdata('id_source') ); ?>
	</td></tr>
	<tr>
		<td width="150" class="key"><label>Name Like</label></td>
		<td><input type="text" class="inputbox"  name="orgname" value="<?=$this->session->userdata('orgname');?>">
	</td></tr>
</table>
</fieldset>

<br/>

<table class="adminlist" cellpadding="1">
<thead>
	<tr>
		<th width="2%" class="title">#</th>
		<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($rows);?>);" />
	    <th align="left" nowrap>Organization</th>
	    <th class="title">Last Modified</th>		
		<th class="title">Source</th>	
		<th class="title">Product</th>			
		</th>
	</tr>
</thead>	
<tbody>
<?php  foreach($rows as $i=>$row)	:	$id=$row->OID; ?>
	<tr class="row<?=($i%2);?>">
		<td><?=$i+1;?></td>
		<td><input type="checkbox" name="cid[]" 
					id="cb<?=$i;?>" value="<?=$id;?>" 
					onclick="isChecked(this.checked);" />	</td>
		<td><a href="<?=$segment;?>/edit/<?=$id;?>.html" title="edit">
				<?=$row->ORGANIZATION;?></a>	</td>					
		<td><?=$row->LAST_UPDATE;?></td>		
		<td><?=$row->SOURCE;?></td>	
		<td><?=$row->PRODUCT;?></td>
	</tr>
<?php endforeach; ?>	
</tbody>
</table>		

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

<?php	$this->load->view('entry/js_onsubmit');	?>