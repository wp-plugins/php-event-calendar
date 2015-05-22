<?php
global $wpdb;

$current_user = wp_get_current_user();
define('PEC_USER_ID', $current_user->ID);
define('PREFIX',$wpdb->prefix);

//define('PEC_PATH', '/phpEventCal/trunk');
//define('PEC_PATH_LOCAL','/highpitch_eventcal'); //==when in local
define('PEC_PATH_LOCAL','/'); //=== When in live
$dir = str_replace('\\','/',dirname(__FILE__));
$host = $_SERVER['DOCUMENT_ROOT'];
$plug_dir = str_replace($host,'',$dir);
define('PEC_PATH', $plug_dir);
define('PEC_PLUGIN_DIR',substr(PEC_PATH, strpos(PEC_PATH,'wp-content')));
define('PEC_PLUGIN_ROOT_DIR',$dir);
define('WP_ROOT',substr($dir,0,strpos($dir,'wp-content')));
if(function_exists('get_site_url')) {
    define('WP_SITE_URL', get_site_url().'/');
}
else {
    define('WP_SITE_URL','http://'.$_SERVER['HTTP_HOST'].PEC_PATH_LOCAL);
}

define('WP_PEC_PLUGIN_SITE_URL',WP_SITE_URL.PEC_PLUGIN_DIR);
//define('PEC_PATH', '/highpitch_eventcal/branches/wpplugin/wordpress/wp-content/plugins/eventcal');
//============Generatl Settings
define('DEBUG',false);


//============DB Settings
/*
define('PEC_DB_HOST','localhost');
define('PEC_DB_USER','root');
define('PEC_DB_PASS','');
define('PEC_DB_TYPE','mysql');
define('PEC_DB_NAME','full_calendar');
define('PEC_DB_CHARSET','');
*/
global $wpdb;

/******** DO NOT MODIFY ***********/
require_once('pec.php');
/**********************************/
?>
