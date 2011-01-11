<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class users_model extends Model {
	private $dbauth;
	
	function __construct () { 	
		parent::__construct();	
		$this->dbauth	= $this->load->database('auth', TRUE);	// sqlite driver
	}	
	
	// class implementation	
	
	public function getAll() {
		return $this->dbauth->get('auth')->result();
	}	
	
	public function getDummy() {
		return array(   'username'	=> 	'',	'gruppe'	=> 	''	);	
	}			

	public function getID($username) {
		$this->dbauth->select('ID')->where('username', $username);
		$row = $this->dbauth->get('auth')->row();
		return $row->ID;
	}		
	
	public function update($id, $data) {
		$this->dbauth->where(array('ID' => $id));
		$this->dbauth->update('auth', $data);
	}		
	
	public function insert($data) {
		$this->dbauth->insert('auth', $data);
	}
	
	public function del($id) {
		$this->dbauth->where('ID', $id);		
		$this->dbauth->delete('auth');
	}			
	
	// class extension	
	public function get($id) {
		$this->dbauth->where('ID', $id);				
		return $this->dbauth->get('auth')->row_array();
	}	

}	// class

?>