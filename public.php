<?php
$privacy = 'public';
require_once('conf.php');
//====security checking


//====Load all calendars
$allCals = new C_Calendar('LOAD_PUBLIC_CALENDARS');

//====Load calendar properties
$calendarProperties = $allCals->calendarProperties;

//====Load calendars
$allCalendars = $allCals->allCalendars;

//==== Get calendar Id
$calendarId = isset($_GET['c'])?$_GET['c']:1;
//====Initiate Event Calendar Class
$pec = new C_PhpEventCal($calendarProperties,$calendarId);

//==== Setting Properties
$pec->header();
//$pec->firstDay(2);
//$pec->weekends();
//$pec->weekMode('liquid');
//$pec->weekNumbers(true);
//$pec->height(580);

//$pec->contentHeight(400);
//$pec->slotMinutes(50);
//$pec->defaultView('month'); //month,basicWeek,agendaWeek,basicDay,agendaDay

if(isset($_COOKIE['currentView']) && $_COOKIE['currentView']!=''){
    $pec->defaultView($_COOKIE['currentView']); //month,basicWeek,agendaWeek,basicDay,agendaDay
    @setcookie("currentView", ""); // TODO, fix "header already sent". It's surpressed for now. Bad
}
//$pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Agenda Day','basicDay'=>'Day','basicWeek'=>'Week','month'=>'Month','agendaWeek'=>'Agenda Week'));
$pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Day','basicDay'=>'Day','month'=>'Month','agendaWeek'=>'Week','pec'=>'Upcoming'));

//===Each Event as a form of Array
$events = array(
//    array('id'=>178,'title'=>'My Event 1','start'=>'2014-02-10'),
//    array('id'=>178,'title'=>'My Event 2','start'=>'2014-02-17',),
//    array('id'=>178,'title'=>'My Event 3','start'=>'2014-02-24')
);

//==== find if one or more calendar(s) is/are having external URL(s), Ex: google URL
// $_SESSION['userData']['active_calendar_id'] is replaced by $calid
$calid = array(24, 28, 29);
$activeExternalURLForCalendars = C_Events::findExternalURLForCalendars($calid);
//==== generate external URLs for calendars if any
if($activeExternalURLForCalendars) {
    $calURLs = NULL;
    foreach($activeExternalURLForCalendars as $k => $cal){
        $calURLs[] = array('url'=>$cal['description'],'color'=>$cal['color']);
    }
    if(!is_null($calURLs)) $pec->events($calURLs,'calendar');
}
else $pec->events($events);

//$pec->events(array('https://www.google.com/calendar/feeds/billahnorm%40gmail.com/public/basic','https://www.google.com/calendar/feeds/ngo11n296na6sb0v5gam8902ik%40group.calendar.google.com/public/basic'),'calendar');
//$pec->events($events);
/*
$moreEvents = array(
    array('title'=>'event6','start'=>'2013-11-17'),
    array('title'=>'event7','start'=>'2013-11-04','end'=>'2010-01-01'),
    array('title'=>'event8','start'=>'2013-11-20 12:30:00','allDay'=>false)
);

//==============================================
//TODO:Event Source is not working at the moment
$pec->eventSources(
    array('events'=>$moreEvents,'color'=>'red','textColor'=>'green','backgroundColor'=>'gray')
);
*/
//====================================================
//TODO: Google Event Feed is not working at the moment
//$pec->events('http://www.google.com/calendar/feeds/developer-calendar@google.com/public/full?alt=json-in-script','json');

$pec->editable(true);

$pec->dragOpacity(.2);
//$pec->firstDay(6);
//$pec->allDaySlot(true);
//$pec->fcFunction('viewRender',array());
//$pec->handleWindowResize(true);
?>

    <style>
        .container {
            width: auto;
        }
        #add-calendar {
            cursor: pointer;
        }
        .list-group a {
            padding: 4px;
            text-align: left;
            padding-left: 10px;
            padding-right: 2px;
        }
        .list-group a:hover {
            opacity: 0.75;
        }
        .fc-header-right .fc-header-space {
            display: none;
        }
        .unselect-calendar {
            float: right;
            font-size: 8px;
            margin-top: 13px;
            display: inline-block;
            z-index: 10000;
        }
        .unselect-calendar:hover {
            text-shadow: 0 2px 5px black;
            color: maroon;
        }

        a#cal-settings-link{
            display: none;
        }

    </style>

<?php //require_once(SERVER_HTML_INCLUDE_DIR.'top-navigation.html.php'); ?>
<div class="container">
    <?php
    require_once(SERVER_HTML_DIR.'calendar-create.html.php');
    require_once(SERVER_HTML_DIR.'calendar-settings.html.php');
    ?>

    <div class="starter-template">
        <p class="lead">
        <div class="row">
            <div class="col-md-12" style="overflow:hidden;float:inherit;width:inherit">
                <?php
                $pec->display_container();
                ?>
            </div>
        </div>
        </p>
    </div>



</div><!-- /.container -->


<?php
//=====display
$pec->display('body','public');
?>
