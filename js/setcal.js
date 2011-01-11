// <?php !! This fools editor ...  ?>
// <SCRIPT LANGUAGE="JavaScript">

function setupCalendar1() {
    Calendar.setup({
        inputField     :    "f_date_b",      // id of the input field
        ifFormat       :    "%d.%m.%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "f_trigger_b",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1,               // show all years in drop-down boxes (instead of every other year as default)
        firstDay	: 0
    });
}

function setupCalendar2() {
    Calendar.setup({
        inputField     :    "st_date",      // id of the input field
        ifFormat       :    "%d.%m.%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "st_trigger",   // trigger for the calendar (button ID)
        singleClick    :    false,           // double-click mode
        step           :    1,               // show all years in drop-down boxes (instead of every other year as default)
        firstDay	: 0
    });
    Calendar.setup({
        inputField	: "en_date",      
        ifFormat	: "%d.%m.%Y",       
        showsTime	: false,            
        button		: "en_trigger",   
        singleClick	: false,           
        step		: 1,             
        firstDay	: 0
    });
}

// </SCRIPT>