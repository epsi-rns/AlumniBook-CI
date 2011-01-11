<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	switch ($task) {
		case 'manage':	
			$buttons = array(	'del' => 'Delete', 'edit' => 'Edit', 'add' => 'New'	);
			break;
		case 'edit':	
		case 'add':
			$buttons = array(	'save' => 'Save', 'apply' => 'Apply', 'cancel' => 'Cancel'	);
			break;
	}	
	
	if (!empty($morebuttons)) $buttons= $morebuttons + $buttons;  
?>

	<!-- import the adminlistform.js script -->
	<script type="text/javascript" src="./js/adminlistform.js"></script>
	<noscript>
		Warning! JavaScript must be enabled for proper operation.	
	</noscript>  

				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
			
<div class="toolbar">
<table class="toolbar"><tr>
<?php foreach($buttons as $submittask => $name)	:	?>
	<td class="button">
		<a onclick="javascript:submitbutton('<?=$submittask;?>');">
		<span class="icon-32-<?=strtolower($name);?>" title="<?=$name;?>"></span><?=$name;?></a>
	</td>	
<?php endforeach; ?>

</tr></table>
</div>

<div class="header <?=$icon48;?>">
<?php if($task=='manage')	: ?>
	List/Manager
<?php elseif($task=='edit')	: ?>
	User: <small><small>[ Edit ]</small></small>
<?php elseif($task=='add')	: ?>
	User: <small><small>[ New ]</small></small>	
<?php endif;	?>
</div>

				<div class="clr"></div>
			</div>
			<div class="b">

				<div class="b">
					<div class="b"></div>
				</div>
			</div>
			
  		</div>
   		<div class="clr"></div>
<br/>