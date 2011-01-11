<?php 
/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("generic_alumni.php");

class ACompy extends Generic_alumni {

	function __construct () { 
		parent::__construct(); 	
			
		$this->segment		= 'acompy';
		$this->manageview	= 'entry/acompetencies';
		$this->editview		= 'entry/editacompy';	
		
		$this->load->model('entry/acompy_model', 'dbm');
	}	

	public function edit($MasterID=null, $ID=null) {
		$this->xajax->register(XAJAX_FUNCTION, 
			array('selectCompetencies',	&$this,	'selectCompetencies'));
        $this->xajax->processRequest();

		parent::edit($MasterID, $ID);
	}

	protected function mapPostData($MasterID) {
		return array(
			'AID'	=> $MasterID,
			'CompetencyID'	=> $_POST['id_compy'],
			'Description'			=> $_POST['desc']
		);		
	}
	
	//-- XAJAX's Function   
    public function selectCompetencies($orig_val) {
		$pairs	=& $this->dbm->getCompetencies();	
		$content = form_dropdown( 'id_compy', $pairs, $orig_val);

        $objResponse = new xajaxResponse();
        $objResponse->Assign("CompetenciesID","innerHTML", $content);
        return $objResponse;
    }			

} // class

?>