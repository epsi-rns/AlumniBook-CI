<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_model.php");

class alumni_model extends Generic_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'Alumni'; 
		$this->tableID = 'AID'; 
	}	
	
	// class implementation
	
	public function getAll() {
		// Override parent's method			
	  $extendedAlumniJoin = ""
		."    LEFT JOIN ACommunities C ON (C.AID=A.AID) "
		."    LEFT JOIN Source S ON (A.SourceID=S.SourceID) ";
		
		// set filter		
		$this->setFilter();
		
		// let's get it done
		$this->db->orderby('Last_Update');
		$this->db->select('A.*, C.Community, S.Source ');
		$this->db->from("Alumni A ".$extendedAlumniJoin);
		return $this->db->get()->result();			
	}	
	
	public function getDummy() {
		return array(
			'SOURCEID'	=> null,
			'NAME'			=> '',
			'PREFIX'		=> '',
			'SUFFIX'		=> '',
			'GENDER'		=> '',
			'BIRTHPLACE'=> '',
			'BIRTHDATE'	=> null,
			'RELIGIONID'	=> null
		);				
	}		
	
	public function update($id, $data) {
		parent::update($id, $data);		
		$this->setDateSession();
	}
	
	public function insert($data) {
		// default value, not very useful, maintain compatiblity
		$data['CollectorID']	= 21;
		$data['UpdaterID']	= 21;		
		
		$newID = parent::insert($data);		
		$this->setDateSession();				
		return $newID;
	}
	
	// common methods	
	
	// validation
	private function setFilter() {	
		$this->db->where(	"(Last_Update >= '".	$this->session->userdata('stdta').	"')"	);
		$this->db->where(	"(Last_Update <= '".	$this->session->userdata('endta').	"')"	);
		
		$name = $this->session->userdata('name');
		if (!empty($name))			$this->db->like( "A.Name", $name );
		
		$where = array();
		
		$id_source = $this->session->userdata('id_source');
		if(!empty($id_source))	$where['S.SourceID'] = $id_source;
		
		$id_prog = $this->session->userdata('id_prog');
		if(!empty($id_prog))		$where['C.ProgramID'] = $id_prog;
		
		$id_dept = $this->session->userdata('id_dept');		
		if(!empty($id_dept))		$where['C.DepartmentID'] = $id_dept;
		
		$year = $this->session->userdata('year');
		if(!empty($year))			$where['C.Angkatan'] = $year;
		
		$this->db->where($where);	
	}
	
	// list filter
	public function getSources() {		
		$rows = $this->db->get('source')->result();	
		return $this->getPairs($rows, 'SOURCEID', 'SOURCE');	
	}		

	public function getDepts() {		
		$rows = $this->db->get('department')->result();	
		return $this->getPairs($rows, 'DEPARTMENTID', 'DEPARTMENT');	
	}		
	
	public function getProgs() {		
		$rows = $this->db->get('program')->result();	
		return $this->getPairs($rows, 'PROGRAMID', 'PROGRAM');	
	}		
	
	public function getRels() {		
		$rows = $this->db->get('religion')->result();	
		return $this->getPairs($rows, 'RELIGIONID', 'RELIGION');	
	}		

	// class extension	
	private function setDateSession() {
		$date1 = time();
		$date2 = strtotime('+1 days', $date1);
		$this->session->set_userdata( 'stdta',	strftime("%d.%m.%Y", $date1) );
		$this->session->set_userdata( 'endta',	strftime("%d.%m.%Y", $date2) );		
	}		

}	// class

?>