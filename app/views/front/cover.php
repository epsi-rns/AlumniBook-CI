<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed');	
?>
  	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
		xajax_showLeftMenu();	
    //]]>
	</SCRIPT>
<br>

    <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
		<tr>
			<td width="50%" valign="top" class="contentdescription">
			<div class="componentheading"><font size=+2>C</font>ommunity</div>
			Pilih tabel community:</td>
			<td width="50%" valign="top" class="contentdescription">
			<div class="componentheading"><font size=+2>D</font>ata Entry</div>
				Mengubah Data:</td>				
		</tr>	
      <tr>
		<td><ul>
<?php	foreach($covermenus[0] as $task=>$text): ?>
				<li><a href="main/browse/<?=$task;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>			
		</ul></td>
			<td><ul>
				<li><a href="person.html">Manage Alumni</a></li>
				<li><a href="org.html">Manage Organizations</a></li>				
			</ul></td>		
      </tr>
      <tr>
		<td width="50%" valign="top" class="contentdescription">
		<div class="componentheading"><font size=+2>A</font>lumni</div>
		Pilih tabel alumni:</td>
		<td width="50%" valign="top" class="contentdescription"">
		<div class="componentheading"><font size=+2>O</font>rganisasi</div>
		Pilih tabel organisasi:</td>
      </tr>
      <tr>
		<td>
		<img src="./images/people.gif" border="0" align="left">
		<ul>
<?php	foreach($covermenus[1] as $task=>$text): ?>
				<li><a href="main/browse/<?=$task;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>			
		</ul></td>
		<td><ul>
<?php	foreach($covermenus[2] as $task=>$text): ?>
				<li><a href="main/browse/<?=$task;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>			
		</ul></td>
      </tr>
      <tr>
		<td width="100%" colspan="2" valign="top" class="contentdescription">
		<div class="componentheading"><font size=+2>J</font>ob and Occupation</div>
		Pilih tabel pekerjaan:</td>
      </tr>
      <tr>
		<td><ul>
<?php	foreach($covermenus[3] as $task=>$text): ?>
				<li><a href="main/browse/<?=$task;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>			
		</ul></td>
      </tr>
<?php if($this->auth->checkSession())	:	?>
		<tr>
			<td width="100%" colspan="2" valign="top" class="contentdescription">
			<div class="componentheading"><font size=+2>U</font>ser</div>
				Administration:</td>
		</tr>
		<tr>
			<td>
			<img src="./images/users.png" border="0" align="left">			
			<ul>
<?php	foreach($covermenus[10] as $task=>$text): ?>
				<li><a href="user/<?=$task;?>.html"><?=$text;?></a></li>
<?php endforeach; ?>	
<?php if($this->session->userdata('group')=='admin')	:	?>
				<li><a href="users/manage.html">Manage Users</a></li>
<?php endif; ?>
			</ul></td>
		</tr>
<?php endif; ?> 
    </table>

  <q>Data ini terakhir di-update tanggal <blink><?=$lastupdate;?></blink>.</q>