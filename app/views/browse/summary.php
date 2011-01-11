<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	function getRowURL(&$rows, $link, $d) {
		$ys = round($d/10).'x';
		$dlink = $link.'/decade,'.$d.'.html';	

		$year	= '<a href="'.$dlink.'">'.$ys."</a>";
		$vals	= array($year);

		for ($i=0; $i<10; $i++) {
			$y=$i+$d;			
			if (isset($rows[$y])) {
				$ylink = $link.'/yearby,'.$y.'.html';  
				$t = $rows[$y];
				$vals[] = '<a href="'.$ylink.'">'.$t."</a>"; 
			} else $vals[] = '';
		} 

		return $vals;
	}	
?>	
			<div align="center">
			<h3>Summary for this Community</h3>
			<table border="0" cellspacing="2" cellpadding="3" class="submenucontainer">
				<tr class="sectiontableheader" align="right">
					<td>&nbsp;Tahun&nbsp;</td>		
					<?php for ($i=0; $i<10; $i++): ?>
					<td>&nbsp;0<?=$i;?>&nbsp;</td>
					<?php endfor; ?>
				</tr>
				<?php 
					for ($d=1960, $ste=true; $d<2010; $d+=10, $ste=!$ste): 
					$refs = getRowURL($rows, $link, $d); ?>
				<tr class="sectiontableentry<?=$ste?"2":"1";?>" align="right"> 				
					<td>&nbsp;<? echo ($first=array_shift($refs));?>&nbsp;</td>
					<?php foreach($refs as $ref): ?>
					<td nowrap><?=$ref;?></td>
					<?php endforeach; ?>
				</tr>
				<?php endfor; ?>				
			</table>
			</div>