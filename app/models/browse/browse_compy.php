<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_compy extends browse_iluni {

	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name', 3=>'Kompetensi') 
			+ $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Kompetensi Alumni';
	} // constructor

	protected function doFilterSelect() { 
	  $this->selectCommunity();  
	  $this->selectSource();
	?><br/>Kompetensi
	  <select name="competency" class="inputbox">
	  <?php echo $this->selectDBList('CompetencyID', 'Competency', $this->input->post('competency') ); ?>
	  </select>
	<?php }

	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Nama Lengkap</th>
	    <th nowrap align="center">Community</th>
	    <th nowrap>Kompetensi</th>
	    <th nowrap>Keterangan</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="28%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="10%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="28%" align="left"><?php echo $row->COMPETENCY;?></td>
	    <td width="28%" align="left"><?php echo $row->DESCRIPTION;?></td>
	<?php }

	protected function getTitle(&$row) { return $row->NAME; }
} // class

?>