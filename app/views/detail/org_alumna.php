<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	// show Alumna In Organization
?>
		<strong><?=$this->ref->alumna($alumna);?></strong>
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
<?php	
	$this->item->showMapDetail($alumna, $k); 
	$this->item->showCommunity($communities, $k); 
	$this->item->showAddress($moffices, $k, $this->lang->line('item_workingaddress'));
	$this->item->showContact($mcontacts, $k);	
?>
		</table>