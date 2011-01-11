<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

abstract class browse_base extends Model {	// Generic Browser
	public $task = ""; 	//protected
	
	/** @var datasource related */
	public $rows = null;
	
	/** @var form selection: order, filter, group */
	protected $orderSelect		= null;
	protected $groupSelect	= null;

	/** @var accessories */
	protected $tableName		= '';
	protected $groupingID		= null;
	private $isGrouping = false;
	
	/** @var link */
	protected $sheets	=	array();		

	// Force Extending class to define this method
	abstract protected function doRow(&$row);	
	/** Forward declaration */
	// doFilterSelect(), doTableHeader(), doTableFooter, getGroupStr(&$row), 
	// doParam(), belowHeader(), getTitle
	
	function __construct () {
	  parent::__construct(); // inherited constructor	  

// --- HTML initialization
	  $this->textOrder = 'Urutkan tampilan'; //todo: masukin ke language
	  $this->textFilter = 'Saring tampilan'; //todo: masukin ke language
	  $this->textGroup = 'Gabungan, lalu jumlahkan'; //todo: masukin ke language
	} // constructor

	// --- HTML Methods
	public function show() {
		$this->load->view('browse/header'); 	
		
	  $this->doSelectionForm();
	  if (method_exists($this, 'belowHeader')) { $this->belowHeader(); }	  

		$this->doTableName();
//	  if (method_exists($this, 'doParam')) { $this->doParam(); }

		$this->isGrouping=method_exists($this, 'getGroupStr');	// prevent call to abstract
		$isRowTitle=method_exists($this, 'getTitle');		// prevent call to abstract

		for ($i=0, $n=count( $this->rows ); $i < $n; $i++) { 
			$row = &$this->rows[$i]; 

			if ($i==0) $this->tableHead($row); 
			elseif ($this->isGrouping) $this->checkGrouping($row); 

			$title = ($isRowTitle) ? ' title="'.$this->getTitle($row).'"' : ""; 
			echo "\t  <tr ".'class="sectiontableentry'.(($i%2==1)? "1":"2").'"'.$title.">\n\t  ";
	?>  <td width="2%" align="center"><?php echo $i+1; ?></td>
	    <?php $this->doRow($row); /* call abstract */ ?>	
	  </tr>
	<?php 
			if ($i==$n-1) $this->tableFoot(); 	
		} 
	} // show
	
	/* $row = first row in rows, reserved argument for inheritance */
	protected function tableHead(&$row) { 
	  if ($this->isGrouping) {
	    $this->groupStr = $this->getGroupStr($row);
	    echo '<i>'.$this->groupStr.'</i>';
	  }
	?>  
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="contenttoc">
	  <thead>
	  <tr class="sectiontableheader">
	    <th width="20">#</th>
	    <?php $this->doTableHeader(); /* call abstract */ ?>
	  </tr>
	  </thead>
	  <tbody>
	<?php }	
	
	protected function tableFoot() { ?>
	  </tbody>
	<?php if (method_exists($this, 'doTableFooter')) { ?>
	  <tfoot>
	  <tr class="sectiontableheader">
	    <td></td>
	    <?php $this->doTableFooter(); /* call abstract */ ?>
	  </tr>
	  </tfoot>
	<?php } ?>
	  </table>
	  <br/>
	<?php }	

	private function checkGrouping(&$row) {
	  if ($this->groupStr <> $this->getGroupStr($row)) {
	    $this->tableFoot();
	    $this->tableHead($row);
	  }
	}
	
	protected function selectAList($init, $array) { 
		$buffer='';	
		foreach($array as $k=>$v) {
			$buffer .= '<option value="'.$k.'"';
			if ( (isset($init)) && ($init==$k) ) { $buffer .= " selected"; }
			$buffer .= ">".$v."</option>\n"; 
		}
		return $buffer;
	}
	
	private function doSelectionForm() { 
		$isForm = FALSE;				 

		$data['isorder']		=	(bool)$this->orderSelect;
		if ($this->orderSelect) { 			
			$isForm = TRUE; 			
			$data['textorder']	=	$this->textOrder;
			$data['orderby']		=	$this->SelectAList($this->input->post('orderby'), $this->orderSelect);
		}		

		$data['isgroup']		=	(bool)$this->groupSelect;
		if ($this->groupSelect) { 
			$isForm = TRUE; 			
			$data['textgroup']	=	$this->textGroup;
			$data['groupby']		=	$this->SelectAList($this->input->post('groupby'), $this->groupSelect);
		}

		$data['isfilter'] = method_exists($this, 'doFilterSelect');	/* prevent abstract methods */
		if ($data['isfilter']) { 						
			$data['textfilter']	=	$this->textFilter;

			ob_start();
			$this->doFilterSelect();				
			$data['filter']		=	ob_get_contents();
			ob_end_clean();				
			
			if (!empty($data['filter']))	$isForm = TRUE; 
		}

		$data['task'] = $this->task;
		$data['isform']	=	$isForm;		
		
		if ($isForm)	$this->load->view('browse/selectionform', $data);
	} // form	


	protected function selectDBList($ID, $field, $init, $undef = null) {
		$buffer='';
		
		$ID = strtoupper($ID);
		$field = strtoupper($field);

		$buffer .= "\t\t".'<option value=""';   
		if (!isset($init))	{ $buffer .= " selected"; }	
		$buffer .= ">Semua</option>\n";
	  
		if (isset($undef)) {
			$buffer .= "\t\t".'<option value="'.$undef.'"'; 
			if ($init==$undef)	{ $buffer .= " selected"; }	
			$buffer .= ">undefined</option>\n";
		} 

		# Load the query from database
		$query = $this->db->query("SELECT $ID, $field FROM $field");
		$rows = $query->result_array();

		foreach($rows as $row) {
			$buffer .= "\t\t".'<option value="'.$row[$ID].'"';
			if ( (isset($init)) && ($init==$row[$ID]) ) { $buffer .= " selected"; }
			$buffer .= ">".$row[$field]."</option>\n"; 
		}
	
		return $buffer;	
	}
	
	protected function doTableName() { 
		$data['task']	= $this->task;
		$data['tablename']	= $this->tableName;
		$data['sheets']	= $this->sheets;		
		$this->load->view('browse/tablename', $data);
	}	
} // class	
?>