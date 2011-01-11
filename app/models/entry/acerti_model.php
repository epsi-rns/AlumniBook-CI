<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class acerti_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'ACertifications'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		$this->db->where( 'AID', $MasterID );
		return parent::getAll($MasterID);
	}	
	
	public function getDummy() {
		return  array(
			'CERTIFICATION'	=> '',
			'INSTITUTION'		=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// validation

}	// class

?>