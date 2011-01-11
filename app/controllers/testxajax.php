<?php
Class Testxajax Extends Controller {

	function __construct () { 
		parent::__construct(); 	
		
		$this->load->model('init_model');	// loaded first			
//		$this->xajax->setFlag("debug", true);			
    }
	
	//-- CI's Segment
    public function func() {
		$this->xajax->register(XAJAX_FUNCTION, array('testFunction',&$this,'testFunction'));
        $this->xajax->processRequest();

        $this->theme->view('test/test_xajax');    
    }   
	
    public function modal() {	// LockBox test
		require_once( APPPATH.'libraries/xajax_plugins/response/modalWindow.inc.php');	
		
		$this->xajax->register(XAJAX_FUNCTION, array('testWindow',&$this,'testWindow'));	
		$this->xajax->register(XAJAX_FUNCTION, array('actionClose',&$this,'actionClose'));
        $this->xajax->processRequest();
	
        $this->theme->view('test/test_xajaxplugin');  		
	}	
	
	//-- XAJAX's Function   
    public function testFunction($number) {
        $objResponse = new xajaxResponse();
        $objResponse->Assign("SomeElementId","innerHTML", 
			"Xajax is working. Lets add : ".($number+3));
        return $objResponse;
    }
	
	public function testWindow() {	
		$objResponse = new xajaxResponse();
		$objResponse->plugin( 'clsmodalWindow', 'addWindow', 
			$this->windowContentTest(), '#000000', 20 );
		return $objResponse;
	}

	public function actionClose($data) {
		// now you can close your window, or, if you want, open a new window		
		$objResponse = new xajaxResponse();
		
		if ( $data['windowoption'] == 1 )	{
			$objResponse->plugin( 'clsmodalWindow', 'addWindow', 
				$this->windowContentSubmit($data), 'red', 20 );
		}	else	{
			$objResponse->plugin( 'clsmodalWindow', 'closeWindow');
		}	
	
		return $objResponse;
	}		
	
	//-- Serve XAJAX's View
	private function windowContentTest() {
		$width = rand( 100, 500 );
		$height = rand( 100, 500 );
		$id = md5(microtime());
		
		return '
	<div	style="width:' . $width . 'px;height:' . $height . 'px; font-size: 10px;
			background:#FFFFFF;color:#000000;border:1px solid #999999;padding:5px">
		<a href="javascript:void(0)"	onclick="xajax.closeWindow()"	>
		<img src="./images/closelabel.gif" alt="close" border="0" align="right"></a><br/>
		<a href="javascript:void(0)"	onclick="xajax_testWindow()"	>open new Window</a><br/>
		<form id="' . $id . '" method="post" enctype="multipart/form-data">
		<select name="windowoption" style="width:100px;">
			<option value="1">open new window</option>
			<option value="2">close window</option>
		</select><br>
		<input name="testinput" value="" type="text" style="width:100px;"/>
		</form>
		<a	href="javascript:void(0)" 
				onclick="xajax_actionClose(xajax.getFormValues(\'' . $id . '\'))"
		>submit formdata</a><br/>
	</div>';		
	}
	
	private function windowContentSubmit($data) {
		// do something with data...	
		$content = print_r( $data, true );
		return '			
		<div	style="width:200px;height:200px; font-size: 10px;
				background:#456789;color:#000000;border:1px solid #999999;padding:5px">
			<a href="javascript:void(0)" onclick="xajax.closeWindow()">close</a><br/>
			<pre>' . $content . '</pre>
		 </div>';
	}	 

}	// class
?>