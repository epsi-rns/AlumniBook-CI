<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
	  <form action="main/browse/<?=$task;?>.html" method="post" name="alumniForm">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
<?php if($isorder): ?>		
			<tr class="sectiontableheader" title="<?=$textorder;?>">
			<td vAlign="top" nowrap width="70"><i><legend><?=$this->lang->line('cmn_ordering');?></legend></i></td>
			<td><select name="orderby" class="inputbox">
			<?=$orderby;?>
			</select></td>
			</tr>
<?php endif; ?>			
	
<?php if($isgroup): ?>		
			<tr class="sectiontableheader" title="<?=$textgroup;?>">
			<td vAlign="top" nowrap width="70"><i><legend>Group by :</legend></i></td>
			<td><select name="groupby" class="inputbox">
			<?=$groupby;?>
			</select></td>
	    </tr>
<?php endif; ?>	

<?php if($isfilter): ?>	
			<tr class="sectiontableheader" title="<?=$textfilter;?>">
			<td vAlign="top" nowrap width="70"><i><legend><?=$this->lang->line('cmn_filter');?></legend></i></td>
			<td>
			<?=$filter;?>
			</td>
			</tr>
<?php endif; ?>

<?php if($isform): ?>	
			<tr class="sectiontableheader">
			<td vAlign="top" colspan="2" align="right">
				<input name="Submit" type="submit" value="<?=$this->lang->line('cmn_apply');?>">
			</td>
			</tr>
<?php endif; ?>	 
	
	  </table>
	  </form>