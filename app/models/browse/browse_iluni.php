<?php 
/** Iluni DB @version 0.1.6 @package Iluni Database **/

if (!defined('BASEPATH')) exit('No direct script access allowed'); 
include('browse_base.php');

abstract class browse_iluni extends browse_base {

	function __construct () {
	  parent::__construct(); // inherited constructor
	
	  $this->comySelect = array(""=>'----------', 11=>"Community", 12=>'Angkatan', 13=>'Department', 14=>'Program');
	  $this->sourceSelect = array(""=>'----------', 19=>"Source");
	} // constructor


	protected function getGroupStr(&$row) { 
		switch ($this->input->post('orderby')) {
			case 2: $result = strtoupper(substr($row->NAME, 0, 1)); break; 
			case 42: $result = strtoupper(substr($row->ORGANIZATION, 0, 1)); break; 
			case 11: $result = $row->COMMUNITY; break; 
			case 12: $result = $row->ANGKATAN; break; 
			case 13: $result = $row->DEPARTMENT; break; 
			case 14: $result = $row->PROGRAM; break; 
			case 19: $result = $row->SOURCE; break; 
			case 22: $result = $row->PROPINSI; break; 
			case 23: $result = $row->WILAYAH; break; 
			default: $result ='';
		}

		return $result;
	}

	protected function selectCommunity() { 	
		$arr = array('0'=>"", '1960'=>'196x', '1970'=>'197x', '1980'=>'198x', '1990'=>'199x', '2000'=>'200x');
		$deptby	= $this->selectDBList('DepartmentID', 'Department', $this->input->post('deptby'), -1);
		$progby	= $this->selectDBList('ProgramID', 'Program', $this->input->post('progby'), -1);
		$decade	= $this->selectAList($this->input->post('decade'), $arr);
		$yearby	= $this->input->post('yearby');	

		$data = array( 'selectname'=>'community',
			'deptby'=>$deptby,	'progby'=>$progby,	'decade'=>$decade, 'yearby'=>$yearby	);
		$this->load->view('browse/iluni_filterselect', $data);
	}

	protected function selectSource() { 
		$data['selectname'] = 'source';
		$data['source'] = $this->selectDBList('SourceID', 'Source', $this->input->post('source'), -1);
		$this->load->view('browse/iluni_filterselect', $data);
	}
	
	protected function selectLDate() {
		$data = array( 'selectname'=>'lastupdate', 'lastupdate'=> $this->input->post('lastupdate')	);
		$this->load->view('browse/iluni_filterselect', $data);		
	}	

	protected function selectAlpha() { 
		$url = "main/browse/".$this->task.".html";
		$data = array( 'selectname'=>'alpha', 'alpha'=> $this->input->post('alpha'), 'url'=>$url);
		$this->load->view('browse/iluni_filterselect', $data);					
	}	
	
	protected function selectName() { 
		$data['selectname'] = 'suchen';
		$data['suchen'] = $this->input->post('name');
		$this->load->view('browse/iluni_filterselect', $data);
	}	
} // class	
?>