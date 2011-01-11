<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Detail extends Controller {
	public $mylang; // shortcut for using in some views
	
	function __construct () { 
		parent::__construct(); 	

		// Load Models
		$this->load->model('init_model');	// loaded first			
		$this->load->model('ref_iluni', 'ref');
		$this->load->model('detail_model', 'ds');		
		$this->mylang = $this->session->userdata('lang');
		
		$this->xajax->register(XAJAX_FUNCTION, array('showLeftMenu',&$this->theme,'showLeftMenu'));	
	}	
	
	// alumni
	public function a($id) { 
		// Load Models
		$this->load->model('detail/item_alumni', 'item');	// before XAJAX' Request

		// XAJAX
		$this->xajax->register(XAJAX_FUNCTION, array('showAlumna',&$this,'showAlumna'));
		$this->xajax->register(XAJAX_FUNCTION, array('showOrgInAlumna',&$this,'showOrgInAlumna'));
        $this->xajax->processRequest();	
		
		// Assign
		$data['aid']		= $id;			
		$data['name']	= $this->ds->getAlumnaName ($id);
		$data['mids'] 	=& $this->ds->loadMapID('A', $id);		

		// Serve View
		$this->theme->view('detail/alumna', $data);
	}	
	
	// organization
	public function o($id) {
		// Load Models
		$this->load->model('detail/item_org', 'item');	// before XAJAX'request
		
		// XAJAX
		$this->xajax->register(XAJAX_FUNCTION, array('showOrg',&$this,'showOrg'));
		$this->xajax->register(XAJAX_FUNCTION, array('showAlumnaInOrg',&$this,'showAlumnaInOrg'));
        $this->xajax->processRequest();			

		// Assign
		$data['oid']		= $id;			
		$data['one']		=& $this->ds->getOrg ($id);	
		$data['mids'] 	=& $this->ds->loadMapID('O', $id);			

		// Serve View
		$this->theme->view('detail/org', $data);
	}		
	
	//-- XAJAX's Function  
    public function showAlumna($aid) {
		$k = 0;
		$mode=1;
		
		$data['mode'] = $mode;
		$data['one'] =& $this->ds->getAlumna ($aid);
		$data['communities']	=& $this->ds->loadComy ($aid);	
		$data['competencies']	=& $this->ds->loadCompy ($aid);
		$data['certifications']	=& $this->ds->loadCerti ($aid);
		$data['experiences']	=& $this->ds->loadExperiences ($aid);	 

		if (($mode==1) || ($mode==3)) {
			$data['homes'] =& $this->ds->loadAddress('A', $aid);
			$acontacts	= $this->ds->loadContact('A', $aid);  
			$this->item->rebuildContacts($acontacts);
			$data['acontacts'] =& $acontacts;			
		}

		$content = $this->load->view('detail/alumna_det', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("AlumnaID","innerHTML", $content);
        return $objResponse;
    }

    public function showOrgInAlumna($mid) {
		$k = 0;
		$mode=1;
		$data['organization'] =& $this->ds->loadMap('O', $mid);
		$oid	= $data['organization']->OID;		

		if ($mode==1) {
			$data['offices']		=& $this->ds->loadAddress('O', $oid);
			$ocontacts	= $this->ds->loadContact('O', $oid); 
			$this->item->rebuildContacts($ocontacts);
			$data['ocontacts'] =& $ocontacts;
		}
		if (($mode==1) || ($mode==3)) {
			$data['moffices']		=& $this->ds->loadAddress('M', $mid);
			$mcontacts	= $this->ds->loadContact('M', $mid);  
			$this->item->rebuildContacts($mcontacts);
			$data['mcontacts'] =& $mocontacts;
		}		
		
		$content = $this->load->view('detail/alumna_org', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("MID".$mid,"innerHTML", $content);
        return $objResponse;
    }		
	
    public function showOrg($oid) {
		$k = 0;
		$mode=1;
		
		$data['mode'] = $mode;
		
		$data['one']		=& $this->ds->getOrg ($oid);		
		$data['fields'] 	=& $this->ds->loadField ($oid);

		$data['parents']		= null;
		$data['branches']	= null;
		if (($mode==1) || ($mode==2)) {
			if (isset($data['one']->PARENTID)) { 	      // notice: not using $database->loadObject() anymore
				$data['parents'] =& $this->ds->loadAny(
					"SELECT FIRST 1 OID, Organization FROM Organization "
					."WHERE OID=".$this->one->PARENTID); 
			} 
			$data['branches'] =& $this->ds->loadAny(
				"SELECT OID, Organization FROM Organization WHERE ParentID=".$oid);
	  }

		if (($mode==1) || ($mode==3)) {
			$data['offices']	=& $this->ds->loadAddress('O', $oid);
			$ocontacts	= $this->ds->loadContact('O', $oid); 
			$this->item->rebuildContacts($ocontacts);
			$data['ocontacts'] =& $ocontacts;		
		}		

		$content = $this->load->view('detail/org_det', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("OrganizationID","innerHTML", $content);
        return $objResponse;
    }	
	
    public function showAlumnaInOrg($mid) {
		$k = 0;
		$mode=1;
		$data['alumna'] =& $this->ds->loadMap('A', $mid);
		$aid	= $data['alumna']->AID;	
		
		$data['communities'] = $this->ds->loadComy ($aid);

		if (($mode==1) || ($mode==3)) {
			$data['moffices']		=& $this->ds->loadAddress('M', $mid);
			$mcontacts	= $this->ds->loadContact('M', $mid);  
			$this->item->rebuildContacts($mcontacts);
			$data['mcontacts'] =& $mocontacts;
		}		
		
		$content = $this->load->view('detail/org_alumna', $data, true);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("MID".$mid,"innerHTML", $content);
        return $objResponse;
    }			
	
}
?>