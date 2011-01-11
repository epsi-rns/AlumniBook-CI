<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	$arrBulan = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 
		5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
		9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");
		
?>
    <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
      <tr>
		<td width="100%" colspan="2" valign="top" class="contentdescription">
		<div class="componentheading">Month of Birth</div>
		Pilih bulan kelahiran:</td>
      </tr>
      <tr>
		<td><ul>
<?php foreach ($arrBulan as $ID=>$text): ?>
				<li><a href="browse/birth/<?=$ID;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>
		</ul></td>
      </tr>
    </table>