<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Ref_iluni extends Model {
	private $now;
	
	function __construct () {
		parent::__construct();
		
		$this->now = time();		
	} // constructor	
	

	// --- Common HTML Reference Methods
	protected function testMakeRef($url, $text) {
	  return "\t\t".($this->hideRef ? $text : '<a href="'.$url.'">'.$text."</a>")."\n";
	}

	protected function PastDateImg ($date) {
		$pastdate = round ( ($this->now - strtotime($date)) /  86400 );
		if (($pastdate-15) < 0) {$img='new1.gif';}
		elseif (($pastdate-40) < 0) {$img='new2.gif';}
		elseif (($pastdate-100) < 0) {$img='new3.gif';}

		return isset($img) ? '&nbsp;<img src="images/'.$img.'" border="0"/>' : ""; 
	}
	
	// Shortcut Helper
	public function alumna (&$row) {
		$name = $row->NAME;
		if (isset($row->SHOWTITLE)) { if ($row->SHOWTITLE=='T') {
		  if (isset($row->PREFIX)) {$name = $row->PREFIX." $name";}
		  if (isset($row->SUFFIX)) {$name .= ', '.$row->SUFFIX;}
		}}

		$new = empty($row->LAST_UPDATE) ? "" : $this->PastDateImg($row->LAST_UPDATE); 

		$quiz = "";
		if (isset($row->SOURCEID)) {
		  if ($row->SOURCEID==11) {
		    $quizimg='images/icon/icon_mini_members.gif';
		    $quiz='&nbsp;<img src="'.$quizimg.'" border="0"/>';
		  }
		}

		return "\t\t".'<a href="adet/'.$row->AID.'.html">'.$name."</a>\n\t\t$quiz$new\n";
	}

	public function org(&$row) {
	  $new = empty($row->LAST_UPDATE) ? "" : $this->PastDateImg($row->LAST_UPDATE);
	  return "\t\t".'<a href="odet/'.$row->OID.'.html">'.$row->ORGANIZATION."</a>\n\t\t$new\n";
	}

	public function dept (&$row) {
		return "\t\t".'<a href="alumni/deptby,'.$row->DEPARTMENTID.'.html">'.$row->DEPARTMENT."</a>\n";
	}

	public function prog (&$row) {
		return "\t\t".'<a href="alumni/progby,'.$row->PROGRAMID.'.html">'.$row->PROGRAM."</a>\n";
	}

	public function comy (&$row) {
	  $text = $row->COMMUNITY;
	  if (isset($row->ANGKATAN))	{ $text .=  " - ".$row->ANGKATAN; }
	  if (isset($row->KHUSUS))	{ $text .=  " ($row->KHUSUS)"; }

		$url = 'alumni';
		if (!empty($row->DEPARTMENTID))	$url .= '/deptby,'.$row->DEPARTMENTID;
		if (!empty($row->PROGRAMID))	$url .= '/progby,'.$row->PROGRAMID;
		if (!empty($row->ANGKATAN))	$url .= '/yearby,'.$row->ANGKATAN;

		return "\t\t".'<a href="'.$url.'.html">'.$text."</a>\n";
	}

	public function year (&$row) {
	  if (isset($row->ANGKATAN)) 
	    { $text=$row->ANGKATAN; $ref=$row->ANGKATAN; } 
	  else { $text='undefined'; $ref=-1; }
	
	  return "\t\t".'<a href="alumni/yearby,'.$ref.'.html">'.$text."</a>\n";
	}

	public function field (&$row) {
		$url = 'browse/field/'.$row->FIELDID.'.html';
		$desc = empty($row->DESCRIPTION) ? "" : " (".$row->DESCRIPTION.")";
		return "\t\t".'<a href="'.$url.'">'.$row->FIELD.'</a>'.$desc."\n";
	}

	public function competency (&$row) {
		$url = 'browse/compy/'.$row->COMPETENCYID.'.html';
		$desc = empty($row->DESCRIPTION) ? "" : " (".$row->DESCRIPTION.")";
		return "\t\t".'<a href="'.$url.'">'.$row->COMPETENCY.'</a>'.$desc."\n";
	}

	public function certification (&$row) {  
		return "\t\t".$row->CERTIFICATION.(empty($row->INSTITUTION) ? "" : " (".$row->INSTITUTION.")")."\n";
	}

	public function experiences (&$rows) {
	  if (count($rows)==1) $certies[] = $rows[0]->ORGANIZATION; 
	  else for($i=0, $n=count($rows); $i < $n; $i++) { $certies[] = ($i+1).". ".$rows[$i]->ORGANIZATION; }
	  return "\t\t".implode("<br/>\n", $certies);
	}	

	public function occupation (&$row) { // Occupation
	  $url = 'browse/occup/'.$row->JOBTYPEID.'.html';
	  return "\t\t".'<a href="'.$url.'">'.$row->JOBTYPE.'</a>'."\n";
	}

	public function jobposition (&$row) {
	  $url = 'browse/pos/'.$row->JOBPOSITIONID.'.html';

	  if (!empty($row->FUNGSIONAL)) $items[] = $row->FUNGSIONAL;
	  if (!empty($row->STRUKTURAL)) $items[] = $row->STRUKTURAL;
	  if (!empty($row->DESCRIPTION)) $items[] = $row->DESCRIPTION; 
	  $desc = empty($items) ? "" : ": ".implode(', ', $items); 

	  return "\t\t".'<a href="'.$url.'">'.$row->JOBPOSITION.'</a>'.$desc."\n";
	}

	public function salute(&$row) {
	  switch ($row->GENDER) {
	    case 'M': $salute = 'Bapak'; break;
	    case 'F': $salute = 'Ibu'; break;
	    default: $salute = 'Alumni';
	  }

	  if (isset($row->BIRTHDATE)) {
	    $today = getdate();
	    $birthyear = date('Y', strtotime($row->BIRTHDATE));
	    $diffyear = $today['year'] - $birthyear;

	    if (($diffyear>15) && ($diffyear<35)) {
	      switch ($row->GENDER) {
		case 'M': $salute = 'Abang'; break;
		case 'F': $salute = 'Kakak'; break;
	      }
	    } // diffyear
	  }  
	  return $salute;
	}  // function
} // class		