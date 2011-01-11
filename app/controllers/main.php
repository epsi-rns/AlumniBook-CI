<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Main extends Controller {
	public $mylang; // shortcut for using in some views
	
	function __construct () { 
		parent::__construct(); 	

		$this->load->model('init_model');	// loaded first			
		$this->load->model('ref_iluni', 'ref');	
		$this->mylang = $this->session->userdata('lang');

		$this->xajax->register(XAJAX_FUNCTION, array('showLeftMenu',&$this->theme,'showLeftMenu'));	
		$this->xajax->register(XAJAX_FUNCTION, array('showSummary',	&$this,	'showSummary'));		
        $this->xajax->processRequest();		
	}		

	public function index()	{	
		$data['covermenus']	= $this->main_model->getCoverMenu();
		$timelastupdate			= strtotime($this->main_model->getLastUpdate());
		$data['lastupdate']		= strftime("%d %B %Y, jam %H:%M:%S", $timelastupdate);
		$this->theme->view('front/cover', $data);
	}	
	
	public function rss() {
		$data['rows'] =& $this->main_model->getRSS();
		$this->load->view('rss', $data);			
	}	
	
	public function browse($task, $ID=null)	{	
		$num		= func_num_args();	
		$arg_list	= func_get_args();	
		$task		= strtolower($task);
		
		// initialize arguments possibility	
		$allowedtask = array(
			'comy', 'tocomy', 'ctcomy', 'alumni', 'birth', 'compy', 'certi', 
			'org', 'field', 'occup', 'pos', 'amap', 'omap',
			'home', 'office', 'awaddr', 'owaddr', 'acon', 'ocon',  'awcon', 'owcon');			
		$categorized	= array('birth', 'compy', 'field', 'occup', 'pos');
		$taskusingID	= $categorized;
		$mapIDpost		= array(
			'birth'=>'monthby','compy'=>'competency', 
			'field'=>'field', 'occup'=>'occupation', 'pos'=>'position');		
		$mapname		= array(
			'amap'=> 'map', 'omap'=> 'map',
			'home'=>'address', 'office'=>'address', 'awaddr'=>'address','owaddr'=>'address',
			'acon'=>'contact', 'ocon'=>'contact', 'awcon'=>'contact','owcon'=>'contact');
		$viewclass		= isset($mapname[$task]) ? $mapname[$task] : $task;				

		if (in_array($task, $categorized) && ($num==1)) {
			$postcheck	= $mapIDpost[$task];
			if (empty($_POST[$postcheck])) 
				{	$this->showCategories($task);	return; } 		
		}
		
		if (in_array($task, $taskusingID)) {	// Map ID as a post variable			
			$postcheck	= $mapIDpost[$task];
			if	($num==2) 	{	$_POST[$postcheck] = intval($ID); }
		}		

		if (in_array($task, $allowedtask)) {					
			// Initialize Parameter Arguments
			$isvalid=true;

			if ($task=='alumni') 
				$isvalid = $this->validategetalumni($num, $arg_list);
			
			$this->validatepost();
			if (($task=='birth') && empty($_POST['monthby'])) $isvalid=false;
			
			if (!$isvalid) {show_404('page');return;}
			
			// Serve Data, 
			$this->load->model('browse_model');
			$this->benchmark->mark('database_execution_start');
			$rows =& $this->browse_model->getRows($task);
			$this->benchmark->mark('database_execution_end');			
			
			$this->putsession();			
			
			// Serve View, Init Object
			$this->load->model('browse/browse_'.$viewclass, 'browse');
			// Assign
			$this->browse->rows =& $rows;
			$this->browse->task = $task;

			$this->theme->view('browse');
		} else show_404('page');

	}		
	
	public function sheet($task)	{	
		$task		= strtolower($task);
		$sheetclass = $task;

		// initialize arguments possibility	
		$allowedtask = array('alumni', 'adet');

		if (in_array($task, $allowedtask)) { 
			if (in_array( $task, array('adet') )) 
				$stask = 'alumni';
			else $stask = $task;
		
			// Initialize Parameter Arguments
			$this->getsession();

			// load models
			$this->load->model('browse_model');
			$this->load->model('sheet/sheet_'.$sheetclass, 'sheet');	
			if (in_array( $task, array('adet') )) { 
				$this->load->model('detail_model', 'ds');
				$this->sheet->ds =& $this->ds;
			}	

			// Save it before any long query
			$this->sheet->orderby = $this->input->post('orderby'); 

			// Serve Data, 
			$rows =& $this->browse_model->getRows($stask);		

			// Serve Sheet, 			
			$this->sheet->rows =& $rows;	// Assign		
			$this->sheet->show();		
		} else show_404('page');		
	}
	
	private function validatepost() {
		/* Community */		
		if (!empty($_POST['yearby']))	{ 		
			if (($_POST['yearby'] < 1964) or ($_POST['yearby'] > 2015)) 
				$_POST['yearby']=-1; 
		}
		if (!empty($_POST['decade']))	{ 
			if ( !in_array($_POST['decade'], array(1960, 1970, 1980, 1990, 2000, 2010)) ) 
				$_POST['decade'] = -1; 
		}		
		
		/* Extended alumni */
		if (!empty($_POST['name']))		$_POST['name'] = addslashes(trim($_POST['name'])); 
		if (!empty($_POST['monthby']))	{
			if (($_POST['monthby']<1) or ($_POST['monthby']>12)) 
				unset($_POST['monthby']); 
		}		
	  	if (!empty($_POST['lastupdate']))	$_POST['lastupdate'] = trim($_POST['lastupdate']); 
		if (!empty($_POST['alpha']))	$_POST['alpha'] = trim($_POST['alpha']); 

	}

	private function validategetalumni($num, $arg_list) {
			$gets = array();

			if ($num>1) {
				array_shift($arg_list);
				foreach($arg_list as $arg) {
					$pair = explode(',', $arg);
					$gets[$pair[0]] = $pair[1];
				}	
			}				

			$checks = array('deptby', 'progby', 'yearby', 'decade');

			/* Community */				
			// Validate all posible query browser's params here
			foreach($checks as $check)
				if (!empty($gets[$check]))	{ $_POST[$check] = intval($gets[$check]); }
		
			// Check whether any params exist
			$isvalid=false;
			if (isset($_POST['name'])) $isvalid=true;				
			foreach($checks as $check) { if (isset($_POST[$check])) $isvalid=true;	}	
			
			return $isvalid;
	}
	
	private function putsession() {
		$checks = array('orderby', 'source', 'deptby', 'progby', 'yearby', 'decade', 'name', 'monthby', 'lastupdate', 'alpha');

		foreach($checks as $check) { 
			$value = $this->input->post($check);
			$this->session->set_userdata($check, $value);
		}		
	}
	
	private function getsession() {
		$checks = array('orderby', 'source', 'deptby', 'progby', 'yearby', 'decade', 'name', 'monthby', 'lastupdate', 'alpha');

		foreach($checks as $check)  
			$_POST[$check] = $this->session->userdata($check);
	}	
	
	private function showCategories($task) {
		switch($task) {
			case 'birth': $this->theme->view('browse/menubirth'); break;
			default: {						
				$columnname = array(
					'compy'=>'Competency', 'field'=>"Field", 
					'occup'=>'JobType', 'pos'=>'JobPosition');
				$bodytext = array(
					'compy'=>'kompetensi alumni', 'field'=>'bidang usaha', 
					'occup'=>'jenis pekerjaan', 'pos'=>'jenis jabatan');
				$headtext = array(
					'compy'=>'Kompetensi', 'field'=>'Business Field', 
					'occup'=>'Occupation/Job Type', 'pos'=>'Job Position'
				);
				
				$this->load->model('browse_model');
				
				$data['task'] = $task;
				$data['rows'] =& $this->browse_model->getCategories($task);
				$data['ID'] = strtoupper($columnname[$task].'ID');
				$data['option'] = strtoupper($columnname[$task]);
				$data['bodytext'] = 'Pilih '.$bodytext[$task];
				$data['headtext'] = 'Pilih '.$headtext[$task];
				$this->theme->view('browse/menuoption', $data);						
			}	
		}		
	}	

	//-- XAJAX's Function   
	public function showSummary($deptby, $progby) {
		$dept =  !empty($deptby) ? '/deptby,'.$deptby : '';
		$prog =  !empty($progby) ? '/progby,'.$progby : '';
		$data['link'] = 'alumni'.$dept.$prog;
			
		$this->load->model('browse_model');			
		$data['rows'] =& $this->browse_model->rowYearSummary($deptby, $progby);
			
        $objResponse = new xajaxResponse();
		if(!empty($data['rows'])) {
			$content = $this->load->view('browse/summary', $data, true);			
			$objResponse->Assign("SummaryID","innerHTML", $content);
		}	
        return $objResponse;
	}
}
?>