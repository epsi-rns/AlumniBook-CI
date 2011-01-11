<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
	<SCRIPT LANGUAGE="JavaScript"><!-- 
	function submitbutton(task) {
		var f = document.adminForm;	
		
		if (f.boxchecked.value==0) {
			switch (task) {
				case 'edit'	: alert('Please select from the list to Edit'); break;
				case 'del'	: alert('Please select from the list to Delete'); break;
				default		: submitform( task );
			}
		}	else { submitform( task );	}
	}	
    --></SCRIPT>