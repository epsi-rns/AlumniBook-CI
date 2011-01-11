<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_model.php");

abstract class Detail_Model extends Generic_Model {
	function __construct () { 	parent::__construct();	}	
	
	// class implementation	
	public function getAll($MasterID) {	// alter parameter
		return parent::getAll();
	}			

	// common methods	

	public function getAlumna($MasterID) {	
		$this->db->select('FIRST 1 AID, Name');
		$this->db->where('AID', $MasterID);	
		return $this->db->get('Alumni')->row();		
	}
	
	public function getOrganization($MasterID) {	
		$this->db->select('FIRST 1 OID, Organization');
		$this->db->where('OID', $MasterID);		
		return $this->db->get('Organization')->row();		
	}	
}	// class

?>