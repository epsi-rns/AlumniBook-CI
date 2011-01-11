<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class amap_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'AOMAP'; 
		$this->tableID = 'MID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		// Override parent's method		
		$this->db->where( 'AID', $MasterID );
		$this->db->select('AO.*, O.Organization, JP.JobPosition, JT.JobType');
		$this->db->from('AOMap AO'
			.'  INNER JOIN Organization O ON (O.OID=AO.OID)'
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
	public function getMapOrganization($MapID) { // deprecated
		if (empty($MapID)) return null;
		
		$this->db->where( 'MID', $MapID );
		$this->db->select('FIRST 1 O.Organization');
		$this->db->from('AOMap AO'
			.'  INNER JOIN Organization O ON (O.OID=AO.OID)');
		$row = $this->db->get()->row();		
		return $row->ORGANIZATION;
	}
	
	public function getOrgName($OID) {		
		$this->db->select('FIRST 1 Organization')->from('Organization')->where( 'OID', $OID );
		$row = $this->db->get()->row();		
		return $row->ORGANIZATION;
	}	
	
	public function getOrgsName($like) {
		$this->db->where("Organization LIKE '%$like%' ");
		$this->db->select('OID, Organization')->from('Organization')->orderby('Organization');
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