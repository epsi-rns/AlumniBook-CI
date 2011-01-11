<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class ooffice_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'Address'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		// Override parent's method		
		$this->db->where( 'LinkType', 'O' );
		$this->db->where( 'LID', $MasterID );
		$this->db->from('Address');
		$this->db->select('DID, Address, Region');
		return $this->db->get()->result();
	}	

	public function get($id) {
		$this->db->where( 'LinkType', 'O' );
		return parent::get($id);
	}		
	
	public function getDummy() {
		return  array(
			'KAWASAN'		=> '',
			'GEDUNG'		=> '',
			'JALAN'			=> '',
			'POSTALCODE'	=> '',
			'NEGARAID'	=> '99',
			'PROPINSIID'	=> '',
			'WILAYAHID'	=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getNegara() {		
		$rows = $this->db->get('Negara')->result();	
		return $this->getPairs($rows, 'NEGARAID', 'NEGARA');
	}
	
	public function getPropinsi() {		
		$rows = $this->db->get('Propinsi')->result();	
		return $this->getPairs($rows, 'PROPINSIID', 'PROPINSI');
	}	
	
	public function getLimitedWilayah($id_prov) {			
		$this->db->where('PropinsiID', $id_prov);
		$rows = $this->db->get('Wilayah')->result();	
		return $this->getPairs($rows, 'WILAYAHID', 'WILAYAH');
	}		
	
	public function getJSWilayah() { // deprecated
		$this->db->where('WilayahID >= 0');	//	Fix, -1			
		$this->db->orderby('PropinsiID');
		return $this->db->get('Wilayah')->result();		
	}			
	
	public function getCurrentWilayah($id_detail) {	// deprecated
		if (empty($id_detail)) $id_prov=0;
		else {
			$this->db->where('DID', $id_detail);			
			$row_addr	= $this->db->get('Address')->row();
			$id_prov		= $row_addr->PROPINSIID;			
		}		
		
		return $this->getLimitedWilayah($id_prov);
	}	
	
	// validation

}	// class

?>