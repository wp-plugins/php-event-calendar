<?php
/**
 * File: cls_events.php This class manages events
 *
 * Description:
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * Class C_Events This class consists of DB operations for loading calendar settings, edit etc
 *
 * Description: Manages Events. Extends C_Calendar Class
 *
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Events extends C_Calendar
{
    /**
     * Properties for Events
     */

    /**
     * @var integer String/Integer. Optional. Uniquely identifies the given event. Different instances of repeating events should all have the same id.
     */
    public $id;

    /**
     * @var string $title. Required. The title on an event's element
     * Required
     */
    public $title;

    /**
     * @var string $allDay
     * true or false. Optional. Whether an event occurs at a specific time-of-day. This property affects whether an event's time is shown. Also, in the agenda views, determines if it is displayed in the "all-day" section. Don't include quotes around your true/false. This value is not a string!
     * When specifying Event Objects for events or eventSources, omitting this property will make it inherit from allDayDefault, which is normally true.
     */
    public $allDay;

    /**
     * @var string $start Start date for the event
     * Required
     * Date. Required. The date/time an event begins. When specifying Event Objects for events or eventSources, you may specify a string in IETF format (ex: "Wed, 18 Oct 2009 13:00:00 EST"), a string in ISO8601 format (ex: "2009-11-05T13:15:30Z") or a UNIX timestamp.
     */
    public $start;

    /**
     * @var string $start_date
     * @ignore
     */
    public $start_date;

    /**
     * @var string $start_time
     * @ignore
     */
    public $start_time;

    /**
     * @var int $start_timestamp
     * @ignore
     */
    public $start_timestamp;

    /**
     * @var string $end_date
     * @ignore
     */
    public $end_date;

    /**
     * @var string $end_time
     * @ignore
     */
    public $end_time;

    /**
     * @var int $end_timestamp
     * @ignore
     */
    public $end_timestamp;

    /**
     * @var string $end
     * Date. Optional. The date/time an event ends. As with start, you may specify it in IETF, ISO8601, or UNIX timestamp format. If an event is all-day... the end date is inclusive. This means an event with start Nov 10 and end Nov 12 will span 3 days on the calendar. If an event is NOT all-day... the end date is exclusive. This is only a gotcha when your end has time 00:00. It means your event ends on midnight, and it will not span through the next day.
     */
    public $end;

    /**
     * @var string $url
     * String. Optional. A URL that will be visited when this event is clicked by the user. For more information on controlling this behavior, see the eventClick callback.
     */
    public $url;

    /**
     * @var string $className
     * String/Array. Optional. A CSS class (or array of classes) that will be attached to this event's element.
     */
    public $className;

    /**
     * @var string $editable
     * true or false. Optional. Overrides the master editable option for this single event.
     */
    public $editable;

    /**
     * @var string $startEditable
     * true or false. Optional. Overrides the master eventStartEditable option for this single event.
     */
    public $startEditable;

    /**
     * @var string $durationEditable
     * true or false. Optional. Overrides the master eventDurationEditable option for this single event.
     */
    public $durationEditable;

    /**
     * @var string $source
     * Event Source Object. Automatically populated. A reference to the event source that this event came from
     */
    public $source;

    /**
     * @var string $color
     * Sets an event's background and border color just like the calendar-wide eventColor option.
     */
    public $color;

    /**
     * @var string $backgroundColor
     * Sets an event's background color just like the calendar-wide eventBackgroundColor option.
     */
    public $backgroundColor;

    /**
     * @var string $borderColor
     * Sets an event's border color just like the the calendar-wide eventBorderColor option.
     */
    public $borderColor;

    /**
     * @var string
     * Sets an event's text color just like the calendar-wide eventTextColor option.
     */
    public $textColor;

    /**
     * @var string $description
     * non standard
     */
    public $description;

    /**
     * @var string $free_busy
     */
    public $free_busy;

    /**
     * @var string $location
     */
    public $location;

    /**
     * @var string $privacy
     */
    public $privacy;

    /**
     * @var string $reminder_type
     */
    public $reminder_type;

    /**
     * @var string $repeat_start_date
     */
    public $repeat_start_date;

    /**
     * @var string $repeat_end_on
     */
    public $repeat_end_on;

    /**
     * @var string $repeat_end_after
     */
    public $repeat_end_after;

    /**
     * @var string $repeat_never
     */
    public $repeat_never;

    /**
     * @var string $repeat_by
     */
    public $repeat_by;
    /**
     * @var string $reminder_time
     */
    public $reminder_time;

    /**
     * @var string $reminder_time_unit
     */
    public $reminder_time_unit;

    /**
     * @var integer $repeat
     */
    public $repeat;

    /**
     * @var string $repeat_type
     */
    public $repeat_type;

    /**
     * @var int $repeat_on_sun
     * @ignore
     */
    public $repeat_on_sun;

    /**
     * @var int $repeat_on_mon
     * @ignore
     */

    /**
     * @var int $repeat_on_mon
     * @ignore
     */
    public $repeat_on_mon;

    /**
     * @var int $repeat_on_tue
     * @ignore
     */
    public $repeat_on_tue;

    /**
     * @var int $repeat_on_wed
     * @ignore
     */
    public $repeat_on_wed;

    /**
     * @var int $repeat_on_thu
     * @ignore
     */
    public $repeat_on_thu;

    /**
     * @var int $repeat_on_fri
     * @ignore
     */
    public $repeat_on_fri;

    /**
     * @var int $repeat_on_sat
     * @ignore
     */
    public $repeat_on_sat;

    /**
     * @var int $repeat_interval
     * @ignore
     */
    public $repeat_interval;

    /**
     * @var int $calendar_selected
     * @ignore
     */
    public $calendar_selected;


    /**
     * @var int $errorNo
     * @ignore
     */
    public $errorNo;

    /**
     * @var boolean|string $errMsg
     * @ignore
     */
    public $errMsg = false;

    /**
     * @var array $errMsgList
     * @ignore
     */
    public $errMsgList = array(
        0 => 'Required params are missing',
        1 => 'DB Error',
        2 => 'Method Not Found'
    );

    /**
     * @var object $db
     * @ignore
     */
    public $db;

    /**
     * @var object $dbObj
     * @ignore
     */
    public $dbObj;

    /**
     * @var array $myEvents
     * @ignore
     */
    public $myEvents;

    /**
     *
     */
    protected $eventIndex;

    /**
     *
     */
    protected $loadEventsOnPageLoad=false;


    /**
     * Constructor Function for Events
     *
     * Creates an Event Object when called.
     * By default creates an event object and if user requests 'LOAD_MY_EVENTS' then it loads all events based on logged in users
     *
     * @param int $calendarID
     * @param string $title
     * @param string $start
     * @param string $end
     * @param string $url
     * @param string $allDay
     * @param string $className
     * @param string $editable
     * @param string $startEditable
     * @param string $durationEditable
     * @param string $source
     * @param string $color
     * @param string $backgroundColor
     * @param string $borderColor
     * @param string $textColor
     * @param string $description
     * @param string $free_busy
     * @param string $location
     * @param string $privacy
     * @param string $repeat_start_date
     * @param string $repeat_end_on
     * @param string $repeat_end_after
     * @param string $repeat_never
     * @param string $repeat_by
     * @param string $repeat_type
     * @param string $repeat_interval
     * @param int $repeat_on_sun
     * @param int $repeat_on_mon
     * @param int $repeat_on_tue
     * @param int $repeat_on_wed
     * @param int $repeat_on_thu
     * @param int $repeat_on_fri
     * @param int $repeat_on_sat
     *
     * @author : Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public function __construct($calendarID = 0, $title, $start = '', $end = '', $url = '', $allDay = '', $className = '', $editable = '', $startEditable = '',
                                $durationEditable = '', $source = '', $color = '', $backgroundColor = '', $borderColor = '', $textColor = '', $description = '',
                                $free_busy = 'free', $location = '', $privacy = 'public',                $repeat_start_date = '', $repeat_end_on = '', $repeat_end_after = '',
                                $repeat_never = '', $repeat_by='',                  $repeat_type = 'none', $repeat_interval = '',
                                $repeat_on_sun = 0, $repeat_on_mon = 0, $repeat_on_tue = 0, $repeat_on_wed = 0, $repeat_on_thu = 0, $repeat_on_fri = 0, $repeat_on_sat = 0)
    {

        if ($title == 'LOAD_MY_EVENTS') {

            if($calendarID == 0) $this->loadEventsOnPageLoad = true;
            //====DB
            $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
            $this->db = $this->dbObj->db;

            if ($calendarID > 0) $calID = $calendarID;
            else if (isset($_SESSION['userData']['active_calendar_id'])) $calID = $_SESSION['userData']['active_calendar_id'];
            else $calID = 0;
            //var_dump($_SESSION['userData']['active_calendar_id']);
            return $allEvents = $this->loadAllEvents($calID);

        }
        if($title == 'LOAD_MY_EVENTS_BASED_SEARCH_KEY'){
            //====DB
            $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
            $this->db = $this->dbObj->db;

            $calID = 0;
            $searchKey = $calendarID; // $calendarID is now a search key for search feature as we are re-using event loading feature based on calendar ids
            return $allEvents = $this->loadAllEvents($calID,$searchKey);

        }
        if ($title == 'LOAD_PUBLIC_EVENTS') {
            if($calendarID == 0) $this->loadEventsOnPageLoad = true;
            //====DB
            $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
            $this->db = $this->dbObj->db;

            if ($calendarID > 0) $calID = $calendarID;
            else if (isset($_SESSION['userData']['active_calendar_id'])) $calID = $_SESSION['userData']['active_calendar_id'];
            else $calID = 0;
            //var_dump($_SESSION['userData']['active_calendar_id']);
            return $allEvents = $this->loadAllPublicEvents($calID);

        }

        if($title == 'GENERAL_PURPOSE') {
            //====DB
            $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
            $this->db = $this->dbObj->db;
            return NULL;
        }

        else {
            if ($title == '' || $start == '') {
                $this->errorNo = 0;
                $this->errMsg = $this->errMsgList[$this->errorNo];
                return false;
            } else $this->errMsg = false;

            $this->title = $title;
            $this->calendar_selected = false;

            /*
            $this->start = $start;
            $startData = explode(' ', $start);

            if (isset($startData[0])) {
                $dtParts = explode('-', $startData[0]);
                if (strlen($dtParts[1]) < 2) $dtParts[1] = '0' . $dtParts[1];
                if (strlen($dtParts[2]) < 2) $dtParts[2] = '0' . $dtParts[2];
                $startData[0] = $dtParts[0] . '-' . $dtParts[1] . '-' . $dtParts[2];
                $this->start_date = $startData[0];
            }

            if (isset($startData[1])) {
                $dtParts = explode(':', trim($startData[1]));
                if (strlen($dtParts[0]) < 2) $dtParts[0] = '0' . $dtParts[0];
                if (strlen($dtParts[1]) < 2) $dtParts[1] = '0' . $dtParts[1];
                $startData[1] = $dtParts[0] . ':' . $dtParts[1];
                $this->start_time = $startData[1];
            } else $this->start_time = '';
            $this->start_timestamp = strtotime($start);
            */
           /*
            $this->end = $end;
            $endData = explode(' ', $end);

            if (isset($end) && strlen(trim($end)) > 0) {
                $dtParts = explode('-', $endData[0]);
                if (strlen($dtParts[1]) < 2) $dtParts[1] = '0' . $dtParts[1];
                if (strlen($dtParts[2]) < 2) $dtParts[2] = '0' . $dtParts[2];
                $endData[0] = $dtParts[0] . '-' . $dtParts[1] . '-' . $dtParts[2];
                $this->end_date = $endData[0];
            }


            if (isset($endData[1]) && $endData[1] != '') {
                $dtParts = explode(':', trim($endData[1]));
                if (@strlen(@$dtParts[0]) < 2) $dtParts[0] = '0' . $dtParts[0];
                if (@strlen(@$dtParts[1]) < 2) $dtParts[1] = '0' . $dtParts[1];
                $endData[1] = $dtParts[0] . ':' . $dtParts[1];

                $this->end_time = $endData[1];
            } else $this->end_time = '';
            $this->end_timestamp = strtotime($end);
           */

            $this->start = $start;
            $this->start_timestamp = strtotime($start);
            $this->start_date = date('Y-m-d',$this->start_timestamp);
            $this->start_time = date('H:i',$this->start_timestamp);

            $this->end = $end;
            $this->end_timestamp = strtotime($end);
            $this->end_date = date('Y-m-d',$this->end_timestamp);
            $this->end_time = date('H:i',$this->end_timestamp);

            $this->url = $url;
            $this->allDay = $allDay;
            $this->className = $className;
            $this->editable = $editable;
            $this->startEditable = $startEditable;
            $this->durationEditable = $durationEditable;
            $this->source = $source;
            $this->color = $color;
            $this->backgroundColor = $backgroundColor;
            $this->borderColor = $borderColor;
            $this->textColor = $textColor;
            $this->description = $description;
            $this->description = $description;
            $this->free_busy = $free_busy;
            $this->location = $location;
            $this->privacy = $privacy;
            $this->repeat_start_date = $repeat_start_date;
            $this->repeat_end_on = $repeat_end_on;
            $this->repeat_end_after = $repeat_end_after;
            $this->repeat_never = $repeat_never;
            $this->repeat_by = $repeat_by;

            $this->repeat_on_sun = $repeat_on_sun;
            $this->repeat_on_mon = $repeat_on_mon;
            $this->repeat_on_tue = $repeat_on_tue;
            $this->repeat_on_wed = $repeat_on_wed;
            $this->repeat_on_thu = $repeat_on_thu;
            $this->repeat_on_fri = $repeat_on_fri;
            $this->repeat_on_sat = $repeat_on_sat;
            $this->repeat_type = $repeat_type;
            $this->repeat_interval = $repeat_interval;

            //====DB
            $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
            $this->db = $this->dbObj->db;

        }

        return true;
    }

    /**
     * Loads Single Event based on Event ID passed in parameter
     *
     * @param $eventID
     * @return mixed|null
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadSingleEventData($eventID)
    {
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_events` WHERE `id`=$eventID";
        $eventData = $dbObj->db_query($sql);

        if ($dbObj->num_rows($eventData) > 0) {
            return $dbObj->fetch_array($eventData);
        } else return NULL;

    }


    /**
     * Loads all events based on calendar ID or search key
     * @param int $calID
     * @return null|string
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function loadAllEvents($calID = 0,$searchKey='')
    {
        $userID = PEC_USER_ID;
        $sql = "SELECT `pe`.* FROM  `pec_events` as `pe` LEFT JOIN `pec_calendars` `pc` ON (`pe`.`cal_id` = `pc`.`id`) WHERE `pc`.`user_id`=$userID";


        if (!is_array($calID) && $calID > 0) $sql .= " AND `pe`.`cal_id` IN ($calID)";
        else if (is_array($calID)) {
            $calIDs = implode(',', $calID);
            if ($calIDs == '') $sql .= "";
            else $sql .= " AND `pe`.`cal_id` IN ($calIDs)";
        }

        if(isset($searchKey) && $searchKey != ''){
            $sql .= " AND `pe`.`title` LIKE '%$searchKey%' ";
        }

        $sql .= " ORDER BY `pe`.`start_date` ASC";
        $allEvents = $this->dbObj->db_query($sql);
        //die($allEvents);
        if ($this->dbObj->num_rows($allEvents) > 0) {
            return $this->prepareEventsForCalendarToShow($allEvents);
        } else return NULL;

        //           echo '<pre style="text-align: left">';
        //            while($res = $this->dbObj->fetch_array_assoc($allEvents)){
        //                print_r($res);
        //            }
        //            echo '</pre>';
    }

    /**
     * Loads all public events based on calendar ID
     * @param int $calID
     * @return null|string
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function loadAllPublicEvents($calID = 0)
    {
        $sql = "SELECT `pe`.* FROM  `pec_events` as `pe` LEFT JOIN `pec_calendars` `pc` ON (`pe`.`cal_id` = `pc`.`id`) WHERE `pe`.`privacy` = 'public'";

        $sql .= " OR `pc`.`public` = 1 ";

        $sql .= " ORDER BY `pe`.`start_date` ASC";

        $allEvents = $this->dbObj->db_query($sql);
        //die($allEvents);
        if ($this->dbObj->num_rows($allEvents) > 0) {
            return $this->prepareEventsForCalendarToShow($allEvents);
        } else return NULL;

    }

    /**
     * Returns the amount of weeks into the month a date is
     * @param $date
     * @param $rollover
     * @return int
     */
    public function getWeekPositionInMonth($date, $rollover){
        switch($rollover){
            case 0:
                $rollover = 'sunday';
                break;
            case 1:
                $rollover = 'monday';
                break;
            case 2:
                $rollover = 'tuesday';
                break;
            case 3:
                $rollover = 'wednesday';
                break;
            case 4:
                $rollover = 'thursday';
                break;
            case 5:
                $rollover = 'friday';
                break;
            case 6:
                $rollover = 'saturday';
                break;
            default:
                $rollover = 'monday';
                break;
        }

        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = round(($timestamp - $first) / $daylen);

        $i = 1;
        $weeks = 1;

        for($i; $i<=$elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));
            if($day == strtolower($rollover))  $weeks ++;
        }
        $date_parts = explode('-', $date);
        $date_parts[2] = '01';
        $first_of_month = implode('-', $date_parts);
        $day_first_of_month = strtolower(date("l", strtotime($first_of_month)));

        if($day_first_of_month == strtolower($rollover)) $weeks = $weeks - 1;
        return $weeks;
    }

    public function getWeekPositionBasedOnDayInMonth($cDate,$dayNameOfTheMonthForStartDate){
        $dayNameOfTheMonthForStartDate = strtolower($dayNameOfTheMonthForStartDate);

        $repeatLoop = strtotime($cDate);
        $dayFromDate = (int)date('j',$repeatLoop);

        $date_parts = explode('-', $cDate);
        $date_parts[2] = '01';
        $first_of_month = implode('-', $date_parts);
        $loopDTTime = strtotime($first_of_month);

        $weekCounter = 0;
        for($i=$loopDTTime;$i<=$loopDTTime + ((int)date('t',$repeatLoop))*60*60*24; $i=$i+60*60*24){
            $cDayName =strtolower(date("l", $i));
            $loopDay = (int)date('j',$i);
            if($loopDay>$dayFromDate){
                break;
            }
            if($dayNameOfTheMonthForStartDate == $cDayName) $weekCounter ++;
        }

        return $weekCounter;

    }

    public function handleRepeatEvents($res,$eventValues,$start_time='',$end_time=''){
        if(!isset($this->eventIndex)) $this->eventIndex = 0;
        $repeatEvent = false;
        $myEvents = NULL;
        if($end_time == NULL) $end_time = '';

        //====For repeating events
        if(!isset($res['repeat_type'])) $res['repeat_type'] = 'none';

        if($res['repeat_type'] != 'none' && !is_null($res['repeat_type'])){
            $repeatEvent = true;
            $repeatParams[$res['id']]['repeat_type']            = isset($res['repeat_type']) ? $res['repeat_type']:'';
            $repeatParams[$res['id']]['repeat_interval']        = isset($res['repeat_interval']) ? $res['repeat_interval']:'';
            $repeatParams[$res['id']]['repeat_count']           = isset($res['repeat_count']) ? $res['repeat_count']:'';
            $repeatParams[$res['id']]['repeat_start_date']      = isset($res['repeat_start_date']) ? $res['repeat_start_date']:'';
            $repeatParams[$res['id']]['repeat_end_on']          = isset($res['repeat_end_on']) ? $res['repeat_end_on']:'';
            $repeatParams[$res['id']]['repeat_end_after']       = isset($res['repeat_end_after']) ? $res['repeat_end_after']:'';
            $repeatParams[$res['id']]['repeat_never']           = isset($res['repeat_never']) ? $res['repeat_never']:'';
            $repeatParams[$res['id']]['repeat_on_sun']          = isset($res['repeat_on_sun']) ? $res['repeat_on_sun']:'';
            $repeatParams[$res['id']]['repeat_on_mon']          = isset($res['repeat_on_mon']) ? $res['repeat_on_mon']:'';
            $repeatParams[$res['id']]['repeat_on_tue']          = isset($res['repeat_on_tue']) ? $res['repeat_on_tue']:'';
            $repeatParams[$res['id']]['repeat_on_wed']          = isset($res['repeat_on_wed']) ? $res['repeat_on_wed']:'';
            $repeatParams[$res['id']]['repeat_on_thu']          = isset($res['repeat_on_thu']) ? $res['repeat_on_thu']:'';
            $repeatParams[$res['id']]['repeat_on_fri']          = isset($res['repeat_on_fri']) ? $res['repeat_on_fri']:'';
            $repeatParams[$res['id']]['repeat_on_sat']          = isset($res['repeat_on_sat']) ? $res['repeat_on_sat']:'';
            $repeatParams[$res['id']]['repeat_deleted_indexes'] = isset($res['repeat_deleted_indexes']) ? $res['repeat_deleted_indexes']:'';

            $repeatStartDate = strtotime($res['repeat_start_date']);
            //$repeatStartDate = $res['start_timestamp'];

            $monthlyInterval = 1;
            $yearlyInterval = 1;
            $repeatInterval = 1;
            switch($res['repeat_type']){
                case 'weekly':
                    $sault = 0;
                    $repeatInterval = $res['repeat_interval'];

                    //===if repeat never ends
                    if(@$res['repeat_never'] == 1){
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime('+6 year')));
                    }
                    //===if ends after X occurrences
                    else if(@$res['repeat_end_after'] > 0){
                        $intervals = $res['repeat_interval']*$res['repeat_end_after'];
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime("+$intervals week")));

                    }
                    //===if ends on a given date
                    else if(@$res['repeat_end_on'] !='0000-01-01'){
                        $repeatEndDate = strtotime($res['repeat_end_on']);
                    }
                    break;

                case 'everyTTDay':
                case 'everyMWFDay':
                case 'everyWeekDay':
                case 'daily':
                    $sault = 24*60*60;
                    $repeatInterval = $res['repeat_interval'];
                    //echo '<pre style="margin-top: 20px; text-align: left">';
                    //print_r($res);
                    ///echo '</pre>';

                //===if repeat never ends
                    if(@$res['repeat_never'] == 1){
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime('+6 year')));
                    }
                    //===if ends after X occurrences
                    else if(@$res['repeat_end_after'] > 0){
                        $startDate = $repeatParams[$res['id']]['repeat_start_date'];
                        $startDateRaw = strtotime($startDate);
                        $intervals = $res['repeat_interval']*$res['repeat_end_after'];
                        //$repeatEndDate = strtotime(date('Y-m-d',strtotime("+$intervals day")));
                        $repeatEndDate = $startDateRaw + ($intervals*$sault);
                        //$repeatEndDate = strtotime(date('Y-m-d',strtotime("+$intervals day")));

                        //echo '<pre style="margin-top: 20px; text-align: left">';
                        //echo $res['title']." ".$intervals." ".date('Y-m-d',$repeatEndDate)." ".date('Y-m-d',$startDateRaw);
                        //echo '</pre>';
                    }
                    //===if ends on a given date
                    else if(@$res['repeat_end_on'] !='0000-01-01'){
                        $repeatEndDate = strtotime($res['repeat_end_on']);
                        //echo "<pre>".date('Y-m-d',$repeatEndDate)."</pre>";
                        $repeatEndDate = $repeatEndDate - $sault;
                        //echo "<pre>".date('Y-m-d',$repeatEndDate)."</pre>";
                    }
                    break;

                case 'monthly':
                    $sault = 0;
                    $repeatInterval = $res['repeat_interval'];
                    $repeatBy = $res['repeat_by']; //repeat_by_day_of_the_month, repeat_by_day_of_the_week
                    //$repeatStartDate = $res['repeat_start_date'];

                    //=== find the day of the start date
                    $stdOfMonth = date('j',strtotime($res['repeat_start_date'])); //Ex: Day of the month without leading zeros (1 to 31 without leading 0)
                    $stdNameOfMonth = date('D',strtotime($res['repeat_start_date'])); //Ex: A textual representation of a day, three letters (Mon through Sun)


                    //=== Determine which week of the month for the day
                    //$userStartDay = $_SESSION['calendarData']['properties']['start_day'];
                    //===Example: Monthly on day 05
                    if($repeatBy == 'repeat_by_day_of_the_month'){

                    }
                    //===Example: Monthly on the third Wednesday
                    else if($repeatBy == 'repeat_by_day_of_the_week'){
                        $dayNameOfTheMonthForStartDate = strtolower(date("l", strtotime($res['repeat_start_date'])));
                        //$weekNumberOfMonth = $this->getWeekPositionInMonth($res['repeat_start_date'],$userStartDay);
                        $weekNumberOfMonth = $this->getWeekPositionBasedOnDayInMonth($res['repeat_start_date'],$dayNameOfTheMonthForStartDate);
                    }

                    //=======================OLD Implementation From Here

                    //===if repeat never ends
                    if(@$res['repeat_never'] == 1){
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime('+6 year')));
                    }
                    //===if ends after X occurrences
                    else if(@$res['repeat_end_after'] > 0){
                        $intervals = $res['repeat_interval']*$res['repeat_end_after'];
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime("+$intervals month")));
                    }
                    //===if ends on a given date
                    else if(@$res['repeat_end_on'] !='0000-01-01'){
                        $repeatEndDate = strtotime($res['repeat_end_on']);
                    }
                    break;
                case 'yearly':
                    $sault = 24*60*60;
                    $repeatInterval = $res['repeat_interval'];
                    //===if repeat never ends
                    if(@$res['repeat_never'] == 1){
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime('+6 year')));
                    }
                    //===if ends after X occurrences
                    else if(@$res['repeat_end_after'] > 0){
                        $intervals = $res['repeat_interval']*$res['repeat_end_after'];
                        $repeatEndDate = strtotime(date('Y-m-d',strtotime("+$intervals year")));
                    }
                    //===if ends on a given date
                    else if(@$res['repeat_end_on'] !='0000-01-01'){
                        $repeatEndDate = strtotime($res['repeat_end_on']);
                    }
                    break;
            }
        }

        if($repeatEvent){

            if($eventValues['end'] == '') $eventDurationDifference = 0;
            else $eventDurationDifference = strtotime($eventValues['end']) - strtotime($eventValues['start']);

            $repeatLoop = 0;
            $repeatCount = 0;

            //===find week start day
            if(isset($_SESSION['calendarData']['properties']['start_day']))$weekStartDayFromSettings = $_SESSION['calendarData']['properties']['start_day'];
            else $weekStartDayFromSettings = 0;
            switch($weekStartDayFromSettings){
                case 0:
                    $weekStartDay = 'sunday';
                    break;
                case 1:
                    $weekStartDay = 'monday';
                    break;
                case 2:
                    $weekStartDay = 'tuesday';
                    break;
                case 3:
                    $weekStartDay = 'wednesday';
                    break;
                case 4:
                    $weekStartDay = 'thursday';
                    break;
                case 5:
                    $weekStartDay = 'friday';
                    break;
                case 6:
                    $weekStartDay = 'saturday';
                    break;
            }

            for($repeatLoop=$repeatStartDate; $repeatLoop <=@$repeatEndDate+$sault;){
                //if($sault > 0)$repeatLoop = $repeatLoop + ($sault);

                if(((isset($_POST['action']) && $_POST['action'] == 'LOAD_EVENTS_BASED_ON_CALENDAR_ID' ) || $this->loadEventsOnPageLoad) && $repeatCount == 0 ){
                    $repeatCount ++;
                    continue;
                }
                $repeatLoopDay = date('D',$repeatLoop);
                $repeatLoopMonth = date('m',$repeatLoop);
                $repeatLoopYear = date('Y',$repeatLoop);

                //===determine which day to set for repeating events
                $rSTDate = date('Y-m-d',$repeatLoop).' '.$start_time;
                $rENDate = date('Y-m-d',$repeatLoop+$eventDurationDifference).' '.$end_time;

                //===For weekly repeats
                switch($res['repeat_type']){
                    case 'weekly':

                        if(isset($res['repeat_end_after']) && $res['repeat_end_after'] > 0){

                            if(isset($res['repeat_end_after']) &&  $repeatCount > $res['repeat_end_after']) continue;

                            $weekStart = date('d',strtotime("last $weekStartDay",$repeatLoop));

                            $weekStartTime = strtotime(date("Y-m-d", mktime(0, 0, 0, date("m",$repeatLoop), $weekStart, date("Y",$repeatLoop))));
                            $weekEnd = strtotime(date('Y-m-d',mktime(0, 0, 0, date("m",$repeatLoop)  , $weekStart+6, date("Y",$repeatLoop))));
                            //echo date('Y-m-d',$weekStartTime);

                            for($repeatWeekly = $weekStartTime; $repeatWeekly<=$weekEnd;$repeatWeekly=$repeatWeekly+24*60*60){
                                $repeatLoopIntegerDayWeek = date('d',$repeatWeekly);
                                $repeatLoopDayWeek = date('D',$repeatWeekly);

                                $rSTDateWeek = date('Y-m-d',$repeatWeekly).' '.$start_time;
                                $rENDateWeek = date('Y-m-d',$repeatWeekly+$eventDurationDifference).' '.$end_time;

                                if(
                                    $repeatLoopDayWeek == 'Mon' && @$res['repeat_on_mon'] == 1
                                        || $repeatLoopDayWeek == 'Tue' && @$res['repeat_on_tue'] == 1
                                            || $repeatLoopDayWeek == 'Wed' && @$res['repeat_on_wed'] == 1
                                                || $repeatLoopDayWeek == 'Thu' && @$res['repeat_on_thu'] == 1
                                                    || $repeatLoopDayWeek == 'Fri' && @$res['repeat_on_fri'] == 1
                                                        || $repeatLoopDayWeek == 'Sat' && @$res['repeat_on_sat'] == 1
                                                            || $repeatLoopDayWeek == 'Sun' && @$res['repeat_on_sun'] == 1
                                ) {
                                    $eventValues['start']  = $rSTDateWeek;
                                    $eventValues['end']    = $rENDateWeek;
                                    $myEvents[$this->eventIndex] = $eventValues;

                                    $this->eventIndex++;
                                }
                            }

                            //echo $repeatCount;
                            $repeatLoop = $repeatLoop + (24*60*60)*7*$repeatInterval;

                        }
                        else {
                            if(
                                $repeatLoopDay == 'Mon' && @$res['repeat_on_mon'] == 1
                                    || $repeatLoopDay == 'Tue' && @$res['repeat_on_tue'] == 1
                                        || $repeatLoopDay == 'Wed' && @$res['repeat_on_wed'] == 1
                                            || $repeatLoopDay == 'Thu' && @$res['repeat_on_thu'] == 1
                                                || $repeatLoopDay == 'Fri' && @$res['repeat_on_fri'] == 1
                                                    || $repeatLoopDay == 'Sat' && @$res['repeat_on_sat'] == 1
                                                        || $repeatLoopDay == 'Sun' && @$res['repeat_on_sun'] == 1
                            ) {
                                $eventValues['start']  = $rSTDate;
                                $eventValues['end']    = $rENDate;
                                $myEvents[$this->eventIndex] = $eventValues;

                                $this->eventIndex++;
                            }

                            $repeatLoop = $repeatLoop + (24*60*60)*$repeatInterval;

                        }
                        break;

                    case 'daily':
                        $eventValues['start']  = $rSTDate;
                        $eventValues['end']    = $rENDate;
                        $myEvents[$this->eventIndex] = $eventValues;

                        $this->eventIndex++;
                        $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*1;
                        //$repeatLoop = $repeatLoop + ($sault);

                        break;
                    case 'everyWeekDay':
                        if(
                            $repeatLoopDay == 'Mon'
                                || $repeatLoopDay == 'Tue'
                                    || $repeatLoopDay == 'Wed'
                                        || $repeatLoopDay == 'Thu'
                                            || $repeatLoopDay == 'Fri'
                        ) {
                            $eventValues['start']  = $rSTDate;
                            $eventValues['end']    = $rENDate;
                            $myEvents[$this->eventIndex] = $eventValues;

                            $this->eventIndex++;
                        }
                        $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*1;
                        break;

                    case 'everyMWFDay':
                        if(
                            $repeatLoopDay == 'Mon'
                                    || $repeatLoopDay == 'Wed'
                                            || $repeatLoopDay == 'Fri'
                        ) {
                            $eventValues['start']  = $rSTDate;
                            $eventValues['end']    = $rENDate;
                            $myEvents[$this->eventIndex] = $eventValues;

                            $this->eventIndex++;
                        }
                        $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*1;
                        break;

                    case 'everyTTDay':
                        if(
                            $repeatLoopDay == 'Tue'
                            || $repeatLoopDay == 'Thu'
                        ) {
                            $eventValues['start']  = $rSTDate;
                            $eventValues['end']    = $rENDate;
                            $myEvents[$this->eventIndex] = $eventValues;

                            $this->eventIndex++;
                        }
                        $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*1;
                        break;

                    case 'monthly':
                        //===Example: Monthly on day 05
                        if($repeatBy == 'repeat_by_day_of_the_month'){
                            $totalDaysInTheMonth = (int)date('t',$repeatLoop);
                            if((int)$stdOfMonth <= $totalDaysInTheMonth){
                                $rSTDateMonth = date("Y-m-d", mktime(0, 0, 0, date("m",$repeatLoop), $stdOfMonth, date("Y",$repeatLoop))).' '.$start_time;
                                $rENDateMonth = date("Y-m-d", mktime(0, 0, 0, date("m",$repeatLoop), $stdOfMonth, date("Y",$repeatLoop))).' '.$end_time;

                                $eventValues['start']  = $rSTDateMonth;
                                $eventValues['end']    = $rENDateMonth;
                                $myEvents[$this->eventIndex] = $eventValues;

                                $this->eventIndex++;
                            }
                            $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*30;
                        }
                        //===Example: Monthly on the third Wednesday
                        else if($repeatBy == 'repeat_by_day_of_the_week'){
                            $dayNameOfTheMonthForStartDate = strtolower($dayNameOfTheMonthForStartDate);
                            //echo $weekNumberOfMonth;
                            $cDate = date('Y-m-d',$repeatLoop);

                            $date_parts = explode('-', $cDate);
                            $date_parts[2] = '01';
                            $first_of_month = implode('-', $date_parts);
                            $loopDTTime = strtotime($first_of_month);

                            $weekCounter = 0;
                            for($i=$loopDTTime;$i<=$loopDTTime + ((int)date('t',$repeatLoop))*60*60*24; $i=$i+60*60*24){
                                $cDayName =strtolower(date("l", $i));
                                if($dayNameOfTheMonthForStartDate == $cDayName) $weekCounter ++;

                                if($weekCounter == $weekNumberOfMonth){
                                    $rSTDateMonth = date("Y-m-d", mktime(0, 0, 0, date("m",$i), date("d",$i), date("Y",$repeatLoop))).' '.$start_time;
                                    $rENDateMonth = date("Y-m-d", mktime(0, 0, 0, date("m",$i), date("d",$i), date("Y",$repeatLoop))).' '.$end_time;
                                    break;
                                }
                            }

                            $eventValues['start']  = $rSTDateMonth;
                            $eventValues['end']    = $rENDateMonth;
                            $myEvents[$this->eventIndex] = $eventValues;

                            $this->eventIndex++;
                            $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*30;
                        }
                        break;

                    case 'yearly':
                        $eventValues['start']  = $rSTDate;
                        $eventValues['end']    = $rENDate;
                        $myEvents[$this->eventIndex] = $eventValues;

                        $this->eventIndex++;
                        $repeatLoop = $repeatLoop + $repeatInterval*(24*60*60)*365;
                        break;

                    default:
                        $repeatLoop = $repeatLoop + ($sault);

                }

                //if($sault > 0)$repeatLoop = $repeatLoop + ($sault);
                //==== repeat ends after is set and loop count is equal to it, then break the loop
                if(isset($res['repeat_end_after']) && $res['repeat_end_after'] > 0){
                    if($repeatCount == $res['repeat_end_after']) break;
                }

                $repeatCount++;
            }
        }


        return $myEvents;
    }

    /**
     * Prepare Events for Calendar to Show.
     * This is for internal use
     *
     * @param $events
     * @return string
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @ignore
     */
    public function prepareEventsForCalendarToShow($events)
    {
        if ($this->dbObj->num_rows($events) <= 0) return NULL;

        $myEvents = false;
        $repeatParams = NULL;
        $this->eventIndex = 0;
        while ($res = $this->dbObj->fetch_array_assoc($events)) {

            $id = $res['id'];
            //$title = htmlspecialchars($res['title'],ENT_QUOTES);
            $title = $res['title'];
            $start_date = $res['start_date'];
            $start_time = $res['start_time'];
            $start_timestamp = $res['start_timestamp'];
            $start = $start_date . ' ' . $start_time;

            $end = '';
            if ($res['end_date'] != NULL) {
                $end_date = $res['end_date'];
                $end_time = $res['end_time'];
                $end_timestamp = $res['end_timestamp'];
                $end = $end_date . ' ' . $end_time;
            }

            //$end = $res['end'];
            $url = $res['url'];
            $borderColor = $res['borderColor'];
            $textColor = $res['textColor'];
            $backgroundColor = $res['backgroundColor'];
            $allDay = isset($res['allDay']) ? $res['allDay'] : '';

            $eventValues = array(
                'id' => $id,
                'title' => $title,
                'start' => '',
                'end' => '',
                'borderColor' => $borderColor,
                'textColor' => $textColor,
                'backgroundColor' => $backgroundColor,
                'allDay' => $allDay
            );

            //==== Handling Repeating Events
            if(!isset($end_time) || is_null($end_time)) $end_time = '';
            $repeatEvents = $this->handleRepeatEvents($res,$eventValues,$start_time,$end_time);


            //====regular events
            $eventValues['start']  = $start;
            $eventValues['end']    = $end;
            if(is_null($repeatEvents)) $myEvents[$this->eventIndex] = $eventValues;
            else $myEvents[$this->eventIndex] = array();


            if(!is_null($repeatEvents)) {
                if(count($myEvents[$this->eventIndex])<=0) unset($myEvents[$this->eventIndex]);
                $myEvents = array_merge($myEvents,$repeatEvents);
            }

            //echo '<pre style="margin-top: 20px; text-align: left">';
            //print_r($myEvents);
            //echo '</pre>';


            /*
            $myEvents[$this->eventIndex] = array(
                'id' => $id,
                'title' => $title,
                'start' => $start,
                'end' => $end,
                'borderColor' => $borderColor,
                'textColor' => $textColor,
                'backgroundColor' => $backgroundColor,
                'allDay' => $allDay
            );
            */


            /*
            foreach($myEvents[$this->eventIndex] as $k=>$v){
                if($v == ' ' || $v == '') unset($myEvents[$this->eventIndex][$k]);
            }
            */

            $this->eventIndex++;

        }

        // Our own custom comparison function

        function fixem($a, $b){
            if ($a["start"] == $b["start"]) { return 0; }
            return ($a["start"] < $b["start"]) ? -1 : 1;
        }

        // Our Call to Sort the Data
        usort($myEvents, "fixem");
        /*
        echo '<pre style="text-align: left">';
            print_r($myEvents);
        echo '</pre>';
        */

        $this->myEvents = $myEvents;

    }

    /**
     * Saves events
     * @param array $params
     * @return bool|integer on success returns the event id, otherwise boolean false
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function saveEvent($params = array())
    {
        return ($this->db->AutoExecute('pec_events', $params, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : false;
    }



    /**
     * Edits events based on event id passed
     * @param array $params
     * @param $id
     * @return bool|integer on success returns the effected event id, otherwise boolean false
     *
     */
    public function editEvent($params = array(), $id)
    {
        return ($this->db->AutoExecute('pec_events', $params, 'UPDATE', "id=$id")) ? $id : false;
    }

    /**
     * Sets a calendar active
     * @param $eventID
     * @return bool|mixed
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function removeEvent($eventID)
    {
        if(!PEC_USER_ID) return false;
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;


        $sql = "DELETE FROM `pec_events` WHERE `id`=$eventID";
        return $isDelete = $dbObj->db_query($sql);

    }


    /**
     * Finds calendar ids with external URL
     * @param string|array $calIds comma separated calendar id Ex: 123,3,12
     * @return bool|mixed
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */

    public static function findExternalURLForCalendars($calIds='')
    {
        if(!isset($_SESSION['userData'])) return false;
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $activeExternalURLForCalendars = false;

        if($calIds=='' || (int)$calIds == 0 || $calIds[0]=='') $sql = "SELECT `id`,`type`,`description`,`color` FROM `pec_calendars` WHERE `type` = 'url'";
        else {
            $calIds = implode(',', $calIds);
            $sql = "SELECT `id`,`type`,`description`,`color` FROM `pec_calendars` WHERE `id` IN ($calIds) AND `type` = 'url'";
        }

        $activeExternalURLForCalendarsData = $dbObj->db_query($sql);

        if ($dbObj->num_rows($activeExternalURLForCalendarsData) > 0) {
            $activeExternalURLForCalendars =  $activeExternalURLForCalendarsData;
        } else $activeExternalURLForCalendars = false;

        return $activeExternalURLForCalendars;

    }


}

?>