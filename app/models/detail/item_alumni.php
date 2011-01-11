<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	include('item_base.php');

class item_alumni extends item_base {
	function __construct () {
	  parent::__construct(); // inherited constructor		
	}

	public function showCompy (&$rows, &$k) {
	  foreach ($rows as $compy) { 
		$this->showRowValue($this->ref->competency($compy), $k, $this->lang->line('item_competency'), $this->lang->line('same_competency'));
	  }
	}

	public function showCerti (&$rows, &$k) {
	  foreach ($rows as $certi) { 
		$this->showRowValue($this->ref->certification($certi), $k, $this->lang->line('item_certification'));	  }
	}

	public function showExperiences (&$experiences, &$k)	
	{ $this->showChkRowsFunc($experiences, $k, 'experiences', $this->lang->line('item_experience')); }

	public function showGender (&$one, &$k) {
		if (!empty($one->GENDER)) 
		{ $this->showChkRowValue (
			($one->GENDER=='M') ? $this->lang->line('gender_male') : $this->lang->line('gender_female'), 
			$k, $this->lang->line('item_gender')); }
	}

	public function showTitle (&$one, &$k) {
	  if ( (!empty($one->SHOWTITLE)) || $this->showEmpty ) { 
	    if ($one->SHOWTITLE == 'T') {
	      if (!empty($one->PREFIX)) {$title = $one->PREFIX;} 
	      if (!empty($one->SUFFIX)) {$title = empty($title) ? $one->SUFFIX : $title.', '.$one->SUFFIX;}
	    } else $title="";
	    $this->showChkRowValue ($title, $k, $this->lang->line('item_title')); 
	  }
	}

	public function showBirth (&$one, &$k) {
	  if (!empty($one->BIRTHPLACE))	$items[] = $one->BIRTHPLACE;
	  if (!empty($one->BIRTHDATE))	$items[] = $this->getTanggal($one);
	  $text = (empty($items)) ? "" : implode(', ', $items);
	  $this->showChkRowValue ($text, $k, $this->lang->line('item_birthplacedate')); 
	}

	private function getTanggal (&$one) { 
	  $arrBulan = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 
		5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
                9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

	  $arrHari = array(1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis",
		5 => "Jumat", 6 => "Sabtu", 0 => "Minggu");  // ISO 8601, Firebird, not mysql

	  return $arrHari[$one->HARI].", ".$one->TANGGAL
		." ".$arrBulan[$one->BULAN]." ".$one->TAHUN;
	}
} // end of class

?>