<?php
/**
 * File: cls_properties.php:
 *
 * Description: It is inherited by C_Events Class
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 */

/**
 * Class C_Properties setter and getter for Event Calendar Properties
 *
 * Description: Defines Event Calendar Properties provided by FullCalendar. Sets and Gets Properties. It is inherited
 * by C_Events Class
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */

class C_Properties
{

    //================General Display==================
    /**
     * @var string $header
     */
    public $header;
    /**
     * @var string $theme
     */
    public $theme;
    /**
     * @var string $buttonIcons
     */
    public $buttonIcons;
    /**
     * @var string $firstDay
     */
    public $firstDay;
    /**
     * @var string $isRTL
     */
    public $isRTL;
    /**
     * @var string $weekends
     */
    public $weekends;
    /**
     * @var string $hiddenDays
     */
    public $hiddenDays;
    /**
     * @var string $weekMode
     */
    public $weekMode;
    /**
     * @var string $weekNumbers
     */
    public $weekNumbers;
    /**
     * @var string $weekNumberCalculation
     */
    public $weekNumberCalculation;
    /**
     * @var string $height
     */
    public $height;
    /**
     * @var string $contentHeight
     */
    public $contentHeight;
    /**
     * @var string $aspectRatio
     */
    public $aspectRatio;
    /**
     * @var string $handleWindowResize
     */
    public $handleWindowResize;

    //======================Views=======================
    /**
     * @var string $defaultView
     */
    public $defaultView;

    //==================Agenda Options==================
    /**
     * @var string $allDaySlot
     */
    public $allDaySlot;
    /**
     * @var string $allDayText
     */
    public $allDayText;
    /**
     * @var string $axisFormat
     */
    public $axisFormat;
    /**
     * @var string $slotMinutes
     */
    public $slotMinutes;
    /**
     * @var string $snapMinutes
     */
    public $snapMinutes;
    /**
     * @var string $defaultEventMinutes
     */
    public $defaultEventMinutes;
    /**
     * @var string $firstHour
     */
    public $firstHour;
    /**
     * @var string $minTime
     */
    public $minTime;
    /**
     * @var string $maxTime
     */
    public $maxTime;
    /**
     * @var string $slotEventOverlap
     */
    public $slotEventOverlap;

    //=================Current Date====================
    /**
     * @var integer $year
     */
    public $year;
    /**
     * @var integer $month
     */
    public $month;
    /**
     * @var string $date
     */
    public $date;

    //=============Text/Time Customization============
    /**
     * @var string $timeFormat
     */
    public $timeFormat;
    /**
     * @var string $columnFormat
     */
    public $columnFormat;
    /**
     * @var string $titleFormat
     */
    public $titleFormat;
    /**
     * @var string $buttonText
     */
    public $buttonText;
    /**
     * @var string $monthNames
     */
    public $monthNames;
    /**
     * @var string $monthNamesShort
     */
    public $monthNamesShort;
    /**
     * @var string $dayNames
     */
    public $dayNames;
    /**
     * @var string $dayNamesShort
     */
    public $dayNamesShort;
    /**
     * @var string $weekNumberTitle
     */
    public $weekNumberTitle;

    //============Selection===========================
    /**
     * @var string $selectable
     */
    public $selectable;
    /**
     * @var string $selectHelper
     */
    public $selectHelper;
    /**
     * @var string $unselectAuto
     */
    public $unselectAuto;
    /**
     * @var string $unselectCancel
     */
    public $unselectCancel;

    //============Event Data==========================
    /**
     * @var string $eventsArr
     */
    public $eventsArr;
    /**
     * @var string $events
     */
    public $events;
    /**
     * @var object|array $eventObj
     */
    public $eventObj;
    /**
     * @var array $eventSources
     */
    public $eventSources;
    /**
     * @var string $allDayDefault
     */
    public $allDayDefault;
    /**
     * @var boolean $ignoreTimezone
     */
    public $ignoreTimezone;
    /**
     * @var string $startParam
     */
    public $startParam;
    /**
     * @var string $endParam
     */
    public $endParam;
    /**
     * @var string $lazyFetching
     */
    public $lazyFetching;

    //============Event Rendering====================
    /**
     * @var string $eventColor
     */
    public $eventColor;
    /**
     * @var string $eventBackgroundColor
     */
    public $eventBackgroundColor;
    /**
     * @var string $eventBorderColor
     */
    public $eventBorderColor;
    /**
     * @var string $eventTextColor
     */
    public $eventTextColor;

    //============Event Dragging & Resizing==========
    /**
     * @var string $editable
     */
    public $editable;
    /**
     * @var string $eventStartEditable
     */
    public $eventStartEditable;
    /**
     * @var string $eventDurationEditable
     */
    public $eventDurationEditable;
    /**
     * @var integer $dragRevertDuration
     */
    public $dragRevertDuration;
    /**
     * @var integer $dragOpacity
     */
    public $dragOpacity;

    //============Dropping External Elements=========
    /**
     * @var boolean $droppable
     */
    public $droppable;
    /**
     * @var boolean $dropAccept
     */
    public $dropAccept;

    /**
     * __constructor method
     * @ignore
     */
    public function __construct()
    {
    }

    /**
     * Loads all available properties
     *
     * @param null $calendarProperties
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function load_properties($calendarProperties = NULL)
    {
        //====================================================================
        //====Default Header Properties
        //====================================================================
        if ($this->header == NULL) $this->header = 'false';
        //====Theme
        $this->theme = 'false';
        //====Button Icons
        $this->buttonIcons = "{ prev: 'left-single-arrow',
                                next: 'right-single-arrow',
                                prevYear: 'left-double-arrow',
                                nextYear: 'right-double-arrow'}";
        //====First Day
        (isset($calendarProperties['start_day'])) ? $this->firstDay = $calendarProperties['start_day'] : '0';
        //====Is RTL (Right to Left)
        $this->isRTL = 'false';
        //====Weekends
        $this->weekends = 'true';
        //====Hidden Days
        $this->hiddenDays = '[]';
        //====Week Mode
        $this->weekMode = 'fixed';
        //====Week Number
        $this->weekNumbers = 'false';
        //====Week Number Calculation
        $this->weekNumberCalculation = 'iso';
        //====Height
        $this->height = ''; //This remains unset by default
        //====Content Height
        $this->contentHeight = ''; //This remains unset by default
        //====Aspect Ratio
        $this->aspectRatio = '1.35';
        //====Handle Window Resize
        $this->handleWindowResize = 'true';

        //====Default View
        (isset($calendarProperties['default_view'])) ? $this->defaultView = $calendarProperties['default_view'] : 'month';

        //====All Day Slot
        $this->allDaySlot = 'true';
        //====All Day Text
        $this->allDayText = 'all-day';
        //====Axis Format
        $this->axisFormat = 'h(:mm)A';
        //====Slot Minutes
        //$this->slotMinutes = '30'; //v1
        //====Snap Minutes
        //$this->snapMinutes = ''; //v1
        //====Default Event Minutes
        //$this->defaultEventMinutes = '120';
        //====First Hour
        //$this->firstHour = '6'; //v1
        //====Min Time
        $this->minTime = '0';
        //====Max Time
        $this->maxTime = '24';
        //====Slot Event Overlap
        $this->slotEventOverlap = 'true';

        //====Year
        $this->year = date('Y');
        //====Month
        $this->month = date('m') - 1;
        //====Date
        $this->date = date('d');

        //====Time Format
        if (isset($calendarProperties['timeformat']) && $calendarProperties['timeformat'] == 'standard') {
            $this->timeFormat = '{' . substr(str_replace('"', "'", json_encode(array('agenda' => 'hh:mm A', '' => 'hh:mm A'))), 1, -1) . '}';
        } else {
            $this->timeFormat = '{' . substr(str_replace('"', "'", json_encode(array('agenda' => 'hh:mm A', '' => 'hh:mm A'))), 1, -1) . '}';
        }
        //====Column Format
        $this->columnFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'ddd', 'week' => 'ddd M/D', 'day' => 'dddd M/D'))), 1, -1) . '}';
        //====Title Format
        $this->titleFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'MMMM YYYY', 'week' => 'MMM D YYYY', 'day' => 'dddd, MMM D, YYYY'))), 1, -1) . '}';
        //====Button Text
        $this->buttonText = '{' . substr(str_replace('"', "'", json_encode(array('prev' => '&lsaquo;', 'next' => '&rsaquo;', 'prevYear' => '&laquo;', 'nextYear' => '&raquo;', 'today' => 'today', 'month' => 'month', 'week' => 'week', 'day' => 'day'))), 1, -1) . '}';
        //====Month Names
        $this->monthNames = '[' . substr(str_replace('"', "'", json_encode(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'))), 1, -1) . ']';
        //====Month Short Names
        $this->monthNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'))), 1, -1) . ']';
        //====Day Names
        $this->dayNames = '[' . substr(str_replace('"', "'", json_encode(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'))), 1, -1) . ']';
        //====Day Names Short
        $this->dayNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'))), 1, -1) . ']';
        //====Week Number Title
        $this->weekNumberTitle = 'W';

        //====Selectable
        $this->selectable = 'false';
        //====Select Helper
        $this->selectHelper = 'false';
        //====Unselect Auto
        $this->unselectAuto = 'true';
        //====Unselect Cancel
        $this->unselectCancel = '';

        //====Load Event Object
        //$this->eventObj = new C_Events();

        //====Events
        $this->events = '[]';
        //====Event Sources
        $this->eventSources = '[]';
        //====All Day Default
        $this->allDayDefault = 'true';
        //====Ignore Time Zone
        (isset($calendarProperties['time_zone']) && ((int)$calendarProperties['time_zone'] >= -12 && (int)$calendarProperties['time_zone'] <= 12)) ? $this->ignoreTimezone = 'true' : $this->ignoreTimezone = 'false';

        //====Start Param
        $this->startParam = 'start';
        //====End Param
        $this->endParam = 'end';
        //====Lazy Fetching
        $this->lazyFetching = 'true';

        //=====Event Color
        $this->eventColor = '';
        //=====Event Background Color
        $this->eventBackgroundColor = '';
        //=====Event Border Color
        $this->eventBorderColor = '';
        //=====Event Text Color
        $this->eventTextColor = '';

        //=====Editable
        $this->editable = 'false';
        //=====Event Start Editable
        $this->eventStartEditable = 'true';
        //=====Event Duration Editable
        $this->eventDurationEditable = 'true';
        //=====Drag Revert Duration
        $this->dragRevertDuration = '500';
        //=====Drag Opacity
        $this->dragOpacity = "{agenda: .5, '':1.0}";

        //=====Droppable
        $this->droppable = 'false';
        //=====Drop Accept
        $this->dropAccept = '*';


    }

    /**
     * header: Setter
     *
     * Format:
     * Default
     * {
     *     left:   'title',
     *     center: '',
     *     right:  'today prev,next'
     * }
     *
     * If not set: either false or assigns the param
     *
     * Setting the header options to false will display no header. An object can be supplied with
     * properties left, center, and right. These properties contain strings with comma/space separated values.
     * Values separated by a comma will be displayed adjacently. Values separated by a space will be displayed
     * with a small gap in between. Strings can contain any of the following values:
     *
     * title
     * text containing the current month/week/day
     * prev
     * button for moving the calendar back one month/week/day
     * next
     * button for moving the calendar forward one month/week/day
     * prevYear
     * button for moving the calendar back on year
     * nextYear
     * button for moving the calendar forward one year
     * today
     * button for moving the calendar to the current month/week/day
     * a view name
     * button that will switch the calendar to any of the Available Views
     * Specifying an empty string for a property will cause it display no text/buttons.
     *
     * @see http://arshaw.com/fullcalendar/docs/display/header/
     *
     * @param array|string $param
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */

    public function header($param = '')
    {
        if (!$param || !isset($param)) $this->header = 'false';
        if ($param == '') $this->header = "{
                                                center:   'title',
                                                //right: 'basicDay, basicWeek, month, agendaDay, agendaWeek',
                                                right: 'agendaDay, month, agendaWeek, pec',
                                                left:  'today prev,next'
                                            }";
        else $this->header = $param;
    }

    /**
     * theme: Setter
     * Boolean, default: false
     * Enables/disables use of jQuery UI theming.
     *
     * Once you enable theming with true, you still need to include the CSS file for the theme you want.
     * For example, if you just downloaded a theme from the jQuery UI Themeroller,
     * you need to put a <link> tag in your page's <head>.
     *
     * @param string $v
     * @author Mostanser Billah
     * @see http://arshaw.com/fullcalendar/docs/display/theme/
     */
    public function theme($v = 'false')
    {
        $this->theme = (!$v) ? 'false' : 'true';
    }

    /**
     * buttonIcons : Setter
     *
     * Determines which theme icons appear on the header buttons.
     *
     * Object, default:{
     *      prev: 'left-single-arrow',
     *      next: 'right-single-arrow',
     *      prevYear: 'left-double-arrow',
     *      nextYear: 'right-double-arrow'
     *  }
     * This option only applies to calendars that have jQuery UI theming enabled with the theme option.
     * A hash must be supplied that maps button names (from the header) to icon strings.
     * The icon strings determine the CSS class that will be used on the button. For example, the string 'circle-triangle-w'
     * will result in the class 'ui-icon-triangle-w'.
     * If a button does not have an entry, it falls back to using buttonText.
     * If you are using a jQuery UI theme and would prefer not to display any icons and would rather use buttonText instead,
     * you can set the buttonIcons option to false.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/buttonIcons/
     */
    public function buttonIcons($v = 'false')
    {
        $this->buttonIcons = (!$v) ? 'false' : 'true';
    }

    /**
     * firstDay: Setter
     * The day that each week begins.
     *
     * Integer, default: 0 (Sunday)
     *
     * The value must be a number that represents the day of the week.
     * Sunday=0, Monday=1, Tuesday=2, etc.
     * This option is useful for UK users who need the week to start on Monday (1).
     *
     * In versions 1.1 through 1.2.1, this option was known as weekStart.
     *
     * @param string $v
     * @author Mostanser Billah
     * @see http://arshaw.com/fullcalendar/docs/display/firstDay/
     *
     */
    public function firstDay($v = '0')
    {
        $this->firstDay = (string)$v;
    }

    /**
     * isRTL: Setter
     *
     * Displays the calendar in right-to-left mode.
     * Boolean, default: false
     *
     * This option is useful for right-to-left languages such as Arabic and Hebrew.
     * In versions 1.1 through 1.2.1, this option was known as rightToLeft.
     *
     * @param string $v
     * @author Mostanser Billah
     * @see http://arshaw.com/fullcalendar/docs/display/isRTL/
     *
     */
    public function isRTL($v)
    {
        $this->isRTL = (!$v) ? 'false' : 'true';;
    }

    /**
     * weekends: Setter
     * Whether to include Saturday/Sunday columns in any of the calendar views.
     *
     * Boolean, default: true
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/weekends/
     *
     */
    public function weekends($v = 'true')
    {
        $this->weekends = (!$v) ? 'false' : 'true';
    }

    /**
     * hiddenDays: Setter
     *
     * Exclude certain days-of-the-week from being displayed.
     * Array, default: []
     *
     * The value is an array of day-of-week indices to hide. Each index is zero-base (Sunday=0) and ranges from 0-6. Example:
     *      hiddenDays: [ 2, 4 ] // hide Tuesdays and Thursdays
     *      hiddenDays: [ 1, 3, 5 ] // hide Mondays, Wednesdays, and Fridays
     *
     * By default, no days are hidden, unless weekends is set to false.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/hiddenDays/
     *
     */
    public function hiddenDays($v = '[]')
    {
        $this->hiddenDays = $v;
    }

    /**
     * weekMode : Setter
     * Determines the number of weeks displayed in a month view. Also determines each week's height.
     * String, default: 'fixed'
     *
     * Available options:
     * 'fixed'
     *      The calendar will always be 6 weeks tall. The height will always be the same,
     *      as determined by height, contentHeight, or aspectRatio.
     * 'liquid'
     *      The calendar will have either 4, 5, or 6 weeks, depending on the month.
     *      The height of the weeks will stretch to fill the available height, as determined by height, contentHeight, or aspectRatio.
     * 'variable'
     *      The calendar will have either 4, 5, or 6 weeks, depending on the month. Each week will have the same constant height,
     *      meaning the calendar’s height will change month-to-month.
     *
     * In versions 1.0 through 1.2.1, this option was known as fixedWeeks.
     *
     * @param string $v
     * @author Mostanser Billah
     * @see http://arshaw.com/fullcalendar/docs/display/weekMode/
     */
    public function weekMode($v = 'fixed')
    {
        $this->weekMode = (string)$v;
    }

    /**
     * weekNumbers: Setter
     * Determines if week numbers should be displayed on the calendar.
     *
     * Boolean, default: false
     * If set to true, week numbers will be displayed in a separate left column in the month/basic views as well as
     * at the top-left corner of the agenda views. See Available Views.
     * By defaut, FullCalendar will display the ISO8601 week number. To display other types of week numbers, see weekNumberCalculation.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/weekNumbers/
     *
     */
    public function weekNumbers($v = 'false')
    {
        $this->weekNumbers = (!$v) ? 'false' : 'true';
    }

    /**
     * weekNumberCalculation: Setter
     * The method for calculating week numbers that are displayed with the weekNumbers setting.
     *
     * String/Function, default:"iso"
     * The default ("iso") causes ISO8601 week numbers.
     *
     * You may also specify a function, which accepts a single native Date object and returns an integer week number.
     * Since FullCalendar currently lacks a built-in internationlization system, this is only way to implement localized week numbers.
     *
     * @param string $v default is "iso"
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/weekNumberCalculation/
     */
    public function weekNumberCalculation($v = 'iso')
    {
        $this->weekNumberCalculation = (string)$v;
    }

    /**
     * height : Setter
     * Will make the entire calendar (including header) a pixel height.
     * Integer
     *
     * By default, this option is unset and the calendar's height is calculated by aspectRatio.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/height/
     *
     */
    public function height($v = '')
    {
        $this->height = (string)$v;
    }

    /**
     * contentHeight: Setter
     * Will make the calendar's content area a pixel height.
     * Integer
     *
     * By default, this option is unset and the calendar's height is calculated by aspectRatio.
     *
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @param string $v
     * @see http://arshaw.com/fullcalendar/docs/display/contentHeight/
     */
    public function contentHeight($v = '')
    {
        $this->contentHeight = (string)$v;
    }

    /**
     * aspectRatio : Setter
     *
     * Determines the width-to-height aspect ratio of the calendar.
     * Float, default: 1.35
     *
     * A calendar is a block-level element that fills its entire avaiable width.
     * The calendar’s height, however, is determined by this ratio of width-to-height. (Hint: larger numbers make smaller heights).
     *
     * The setter only works in version 1.4.2 and later.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/aspectRatio/
     *
     */
    public function aspectRatio($v = '1.35')
    {
        $this->aspectRatio = (string)$v;
    }

    /**
     * handleWindowResize: Setter
     * Whether to automatically resize the calendar when the browser window resizes.
     * Boolean, default: true
     * If true, the calendar will automatically resize when the window resizes,
     * and the windowResize callback will be called. If false, none of this will happen.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/display/handleWindowResize/
     */
    public function handleWindowResize($v = 'true')
    {
        $this->handleWindowResize = (!$v) ? 'false' : 'true';
    }

    /**
     * Available Views
     * String, default: month
     * FullCalendar has a number of different "views", or ways of displaying days and events.
     * The following 5 views are all built in to FullCalendar:
     * month - see example
     * basicWeek - see example (available since version 1.3)
     * basicDay - see example (available since version 1.3)
     * agendaWeek - see example (available since version 1.4)
     * agendaDay - see example (available since version 1.4)
     * You can define header buttons to allow the user to switch between them.
     * You can set the initial view of the calendar with the defaultView option.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/views/defaultView/
     * @see http://arshaw.com/fullcalendar/docs/views/Available_Views/
     */
    public function defaultView($v = 'month')
    {
        $this->defaultView = (string)$v;
    }

    /**
     * Determines if the "all-day" slot is displayed at the top of the calendar.
     * Boolean, default: true
     * When hidden with false, all-day events will not be displayed in agenda views.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/allDaySlot/
     */
    public function allDaySlot($v = 'true')
    {
        $this->allDaySlot = (!$v) ? 'false' : 'true';
    }

    /**
     * The text titling the "all-day" slot at the top of the calendar.
     *
     * String, default: 'all-day'
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/allDayText/
     *
     */
    public function allDayText($v = 'all-day')
    {
        $this->allDayText = (string)$v;
    }


    /**
     * Determines the time-text that will be displayed on the vertical axis of the agenda views.
     * String, default: 'h(:mm)tt'
     * The value is a format-string that will be processed by formatDate.
     * The default value will produce times that look like "5pm" and "5:30pm".
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/axisFormat/
     */
    public function axisFormat($v = 'h(:mm)A')
    {
        $this->axisFormat = (string)$v;
    }

    /**
     * slotMinutes
     * The frequency for displaying time slots, in minutes.
     * Integer, default: 30
     * The default will make a slot every half hour.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/slotMinutes/
     */
    public function slotMinutes($v = '30')
    {
        $this->slotMinutes = (string)$v;
    }

    /**
     * snapMinutes
     * The time interval at which a dragged event will snap to the agenda view time grid.
     * Also affects the granularity at which selections can be made. Specified in number of minutes.
     *
     * Integer
     *
     * The default value will be whatever slotMinutes is, which defaults to 30 (half an hour).
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/snapMinutes/
     */
    public function snapMinutes($v = '30')
    {
        $this->snapMinutes = (string)$v;
    }

    /**
     * defaultEventMinutes
     * Determines the length (in minutes) an event appears to be when it has an unspecified end date.
     *
     * Integer, default: 120
     *
     * By default, if an Event Object as no end, it will appear to be 2 hours.
     * This option only affects events that appear in the agenda slots, meaning they have allDay set to true.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/defaultEventMinutes/
     */
    public function defaultEventMinutes($v = '120')
    {
        $this->defaultEventMinutes = (string)$v;
    }

    /**
     * firstHour
     * Determines the first hour that will be visible in the scroll pane.
     * Integer, default: 6
     *
     * Values must be from 0-23, where 0=midnight, 1=1am, etc.
     * The user will be able to scroll upwards to see events before this time.
     * If you want to prevent users from doing this, use the minTime option instead.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/firstHour/
     */
    public function firstHour($v = '6')
    {
        $this->firstHour = (string)$v;
    }


    /**
     * Determines the first hour/time that will be displayed, even when the scrollbars have been scrolled all the way up.
     * Integer/String, default: 0
     * This can be a number like 5 (which means 5am), a string like '5:30' (which means 5:30am) or a string like '5:30am'.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/minTime/
     */
    public function minTime($v = '0')
    {
        $this->minTime = (string)$v;
    }

    /**
     * Determines the last hour/time (exclusively) that will be displayed, even when the scrollbars have been scrolled all the way down.
     * Integer/String, default: 24
     *
     * This can be a number like 22 (which means 10pm), a string like '22:30' (which means 10:30pm) or a string like '10:30pm'.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/maxTime/
     */
    public function maxTime($v = '24')
    {
        $this->maxTime = (string)$v;
    }


    /**
     * slotEventOverlap
     * Determines if timed events in agenda view should visually overlap.
     *
     * Boolean, default: true
     *
     * When set to true (the default), events will overlap each other. At most half of each event will be obscured:
     * When set to false, there will be absolutely no overlapping:
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/agenda/slotEventOverlap/
     */
    public function slotEventOverlap($v = 'true')
    {
        $this->slotEventOverlap = (!$v) ? 'false' : 'true';
    }


    /**
     * year
     * The initial year when the calendar loads.
     *
     * Integer
     *
     * Must be a 4-digit year like 2009.
     * If year is unspecified, the calendar will begin at the current year.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/current_date/year/
     *
     */
    public function year($v = '')
    {
        $this->year = (string)(($v == '') ? date('Y') : $v);
    }

    /**
     * month
     * The initial month when the calendar loads.
     * Integer
     *
     * IMPORTANT: The value is 0-based, meaning January=0, February=1, etc.
     *
     * If month is unspecified and year is set to the current year, the calendar will start on the current month.
     * If month is unspecified and year is not set to the current year, the calendar will start on January.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/current_date/month/
     */

    public function month($v = '')
    {
        $this->month = (string)(($v == '') ? date('m') : $v);
    }

    /**
     * date
     * The initial date-of-month when the calendar loads.
     * Integer
     *
     * This option only matters for the week & day views. Month view does not need this option,
     * because month view always displays the entire month from start to finish.
     * If date is unspecified, and year/month are set to the current year/month, then the calendar will start on the current date.
     * If date is unspecified, and year/month are not set to the current year/month, then the calendar will start on the first of the month.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/current_date/date/
     */
    public function date($v = '')
    {
        $this->date = (($v == '') ? date('d') : $v);
    }


    /**
     * timeFormat
     * Determines the time-text that will be displayed on each event.
     *
     * String/View Option Hash, default:
     *  {
     *      // for agendaWeek and agendaDay
     *      agenda: 'h:mm{ - h:mm}', // 5:00 - 6:30
     *
     *      // for all other views
     *      '': 'h(:mm)t'            // 7p
     *  }
     *
     * A single format string will change the time-text for events in all views. A View Option Hash may be provided to target specific views (this is what the default does).
     * Uses formatDate/formatDates formatting rules. (The formatting rules were much different in versions before 1.3. See here)
     * Time-text will only be displayed for Event Objects that have allDay equal to false. Here is an example of displaying all events in a 24-hour format:
     *
     * A View Option Hash can only be provided in version 1.4 and later.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/text/timeFormat/
     */
    public function timeFormat($v = '')
    {
        if ($v == '') $this->timeFormat = '{' . substr(str_replace('"', "'", json_encode(array('agenda' => 'h:mm{ - h:mm}', '' => 'h(:mm)A'))), 1, -1) . '}';
        else if (gettype($v) == 'string') $this->timeFormat = (string)$v;
        else if (gettype($v) == 'array') $this->timeFormat = '{' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . '}';
        else $this->timeFormat = '{' . substr(str_replace('"', "'", json_encode(array('agenda' => 'h:mm{ - h:mm}', '' => 'h(:mm)A'))), 1, -1) . '}';
    }


    /**
     * columnFormat
     * Determines the text that will be displayed on the calendar's column headings.
     * String/View Option Hash, default:
     * {
     *       month: 'ddd',    // Mon
     *       week: 'ddd M/d', // Mon 9/7
     *       day: 'dddd M/d'  // Monday 9/7
     * }
     *
     * A single string will set the title format for all views. A View Option Hash may be provided to target specific views (this is what the default does).
     * Uses formatDate/formatDates formatting rules. (The formatting rules were much different in versions before 1.3. See here)
     *
     * A View Option Hash can only be provided in version 1.4 and later.
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/text/columnFormat/
     */
    public function columnFormat($v = '')
    {
        if ($v == '') $this->columnFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'ddd', 'week' => 'ddd M/d', 'day' => 'dddd M/d'))), 1, -1) . '}';
        else if (gettype($v) == 'string') $this->columnFormat = (string)$v;
        else if (gettype($v) == 'array') $this->columnFormat = '{' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . '}';
        else $this->columnFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'ddd', 'week' => 'ddd M/d', 'day' => 'dddd M/d'))), 1, -1) . '}';
    }

    /**
     * titleFormat
     * Determines the text that will be displayed in the header's title.
     *
     * String/View Option Hash, default:
     * {
     *      month: 'MMMM yyyy',                             // September 2009
     *      week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}", // Sep 7 - 13 2009
     *      day: 'dddd, MMM d, yyyy'                  // Tuesday, Sep 8, 2009
     * }
     *
     * A single string will set the title format for all views. A View Option Hash may be provided to target specific views (this is what the default does).
     * Uses formatDate/formatDates formatting rules. (The formatting rules were much different in versions before 1.3. See here)
     * A View Option Hash can only be provided in version 1.4 and later.
     *
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/text/titleFormat/
     */

    public function titleFormat($v = '')
    {
        if ($v == '') $this->titleFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'MMMM YYYY', 'week' => 'MMM D[ YYYY]', 'day' => 'dddd, MMM D, YYYY'))), 1, -1) . '}';
        else if (gettype($v) == 'string') $this->titleFormat = (string)$v;
        else if (gettype($v) == 'array') $this->titleFormat = '{' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . '}';
        else $this->titleFormat = '{' . substr(str_replace('"', "'", json_encode(array('month' => 'MMMM YYYY', 'week' => 'MMM d[ YYYY]', 'day' => 'dddd, MMM D, YYYY'))), 1, -1) . '}';
    }

    /**
     * buttonText
     * @param string $v
     * Text that will be displayed on buttons of the header.
     *
     * Object, default:
     * {
     *      prev:     '&lsaquo;', // <
     *      next:     '&rsaquo;', // >
     *      prevYear: '&laquo;',  // <<
     *      nextYear: '&raquo;',  // >>
     *      today:    'today',
     *      month:    'month',
     *      week:     'week',
     *      day:      'day'
     * }
     *
     * @see http://arshaw.com/fullcalendar/docs/text/buttonText/
     *
     */

    public function buttonText($v = '')
    {
        if ($v == '') $this->buttonText = '{' . substr(str_replace('"', "'", json_encode(array('prev' => '&lsaquo;', 'next' => '&rsaquo;', 'prevYear' => '&laquo;', 'nextYear' => '&raquo;', 'today' => 'today', 'month' => 'month', 'week' => 'week', 'day' => 'day'))), 1, -1) . '}';
        else if (gettype($v) == 'string') $this->buttonText = (string)$v;
        else if (gettype($v) == 'array') $this->buttonText = '{' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . '}';
        else $this->buttonText = '{' . substr(str_replace('"', "'", json_encode(array('prev' => '&lsaquo;', 'next' => '&rsaquo;', 'prevYear' => '&laquo;', 'nextYear' => '&raquo;', 'today' => 'today', 'month' => 'month', 'week' => 'week', 'day' => 'day'))), 1, -1) . '}';
    }

    /**
     * monthNames
     * @param string $v
     *
     * Full Names of Months
     *
     * Array, default:['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October', 'November', 'December']
     *
     * Prior to version 1.3, this was possible by setting $.fullCalendar.monthNames
     * @see http://arshaw.com/fullcalendar/docs/text/monthNames/
     */
    public function monthNames($v = '')
    {
        if ($v == '') $this->monthNames = '[' . substr(str_replace('"', "'", json_encode(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'))), 1, -1) . ']';
        else if (gettype($v) == 'string') $this->monthNames = (string)$v;
        else if (gettype($v) == 'array') $this->monthNames = '[' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . ']';
        else $this->monthNames = '[' . substr(str_replace('"', "'", json_encode(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'))), 1, -1) . ']';
    }

    /**
     * monthNamesShort
     *
     * @param string $v
     *
     * Abbreviated names of months.
     *
     * Array, default:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
     *
     * Prior to version 1.3, this was possible by setting $.fullCalendar.monthAbbrevs
     * @see http://arshaw.com/fullcalendar/docs/text/monthNamesShort/
     */
    public function monthNamesShort($v = '')
    {
        if ($v == '') $this->monthNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'))), 1, -1) . ']';
        else if (gettype($v) == 'string') $this->monthNamesShort = (string)$v;
        else if (gettype($v) == 'array') $this->monthNamesShort = '[' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . ']';
        else $this->monthNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'))), 1, -1) . ']';
    }

    /**
     * dayNames
     *
     * @param string $v
     *
     * Full names of days-of-week.
     *
     * Array, default:['Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday', 'Friday', 'Saturday']
     *
     * Prior to version 1.3, this was possible by setting $.fullCalendar.dayNames
     * @see http://arshaw.com/fullcalendar/docs/text/dayNames/
     */
    public function dayNames($v = '')
    {
        if ($v == '') $this->dayNames = '[' . substr(str_replace('"', "'", json_encode(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'))), 1, -1) . ']';
        else if (gettype($v) == 'string') $this->dayNames = (string)$v;
        else if (gettype($v) == 'array') $this->dayNames = '[' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . ']';
        else $this->dayNames = '[' . substr(str_replace('"', "'", json_encode(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'))), 1, -1) . ']';
    }

    /**
     * dayNamesShort
     *
     * @param string $v
     *
     * Abbreviated names of days-of-week.
     *
     * Array, default:['Sun', 'Mon', 'Tue', 'Wed','Thu', 'Fri', 'Sat']
     *
     * Prior to version 1.3, this was possible by setting $.fullCalendar.dayNamesShort
     *
     * @see http://arshaw.com/fullcalendar/docs/text/dayNamesShort/
     */
    public function dayNamesShort($v = '')
    {
        if ($v == '') $this->dayNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'))), 1, -1) . ']';
        else if (gettype($v) == 'string') $this->dayNamesShort = (string)$v;
        else if (gettype($v) == 'array') $this->dayNamesShort = '[' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . ']';
        else $this->dayNamesShort = '[' . substr(str_replace('"', "'", json_encode(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'))), 1, -1) . ']';
    }

    /**
     * weekNumberTitle
     * The heading text for week numbers.
     * String, default: "W"
     * This text will go above the week number column in the month/basic views. It will go alongside the week number text in the top-left cell for agenda views.
     *
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/text/weekNumberTitle/
     */
    public function weekNumberTitle($v = 'W')
    {
        $this->weekNumberTitle = (string)$v;
    }

    /**
     * selectable
     * Allows a user to highlight multiple days or timeslots by clicking and dragging.
     * Boolean/View Option Hash, default: false
     * To let the user make selections by clicking and dragging, this option must be set to true.
     * The select and unselect callbacks will be useful for monitoring when selections are made and cleared.`
     * To learn the ways in which selections can be cleared, read the docs for the unselect callback.
     *
     * To view an example of how to create a new event based on a user's selection see "demos/selectable.html" in the download, or visit this page.`
     *
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/selection/selectable/
     */

    public function selectable($v = 'false')
    {
        if (gettype($v) == 'array') $this->selectable = '{' . substr(str_replace('"', "'", json_encode($v)), 1, -1) . '}';
        else if (gettype($v) == 'boolean') $this->selectable = (!$v) ? 'false' : 'true';
        else $this->selectable = 'false';
    }

    /**
     * selectHelper
     * Whether to draw a "placeholder" event while the user is dragging.
     * Boolean/Function, default: false
     *
     * This option only applies to the agenda views.
     * A value of true will draw a "placeholder" event while the user is dragging
     * (similar to what Google Calendar does for its week and day views).
     * A value of false (the default) will draw the standard highlighting over each cell.
     * A function can also be specified for drawing custom elements.
     * It will be given 2 arguments: the selection's start date and end date (Date objects).
     * It must return a DOM element that will be used.
     *
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/selection/selectHelper/
     */
    public function selectHelper($v = 'false')
    {
        if (gettype($v) == 'string') $this->selectHelper = (string)$v;
        else if (gettype($v) == 'boolean') $this->selectHelper = (!$v) ? 'false' : 'true';
        else $this->selectHelper = 'false';
    }

    /**
     * unselectAuto
     * Whether clicking elsewhere on the page will cause the current selection to be cleared.
     * Boolean, default: true
     *
     * This option can only take effect when selectable is set to true.
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/selection/unselectAuto/
     */
    public function unselectAuto($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->unselectAuto = (!$v) ? 'false' : 'true';
        else $this->unselectAuto = 'true';
    }

    /**
     * unselectCancel
     * A way to specify elements that will ignore the unselectAuto option.
     * String, default: ''
     *
     * Clicking on elements that match this jQuery selector will prevent the current selection from being cleared (due to the unselectAuto option).
     * This option is useful if you have a "Create an event" form that shows up in response to the user making a selection.
     * When the user clicks on this form, you probably don't want to the current selection to go away.
     * Thus, you should add a class to your form such as "my-form", and set the unselectCancel option to ".my-form".
     *
     * @param string $v
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/selection/unselectCancel/
     */
    public function unselectCancel($v = '')
    {
        $this->unselectCancel = (string)$v;

    }

    /**
     * Generates Full Calendar Formatted Events
     *
     * @param array|object $events
     * @param string $mode default is "array"
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/event_data/events_array
     */
    public function events($events, $mode = 'array')
    {
        switch ($mode) {
            case 'calendar':
                $eventsURLs = $events;
                $eventSrcStr = '';

                //==== calendar colors
                $colorArray = array(
                    '#3a87ad'=>'gcal-event-1',
                    '#eaff00'=>'gcal-event-2',
                    '#f903a5'=>'gcal-event-3',
                    '#1a9b05'=>'gcal-event-4',
                    '#0c2ddd'=>'gcal-event-5',
                    '#ff4206'=>'gcal-event-6',
                    '#17cccc'=>'gcal-event-7',
                    '#0a0003'=>'gcal-event-8',
                    '#a8a8a8'=>'gcal-event-9'
                );
                foreach($eventsURLs as $k=>$eURL){
                    $color = $colorArray[$eURL['color']];
                    $eventSrcStr .= "{url: '".$eURL['url']."',className: ' ".$color." gcal-event',allDayDefault: false},";
                }

                $this->eventSources = "[ $eventSrcStr ]";

                $events = NULL;
                if ($this->eventsArr == NULL) $this->eventsArr = array();
                if ($events == NULL) $events = array();
                $this->eventsArr = array_merge($this->eventsArr, $events);
                //$this->events = '[' . substr(str_replace('"', "'", json_encode($this->eventsArr)), 1, -1) . ']';
                $this->events = '[' . substr(json_encode($this->eventsArr), 1, -1) . ']';
                break;

            case 'json':
                $this->events = "'" . $events . "'";
                break;

            case 'array':
                ;
            default:
                if ($this->eventsArr == NULL) $this->eventsArr = array();
                if ($events == NULL) $events = array();
                $this->eventsArr = array_merge($this->eventsArr, $events);
                //$this->events = '[' . substr(str_replace('"', "'", json_encode($this->eventsArr)), 1, -1) . ']';
                $this->events = '[' . substr(json_encode($this->eventsArr), 1, -1) . ']';
        }
    }

    /**
     * Event Source For Full Calendar
     * A way to specify multiple event sources.
     * Array
     *
     * This option is used instead of the events option.
     *
     * You can put any number of event arrays, functions, JSON feed URLs, or full-out Event Source Objects into the eventSources array.
     * @param $eventSourceObjects
     * @author Richard Z.C. <info@phpeventcalendar.com>
     * @see http://arshaw.com/fullcalendar/docs/event_data/eventSources/
     */
    public function eventSources($eventSourceObjects)
    {
        $this->eventSources = '{' . substr(str_replace('"', "'", json_encode($eventSourceObjects)), 1, -1) . '}';
    }

    /**
     * allDayDefault
     * Boolean, default: true
     * Determines the default value for each Event Object's allDay property, when it is unspecified.
     * @param string $v
     *
     * @see http://arshaw.com/fullcalendar/docs/event_data/allDayDefault/
     */
    public function allDayDefault($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->allDayDefault = (!$v) ? 'false' : 'true';
        else $this->allDayDefault = 'true';
    }

    /**
     * ignoreTimezone
     * When parsing ISO8601 dates, whether UTC offsets should be ignored while processing event source data.
     * @param string $v
     * Boolean, default: true
     *
     * The default is true, which means the UTC offset for all ISO8601 dates will be ignored.
     * For example, the date "2008-11-05T08:15:30-05:00" will be processed as November 5th, 2008 at 8:15am in the local offset of the browser.
     *
     * If you are using ISO8601 dates with UTC offsets, chances are you want them processed. You must set this option to false.
     * In the future, the default for this option will probably be changed to false.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_data/ignoreTimezone/
     */
    public function ignoreTimezone($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->ignoreTimezone = (!$v) ? 'false' : 'true';
        else $this->ignoreTimezone = 'true';
    }

    /**
     * startParam
     * @param string $v
     * A GET parameter of this name will be inserted into each JSON feed's URL.
     *
     * String, default: 'start'
     * The value of this GET parameter will be a UNIX timestamp denoting the start of the first visible day (inclusive).
     *
     * @see http://arshaw.com/fullcalendar/docs/event_data/startParam/
     */
    public function startParam($v = 'start')
    {
        $this->startParam = $v;
    }

    /**
     * endParam
     * @param string $v
     * A GET parameter of this name will be inserted into each JSON feed's URL.
     * String, default: 'end'
     * The value of this GET parameter will be a UNIX timestamp denoting the end of the last visible day (exclusive).
     *
     * @see http://arshaw.com/fullcalendar/docs/event_data/endParam/
     */
    public function endParam($v = 'end')
    {
        $this->endParam = $v;
    }

    /**
     * lazyFetching
     * @param string $v
     * Determines when event fetching should occur.
     *
     * Boolean, default: true
     *
     * When set to true (the default), the calendar will only fetch events when it absolutely needs to, minimizing AJAX calls.
     * For example, say your calendar starts out in month view, in February.
     * FullCalendar will fetch events for the entire month of February and store them in its internal cache.
     * Then, say the user switches to week view and begins browsing the weeks in February.
     * The calendar will avoid fetching events because it already has this information stored.
     *
     * When set to false, the calendar will fetch events any time the view is switched, or any time the current date
     * changes (for example, as a result of the user clicking prev/next).
     *
     * Before this option existed, FullCalendar would always do "lazy" event fetching, as if lazyFetching were set to true.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_data/lazyFetching/
     */
    public function lazyFetching($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->lazyFetching = (!$v) ? 'false' : 'true';
        else $this->lazyFetching = 'true';
    }

    /**
     * eventColor
     * @param string $v
     * Sets the background and border colors for all events on the calendar.
     * String
     *
     * You can use any of the CSS color formats such #f00, #ff0000, rgb(255,0,0), or red.
     * This option can be overridden on a per-source basis with the color Event Source Object option or on a per-event basis with the color Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_rendering/eventColor/
     */
    public function eventColor($v = '')
    {
        $this->eventColor = $v;
    }

    /**
     * eventBackgroundColor
     * @param string $v
     * Sets the background color for all events on the calendar.
     * String
     * You can use any of the CSS color formats such #f00, #ff0000, rgb(255,0,0), or red.
     * This option can be overridden on a per-source basis with the backgroundColor Event Source Object option or on a per-event basis with the backgroundColor Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_rendering/eventBackgroundColor/
     */
    public function eventBackgroundColor($v = '')
    {
        $this->eventBackgroundColor = $v;
    }

    /**
     * eventBorderColor
     * @param string $v
     * Sets the border color for all events on the calendar.
     * String
     *
     * You can use any of the CSS color formats such #f00, #ff0000, rgb(255,0,0), or red.
     *
     * This option can be overridden on a per-source basis with the borderColor Event Source Object option or on a per-event basis with the borderColor Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_rendering/eventBorderColor/
     */
    public function eventBorderColor($v = '')
    {
        $this->eventBorderColor = $v;
    }

    /**
     * eventTextColor
     * @param string $v
     * Sets the text color for all events on the calendar.
     * String
     *
     * You can use any of the CSS color formats such #f00, #ff0000, rgb(255,0,0), or red.
     * This option can be overridden on a per-source basis with the textColor Event Source Object option or on a per-event basis with the textColor Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_rendering/eventTextColor/
     */
    public function eventTextColor($v = '')
    {
        $this->eventTextColor = $v;
    }

    /**
     * editable
     * @param string $v
     * Determines whether the events on the calendar can be modified.
     * Boolean, default: false
     *
     * This determines if the events can be dragged and resized. Enables/disables both at the same time.
     * If you don't want both, use editable in conjunction with eventStartEditable and eventDurationEditable.
     * This option can be overridden on a per-event basis with the Event Object editable property.
     *
     * Prior to version 1.3, the draggable option was used instead.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_ui/editable/
     */
    public function editable($v = 'false')
    {
        if (gettype($v) == 'boolean') $this->editable = (!$v) ? 'false' : 'true';
        else $this->editable = 'true';
    }

    /**
     * eventStartEditable
     * @param string $v
     *
     * Allow events' start times to be editable through dragging.
     * Boolean, default: true
     *
     * This option can be overridden on a per-source basis with the startEditable Event Source Object option or on a per-event basis with the startEditable Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_ui/eventStartEditable/
     */
    public function eventStartEditable($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->eventStartEditable = (!$v) ? 'false' : 'true';
        else $this->eventStartEditable = 'true';
    }

    /**
     * eventDurationEditable
     * @param string $v
     *
     * Allow events' durations to be editable through resizing.
     * Boolean, default: true
     * This option can be overridden on a per-source basis with the durationEditable
     * Event Source Object option or on a per-event basis with the durationEditable Event Object option.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_ui/eventDurationEditable/
     */
    public function eventDurationEditable($v = 'true')
    {
        if (gettype($v) == 'boolean') $this->eventDurationEditable = (!$v) ? 'false' : 'true';
        else $this->eventDurationEditable = 'true';
    }


    /**
     * dragRevertDuration
     * @param string $v
     *
     * Time it takes for an event to revert to its original position after an unsuccessful drag.
     * Integer, default: 500
     *
     * Time is in milliseconds (1 second = 1000 milliseconds).
     *
     * Prior to version 1.3, this option was known as eventRevertDuration
     *
     * @see http://arshaw.com/fullcalendar/docs/event_ui/dragRevertDuration/
     */
    public function dragRevertDuration($v = '500')
    {
        $this->dragRevertDuration = '500';
    }

    /**
     * dragOpacity
     * @param string $v
     * The opacity of an event while it is being dragged.
     * Float/View Option Hash, default:
     * {
     *      // for agendaWeek and agendaDay
     *      agenda: .5,
     *      // for all other views
     *      '': 1.0
     * }
     *
     * Float values range from 0.0 to 1.0.
     * Specify a single number to affect all views, or a View Option Hash to target specific views (which is what the default does).
     * A View Option Hash can only be provided in versions 1.4 and later.
     * Prior to version 1.3, this option was known as eventDragOpacity.
     *
     * @see http://arshaw.com/fullcalendar/docs/event_ui/dragOpacity/
     */
    public function dragOpacity($v = "{agenda: .5, '': 1.0}")
    {
        $this->dragOpacity = $v;
    }

    /**
     * @param string $v
     * Determines if jQuery UI draggables can be dropped onto the calendar.
     * Boolean, default: false
     *
     * This option operates with jQuery UI draggables. You must download the appropriate
     * jQuery UI files and initialize a draggable element. Additionally, you must set the calendar's droppable option to true.
     * Here is how you might initialize an element that can be dragged onto a calendar:
     * $('#my-draggable').draggable({
     *      revert: true,      // immediately snap back to original position
     *      revertDuration: 0  //
     * });
     *
     * $('#calendar').fullCalendar({
     *      droppable: true,
     *      drop: function(date, allDay) {
     *          alert("Dropped on " + date + " with allDay=" + allDay);
     *      }
     * });
     *
     * How can I use this to add events???
     * Good question. It is a common need to have an "external list of events" that can be dragged onto the calendar.
     *
     * While the droppable option deals with generic jQuery UI draggables and is not specifically tailored to adding events, it is possible to achieve this with a few lines of code.
     * Follow the external-dragging.html example in FullCalendar's download. You can also view the example online.
     * http://arshaw.com/js/fullcalendar-1.5.3/demos/external-dragging.html
     *
     * In short, you must call renderEvent yourself in the drop callback.
     * Hopefully, this task will become more convenient with future API changes.
     *
     * @see http://arshaw.com/fullcalendar/docs/dropping/droppable/
     */
    public function droppable($v = 'false')
    {
        if (gettype($v) == 'boolean') $this->droppable = (!$v) ? 'false' : 'true';
        else $this->droppable = 'true';
    }


    /**
     * dropAccept
     * @param string $v
     * Provides a way to filter which elements can be dropped onto the calendar.
     * String/Function, default: "*"
     * By default, after setting a calendar' droppable option to true, the calendar will accept any draggables that are dropped onto the calendar.
     * The dropAccept option allows the calendar be more selective about which elements can/can't be dropped.
     *
     * The value of dropAccept can be a string jQuery selector.
     * It can also be a function that accepts the draggable item as a single argument, and returns true if the element can be dropped onto the calendar.
     *
     * In the following example, the first draggable (with id "draggable1") can be dropped on the calendar, while the second draggable (with id "draggable2") cannot:
     * ...
     * <div id='calendar'></div>
     * <div id='draggable1' class='cool-event'></div>
     * <div id='draggable2'></div>
     * ...
     *
     * and here is the JavaScript:
     * $('#calendar').fullCalendar({
     *      droppable: true,
     *      dropAccept: '.cool-event',
     *      drop: function() {
     *          alert('dropped!');
     *      }
     * });
     *
     * $('#draggable1').draggable();
     * $('#draggable2').draggable();
     *
     * @see http://arshaw.com/fullcalendar/docs/dropping/dropAccept/
     */
    public function dropAccept($v = '*')
    {
        $this->dropAccept = (string)$v;
    }


}

?>