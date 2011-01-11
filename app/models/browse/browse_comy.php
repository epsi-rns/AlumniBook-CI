<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_comy extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Community', 3=>'Department (ID)', 4=>'Program (ID)');
		$this->tableName = 'Community';
	} // constructor

	protected function doFilterSelect() { $this->selectSource(); }

	function doTableHeader() { ?>
	    <th align="left" nowrap>Community</th>
	    <th nowrap>Department</th>
	    <th nowrap>Program</th>
	<?php }

	function doRow(&$row) { ?>
	    <td width="40%" align="left"><?php echo $this->ref->comy($row)." ($row->TOTAL)";?></td>
	    <td width="25%" align="left"><?php echo $this->ref->dept($row);?></td>
	    <td width="25%" align="left"><?php echo $this->ref->prog($row);?></td>
	<?php }
} // class	