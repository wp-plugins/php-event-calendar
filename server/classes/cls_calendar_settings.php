<?php
/**
 * File: cls_calendar_settings.php This class has calendar settings that can be inherited
 *
 * Description: Calendar settings like timezone, time format, default view, date formats, week start day, language etc.
 * It is inherited by C_Calendars class
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * Class C_Calendar_Settings This class consists of DB operations for loading calendar settings, edit etc
 *
 * Description: Handles Calendar settings like language, time zone, default view, shortdate & longdate formats, time
 * format and start date at the moment
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 * @todo $language property to be implemented
 * @todo $time_zone property to be implemented
 *
 */
class C_Calendar_Settings
{
    /**
     * @var string $language , a set of languages can be setup, not in use in this version 1.0.1
     * @todo: need to implement this
     */
    public $language;

    /**
     * @var string $time_zone , a set of different timezones, not in use in this version 1.0.1
     * @todo: need to implement this
     */
    public $time_zone;

    /**
     * @var string $default_view , a set of views provided by full calendar
     * Values: Month, Week, Day, Agenda
     */
    public $default_view;

    /**
     * @var string $shortdate_format , a set of date formats as short form of dates
     * Formats: MM/dd/yyyy, dd/MM/yyyy, dd-MM-yyyy, MM-dd-yyyy, dd-MM-yy, MMM dd, yyyy
     */
    public $shortdate_format;

    /**
     * @var $longdate_format , a set of date formats as long form of dates
     * Formats: dddd, dd MMMM yyyy, dddd, MMMM dd, yyyy
     */
    public $longdate_format;

    /**
     * @var $timeformat , a set of time formats
     * Values: core, standard
     */
    public $timeformat;

    /**
     * @var string $start_day , the first day of the week
     * Values: Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday
     */
    public $start_day;

    /**
     * Constructor function for this class
     *
     * Description: No use of this
     *
     */
    public function __construct()
    {

    }

    /**
     * Loads all calendar settings
     *
     * Description: Loads all calendar settings for current logged in user
     *
     * @param integer $userID, current logged in user id
     * @return null|array, the set of current calendar settings for given user id
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function loadCalendarSettings($userID)
    {
        $sql = "SELECT * FROM  `pec_settings` WHERE `user_id` = $userID";
        $allCals = $this->dbObj->db_query($sql);

        $result = NULL;

        if ($this->dbObj->num_rows($allCals) > 0) {
            while ($res = $this->dbObj->fetch_array_assoc($allCals)) {
                $result = $res;
            }
        } else return NULL;

        return $result;

    }


    /**
     * Loads all calendar settings
     *
     * Description: Loads all calendar settings for current logged in user
     *
     * @param integer $userID, current logged in user id
     * @return null|array, the set of current calendar settings for given user id
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function loadPublicCalendarSettings()
    {

        //==== Create Params Array for saving
        $params['shortdate_format'] = 'MM/DD/YYYY';
        $params['longdate_format'] = 'dddd, DD MMMM YYYY';
        $params['timeformat'] = 'core';
        $params['custom_view'] = '';
        $params['start_day'] = '0';
        $params['default_view'] = 'month';
        $params['wysiwyg'] = '0';
        $params['staff_mode'] = '0';
        $params['calendar_mode'] = 'vertical';
        $params['timeline_day_width'] = '360';
        $params['timeline_row_height'] = '28';
        $params['timeline_show_hours'] = '1';
        $params['timeline_mode'] = 'horizontal';
        $params['week_cal_timeslot_min'] = '30';
        $params['timeslot_height'] = '20';
        $params['week_cal_start_time'] = '00:00';
        $params['week_cal_end_time'] = '23:00';
        $params['week_cal_show_hours'] = '1';
        $params['event_tooltip'] = '1';
        $params['left_side_visible'] = '1';
        $params['language'] = 'English';
        $params['time_zone'] = '-12';
        $params['privacy'] = 'public';
        $params['email_server'] = 'PHPMailer';



        return $params;

    }

    /**
     * Saves calendar settings
     *
     * Description: Saves calendar settings based on user request
     *
     * @param array $params, contains all necessary parameters for calendar settings
     * @return bool|integer, if success returns the new calendar settings id, otherwise false
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function saveCalendarSettings($params)
    {
        return ($this->db->AutoExecute('pec_settings', $params, 'INSERT') && isset($this->db->_connectionID->insert_id)) ? $this->db->_connectionID->insert_id : false;
    }

    /**
     * Updates calendar settings
     *
     * Description: Updates calendar settings based on user request
     *
     * @param $params, contains all necessary parameters for calendar settings
     * @param integer $id, the primary key for calendar settings DB record
     * @return bool|integer, if success then returns calendar settings id, otherwise false
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function updateCalendarSettings($params, $id)
    {
        return ($this->db->AutoExecute('pec_settings', $params, 'UPDATE', "id=$id")) ? $id : false;
    }
}

?>