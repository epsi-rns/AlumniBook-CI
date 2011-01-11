<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_org extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(41=>"ID", 42=>'Organisasi', 43=>'Produk', 44=>'Cabang');
		$this->tableName = 'Organisasi';
	} // constructor

	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Organisasi</th>
	    <th nowrap align="left">Produk</th>
	    <th nowrap align="center">Cabang</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="40%" align="left"><?php echo $this->ref->org($row);?></td>
	    <td width="30%" align="left"><?php echo $row->PRODUCT;?></td>
	    <td width="0%" align="center"><?php 
		switch ($row->HASBRANCH) {
		  case 'T': echo "Ada"; break;
		  case 'F': echo "Tidak ada"; break;
		}
	    ?></td>
	<?php }
} // class

?>