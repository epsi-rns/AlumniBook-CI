<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("sheet_base.php");

class sheet_alumni extends sheet_base {
	private $fields = array();
	private $groupfield;

	function __construct () {
		parent::__construct(); // inherited constructor

		// Initialize Variables
		$this->titles = array('Community',	'Name',	'Angkatan',	'Program',	'Department',	'Last_Update');
		$this->buchName	= 'alumni.xls';
		$this->blattName	= 'Alumni';
		$this->sheetTitle		= 'Alumni and Community';
		$this->allowedGroupID = array(11, 12, 13, 14, 19);				
		
		foreach($this->titles as $i=>$title)
			$this->fields[$i]=strtoupper($title);		
	} // constructor
	
	protected function vorFormat() {
		// non preformatted setting
		$comySelect = array(0=>null, 11=>"Community", 12=>'Angkatan', 13=>'Department', 14=>'Program');
		$sourceSelect = array(""=>'----------', 19=>"Source");
		$orderSelect = array(1=>"ID", 2=>'Name') + $comySelect + $sourceSelect;	
	
		if (in_array($this->orderby, $this->allowedGroupID))
			$this->groupfield = strtoupper($orderSelect[$this->orderby]);
		else $this->groupfield=null;			
		
		// actual preformatted setting here
		$this->ws->setColumn(0, 0, 15);
		$this->ws->setColumn(1, 1, 30);
		$this->ws->setColumn(2, 2, 12);
		$this->ws->setColumn(5, 5, 17);
	}	
	
	protected function getGroupStr(&$row) {
		$field = $this->groupfield; 
		if (empty( $field )) return null;
		else return $row->$field;
	}	
/*	
	protected function getGroupStr(&$row) { 
		switch ($this->orderby) {
			case 2: $result = strtoupper(substr($row->NAME, 0, 1)); break; 
			case 42: $result = strtoupper(substr($row->ORGANIZATION, 0, 1)); break; 
			case 11: $result = $row->COMMUNITY; break; 
			case 12: $result = $row->ANGKATAN; break; 
			case 13: $result = $row->DEPARTMENT; break; 
			case 14: $result = $row->PROGRAM; break; 
			case 19: $result = $row->SOURCE; break; 
			case 22: $result = $row->PROPINSI; break; 
			case 23: $result = $row->WILAYAH; break; 
			default: $result ='';
		}

		return $result;
	}
*/	

	protected function doRow(&$row) {
		for ($i = 0; $i <= 5; $i++) {
			$field = $this->fields[$i]; 
			$this->ws->write($this->zeile, $i, $row->$field );
		}	
	}
} // class

?>