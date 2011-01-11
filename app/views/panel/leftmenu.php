<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$leftmenus = $this->main_model->getLinksMenu();
	foreach($leftmenus as $leftmenu)	:
?>
	<div class="module_menu"><div><div><div>
	    <h3><?=$leftmenu['title'];?></h3>			
	    <ul class="menu">
<?php foreach($leftmenu['item'] as $task => $text)	: ?>
			<li>
				<a href="browse/<?=$task;?>.html" {ID}>
				<span><?=$text;?></span>
			</a></li>
<?php endforeach; ?>
	    </ul>
	</div></div></div></div>
<?php endforeach; ?>