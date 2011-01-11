<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include("browse_iluni.php");

class browse_field extends browse_iluni {
	function __construct () {
		parent::__construct(); // inherited constructor

		$this->orderSelect = array(41=>"ID", 42=>'Organisasi', 43=>'Produk', 44=>'Bidang Usaha');
		$this->tableName = 'Bidang Usaha';
	} // constructor

	protected function doTableHeader() { ?>
	    <th align="left" nowrap>Organisasi</th>
	    <th nowrap align="left">Bidang Usaha</th>
	    <th nowrap align="left">Keterangan Bidang Usaha</th>
	    <th nowrap align="left">Produk</th>
	<?php }

	protected function doRow(&$row) { ?>
	    <td width="30%" align="left"><?php echo $this->ref->org($row);?></td>
	    <td width="20%" align="left"><?php echo $row->FIELD;?></td>
	    <td width="20%" align="left"><?php echo $row->DESCRIPTION;?></td>
	    <td width="20%" align="left"><?php echo $row->PRODUCT;?></td>
	<?php }
} // class

?>