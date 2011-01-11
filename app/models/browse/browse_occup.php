<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_occup extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name', 3=>'Pekerjaan') 
			+ $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Occupation';
	} // constructor

	protected function doFilterSelect() { 
	  $this->selectCommunity(); 
	  $this->selectSource();
	?><br/>Pekerjaan
	  <select name="occupation" class="inputbox">
	  <?php echo $this->selectDBList('JobTypeID', 'JobType', $this->input->post('occupation') ); ?>
	  </select>
	<?php }

	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Name</th>
	    <th align="center" nowrap>Community</th>
	    <th align="left" nowrap>Organisasi</th>
	    <th nowrap>Pekerjaan</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="18%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="12%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="18%" align="left"><?php echo $this->ref->org($row);?></td>
	    <td width="15%" align="left"><?php echo $row->JOBTYPE;?></td>
	<?php }
} // class

?>