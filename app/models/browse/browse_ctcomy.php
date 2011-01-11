<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_ctcomy extends browse_iluni {
	private $deptName;
	private $deptUName;

	function __construct () {
		parent::__construct(); // inherited constructor

		$this->tableName = 'Community in Cross Tabulation';
		$this->deptName = array(1=>'Sipil', 2=>'Mesin', 3=>'Elektro', 
			4=>'Metalurgi', 5=>'Arsitektur', 6=>'Kimia', 7=>'Industri', 8=>'Perkapalan');
		foreach ($this->deptName as $k=>$v) { $this->deptUName[$k] = strtoupper($v); }
	} // constructor

	protected function doTableHeader() { ?>
	    <th align="left">Angkatan</th>
	    <th align="left">Program</th>
<?php foreach ($this->deptName as $k=>$v): ?>
		<th nowrap><?=$v;?></th>
<?php endforeach; ?>
	    <th align="center">Total</th>	
	<?php }	

	private function getURL(&$row, $k) {
		return 'main/browse/alumni/deptby,'.$k.'/progby,'.$row->PROGRAMID.'/yearby,'.$row->ANGKATAN.'.html';
	}

	protected function ProgYearRef (&$row) {
	  if (isset($row->ANGKATAN)) 
	    { $text=$row->ANGKATAN; $ref=$row->ANGKATAN; } 
	  else { $text='undefined'; $ref=-1; }

	  $url = 'main/browse/alumni/progby,'.$row->PROGRAMID.'/yearby,'.$ref.'.html';	
	  return "\t\t".'<a href="'.$url.'">'.$text."</a>\n";
	}

	protected function doRow(&$row) {	?>
		<td width="10%" align="left"><?=$this->ProgYearRef($row);?></td>
		<td width="10%" align="left"><?=$row->PROGRAM;?></td>
<?php foreach ($this->deptUName as $k=>$v) 	: 
			if	($row->$v != 0) {
				if (empty($row->ANGKATAN)) { $ref=$row->$v; } 
				else { $ref= '<a href="'.$this->getURL($row, $k).'">'.$row->$v."</a>"; }			
			}	else { $ref="0"; }
?>		
		<td width="10%" align="center"><?=$ref;?></td>
<?php endforeach; ?>
		<td width="5%" align="center"><b><?=$row->TOTAL;?></b></td>
	<?php }	

} // class

?>