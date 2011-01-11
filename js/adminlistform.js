// <?php !! This fools editor ...  ?>
// <SCRIPT LANGUAGE="JavaScript">


/* Borrowed from Joomla and modified heavily */

/**
* Joomla! is Free Software
*/

function checkAll( n ) {
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.cb' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	f.boxchecked.value = (c) ? n2 : 0;
}

function isChecked(isitchecked){
	cb = document.adminForm.boxchecked;
	if (isitchecked)	{	cb.value++;	}	else {	cb.value--;	}
}

function submitform(task) {
	var f = document.adminForm;	
	f.task.value = task;	f.submit();
}

/* Borrowed from Joomla and unmodified */

// LTrim(string) : Returns a copy of a string without leading spaces.
function ltrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}

//RTrim(string) : Returns a copy of a string without trailing spaces.
function rtrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;       // Get length of string
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}

// Trim(string) : Returns a copy of a string without leading or trailing spaces
function trim(str) {
   return rtrim(ltrim(str));
}

/**
* Writes a dynamically generated list
* @param string The parameters to insert into the <select> tag
* @param array A javascript array of list options in the form [key,value,text]
* @param string The key to display for the initial state of the list
* @param string The original key that was selected
* @param string The original item value that was selected
*/
function writeDynaList( selectParams, source, key, orig_key, orig_val ) {
	var html = '\n	<select ' + selectParams + '>';
	var i = 0;
	for (x in source) {
		if (source[x][0] == key) {
			var selected = '';
			if ((orig_key == key && orig_val == source[x][1]) || (i == 0 && orig_key != key)) {
				selected = 'selected="selected"';
			}
			html += '\n		<option value="'+source[x][1]+'" '+selected+'>'+source[x][2]+'</option>';
		}
		i++;
	}
	html += '\n	</select>';

	document.writeln( html );
}

/**
* Changes a dynamically generated list
* @param string The name of the list to change
* @param array A javascript array of list options in the form [key,value,text]
* @param string The key to display
* @param string The original key that was selected
* @param string The original item value that was selected
*/
function changeDynaList( listname, source, key, orig_key, orig_val ) {
	var list = eval( 'document.adminForm.' + listname );

	// empty the list
	for (i in list.options.length) {
		list.options[i] = null;
	}
	i = 0;
	for (x in source) {
		if (source[x][0] == key) {
			opt = new Option();
			opt.value = source[x][1];
			opt.text = source[x][2];

			if ((orig_key == key && orig_val == opt.value) || i == 0) {
				opt.selected = true; 
			}
			list.options[i++] = opt;
		}
	}
	list.length = i;
}

/*
**************************************
* Event Listener Function v1.4       *
* Autor: Carlos R. L. Rodrigues      *
**************************************
*/
addEvent = function(o, e, f, s){
	var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
	r[r.length] = [f, s || o], o[e] = function(e){
		try{
			(e = e || event).preventDefault || (e.preventDefault = function(){e.returnValue = false;});
			e.stopPropagation || (e.stopPropagation = function(){e.cancelBubble = true;});
			e.target || (e.target = e.srcElement || null);
			e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
		}catch(f){}
		for(d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false));
		return e = null, !!d;
    }
};

removeEvent = function(o, e, f, s){
	for(var i = (e = o["_on" + e] || []).length; i;)
		if(e[--i] && e[i][0] == f && (s || o) == e[i][1])
			return delete e[i];
	return false;
};

//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com/forms/masked-input [v1.0]

//========================================================
// REQUIRES http://www.jsfromhell.com/geral/event-listener
//========================================================

MaskInput = function(f, m){
	function mask(e){
		var patterns = {"1": /[A-Z]/i, "2": /[0-9]/, "4": /[\xC0-\xFF]/i, "8": /./ },
			rules = { "a": 3, "A": 7, "9": 2, "C":5, "c": 1, "*": 8};
		function accept(c, rule){
			for(var i = 1, r = rules[rule] || 0; i <= r; i<<=1)
				if(r & i && patterns[i].test(c))
					break;
				return i <= r || c == rule;
		}
		var k, mC, r, c = String.fromCharCode(k = e.key), l = f.value.length;
		(!k || k == 8 ? 1 : (r = /^(.)\^(.*)$/.exec(m)) && (r[0] = r[2].indexOf(c) + 1) + 1 ?
			r[1] == "O" ? r[0] : r[1] == "E" ? !r[0] : accept(c, r[1]) || r[0]
			: (l = (f.value += m.substr(l, (r = /[A|9|C|\*]/i.exec(m.substr(l))) ?
			r.index : l)).length) < m.length && accept(c, m.charAt(l))) || e.preventDefault();
	}
	for(var i in !/^(.)\^(.*)$/.test(m) && (f.maxLength = m.length), {keypress: 0, keyup: 1})
		addEvent(f, i, mask);
};

// </SCRIPT>