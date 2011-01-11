<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>

<br/>

<?php if(isset($message))	: ?>
	<font color="red"><b><?=$message;?></b></font>
	<br/>
<?php endif; ?>

<?php if($task=='in')	: ?>
    <form method="post" action="user/in.html">
		<div class="loginform">
			<label><span>Username:</span>
				<input type="text" name="username"></label><br/>
			<label><span>Password:</span>
				<input type="password" name="password"></label><br/>
			<input type="submit" value="Login"><br/>
		</div>
	</form>
<?php elseif($task=='out')	: ?>
	Logging out <?=$username;?>.<br/>
	Bye..
<?php elseif($task=='cpass')	: ?>
    <form method="post" action="user/cpass.html">
		<div class="loginform">
			<p><label><span>Username:</span>
				<strong><?=$username;?></strong></label></p>
			<p><label><span>Old Password:</span>
				<input type="password" name="password_old"></label></p>
			<p><label><span>New Password:</span>
				<input type="password" name="password_new"></label><br/>
			<label><span>Confirm Password:</span>
				<input type="password" name="password_confirm"></label></p>
			<br/>	
			<label><span>&nbsp;</span>
				<input type="submit" value="Change Password"></label>
		</div>
	</form>
<?php elseif($task=='passchanged')	: ?>	
	Password changed, <?=$username;?>.<br/>
<?php endif; ?>