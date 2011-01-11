<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_birth extends browse_iluni {

	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(1=>"ID", 2=>'Name', 3=>'Kelahiran',
			4=>'Tanggal', 5=>'Bulan', 6=>'Tahun', 7=>'Hari') 
			+ $this->comySelect + $this->sourceSelect;
		$this->tableName = 'Birth Date';
		$this->months = array (
			1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 
			5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 
			9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember' );
		$this->days = array(1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis",
			5 => "Jumat", 6 => "Sabtu", 0 => "Minggu");  // ISO 8601, Firebird, not mysql
	} // constructor

	private function selectMonthList($init) { 
		$buffer='';			
		$buffer .="\t\t".'<option value=""';   
		if (!isset($init))	{ $buffer .= " selected"; }	
		$buffer .=">Semua</option>\n";

		$buffer .= $this->SelectAList($init, $this->months);
		return $buffer;		  
	}

	protected function doFilterSelect() {
		$this->selectCommunity();  
		$this->selectSource();
		$monthselect = $this->selectMonthList($this->input->post('monthby'));
?>
	<br/>Bulan
		<select name="monthby" class="inputbox">
		<?=$monthselect;?>
		</select>
<?php
	}
	
	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Nama Lengkap</th>
	    <th nowrap align="center">Community</th>
	    <th nowrap>Tanggal Lahir</th>
	    <th nowrap>Hari</th>
	    <th nowrap>Tanggal</th>
	    <th nowrap>Bulan</th>
	    <th nowrap>Tahun</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="20%" align="left"><?php echo $this->ref->alumna($row);?></td>
	    <td width="8%" align="center"><?php echo $row->COMMUNITY;?></td>
	    <td width="20%" align="center"><?php echo substr($row->BIRTHDATE, 0, 10);?></td>
	    <td width="15%" align="center"><?php echo $this->days[$row->HARI];?></td>
	    <td width="10%" align="center"><?php echo $row->TANGGAL;?></td>
	    <td width="15%" align="center"><?php echo $this->months[$row->BULAN];?></td>
	    <td width="10%" align="center"><?php echo $row->TAHUN;?></td>
	<?php }	
	
	function getTitle(&$row) { return $this->ref->salute($row).' '.$row->NAME; }
} // class

?>