<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div style="float: right; border: 1px solid #b87; padding: 2px; font-size: 90%; background: #ffb;">
Theme: <a href="javascript:void(0);" onclick="return setActiveStyleSheet(this, 'red_images');">Red</a>
|<a href="javascript:void(0);" onclick="return setActiveStyleSheet(this, 'green_images');">Green</a>
|<a href="javascript:void(0);" onclick="return setActiveStyleSheet(this, 'blue_images');">Blue</a>
	<SCRIPT LANGUAGE="JavaScript">
	//<![CDATA[
		theme = getCookie("theme");
		if (typeof theme == "undefined") {	theme = 'green_images'; }
		setActiveStyleSheet(null, theme);
    //]]>
	</SCRIPT>
</div>
