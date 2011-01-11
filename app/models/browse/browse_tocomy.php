<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_tocomy extends browse_iluni {
	private $colorIndex = 1; // initial value
	private $sum = 0;
	private $max = 0;

	function __construct () {
		parent::__construct(); // inherited constructor

		$this->groupSelect = array(1=>'Community', 2=>'Department', 3=>'Program', 4=>'Angkatan', 5=>'Detail Community');
		$this->tableName = 'Total for each communities';
	} // constructor

	protected function doFilterSelect() { $this->selectSource(); }

	protected function doTableHeader() {
		switch ($this->input->post('groupby')) {
			case 1: case 5: $text='Community'; break;
			case 2: $text='Department'; break;
			case 3: $text='Program'; break;
			case 4: $text='Angkatan'; break;
		} 	
?>
		<th align="left" nowrap><?=$text;?></th>
	    <th nowrap>Percent</th>
	    <th nowrap colspan="2">Total</th>
<?php
		// graph accesories
		foreach ($this->rows as $row) { 
			$this->sum += $row->TOTAL; 
			$this->max = ($this->max < $row->TOTAL) ? $row->TOTAL : $this->max; 
		}
	}
	
	function doRow(&$row) { 
		switch ($this->input->post('groupby')) {
			case 1: case 5: $url=$this->ref->comy($row); break;
			case 2: $url=$this->ref->dept($row); break;
			case 3: $url=$this->ref->prog($row); break;
			case 4: $url=$this->ref->year($row); break;
		} 	

		if ($this->colorIndex==5) {$this->colorIndex=1;} else {$this->colorIndex++;}
		$percent	=	round(100*$row->TOTAL*100/$this->sum)/100;
		$width		=	round($row->TOTAL*300/$this->max);
?>
		<td width="20%" align="left"><?=$url;?></td>	
	    <td width="10%" align="center">(<?=$percent;?>%)</td>
	    <td width="10%" align="left"><?=$row->TOTAL;?></td>
	    <td width="300" align="left"><img src="images/blank.png"
			class="bars_color_<?=$this->colorIndex;?>" 
			height="2" width="<?=$width;?>" alt="" /></td>	
<?php
	}	
} // class

?>