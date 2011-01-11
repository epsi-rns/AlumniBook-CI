<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Theme 
{
	private $theme;
	public $dataTheme;
	public $data;
	public $view;
	
	function __construct () { 
		$this->theme =& get_instance();
		$this->dataTheme = array();	// No need any theme data in this project
	}	
	
	public function view($view, &$data = null)	{
		$this->view = $view;
		$this->data =& $data;
		$this->dataTheme['xajax_js'] = $this->theme->xajax->getJavascript('./js/');			
		$this->theme->load->view('theme', $data);
	}	
	
	//-- XAJAX's Function  	
	public function showLeftMenu() {
		$content =	'<div id="leftcol">';
		$content .=	$this->theme->load->view('panel/leftmenu', null, true); 
		$content .=	$this->theme->load->view('panel/modulerss', null, true); 
		$content .=	'</div>';

		$toggle = '
			<span class="pathway">&#x00ab;
					<a href="javascript:void(0);" onclick="menuToggle();" id="menuControl"> hide menu </a>
				&#x00bb;</span>';
		
        $objResponse = new xajaxResponse();
        $objResponse->Assign("leftmenu","innerHTML", $content);
        $objResponse->Assign("pathway","innerHTML", $toggle);		
        return $objResponse;		
	}	
}
?>