<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include('item_base.php');

class item_org extends item_base {
	function __construct () {
	  parent::__construct(); // inherited constructor				
	}

	public function showOtherOrg (&$orgs, &$k, $text) {
	  if (!empty($orgs)) { foreach ($orgs as $org) { 
	      $this->showRowValue ("<strong>".$this->ref->org($org)."</strong>", $k, $text); 
	  }} 
	}

	public function showParent (&$parents, &$k)	
		{ $this->showOtherOrg ($parents, $k, $this->lang->line('item_parentorg')); } // notice: might using multiple rows;
		
	public function showBranch (&$branches, &$k)	
		{ $this->showOtherOrg ($branches, $k, $this->lang->line('item_branchorg')); }
		
	public function showProduct (&$one, &$k)	
		{ $this->showChkRowValue ($one->PRODUCT, $k, $this->lang->line('item_product')); }
} // end of class

?>