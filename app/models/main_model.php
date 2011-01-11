<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class main_model extends Model {
	
	function __construct () { parent::__construct();	}	
	
	public function getLinksMenu() {
		return array(
			0 => array (
				'title'	=> 'Community Summary',
				'item'	=> array('comy'=>'Community', 'tocomy'=>'Total'
					/*, 'ctcomy'=>'Cross Tabulation'*/	)			
			),
			1 => array (
				'title'	=> 'Browse Alumni',
				'item'	=> array('ctcomy'=>'Alumni', 'birth'=>'Birth Day',
					/* exclude	'home'=>'Home', 'acon'=>'Personal Contact,*/
					'compy'=>'Competency', 'certi'=>'Certification')
			),
			2 => array (
				'title'	=> 'Browse Organization',
				'item'	=> array('org'=>'Organization', 'field'=>'Business Field'
					/* exclude	'office'=>'Office', 'ocon'=>'Organization Contact' */	)
			),
			3 => array (
				'title'	=> 'Browse Mapping',
				'item'	=> array('occup'=>'Occupation', 'pos'=>'Job Position',
					'amap'=>'Alumni to <br/>Organization', 'omap'=>'Organization to <br/>Alumni'
					/* exclude	'awaddr'=>'Working Address', 'awcon'=>'Working Contact' */	)
			)
		);
	}

	public function getCoverMenu() {
		$all =  array(
			0 => array (
				'task'	=>	array('comy', 'tocomy'	/*, 'ctcomy'*/	),
				'text'	=>	array('Community', 'Total for each communities'
					/*, 'Communities in cross tabulation'*/ )
			),
			1 => array (
				'task'	=>	array(	'ctcomy', 'compy' ,	'certi', 'birth', 'home', 'acon'	),
				'text'	=>	array(	'Alumni Sederhana', 'Kompetensi', 'Sertifikasi',
					'Tanggal Lahir', 'Rumah', 'Kontak Pribadi'	)
			),
			2 => array (
				'task'	=>	array(	'org', 'field' ,	'office', 'ocon'	),
				'text'	=>	array(	'Organisasi Sederhana', 'Bidang Usaha', 
					'Kantor', 'Kontak Organisasi'	)
			),
			3 => array (
				'task'	=>	array(	'amap', 'omap' ,	'pos',	'owaddr', 'owcon'	),
				'text'	=>	array(	'Alumni -- Organisasi', 'Organisasi -- Alumni', 'Jabatan',
					'Alamat Kerja', 'Kontak Kerja'	)
			),
			10 => array (
				'task'	=>	array('out', 'cpass' ),
				'text'	=>	array('Logout', 'Change Password' )
			)		
		);
		
		foreach($all as $key => $links)
			{	$menus[$key] = array_combine($links['task'], $links['text']);	}
			
		return $menus;	
	}
	
	public function getLastUpdate() {
		$row = $this->db->select_max('Last_Update')->get('Alumni')->row_array();
		return $row['LAST_UPDATE'];  		
	}		
	
	public function getRSS() {
		$sql='SELECT FIRST 5 *
			FROM Alumni A
			INNER JOIN ACommunities AC ON (A.AID=AC.AID)
			WHERE (SOURCEID=11) AND (Community IS NOT NULL)
			ORDER BY Last_Update DESC';		
		return $this->db->query($sql)->result();
	}
	
}	

?>