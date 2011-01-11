<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 	
	require_once 'Spreadsheet/Excel/Writer.php';	

abstract class sheet_base extends Model {	// General Tabellenkalkulation
//	public $task = ""; 	//protected
	
	/** @var datasource related */
	public $rows = null;
	protected $rownum = 0;

	/** @var Tabellenkalkulation related */
	protected $wb;	// workbook
	protected $ws;	// worksheet
	protected $xlFormat;	
	protected $zeile = 3;	// row cursor
	
	/** @var form selection: order, filter, group */
	public $orderby;

	/** @var accessories, einstellungen */
	protected $titles;				// titel
	protected $buchName;	
	protected $blattName;	
	protected $sheetTitle;		// blatt titel
	protected $groupStr		= null;
	protected $allowedGroupID = null;

	/** @var tabelle datum und uhrzeit */	
	private $seconds_in_a_day = 86400;		// number of seconds in a day
	private $eight_hours = 28800; 				// fix -- $seconds_in_a_day / 3;
	
	// Force Extending class to define this method
	abstract protected function doRow(&$row);	
	/** Forward declaration */
	protected function vorFormat() {}	
	protected function getGroupStr(&$row) { return null; }
	
	function __construct () {
		parent::__construct(); // inherited constructor	  
		$this->wb = new Spreadsheet_Excel_Writer();		
		$this->xlFormat	=& $this->xlFormat();
	} // constructor

	// --- Tabelle Methode
	public function show() {
		// Blatt Hinzufugen
		$this->ws =& $this->wb->addWorksheet($this->blattName);		
		
		$this->ws->write(0, 0, $this->sheetTitle, $this->xlFormat['name']);
		$this->ws->mergeCells(0, 0, 0, count($this->titles)-1);
		$this->ws->setRow(0, 20, $this->xlFormat['name']);		
		
		$this->vorFormat();
		
		if (!in_array($this->orderby, $this->allowedGroupID )) 		
			$this->BandHeader();			
		
		for ($i=0, $n=count( $this->rows ); $i < $n; $i++) { 
			$row = &$this->rows[$i]; 
			$this->rownum = $i;
			
			$this->checkGrouping($row); 
			
			$this->doRow($row); /* call abstract */ 
			$this->zeile++;
			
			if ($i==$n-1) $this->BandFooter();
		}
		
		// sending HTTP headers
		$this->wb->send($this->buchName);	
	
		// We still need to explicitly close the workbook
		$this->wb->close();			
	}	
	
	// -- Band Related - Methode
	private function checkGrouping(&$row) {
		$newGroupStr = $this->getGroupStr($row);
		if ($this->groupStr <> $newGroupStr) {
			$this->groupStr = $newGroupStr;

			if ($this->rownum != 0)	
				$this->BandFooter();

			$this->BandGroup();
			$this->BandHeader();
		}
	}	
	
	protected function BandGroup() {
		$this->ws->writeString($this->zeile, 0, $this->groupStr, $this->xlFormat['group']);	
		$this->ws->mergeCells($this->zeile, 0, $this->zeile, 1);
		$this->zeile++;
	}
	
	protected function BandHeader() {
		foreach($this->titles as $i=>$title)
			$this->ws->write($this->zeile, $i, $title, $this->xlFormat['title']);	
		$this->zeile++;
	}
	
	protected function BandFooter() {
		for ($i = 0; $i <= count($this->titles)-1; $i++) 
			$this->ws->writeBlank($this->zeile, $i, $this->xlFormat['footer']);		
		$this->zeile++;
	}		
	
	// Miscellanous
	protected function xlFormat() {	
		$xlAccFmt   		= '[$-421]_(Rp* #,##0.00_);_(Rp* (#,##0.00);_(Rp* "-"??_);_(@_)';
		$xlDateFmt  	= '[$-421]dd mmmm yy;@';
		$xlMonthFmt	= '[$-421]mmm-yyyy;@';	

		$name		=	array(	'Size'	=> 16,	'Bold'	=> 1,	'Color'	=> 'navy'	);
		$title		= array(	
				'Size'	=> 12,	'Bold'	=> 1,	'Align'	=> 'center',	'FgColor'	=> 'cyan',
				'Bottom'	=> 2, 'Top'	=>	1,	'bordercolor'	=>	'navy');
		$mast		= $title + array(	'Italic'	=> 1,	'Color'	=> 'green'	);
		$group		= array(	'Size'	=> 13,	'Bold'	=> 1,	'Align'	=> 'right',	'Color'	=> 'navy',	'FgColor'	=> 'yellow'	);
		$rupiah	= array(	'NumFormat'	=> $xlAccFmt	);
		$date		= array(	'NumFormat'	=> $xlDateFmt	);
		$footer	= array( 'Top'	=>	1,	'bordercolor'	=>	'navy' );
		$total		= $footer + $rupiah + array(	'Bold'	=> 1,	'Underline'	=> 2	);	
		$title2		= array(	'Italic'	=> 1,	'Bottom'	=> 2, 'bordercolor'	=>	'navy');		
		$title2date = $date + $title2;
		$title3		= $title2 + array(	'Size'	=> 11, 'Bold'	=>	1	);
		
		$format = array();
		$vars = array ('name', 'title', 'mast', 'group', 'total', 'rupiah', 'date', 'footer', 'title2', 'title2date', 'title3');
		foreach ($vars as $var)
			$format[$var]	=& $this->wb->addFormat($$var);

		return $format;
	}
	
	function fb2xlDate($fbdate) {
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $this->seconds_in_a_day * 25569;		

		$unixtime = strtotime($fbdate) + $this->eight_hours; // fb2xl fix, careful with this trick!!
		return ($unixtime + $ut_to_ed_diff) / $this->seconds_in_a_day;		
	}	
} // class	
?>