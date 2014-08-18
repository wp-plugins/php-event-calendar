<?php
/**
 * File: cls_phpeventcal.php:
 *
 * Description: It extends event properties and has some important core functionalities.
 *
 * @package eventcalendar
 * @author Richard Chen
 * @modifiedby Richard Z.C. <info@phpeventcalendar.com>
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * @ignore
 */
if (str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) == PEC_PLUGIN_DIR) {
    define('ABS_PATH', '');
} else {
    define('ABS_PATH', PEC_PLUGIN_DIR);
}

/**
 * @ignore
 */
if (!session_id()) {
   // session_start();
}


/**
 * Class C_PhpEventCal : Controller for Front end Event Calendar and Manager
 *
 * Description: Responsible for showing/altering and managing front end event calendar based on full calendar. It
 * extends C_Core class and mainly implements various features of full calendar.
 *
 * @author Richard Chen
 * @modifiedby Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_PhpEventCal extends C_Core
{
    /**
     * @var array $jsonDefaultSettings
     */
    public $jsonDefaultSettings;

    /**
     * @var string $jsonDefaultSettingsStr
     */
    public $jsonDefaultSettingsStr;

    /**
     * @var string $userConfig
     */
    public $userConfig;

    /**
     * @var array $config
     */
    public $config;

    /**
     * @var string $configStr
     */
    public $configStr;

    /**
     * @var string $webURL
     */
    public $webURL;

    /**
     * @var null|array $calendarProperties
     */
    public $calendarProperties;

    /**
     * Constructor method
     *
     * @param null $calendarProperties
     */
    public function __construct($calendarProperties = NULL, $calId=0)
    {
        //====Load DB
        $this->load_db();
        $this->webURL = WP_PEC_PLUGIN_SITE_URL;

        $this->calendarProperties = $calendarProperties;

        if(isset($calendarProperties['privacy']) && $calendarProperties['privacy']=='public'){
            //==== Load Public Event Manager

            $allEvents = new C_Events($calId, 'LOAD_PUBLIC_EVENTS');
        }
        else {
            //==== Load Event Manager
            $allEvents = new C_Events(0, 'LOAD_MY_EVENTS');
        }

        //==== Load Event from DB
        $this->events($allEvents->myEvents);

        //====Load Properties
        $this->load_properties($this->calendarProperties);
    }


    /**
     * Sets configuration for events
     *
     * @param $config
     * @author Richard Chen
     */
    public function setConfig($config)
    {
        $this->userConfig = $config;
        $this->config = array_merge($this->jsonDefaultSettings, $this->userConfig);
        /*
        echo '<pre style="text-align: left">';
        print_r($this->jsonDefaultSettings);
        print_r($this->config);
        echo '</pre>';
        */
        $this->configStr = substr(str_replace('"', "'", json_encode($this->config)), 1, -1);
    }

    /**
     * Modal window for Event Create
     * This has HTML Source for generating bootstrap modal window
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function modal_window()
    {
        require_once(PEC_PLUGIN_ROOT_DIR . '/server/html/event-create.html.php');
    }
// Modal window for public calender details
    public function modal_window_public()
    {
        require_once(PEC_PLUGIN_DIR . '/server/html/event-create-public.html.php');
    }

    /**
     * Displays Full Calendar Main window in the targeted HTML Element
     * @param string $target
     * @author Richard Chen
     * @modifiedby Richard Z.C. <info@phpeventcalendar.com>
     */
    public function display($target = 'body',$privacy='private')
    {
        if ($target == 'head') {
            $this->display_script_include_once_head(true, true, true, true, true);
        }
        if ($target == 'body') {
            //$this->display_container();
            if($privacy=='private')$this->modal_window();
            if($privacy=='public')$this->modal_window_public();
            $this->display_script_include_once_foot(true, true, true, true, true);
            $this->display_script_begin();
            if($privacy=='private') $this->display_properties_main($this->calendarProperties);
            else if($privacy =='public')
                $this->display_properties_main_public($this->calendarProperties);
            $this->display_script_end();
            //$this->display_custom_js('calendar');
        }
    }

    /**
     * Loads jquery initiator
     * @author Richard Chen
     * @ignore
     */
    private function display_script_begin()
    {
        echo "\n" . '<script language="javascript" type="text/javascript"> ' . "\n";
        echo 'jQuery(document).ready(function($) { ' . "\n";
    }

    /**
     * Display Main Properties for events
     *
     * @param $calendarProperties
     * @author Richard Chen
     * @modifiedby Richard Z.C. <info@phpeventcalendar.com>
     */
    private function display_properties_main_public($calendarProperties){
        //$userRol = $_SESSION['userData']['role'];
        $adminURL = admin_url('admin-ajax.php');
        $noMapURL = plugins_url( '../../images/no-map.jpg', __FILE__ );

        echo "
            var ajaxurl = '$adminURL'; //this is required for Wordpress User Facing Pages for AJAX Calls
            //==================Custom JS=============================
            $('#eventForm').click(function (){

            });
            //==================Event Calander Script=================
            //alert('$this->handleWindowResize');
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: $this->header,
                allDaySlot:$this->allDaySlot,
                allDayText:'$this->allDayText',
                axisFormat:'$this->axisFormat',
                snapMinutes:'$this->snapMinutes',
                defaultEventMinutes: '$this->defaultEventMinutes',
                firstHour: '$this->firstHour',
                minTime: '$this->minTime',
                //maxTime: '$this->maxTime',
                slotEventOverlap: '$this->slotEventOverlap',
                weekends: $this->weekends,
                firstDay: $this->firstDay,
                isRTL: $this->isRTL,
                hiddenDays: $this->hiddenDays,
                year:$this->year,
                month:$this->month,
                date:$this->date,
                theme: $this->theme,
                buttonIcons: $this->buttonIcons,
                weekMode: '$this->weekMode',
                weekNumbers: $this->weekNumbers,
                weekNumberCalculation: '$this->weekNumberCalculation',
                height:'$this->height',
                contentHeight: '$this->contentHeight',
                aspectRatio: $this->aspectRatio,
                handleWindowResize: $this->handleWindowResize,
                defaultView: '$this->defaultView',
                timeFormat: $this->timeFormat,
                columnFormat: $this->columnFormat,
                titleFormat: $this->titleFormat,
                buttonText: $this->buttonText,
                monthNames: $this->monthNames,
                monthNamesShort: $this->monthNamesShort,
                dayNames: $this->dayNames,
                dayNamesShort: $this->dayNamesShort,
                weekNumberTitle: '$this->weekNumberTitle',
                selectable: '$this->selectable',
                selectHelper: '$this->selectHelper',
                unselectAuto: '$this->unselectAuto',
                unselectCancel: '$this->unselectCancel',
                viewRender: function(view, element){
                    //alert('here');
                    //alert(view);
                },

                eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                },

                eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
                },
                dayClick: function(date, allDay, jsEvent, view) {
                },
                events: $this->events,
                //================================
                eventSources: $this->eventSources,
                allDayDefault: $this->allDayDefault,
                ignoreTimezone: $this->ignoreTimezone,
                startParam: '$this->startParam',
                endParam: '$this->endParam',
                lazyFetching: $this->lazyFetching,
                eventColor: '$this->eventColor',
                eventBackgroundColor: '$this->eventBackgroundColor',
                eventBorderColor: '$this->eventBorderColor',
                editable: $this->editable,
                eventStartEditable: $this->eventStartEditable,
                eventDurationEditable: $this->eventDurationEditable,
                dragRevertDuration: $this->dragRevertDuration,
                dragOpacity: $this->dragOpacity,
                droppable: $this->droppable,
                dropAccept: '$this->dropAccept',
				eventClick: function(calEvent, jsEvent, view) {
				    jqxhr = $.ajax({
                        type: 'POST',
                        //url: '$this->webURL/server/ajax/events_manager.php', //comment out for Wordpress AJAX URL
                        url: ajaxurl, //For Wordpress AJAX instead use WP Admin Ajax URL, which is actually ajaxurl
                            data: {eventID:calEvent.id,action:'LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID_PUBLIC'},
                            dataType: 'json',
                            _ajax_nonce: 'wp_create_nonce(NONCE_LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID_PUBLIC)' //Make sure to use WP nonce

                        })
                        .done(function(ed) {
                            var shortdateFormat = '$calendarProperties[shortdate_format]';
                            var longdateFormat = '$calendarProperties[longdate_format]';

                            $('#myModal').modal({backdrop:'static',keyboard:false});
                            var modalTitle = '<b>'+ calEvent.title.toUpperCase() + '</b> <br >' +  $.fullCalendar.moment(calEvent.start).format(longdateFormat+' hh:mm A');
                            $('#myModalLabel').html(modalTitle);
                            $('#myTab a:first').tab('show');

                            //====setting up values

                            $('#title').val(calEvent.title);

                            var startMoment = moment(calEvent.start)
                            $('#start-date-guest').val(startMoment.format('YYYY-MM-DD'));
                            $('#start-time').val(startMoment.format('hh:mm A'));

                            var endMiliseconds = Date.parse(calEvent.end);
                            var endMoment = '';
                            endMoment = moment(calEvent.end);

                            if(calEvent.end == null && (calEvent.allDay!='on' || ed.allDay!='on'  )){
                                if(ed.end_date == null || ed.end_date == '' || calEvent.end == null){
                                    var dePrepDate = ed.start_date.split('-');
                                    var dePrepTime = ed.start_time.split(':');
                                    var dePrep = new Date(dePrepDate[0],dePrepDate[1]-1,dePrepDate[2],parseInt(dePrepTime[0])+1,dePrepTime[1],0,0);
                                    endMoment = moment(dePrep)
                                }
                                else {
                                    var dePrepDate = ed.end_date.split('-');
                                    var dePrepTime = ed.end_time.split(':');
                                    var dePrep = new Date(dePrepDate[0],dePrepDate[1],dePrepDate[2],dePrepTime[0],dePrepTime[1],0,0);
                                    endMoment = moment(dePrep)
                                }
                            }

                            if(calEvent.end != null){
                                $('#end-date-guest').val(endMoment.format('YYYY-MM-DD'));
                                $('#end-time').val(endMoment.format('hh:mm A'));
                            }


                            if(calEvent.allDay == 'on' || calEvent.allDay == true) {
                                $('#dayAll').html('All Day Event');
                                $('#allday_msg').show();
                                $('#end-group').hide();
                            }
                            else {
                                $('#end-group').show();
                                $('#allday_msg').hide();
                                $('#dayAll').html('');
                            }

                            /*
                            if(ed.repeat_type != 'none') {
                                $('#repeat_msg').show();
                                $('#repeat_type').html(ed.repeat_type.toUpperCase() + ' Repeating Event');
                            }
                            else {
                                $('#repeat_type').html('');
                                $('#repeat_msg').hide();

                            }
                            */

                            $('#url').val(calEvent.url);
                            $('#backgroundColor').val(calEvent.backgroundColor);
                            $('#borderColor').val(calEvent.borderColor);
                            $('#textColor').val(calEvent.textColor);




                            //====setting up selected calendar values
                            $('.selectpicker').selectpicker('val', [ed.cal_id]);
                            //$('.select-calendar-cls').css('opacity','0.35');
                            //$('#select-calendar').attr('disabled','disabled');


                            if(ed.location == null || ed.location == '') {
                                $('#loc_msg').hide();
                                $('#location').val('');
                            }
                            else {
                                $('#loc_msg').show();
                                $('#location').val(ed.location);
                            }

                            if(ed.url != null) {
                                $('#url_msg').show();
                                // $('#url').val(ed.url);
                                $('#url').text(ed.url);
                                $('#url').attr('href', ed.url);
                            }
                            else {
                                $('#url_msg').hide();
                                $('#url').val('');
                            }

                            if(ed.description != '') {
                                $('#desc_msg').show();
                                $('#description').html(ed.description);
                            }
                            else {
                                $('#desc_msg').hide();
                                $('#description').val('');
                            }

                            $('#backgroundColor').val(ed.backgroundColor);

                            //==== google maps
                            //var addr = document.getElementById('location').value;
                            var address = ed.location;
                            var geocoder = new google.maps.Geocoder();
                            if(address == null || address == ''){

                                /*$('#gmap_canvas').html('<img src=\'$noMapURL\' style=\'height: 255px; width: 380px; border:1px dotted #d9d9d9;\'>');*/
                                $('#gmap_canvas').css('height','auto');
                            }
                            else{
                                $('#gmap_canvas').css('height','300px');
                                geocoder.geocode({ 'address': address }, function (results, status) {

                                    if (status == google.maps.GeocoderStatus.OK) {
                                        var latitude = results[0].geometry.location.lat();
                                        var longitude = results[0].geometry.location.lng();
                                    }

                                    var myOptions = {
                                        zoom:17,
                                        center:new google.maps.LatLng(latitude,longitude),
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };
                                    map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
                                    marker = new google.maps.Marker({
                                        map: map,
                                        position: new google.maps.LatLng(latitude, longitude)
                                    });
                                    infowindow = new google.maps.InfoWindow({
                                        content:address
                                    });
                                    google.maps.event.addListener(marker, 'click', function(){
                                        infowindow.open(map,marker);
                                    });
                                    infowindow.open(map,marker);
                                });
                            }

                        })
                        .fail(function() {
                        });
                }
            });";
    }

    /**
     * Display Main Properties for events
     *
     * @param $calendarProperties
     * @author Richard Chen
     * @modifiedby Richard Z.C. <info@phpeventcalendar.com>
     */
    private function display_properties_main($calendarProperties)
    {
        $userRol = $_SESSION['userData']['role'];

        echo "
            //==================Custom JS=============================
            $('#eventForm').click(function (){

            });

            //==================Event Calander Script=================
            //alert('$this->handleWindowResize');
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var userRole = '$userRol';

            $('#calendar').fullCalendar({
                header: $this->header,
                allDaySlot:$this->allDaySlot,
                allDayText:'$this->allDayText',
                axisFormat:'$this->axisFormat',
                snapMinutes:'$this->snapMinutes',
                defaultEventMinutes: '$this->defaultEventMinutes',
                firstHour: '$this->firstHour',
                minTime: '$this->minTime',
                //maxTime: '$this->maxTime',
                slotEventOverlap: '$this->slotEventOverlap',
                weekends: $this->weekends,
                firstDay: $this->firstDay,
                isRTL: $this->isRTL,
                hiddenDays: $this->hiddenDays,
                year:$this->year,
                month:$this->month,
                date:$this->date,
                theme: $this->theme,
                buttonIcons: $this->buttonIcons,
                weekMode: '$this->weekMode',
                weekNumbers: $this->weekNumbers,
                weekNumberCalculation: '$this->weekNumberCalculation',
                height:'$this->height',
                contentHeight: '$this->contentHeight',
                aspectRatio: $this->aspectRatio,
                handleWindowResize: $this->handleWindowResize,
                defaultView: '$this->defaultView',
                timeFormat: $this->timeFormat,
                columnFormat: $this->columnFormat,
                titleFormat: $this->titleFormat,
                buttonText: $this->buttonText,
                monthNames: $this->monthNames,
                monthNamesShort: $this->monthNamesShort,
                dayNames: $this->dayNames,
                dayNamesShort: $this->dayNamesShort,
                weekNumberTitle: '$this->weekNumberTitle',
                selectable: '$this->selectable',
                selectHelper: '$this->selectHelper',
                unselectAuto: '$this->unselectAuto',
                unselectCancel: '$this->unselectCancel',
                viewRender: function(view, element){
                    //alert('here');
                    //alert(view);
                },

                eventResize: function(event, revertFunc, jsEvent, ui, view) {
                    processMovedEvent(event, revertFunc, jsEvent, ui, view);

                    /*
                    alert(
                        'The end date of ' + event.title + 'has been moved ' +
                        dayDelta + ' days and ' +
                        minuteDelta + ' minutes.'
                    );

                    if (!confirm('is this okay?')) {
                        revertFunc();
                    }
                    */
                },

                eventDrop: function(event, revertFunc, jsEvent, ui, view) {
                    processMovedEvent(event, revertFunc, jsEvent, ui, view);
                },
                dayClick: function(date, allDay, jsEvent, view) {
                    //==== show this panel if it is hidden
                    $('#end-group').show();
                    $('#remove-block').hide();
                    $('#repeat_by_group').hide();

                    //===Clearing Reminder Settings Panel
                    $('#hide-reminder-settings').click();
                    serial = 1;
                    $('#guest-list div').remove();

                    //===Selecting Multiple Calendar

                    $('#eventForm fieldset').removeAttr('disabled');

                    var dt = new Date();

                    var hours   = dt.getHours();
                    var minutes = dt.getMinutes();
                    if(minutes > 30) minutes = 30;
                    else minutes = 0;
                    var ehours;
                    if(hours > 0) ehours = hours+1;
                    if(hours == 0) ehours = hours;
                    if(hours == 23) ehours = hours;

                    var eminutes;
                    if(ehours >= 24) ehours = '0';
                    if(hours > 0) eminutes = minutes;
                    if(hours == 0) eminutes = '59';
                    if(hours == 23) eminutes = '59';

                    var mm = date.format('M');
                    var dd = date.format('D');
                    var yyyy = date.format('YYYY');

                    if(parseInt(mm) <= 9) mm = '0'+(parseInt(mm)+0);
                    if(parseInt(dd) <= 9) dd = '0'+dd;
                    if(parseInt(hours) <= 9) hours = '0'+hours;
                    if(parseInt(minutes) <= 9) minutes = '0'+minutes;
                    if(parseInt(ehours) <= 9) ehours = '0'+ehours;
                    if(parseInt(eminutes) <= 9) eminutes = '0'+eminutes;

                    var curDate = yyyy+'-'+mm+'-'+dd+' '+hours+':'+minutes;
                    var curDateInput = yyyy+'-'+mm+'-'+dd;

                    var shortdateFormat = '$calendarProperties[shortdate_format]';
                    var longdateFormat = '$calendarProperties[longdate_format]';
                    var title = $.fullCalendar.moment(date).format(longdateFormat+' hh:mm A');
                    $('#myModal').modal({backdrop:'static',keyboard:false});
                    $('#myModalLabel').html(title);
                    $('#myTab a:first').tab('show');
                    $('#create-event').html('Create Event');
                    $('#update-event').val('');

                    //==== resetting fields
                    document.getElementById('eventForm').reset();
                    $('.checkbox-inline input, #allDay').removeAttr('checked');
                    $('.repeat-box').hide();
                    //$('#hide-standard-settings').click(); //<!-- lite_disabled: always expanding this section for lite version only -->
                    $('#show-standard-settings').click(); //lite_disabled
                    //$('.color-box').removeClass('color-box-selected');
                    $('#backgroundColor').val('#3a87ad');
                    $('#repeat_end_on').val('');
                    $('#repeat_end_after').val('');
                    $('#repeat_never').val('1');
                    $('#ends-db-val').datetimepicker('remove');
                    $('#ends-db-val').attr('readonly','readonly');

                    //====For Agenda Week & Agenda Day
                    if(hours > 0 || minutes > 0){

                    }

                    //====Setting Date Fields
                    $('#start-date').val(curDateInput);
                    $('#end-date').val(curDateInput);
                    $('#repeat_start_date').val(curDateInput);

                    //===convert 24 hours to 12 hours format
                    var startTime12Format = formatTimeStr(hours+':'+minutes);
                    var endTime12Format = formatTimeStr(ehours+':'+eminutes);

                    $('#start-time').val(startTime12Format);
                    $('#end-time').val(endTime12Format);


                    //$('#select-calendar').removeAttr('disabled');
                    //$('.select-calendar-cls').css('opacity','1');
                    var jqxhr = $.ajax({
                        type: 'POST',
                            //url: '<?php //echo WP_PEC_PLUGIN_SITE_URL?>/server/ajax/events_manager.php',
                            url: ajaxurl, //For Wordpress AJAX instead use WP Admin Ajax URL, which is actually ajaxurl
                            data: {action: 'LOAD_SELECTED_CALENDAR_FROM_SESSION',_ajax_nonce: 'wp_create_nonce(NONCE_LOAD_SELECTED_CALENDAR_FROM_SESSION)'},
                            dataType: 'json'
                        })
                        .done(function(selCal) {
                            //====setting up values
                            $('.selectpicker').selectpicker('val', selCal);
                        })
                        .fail(function() {
                        });

                    var jqxhr = $.ajax({
                        type: 'POST',
                            //url: '<?php //echo WP_PEC_PLUGIN_SITE_URL?>/server/ajax/events_manager.php',
                            url: ajaxurl, //For Wordpress AJAX instead use WP Admin Ajax URL, which is actually ajaxurl
                            data: {action: 'LOAD_SELECTED_CALENDAR_COLOR',_ajax_nonce: 'wp_create_nonce(NONCE_LOAD_SELECTED_CALENDAR_COLOR)'},
                        })
                        .done(function(selCalColor) {
                            //====setting up values
                            $('#backgroundColor').val(selCalColor);
                            var selCalColorData = selCalColor.split('#');
                            var colorID = 'cid_'+selCalColorData[1];
                            $('#'+colorID).click();
                        })
                        .fail(function() {
                        });
                },
                events: $this->events,
                //================================
                eventSources: $this->eventSources,
                allDayDefault: $this->allDayDefault,
                ignoreTimezone: $this->ignoreTimezone,
                startParam: '$this->startParam',
                endParam: '$this->endParam',
                lazyFetching: $this->lazyFetching,
                eventColor: '$this->eventColor',
                eventBackgroundColor: '$this->eventBackgroundColor',
                eventBorderColor: '$this->eventBorderColor',
                editable: $this->editable,
                eventStartEditable: $this->eventStartEditable,
                eventDurationEditable: $this->eventDurationEditable,
                dragRevertDuration: $this->dragRevertDuration,
                dragOpacity: $this->dragOpacity,
                droppable: $this->droppable,
                dropAccept: '$this->dropAccept',
				eventClick: function(calEvent, jsEvent, view) {
				    var shortdateFormat = '$calendarProperties[shortdate_format]';
                    var longdateFormat = '$calendarProperties[longdate_format]';
                    userRole = 'admin';
				    eventRenderer(calEvent,jsEvent,view,userRole,shortdateFormat,longdateFormat);
                }
            });";
    }

    /**
     * Loads jquery end Javascript
     * @author Richard Chen
     * @ignore
     */
    private function display_script_end()
    {
        echo "\n" . '});' . "\n";
        echo '</script>' . "\n";
    }

    /**
     * Not in use
     * @ignore
     */
    private function display_debug()
    {
    }

    /**
     * Display Hidden HTML Containers
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @ignore
     */
    public function display_container()
    {
        require_once(PEC_PLUGIN_ROOT_DIR . '/server/html/calendar-window.html.php');
        //require_once(PEC_PLUGIN_DIR . '/server/html/calendar-window.html.php');
    }
}

?>