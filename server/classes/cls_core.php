<?php
/**
 * File: cls_core.php: Some core functionalities related to front end as well as back end
 *
 * Description: It extends event properties and has some important core functionalities.
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * Class C_Core : Front End methods for loading javascript libraries as well as loading CSS libraries also it loads DB object
 *
 * Description: It extends Event properties. The main task of this class is to load javascript libraries and css files for
 * front end purposes. Beside it loads DB object.
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Core extends C_Properties
{
    /**
     * @var object DB Object
     */
    public $db;

    /**
     * Constructor Function
     */
    public function __construct()
    {
    }

    /**
     * Loads All CSS files based on user requests for front end purposes
     *
     * @param bool $bootstrap, if true then loads the CSS for bootstrap
     * @param bool $fullCalendar, if true then loads the CSS for fullCalendar
     * @param bool $datetimePicker, if true then loads the CSS for datetimePicker
     * @param bool $colorPicker, if true then loads colorPicker
     * @param bool $jqueryUI, if true then loads jqueryUI
     *
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     *
     */
    public static function display_script_include_once_head($bootstrap = false, $fullCalendar = false, $datetimePicker = false, $colorPicker = false, $jqueryUI = false)
    {
        if ($fullCalendar) {
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/css' . FULL_CALENDAR_VERSION  . '/fullcalendar.css" />' . "\n";
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/css' . FULL_CALENDAR_VERSION  . '/fullcalendar.print.css" media="print"/>' . "\n";
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/css' . FULL_CALENDAR_VERSION  . '/fullcalendar.custom.css" />' . "\n";
        }
        if ($bootstrap) {
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap/css/bootstrap.min.css" />' . "\n";
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap/css/bootstrap-theme.min.css" />' . "\n";
        }

        if ($datetimePicker) {
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" />' . "\n";
        }
        if ($colorPicker) {
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-colorpicker-master/css/bootstrap-colorpicker.min.css" />' . "\n";
        }
        if ($jqueryUI) {
            //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/css' . FULL_CALENDAR_VERSION  . '/start/jquery-ui.min.css" />';
        }

        //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/ladda-bootstrap-master/dist/ladda-themeless.min.css" />' . "\n";
        //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.css" />' . "\n";
        //echo '<link rel="shortcut icon" href="'. WP_PEC_PLUGIN_SITE_URL  .'/images/pec-logo-icon.png"/>'. "\n";

        //echo '<link rel="stylesheet" href="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-select2/select2.css" />' . "\n";
    }

    /**
     * Loads Javascript/jQuery libraries for Front end purposes based on user request. Other than requested libraries
     * it loads few Javascript/jQuery plugins by default
     *
     * @param bool $bootstrap, if true then loads bootstrap jquery library
     * @param bool $fullCalendar, if true then loads fullCalendar jquery library
     * @param bool $datetimePicker, if true then loads datetimePicker jquery library
     * @param bool $colorPicker, if true then loads colorPicker
     * @param bool $jqueryUI, if true then loads jqueryUI jquery library
     *
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function display_script_include_once_foot($bootstrap = false, $fullCalendar = false, $datetimePicker = false, $colorPicker = false, $jqueryUI = false)
    {
        //===this function can't be used in WP anymore as the scripts are being loaded from the WP hooks

        if(FULL_CALENDAR_VERSION == '/fullcalendar-2.0.0') {
            echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/js' . FULL_CALENDAR_VERSION  . '/moment.min.js" type="text/javascript"></script>' . "\n";
        }
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/js' . FULL_CALENDAR_VERSION  . '/jquery.min.js" type="text/javascript"></script>' . "\n";
        if ($jqueryUI) {
            //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/js' . FULL_CALENDAR_VERSION  . '/jquery-ui.custom.min.js" type="text/javascript"></script>' . "\n";
        }
        if ($bootstrap) {
            //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>' . "\n";
        }
        if ($datetimePicker) {
            //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>' . "\n";
        }
        if ($colorPicker) {
            //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js" type="text/javascript"></script>' . "\n";
        }
        if ($fullCalendar) {
            //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/js' . FULL_CALENDAR_VERSION  . '/fullcalendar.js" type="text/javascript"></script>' . "\n";
        }
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/ifightcrime-bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>' . "\n";
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/ladda-bootstrap-master/dist/spin.min.js" type="text/javascript"></script>' . "\n";
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/ladda-bootstrap-master/dist/ladda.min.js" type="text/javascript"></script>' . "\n";
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.js" type="text/javascript"></script>' . "\n";
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/js' . FULL_CALENDAR_VERSION  . '/gcal.js" type="text/javascript"></script>' . "\n";
        //echo '<script src="' . WP_PEC_PLUGIN_SITE_URL . '/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>' . "\n";

    }

    /**
     * Loads custom JS for Front End purposes
     * @param $jsName
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function display_custom_js($jsName)
    {
        //require_once PEC_PLUGIN_DIR . "/js/custom/$jsName.js.php";
    }

    /**
     * Loads DB Object
     *
     * Note: This object wont be inherited for any static method
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function load_db()
    {
        $this->db = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
    }

    public static function sendEmail($recipients, $emailSubject, $emailBody, $CC='', $BCC='', $files=''){
        define('ENABLE_OUTGOING_EMAILS',true);
        if(ENABLE_OUTGOING_EMAILS){
            //require_once(FILE_BASEPATH."libraries/phpmailer/classes/class.phpmailer.php");
            require_once (PEC_PLUGIN_DIR.'server/phpmailer/PHPMailerAutoload.php');

            //-------------------------------------------------------------------------------------
            //--- create phpmailer object
            $mailer = new PHPMailer();
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
            $mailer->SMTPSecure = "ssl://";                 // sets the prefix to the servier
            $mailer->Host       = "smtp.sendgrid.net";      // sets SMTP server
            $mailer->Port       = 465;
            $mailer->SMTPAuth = TRUE;
            $mailer->Username = 'AIMS';
            $mailer->Password = '9uvumUtHUq_8reba';
            $mailer->From = 'billahnorm@gmail.com';
            $mailer->FromName = 'PHP Full Calendar';
            //-------------------------------------------------------------------------------------
            //--- prepare email body and subject
            $mailer->Body = $emailBody;
            $mailer->Subject = $emailSubject;
            //-------------------------------------------------------------------------------------
            //--- Add Email Recipients
            if(!empty($recipients)){
                if(strstr($recipients, ",")){
                    $recipients = explode(",", $recipients);
                }
                elseif(strstr($recipients, ";")){
                    $recipients = explode(";", $recipients);
                }
                else{
                    $recipients = array($recipients);
                }

                foreach($recipients as $email){
                    $mailer->AddAddress(@trim($email));
                }
            }
            //-------------------------------------------------------------------------------------
            //--- Add CC Recipients
            if(!empty($CC)){
                if(strstr($CC, ",")){
                    $CC = explode(",", $CC);
                }
                elseif(strstr($CC, ";")){
                    $CC = explode(";", $CC);
                }
                else{
                    $CC = array($CC);
                }

                foreach($CC as $email){
                    $mailer->AddCC(@trim($email));
                }
            }
            //-------------------------------------------------------------------------------------
            //--- Add BCC Recipients
            if(!empty($BCC)){
                if(strstr($BCC, ",")){
                    $BCC = explode(",", $BCC);
                }
                elseif(strstr($BCC, ";")){
                    $BCC = explode(";", $BCC);
                }
                else{
                    $BCC = array($BCC);
                }

                foreach($BCC as $email){
                    $mailer->AddBCC(@trim($email));
                }
            }
            //-------------------------------------------------------------------------------------
            //--- Process Attachments if any
            if(!empty($files)){
                //----- Find key of files object
                $tmp = array_keys($files);
                $key = $tmp[0];
                $totalFiles = count($files[$key]['name']);

                if($totalFiles > 0){
                    for($i=0; $i<$totalFiles; $i++){
                        $mailer->AddAttachment($files[$key]['tmp_name'][$i], $files[$key]['name'][$i]);
                    }
                }
            }
            //-------------------------------------------------------------------------------------
            //--- send email(s)
            if($mailer->Send()) return 'sent';
            else return $mailer->ErrorInfo;
        }
        else{
            return 'sent';
        }
    }



}

?>