<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

?>
    <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
      <tr>
		<td width="100%" colspan="2" valign="top" class="contentdescription">
			<div class="componentheading"><?=$headtext;?></div>
			<?=$bodytext;?>:</td>
      </tr>
      <tr>
		<td><ul>
<?php foreach ($rows as $row): ?>
				<li><a href="browse/<?=$task;?>/<?=$row[$ID];?>.html">
					<?=$row[$option];?></a>(<?=$row['TOTAL'];?>)</li>
<?php endforeach; ?>		
		</ul></td>
      </tr>
    </table>