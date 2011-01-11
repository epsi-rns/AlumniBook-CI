<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_pos extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name', 3=>'Jabatan') 
			+ $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Job Position';
	} // constructor

	protected function doFilterSelect() { 
	  $this->selectCommunity(); 
	  $this->selectSource();
	?><br/>Pekerjaan
	  <select name="position" class="inputbox">
	  <?php	$this->selectDBList('JobPositionID', 'JobPosition', $this->input->post('position') ); ?>
	  </select>
	<?php }

	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Name</th>
	    <th align="center" nowrap>Community</th>
	    <th align="left" nowrap>Organisasi</th>
	    <th nowrap align="left">Jabatan</th>
	    <th nowrap align="left">Department</th>
	    <th nowrap align="left">Keterangan</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="18%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="12%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="18%" align="left"><?php echo $this->ref->org($row);?></td>
	    <td width="15%" align="left"><?php echo $row->JOBPOSITION;?></td>
	    <td width="15%" align="left"><?php echo $row->DEPARTMENT;?></td>
	    <td width="15%" align="left"><?php echo $row->DESCRIPTION;?></td>
	<?php }
} // class

?>