<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$suchen = $this->lang->line('search_box');
	$isAuth	= $this->auth->checkSession();	
?>

	<div id="search">
	    <form action="main/browse/alumni.html" method="post" name="suchenForm">	  
	      <input type="text" name="name" value="<?=$suchen;?>" class="inputbox" 
		onchange="document.suchenForm.submit();"
		onfocus="if(this.value=='<?=$suchen;?>') this.value='';" 
	      />
	    </form>
	</div>

	<div id="topmenu">
	    <ul id="mainlevel-nav">
		<li><a href="http://www.iluni.org/" class="mainlevel-nav" >
		<img src="images/icon/icon_mini_login.gif" border="0">
		Iluni.org</a></li>
<?php if($isAuth)	: ?>
		<li><a href="user/out.html" class="mainlevel-nav" >
			<img src="images/icon/icon_mini_login.gif" border="0">
			logout</a></li>			
<?php endif;	?>				
		<li><a href="index.php" class="mainlevel-nav" >
		<img src="images/icon/icon_mini_register.gif" border="0">
		Home</a></li>
	    </ul>
	</div> 
