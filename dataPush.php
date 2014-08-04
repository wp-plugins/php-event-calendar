<?php
/**
 * Plugin Name: PHP Event Calendar
 * Plugin URI: http://phpeventcalendar.com/
 * Description: PHP Event Calendar can import and display your calendars from PHP Event Calendar, Google Calendar, Microsoft Outlook, Apple Calendar
 * and any other application that export events in standard iCalendar format (file extension .ics) in your WordPress site.
 * Version: 1.0
 * Author: PHPControls Inc.
 * Author URI: http://phpcontrols.com/
 * License: GPL2
 */

global $db_version;
$db_version = "1.0";
    /* This part is important to enable a menu item linked with external source :)
    add_filter( 'wp_list_pages', 'my_menu_link' );
    add_filter( 'wp_nav_menu_items', 'my_menu_link' );

    function my_menu_link($items) {
        //global $wp_query;

        $title = 'my title';
        $dir = plugin_dir_url( __FILE__ );
        $url = $dir.'calendar.php';
        $class ='menu-item';

        //perform query to add 'active' class when appropriate.
        if(true) $class = 'current_page_item';

        $menu_link = '<li class="'.$class.'"><a href="'.$url.'">'.$title.'</a></li>';
        $items = $items . $menu_link;
        return $items;
    }
    */

    add_thickbox();
    function pec_admin_settings_style()
    {
        if (is_admin()) {
            // Register the style like this for a plugin:
            wp_register_style( 'pec-wp-admin-settings', plugins_url( 'css/pec-wp-admin-settings.css', __FILE__ ));
            // or
            // Register the style like this for a theme:
            // wp_register_style( 'pec-admin-settings-style', get_template_directory_uri() . '/css/pec-wp-admin-settings');
         
            // For either a plugin or a theme, you can then enqueue the style:
            wp_enqueue_style( 'pec-wp-admin-settings' );
        }
    }
    add_action( 'admin_enqueue_scripts', 'pec_admin_settings_style' );

    function pec_wp_user_style()
    {
        if (!is_admin()) {
            // Register the style like this for a plugin:
            wp_register_style( 'pec-wp-user', plugins_url( 'css/pec-wp-user.css', __FILE__ ));
            wp_enqueue_style( 'pec-wp-user' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'pec_wp_user_style' );


    function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    function table_install() {
        $dir = plugin_dir_path( __FILE__ );
        $location = $dir.'full_calendar.php';
        global $wpdb;
        global $db_version;

        //load file
        $commands ='';
        include($location);

        //delete comments
        /*
        $lines = explode("\n",$commands);
        $commands = '';
        foreach($lines as $line){
            $line = trim($line);
            if( $line && ! startsWith($line,'--') ){
                $commands .= $line . "\n";
            }
        }
        */
        //convert to array
        $commands = explode(";", $commands);

        //run commands
        $total = $success = 0;
        foreach($commands as $command){
            if(trim($command)){
                $success += (@$wpdb->query($command)==false ? 0 : 1);
                $total += 1;
            }
        }

        //return number of successful queries and total number of queries found
        return array(
            "success" => $success,
            "total" => $total
        );

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        add_option( "db_version", $db_version );
    }



// Create tables on plugin activation
register_activation_hook(__FILE__, 'table_install');

//require_once 'uninstall.php'; register_uninstall_hook( __FILE__, 'table_uninstall' );
require_once 'uninstall.php'; register_deactivation_hook( __FILE__, 'table_uninstall' );

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new top-level menu (ill-advised):
    add_menu_page(__('PHP Event Calendar','menu-test'), __('Event Calendar','menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_settings_page', plugins_url( 'images/pec-logo-icon-20x20.png', __FILE__ ) );
}



/*######################*/
// mt_settings_page() displays the page content for upload ics file
    function mt_settings_page() {

        //must check that the user has the required capability
        if (!current_user_can('manage_options'))
        {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }

        // variables for the field and option names

        $hidden_field_name = 'mt_submit_hidden';
        $data_file_name = 'fupload';
        $data_file_name_url = 'urlupload';
        $upload_dir ='uploads';
        $dir = plugin_dir_path( __FILE__ ).$upload_dir;

        function getHeaders($url)
        {
            $ch = curl_init($url);
            curl_setopt( $ch, CURLOPT_NOBODY, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
            curl_setopt( $ch, CURLOPT_HEADER, false );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 3 );
            curl_exec( $ch );
            $headers = curl_getinfo( $ch );
            curl_close( $ch );

            return $headers;
        }

        function download($url, $path)
        {
            # open file to write
            $fp = fopen ($path, 'w+');
            # start curl
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            # set return transfer to false
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
            curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/calendar','Depth: 1'));
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_SSLVERSION,3);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');//New added. Removed curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND')
            # increase timeout to download big file
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
            # write data to local file
            curl_setopt( $ch, CURLOPT_FILE, $fp );
            # execute curl
            curl_exec( $ch );
            $error = curl_error($ch);
            # close curl
            curl_close( $ch );
            # close local file
            fclose( $fp );

            if (filesize($path) > 0) return true;
        }
        //Upload data from url
        if(isset($_POST[$data_file_name_url])){
            $url = $_POST[$data_file_name_url];
            $path = $dir.'/mycal.ics';
            $status_flag=0;
            $headers = getHeaders($url);
            //echo $headers['http_code'].'- http code </br>';
            //echo 'Download content length : '.$headers['download_content_length'].'</br>';
            if (($headers['http_code'] === 0 || $headers['http_code'] === 200 || $headers['http_code'] === 2000 || $headers['http_code'] === 302) and $headers['download_content_length'] < 1024*1024) {
                if (download($url, $path)){
                    //echo 'Download complete!';
                    $status_flag=1;
                }
            }
            if ($status_flag==0){
                ?>
                <div class="updated"><p><strong><?php _e('Your selected file could not download. Server may not give the HTTP Header permission or requesting session time may Expired.   Try again.', 'menu-test' ); ?></strong></p></div>
            <?php
            }else{
                ?>
                <div class="updated"><p><strong><?php _e('File Downloading complete.', 'menu-test' );  ?></strong></p></div>
            <?php
            }
            include("icalreader.php"); // Run parser and insert into DB
        }

        // File upload through Browse local file
        if( isset($_FILES['fupload'])) {
            // Read posted file information
            $file_name = $_FILES['fupload']['name'];
            $file_type = $_FILES['fupload']['type'];
            $file_temp_path = $_FILES['fupload']['tmp_name'];
            $file_size = $_FILES['fupload']['size'];
            $static_file_name = 'mycal';
            $status_flag = 0;

            //Put the file in directory with checking
            if ($file_type == "text/calendar") {
                if(!is_writable($dir)){
                    chmod($dir, 0777);
                }
                copy($file_temp_path, "$dir/$static_file_name.ics");// removed  'or die("Couldn't copy")'
                $status_flag = 1;
            }
            // Put an settings updated message on the screen
            if ($status_flag==0){
                ?>
                <div class="updated"><p><strong><?php _e('Your selected file is not *.ics format. Try again'.$file_type, 'menu-test' ); ?></strong></p></div>
            <?php
            }else{
                ?>
                <div class="updated"><p><strong><?php _e('File uploading complete successfully.', 'menu-test' );  ?></strong></p></div>
            <?php
            }
            include("icalreader.php"); // Run parser and insert into DB
        }


    // top
    echo '<h2>PHP Event Calendar Settings</h2>';

    // container

    echo '<div id="pec-settings" style="width:1000px;">';

        // main 

        echo '<div id="pec-settings-main" style="width:800px;float:left">';

            // info

            echo '<div id="pec-settings-info" class="wrap">
                    <img src="'.  plugins_url( 'images/pec-logo.png',  __FILE__ ) .'" width="200" /><br />

                    <p>
                    This plugin is built with FREE <a href="http://phpeventcalendar.com">PHP Event Calendar</a> Lite edition! 
                    PHP Event Calendar is a modern, AJAX based, multi-user calendar/scheduling application. 
                    It can be used right out of the box as a standalone event calendar/scheduling application or can 
                    be customized easily to seamlessly integrate into your own environment. 
                    </p>

                    <p>
                    The Lite edition is similar to full version with a few limitations. 
                    The Lite edition allows single calendar only; no recurring/repeating events; no email reminder. 
                    The  full version has no those limitations. <a href="http://phpeventcalendar.com">Learn more...</a>
                    </p>
                  </div>';

            // export instruction

            echo '<div>
                    <h3>1. Learn how to export calendar to .ics file </h3>
                    
                    <p>
                        <ul style="padding-left:12px">
                        <li><a href="'.  plugins_url( 'images/PHP_Event_Calendar_export.png',  __FILE__ ) .'" width="800" height="1000" class="thickbox">PHP Event Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/gcal_export.png',  __FILE__ ) .'" width="600" height="550" class="thickbox">Google Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/OSX_iCal_export.png',  __FILE__ ) .'" width="600" height="350" class="thickbox">Apple OSX iCal/Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/outlook_export.png',  __FILE__ ) .'" width="600" height="550" class="thickbox">Microsoft Outlook</a><br />
                        </ul>
                    </p>

                  </div>';

            // form 

            echo '<div id="pec-settings-form">';

                // header upload .ics file  

                echo "<h3>2. ". __("Upload an iCalendar *.ics file", "menu-test") ."</h3>";
                echo "<table style='padding-left:12px'><tr><td>";
                    echo "<h4>" . __( 'Upload from this computer', 'menu-test' ) . "</h4>";

                    // settings form

                    ?>

                    <form enctype="multipart/form-data" action="" method="post">
                        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

                        <p class="submit"><?php _e("File:", 'menu-test' ); ?>
                            <input type="file" name="<?php echo $data_file_name; ?>" >
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Upload') ?>" />
                        </p>

                    </form>

                    <!--######-->

                <?php
                echo "</td>"; // pec-admin-column1

                echo '<td><div class="pec-admin-vertical-hr"></div></td>'; // vertical hr

                // header upload via URL

                echo "<td>";
                    echo "<h4>" . __( 'Or upload from web URL', 'menu-test' ) . "</h4>";

                    // settings form

                    ?>

                    <form enctype="multipart/form-data" action="" method="post">
                        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

                        <p class="submit"><?php _e("File:", 'menu-test' ); ?>
                            <input type="url" name="<?php echo $data_file_name_url; ?>" >
                            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Upload') ?>" />
                        </p>

                    </form>
                </td></tr></table>

            </div><!-- form container -->

            <div>
                <h3>3. Add shortcode to page</h3>
                <p style="padding-left:12px">
                    After uploading the file, please create a <a href="<?php echo admin_url();?>post-new.php?post_type=page">new page</a> that will only contain the short-code 
                    <br /><br />
                    <code>"[php_event_calendar]"</code>
                    <br /><br />
                </p>
            </div>

            <div>
                <h3>All Done! Well, you still need help?</h3>

                <p style="padding-left:12px">
                    Feel free to <a href="http://phpeventcalendar.com/contact/" target="_new">send us your feedback and suggestions</a>.
                </p>
            </div>


        </div><!-- pec-settings-main -->

        <!-- PEC right sidebar -->
        <div id="pec-admin-sidebar" style="width:180px;float:right">
            <h3>More About PHP Event Calendar</h3>

            <a href="http://phpeventcalendar.com/screenshots/" target="_new">Screenshots</a><br />
            <a href="http://quickproductdemo.com/phpeventcal/" target="_new">Full Version Demo</a><br />
            <a href="http://phpeventcalendar.com/category/docs/" target="_new">Quick Guide</a><br />
            <a href="http://phpeventcalendar.com/store/" target="_new">Download</a><br />
            <a href="http://phpeventcalendar.com/contact/" target="_new">Support & Contact</a><br />
        </div>

    </div><!-- pec-settings -->


    <?php

    }

    // Short code to display full calendar in a page
    /*
    function pec_shortcode() {
        wp_enqueue_script("add_jquery_file", WP_PLUGIN_URL.'/pec-importer/js/jquery.min.js');
        wp_enqueue_script("add_fullcalendar_js_file", WP_PLUGIN_URL.'/pec-importer/js/fullcalendar.js');
        //wp_enqueue_script("add_main_js_file", WP_PLUGIN_URL.'/pec-importer/js/pec.js');
        include('js/pec.js.php');
        wp_enqueue_style("add_fullcalendar_css", WP_PLUGIN_URL.'/pec-importer/css/fullcalendar.css');
        ob_start();
        ?>
        <div class="wrapper">
            <div id="calendar"></div>
        </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'pec-importer', 'pec_shortcode' );
    */
?>
<?php

function event_calendar(){
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
//$pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Agenda Day','basicDay'=>'Day','basicWeek'=>'Week','month'=>'Month','agendaWeek'=>'Agenda Week'));
    $pec->buttonText(array('prev'=>'Prev','next'=>'Next', 'agendaDay'=>'Day','basicDay'=>'Day','month'=>'Month','agendaWeek'=>'Week','list'=>'Agenda'));

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

    <!DOCTYPE html>
    <html>
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PHP Event Calendar Lite</title>
        <?php echo $pec->display('head');?>
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

        </style>
    </head>

    <body>
    <?php //require_once(SERVER_HTML_INCLUDE_DIR.'top-navigation.html.php'); ?>
    <div class="container">
        <?php
        //require_once(SERVER_HTML_DIR.'calendar-create.html.php');
        //require_once(SERVER_HTML_DIR.'calendar-settings.html.php');
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

    </body>

    </html>
<?php
}

add_shortcode( 'php_event_calendar', 'event_calendar' );
?>