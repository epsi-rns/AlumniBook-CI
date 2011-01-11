<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class item_base extends Model {
	
	/** @var section table class name */
	public $css = "sectiontableentry";

	/** @var http request */
	public $mode	= null; 
	public $showEmpty	= FALSE; 

	function __construct () {
	  parent::__construct(); // inherited constructor
	} // constructor	

	protected function showRowValue ($onevalue, &$k, $name, $title=null) { ?>
	    <tr class="<?php echo $this->css.($k+1); ?>"
		<?php echo $title ? 'title="'.$title.'">' : '>'; ?>
	      <td nowrap vAlign="top"><?php echo $name; ?></td>
	      <td><?php echo empty($onevalue) ? "-" :  $onevalue;?></td>
	    <tr>
	  <?php $k = 1 - $k; 
	}

	protected function showChkRowValue ($onevalue, &$k, $name, $title=null) { 
	  if (!empty($onevalue) || $this->showEmpty) $this->showRowValue($onevalue, $k, $name, $title); 
	}

	protected function showChkRowsFunc(&$rows, &$k, $func, $name, $title=null) {
	  $value = empty($rows) ? "" : $this->ref->$func($rows);
	  if (!empty($value) || $this->showEmpty) $this->showRowValue($value, $k, $name, $title);	
	} 

	protected function uniqueRows (&$rows) {
	  if (empty($rows)) return null;
	  else {
	    $news = Array();
	    foreach ($rows as $row) {
	      $in_new = FALSE;
	      foreach ($news as $new) { 
		if ($new==$row)
		{ $in_new=TRUE; break; }
	      }
	      if (!$in_new) $news[]=$row;
	    }
	    return $news;
	  }
	}

	public function Contact (&$row) {
	  switch ( $row->CTID ) {
	    case 8: // contact is email site
		if ( preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $row->CONTACT ) )
			{ $contact = $row->CONTACT; } else { $contact=''; }
		$contact = '<a href="mailto:'.$contact.'">'.$row->CONTACT."</a>"; break;
	    case 9: // contact is web site
		if (!eregi( "http.*://", $row->CONTACT )) 
			{ $contact = "http://$row->CONTACT"; } 
		else	{ $contact = $row->CONTACT; }
		$contact = '<a href="'.$contact.'">'.$row->CONTACT."</a>"; break;
	    default: // phone, fax or mobile phone
		$contact = $row->CONTACT; break;
          }
	  return $contact;
	}

	public function rebuildContacts (&$contacts) {
		if (!empty($contacts)) {
			foreach ($contacts as $contact) { $newArr[$contact->CTID][] = $this->Contact($contact); }
				$map = array (
					3	=>	$this->lang->line('contacttype_hp'),
					4	=>	$this->lang->line('contacttype_phone'),
					6	=>	$this->lang->line('contacttype_fax'),
					8	=>	$this->lang->line('contacttype_email'),
					9	=>	$this->lang->line('contacttype_website')	);

				foreach ($newArr as $k => $v) {
					$newObj = new stdClass();
					list($newObj->CTID, $newObj->CONTACT, $newObj->CONTACTTYPE) = array($k, implode(', ', $v), $map[$k]);
					$newArrObj[] = $newObj;
				}

			$contacts = $newArrObj;
		}	
	}

	public function showContact (&$contacts, &$k) {
	  if (!empty($contacts)) { foreach ($contacts as $contact) {
	    $this->showRowValue($contact->CONTACT, $k, $contact->CONTACTTYPE); 
	  }} 
	}

	private function showContactItem (&$contacts, &$k, $ctid, $contactname) {
	  if (!empty($contacts)) { foreach ($contacts as $contact) { 
	    if ($contact->CTID==$ctid) { $items[] = $contact->CONTACT; } 
	  }}
	  $text = empty($items) ? "" : implode(', ', $items);
	  $this->showChkRowValue ($text, $k, $contactname); 
	}

	public function showMobilePhone(&$contacts, &$k)	
		{ $this->showContactItem($contacts, $k, 3, $this->lang->line('contacttype_')); }
	public function showPhone	(&$contacts, &$k)	
		{ $this->showContactItem($contacts, $k, 4, $this->lang->line('contacttype_phone')); }
	public function showFax	(&$contacts, &$k)	
		{ $this->showContactItem($contacts, $k, 6, $this->lang->line('contacttype_fax')); }
	public function showEMail	(&$contacts, &$k)	
		{ $this->showContactItem($contacts, $k, 8, $this->lang->line('contacttype_email')); }
	public function showWebSite	(&$contacts, &$k)	
		{ $this->showContactItem($contacts, $k, 9, $this->lang->line('contacttype_website')); }

	private function excludeContacts (&$contacts, $ctid) {
	  for($i=0, $n=count($contacts); $i < $n; $i++)  { 
	    if ($contacts[$i]->CTID==$ctid) { 
		$items[] = $contacts[$i];
		unset($contacts[$i]);
	    } 
	  }

	  if (isset($items)) $contacts = array_merge($contacts); // reindex;
	  else $items=null;

	  return $items;
	}

	public function excludeMobilePhone(&$contacts)	{ return $this->excludeContacts($contacts, 3); }
	public function excludePhone	(&$contacts)	{ return $this->excludeContacts($contacts, 4); }
	public function excludeFax	(&$contacts)	{ return $this->excludeContacts($contacts, 6); }
	public function excludeEMail	(&$contacts)	{ return $this->excludeContacts($contacts, 8); }
	public function excludeWebSite	(&$contacts)	{ return $this->excludeContacts($contacts, 9); }

	public function showAddress (&$rows, &$k, $text) {
	  if (!empty($rows)) { foreach ($rows as $address) { 
		$value = $address->ADDRESS."<br/>".$address->REGION;
		$this->showRowValue($value, $k, $text);
	  }} elseif ($this->showEmpty) $this->showRowValue('-', $k, $text); 
	}

	public function showMapDetail (&$row, &$k) {
	  $this->showChkRowValue ($this->ref->occupation($row), $k, $this->lang->line('item_jobtype'));
	  $this->showChkRowValue ($this->ref->jobposition($row), $k, $this->lang->line('item_jobposition'), $this->lang->line('same_jobpos')); 
	  if (!empty($jobPos) && !empty($row->DEPARTMENT)) $k = 1 - $k;
	  $this->showChkRowValue ($row->DEPARTMENT, $k, $this->lang->line('item_department'));
	}

	/* Index by community and field */

	public function showCommunity (&$communities, &$k) {
	  if (!empty($communities)) { foreach ($communities as $community) {
	      $this->showRowValue($this->ref->comy($community), $k, $this->lang->line('item_community'), $this->lang->line('same_community')); 
	  }} 
	}

	public function showField (&$rows, &$k) {
	  foreach ($rows as $field) { 
		$this->showRowValue($this->ref->field($field), $k, $this->lang->line('item_field'), $this->lang->line('same_field'));
	  }
	}
} // end of class

?>