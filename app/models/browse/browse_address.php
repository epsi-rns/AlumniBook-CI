<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_address extends browse_iluni {
	private $addcomy;
	private $addAlumni=False;
	private $addOrg=False;
	
	function __construct () {
		parent::__construct(); // inherited constructor
	
		switch ($this->task) {
			case 'home'  	: $arr1 = array(1=>'ID', 2=>'Nama'); break;
			case 'office'		: $arr1 = array(41=>'ID', 42=>'Organisasi'); break; 
			case 'awaddr'	: $arr1 = array(1=>'ID', 2=>'Nama', 42=>'Organisasi'); break; 
			case 'owaddr'	: $arr1 = array(41=>'ID', 42=>'Organisasi', 2=>'Nama'); break; 
	    default: $arr1 = array(); 
		}
		$arr2 = array(5=>'Alamat', 6=>'Daerah'); 
		$arr3 = array(21=>'Kode Negara', 22=>'Kode Propinsi', 23=>'Kode Wilayah',
			24=>'Kode Pos', 25=>'Jalan', 26=>'Kawasan', 27=>'Gedung'); 

		$this->addcomy = array('home', 'awaddr','owaddr');
		
		if (in_array($this->task, $this->addcomy))
			{ $this->orderSelect = $arr1 + $arr2 + $arr3 + $this->comySelect + $this->sourceSelect; }
		else	{ $this->orderSelect = $arr1 + $arr2 + $arr3; }
		
		$this->addAlumni = in_array($this->task, array('home', 'awaddr','owaddr') );
		$this->addOrg = in_array($this->task, array('office', 'awaddr','owaddr') );

	    $this->tableName = 'Address';
	} // constructor

	protected function doFilterSelect() { 
		if (in_array($this->task, $this->addcomy))
			{ $this->selectCommunity(); $this->selectSource(); }
	}

	protected function doTableHeader() { 
	  switch ($this->task) {
	    case 'home': { ?>  
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<?php } break;
	    case 'office': { ?><th align="left" nowrap>Organisasi</th><?php } break;
	    case 'awaddr':   { ?>
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<th align="left" nowrap>Organisasi</th>
		<?php } break;
	    case 'owaddr':   { ?>
		<th align="left" nowrap>Organisasi</th>
		<th align="left" nowrap>Name</th>
		<th align="center" nowrap>Community</th>
		<?php } break;
	  } ?>
	    <th nowrap>Address</th>
	    <th nowrap>Region</th>
	<?php }

	protected function doRow(&$row) { 
	  switch ($this->task) {
	    case 'home':   { ?>
		<td width="25%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="10%" align="center"><?php echo $row->COMMUNITY;?></td>
		<?php } break;
	    case 'office': { ?>
		<td width="30%" align="left"><?php echo $this->ref->org($row);?></td>
		<?php } break;
	    case 'awaddr':   { ?>
		<td width="15%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="10%" align="center"><?php echo $row->COMMUNITY;?></td>
		<td width="15%" align="left"><?php echo $this->ref->org($row);?></td>
		<?php } break;
	    case 'owaddr':   { ?>
		<td width="15%" align="left"><?php echo $this->ref->org($row);?></td>
		<td width="15%" align="left"><?php echo $this->ref->alumna($row);?></td>
		<td width="10%" align="center"><?php echo $row->COMMUNITY;?></td>
		<?php } break;
	  } ?>
	    <td width="28%" align="left"><?php echo $row->ADDRESS;?></td>
	    <td width="28%" align="left"><?php echo $row->REGION;?></td>
	<?php }
} // class
?>