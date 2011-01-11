<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_model.php");

class org_model extends Generic_Model {
	
	function __construct () { 	
		parent::__construct();	
		$this->tablename = 'Organization'; 
		$this->tableID = 'OID'; 
	}	
	
	// class implementation
	
	public function getAll() {
		// Override parent's method	
		
		// set filter		
		$this->setFilter();
		
		// let's get it done
		$this->db->orderby('Last_Update');
		$this->db->from("Organization O "
			."    LEFT JOIN Source S ON (O.SourceID=S.SourceID) ");
		return $this->db->get()->result();			
	}	
	
	public function getDummy() {
		return array(
			'SOURCEID'	=> null,
			'ORGANIZATION'	=> '',
//			'PARENTID'			=> '',
//			'HASBRANCH'		=> 'F',
			'PRODUCT'			=> ''
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
		$this->db->where(	"(Last_Update >= '".	$this->session->userdata('stdto').	"')"	);
		$this->db->where(	"(Last_Update <= '".	$this->session->userdata('endto').	"')"	);
		
		$orgname = $this->session->userdata('orgname');
		if (!empty($orgname))			$this->db->like( "O.Organization", $orgname );
		
		$where = array();
		
		$id_source = $this->session->userdata('id_source');
		if(!empty($id_source))	$where['S.SourceID'] = $id_source;
		
		$this->db->where($where);	
	}
	
	// list filter
	public function getSources() {		
		$rows = $this->db->get('source')->result();	
		return $this->getPairs($rows, 'SOURCEID', 'SOURCE');	
	}		

	// class extension	
	private function setDateSession() {
		$date1 = time();
		$date2 = strtotime('+1 days', $date1);
		$this->session->set_userdata( 'stdto',	strftime("%d.%m.%Y", $date1) );
		$this->session->set_userdata( 'endto',	strftime("%d.%m.%Y", $date2) );	
	}		

}	// class

?>