<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

switch($selectname) {
	case 'suchen': ?>
		<input type="hidden" name="name" value="<?=$suchen;?>">
<?php	break;

	case 'source': ?>
		Source
		<select name="source" class="inputbox">
		<?=$source;?>
		</select>&nbsp;<br/>	
<?php	break;

	case 'community': ?>
	Departemen
		<select name="deptby" class="inputbox">
		<?=$deptby;?>
		</select>&nbsp;		
	Program
		<select name="progby" class="inputbox">
		<?=$progby;?>
		</select>&nbsp;	
	Angkatan
		<select name="decade" class="inputbox" 
			onchange="document.alumniForm.yearby.value='';">
		<?=$decade;?>
		</select>&nbsp;
		<input name="yearby" type="text"  class="inputbox" value="<?=$yearby;?>" 
			onchange="document.alumniForm.decade.selectedIndex='0';" />&nbsp;
	<br/>	
<?php	break;

	case 'month': ?>
	<br/>Bulan
		<select name="monthby" class="inputbox">
		<?=$monthby;?>
		</select>		
<?php	break;

	case 'compy': ?>		
	<br/>Kompetensi
		<select name="competency" class="inputbox">
		<?=$compy;?>
		</select>		
<?php	break;

	case 'field': ?>		
	Bidang Usaha
		<select name="field" class="inputbox">
		<?=$field;?>
		</select>	
<?php	break;

	case 'pos': ?>	
	<br/>Pekerjaan
		<select name="position" class="inputbox">
		<?=$post;?>
		</select>
<?php	break;

	case 'occup': ?>	
	<br/>Pekerjaan
		<select name="occup" class="inputbox">
		<?=$occupation;?>
		</select>	
<?php	break;

	case 'lastupdate': ?>	
	  Last Update (after)
	<input type="text" name="lastupdate" id="f_date_b" value="<?=$lastupdate;?>" readonly="1" />
	<button type="reset" id="f_trigger_b">...</button>	
	&nbsp;<br/>
	<script type="text/javascript" src="./js/setcal.js"></script>	
	<script type="text/javascript">
		setupCalendar1();
	</script>
<?php	break;

	case 'alpha': ?>		
		<input type="hidden" name="alpha" value="<?=$alpha;?>">
		<p align="center">|
		  <SCRIPT LANGUAGE="JavaScript">
		  <!--
		    abjad='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    for (i=0; i<26; i++) {
		      if (document.alumniForm.alpha.value == abjad.charAt(i)) {
			document.write(abjad.charAt(i)+'&nbsp;|&nbsp;');
		      } else {
			clstr = "document.alumniForm.alpha.value='"+abjad.charAt(i)+"'; document.alumniForm.submit();";
			document.write('<a href="{URL}#" onclick="'+clstr+'">'+abjad.charAt(i)+'</a>&nbsp;|&nbsp;');
		      }
		    }
		  -->
		  </SCRIPT>
		</p>	
<?php	break;	

} 
?>