<?php
/**
 * File: cls_calendars.php: This class has DB operations regarding calendar create/update and loading properties
 *
 * Description: Calendar settings like timezone, time format, default view, date formats, week start day, language etc.
 * It extends C_Calendar_Settings class
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * Class C_Calendar This class has DB operations regarding calendar create/update, loading properties & settings
 *
 * Description: This class has DB operations regarding calendar create/update and loading properties.
 * Also it has calendar settings like timezone, time format, default view, date formats, week start day, language etc.
 * It extends C_Calendar_Settings class
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 * @todo Need to implement calendar settings class in full
 */
class C_Calendar extends C_Calendar_Settings
{
    /**
     * @var integer $id : calendar id
     */
    public $id;

    /**
     * @var integer $type : type of user
     */
    public $type;

    /**
     * @var integer $user_id : current logged in user id
     */
    public $user_id;

    /**
     * @var string $name : calendar name
     */
    public $name;

    /**
     * @var string $description : description of the calendar
     */
    public $description;

    /**
     * @var string $color : color of the calendar
     */
    public $color;

    /**
     * @var integer $admin_id : not in use in version 1.0.1
     */
    public $admin_id;

    /**
     * @var string $status : show/hide status of calendar
     */
    public $status;

    /**
     * @var string $show_in_list : whether to show a calendar in the list or not
     */
    public $show_in_list;

    /**
     * @var int $public : whether a calendar is set to public or not
     */
    public $public;

    /**
     * @var string $reminder_message_email : reminder type as message email, not implemented in version 1.0.1
     */
    public $reminder_message_email;

    /**
     * @var string $reminder_message_popup : reminder type as message popup window, not implemented in version 1.0.1
     */
    public $reminder_message_popup;

    /**
     * @var string $access_key : not in use in this version 1.0.1
     */
    public $access_key;

    /**
     * @var bool|string $created_on : the date of a calendar that has been created
     */
    public $created_on;

    /**
     * @var string $updated_on : the date that a calendar has been updated, not implemented in this version 1.0.1
     */
    public $updated_on;

    /**
     * @var int $errorNo : error numbers
     */
    protected $errorNo;

    /**
     * @var bool $errMsg : determines whether there is an error or not
     */
    protected $errMsg = false;

    /**
     * @var array $errMsgList : list of error messages
     * @uses C_Calendar::$errorNo
     */
    protected $errMsgList = array(
        0 => 'Required params are missing',
        1 => 'DB Error',
        2 => 'Method Not Found'
    );

    /**
     * @var $db : database object
     */
    public $db;

    /**
     * @var $dbObj : C_Database object
     */
    public $dbObj;

    /**
     * @var array|null $allCalendars : list of calendars
     */
    public $allCalendars;

    /**
     * @var null $calendarProperties : calendar properties
     */
    public $calendarProperties;


    /**
     * Constructor function for this class
     *
     * Description: This class can be constructed using calendar properties.
     *
     * During creating an instance of this class using this constructor following things can be happened:
     *
     * 1. Default Calendar Parameters for creating/editing, $name='ANYTHING'
     *
     * 2. Loading My Calendars, Ex: $name = 'LOAD_MY_CALENDARS'
     *
     * 3. Loading Current Calendar's Properties, Ex: $name = 'LOAD_CALENDAR_PROPERTIES'
     *
     * 4. Updating Current Calendar's Properties, Ex: $name = 'UPDATE_CALENDAR_PROPERTIES'
     *
     *
     * @param $name name of the calendar, required
     * @param string $description description of the calendar, required
     * @param string $color color of the calendar, default: #3a87ad
     * @param string $type user type, default: user
     * @param string $status current status for the calendar, default: on
     * @param string $show_in_list whether to show the calendar in the list, not implemented in version 1.0.1
     * @param integer $public whether it is public or private, not implemented in version 1.0.1
     * @param string $reminder_message_email reminder type as email message, not implemented in version 1.0.1
     * @param string $reminder_message_popup reminder type as popup message, not implemented in version 1.0.1
     * @param string $access_key not implemented in this version 1.0.1
     * @param string $created_on created date of the calendar, default: current date
     * @param string $updated_on updated date of the calendar, not implemented in this version 1.0.1
     *
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function __construct($name, $description = '', $color = '#3a87ad', $type = 'user', $status = 'on', $show_in_list = '1', $public = 1, $reminder_message_email = '', $reminder_message_popup = '', $access_key = '', $created_on = '', $updated_on = '')
    {
        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;

        $userID = PEC_USER_ID;

        //==== Load all calendars of the current user
        if ($name == 'LOAD_MY_CALENDARS') {
            $this->allCalendars = $this->loadAllCalendars($userID);

            //==== on page load if there is no calendar selected, then select the first calendar as default calendar
            $activeCalendars = $this->activeCalendarId($userID);
            if($activeCalendars[0] == ''){
                C_User::setActiveCalendar($userID, array($this->allCalendars[0]['id']));
                //$_SESSION['userData']['active_calendar_id'] = array($this->allCalendars[0]['id']);
            }

            //===== If the user does not have any calendar created, or if this is the first time login for the user
            //===== Then create a default calendar for the user
            if ($this->allCalendars == NULL) {
                //==== Create Params Array for saving
                $params['name'] = 'Default Calendar';
                $params['description'] = 'This is a default calendar';
                $params['color'] = '#3a87ad';
                $params['type'] = 'user';
                $params['status'] = 'on';
                $params['show_in_list'] = '1';
                $params['public'] = 0;
                $params['reminder_message_email'] = '';
                $params['reminder_message_popup'] = '';
                $params['access_key'] = '';
                $params['created_on'] = date('Y-m-d');
                $params['updated_on'] = '';
                $this->id = $this->saveCalendar($params);
                $params['id'] = $this->id;

                C_User::setActiveCalendar($userID, array($this->id));
                //==== also update the current session for the user
                $_SESSION['userData']['active_calendar_id'] = array($this->id);

                $this->allCalendars = $this->loadAllCalendars($userID);
            }
            //===== Load Calendar Settings/Properties
            $this->calendarProperties = $this->loadCalendarSettings($userID);

            //===== If the user does not have any calendar settings, then create one by default at the first login
            if ($this->calendarProperties == NULL) {
                //==== Create Params Array for saving
                $params['user_id'] = $userID;
                $params['language'] = 'English';
                $params['time_zone'] = '-12';
                $params['default_view'] = 'month';
                $params['shortdate_format'] = 'MM/DD/YYYY';
                $params['longdate_format'] = 'dddd, DD MMMM YYYY';
                $params['timeformat'] = 'core';
                $params['start_day'] = 'Saturday';
                $params['email_server'] = 'PHPMailer';
                $this->id = $this->saveCalendarSettings($params);
                $params['id'] = $this->id;

                $this->calendarProperties = $this->loadCalendarSettings($userID);
                $_SESSION['calendarData']['properties'] = $this->calendarProperties;
            }
        } //==== Load the calendar properties for current logged in user
        else if ($name == 'LOAD_CALENDAR_PROPERTIES') {
            $this->loadCalendarSettings($userID);
        } //==== Update calendar properties when requested for current logged in user
        else if ($name == 'UPDATE_CALENDAR_PROPERTIES') {
            $params = $_POST;

            //==== load session calendar properties
            $this->calendarProperties = $this->loadCalendarSettings($userID);
            $cal_properties = $this->calendarProperties;
            //==== update calendar settings
            $id = $cal_properties['id'];
            $settingsID = $this->updateCalendarSettings($params, $id);

            //==== load calendar settings again once after update is done
            //$this->calendarProperties = $this->loadCalendarSettings($userID);
            //$_SESSION['calendarData']['properties'] = $this->calendarProperties;
        } //==== setting up the default calendar properties
        else if ($name == 'LOAD_PUBLIC_CALENDARS'){
            $this->calendarProperties = $this->loadPublicCalendarSettings();
        } //==== setting up the default calendar properties
        else {
            //==== Load Calendar Manager
            //$calObj = new C_Calendar($name, $description, $color, $type, $status, $show_in_list, $public, $reminder_message_email, $reminder_message_popup, $access_key, $created_on, $updated_on);

            if ($name == '') {
                $this->errorNo = 0;
                $this->errMsg = $this->errMsgList[$this->errorNo];
                return false;
            } else $this->errMsg = false;

            $this->name = $name;
            $this->description = $description;
            $this->color = $color;
            $this->type = $type;
            $this->status = $status;
            $this->show_in_list = $show_in_list;
            $this->public = $public;
            $this->reminder_message_email = $reminder_message_email;
            $this->reminder_message_popup = $reminder_message_popup;
            $this->access_key = $access_key;
            $this->created_on = date('Y-m-d');
            $this->updated_on = '';

        }

        return true;
    }

    /**
     * Loads all calendar for current logged in user
     *
     * @param integer $userID current logged in user
     * @return array|null if any calendar is found then an array is returned, otherwise NULL will be returned
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function loadAllCalendars($userID)
    {
        $sql = "SELECT * FROM  `pec_calendars` WHERE `user_id` = $userID";
        $allCals = $this->dbObj->db_query($sql);

        $result = NULL;

        if ($this->dbObj->num_rows($allCals) > 0) {
            while ($res = $this->dbObj->fetch_array_assoc($allCals)) {
                $result[] = $res;
            }
        } else return NULL;

        return $result;
    }

    public static function getFirstCalendarID($userID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_calendars` WHERE `user_id` = '$userID' LIMIT 0,1";
        $allCals = $dbObj->db_query($sql);

        $result = NULL;

        if ($dbObj->num_rows($allCals) > 0) {
            while ($res = $dbObj->fetch_array_assoc($allCals)) {
                $result[] = $res;
            }
        }
        else return false;

        $_SESSION['userData']['active_calendar_id'] = array($result[0]['id']);
        return $result[0]['id'];


    }

    /**
     * Loads Single Calendar Data
     *
     * @param $calID
     * @return mixed|null
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadSingleCalendarData($calID)
    {
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $userID = PEC_USER_ID;
        $sql = "SELECT * FROM  `pec_calendars` WHERE `id` IN ($calID) AND `user_id` = $userID";
        $allCals = $dbObj->db_query($sql);

        $result = NULL;

        if ($dbObj->num_rows($allCals) > 0) {
            while ($res = $dbObj->fetch_array_assoc($allCals)) {
                $result[$res['id']] = $res['color'];
            }
        } else return NULL;

        return $result;

    }


    /**
     * Saves a new calendar
     *
     * While saving it finds the current logged in user from session.
     *
     * @param array $params
     * @return bool|integer on success returns inserted calendar id, otherwise returns a boolean false
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function saveCalendar($params = array())
    {
        //==== get current user id
        $params['user_id'] = $_SESSION['userData']['id'];
        return ($this->db->AutoExecute('pec_calendars', $params, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : false;
    }

    /**
     * Edits a given calendar
     *
     * @param array $params
     * @param integer $id
     * @return bool|integer on success returns updated calendar id, otherwise returns a boolean false
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function editCalendar($params = array(), $id)
    {
        return ($this->db->AutoExecute('pec_calendars', $params, 'UPDATE', "id=$id")) ? $id : false;
    }

    /**
     * @param $calID
     */
    public static function setCalToPrivate($calID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "UPDATE `pec_calendars` SET `public`='0' WHERE `id`=$calID";
        $isUpdate = $dbObj->db_query($sql);

    }

    /**
     * @param $calID
     */
    public static function setCalToPublic($calID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "UPDATE `pec_calendars` SET `public`='1' WHERE `id`=$calID";
        $isUpdate = $dbObj->db_query($sql);

    }

    /**
     * @param $link
     * @param $sendTo
     * @param $message
     */

    public static function sendPublicCal($link, $sendTo, $message){
        //=== message code here
        $publicCalendarEmail = '';
        //=== get email template
        require_once(SERVER_HTML_DIR.'emails/public-calendar-email.html.php');

        $mail = C_Core::sendEmail($sendTo,'FullCalendar: Someone has sent you a calendar',$publicCalendarEmail);
        if($mail != 'sent') {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail;
        } else {
            echo 'Email Sent To: '.$sendTo.'<br />';
        }


    }

    /**
     * Updates a new calendar
     *
     * While saving it finds the current logged in user from session.
     *
     * @param array $params
     * @return bool|integer on success returns inserted calendar id, otherwise returns a boolean false
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function updateCalendar($params = array(),$id)
    {
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //==== get current user id
        return ($dbObj->db->AutoExecute('pec_calendars', $params, 'UPDATE', "id=$id") && isset($dbObj->db->_connectionID->insert_id)) ? $dbObj->db->_connectionID->insert_id : false;
    }

    public static function getWeeks($timestamp)
    {
        $maxday    = date("t",$timestamp);
        $thismonth = getdate($timestamp);
        $timeStamp = mktime(0,0,0,$thismonth['mon'],1,$thismonth['year']);    //Create time stamp of the first day from the give date.
        $startday  = date('w',$timeStamp);    //get first day of the given month
        $day = $thismonth['mday'];
        $weeks = 0;
        $week_num = 0;

        for ($i=0; $i<($maxday+$startday); $i++) {
            if(($i % 7) == 0){
                $weeks++;
            }
            if($day == ($i - $startday + 1)){
                $week_num = $weeks;
            }
        }
        return $week_num;
    }

    /**
     * Export a calendar
     *
     * While exporting the calendar it will fetch all events information in this calID.
     *
     * @param array $calID
     * @return exported data into a .ics file
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function exportCalendar($calID)
    {
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_calendars` WHERE `id` IN ($calID) AND `user_id` = $userID";
        $allCals = $dbObj->db_query($sql);

        $sql2 = "SELECT * FROM  `pec_settings` WHERE `user_id` = $userID";
        $setCals = $dbObj->db_query($sql2);

        $sql3 = "SELECT * FROM  `pec_events` WHERE `cal_id` = $calID";
        $events = $dbObj->db_query($sql3);

        $resultStart = NULL;
        $calName = '';

        $resultStart = "BEGIN:VCALENDAR
PRODID:-//PEC Inc//PHP Event Calendar//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH";

        if ($dbObj->num_rows($allCals) > 0) {
            while ($res = $dbObj->fetch_array_assoc($allCals)) {
                $calName = $res['name'];
                $resultStart .= "X-WR-CALNAME:".$calName;
            }
        }
        else
            $calName = null;

        $tZone = "0000";
        if ($dbObj->num_rows($setCals) > 0) {
            while ($set = $dbObj->fetch_array_assoc($setCals)) {
                $tZone = ($set['time_zone'] > 0)? '+'.$set['time_zone']."00" : $set['time_zone']."00";
                //$timezone = '+0:00';
                $timezone = preg_replace('/[^0-9]/', '', $tZone) * 36;
                $timezone_name = timezone_name_from_abbr(null, $timezone, true);

            }
        }
        else{
            $tZone = null; $timezone_name = null;
        }
        $resultStart .= "
X-WR-TIMEZONE:".$timezone_name."
BEGIN:VTIMEZONE
TZID:".$timezone_name."
X-LIC-LOCATION:".$timezone_name."
BEGIN:STANDARD
TZOFFSETFROM:".$tZone."
TZOFFSETTO:".$tZone."
TZNAME:".$timezone_name."
DTSTART:19700101T000000
END:STANDARD
END:VTIMEZONE";
        $eventDetails = null;
        if ($dbObj->num_rows($events) > 0) {
            while ($event = $dbObj->fetch_array_assoc($events)) {
                $startDate = str_replace("-","",$event['start_date']);
                $startTime = str_replace(":","",$event['start_time']);

                $endDate = str_replace("-","",$event['end_date']);
                $endTime = str_replace(":","",$event['end_time']);

                if($startDate > $endDate){
                    $endDate = $startDate;
                }

                if($event['allDay'] == 'on'){
                    $start = ';VALUE=DATE:'.$startDate;
                    $end = ';VALUE=DATE:'.$endDate;
                }
                else{
                    $start = ";TZID=".$timezone_name.":".$startDate."T".$startTime."00";
                    $end = ";TZID=".$timezone_name.":".$endDate."T".$endTime."00";
                }

                if($event['repeat_type'] == 'none'){
                    $repeatType = null;
                }
                else
                    $repeatType = "
RRULE:FREQ=".$event['repeat_type'];

                if($event['repeat_end_after'] > 0){
                    $count = ";COUNT=".$event['repeat_end_after'];
                }
                else
                    $count = null;

                if($event['repeat_end_on'] == NULL || $event['repeat_end_on'] == '0000-01-01'){
                    $until = null;
                }
                else{
                    $untilDate = str_replace("-","",$event['repeat_end_on']);
                    $until = ";UNTIL=".$untilDate."T".$endTime."00";
                }



                if($event['repeat_by'] == 'repeat_by_day_of_the_month' && $event['repeat_type']=='monthly'){
                    $day = date('d', $event['start_timestamp']);
                    $repeatBy = ";BYMONTHDAY=".$day;
                }
                else if($event['repeat_by'] == 'repeat_by_day_of_the_week' && $event['repeat_type']=='monthly'){
                    $eventDay = date('N', $event['start_timestamp']);
                    $firstDay = (new DateTime($startDate));
                    $firstDay = $firstDay->modify('first day of this month')->format('N');
                    $weekDay = C_Calendar::getWeeks($event['start_timestamp']);
                    $weekDay = ($firstDay > $eventDay) ? $weekDay-1:$weekDay;
                    $day = substr(date('D', $event['start_timestamp']),0,2);
                    $repeatBy = ";BYDAY=".$weekDay.$day;
                }
                else
                    $repeatBy = null;

                if($event['repeat_type'] == 'everyMWFDay'){
                    $mwf = ";BYDAY=MO,WE,FR";
                    $repeatType = "
RRULE:FREQ=WEEKLY";
                }
                else if($event['repeat_type'] == 'everyWeekDay'){
                    $mwf = ";BYDAY=MO,TU,WE,TH,FR";
                    $repeatType = "
RRULE:FREQ=WEEKLY";
                }
                else if($event['repeat_type'] == 'everyTTDay'){
                    $mwf = ";BYDAY=TU,TH";
                    $repeatType = "
RRULE:FREQ=WEEKLY";
                }
                else
                    $mwf = null;

                if($event['repeat_type'] == 'weekly'){
                    $byDay = "";
                    $byDay .= ($event['repeat_on_sun'] == 1)? ",SU" : "";
                    $byDay .= ($event['repeat_on_mon'] == 1)? ",MO" : "";
                    $byDay .= ($event['repeat_on_tue'] == 1)? ",TU" : "";
                    $byDay .= ($event['repeat_on_wed'] == 1)? ",WE" : "";
                    $byDay .= ($event['repeat_on_thu'] == 1)? ",TH" : "";
                    $byDay .= ($event['repeat_on_fri'] == 1)? ",FR" : "";
                    $byDay .= ($event['repeat_on_sat'] == 1)? ",SA" : "";
                    $byDay = ";BYDAY=".substr($byDay, 1);
                }
                else
                    $byDay = null;

                if($event['repeat_interval'] > 0){
                    $interval = ";INTERVAL=".$event['repeat_interval'];
                }
                else
                    $interval = null;

                $thisDate = date('Ymd');
                $thisTime = date('His');
                $dtStamp = $thisDate."T".$thisTime."Z";



                $eventDetails .= "
BEGIN:VEVENT
DTSTART".$start."
DTEND".$end
                    .$repeatType.$count.$until.$repeatBy.$interval.$mwf.$byDay."
DTSTAMP:".$dtStamp."
UID:".$event['id']."
CREATED:".$event['created_on']."
DESCRIPTION:".$event['description']."
LAST-MODIFIED:".$event['updated_on']."
LOCATION:".$event['location']."
SEQUENCE:0
STATUS:".$event['invitation_response']."
SUMMARY:".$event['title']."
TRANSP:
END:VEVENT";
            }
        }
        $resultEnd = "
END:VCALENDAR";

        $thisDate = date('Ymd');
        $thisTime = date('His');

        $calName = str_replace(" ","-",$calName);
        $fileName = $calName."-".$thisDate.$thisTime.".ics";
        $folder = "temp/".$fileName;
        $directory = BASE_DIR.$folder;
        $file = fopen($directory,"w");

        $data = $resultStart.$eventDetails.$resultEnd;
        fwrite($file,$data);
        fclose($file);
        /*
        if($eventDetails == null){
            echo "fail";
        }
        else*/
        echo $folder;

        //return $directory;

    }

    public static function activeCalendarId($userID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;


        $sql = "SELECT `active_calendar_id` FROM  `pec_users` WHERE `id` = $userID";
        $allCal = $dbObj->db_query($sql);

        $result = NULL;

        if ($dbObj->num_rows($allCal) > 0) {
            while ($res = $dbObj->fetch_array_assoc($allCal)) {
                $result[] = $res['active_calendar_id'];
            }
        } else return NULL;

        return $result;

    }

}

?>