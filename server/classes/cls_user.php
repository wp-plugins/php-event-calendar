<?php
/**
 * File: cls_user.php: User Manager for Calendar Application
 *
 * Description: User Manager for Calendar Application
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
 * Class C_Security : User Manager for Calendar Application
 *
 * Description: User Manager for Calendar Application
 *
 * @author: Richard Z.C. <info@phpeventcalendar.com>
 * @package eventcalendar
 * @version beta-1.0.2
 *
 */
class C_User
{
    /**
     * @var object $db
     */
    public $db;
    /**
     * @var C_Database $dbObj
     */
    public $dbObj;
    /**
     * @var array $userData
     */
    public $userData;
    /**
     * @var boolean|string $loggedIn
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
     * __constructor Method checks user credentials are provided properly or not
     * @param $username
     * @param $password
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function __construct($username, $password)
    {
        //==== Check User Data
        if (empty($username) || empty($password)) {
            $this->errorMsg = 'Username OR Password is Missing';
            $this->loggedIn = false;
            return false;
        } else {
            @$this->userData->username = trim($username);
            @$this->userData->password = md5(trim($password));
            @$this->loggedIn = 'in_progress';
        }

        //====DB
        $this->dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $this->db = $this->dbObj->db;
    }

    /**
     * Determines whether an user exists or not
     * @param $username
     * @param $password
     * @return bool true if success and false otherwise
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public function checkUser($username, $password)
    {
        $sql = "SELECT * FROM  `pec_users` WHERE `username` = '$username' AND `password` = '$password'";
        $isUser = $this->dbObj->db_query($sql);


        if ($this->dbObj->num_rows($isUser) > 0) {
            $this->userData->data = $isUser;
            $this->loggedIn = true;
            $this->successMsg = 'Welcome ' . $username;
            return true;
        } else {
            $this->userData = NULL;
            $this->errorMsg = 'Incorrect Username or Password';
            $this->loggedIn = false;
            return false;
        }

    }

    /**
     * Fetches User Details from Database based on userID
     * @param int $userID
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function getUserDetails($userID = 0)
    {
        if (isset($_SESSION['userData'])) return $_SESSION['userData'];
    }

    /**
     * Sets a calendar active
     * @param $userID
     * @param $calIDs
     * @author Richard Z.C. <info@phpeventcalendar.com>
     */
    public static function setActiveCalendar($userID, $calIDs)
    {
        //====DB
        $dbObj = new C_Database(PEC_DB_HOST, PEC_DB_USER, PEC_DB_PASS, PEC_DB_NAME, PEC_DB_TYPE, PEC_DB_CHARSET);
        $db = $dbObj->db;

        $cids = implode(',', $calIDs);

        $sql = "UPDATE `pec_users` SET `active_calendar_id`='$cids' WHERE `id`=$userID";
        $isUser = $dbObj->db_query($sql);

    }

    /**
     * @ignore
     */
    public function userLogOut()
    {

    }

    /**
     * @ignore
     */
    public function getUserPermissions()
    {

    }

    /**
     * @ignore
     */
    public function getUserAllCalendars()
    {

    }

    /**
     * @ignore
     */
    public function getUserCalendar()
    {

    }


    /**
     * @ignore
     */
    private function storeUserDataIntoSession()
    {

    }
}

?>