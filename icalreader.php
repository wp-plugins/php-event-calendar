<?php
require_once ('conf.php');

include('cls_icalreader.php');
$dbcon = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//== Check and Insert user info if current user never import an ics file.
global $current_user; get_currentuserinfo();
$timezone = get_option('gmt_offset');
$select_sql = "SELECT * FROM `pec_users` WHERE `admin_id`='$current_user->ID' ";

$insert_sql = "INSERT INTO `pec_users` (`access_key`, `activated`, `admin_id`, `role`, `first_name`, `last_name`, `active_calendar_id`, `company`, `username`, `password`, `email`, `timezone`, `language`, `theme`, `kbd_shortcuts`, `created_on`, `updated_on`)
VALUES('1', 1, '$current_user->ID', 'super', '$current_user->user_firstname', '$current_user->user_lastname', '0', 'Highpitch', '$current_user->user_login', '$current_user->user_pass', '$current_user->user_email', '$timezone', 'English', 'default', 1, '', '')";
$result = mysqli_query($dbcon,$select_sql);
if(mysqli_num_rows($result) < 1)
    mysqli_query($dbcon, $insert_sql);

$upload_dir ='/uploads/';
$upload_dir_params = wp_upload_dir();
//$dir = plugin_dir_path( __FILE__ ).$upload_dir; //plugin directory can not be used for uploading files
$dir = $upload_dir_params['path']; //this has to be WP's upload dir

$ical = new ical($dir.'/mycal.ics');
$cal_name = $ical->cal_name;
$cal_desc = $ical->cal_desc;
$today = date('Y-m-d');

//=== Check and insert calendar info
//=== for lite version, there will be one calendar only, even for multiple imports
//$cal_select = "SELECT * FROM `pec_calendars` WHERE `name`='$cal_name' AND `user_id`='$current_user->ID' ";
$cal_select = "SELECT * FROM `pec_calendars` WHERE `user_id`='$current_user->ID' ";

//==== for lite version, calendar name will be always same = '$cal_name="Default Calendar"';
$cal_name = 'Default Calendar';
$cal_desc = 'Default Calendar';

$cal_insert = "INSERT INTO `pec_calendars` (`type`, `user_id`, `name`, `description`, `color`, `admin_id`, `status`, `show_in_list`, `public`, `reminder_message_email`, `reminder_message_popup`, `access_key`, `created_on`, `updated_on`) VALUES
('user', '$current_user->ID', '$cal_name', '$cal_desc', '#3a87ad', NULL, 'on', '1', 0, '', '', '', '$today', NULL)";

$resultCal = mysqli_query($dbcon,$cal_select);
if(mysqli_num_rows($resultCal) <= 0){
    mysqli_query($dbcon, $cal_insert);
}

//=== for lite version, there will be one calendar only, even for multiple imports
//$cal_id = mysqli_fetch_array(mysqli_query($dbcon,"SELECT `id` FROM `pec_calendars` WHERE `name`='$cal_name' AND `user_id`='$current_user->ID' "));
$cal_id = mysqli_fetch_array(mysqli_query($dbcon,"SELECT `id` FROM `pec_calendars` WHERE `user_id`='$current_user->ID' "));
$calID = $cal_id['id'];

//==== update for active calendar into pec_user table
$user_update = "UPDATE `pec_users` SET `active_calendar_id` = '$calID'";
if(mysqli_num_rows($resultCal) <= 0){
    mysqli_query($dbcon, $user_update);
}

$events = $ical->get_event_array();

//echo "Cal Name ".$events['X-WR-CALNAME']."<br>";
//echo "Cal Desc ".$events['X-WR-CALDESC']."<br>";
if(!is_array($events)){ die(''); }

foreach($events as $event){

    $start_date = substr($event['DTSTART'], 0, 8);
    $start_time = substr($event['DTSTART'], 9, 6);

    if(isset($event['DTEND'])){
        $end_date = substr($event['DTEND'], 0, 8);
        $end_time = substr($event['DTEND'], 9, 6);
    }

    $created_date = substr($event['CREATED'], 0, 8);
    $created_time = substr($event['CREATED'], 9, 6);

    $modify_date = substr($event['LAST-MODIFIED'], 0, 8);
    $modify_time = substr($event['LAST-MODIFIED'], 9, 6);


    // Prepare start & End Date-Time to insert in full calendar DB
    if($start_date != null){
        $start_date = substr_replace($start_date,'-',4,0);
        $start_date = substr_replace($start_date,'-',7,0);
    }

    if($end_date != null){
        $end_date = substr_replace($end_date,'-',4,0);
        $end_date = substr_replace($end_date,'-',7,0);
    }

    if($start_time != null){
        $start_time = substr_replace($start_time,':',2,0);
        $start_time = substr($start_time, 0, 5);
    }

    if($end_time != null){
        $end_time = substr_replace($end_time,':',2,0);
        $end_time = substr($end_time, 0, 5);
    }

    //===determining all day event
    $allDayEvent = false; //--- set it false by default
    $allDay = '';
    if($start_time == false || empty($start_time) || $start_time == ''){
        //=== its a all day event
        $start_time = '00:00';
        $allDayEvent = true;
    }
    if($end_time == false || empty($end_time) || $end_time == ''){
        //=== its a all day event
        $end_time = '00:00';
        $allDayEvent = true;
    }

    //=== set allDay param on if it is a allDay event
    if($allDayEvent){
        $allDay = 'on';
    }


    //-------------------------------------------------------
    //--------- Created and Last Modified Date Time --------
    if($modify_date != null){
        $modify_date = substr_replace($modify_date,'-',4,0);
        $modify_date = substr_replace($modify_date,'-',7,0);
    }

    if($created_date != null){
        $created_date = substr_replace($created_date,'-',4,0);
        $created_date = substr_replace($created_date,'-',7,0);
    }

    if($modify_time != null){
        $modify_time = substr_replace($modify_time,':',2,0);
        $modify_time = substr($modify_time, 0, 5);
    }

    if($created_time != null){
        $created_time = substr_replace($created_time,':',2,0);
        $created_time = substr($created_time, 0, 5);
    }
    //----------------------------------------------------------

    $start_timestamp = strtotime($start_date." ".$start_time);
    $end_timestamp = strtotime($end_date." ".$end_time);

    $description = isset($event['DESCRIPTION'])?$event['DESCRIPTION']:'';
    $summary = isset($event['SUMMARY'])?$event['SUMMARY']:'';
    $status = isset($event['STATUS'])?$event['STATUS']:'';
/*
    echo "DTstart ".$start_date." ".$start_time."<br>";
    echo "DTend ".$end_date." ".$end_time."<br>";
    echo "DTtimestamp ".$start_timestamp."<br>";
    echo "Description: ".$description."<br>";
    echo "Summary: ".$summary."<br>";
    echo "Created: ".$created_date." ".$created_time."<br>";
    echo "Modified: ".$modify_date." ".$modify_time."<br>";
    echo "Status: ".$status."<br>";
*/
    //global $wpdb, $table_prefix;
    //$dir = str_replace('\\','/',dirname(__FILE__));
    //$wp_config_dir = substr($dir,0,strpos($dir,'wp-content'));
    //require_once($wp_config_dir."wp-config.php");

    /*$sql = "INSERT INTO `".$table_prefix."pec_events` (`start_date`, `start_time`, `start_timestamp`, `end_date`, `end_time`, `end_timestamp`, `title`, `description`, `created_on`, `updated_on`)
    VALUES ('$start_date', '$start_time', '$start_timestamp', '$end_date', '$end_time', '$end_timestamp', '$summary', '$description', '$created_date', '$modify_date');";
    $wpdb->query($sql);
    */
    //str_replace('0','','+0600');
    $sql = "INSERT INTO `pec_events` (`cal_id`, `start_date`, `start_time`, `start_timestamp`, `end_date`, `end_time`, `end_timestamp`, `title`, `description`, `created_on`, `updated_on`,`allDay`)
    VALUES ('$cal_id[id]', '$start_date', '$start_time', '$start_timestamp', '$end_date', '$end_time', '$end_timestamp', '$summary', '$description', '$created_date', '$modify_date','$allDay');";

    $select_qry = "SELECT * FROM `pec_events` WHERE `start_date`='$start_date' AND `title`='$summary' ";
    $result = mysqli_query($dbcon, $select_qry);
    if($result!=false){
        $select_row = mysqli_num_rows($result);
        if($select_row == 0)
        mysqli_query($dbcon, $sql);
    }


}



//print_r( $events );
?>