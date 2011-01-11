<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/

	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
	<nobr>
	<label>Start
		<input type="text" name="stdt" id="st_date" 
			value="<?=$stdt;?>" readonly="1" />
		<button type="reset" id="st_trigger">...</button>	
	</label><wbr>
	<label>End
		<input type="text" name="endt" id="en_date" 
			value="<?=$endt;?>" readonly="1" />
		<button type="reset" id="en_trigger">...</button>	
	</label></nobr>
	<br/>
	<script type="text/javascript" src="./js/setcal.js"></script>	
	<script type="text/javascript">
		setupCalendar2();
	</script>
	<script type="text/javascript" src="./js/month.js"></script>	
	<script type="text/javascript">	
		// rewrite function
	    function updateDate(date1, date2) {	
			with (document.adminForm) { 
				stdt.value = printDate(date1);
				endt.value = printDate(date2);		 		 	 	
		}  
     }
	</script>	 