<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

abstract class Generic_detail extends Controller {
	protected $newID;
	
	// Need to be initialized in each descendant
	protected $segment;
	protected $manageview;
	protected $editview;
	protected $icon48;	
	
	public $data;
	
	abstract protected function mapPostData($MasterID);
	
	// Force Event Method Name
	protected function onBeforeManage(&$data) {}	
	protected function onBeforeEdit(&$data, $ID=null) {}
	
	/*----Implementation----*/	
	
	function __construct () { 
		parent::__construct(); 	
		
		$this->load->model('init_model');	// loaded first
		$this->data = array();
	}		
	
	public function index()	{	redirect($this->segment.'/manage');	}
	
	public function manage($MasterID=null) {
		if (empty($MasterID)) show_404();
		
		switch($this->input->post('task')) {			
			case 'edit'	: 		
				$cid = $_POST['cid'];
				redirect($this->segment.'/edit/'.$MasterID.'/'.$cid[0]);	break; 
			case 'add'	:	
				redirect($this->segment.'/edit/'.$MasterID);	break; 
			case 'del'	:	
				$cid = $_POST['cid'];
				foreach($cid as $id)	$this->dbm->del($id);
				redirect($this->segment.'/manage/'.$MasterID);	break;
			default:
				$data =& $this->data;			
				$data['rows']	=& $this->dbm->getAll($MasterID);
				$data['task']	= 'manage';
				$data['MasterID'] = $MasterID;
				$data['segment']	= $this->segment;
				$data['icon48']	= $this->icon48;	
				
				$this->onBeforeManage($data);					
				$this->theme->view($this->manageview, $data);				
		}	
	}
	
	public function edit($MasterID=null, $ID=null) {
		if (empty($MasterID)) show_404();		
		
		switch($this->input->post('task')) {	
			case 'cancel'	:	
				redirect($this->segment.'/manage/'.$MasterID);	break;
			case 'save'		:
				$this->save($MasterID, $ID);
				redirect($this->segment.'/manage/'.$MasterID);	break;
			case 'apply'		:
				$this->save($MasterID, $ID);	
				if (empty($ID)) {	$ID = $this->NewID;	}				
				redirect($this->segment.'/edit/'.$MasterID.'/'.$ID);	break;
			default:
				$data =& $this->data;
				if (empty($ID)) {
					$data['row'] =& $this->dbm->getDummy();
					$data['task'] = 'add'; 					
				} else {
					$data['row'] =& $this->dbm->get($ID);
					$data['task'] = 'edit'; 		
				}	
				$data['MasterID'] = $MasterID;
				$data['icon48']	= $this->icon48;
				
				$this->onBeforeEdit($data, $ID);
				$this->theme->view($this->editview, $data);
		}	
	}
	
	protected function save($MasterID, $ID=null) {
		$data = $this->mapPostData($MasterID);

		if (empty($ID)) {
			$this->NewID = $this->dbm->insert($data);	
		} else {						
			$this->dbm->update($ID, $data);
		}
	}	
} // class

?>