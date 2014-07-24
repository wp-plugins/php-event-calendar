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
    include('pec-admin.php');
}

//=== Public view calendar
function event_calendar(){
    include('public.php');
}

//==== Load scripts
function pec_load_scripts_20(){
    wp_enqueue_style( 'jquery-ui', plugins_url('/css/fullcalendar-2.0.0/start/jquery-ui.min.css', __FILE__ ) );

    wp_enqueue_style( 'fullcalendar', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.css' , __FILE__ ));
    wp_enqueue_style( 'fullcalendar-print', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.print.css' , __FILE__ ), false, false, 'print' );
    wp_enqueue_style( 'fullcalendar-custom', plugins_url( '/css/fullcalendar-2.0.0/fullcalendar.custom.css' , __FILE__ ) );
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


    wp_enqueue_script(
        'pec-calendar-custom',
        plugins_url( '/js/custom/calendar.js' , __FILE__ ),
        array('jquery', 'fullcalendar' )
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


}

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

?>