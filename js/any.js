// <?php !! This fools editor ...  ?>
// <SCRIPT LANGUAGE="JavaScript">

/*  Epsiarto Rizqi Nurwijayadi, 2007  |  www.citrajaya.net
 * -----------------------------------------------------------
 *
 * Provide miscellanous simple script needed in some pages
 */


function menuToggle() {
    var el = document.getElementById("leftmenu");
    if (el.style.display == 'block') {
	el.style.display = 'none';
	document.getElementById("leftdoc").style.width = '20px';
	document.getElementById("pathway").style.left = '-20px';
	document.getElementById("menuControl").innerHTML = ' show menu ';
    } else {
	el.style.display = 'block';
	document.getElementById("leftdoc").style.width = '152px';
	document.getElementById("pathway").style.left = '-152px';
	document.getElementById("menuControl").innerHTML = ' hide menu ';
    }
}

var oldLink = null;

// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  
	if (link != null) {
		if (oldLink) oldLink.style.fontWeight = 'normal';
		oldLink = link;
		link.style.fontWeight = 'bold';
	}	

  setCookie("theme", title, null, "/");
  
  return false;
}


    // Sets cookie values. Expiration date is optional
    function setCookie(name, value, expires, path) 
    {
        strCookie = name + "=" + escape(value)
			+ ((expires) ? "; expires=" + expires.toGMTString() : "")
			+ ((path) ? "; path=" + path : "");

        document.cookie = strCookie;
    }

    function getCookie(Name) 
    {
        var search = Name + "="
        if (document.cookie.length > 0) { 
            // if there are any cookies
            offset = document.cookie.indexOf(search)
            if (offset != -1) { 
                // if cookie exists
                offset += search.length

                // set index of beginning of value
                end = document.cookie.indexOf(";", offset)

                // set index of end of cookie value
                if (end == -1)
                    end = document.cookie.length

                return unescape(document.cookie.substring(offset, end))
            }
        }
    }

// </SCRIPT>
