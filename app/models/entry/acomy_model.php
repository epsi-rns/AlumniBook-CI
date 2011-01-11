<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class acomy_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'ACommunities'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		$this->db->select('DID, Community')->where( 'AID', $MasterID );
		return parent::getAll($MasterID);
	}	
	
	public function getDummy() {
		return  array(
			'CID'	=> '',
			'ANGKATAN'	=> '',
			'KHUSUS'		=> ''
		);				
	}		

	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getCommunities() {		
		$rows = $this->db->get('Community')->result();	
		return $this->getPairs($rows, 'CID', 'COMMUNITY');
	}			

	// validation

}	// class

?>