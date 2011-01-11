<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
	$this->item->showProduct($one, $k); 
	$this->item->showField($fields, $k); 
	$this->item->showParent($parents, $k); 
	$this->item->showBranch($branches, $k); 
	$this->item->showAddress($offices, $k, $this->lang->line('item_office'));
	$this->item->showContact($ocontacts, $k);	  
?>