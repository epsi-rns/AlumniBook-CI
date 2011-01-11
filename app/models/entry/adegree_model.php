<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class adegree_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'ADegrees'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation

	public function getAll($MasterID) {
		// Override parent's method
		$this->db->select('AD.*, S.Strata');
		$this->db->where( 'AID', $MasterID );
		$this->db->from('ADegrees AD'
			.'  LEFT JOIN Strata S ON (S.STRATAID = AD.STRATAID)');
		return $this->db->get()->result();
	}	

	public function getDummy() {
		return  array(
			'STRATAID'		=> '10',
			'ADMITTED'		=> '',
			'GRADUATED'	=> '',
			'DEGREE'			=> '',
			'INSTITUTION'	=> 'University of Indonesia',
			'MAJOR'		=> '',
			'MINOR'		=> '',
			'CONCENTRATION'	=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getStrata() {		
		$rows = $this->db->get('Strata')->result();	
		return $this->getPairs($rows, 'STRATAID', 'STRATA');
	}	
	
	// validation

}	// class

?>