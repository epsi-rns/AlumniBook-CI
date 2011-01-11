<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	$this->item->showCommunity($communities, $k);  
	if ($mode==1) { 
		$this->item->showGender($one, $k); 
		$this->item->showBirth($one, $k); 
	} 
	$this->item->showTitle($one, $k); 
	$this->item->showCompy($competencies, $k); 
	$this->item->showCerti($certifications, $k); 
	$this->item->showAddress($homes, $k, $this->lang->line('item_home')); 
	$this->item->showContact($acontacts, $k); 
	$this->item->showExperiences($experiences, $k);
?>