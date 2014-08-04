<?php
include('cls_icalreader.php');
$upload_dir ='/uploads/';
$dir = plugin_dir_url( __FILE__ ).$upload_dir;
$ical = new ical($dir.'mycal.ics');

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
    $dir = str_replace('\\','/',dirname(__FILE__));
    $wp_config_dir = substr($dir,0,strpos($dir,'wp-content'));
    require_once($wp_config_dir."wp-config.php");

    /*$sql = "INSERT INTO `".$table_prefix."pec_events` (`start_date`, `start_time`, `start_timestamp`, `end_date`, `end_time`, `end_timestamp`, `title`, `description`, `created_on`, `updated_on`)
    VALUES ('$start_date', '$start_time', '$start_timestamp', '$end_date', '$end_time', '$end_timestamp', '$summary', '$description', '$created_date', '$modify_date');";
    $wpdb->query($sql);
    */
    $sql = "INSERT INTO `pec_events` (`start_date`, `start_time`, `start_timestamp`, `end_date`, `end_time`, `end_timestamp`, `title`, `description`, `created_on`, `updated_on`)
    VALUES ('$start_date', '$start_time', '$start_timestamp', '$end_date', '$end_time', '$end_timestamp', '$summary', '$description', '$created_date', '$modify_date');";
    $dbcon = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 3306);

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