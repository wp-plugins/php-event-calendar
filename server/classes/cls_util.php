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

    // Indents JSON string to be more readable
    public static function indent_json($json) {
        $result    = '';
        $pos       = 0;
        $strLen    = strlen($json);
        $indentStr = '  ';
        $newLine   = "\n";

        for($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string
            $char = substr($json, $i, 1);

            // If this character is the end of an element,
            // output a new line and indent the next line
            if($char == '}' || $char == ']') {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            #bug: it adds newline wronly when the value is comma(,). Removed for now
            //if ($char == ',' || $char == '{' || $char == '[') {
            if ($char == '{' || $char == '[') {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
        }

        return $result;
    }
}

?>
