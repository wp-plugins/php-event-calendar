<?php
/**
 * File: cls_security.php: Secures the Calendar Application
 *
 * Description: Secures the Calendar Application
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
 * Class C_Security : Secures the Calendar Application
 *
 * Description: Secures the Calendar Application
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */
class C_Security {

    /**
     * @var object $db
     */
    public $db;
    /**
     * @var object $dbObj
     */
    public $dbObj;
    /**
     * @var array $userData
     */
    public $userData;
    /**
     * @var boolean $loggedIn
     */
    public $loggedIn;
    /**
     * @var string $errorMsg
     */
    public $errorMsg;
    /**
     * @var string $successMsg
     */
    public $successMsg;

    /**
     * @ignore
     */
    public function __construct(){

    }

    /**
     * Connects with DB for internal use
     * @ignore
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     */
    public function dbConnect(){
        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST,PEC_DB_USER,PEC_DB_PASS,PEC_DB_NAME,PEC_DB_TYPE,PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;

    }

    /**
     * Authorize an user
     * @param int $userId
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     * @ignore
     */
    public static function authorizeAccess($userId=0){

    }

    /**
     * validate an user
     * @author: Richard Z.C. <info@phpeventcalendar.com>
     * @ignore
     */
    public static function validateUserSession(){
        if(!isset($_SESSION['userData'])) header('Location: index.php');

        //=== if user is valid then process session data a bit for default calendar
        if(isset($_SESSION['userData']['active_calendar_id']) && is_string($_SESSION['userData']['active_calendar_id'])) $_SESSION['userData']['active_calendar_id'] = array($_SESSION['userData']['active_calendar_id']);
        /*
        echo '<pre>';
        print_r($_SESSION['userData']['active_calendar_id']);
        echo '</pre>';
        */
    }

}
?>