<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_certi extends browse_iluni {

	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name', 3=>'Sertifikasi', 4=>'Institusi') 
			+ $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Sertifikasi Alumni';
	} // constructor

	protected function doFilterSelect() { $this->selectCommunity(); $this->selectSource(); }

	function doTableHeader() { ?>
	    <th align="left" nowrap>Nama Lengkap</th>
	    <th nowrap align="center">Community</th>
	    <th nowrap>Sertifikasi</th>
	    <th nowrap>Institusi</th>
	<?php }

	function doRow(&$row) { ?>
	    <td width="28%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="15%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="28%" align="left"><?php echo $row->CERTIFICATION;?></td>
	    <td width="28%" align="left"><?php echo $row->INSTITUTION;?></td>
	<?php }

	protected function getTitle(&$row) { return $row->NAME; }
} // class

?>