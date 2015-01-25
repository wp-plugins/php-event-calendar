<?php
/**
 * File: cls_venue.php: Event Venue Manager
 *
 * Description: Event Venue Manager for Calendar Application
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
 * Class C_Venue : User Manager for Calendar Application
 *
 * Description: User Manager for Calendar Application
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Venue {

    /*
     * @var object $venue_name
     */
    public $venue_name;

    /*
     * @var object $address
     */
    public $address;

    /*
     * @var object $city
     */
    public $city;

    /*
     * @var object $country
     */
    public $country;

    /*
     * @var object $state
     */
    public $state;

    /*
     * @var object $post_code
     */
    public $post_code;

    /*
     * @var object $phone
     */
    public $phone;

    /*
     * @var object $website
     */
    public $website;

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
     * @param $venue_name
     * @param $createdDate
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function __construct($userID, $createdDate, $venue_name, $address, $city, $country, $state, $post_code, $phone, $website ){

        $this->createdDate = $createdDate;
        $this->venue_name = $venue_name;
        $this->userID = $userID;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->state = $state;
        $this->post_code = $post_code;
        $this->phone = $phone;
        $this->website = $website;

        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;

    }

    public function saveVenues(){
            $rData['userID'] = $this->userID;
            $rData['venue_name'] = $this->venue_name;
            $rData['createdDate'] = $this->createdDate;
            $rData['address'] = $this->address;
            $rData['city'] = $this->city;
            $rData['country'] = $this->country;
            $rData['state'] = $this->state;
            $rData['post_code'] = $this->post_code;
            $rData['phone'] = $this->phone;
            $rData['website'] = $this->website;
            return ($this->db->AutoExecute('pec_venues', $rData, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : $this->db->Insert_ID();
    }

    public function updateVenues(){
        $userID = $this->userID;

        //===delete existing venue for the current Event here
        C_Venue::deleteAllVenuesForAnEvent($userID);
        //===execute save venue here
        $this->saveVenues();
    }

    /**
     * @param $userID
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function deleteAllVenuesForAnEvent($userID){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $sql = "DELETE FROM `pec_venues` WHERE `event_id`=$userID";
        $isDelete = $dbObj->db_query($sql);
    }

    /**
     * Load venue_name information
     * @param $userID
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadVenues(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_venues`";
        $dt = $dbObj->db_query($sql);

        $data = $dbObj->num_rows($dt);
        return $data;

    }


    /**
     * Load All venue_names information
     * @return Array/NULL
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function loadAllVenues(){
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        //$userID = $_SESSION['userData']['id'];
        $sql = "SELECT * FROM  `pec_venue_names` WHERE 1";
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
//        C_Venue::deleteAllGuestEmailsForAnEvent($userID);
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
//        $sql = "DELETE FROM `pec_venue_name` WHERE `event_id`=$userID";
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
//        $sql = "SELECT * FROM  `pec_venue_name` WHERE `event_id`=$userID";
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
//    public static function getEventVenues(){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        //====Load All Venues
//        return $allVenues = C_Venue::loadAllVenues();
//
//    }
//
//    public static function prepareEventsForVenue(){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        //====get venue_name data
//        $venue_nameData = C_Venue::getEventVenues();
//
//        foreach($venue_nameData as $k => $rData){
//            $todayTime = time();
//            $timeDifferenceBetweenStartAndToday = 0;
//            $venue_nameTime = $rData['time'];
//            $venue_nameTimeUnit = $rData['time_unit'];
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
//                $eventStartTimeForRepeatingEvent = C_Venue::findStartDateForRepeatingEvent($eventData,$rData,$todayTime,$eventStartTime);
//            }
//
//            //=== reset event start time if repeating event time has something
//            if($eventStartTimeForRepeatingEvent > 0) $eventStartTime = $eventStartTimeForRepeatingEvent;
//
//            //=== find time deference
//            $timeDifferenceBetweenStartAndToday = $eventStartTime - $todayTime;
//
//            //=== abort venue_name if the date is already past but this is rare and mostly appear for test cases
//            if($timeDifferenceBetweenStartAndToday <= 0 ) continue;
//
//            //==== generate venue_name requested time
//            $makeRequestedTime = C_Venue::generateVenueRequestedTime($eventStartTime,$venue_nameTimeUnit,$venue_nameTime);
//
//            //==== see if it is time to eligible for an event to be reminded
//            if($todayTime >= $makeRequestedTime) {
//                //==== this means it is eligible as today time is greater or equal to the requested time
//               C_Venue::sendVenue($eventData,$isEventRepeating);
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
//                    //==== generate venue_name requested time
//                    $makeRequestedTime = C_Venue::generateVenueRequestedTime($st,$rData['time_unit'],$rData['time']);
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
//    private static function sendVenue($eventData,$isEventRepeating){
//        $userID = $eventData['id'];
//        $venue_name = C_Venue::loadGuests($userID);
//
//        //=== venue_name code here
//        $venue_nameEmail = '';
//        foreach($venue_name as $k=>$guestData){
//            //=== get email template
//            require_once(SERVER_HTML_DIR.'emails/venue_name-email.html.php');
//
//            $mail = C_Core::sendEmail($guestData['email'],'FullCalendar: Event Venue',$venue_nameEmail);
//            if($mail != 'sent') {
//                echo 'Message could not be sent.';
//                echo 'Mailer Error: ' . $mail;
//            } else {
//                echo 'Email Sent To: '.$guestData['email'].'<br />';
//            }
//        }
//
//        //=== check if it is a repeating venue_name
//        //$isEventRepeating = false;
//        if($isEventRepeating) {
//            //==== update venue_name for next repeating start time
//            C_Venue::updateAVenueForRepeatingEvents($eventData);
//        }
//        else {
//            //==== delete venue_name as it is completed
//            C_Venue::deleteAVenue($eventData);
//        }
//    }
//
//    //==== delete a venue_name after sending a venue_name
//    private static function deleteAVenue($eventData){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//
//        $userID = $eventData['id'];
//
//        $sql = "DELETE FROM `pec_venue_names` WHERE `event_id`=$userID";
//        $isDelete = $dbObj->db_query($sql);
//
//        $sql = "DELETE FROM `pec_venue_name` WHERE `event_id`=$userID";
//        $isDelete = $dbObj->db_query($sql);
//    }
//
//    //==== update a venue_name for repeating events
//    private static function updateAVenueForRepeatingEvents($eventData){
//        //====DB
//        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
//        $db = $dbObj->db;
//        $userID = $eventData['id'];
//        $timeSent = date('Y-m-d H:i');
//        $sql = "UPDATE `pec_venue_names` SET `is_repeating_event`='1', `ts`='$timeSent' WHERE `event_id`=$userID";
//        $isUpdate = $dbObj->db_query($sql);
//    }
//
//    /**
//     * @param $eventStartTime
//     * @param $venue_nameTimeUnit
//     * @param $venue_nameTime
//     * @return int
//     */
//    private static function generateVenueRequestedTime($eventStartTime,$venue_nameTimeUnit,$venue_nameTime){
//        $hour = date('H',$eventStartTime);
//        $min = date('i',$eventStartTime);
//        $sec = 0;
//        $day = date('d',$eventStartTime);
//        $month = date('m',$eventStartTime);
//        $year = date('Y',$eventStartTime);
//
//        //===calculate requested time
//        switch($venue_nameTimeUnit){
//            case 'minute':  $min    = $min - $venue_nameTime;
//                break;
//            case 'hour':    $hour   = $hour - $venue_nameTime;
//                break;
//            case 'day':     $day    = $day - $venue_nameTime;
//                break;
//            case 'week':    $day    = $day - 7*$venue_nameTime;
//                break;
//        }
//
//        $makeRequestedTime = mktime($hour,$min,$sec,$month,$day,$year);
//        /*
//        echo ' '. date('M, d: H i',$makeRequestedTime);
//        echo ' ('.$venue_nameTime.', '.$venue_nameTimeUnit.')';
//        echo '<br />';
//        */
//
//
//        return $makeRequestedTime;
//
//    }
//





















} 