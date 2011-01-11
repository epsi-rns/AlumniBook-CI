<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

abstract class generic_browse_model extends Model {
	protected $task = "";
	
	// --- SQL properties
	/** @var sql string relating to child class */
//	protected $countKey		= '';								// ???

	/** @var sql clause: order, filter, group */
	protected $order		= '';									// ???
//	protected $group		= '';
//	protected $groupStr		= '';	
	protected $orderCases 	= null;
	protected $defaultOrder	= null;	
	
	/** @var output for html */
//	public $pageNav		= null;	
	

	// --- Forward declaration 
	/* Force Extending class to define this method */	
	abstract protected function InitInput();	 
	
	function __construct () { parent::__construct();	}	
	
	// Common Tables
	private function getCase(&$param, $default, $cases) {  // cryptic script for geeks ;-)
		if (!isset($param)) { $param=$default; }
		foreach ($cases as $k => $v) { if ($param == $k) {return $v;} }
	}	
	
	protected function loadrows() {
		$this->InitInput();
		
		if ($this->orderCases) // $defaultOrder can be null, we better test against orderCases
			{ $this->order =  $this->getCase($_POST['orderby'], $this->defaultOrder, $this->orderCases); }

		if ($this->order) {$this->db->orderby($this->order);}
		
		//	anytime you need debugging		
		//	echo $this->db->_compile_select();	
		
		$query = $this->db->get();
		return $query->result(); 		
	}	
}

class browse_model extends generic_browse_model {	
	/** @var sql clause: order, filter, group */
	protected $communityOrderCases = array(11=>"C.Community", 12=>'C.Angkatan', 13=>'C.DepartmentID', 14=>'C.ProgramID desc');
	protected $sourceOrderCases = array(19=>'A.SourceID');
	protected $commonAlumniSelect	= " C.Community, C.Angkatan, C.DepartmentID, C.ProgramID, D.Department, P.Program, S.Source ";
	protected $extendedAlumniJoin = "";

	function __construct () {
	  parent::__construct(); // inherited constructor

	  // Init Constant;
	  $this->extendedAlumniJoin = ""
		."    LEFT JOIN ACommunities C ON (C.AID=A.AID) "
		."      LEFT JOIN Department D ON (D.DepartmentID = C.DepartmentID) "
		."      LEFT JOIN Program P ON (P.ProgramID = C.ProgramID) "
		."    INNER JOIN Source S ON (A.SourceID=S.SourceID) ";
	} // constructor
	
	public function getRows($task) {		
		$this->task = $task;
		
		switch($task) {			
			case 'comy'		: $this->prepCommunity();				break;
			case 'tocomy'	: $this->prepTotalCommunity();		break;
			case 'ctcomy'	: $this->prepCrossTabCommunity();	break;
			case 'alumni'	: $this->prepAlumni();						break;
			case 'birth'		: $this->prepBirthDay(); 					break;
			case 'compy'	: $this->prepCompetency();				break;
			case 'certi'		: $this->prepCertification();				break;
			case 'org'		: $this->prepOrganization(); 			break;
			case 'field'		: $this->prepField();							break;
			case 'occup'	: $this->prepOccupation();				break;
			case 'pos'		: $this->prepJobPosition();				break;
			case 'amap'	: 
			case 'omap'	: $this->prepMap(); break;
			case 'home'	: 
			case 'office'		: 
			case 'awaddr'	:
			case 'owaddr'	: $this->prepAddress(); break;
			case 'acon'		: 
			case 'ocon'		: 
			case 'awcon'	: 
			case 'owcon'	: $this->prepContact(); break;
		}
		
		return $this->loadrows();		
	}
	
	protected function InitInput() {
	// --- Web Argument...
	/** @var http request after validation */		
		
		if (!empty($_POST['deptby']))	{ 
			if ($_POST['deptby']==-1)	
						{ $this->db->where('(C.DepartmentID IS NULL)'); }
			else	{ $this->db->where('(C.DepartmentID='.$_POST['deptby'].')'); }			
		}
		
		if (!empty($_POST['progby']))	{ 
			if ($_POST['progby']==-1)	
						{ $this->db->where('(C.ProgramID IS NULL)'); }
			else	{ $this->db->where('(C.ProgramID='.$_POST['progby'].')'); }			
		}
		
		if (!empty($_POST['yearby']))	{ 
			if ($_POST['yearby']==-1)	
						{ $this->db->where('(C.Angkatan IS NULL)'); }
			else	{ $this->db->where('(C.Angkatan='.$_POST['yearby'].')'); }			
		}
		
		if (!empty($_POST['decade']))	{ 
			if ( in_array( $_POST['decade'], array(1960, 1970, 1980, 1990, 2000, 2010)) ) {
				$this->db->where('(C.Angkatan>='.$_POST['decade'].')'); 
				$this->db->where('(C.Angkatan<'.($_POST['decade']+10).')');
			}
		}			

		if (!empty($_POST['source']))	{ 
			if ($_POST['source']==-1)	
						{ $this->db->where('(A.SourceID IS NULL)'); }
			else	{ $this->db->where('(A.SourceID='.$_POST['source'].')'); }			
		}	
		
		if (!empty($_POST['name']))			{	$this->db->where(	"(A.Name LIKE '%".$_POST['name']."%')"	);	}
		if (!empty($_POST['lastupdate']))	{	$this->db->where(	"(A.Last_Update >= '".$_POST['lastupdate']."')"	);	}
		if (!empty($_POST['monthby']))		{	$this->db->where(	'(EXTRACT(MONTH FROM A.BirthDate)='.$_POST['monthby'].')'	);	}
		if (!empty($_POST['field']))				{	$this->db->where(	'(Fs.FieldID='.$_POST['field'].')'	);	}
		if (!empty($_POST['competency']))	{	$this->db->where(	'(ACo.CompetencyID='.$_POST['competency'].')'	);	}
		if (!empty($_POST['occupation']))	{	$this->db->where(	'(M.JobTypeID='.$_POST['occupation'].')'	);	}
		if (!empty($_POST['position']))		{	$this->db->where(	'(M.JobPositionID='.$_POST['position'].')'	);	}
		if (!empty($_POST['alpha']))			{	$this->db->where(	"(Organization LIKE '".$_POST['alpha']."%')"	);	}
	}	

	// Miscellanous
	//--------------------------------------------------------------------------
	
	public function getCategories($task) {
		switch($task)	{
			case 'field': 
				$sql = 'SELECT F.FieldID, F.Field, COUNT(OFs.OID) AS Total '
					."FROM OFields OFs "
					."INNER JOIN Field F ON (F.FieldID=OFs.FieldID) "
					."GROUP BY F.FieldID, F.Field";
				break;	
			case 'occup':
				$sql = 'SELECT JP.JobTypeID, JP.JobType, COUNT(M.MID) AS Total '
					."FROM AOMap M "
					."INNER JOIN JobType JP ON (JP.JobTypeID=M.JobTypeID) "
					."GROUP BY JP.JobTypeID, JP.JobType ";
				break;
			case 'compy':
				$sql = 'SELECT Co.CompetencyID, Co.Competency, COUNT(ACo.AID) AS Total '
					."FROM ACompetencies ACo "
					."INNER JOIN Competency Co ON (ACo.CompetencyID=Co.CompetencyID) "
					."GROUP BY Co.CompetencyID, Co.Competency ";
				break;
			case 'pos':
				$sql = 'SELECT JP.JobPositionID, JP.JobPosition, COUNT(M.MID) AS Total '
					."FROM AOMap M "
					."INNER JOIN JobPosition JP ON (JP.JobPositionID=M.JobPositionID) "
					."GROUP BY JP.JobPositionID, JP.JobPosition ";
				break;
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function rowYearSummary($deptby, $progby) {
		$this->db->select('Angkatan, COUNT(AID) AS Total')->from('ACommunities')->groupby('Angkatan');
		if (!empty($deptby)) $this->db->where('(DepartmentID = '.$deptby.')');
		if (!empty($progby)) $this->db->where('(ProgramID = '.$progby.')');
		
		foreach($this->db->get()->result() as $row)	{ $pairs[$row->ANGKATAN] = $row->TOTAL;	}
		return $pairs;
	}


	// Each Tables
	//--------------------------------------------------------------------------


	protected function prepCommunity() {
	  // --- SQL properties
	  $this->defaultOrder = 1;
	  $this->orderCases = array(1=>"C.CID", 2=>'C.Community', 3=>'C.DepartmentID', 4=>'C.ProgramID desc');

	  $this->db->from("Community C "
		."  INNER JOIN Program P ON (C.ProgramID = P.ProgramID) "
		."  INNER JOIN Department D ON (C.DepartmentID = D.DepartmentID) "
		."  LEFT JOIN ACommunities AC ON (AC.CID=C.CID) "
		."    LEFT JOIN Alumni A ON (A.AID=AC.AID) ");
	  $this->db->select("C.CID, C.Community, C.ProgramID, C.DepartmentID, P.Program, D.Department, COUNT(AC.CID) AS Total");
	  $this->db->groupby("C.CID, C.Community, C.ProgramID, C.DepartmentID, P.Program, D.Department");
//	  $this->countKey = 'DISTINCT C.CID';
	} 
	
	protected function prepCrossTabCommunity() {
		// --- SQL properties
		$this->defaultOrder = 1;
		$this->orderCases = array(1=>"C.ProgramID", 2=>'C.Angkatan');
		
/*	  Due to comma Bug in CI.1.6.

		$this->db->select("C.Angkatan, C.ProgramID, P.Program, "
			."  SUM(IIF(C.DepartmentID = 1, 1, 0)) AS Sipil,"
			."  SUM(IIF(C.DepartmentID = 2, 1, 0)) AS Mesin,"
			."  SUM(IIF(C.DepartmentID = 3, 1, 0)) AS Elektro,"
			."  SUM(IIF(C.DepartmentID = 4, 1, 0)) AS Metalurgi,"
			."  SUM(IIF(C.DepartmentID = 5, 1, 0)) AS Arsitektur,"
			."  SUM(IIF(C.DepartmentID = 6, 1, 0)) AS Kimia,"
			."  SUM(IIF(C.DepartmentID = 7, 1, 0)) AS Industri,"
			."  SUM(IIF(C.DepartmentID = 8, 1, 0)) AS Perkapalan,"
			."  COUNT(C.AID) as Total");   
*/

/*	  Fix it here */
		$this->db->ar_select = array	(
			'C.Angkatan', 'C.ProgramID', 'P.Program',
			'SUM(IIF(C.DepartmentID = 1, 1, 0)) AS Sipil',
			'SUM(IIF(C.DepartmentID = 2, 1, 0)) AS Mesin',
			'SUM(IIF(C.DepartmentID = 3, 1, 0)) AS Elektro',
			'SUM(IIF(C.DepartmentID = 4, 1, 0)) AS Metalurgi',
			'SUM(IIF(C.DepartmentID = 5, 1, 0)) AS Arsitektur',
			'SUM(IIF(C.DepartmentID = 6, 1, 0)) AS Kimia',
			'SUM(IIF(C.DepartmentID = 7, 1, 0)) AS Industri',
			'SUM(IIF(C.DepartmentID = 8, 1, 0)) AS Perkapalan',
			'COUNT(C.AID) as Total'   
		);

		$this->db->from("ACommunities C "
			."  INNER JOIN Alumni A ON (A.AID=C.AID) "
			."  INNER JOIN Program P ON (C.ProgramID=P.ProgramID)");
		$this->db->groupby("C.Angkatan, C.ProgramID, P.Program");
		//	$this->countKey = 'DISTINCT C.Angkatan, C.ProgramID, P.Program';
	} 


	protected function prepTotalCommunity() {
	  // --- SQL properties
	  if (!isset($_POST['groupby'])) { $_POST['groupby']=1; }

	  switch ($_POST['groupby']) {
	    case 1:  
			$this->db->select("COUNT(C.AID) as Total, C2.CID, C2.Community, C2.DepartmentID, C2.ProgramID");
			$this->db->from("ACommunities C "
				."  INNER JOIN Alumni A ON (A.AID=C.AID) "
				."  INNER JOIN Community C2 ON (C2.CID=C.CID)");
			$this->db->groupby("C2.CID, C2.Community, C2.DepartmentID, C2.ProgramID");
			$this->db->orderby("C2.CID");
			//$this->countKey = 'DISTINCT C.CID';
			break;
	    case 2:
			$this->db->select("COUNT(C.AID) as Total, D.Department, C2.DepartmentID");
			$this->db->from("ACommunities C "
				."  INNER JOIN Alumni A ON (A.AID=C.AID) "
				."  INNER JOIN Community C2 ON (C2.CID=C.CID) "
				."  INNER JOIN Department D ON (C2.DepartmentID = D.DepartmentID)");
			$this->db->groupby("D.Department, C2.DepartmentID");
			$this->db->orderby("C2.DepartmentID");
			//$this->countKey = 'DISTINCT D.DepartmentID';
	    break;
	    case 3:  
			$this->db->select("COUNT(C.AID) as Total, P.Program, C2.ProgramID");
			$this->db->from("ACommunities C "
				."  INNER JOIN Alumni A ON (A.AID=C.AID) "
				."  INNER JOIN Community C2 ON (C2.CID=C.CID) "
				."  INNER JOIN Program P ON (C2.ProgramID = P.ProgramID)");
			$this->db->groupby("P.Program, C2.ProgramID");
			$this->db->orderby("C2.ProgramID");
			//  $this->countKey = 'DISTINCT P.ProgramID';
	    break;
	    case 4:  
			$this->db->select("COUNT(C.AID) as Total, C.Angkatan");
			$this->db->from("ACommunities C "
				."  INNER JOIN Alumni A ON (A.AID=C.AID) "
				."  INNER JOIN Community C2 ON (C2.CID=C.CID)");
			$this->db->groupby("C.Angkatan");
			$this->db->orderby("C.Angkatan");
			// $this->countKey = 'DISTINCT C.Angkatan';
	    break;
	    case 5:  
			$this->db->select("COUNT(C.AID) as Total, C2.Community, C.ProgramID, C.DepartmentID, C.Angkatan");
			$this->db->from("ACommunities C "
				."  INNER JOIN Alumni A ON (A.AID=C.AID) "
				."  INNER JOIN Community C2 ON (C2.CID=C.CID)");
			$this->db->groupby("C2.Community, C.ProgramID, C.DepartmentID, C.Angkatan");
			$this->db->orderby("C.ProgramID desc, C.DepartmentID, C.Angkatan");
			//  $this->countKey = 'DISTINCT C.Community';
	    break;
	  }  // switch
	}

	protected function prepAlumni() {
		// --- SQL properties
		$this->defaultOrder = 12;
		$this->orderCases = array(1=>"A.AID", 2=>'Name') + $this->communityOrderCases + $this->sourceOrderCases;
		$this->order = "C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name ";
	
		$this->db->select(
			"A.AID, A.Name, A.Prefix, A.Suffix, A.ShowTitle, A.BirthDate, A.Gender, A.SourceID, A.Last_Update, "
			.$this->commonAlumniSelect);
		$this->db->from("Alumni A ".$this->extendedAlumniJoin);		
//		$this->countKey = 'A.AID';		
	}


	protected function prepBirthDay() {
		// --- SQL properties
		$this->defaultOrder = 4;
		$this->birthOrderCases = array(1=>"A.CID", 2=>'Name', 3=>'BirthDate', 4=>'Tanggal', 5=>'Bulan', 6=>'Tahun', 7=>'Hari' );
		$this->orderCases = $this->birthOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->db->from("Alumni A ".$this->extendedAlumniJoin);
		$this->db->where('(A.BirthDate IS NOT NULL)');
		$this->db->select("A.AID, A.Name, A.Gender, A.BirthDate, "
			.$this->commonAlumniSelect.", "
			."  EXTRACT(WEEKDAY FROM A.BirthDate) AS Hari, EXTRACT(MONTH FROM A.BirthDate) AS Bulan, "
			."  EXTRACT(DAY FROM A.BirthDate) AS Tanggal, EXTRACT(YEAR FROM A.BirthDate) AS Tahun ");
//		$this->countKey = 'A.AID';
	}
	
	protected function prepCompetency() {
		// --- SQL properties
		$this->defaultOrder = 3;
		$this->compyOrderCases = array(1=>"A.AID", 2=>'A.Name', 3=>'Co.Competency');
		$this->orderCases = $this->compyOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->order = "ACo.CompetencyID, C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name ";
		$this->db->from("ACompetencies ACo "
			."  INNER JOIN Alumni A ON (ACo.AID=A.AID) ".$this->extendedAlumniJoin
			."  INNER JOIN Competency Co ON (Co.CompetencyID = ACo.CompetencyID)");
		$this->db->select("A.AID, A.Name, Co.Competency, ACo.Description, ACo.CompetencyID, "
			.$this->commonAlumniSelect);
//	  $this->countKey = 'ACo.AID';
	}

	protected function prepCertification() {
		// --- SQL properties
		$this->defaultOrder = 3;
		$this->certiOrderCases = array(1=>"A.AID", 2=>'A.Name', 3=>'ACe.Certification', 4=>'ACe.Institution');
		$this->orderCases = $this->certiOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->order = "C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name, ACe.Certification ";

		$this->db->from("ACertifications ACe "
			."  INNER JOIN Alumni A ON (ACe.AID=A.AID) ".$this->extendedAlumniJoin);
		$this->db->select("A.AID, A.Name, ACe.Certification, ACe.Institution, "
			.$this->commonAlumniSelect);
//	  $this->countKey = 'ACe.AID';
	}
	
	protected function prepOrganization() {
		// --- SQL properties
		$this->defaultOrder = 3;
		$this->orderCases = array(41=>"OID", 42=>'Organization', 43=>'Product', 44=>'HasBranch');

		$this->order = "Organization ";
		$this->db->from("Organization");
		$this->db->select("OID, Organization, Product, HasBranch, Last_Update");
//	  $this->countKey = 'OID';
	}
	
	protected function prepField() {
		// --- SQL properties
		$this->defaultOrder = 3;
		$this->orderCases = array(41=>"OID", 42=>'Organization', 43=>'Product', 45=>'Field');

		$this->order = "F.FieldID, O.Organization ";
		$this->db->from("OFields Fs "
			."  INNER JOIN Organization O ON (Fs.OID =  O.OID) "
			."  INNER JOIN Field F ON (Fs.FieldID = F.FieldID)");
		$this->db->select("O.OID, O.Organization, O.Product, F.Field, F.FieldID, Fs.Description");
//	  $this->countKey = 'Fs.OID';
	}
	
	protected function prepMap() {
		// --- SQL properties
		$this->defaultOrder = 4;
		$this->mapOrderCases = array(1=>"AID", 41=>'OID', 2=>'Name', 42=>'Organization', 5=>'JobPosition desc');
		$this->orderCases = $this->mapOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->order = ($this->task=='amap') ? 
			"C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name" : "O.Organization";
		$this->db->from("AOMap M "
			."  INNER JOIN Organization O ON (M.OID=O.OID) "
			."  INNER JOIN Alumni A ON (M.AID=A.AID) "
			.$this->extendedAlumniJoin);
		$this->db->select("O.OID, A.AID, A.Name, O.Organization, "
			.$this->commonAlumniSelect);
//	  $this->countKey = 'M.MID';
	}
	
	protected function prepJobPosition() {
		// --- SQL properties
		$this->defaultOrder = 12;
		$this->alumniOrderCases = array(1=>"A.AID", 2=>'Name', 3=>'M.JobPositionID');
		$this->orderCases = $this->alumniOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->order = "M.JobPositionID, C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name ";
		$this->db->from("AOMap M "
			."  INNER JOIN Organization O ON (M.OID=O.OID) "
			."  INNER JOIN Alumni A ON (M.AID=A.AID) ".$this->extendedAlumniJoin
			."  INNER JOIN JobPosition JP ON (M.JobPositionID=JP.JobPositionID)");
		$this->db->select("O.OID, A.AID, A.Name, O.Organization, "
			."  JP.JobPosition, M.JobPositionID, M.Description, M.Department, "
			.$this->commonAlumniSelect);
//	  $this->countKey = 'M.MID';
	}
	
	protected function prepOccupation() {
		// --- SQL properties
		$this->defaultOrder = 12;
		$this->alumniOrderCases = array(1=>"A.AID", 2=>'Name', 3=>'M.JobTypeID');
		$this->orderCases = $this->alumniOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		$this->order = "M.JobTypeID, C.ProgramID desc, C.DepartmentID, C.Angkatan, A.Name ";
		$this->db->from("AOMap M "
			."  INNER JOIN Organization O ON (M.OID=O.OID) "
			."  INNER JOIN Alumni A ON (M.AID=A.AID) ".$this->extendedAlumniJoin
			."  INNER JOIN JobType JT ON (M.JobTypeID=JT.JobTypeID)");
		$this->db->select("O.OID, A.AID, A.Name, O.Organization, "
			."  JT.JobType, M.JobTypeID, "
			.$this->commonAlumniSelect);
//	  $this->countKey = 'M.MID';
	}
	
	protected function prepAddress() {
		// --- SQL properties
		$this->defaultOrder = 23;
		$this->addressOrderCases = array( 1=>"A.AID", 41=>'O.OID', 2=>'A.Name', 42=>'O.Organization', 5=>'Address', 6=>'Region', 
			21=>'NegaraID', 22=>'DR.PropinsiID', 23=>'DR.WilayahID', 24=>'PostalCode desc', 25=>'Jalan', 26=>'Kawasan', 27=>'Gedung'); 
		$this->orderCases = $this->addressOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		switch ($this->task) {
	    case 'home'   :
			$this->db->select("A.AID, A.Name, DR.Address, DR.Region, PR.Propinsi, WI.Wilayah, "
				.$this->commonAlumniSelect);
			$this->db->from("Address DR "
				."  INNER JOIN Alumni A ON (DR.LID = A.AID) ".$this->extendedAlumniJoin
				."  LEFT JOIN Propinsi PR ON (PR.PropinsiID=DR.PropinsiID) "
				."  LEFT JOIN Wilayah WI ON (WI.WilayahID=DR.WilayahID)");
			$this->db->where("(DR.LinkType='A')");
		break;
	    case 'office' : 
			$this->db->select("O.OID, O.Organization, DR.Address, DR.Region, PR.Propinsi, WI.Wilayah");
			$this->db->from("Address DR "
				."  INNER JOIN Organization O ON (DR.LID = O.OID) "
				."  LEFT JOIN Propinsi PR ON (PR.PropinsiID=DR.PropinsiID) "
				."  LEFT JOIN Wilayah WI ON (WI.WilayahID=DR.WilayahID)");
			$this->db->where("(DR.LinkType='O')");
		break;
	    case 'awaddr'   :
			$this->db->select("A.AID, O.OID, A.Name, O.Organization, DR.Address, DR.Region, PR.Propinsi, WI.Wilayah, "
				.$this->commonAlumniSelect);
			$this->db->from("Address DR "
				."  INNER JOIN AOMap M ON (M.MID=DR.LID) "
				."    INNER JOIN Alumni A ON (A.AID = M.AID) ".$this->extendedAlumniJoin
				."    INNER JOIN Organization O ON (M.OID=O.OID) "
				."  LEFT JOIN Propinsi PR ON (PR.PropinsiID=DR.PropinsiID) "
				."  LEFT JOIN Wilayah WI ON (WI.WilayahID=DR.WilayahID)");
			$this->db->where("(DR.LinkType='M')");
		break;
	    case 'owaddr' : 
			$this->db->select("A.AID, O.OID, O.Organization, A.Name, DR.Address, DR.Region, PR.Propinsi, WI.Wilayah, "
				.$this->commonAlumniSelect);
			$this->db->from("Address DR "
				."  INNER JOIN AOMap M ON (M.MID=DR.LID) "
				."    INNER JOIN Organization O ON (M.OID=O.OID) "
				."    INNER JOIN Alumni A ON (A.AID = M.AID) ".$this->extendedAlumniJoin
				."  LEFT JOIN Propinsi PR ON (PR.PropinsiID=DR.PropinsiID) "
				."  LEFT JOIN Wilayah WI ON (WI.WilayahID=DR.WilayahID)");
			$this->db->where("(DR.LinkType='M')");
		break;
		} // switch
//	  $this->countKey = '*';
	}

	protected function prepContact() {
		// --- SQL properties
		if (!isset($this->orderby)) { 
			switch ($this->task) {
				case 'acon'	: 
				case 'awcon'	: $this->orderby=11;  break;
				case 'ocon'	: 
				case 'owcon'	: $this->orderby=42;  break;
			}
		}

		$this->defaultOrder = null; // already set above, actually there's no need to write this line.
		$this->contactOrderCases = array(1=>"A.AID", 41=>'O.OID', 2=>'A.Name', 42=>'O.Organization');
		$this->orderCases = $this->contactOrderCases + $this->communityOrderCases + $this->sourceOrderCases;

		switch ($this->task) {
	    case 'acon'   :
			$this->db->select("A.AID, A.Name, VC.*, "
				.$this->commonAlumniSelect);
			$this->db->from("ViewContacts VC"
				."  INNER JOIN Alumni A ON (VC.LID = A.AID)".$this->extendedAlumniJoin);
			$this->db->where("(VC.LinkType='A')");
		break;
	    case 'ocon' : 
			$this->db->select("O.OID, O.Organization, VC.* ");
			$this->db->from("ViewContacts VC"
				."  INNER JOIN Organization O ON (VC.LID = O.OID)");
			$this->db->where("(VC.LinkType='O')");
		break;
	    case 'awcon'   :
			$this->db->select("A.AID, O.OID, A.Name, O.Organization, VC.*, "
				.$this->commonAlumniSelect);
			$this->db->from("ViewContacts VC "
				."  INNER JOIN AOMap M ON (M.MID=VC.LID) "
				."    INNER JOIN Alumni A ON (A.AID = M.AID) ".$this->extendedAlumniJoin
				."    INNER JOIN Organization O ON (M.OID=O.OID)");
			$this->db->where("(VC.LinkType='M')");
		break;
	    case 'owcon' : 
			$this->db->select("A.AID, O.OID, O.Organization, A.Name, VC.*,  "
				.$this->commonAlumniSelect);
			$this->db->from("ViewContacts VC "
				."  INNER JOIN AOMap M ON (M.MID=VC.LID) "
				."    INNER JOIN Organization O ON (M.OID=O.OID) "
				."    INNER JOIN Alumni A ON (A.AID = M.AID) ".$this->extendedAlumniJoin);
			$this->db->where("(VC.LinkType='M')");
		break;
		} // switch
//	  $this->countKey = '*';
	}

/* template: quick copy to add
class idbBrowseX extends idbBrowseProject {
	function __construct () {
	  parent::__construct(); // inherited constructor

	  // --- SQL properties
	  $this->isFilteredTable= TRUE;  // setting for parent's constructor
	  $this->idbBrowse(); // inherited constructor

//	  $this->defaultOrder = 
//	  $this->orderCases = + ;

	  $this->table = 'FROM '
	  $this->query = 'SELECT '
	  $this->countKey = '*';
	} // constructor
} // class
*/

	
}	// class browse_model

?>