<?php
//test for wp plugin branch
require_once('conf.php');
//====security checking
//$validateUser = C_Security::validateUserSession();


//====Load all calendars
$allCals = new C_Calendar('LOAD_MY_CALENDARS');

//====Load calendar properties
$calendarProperties = $allCals->calendarProperties;

//====Load calendars
$allCalendars = $allCals->allCalendars;

//====Initiate Event Calendar Class
$pec = new C_PhpEventCal($calendarProperties);

//==== Setting Properties
$pec->header();
//$pec->firstDay(2);
//$pec->weekends();
//$pec->weekMode('liquid');
//$pec->weekNumbers(true);
//$pec->height(580);

//$pec->contentHeight(400);
//$pec->slotMinutes(50);
if(isset($_COOKIE['currentView']) && $_COOKIE['currentView']!=''){
    $pec->defaultView($_COOKIE['currentView']); //month,basicWeek,agendaWeek,basicDay,agendaDay
    //setcookie("currentView", "");
}

//$pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Agenda Day','basicDay'=>'Day','basicWeek'=>'Week','month'=>'Month','agendaWeek'=>'Agenda Week'));
$pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Day','basicDay'=>'Day','month'=>'Month','agendaWeek'=>'Week', 'pec'=>'Upcoming'));

//===Each Event as a form of Array
$events = array(
//    array('id'=>178,'title'=>'My Event 1','start'=>'2014-02-10'),
//    array('id'=>178,'title'=>'My Event 2','start'=>'2014-02-17',),
//    array('id'=>178,'title'=>'My Event 3','start'=>'2014-02-24')
);

//==== find if one or more calendar(s) is/are having external URL(s), Ex: google URL
$activeExternalURLForCalendars = C_Events::findExternalURLForCalendars($_SESSION['userData']['active_calendar_id']);
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
        #adminmenu li.menu-top {
            text-align: left;
        }
    </style>

    <?php //require_once(SERVER_HTML_INCLUDE_DIR.'top-navigation.html.php'); ?><!-- lite_disabled -->
    <div class="container">

        <?php
        require_once(SERVER_HTML_DIR.'calendar-create.html.php');
        require_once(SERVER_HTML_DIR.'calendar-update.html.php');
        require_once(SERVER_HTML_DIR.'calendar-settings.html.php');
        ?>

        <div class="starter-template">
            <p class="lead">
                <div class="row">
                    <div class="col-md-2" style="padding: 0;max-width:225px;min-width:225px">
                        <!-- Create New Event Button -->
                        <div style="float: left; padding-left: 10px;">
                            <button type="button" class="btn btn-success" id="create-new-event" style="display:none">Create New Event</button>
                        </div>
                        <div style="clear: both; height: 17px; display: none"></div>

                        <img class="pec-logo" src="<?php echo plugins_url( 'images/pec-logo.png',  __FILE__ ) ?>" /><br /><br />

                        <!-- Date Picker -->
                        <div id="date-picker" style="border: 1px solid #d9d9d9; margin-left: 3px; margin-top: 0; padding-top: 0; border-radius: 2px"></div>


                        <!-- My Calendar -->
                        <div id="my-calendars" class="panel panel-default" style="margin-top: 10px; margin-left: 3px;">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="width: 100%">
                                    <span style="text-align: left; float: left">My Calendars</span>
                                    <span id="" class="glyphicon glyphicon-plus" style="float: right; margin-left: 8px; display: none;"></span><!-- lite_disabled-->
                                    &nbsp;
                                    <span id="" class="glyphicon glyphicon-cog" style="margin-top:1px; float: right; cursor: pointer; display: none;"></span><!-- lite_disabled-->
                                </h3>
                            </div>
                            <div class="list-group">

                                <?php if($allCalendars != NULL) foreach($allCalendars as $k => $v){ ?>
                                    <?php
                                        //var_dump($_SESSION['userData']['active_calendar_id']);
                                        $activeCalendars = C_Calendar::activeCalendarId(PEC_USER_ID);
                                        $activeCalendars = explode(',', $activeCalendars[0]);
                                        if(@in_array($v['id'],$activeCalendars)){
                                            $active = '<span class="glyphicon glyphicon-remove unselect-calendar"></span><span style="float: right" class="glyphicon glyphicon-ok"></span>';
                                            $activeClass = 'selected';
                                        }
                                        else {
                                            $active = '';
                                            $activeClass = '';
                                        }
                                    ?>
                                    <a href="javascript:void(0);" class="list-group-item ladda-button <?php echo $activeClass?>" data-style="expand-right" style="background-color: <?php echo $v['color']?>; color:white;" id="<?php echo $v['id']?>"><span class="ladda-label"><?php echo $v['name']?></span> <?php echo $active?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <br />
                        <div>
                            <a href="http://phpeventcalendar.com/50-off-limited-time-offer-complete-add-on-bundle/"><img src="<?php echo plugins_url( 'images/addon-all.png',  __FILE__ ) ?>" width="220"></a>
                            <script>
                                // Include the UserVoice JavaScript SDK (only needed once on a page)
                                UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/YeozGEz9hA0eZMJyToOKag.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

                                //
                                // UserVoice Javascript SDK developer documentation:
                                // https://www.uservoice.com/o/javascript-sdk
                                //

                                // Set colors
                                UserVoice.push(['set', {
                                    accent_color: '#448dd6',
                                    trigger_color: 'white',
                                    trigger_background_color: '#6aba2e'
                                }]);

                                // Identify the user and pass traits
                                // To enable, replace sample data with actual user traits and uncomment the line
                                UserVoice.push(['identify', {
                                    //email:      'john.doe@example.com', // User’s email address
                                    //name:       'John Doe', // User’s real name
                                    //created_at: 1364406966, // Unix timestamp for the date the user signed up
                                    //id:         123, // Optional: Unique id of the user (if set, this should not change)
                                    //type:       'Owner', // Optional: segment your users by type
                                    //account: {
                                    //  id:           123, // Optional: associate multiple users with a single account
                                    //  name:         'Acme, Co.', // Account name
                                    //  created_at:   1364406966, // Unix timestamp for the date the account was created
                                    //  monthly_rate: 9.99, // Decimal; monthly rate of the account
                                    //  ltv:          1495.00, // Decimal; lifetime value of the account
                                    //  plan:         'Enhanced' // Plan name for the account
                                    //}
                                }]);

                                // Add default trigger to the bottom-right corner of the window:
                                UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right', contact_title: 'Please send us your feedback' }]);

                                // Or, use your own custom trigger:
                                //UserVoice.push(['addTrigger', '#id', { mode: 'contact' }]);

                                // Autoprompt for Satisfaction and SmartVote (only displayed under certai
                                // n conditions)
                                UserVoice.push(['autoprompt', {}]);

                                // Richard: Show the Uservoice feedback widget automatically 5 seconds after page load
                                // setTimeout(function(){UserVoice.show();}, 5000);
                            </script><div id="feedback_link"></div>
                        </div>


                    </div>
                    <div class="col-md-10" style="overflow:hidden;float:inherit;width:inherit">
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
    $pec->display();
    ?>

    <?php
    //======display debug info
    $pec->display_debug();
    ?>
