<?php
/**
 * Plugin Name: PHP Event Calendar
 * Plugin URI: http://phpeventcalendar.com/
 * Description: Easily create, share, and display beautiful and responsive online event calendars through intuitive user interface.
 * Version: 1.4.1
 * Author: PHPControls Inc.
 * Author URI: http://phpcontrols.com/
 * License: GPL2
 */
global $db_version;
$db_version = "1.4";


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
        wp_register_style( 'pec-wp-common', plugins_url( 'css/pec-wp-common.css', __FILE__ ));
        wp_enqueue_style( 'pec-wp-common' );
    }
}
add_action( 'admin_enqueue_scripts', 'pec_admin_settings_style' );

function pec_wp_user_style()
{
    if (!is_admin()) {
        // Register the style like this for a plugin:
        wp_register_style( 'pec-wp-user', plugins_url( 'css/pec-wp-user.css', __FILE__ ));
        wp_enqueue_style( 'pec-wp-user' );
        wp_register_style( 'pec-wp-common', plugins_url( 'css/pec-wp-common.css', __FILE__ ));
        wp_enqueue_style( 'pec-wp-common' );
    }
}
add_action( 'wp_enqueue_scripts', 'pec_wp_user_style' );

function table_install() {
    $dir = plugin_dir_path( __FILE__ );
    $location = $dir.'full_calendar.php';
    global $wpdb;
    global $db_version;

    //load file
    $commands ='';
    include($location);

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

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );

    add_option( "db_version", $db_version );
}

function table_install_data(){

    //== Check and Insert user info if current user never import an ics file.
    $dbcon = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    global $current_user; get_currentuserinfo();
    $timezone = get_option('gmt_offset');
    $select_sql = "SELECT * FROM `pec_users` WHERE `admin_id`='$current_user->ID' ";

    $insert_sql = "INSERT INTO `pec_users` (`access_key`, `activated`, `admin_id`, `role`, `first_name`, `last_name`, `active_calendar_id`, `company`, `username`, `password`, `email`, `timezone`, `language`, `theme`, `kbd_shortcuts`, `created_on`, `updated_on`)
VALUES('1', 1, '$current_user->ID', 'super', '$current_user->user_firstname', '$current_user->user_lastname', '0', 'Highpitch', '$current_user->user_login', '$current_user->user_pass', '$current_user->user_email', '$timezone', 'English', 'default', 1, '', '')";
    $result = mysqli_query($dbcon,$select_sql);
    if(mysqli_num_rows($result) < 1)
        mysqli_query($dbcon, $insert_sql);

//=== Check and insert calendar info
//=== for lite version, there will be one calendar only, even for multiple imports
//$cal_select = "SELECT * FROM `pec_calendars` WHERE `name`='$cal_name' AND `user_id`='$current_user->ID' ";
    $cal_select = "SELECT * FROM `pec_calendars` WHERE `user_id`='$current_user->ID' ";

//==== for lite version, calendar name will be always same = '$cal_name="Default Calendar"';
    $cal_name = 'Default Calendar';
    $cal_desc = 'Default Calendar';
    $today = date('Y-m-d');

    $cal_insert = "INSERT INTO `pec_calendars` (`type`, `user_id`, `name`, `description`, `color`, `admin_id`, `status`, `show_in_list`, `public`, `reminder_message_email`, `reminder_message_popup`, `access_key`, `created_on`, `updated_on`) VALUES
('user', '$current_user->ID', '$cal_name', '$cal_desc', '#3a87ad', NULL, 'on', '1', 0, '', '', '', '$today', NULL)";

    $resultCal = mysqli_query($dbcon,$cal_select);
    if(mysqli_num_rows($resultCal) <= 0){
        mysqli_query($dbcon, $cal_insert);
    }


//===
//=== for lite version, there will be one calendar only, even for multiple imports
//$cal_id = mysqli_fetch_array(mysqli_query($dbcon,"SELECT `id` FROM `pec_calendars` WHERE `name`='$cal_name' AND `user_id`='$current_user->ID' "));
    $cal_id = mysqli_fetch_array(mysqli_query($dbcon,"SELECT `id` FROM `pec_calendars` WHERE `user_id`='$current_user->ID' "));
    $calID = $cal_id['id'];

//==== update for active calendar into pec_user table
    $user_update = "UPDATE `pec_users` SET `active_calendar_id` = '$calID'";
    if(mysqli_num_rows($resultCal) <= 0){
        mysqli_query($dbcon, $user_update);
    }
}


function table_update() {
    $dir = plugin_dir_path( __FILE__ );
    $location = $dir.'full_calendar_update.php';
    global $wpdb;
    global $db_version;
    $db_version = "1.4";

    //load file
    $commands ='';
    include($location);

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

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );

    add_option( "db_version", $db_version );
}

function myplugin_update_db_check() {
    global $db_version;
    if ( get_site_option( 'db_version' ) != $db_version ) {
        table_update();
    }
}
add_action( 'plugins_loaded', 'myplugin_update_db_check' );

// Create tables on plugin activation
register_activation_hook(__FILE__, 'table_install');
register_activation_hook(__FILE__, 'table_install_data');

require_once 'uninstall.php'; register_uninstall_hook( __FILE__, 'table_uninstall' );
//require_once 'uninstall.php'; register_deactivation_hook( __FILE__, 'table_uninstall' );

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new top-level menu (ill-advised):
    add_menu_page(__( 'PHP Event Calendar','menu-pec'), __('Event Calendar','menu-pec'), 'manage_options', 'mt-top-level-handle', 'admin_calendar', plugins_url( 'images/pec-logo-icon-20x20.png', __FILE__ ) );
    add_submenu_page( 'mt-top-level-handle', 'Events Management', 'Events Management', 'manage_options', 'mt-top-level-handle', 'admin_calendar');
    add_submenu_page( 'mt-top-level-handle', __('Imports','menu-pec'), __('Imports','menu-pec'), 'manage_options', 'mt-sub-level-handle', 'mt_settings_page');
    add_submenu_page( 'mt-top-level-handle', 'PHP Event Calendar Premium Add-on', 'Premium Add-Ons', 'manage_options', 'pec-premium-add-ons', 'premium_addons');
}

/*######################*/
// mt_settings_page() displays the page content for upload ics file
function mt_settings_page() {
    include('pec-admin.php');
}

//=== Admin view calendar
function admin_calendar(){
    include('calendar.php');
}

//=== Premium Add-Ons
function premium_addons(){
    include('addons.php');
}

//=== Public view calendar
function event_calendar(){
    include('public.php');
}

//==== Load scripts
function pec_load_scripts_20(){
    //wp_enqueue_style( 'jquery-ui', plugins_url('/css/fullcalendar-2.0.0/start/jquery-ui.min.css', __FILE__ ) );

    wp_enqueue_style( 'fullcalendar', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.css' , __FILE__ ));
    wp_enqueue_style( 'fullcalendar-print', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.print.css' , __FILE__ ), false, false, 'print' );
    wp_enqueue_style( 'fullcalendar-custom', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.custom.css' , __FILE__ ) );
    wp_enqueue_style( 'uploadify', plugins_url( '/css/uploadify.css' , __FILE__ ));
}

function pec_load_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
    wp_enqueue_script( 'jquery-ui-resizable' );


    wp_enqueue_style('bootstrap',plugins_url( '/plugins/bootstrap/css/bootstrap.min.css' , __FILE__ ));
    wp_enqueue_style('bootstrap-theme-min',plugins_url( '/plugins/bootstrap/css/bootstrap-theme.min.css' , __FILE__ ));
    wp_enqueue_style('bootstrap-datetimepicker',plugins_url( '/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css' , __FILE__ ));

    wp_enqueue_style('bootstrap-color-picker',plugins_url( '/plugins/bootstrap-colorpicker-master/css/bootstrap-colorpicker.min.css' , __FILE__ ));
    wp_enqueue_style('bootstrap-ladda-button-themeless',plugins_url( '/plugins/ladda-bootstrap-master/dist/ladda-themeless.min.css' , __FILE__ ));
    wp_enqueue_style('bootstrap-select-min',plugins_url( '/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.css' , __FILE__ ));

    //wp_enqueue_style('theme', get_stylesheet_uri(), array('fullcalendar'));

    wp_enqueue_script('moment',plugins_url( '/js/fullcalendar-2.0.0/moment.min.js' , __FILE__ ));

    wp_enqueue_script(
        'fullcalendar',
        plugins_url( '/js/fullcalendar-2.0.0/fullcalendar.js' , __FILE__ ),
        array( 'jquery','moment' )
    );

    $upload_dir_params = wp_upload_dir();
    $user_ID = get_current_user_id();

    $translation_array = array( 'PEC_PLUGIN_URL_FOR_JS' => plugins_url( '' , __FILE__ ),'PEC_PLUGIN_UPLOAD_URL_FOR_JS'=>str_replace('\\','/',$upload_dir_params['baseurl']), 'PEC_PLUGIN_USER_ID_FOR_JS'=>$user_ID);
    wp_localize_script( 'fullcalendar', 'PEC_JS_OBJECT', $translation_array );

    wp_enqueue_script(
        'pec-uploadify',
        plugins_url( '/js/jquery.uploadify.js' , __FILE__ ),
        array( 'jquery' )
    );

    wp_enqueue_script(
        'pec-calendar-custom',
        plugins_url( '/js/custom/calendar.js' , __FILE__ ),
        array('jquery', 'fullcalendar', 'pec-uploadify')
    );



    wp_enqueue_script(
        'gcal',
        plugins_url( '/js/fullcalendar-2.0.0/gcal.js' , __FILE__ ),
        array( 'jquery' )
    );


    wp_enqueue_script(
        'bootstrap',
        plugins_url( '/plugins/bootstrap/js/bootstrap.min.js' , __FILE__ ),
        array( 'jquery' )
    );
    wp_enqueue_script(
        'bootstrap-datetimepicker',
        plugins_url( '/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );
    wp_enqueue_script(
        'bootstrap-colorpicker',
        plugins_url( '/plugins/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );

    wp_enqueue_script(
        'bootstrap-growl',
        plugins_url( '/plugins/ifightcrime-bootstrap-growl/jquery.bootstrap-growl.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );

    wp_enqueue_script(
        'bootstrap-ladda-button-spin',
        plugins_url( '/plugins/ladda-bootstrap-master/dist/spin.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );

    wp_enqueue_script(
        'bootstrap-ladda-button',
        plugins_url( '/plugins/ladda-bootstrap-master/dist/ladda.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );

    wp_enqueue_script(
        'bootstrap-select',
        plugins_url( '/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.js' , __FILE__ ),
        array( 'bootstrap' )
    );

    wp_enqueue_script(
        'google-map',
        'http://maps.google.com/maps/api/js?sensor=false',
        array( 'jquery' )
    );
}

add_action( 'admin_enqueue_scripts', 'pec_load_scripts' );
add_action( 'admin_enqueue_scripts', 'pec_load_scripts_20', 20 );
add_action( 'wp_enqueue_scripts', 'pec_load_scripts' );
add_action( 'wp_enqueue_scripts', 'pec_load_scripts_20', 20 );

add_shortcode( 'php_event_calendar', 'event_calendar' );

//==== Register AJAX Calls here one by one
function my_AJAX_processing_function(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID_PUBLIC', 'my_AJAX_processing_function');
add_action('wp_ajax_nopriv_LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID_PUBLIC', 'my_AJAX_processing_function');

function my_AJAX_new_event(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_PEC_CREATE_EVENT', 'my_AJAX_new_event');
add_action('wp_ajax_nopriv_PEC_CREATE_EVENT', 'my_AJAX_new_event');

function my_AJAX_load_selected_calendar_from_session(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_LOAD_SELECTED_CALENDAR_FROM_SESSION', 'my_AJAX_load_selected_calendar_from_session');
add_action('wp_ajax_nopriv_LOAD_SELECTED_CALENDAR_FROM_SESSION', 'my_AJAX_load_selected_calendar_from_session');

function my_AJAX_load_selected_calendar_color(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_LOAD_SELECTED_CALENDAR_COLOR', 'my_AJAX_load_selected_calendar_color');
add_action('wp_ajax_nopriv_LOAD_SELECTED_CALENDAR_COLOR', 'my_AJAX_load_selected_calendar_color');

function my_AJAX_export_calendar(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_EXPORT_CALENDAR', 'my_AJAX_export_calendar');
add_action('wp_ajax_nopriv_EXPORT_CALENDAR', 'my_AJAX_export_calendar');

function my_AJAX_update_calendar(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_UPDATE_CALENDAR', 'my_AJAX_update_calendar');
add_action('wp_ajax_nopriv_UPDATE_CALENDAR', 'my_AJAX_update_calendar');

function my_AJAX_share_calendar(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_SHARE_CALENDAR', 'my_AJAX_share_calendar');
//add_action('wp_ajax_nopriv_SHARE_CALENDAR', 'my_AJAX_share_calendar');

function my_AJAX_update_cal_public(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_UPDATE_CAL_PUBLIC', 'my_AJAX_update_cal_public');
//add_action('wp_ajax_nopriv_SHARE_CALENDAR', 'my_AJAX_share_calendar');

function my_AJAX_create_calendar(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_CREATE_CALENDAR', 'my_AJAX_create_calendar');
//add_action('wp_ajax_nopriv_SHARE_CALENDAR', 'my_AJAX_share_calendar');

function my_AJAX_calendar_settings_save(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/calendar_manager.php');
}
add_action('wp_ajax_CALENDAR_SETTINGS_SAVE', 'my_AJAX_calendar_settings_save');
//add_action('wp_ajax_nopriv_SHARE_CALENDAR', 'my_AJAX_share_calendar');

function my_AJAX_load_single_event_based_on_event_id(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID', 'my_AJAX_load_single_event_based_on_event_id');
add_action('wp_ajax_nopriv_LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID', 'my_AJAX_load_single_event_based_on_event_id');


function my_AJAX_SAVE_MOVED_EVENT(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_SAVE_MOVED_EVENT', 'my_AJAX_SAVE_MOVED_EVENT');
//add_action('wp_ajax_nopriv_SAVE_MOVED_EVENT', 'my_AJAX_SAVE_MOVED_EVENT');

function my_AJAX_LOAD_EVENTS_BASED_ON_CALENDAR_ID(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_LOAD_EVENTS_BASED_ON_CALENDAR_ID', 'my_AJAX_LOAD_EVENTS_BASED_ON_CALENDAR_ID');
add_action('wp_ajax_nopriv_LOAD_EVENTS_BASED_ON_CALENDAR_ID', 'my_AJAX_LOAD_EVENTS_BASED_ON_CALENDAR_ID');

function my_AJAX_REMOVE_THIS_EVENT(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_REMOVE_THIS_EVENT', 'my_AJAX_REMOVE_THIS_EVENT');
//add_action('wp_ajax_nopriv_REMOVE_THIS_EVENT', 'my_AJAX_REMOVE_THIS_EVENT');


function my_CHECK_CONFLICT(){
    require_once('conf.php');
    require_once(WP_ROOT.PEC_PLUGIN_DIR.'/server/ajax/events_manager.php');
}
add_action('wp_ajax_CHECK_CONFLICT', 'my_CHECK_CONFLICT');
//add_action('wp_ajax_nopriv_CHECK_CONFLICT', 'my_CHECK_CONFLICT');

?>