<?php 
	/** Trans-Iluni DB @version 0.1.6 @package Trans-Iluni Database **/
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
	<div	style="width:400px;height:400px; font-size: 10px;
			background:#FFFFFF;color:#000000;border:1px solid #999999;padding:5px">
		<a href="javascript:void(0)"	onclick="xajax.closeWindow()"	>
		<img src="./images/closelabel.gif" alt="close" border="0" align="right"></a><br/>

<form method="post" name="modalForm" onsubmit="runQuery(); return false;">

<div>
	<fieldset class="adminform">
	<legend><?=$modaltitle;?></legend>
		<table class="admintable" cellspacing="1">
			<tr>
				<td width="150" class="key"><label>Name Like</label></td>
				<td><input type="text" class="inputbox" name="namesearchquery" value=""></td>
			</tr>			
			<tr>
				<td width="150" class="key"></td>
				<td><input type="button" onclick="runQuery();" value="Run Query" /></td>
			</tr>		
		</table>
	</fieldset>
</div>

<div style="overflow:auto; height:280px;">
<div id="TableID"></div>
</div>

</form>

	</div>