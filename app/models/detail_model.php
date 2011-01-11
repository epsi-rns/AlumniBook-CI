<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class detail_model extends Model {

	function __construct () { parent::__construct();	}	
	
	public function getAlumna ($id) {	
		$sql = "SELECT FIRST 1 A.*, A.BirthDate, "
			."  EXTRACT(DAY FROM A.BirthDate) AS Tanggal, EXTRACT(YEAR FROM A.BirthDate) AS Tahun, "
			."  EXTRACT(WEEKDAY FROM A.BirthDate) AS Hari, EXTRACT(MONTH FROM A.BirthDate) AS Bulan "
			."FROM Alumni A "
			."WHERE AID=".$id;	
		return $this->db->query($sql)->row();
	}	
	
	public function getAlumnaName ($aid) {	
		$this->db->select('FIRST 1 NAME')->from('Alumni')->where(array('AID'=>$aid));	
		return $this->db->get()->row()->NAME;
	}		

	public function getOrg ($id) {	
		$sql = "SELECT FIRST 1 O.* FROM Organization O WHERE OID=".$id;
		return $this->db->query($sql)->row();
	}	

	// Items, common
	// ----------------------
	public function loadAny ($sql) {
		return $this->db->query($sql)->result();
	}	
	
	public function loadAddress ($linktype, $id) {
		$sql = "SELECT D.Address, D.Region FROM Address D "
			."WHERE (D.LinkType='$linktype') AND (D.LID=$id)";
		return $this->db->query($sql)->result();
	}	
	
	public function loadContact ($linktype, $id) {
		$sql= "SELECT CT.ContactType, C.Contact, CT.CTID "
			."FROM Contacts C "
			."  INNER JOIN ContactType CT ON (CT.CTID=C.CTID)"
			."WHERE (C.LinkType='$linktype') AND (C.LID=$id)";
		return $this->db->query($sql)->result();
	}

	public function loadComy ($id) {
		$sql= "SELECT AC.Angkatan, C.Community, AC.Khusus, C.DepartmentID, C.ProgramID "
			."FROM ACommunities AC "
			."  INNER JOIN Community C ON  (C.CID=AC.CID) "
			."WHERE AC.AID=".$id;
		return $this->db->query($sql)->result();
	}

	public function loadMap ($type, $id) {
		switch (strtolower($type)) {
	    case 'a': 
			$sql= "SELECT A.AID, M.MID, A.Name, A.Gender, A.BirthDate, A.Last_Update, "
				."A.Prefix, A.Suffix, A.ShowTitle, ";
			$where = "WHERE M.MID=".$id; break;
	    case 'o': 
			$sql= "SELECT O.OID, M.MID, O.Organization, O.Last_Update, ";
			$where = "WHERE M.MID=".$id; break;
	    default: return false;
		}

		$sql.= "JT.JobType, M.JobTypeID, JP.JobPosition, M.JobPositionID, "
			."M.Description, M.Department, M.Fungsional, M.Struktural "
			."FROM AOMap M "
			."  LEFT JOIN JobType JT ON (M.JobTypeID=JT.JobTypeID) "
			."  LEFT JOIN JobPosition JP ON (M.JobPositionID=JP.JobPositionID) "
			."  INNER JOIN Alumni A ON (M.AID=A.AID) "
			."  INNER JOIN Organization O ON (M.OID=O.OID) "
		.$where;

		return $this->db->query($sql)->row();
	}

	public function loadMapID ($type, $id) {	
		$myID = strtoupper($type)."ID";
		$this->db->select('MID')->from('AOMap')->where(array($myID=>$id));	
		$rows =& $this->db->get()->result();
		
		$mids = array();
		foreach($rows as $row) { $mids[] = $row->MID; }
		return $mids;
	}

	public function loadField ($id) {
		$sql= "SELECT F.Field, F.FieldID, Fs.Description "
			."FROM OFields Fs "
			."  INNER JOIN Field F ON (Fs.FieldID = F.FieldID) "
			."WHERE Fs.OID=".$id;
		return $this->db->query($sql)->result();
	}	
	
	// Items, alumni
	// ----------------------
	public function loadCompy ($id) {
		$sql = "SELECT Co.Competency, ACo.Description, ACo.CompetencyID "
			."FROM ACompetencies ACo "
			."  INNER JOIN Competency Co ON (Co.CompetencyID = ACo.CompetencyID) "
			."WHERE ACo.AID=".$id;
		return $this->db->query($sql)->result();
	}

	public function loadCerti ($id) {
		$sql = "SELECT ACe.Certification, ACe.Institution "
			."FROM ACertifications ACe "
			."WHERE ACe.AID=".$id;
		return $this->db->query($sql)->result();
	}
	
	public function loadExperiences ($id) {
		$sql = "SELECT AID, Organization "
			."FROM AExperiences "
			."WHERE AID=".$id;
		return $this->db->query($sql)->result();
	}	
}