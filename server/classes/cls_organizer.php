<?php
/**
 * File: cls_organizer.php: Event Organizer Manager
 *
 * Description: Event Organizer Manager for Calendar Application
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
 * Class C_Organizer : User Manager for Calendar Application
 *
 * Description: User Manager for Calendar Application
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Organizer {

    /*
     * @var object $organizer
     */
    public $organizer;

    /*
     * @var Array $createdDate
     */
    public $createdDate;

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
     * @param $userID
     * @param $organizer
     * @param $createdDate
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function __construct($userID,$organizer,$createdDate){
        $this->userID = PEC_USER_ID;

        $this->createdDate = $createdDate;

        //if(is_array($organizer) && count($organizer) > 0) {
            $this->organizer = $organizer;
            $this->userID = $userID;
        /*}
        else {
            $this->organizer = false;
            $this->userID = 0;
        }*/

        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;

    }

    public function saveOrganizers(){
            $rData['userID'] = $this->userID;
            $rData['organizer'] = $this->organizer;
            $rData['createdDate'] = $this->createdDate;
            return ($this->db->AutoExecute('pec_organizers', $rData, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : $this->db->Insert_ID();
    }

    public function updateOrganizers(){
        $userID = $this->userID;

        //===delete existing organizers for the current Event here
        C_Organizer::deleteAllOrganizersForAnEvent($userID);
        //===execute save organizer here
        $this->saveOrganizers();
    }

    /**
     * @param $userID
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function deleteAllOrganizersForAnEvent($userID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "DELETE FROM `pec_organizers` WHERE `event_id`=$userID";
        $isDelete = $dbObj->db_query($sql);
    }

    /**
     * Load organizer information
     * @param $userID
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadOrganizers(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_organizers`";
        $dt = $dbObj->db_query($sql);

        $data = $dbObj->num_rows($dt);
        return $data;

    }


    /**
     * Load All organizers information
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadAllOrganizers(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_organizers` WHERE 1";
        $dt = $dbObj->db_query($sql);

        $data = NULL;
        if ($dbObj->num_rows($dt) > 0) {
            while($d = $dbObj->fetch_array($dt)){
                $data[] = $d;
            }
            return $data;
        } else return NULL;

    }
//
//    /**
//     * Save guest information in the DB
//     * @author Richard Z.C. <info@phpeventcalendar.com>
//     *
//     */
//    public function updateGuests()
//    {
//        $userID = $this->userID;
//
//        //===delete existing guest emails for the current Event here
//        C_Organizer::deleteAllGuestEmailsForAnEvent($userID);
//        //===execute save guest here
//        $this->saveGuests();
//    }
//
//    /**
//     * @param $userID
//     * @author Richard Z.C. <info@phpeventcalendar.com>
//     */
//    public static function deleteAllGuestEmailsForAnEvent($userID){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        $sql = "DELETE FROM `pec_organizer` WHERE `event_id`=$userID";
//        $isDelete = $dbObj->db_query($sql);
//    }
//
//
//    /**
//     *
//     * Load guest information
//     * @param $userID
//     * @return Array/NULL
//     *
//     * @author Richard Z.C. <info@phpeventcalendar.com>
//     *
//     */
//    public static function loadGuests($userID){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        //$userID = $_SESSION['userData']['id'];
//        $sql = "SELECT * FROM  `pec_organizer` WHERE `event_id`=$userID";
//        $gData = $dbObj->db_query($sql);
//
//        $guestData = NULL;
//        if ($dbObj->num_rows($gData) > 0) {
//            while($gd = $dbObj->fetch_array($gData)){
//                $guestData[] = $gd;
//            }
//            return $guestData;
//        } else return NULL;
//
//    }
//
//
//    public static function getEventOrganizers(){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        //====Load All Organizers
//        return $allOrganizers = C_Organizer::loadAllOrganizers();
//
//    }
//
//    public static function prepareEventsForOrganizer(){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        //====get organizer data
//        $organizerData = C_Organizer::getEventOrganizers();
//
//        foreach($organizerData as $k => $rData){
//            $todayTime = time();
//            $timeDifferenceBetweenStartAndToday = 0;
//            $organizerTime = $rData['time'];
//            $organizerTimeUnit = $rData['time_unit'];
//
//            //==== event related variables
//            $eventStartTime = 0;
//            $isEventRepeating = false;
//            $repeatType = '';
//            $repeatInterval = 0;
//            $repeatEndsOn = '';
//            $repeatEndsAfter = '';
//            $repeatNever = '';
//
//
//            //==== get event data
//            $eventData = C_Events::loadSingleEventData($rData['event_id']);
//
//
//            /*
//            echo '<pre>';
//            print_r($eventData);
//            echo '</pre>';
//            */
//
//            //=== get event start date
//            $eventStartTime = $eventData['start_timestamp'];
//
//
//            //==== find if it is a repeating event
//            $eventStartTimeForRepeatingEvent = 0;
//            if($eventData['repeat_type'] != 'none'){
//                //====set flag for repeat event as true
//                $isEventRepeating = true;
//                //==== find start date for the repeating event
//                $eventStartTimeForRepeatingEvent = C_Organizer::findStartDateForRepeatingEvent($eventData,$rData,$todayTime,$eventStartTime);
//            }
//
//            //=== reset event start time if repeating event time has something
//            if($eventStartTimeForRepeatingEvent > 0) $eventStartTime = $eventStartTimeForRepeatingEvent;
//
//            //=== find time deference
//            $timeDifferenceBetweenStartAndToday = $eventStartTime - $todayTime;
//
//            //=== abort organizer if the date is already past but this is rare and mostly appear for test cases
//            if($timeDifferenceBetweenStartAndToday <= 0 ) continue;
//
//            //==== generate organizer requested time
//            $makeRequestedTime = C_Organizer::generateOrganizerRequestedTime($eventStartTime,$organizerTimeUnit,$organizerTime);
//
//            //==== see if it is time to eligible for an event to be reminded
//            if($todayTime >= $makeRequestedTime) {
//                //==== this means it is eligible as today time is greater or equal to the requested time
//               C_Organizer::sendOrganizer($eventData,$isEventRepeating);
//            }
//            else {
//                //==== abort
//                continue;
//            }
//
//        }
//    }
//
//
//    /**
//     * @param $eventData
//     * @param $todayTime
//     * @param $eventStartTime
//     * @param $rData
//     * @return int
//     */
//    private static function findStartDateForRepeatingEvent($eventData,$rData,$todayTime,$eventStartTime){
//        //==== check if today time is less or equal to event start time, if yes then it is the start time for this repeating event
//        //if($todayTime <= $eventStartTime) return $eventStartTime;
//
//        //==== create event object
//        $eventObj = new C_Events(0,'GENERAL_PURPOSE');
//        $eventValues = array(
//            'id' => $eventData['id'],
//            'title' => $eventData['title'],
//            'start' => '',
//            'end' => '',
//            'borderColor' => $eventData['borderColor'],
//            'textColor' => $eventData['textColor'],
//            'backgroundColor' => $eventData['backgroundColor'],
//            'allDay' => $eventData['allDay']
//        );
//        //==== get data for repeating events
//        $allRepeatingEvents = $eventObj->handleRepeatEvents($eventData,$eventValues,$eventData['start_time'],$eventData['end_time']);
//
//        //===find time sent if any
//        $timeSent = 0;
//
//        if(isset($rData['ts']) && $rData['ts']!=NULL && $rData['ts']!='0000-00-00 00:00:00') {
//            $timeSent = strtotime($rData['ts']);
//        }
//
//        //==== decide the start date now
//        foreach ($allRepeatingEvents as $k=>$repeatEventData){
//            $st = strtotime($repeatEventData['start']);
//            //echo $todayTime.' -> '.$timeSent.' -> '.$st;
//            //echo '<br />';
//            if($todayTime <= $st){
//                if($timeSent > 0){
//                    //==== generate organizer requested time
//                    $makeRequestedTime = C_Organizer::generateOrganizerRequestedTime($st,$rData['time_unit'],$rData['time']);
//                    if($timeSent > $makeRequestedTime) continue;
//
//                }
//                return $st;
//            }
//
//        }
//    }
//
//    /**
//     * @param $eventData
//     * @param $isEventRepeating
//     */
//    private static function sendOrganizer($eventData,$isEventRepeating){
//        $userID = $eventData['id'];
//        $organizer = C_Organizer::loadGuests($userID);
//
//        //=== organizer code here
//        $organizerEmail = '';
//        foreach($organizer as $k=>$guestData){
//            //=== get email template
//            require_once(SERVER_HTML_DIR.'emails/organizer-email.html.php');
//
//            $mail = C_Core::sendEmail($guestData['email'],'FullCalendar: Event Organizer',$organizerEmail);
//            if($mail != 'sent') {
//                echo 'Message could not be sent.';
//                echo 'Mailer Error: ' . $mail;
//            } else {
//                echo 'Email Sent To: '.$guestData['email'].'<br />';
//            }
//        }
//
//        //=== check if it is a repeating organizer
//        //$isEventRepeating = false;
//        if($isEventRepeating) {
//            //==== update organizer for next repeating start time
//            C_Organizer::updateAOrganizerForRepeatingEvents($eventData);
//        }
//        else {
//            //==== delete organizer as it is completed
//            C_Organizer::deleteAOrganizer($eventData);
//        }
//    }
//
//    //==== delete a organizer after sending a organizer
//    private static function deleteAOrganizer($eventData){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        $userID = $eventData['id'];
//
//        $sql = "DELETE FROM `pec_organizers` WHERE `event_id`=$userID";
//        $isDelete = $dbObj->db_query($sql);
//
//        $sql = "DELETE FROM `pec_organizer` WHERE `event_id`=$userID";
//        $isDelete = $dbObj->db_query($sql);
//    }
//
//    //==== update a organizer for repeating events
//    private static function updateAOrganizerForRepeatingEvents($eventData){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//        $userID = $eventData['id'];
//        $timeSent = date('Y-m-d H:i');
//        $sql = "UPDATE `pec_organizers` SET `is_repeating_event`='1', `ts`='$timeSent' WHERE `event_id`=$userID";
//        $isUpdate = $dbObj->db_query($sql);
//    }
//
//    /**
//     * @param $eventStartTime
//     * @param $organizerTimeUnit
//     * @param $organizerTime
//     * @return int
//     */
//    private static function generateOrganizerRequestedTime($eventStartTime,$organizerTimeUnit,$organizerTime){
//        $hour = date('H',$eventStartTime);
//        $min = date('i',$eventStartTime);
//        $sec = 0;
//        $day = date('d',$eventStartTime);
//        $month = date('m',$eventStartTime);
//        $year = date('Y',$eventStartTime);
//
//        //===calculate requested time
//        switch($organizerTimeUnit){
//            case 'minute':  $min    = $min - $organizerTime;
//                break;
//            case 'hour':    $hour   = $hour - $organizerTime;
//                break;
//            case 'day':     $day    = $day - $organizerTime;
//                break;
//            case 'week':    $day    = $day - 7*$organizerTime;
//                break;
//        }
//
//        $makeRequestedTime = mktime($hour,$min,$sec,$month,$day,$year);
//        /*
//        echo ' '. date('M, d: H i',$makeRequestedTime);
//        echo ' ('.$organizerTime.', '.$organizerTimeUnit.')';
//        echo '<br />';
//        */
//
//
//        return $makeRequestedTime;
//
//    }
//





















} 