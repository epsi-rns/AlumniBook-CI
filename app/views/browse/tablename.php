<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
	  <tr>
	    <td width="100%"><span class="sectionname">
		<img src="images/home.png" border="0"/>
		<a href="main/browse/<?=$task;?>.html">Browse <?=$tablename;?></a>&nbsp;
	    </span>
<?php foreach($sheets as $sheet => $title): ?>
		<br/><img src="images/get.png" border="0"/> Download Sheet
		<a href="main/sheet/<?=$sheet;?>.html"><?=$title;?></a>
<?php endforeach;?>				
		</td>
	  </tr>
	</table>