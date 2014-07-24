<?php
/**
 * File: cls_reminder.php: Event Reminder Manager
 *
 * Description: Event Reminder Manager for Calendar Application
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 * @ignore
 */

/**
 * Class C_Reminder : User Manager for Calendar Application
 *
 * Description: User Manager for Calendar Application
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Reminder {

    /*
     * @var object $reminder
     */
    public $reminder;

    /*
     * @var Array $guests
     */
    public $guests;

    /*
     * @var Array $reminder_type
     */
    public $reminder_type;

    /*
     * @var Array $reminder_time
     */
    public $reminder_time;

    /*
     * @var Array $reminder_time_unit
     */
    public $reminder_time_unit;

    /*
     * @var int $eventID
     */
    public $eventID;

    /*
     * @var int $userID
     */
    public $userID;

    /*
     * @var object $db
     */
    public $db;


    /**
     * __constructor Method checks user credentials are provided properly or not
     * @param $eventID
     * @param $guests
     * @param $eventID
     * @param $guests
     * @param $reminder_type
     * @param $reminder_time
     * @param $reminder_time_unit
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function __construct($eventID,$guests,$reminder_type,$reminder_time,$reminder_time_unit){
        $this->userID = $_SESSION['userData']['id'];

        $this->reminder_type = $reminder_type;
        $this->reminder_time = $reminder_time;
        $this->reminder_time_unit = $reminder_time_unit;

        if(is_array($guests) && count($guests) > 0) {
            $this->guests = $guests;
            $this->eventID = $eventID;
        }
        else {
            $this->guests = false;
            $this->eventID = 0;
        }

        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;

    }

    public function saveReminders(){
        $reminder_type = $this->reminder_type;
        $reminder_time = $this->reminder_time;
        $reminder_time_unit = $this->reminder_time_unit;

        foreach($reminder_type as $k=>$rType){
            $rData['event_id'] = $this->eventID;
            $rData['type'] = $rType;
            $rData['time'] = $this->reminder_time[$k];
            $rData['time_unit'] = $this->reminder_time_unit[$k];
            $rData['is_repeating_event'] = '0';
            $rData['ts'] = '';
            $rID = ($this->db->AutoExecute('pec_reminders', $rData, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : false;

        }
    }

    public function updateReminders(){
        $eventID = $this->eventID;

        //===delete existing reminders for the current Event here
        C_Reminder::deleteAllRemindersForAnEvent($eventID);
        //===execute save reminder here
        $this->saveReminders();
    }

    /**
     * @param $eventID
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function deleteAllRemindersForAnEvent($eventID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "DELETE FROM `pec_reminders` WHERE `event_id`=$eventID";
        $isDelete = $dbObj->db_query($sql);
    }

    /**
     * Load reminder information
     * @param $eventID
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadReminders($eventID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_reminders` WHERE `event_id`=$eventID";
        $dt = $dbObj->db_query($sql);

        $data = NULL;
        if ($dbObj->num_rows($dt) > 0) {
            while($d = $dbObj->fetch_array($dt)){
                $data[] = $d;
            }
            return $data;
        } else return NULL;

    }


    /**
     * Load All reminders information
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadAllReminders(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_reminders` WHERE 1";
        $dt = $dbObj->db_query($sql);

        $data = NULL;
        if ($dbObj->num_rows($dt) > 0) {
            while($d = $dbObj->fetch_array($dt)){
                $data[] = $d;
            }
            return $data;
        } else return NULL;

    }


    /**
     * Save guest information in the DB
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public function saveGuests()
    {
        $guestData = array();
        $guests = $this->guests;

        foreach($guests as $k => $gData){
            $guestData['event_id']  = $this->eventID;
            $guestData['user_id']   =  $this->userID;
            $guestData['email']     = $gData;
            $gID = ($this->db->AutoExecute('pec_guests', $guestData, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : false;
        }
    }


    /**
     * Save guest information in the DB
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public function updateGuests()
    {
        $eventID = $this->eventID;

        //===delete existing guest emails for the current Event here
        C_Reminder::deleteAllGuestEmailsForAnEvent($eventID);
        //===execute save guest here
        $this->saveGuests();
    }

    /**
     * @param $eventID
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function deleteAllGuestEmailsForAnEvent($eventID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "DELETE FROM `pec_guests` WHERE `event_id`=$eventID";
        $isDelete = $dbObj->db_query($sql);
    }


    /**
     *
     * Load guest information
     * @param $eventID
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadGuests($eventID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_guests` WHERE `event_id`=$eventID";
        $gData = $dbObj->db_query($sql);

        $guestData = NULL;
        if ($dbObj->num_rows($gData) > 0) {
            while($gd = $dbObj->fetch_array($gData)){
                $guestData[] = $gd;
            }
            return $guestData;
        } else return NULL;

    }


    public static function getEventReminders(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //====Load All Reminders
        return $allReminders = C_Reminder::loadAllReminders();

    }

    public static function prepareEventsForReminder(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //====get reminder data
        $reminderData = C_Reminder::getEventReminders();

        foreach($reminderData as $k => $rData){
            $todayTime = time();
            $timeDifferenceBetweenStartAndToday = 0;
            $reminderTime = $rData['time'];
            $reminderTimeUnit = $rData['time_unit'];

            //==== event related variables
            $eventStartTime = 0;
            $isEventRepeating = false;
            $repeatType = '';
            $repeatInterval = 0;
            $repeatEndsOn = '';
            $repeatEndsAfter = '';
            $repeatNever = '';


            //==== get event data
            $eventData = C_Events::loadSingleEventData($rData['event_id']);


            /*
            echo '<pre>';
            print_r($eventData);
            echo '</pre>';
            */

            //=== get event start date
            $eventStartTime = $eventData['start_timestamp'];


            //==== find if it is a repeating event
            $eventStartTimeForRepeatingEvent = 0;
            if($eventData['repeat_type'] != 'none'){
                //====set flag for repeat event as true
                $isEventRepeating = true;
                //==== find start date for the repeating event
                $eventStartTimeForRepeatingEvent = C_Reminder::findStartDateForRepeatingEvent($eventData,$rData,$todayTime,$eventStartTime);
            }

            //=== reset event start time if repeating event time has something
            if($eventStartTimeForRepeatingEvent > 0) $eventStartTime = $eventStartTimeForRepeatingEvent;

            //=== find time deference
            $timeDifferenceBetweenStartAndToday = $eventStartTime - $todayTime;

            //=== abort reminder if the date is already past but this is rare and mostly appear for test cases
            if($timeDifferenceBetweenStartAndToday <= 0 ) continue;

            //==== generate reminder requested time
            $makeRequestedTime = C_Reminder::generateReminderRequestedTime($eventStartTime,$reminderTimeUnit,$reminderTime);

            //==== see if it is time to eligible for an event to be reminded
            if($todayTime >= $makeRequestedTime) {
                //==== this means it is eligible as today time is greater or equal to the requested time
               C_Reminder::sendReminder($eventData,$isEventRepeating);
            }
            else {
                //==== abort
                continue;
            }

        }
    }


    /**
     * @param $eventData
     * @param $todayTime
     * @param $eventStartTime
     * @param $rData
     * @return int
     */
    private static function findStartDateForRepeatingEvent($eventData,$rData,$todayTime,$eventStartTime){
        //==== check if today time is less or equal to event start time, if yes then it is the start time for this repeating event
        //if($todayTime <= $eventStartTime) return $eventStartTime;

        //==== create event object
        $eventObj = new C_Events(0,'GENERAL_PURPOSE');
        $eventValues = array(
            'id' => $eventData['id'],
            'title' => $eventData['title'],
            'start' => '',
            'end' => '',
            'borderColor' => $eventData['borderColor'],
            'textColor' => $eventData['textColor'],
            'backgroundColor' => $eventData['backgroundColor'],
            'allDay' => $eventData['allDay']
        );
        //==== get data for repeating events
        $allRepeatingEvents = $eventObj->handleRepeatEvents($eventData,$eventValues,$eventData['start_time'],$eventData['end_time']);

        //===find time sent if any
        $timeSent = 0;

        if(isset($rData['ts']) && $rData['ts']!=NULL && $rData['ts']!='0000-00-00 00:00:00') {
            $timeSent = strtotime($rData['ts']);
        }

        //==== decide the start date now
        foreach ($allRepeatingEvents as $k=>$repeatEventData){
            $st = strtotime($repeatEventData['start']);
            //echo $todayTime.' -> '.$timeSent.' -> '.$st;
            //echo '<br />';
            if($todayTime <= $st){
                if($timeSent > 0){
                    //==== generate reminder requested time
                    $makeRequestedTime = C_Reminder::generateReminderRequestedTime($st,$rData['time_unit'],$rData['time']);
                    if($timeSent > $makeRequestedTime) continue;

                }
                return $st;
            }

        }
    }

    /**
     * @param $eventData
     * @param $isEventRepeating
     */
    private static function sendReminder($eventData,$isEventRepeating){
        $eventID = $eventData['id'];
        $guests = C_Reminder::loadGuests($eventID);

        //=== reminder code here
        $reminderEmail = '';
        foreach($guests as $k=>$guestData){
            //=== get email template
            require_once(SERVER_HTML_DIR.'emails/reminder-email.html.php');

            $mail = C_Core::sendEmail($guestData['email'],'FullCalendar: Event Reminder',$reminderEmail);
            if($mail != 'sent') {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail;
            } else {
                echo 'Email Sent To: '.$guestData['email'].'<br />';
            }
        }

        //=== check if it is a repeating reminder
        //$isEventRepeating = false;
        if($isEventRepeating) {
            //==== update reminder for next repeating start time
            C_Reminder::updateAReminderForRepeatingEvents($eventData);
        }
        else {
            //==== delete reminder as it is completed
            C_Reminder::deleteAReminder($eventData);
        }
    }

    //==== delete a reminder after sending a reminder
    private static function deleteAReminder($eventData){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $eventID = $eventData['id'];

        $sql = "DELETE FROM `pec_reminders` WHERE `event_id`=$eventID";
        $isDelete = $dbObj->db_query($sql);

        $sql = "DELETE FROM `pec_guests` WHERE `event_id`=$eventID";
        $isDelete = $dbObj->db_query($sql);
    }

    //==== update a reminder for repeating events
    private static function updateAReminderForRepeatingEvents($eventData){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;
        $eventID = $eventData['id'];
        $timeSent = date('Y-m-d H:i');
        $sql = "UPDATE `pec_reminders` SET `is_repeating_event`='1', `ts`='$timeSent' WHERE `event_id`=$eventID";
        $isUpdate = $dbObj->db_query($sql);
    }

    /**
     * @param $eventStartTime
     * @param $reminderTimeUnit
     * @param $reminderTime
     * @return int
     */
    private static function generateReminderRequestedTime($eventStartTime,$reminderTimeUnit,$reminderTime){
        $hour = date('H',$eventStartTime);
        $min = date('i',$eventStartTime);
        $sec = 0;
        $day = date('d',$eventStartTime);
        $month = date('m',$eventStartTime);
        $year = date('Y',$eventStartTime);

        //===calculate requested time
        switch($reminderTimeUnit){
            case 'minute':  $min    = $min - $reminderTime;
                break;
            case 'hour':    $hour   = $hour - $reminderTime;
                break;
            case 'day':     $day    = $day - $reminderTime;
                break;
            case 'week':    $day    = $day - 7*$reminderTime;
                break;
        }

        $makeRequestedTime = mktime($hour,$min,$sec,$month,$day,$year);
        /*
        echo ' '. date('M, d: H i',$makeRequestedTime);
        echo ' ('.$reminderTime.', '.$reminderTimeUnit.')';
        echo '<br />';
        */


        return $makeRequestedTime;

    }






















} 