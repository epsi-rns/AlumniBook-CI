<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class ofield_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'OFields'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		// Override parent's method
		$this->db->select('OFi.*, F.Field');
		$this->db->where( 'OID', $MasterID );
		$this->db->from('OFields OFi'
			.'  LEFT JOIN Field F ON (OFi.FieldID=F.FieldID)');
		return $this->db->get()->result();
	}	
	
	public function getDummy() {
		return  array(
			'FIELDID'	=> '',
			'DESCRIPTION'	=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getFields() {		
		$rows = $this->db->get('Field')->result();	
		return $this->getPairs($rows, 'FIELDID', 'FIELD');
	}			

	// validation

}	// class

?>