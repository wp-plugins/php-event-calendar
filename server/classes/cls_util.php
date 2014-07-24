<?php
/**
 * File: cls_utility.php: Utility
 *
 * Description: Utility Library, lightly used in this function
 *
 * @package eventcalendar
 * @author Richard Z.C. <info@phpeventcalendar.com>
 *
 * @version beta-1.0.2
 * @copyright 2014, phpeventcalendar.com
 * @filesource
 * @ignore
 */

/**
 * Class C_Utility : Utility Library
 *
 * Description: At the moment using this library for debugging purpose
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */
class C_Utility
{
    /**
     * Determines whether to tell the application if debug mode is on or off
     * @return bool
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function is_debug()
    {
        return (DEBUG) ? true : false;
    }
}

?>
