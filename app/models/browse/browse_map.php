<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_map extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(($this->task=='amap') ? 1:41=>"ID", 2=>'Nama', 42=>'Organisasi');
		$this->orderSelect = $this->orderSelect + $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Mapping';
	} // constructor

	protected function doFilterSelect() { 
	  $this->selectCommunity();  
	  $this->selectSource();
	}

	protected function doTableHeader() { 
	  switch ($this->task) {
	    case 'omap': { ?>
	    <th align="left" nowrap>Organisasi</th>
	    <th align="left" nowrap>Name</th>
	    <th align="center" nowrap>Community</th>
	  <?php } break;
	    case 'amap': { ?>
	    <th align="left" nowrap>Name</th>
	    <th align="center" nowrap>Community</th>
	    <th align="left" nowrap>Organisasi</th>
	  <?php } break;
	  }
	?>
	<?php }

	protected function doRow(&$row) { 
	  switch ($this->task) {
	    case 'omap': { ?>
	    <td width="18%" align="left"><?php echo $this->ref->org($row);?></td>
	    <td width="18%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="12%" align="center"><?php echo $row->COMMUNITY;?></td>
	  <?php } break;
	    case 'amap': { ?>
	    <td width="18%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="12%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="18%" align="left"><?php echo $this->ref->org($row);?></td>
	  <?php } break;
	  } ?>
	<?php }
} // class

?>