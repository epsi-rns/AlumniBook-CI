<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_contact extends browse_iluni {
	private $addcomy;
	private $addAlumni=False;
	private $addOrg=False;
	
	function __construct () {
		parent::__construct(); // inherited constructor
	
		switch ($this->task) {
			case 'acon' : $arr = array(1=>'ID', 2=>'Nama'); break;
			case 'ocon' : $arr = array(41=>'ID', 42=>'Organisasi'); break; 
			case 'awcon': $arr = array(1=>'ID', 2=>'Nama', 42=>'Organisasi'); break; 
			case 'owcon': $arr = array(41=>'ID', 42=>'Organisasi', 2=>'Nama'); break; 
			default: $arr = array(); 
		}
		
		$this->addcomy = array('acon', 'awcon','owcon');
		
		if (in_array($this->task, $this->addcomy))
			{ $this->orderSelect = $arr + $this->comySelect + $this->sourceSelect; } 
		else { $this->orderSelect = $arr; }
		
		$this->addAlumni = in_array($this->task, array('acon', 'awcon','owcon') );
		$this->addOrg = in_array($this->task, array('ocon', 'awcon','owcon') );		

	  $this->tableName = 'Contact';
	} // constructor

	protected function doFilterSelect() { 
		if (in_array($this->task, $this->addcomy))
			{ $this->selectCommunity(); $this->selectSource(); }
	}

	protected function doTableHeader() { 
	  switch ($this->task) {
	    case 'acon':   { ?>
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<?php } break;
	    case 'ocon': { ?>
		<th align="left" nowrap>Organisasi</th>
		<?php } break;
	    case 'awcon':   { ?>
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<th align="left" nowrap>Organisasi</th>
		<?php } break;
	    case 'owcon':   { ?>
		<th align="left" nowrap>Organisasi</th>
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<?php } break;
	  } ?>
	    <th nowrap>Mobile Phone</th>
	    <th nowrap>Phone</th>
	    <th nowrap>Fax</th>
	    <th nowrap>e-mail</th>
	    <th nowrap>Website</th>
	<?php }

	protected function doRow(&$row) { 
	  switch ($this->task) {
	    case 'acon':   { ?>
		<td width="15%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="5%" align="center"><?php echo $row->COMMUNITY;?></td>
		<?php } break;
	    case 'ocon': { ?>
		<td width="20%" align="left"><?php echo $this->ref->org($row);?></td>
		<?php } break;
	    case 'awcon':   { ?>
		<td width="10%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="3%" align="center"><?php echo $row->COMMUNITY;?></td>
		<td width="10%" align="left"><?php echo $this->ref->org($row);?></td>
		<?php } break;
	    case 'owcon':   { ?>
		<td width="10%" align="left"><?php echo $this->ref->org($row);?></td>
		<td width="10%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="3%" align="center"><?php echo $row->COMMUNITY;?></td>
		<?php } break;
	  } ?>
	    <td width="15%" align="left"><?php echo $row->HP;?></td>
	    <td width="15%" align="left"><?php echo $row->PHONE;?></td>
	    <td width="15%" align="left"><?php echo $row->FAX;?></td>
	    <td width="15%" align="left"><?php echo $row->EMAIL;?></td>
	    <td width="15%" align="left"><?php echo $row->WEBSITE;?></td>
	<?php }
} // class
?>