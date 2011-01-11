<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("detail_model.php");

class ocontact_model extends Detail_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'Contacts'; 
		$this->tableID = 'DID'; 
	}	
	
	// class implementation
	
	public function getAll($MasterID) {
		// Override parent's method
		$this->db->select('CT.ContactType, C.DID, C.Contact ');
		$this->db->where( 'LID', $MasterID );
		$this->db->where( 'LinkType', 'O' );
		$this->db->from('Contacts C'
			.'  LEFT JOIN ContactType CT ON (CT.CTID=C.CTID)');
		return $this->db->get()->result();
	}	
	
	public function get($id) {
		$this->db->where( 'LinkType', 'O' );
		return parent::get($id);
	}			
	
	public function getDummy() {
		return  array(
			'CTID'	=> '',
			'CONTACT'	=> ''
		);				
	}		
	
	// -- class extension	--
	
	// common methods	
	
	// list filter	
	public function getContactTypes() {		
		$rows = $this->db->get('ContactType')->result();	
		return $this->getPairs($rows, 'CTID', 'CONTACTTYPE');
	}			

	// validation

}	// class

?>