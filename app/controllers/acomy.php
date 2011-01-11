<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("generic_alumni.php");

class AComy extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'acomy';
		$this->manageview	= 'entry/acommunities';
		$this->editview		= 'entry/editacomy';	
		
		$this->load->model('entry/acomy_model', 'dbm');
	}
	
	public function edit($MasterID=null, $ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, 
			array('selectCommunities',	&$this,	'selectCommunities'));
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}

	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'CID'	=> $_POST['id_comy'],
			'Angkatan'	=> $_POST['year'],
			'Khusus'		=> $_POST['special']
		);		
	}
	
	//-- XAJAX's Function   
    public function selectCommunities($orig_val) {
		$pairs	=& $this->dbm->getCommunities();	
		$content = form_dropdown( 'id_comy', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("CommunitiesID","innerHTML", $content);
        return $objResponse;
    }			

} // class

?>