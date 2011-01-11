/*
+--------------------------------------------------------------------------
|   modalWindow Plugin
|   =============================================
|   by Oliver Trebes
|   (c) 2006 - 2007 amplified webservices
|   =============================================
|   http://www.angelmedia.de
+--------------------------------------------------------------------------
|   > $Date$
|   > $Revision$
|   > $Author$
+--------------------------------------------------------------------------
|   > Filename:     modalWindow.js
|   > Date started: Tue Dec 18 11:49:23 CET 2007
+--------------------------------------------------------------------------
|	Title: Modal Window Plugin
|
|	Please see <copyright.inc.php> for a detailed description, copyright
|	and license information.
+--------------------------------------------------------------------------
|	javascript based on lightbox 1.0:
+--------------------------------------------------------------------------
|	Lokesh Dhakar - http://www.huddletogether.com
|
|	For more information on this script, visit:
|	http://huddletogether.com/projects/lightbox/
|
|	Licensed under the Creative Commons Attribution 2.5 License - 
|	http://creativecommons.org/licenses/by/2.5/
+--------------------------------------------------------------------------
*/

	try {
		if (undefined == xajax.ext)
			xajax.ext = {};
	} catch (e) {
		alert("Could not create xajax.ext namespace");
	}

	try {
		if (undefined == xajax.ext.modalWindow)
			xajax.ext.modalWindow = {};
	} catch (e) {
		alert("Could not create xajax.ext.modalWindow namespace");
	}

	xjxmW = xajax.ext.modalWindow;
	
	var lb_widgets = 0;
	var loadinglayer = 0;
	
	/**
	 * Function getHeight to recieve the height of the element
	 */
	xjxmW.getHeight = function( e )
	{
		if ( e.style.Height )
		{
			return e.style.Height;
		}
		else
		{
			return e.offsetHeight;
		}
	}
	
	/**
	 * Function getWidth to recieve the height of the element
	 */
	xjxmW.getWidth = function( e )
	{
		if ( e.style.Width )
		{
			return e.style.Width;
		}
		else
		{
			return e.offsetWidth;
		}
	}
	
	/**
	 * Function getPageSize to recieve the size of the current window
	 */
	xjxmW.getPageSize = function()
	{
		var xScroll, yScroll;
		
		if (window.innerHeight && window.scrollMaxY) {	
			xScroll = document.body.scrollWidth;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}
		
		var windowWidth, windowHeight;
		if (self.innerHeight) {	// all except Explorer
			windowWidth = self.innerWidth;
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}	
		
		// for small pages with total height less then height of the viewport
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else { 
			pageHeight = yScroll;
		}
	
		// for small pages with total width less then width of the viewport
		if(xScroll < windowWidth){	
			pageWidth = windowWidth;
		} else {
			pageWidth = xScroll;
		}
	
		arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
		return arrayPageSize;
	}
	
	/**
	 * Function getPageSize to recieve the size of the current pagescroll
	 */
	xjxmW.getPageScroll = function()
	{
		var yScroll;
	
		if (self.pageYOffset) {
			yScroll = self.pageYOffset;
		} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
			yScroll = document.documentElement.scrollTop;
		} else if (document.body) {// all other Explorers
			yScroll = document.body.scrollTop;
		}
	
		arrayPageScroll = new Array('',yScroll) 
		return arrayPageScroll;
	}
	
	/**
	 * Function mw:aw add a new modal window
	 */
	xajax.commands['mw:aw'] = function( args )
	{
		lb_widgets++;

		xjxmW.hideSelects( 'hidden' );
		
		var objBody			= document.getElementsByTagName("body").item(0);
		var zIndex			= lb_widgets ? lb_widgets * 1000 : 1000;
		var arrayPageSize	= xjxmW.getPageSize();
		var arrayPageScroll = xjxmW.getPageScroll();
		var objOverlay 		= document.createElement("div");
		
		objOverlay.setAttribute('id','lb_layer' + lb_widgets );
		objOverlay.style.display 	= 'none';
		objOverlay.style.position	= 'absolute';
		objOverlay.style.top		= '0';
		objOverlay.style.left		= '0';
		objOverlay.style.zIndex		= zIndex;
	 	objOverlay.style.width		= '100%';
	 	objOverlay.style.height		= (arrayPageSize[1] + 'px');
	 	objOverlay.style.minHeight	= '100%';
	 	
	 	if ( args.data[1] )
	 	{
	 		objOverlay.style.backgroundColor = args.data[1];
	 	}
	 	
	 	if ( args.data[2] )
	 	{
			if (navigator.appVersion.indexOf("MSIE")!=-1)
			{
				objOverlay.style.filter = "alpha(opacity=" + args.data[2] + ")";
			}
			else
			{
	 			objOverlay.style.opacity = ( args.data[2] / 100 );
			}
	 	}	 	
	 	
	 	if ( args.data[3] )
	 	{
			objOverlay.className = data[3];
	 	}	 	

	 	objBody.appendChild(objOverlay);
		
		var objLockbox = document.createElement("div");
		objLockbox.setAttribute('id','lb_content' + lb_widgets );
		objLockbox.style.visibility	= 'hidden';
		objLockbox.style.position	= 'absolute';
		objLockbox.style.top		= '0';
		objLockbox.style.left		= '0';
		objLockbox.style.zIndex		= zIndex + 1 ;	
		
		objBody.appendChild(objLockbox);
		
		objLockbox.innerHTML = args.data[0];
		
		var objContent = objLockbox.firstChild;
		height	= xjxmW.getHeight( objContent );
		width	= xjxmW.getWidth( objContent );
		
		cltop   = (arrayPageScroll[1] + ( (arrayPageSize[3] -  height ) / 2 ) );
		clleft	= (                     ( (arrayPageSize[0] -  width ) / 2 ) );
		
		objLockbox.style.top  = cltop  < 0 ? '0px' : cltop  + 'px';
		objLockbox.style.left = clleft < 0 ? '0px' : clleft + 'px';
		
		objOverlay.style.display = '';
		objLockbox.style.visibility = '';
	}
	
	/**
	 * Function mw:cw remove the highest modal window
	 */
	xajax.commands['mw:cw'] = function()
	{
		var activewidget = lb_widgets;
		
		xjxmW.hideSelects(''); 
		
		lId = 'lb_layer' + activewidget;
		cId = 'lb_content' + activewidget;
	
		objElement = document.getElementById(cId);
		
		if (objElement && objElement.parentNode && objElement.parentNode.removeChild)
		{
			objElement.parentNode.removeChild(objElement);
		}	
		
		objElement = document.getElementById(lId);
		
		if (objElement && objElement.parentNode && objElement.parentNode.removeChild)
		{
			objElement.parentNode.removeChild(objElement);
			lb_widgets--;
		}
	}
	/**
	 * Function closeWindow is an alias for mw:cw
	 */
	xajax.closeWindow = xajax.commands['mw:cw'];
	
	/**
	 * Function hideSelects hide or show select-boxes expect the top layer
	 * this is an ie6-fix function
	 */
	xjxmW.hideSelects = function( visibility )
	{
		var selects = document.getElementsByTagName('select');
		
		for(i = 0; i < selects.length; i++)
		{
			if ( !selects[i].rel )
			{
				selects[i].rel = 'ddl_' + lb_widgets;
			}
			
			if ( selects[i].rel == 'ddl_' + lb_widgets )
			{
				selects[i].style.visibility = visibility;
			}
			
			if ( visibility != 'hidden' )
			{
				selects[i].rel = null;
			}
		}
	}