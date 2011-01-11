<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include("browse_iluni.php");

class browse_alumni extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name') + $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Alumni';	   
		$this->sheets['alumni'] = 'Alumni and Community';
		$this->sheets['adet'] = 'Alumni Details';		
	} // constructor

	protected function doFilterSelect() {
		$this->selectCommunity();
		$this->selectSource(); 
		$this->selectLDate(); 
		$this->selectName();  
	}
	
	function doTableHeader() { ?>
	    <th align="left" nowrap>Nama Lengkap</th>
	    <th nowrap align="center">Community</th>
	<?php }	

	protected function doRow(&$row) { ?>
	    <td width="50%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="40%" align="center"><?php echo $row->COMMUNITY;?></td>
	<?php }	

	protected function getTitle(&$row) { return $this->ref->salute($row).' '.$row->NAME; }	
		
	protected function belowHeader() { 
		if ( (empty($_POST['yearby'])) && (empty($_POST['decade'])) ) {
			$deptby = empty($_POST['deptby']) ? 0 : $_POST['deptby'];
			$progby = empty($_POST['progby']) ? 0 : $_POST['progby'];
?>
	<div id="SummaryID"></div>
  	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
		xajax_showSummary(<?=$deptby;?> , <?=$progby;?>);	
    //]]>
	</SCRIPT>
<?php
		}
	}	
} // class

?>