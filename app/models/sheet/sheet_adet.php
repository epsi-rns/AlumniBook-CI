<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("sheet_base.php");

class sheet_adet extends sheet_base {
	private $fields = array();
	private $groupfield;
	public $ds;
	private $ID;

	function __construct () {
		parent::__construct(); // inherited constructor

		// Initialize Variables
		$this->titles = array('Community',	'Name',	'Angkatan',	'Program',	'Department',	'Last_Update');		// Dummy
		$this->buchName	= 'alumni-details.xls';
		$this->blattName	= 'Details';
		$this->sheetTitle		= 'Alumni Details';
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
		$this->ws->setColumn(0, 0, 3);		
		$this->ws->setColumn(2, 2, 15);			
		$this->ws->setColumn(3, 3, 40);		
		$this->ws->setColumn(4, 4, 20);			
	}	
	
	protected function BandHeader() {	
		// Override parent's method, suppress header
	}		
	
	protected function getGroupStr(&$row) {
		$field = $this->groupfield; 
		if (empty( $field )) return null;
		else return $row->$field;
	}	

	protected function doRow(&$row) {
		$this->ID = $row->AID;
		$one =& $this->ds->getAlumna ($this->ID);
		
		$name = $this->alumna($one);
		$this->ws->writeNumber	($this->zeile, 0, $this->rownum+1 );	
		$this->ws->writeString	($this->zeile, 1, $name, $this->xlFormat['title3'] );				
		$this->ws->writeBlank		($this->zeile, 2, $this->xlFormat['title3'] );				
		$this->ws->mergeCells	($this->zeile, 1, $this->zeile, 4);		
		$this->zeile++;		
		
		$this->writeAlumniDetail();
		$this->zeile++;		
	}
	
	private function writeAlumniDetail() {
		$communities		= $this->ds->loadComy ($this->ID);	
		$competencies	= $this->ds->loadCompy ($this->ID);
		$certifications		= $this->ds->loadCerti ($this->ID);
		$experiences		= $this->ds->loadExperiences ($this->ID);	 	
		$organizations 	= $this->ds->loadMap('O', $this->ID);			
		
		if (!empty($communities)) {
			foreach ($communities as $community) {		
				$this->ws->writeString($this->zeile, 2, 'Community' );	
				$this->ws->writeString($this->zeile, 3, $this->comy($community) );
				$this->zeile++;			
			}
		}	
		
		if (!empty($competencies)) {
			foreach ($competencies as $compy) {		
				$this->ws->writeString($this->zeile, 2, 'Competency' );	
				$this->ws->writeString($this->zeile, 3, $compy->COMPETENCY );
				if(!empty( $compy->DESCRIPTION ))
					$this->ws->writeString($this->zeile, 4, $compy->DESCRIPTION );
				$this->zeile++;			
			}
		}	
		
		if (!empty($certifications)) {
			foreach ($certifications as $certi) {		
				$this->ws->writeString($this->zeile, 2, 'Certification' );	
				$this->ws->writeString($this->zeile, 3, $certi->CERTIFICATION );
				if(!empty( $certi->INSTITUTION ))
					$this->ws->writeString($this->zeile, 4, $certi->INSTITUTION );				
				$this->zeile++;			
			}
		}		
		
		if (!empty($experiences)) {
			foreach ($experiences as $expi) {		
				$this->ws->writeString($this->zeile, 2, 'Experiences' );	
				$this->ws->writeString($this->zeile, 3, $expi->ORGANIZATION );
				$this->zeile++;			
			}
		}			
		
		if (!empty($organizations)) {
			$this->zeile++;
			foreach ($organizations as $org) {		
				$name = $org->ORGANIZATION;			
				$this->ws->writeString	($this->zeile, 2, 'Organization', $this->xlFormat['title2'] );				
				$this->ws->writeString	($this->zeile, 3, $name, $this->xlFormat['title2'] );		
				$this->ws->mergeCells	($this->zeile, 3, $this->zeile, 4);					
				$this->zeile++;			
			}
			
			$this->writeOrgDetail($org);	
		}							
	}
	
	private function writeOrgDetail($organization) {
	    $offices	= $this->ds->loadAddress('O', $organization->OID);

		if (!empty($organization->JOBTYPE)) {
			$this->ws->writeString($this->zeile, 2, 'Occupation' );	
			$this->ws->writeString($this->zeile, 3, $organization->JOBTYPE );			
			$this->zeile++;			
		}
		
		if (!empty($organization->JOBPOSITION)) {
			$this->ws->writeString($this->zeile, 2, 'Position' );	
			$this->ws->writeString($this->zeile, 3, $organization->JOBPOSITION );			
			$this->ws->writeString($this->zeile, 4, $this->jobposdesc($organization) );
			$this->zeile++;			
		}
		
		if (!empty($offices)) {
			foreach ($offices as $addr) {		
				$this->ws->writeString($this->zeile, 2, 'Office' );	
				$this->ws->writeString($this->zeile, 3, $addr->ADDRESS );
				$this->zeile++;			
				$this->ws->writeString($this->zeile, 3, $addr->REGION );
				$this->zeile++;			
			}
		}			
	}

	/* Text Helper */

	private function alumna (&$row) {
		$name = $row->NAME;
		if (isset($row->SHOWTITLE)) { if ($row->SHOWTITLE=='T') {
		  if (isset($row->PREFIX)) {$name = $row->PREFIX." $name";}
		  if (isset($row->SUFFIX)) {$name .= ', '.$row->SUFFIX;}
		}}

		return $name;
	}	
	
	private function comy (&$row) {
		$text = $row->COMMUNITY;
		if (isset($row->ANGKATAN))	{ $text .=  " - ".$row->ANGKATAN; }
		if (isset($row->KHUSUS))	{ $text .=  " ($row->KHUSUS)"; }

		return $text;
	}	
	
	private function jobposdesc (&$row) {
		if (!empty($row->FUNGSIONAL)) $items[] = $row->FUNGSIONAL;
		if (!empty($row->STRUKTURAL)) $items[] = $row->STRUKTURAL;
		if (!empty($row->DESCRIPTION)) $items[] = $row->DESCRIPTION; 
		$desc = empty($items) ? "" : implode(', ', $items); 

	  return $desc;
	}	
	
} // class

?>