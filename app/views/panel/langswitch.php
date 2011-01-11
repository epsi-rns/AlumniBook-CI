<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php			
	function getLangRef($lang) {
		switch ($lang) { 
		case 'id':	
			$langid = "id";
			$alt	= "Bahasa Indonesia";
			$title	= "Pilih Bahasa Indonesia";
			break;
		default:	
			$langid = "en";		
			$alt	= "English";		
			$title	= "Select English Language";	
		}
		$bilder	= "images/flag/${langid}.gif";		
		$langjs = 'document.langForm.lang.value="'.$langid.'"; document.langForm.submit();';

		$img = "
			<img src='${bilder}' 
			class='flag' border='1' alt='${alt}' title='${title}'> 
		";
		$imgref	= "<a onclick='${langjs}'>${img}</a>";
		return $imgref;
	}	
?>

	<form name ="langForm" method="POST">
	<input type="hidden" name="lang"/>
<?php 
	/* not index ? */ 
	$config =& get_config();
	$imgref = ($config['language']=='english') ? getLangRef('id') : getLangRef('en');
?>
	<br/><div class="clr"></div>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">	
	<tr>
	  <td align="right"><?=$imgref;?></td>
	  <td>&nbsp;</td>	  
	</tr>
	</table>

	</form>
	<br/>&nbsp;	
