<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/* Generic Model for Firebird */

abstract class Generic_Model extends Model {
	protected $tablename;
	protected $tableID;
	
	function __construct () { 	parent::__construct();	}	
	
	// class implementation	
	abstract public function getDummy();	
	
	public function getAll() {
		return $this->db->get($this->tablename)->result();
	}		
	
	public function get($id) {
		$this->db->select('FIRST 1 *');
		$this->db->where($this->tableID, $id); 
		return $this->db->get($this->tablename)->row_array();		
	}		
	
	public function update($id, $data) {
		// Fix NULL
		foreach($data as $key => $val) {			
			if (empty($val)) $this->db->set($key, 'NULL', FALSE);
			else $this->db->set($key, $val);
		}				
		
		$this->db->where($this->tableID, $id); 
		$this->db->update($this->tablename);	
	}	
	
	public function insert($data) {
		// Fix NULL	
		foreach($data as $key => $val)
			if (empty($val)) unset($data[$key]); 		
		
		$data[$this->tableID]	= $this->getNextID();
		$this->db->insert($this->tablename, $data);		
		
		return $data[$this->tableID];		
	}

	public function del($id) {
		$this->db->where($this->tableID, $id)->delete($this->tablename);		
	}	
	
	// common methods	
	protected function getNextID() {	
		return $this->db->get('next_id')->row()->NEW_ID;	 // select Gen_ID(Common_ID, 1) from rdb$database 	
	}	
	
	public function getLastUpdate() {
		$row = $this->db->select_max('Last_Update')->get($this->tablename)->row_array();
		return $row['LAST_UPDATE'];  		
	}		
	
	// validation		
	protected function usedByTable($othertablename, $id) {	
		$row = $this->db->select('FIRST 1 *')->where($this->tableID, $id)->get($othertablename)->row(); 
		return !empty($row);
	}	

	// list filter
	protected function getPairs($rows, $IDName, $fieldName) {
		$temp = array(''=>'- Select -');
		
		foreach ($rows as $row)
			$temp[$row->$IDName] = $row->$fieldName;
		
		return $temp;
	}
}	// class

?>