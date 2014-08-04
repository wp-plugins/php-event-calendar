<?php
//define('PEC_PATH', '/phpEventCal/trunk');
//define('PEC_PATH_LOCAL','/highpitch_eventcal'); //==when in local
define('PEC_PATH_LOCAL','/'); //=== When in live
$dir = str_replace('\\','/',dirname(__FILE__));
$host = $_SERVER['DOCUMENT_ROOT'];
$plug_dir = str_replace($host,'',$dir);
define('PEC_PATH', $plug_dir);
define('PEC_PLUGIN_DIR',substr(PEC_PATH, strpos(PEC_PATH,'wp-content')));
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
define('DEBUG',true);


//============DB Settings
/*
define('PEC_DB_HOST','localhost');
define('PEC_DB_USER','root');
define('PEC_DB_PASS','');
define('PEC_DB_TYPE','mysql');
define('PEC_DB_NAME','full_calendar');
define('PEC_DB_CHARSET','');
*/

$wp_config_dir = WP_ROOT;
require_once($wp_config_dir."wp-config.php");
define('PEC_DB_HOST', DB_HOST);
define('PEC_DB_USER',DB_USER);
define('PEC_DB_PASS', DB_PASSWORD);
define('PEC_DB_TYPE','mysql');
define('PEC_DB_NAME', DB_NAME);
define('PEC_DB_CHARSET','');

/******** DO NOT MODIFY ***********/
require_once('pec.php');
/**********************************/
?>
