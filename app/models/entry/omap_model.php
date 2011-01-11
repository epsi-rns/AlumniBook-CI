<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class omap_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'AOMAP'; 
		$this->tableID = 'MID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		// Override parent's method		
		$this->db->where( 'OID', $MasterID );
		$this->db->select('AO.*, A.Name, JP.JobPosition, JT.JobType');
		$this->db->from('AOMap AO'
			.'  INNER JOIN Alumni A ON (A.AID=AO.AID)'
			.'  LEFT JOIN JobPosition JP ON (JP.JobPositionID=AO.JobPositionID)'
			.'  LEFT JOIN JobType JT ON (JT.JobTypeID=AO.JobTypeID)');
		return $this->db->get()->result();
	}	

	public function getDummy() {
		return  array(
			'JOBTYPE'				=> '', // Occupation
			'ORGANIZATION'	=> '',
			'DEPARTMENT'		=> '',
			'JOBPOSITION'		=> '',
			'DESCRIPTION'		=> '',
			'STRUKTURAL'		=> '',
			'FUNGSIONAL'		=> ''
		);				
	}		

	// -- class extension	--
	public function getMapAlumna($MapID) { // deprecated
		if (empty($MapID)) return null;
		
		$this->db->where( 'MID', $MapID );
		$this->db->select('FIRST 1 A.Name');
		$this->db->from('AOMap AO'
			.'  INNER JOIN Alumni A ON (A.AID=AO.AID)');
		$row = $this->db->get()->row();		
		return $row->NAME;
	}
	
	public function getAlumnaName($AID) {		
		$this->db->select('FIRST 1 Name')->from('Alumni')->where( 'AID', $AID );
		$row = $this->db->get()->row();		
		return $row->NAME;
	}	
	
	public function getPersonsName($like) {
		$this->db->where("(A.Name LIKE '%$like%')");
		$this->db->select('A.AID, A.Name, AC.Community');
		$this->db->from('Alumni A'
			.'  INNER JOIN ACommunities AC ON (AC.AID = A.AID)');		
		$this->db->orderby('A.Name');
		return $this->db->get()->result();
	}		
	
	// common methods	
	
	// list filter	
	public function getJobPosition() {		
		$rows = $this->db->get('JobPosition')->result();	
		return $this->getPairs($rows, 'JOBPOSITIONID', 'JOBPOSITION');
	}
	
	public function getJobType() {		
		$rows = $this->db->get('JobType')->result();	
		return $this->getPairs($rows, 'JOBTYPEID', 'JOBTYPE');	
	}
	// validation

}	// class

?>