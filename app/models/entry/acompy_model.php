<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class acompy_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'ACompetencies'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation

	public function getAll($MasterID) {
		// Override parent's method
		$this->db->select('ACo.*, AC.Competency');
		$this->db->where( 'AID', $MasterID );
		$this->db->from('ACompetencies ACo'
			.'  LEFT JOIN Competency AC ON (AC.CompetencyID=ACo.CompetencyID)');
		return $this->db->get()->result();
	}	

	public function getDummy() {
		return  array(
			'COMPETENCYID'	=> '',
			'DESCRIPTION'		=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getCompetencies() {		
		$rows = $this->db->get('Competency')->result();	
		return $this->getPairs($rows, 'COMPETENCYID', 'COMPETENCY');
	}	
	
	// validation

}	// class

?>