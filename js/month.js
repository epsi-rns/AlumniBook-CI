// <?php !! This fools editor ...  ?>
// <SCRIPT LANGUAGE="JavaScript">

	function writeMonthHTML() {  // pure html include
		myLongString =	    '<div class="calendar" style="float: left; clear: both;">\n'
			+ '  <table cellspacing="0" cellpadding="0" id="monthTable">\n'
			+ '    <thead>\n'
			+ '      <tr>\n'
			+ '	<td class="button" onclick="showInfo();">?</td>\n'      
			+ '	<td class="button nav" onClick=moveYearClick(-1)>&#x2039;</td>\n'
			+ '	<td class="button title" colspan="10">Select Month:</td>\n'	
			+ '	<td class="button nav" onClick=moveYearClick(1)>&#x203a;</td>\n'
			+ '      </tr>\n'
			+ '    </thead>\n'
			+ '  </table>\n'
			+ '</div>\n'  
		document.write(myLongString);
	}
  
    function showInfo() {	 
		myAbout = "DHTML Month Selector\n\n" 
			+ "- Click on any of the month\n"	 
			+ "- Use the " + String.fromCharCode(0x2039) + ", " 
			+ String.fromCharCode(0x203a) + " buttons to select year.";
		alert(myAbout);  
    }     

    function init() {
     	var today = new Date();
     	Year = today.getFullYear();
		defaultYear = Year;		   
		var myYear = document.getElementById("myYear");
		myYear.innerHTML=Year;
    }
     
    function getMyYear() {	
       var myYear = document.getElementById("myYear");
       return parseInt(myYear.innerHTML); 
    }     

    function moveYearClick(increment) {
		Year = getMyYear();  	
        Year += increment;
        if (Year < defaultYear-7) { Year = defaultYear + 7; }
        if (Year > defaultYear+7) { Year = defaultYear - 7; }
		myYear.innerHTML=Year;		        
    }
     
    function printDate(date) {
	   var m = date.getMonth();
	   var d = date.getDate();
	   var y = date.getFullYear();
	   var sd = (d < 10) ? ("0" + d) : d;
	   var sm = (m < 9) ? ("0" + (1+m)) : (1+m);
	   return sd+'.'+sm+'.'+y;       	
    }     
	 
    function updateDate(date1, date2) {
		with (document.alumniForm) { 
			stdt.value = printDate(date1);
			endt.value = printDate(date2);		 		 	 	
		}  
    }
    
    function monthClick(evt) {
        myMonth = Calendar.getTargetElement(evt).id;
	Year = getMyYear();
	    
        totalDays = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (Year % 4 == 0) { totalDays[1] = 29; }		    
		lastDay = totalDays[myMonth];		      	
     	
     	var theDate1 = new Date(Year, myMonth, 1); 		
     	var theDate2 = new Date(Year, myMonth, lastDay);
		updateDate(theDate1, theDate2);        
    }    
	 
    function yearClick(evt) {
        Year = getMyYear();     	
     	var theDate1 = new Date(Year, 0, 1);
     	var theDate2 = new Date(Year, 11, 31);
		updateDate(theDate1, theDate2);     	
    }	 
   
    function toggleMonth(evt) {
        var border = (evt.type=="mouseover") ? 1 : 0;
	f = Calendar.getTargetElement(evt);   
	f.style.border=border+"px solid #bbb";	
    }     
   
    function writeMonths() {
		var aTable = document.getElementById('monthTable');  
		var aTBodyElement = document.createElement('tbody');     	 
		aTable.appendChild(aTBodyElement);    		 
		var aRow = document.createElement('tr');     	 
		aTBodyElement.appendChild(aRow);    		 

		var aYearElement = document.createElement('td');
		aRow.appendChild(aYearElement);    		 
		with (aYearElement) {
			className= "day wn";		
			id= "myYear";			
		}
		Calendar.addEvent(aYearElement, "click", yearClick);
              
		var myMonthStr = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');       	        
		for (i = 0; i < myMonthStr.length; i++) {
			el = aRow.insertCell(i+1);
			with(el) {
				className= "day";
				innerHTML = myMonthStr[i];
                                id = i+1;
			}
                        Calendar.addEvent(el, "click", monthClick);
			Calendar.addEvent(el, "mouseover", toggleMonth);
			Calendar.addEvent(el, "mouseout", toggleMonth);			 			
		}     
    }
     
    writeMonthHTML(); 
    writeMonths();
	init();     
	
// </SCRIPT>	