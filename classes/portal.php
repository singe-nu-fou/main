<?php
    class portal{
        public $USER_NAME;
        public $USER_TYPE;
        public $USER_LOGIN;
        
        public function __construct(){
            if(self::isSignedIn()){
                foreach($this AS $key=>$value){
                    $this->$key = $_SESSION[$key];
                }
            }
        }
        
        public function signIn($USER_NAME,$USER_PASS){
            $db = self::database();
            $db->query("SELECT USER_NAME,USER_PASS,USER_TYPE_NAME,USER_LOGIN FROM USER_ACCOUNTS JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID WHERE USER_NAME = ?",array($USER_NAME));
            $result = $db->fetch_obj();
            if($USER_PASS !== $result->USER_PASS){
                $_SESSION['ERR_MSG'] = 'Incorrect username or password.';
                return false;
            }
            foreach($result AS $key=>$value){
                if(property_exists($this,$key)){
                    $_SESSION[$key] = $value;
                }
            }
            $this->__construct();
            $db->query("UPDATE USER_ACCOUNTS SET USER_LOGIN = NOW()+0 WHERE USER_NAME = ?",array($this->USER_NAME));
            return true;
        }
        
        public static function redirect($message = NULL,$location = '../'){
            if($message !== NULL){
                $_SESSION['messages'][] = $message;
            }
            header('Location: '.$location);
        }
        
        public static function database(){
            require_once('Zebra_Database\Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = false;
            /*$this->connection->memcache_host = 'localhost';
            $this->connection->memcache_port = 11211;
            $this->connection->memcache_compressed = false;
            $this->connection->memcache_method = 'memcache';*/
            $hostname = 'localhost';
            $username = 'root';
            $userpass = '';
            $database = 'alpha';
            $connection->connect($hostname,$username,$userpass,$database);
            $connection->set_charset();
            return $connection;
        }
        
        public static function isSignedIn(){
            if(isset($_SESSION['USER_NAME'])){
                return true;
            }
            return false;
        }
        
        public static function signOut(){
            session_destroy();
            session_start();
            $_SESSION['ERR_MSG'] = "Signed out successfully.";
        }
        
        public static function getErrMsg(){
            if(isset($_SESSION['ERR_MSG'])){
                echo '<div class="alert alert-danger" style="margin-bottom:0px;">'.$_SESSION['ERR_MSG'].'</div>';
                unset($_SESSION['ERR_MSG']);
            }
        }
        
        public static function getUserTypes(){
            $DB = self::database();
            $DB->query("SELECT * FROM USER_TYPES ORDER BY ID ASC");
            return $DB->fetch_assoc_all();
        }
        
        public static function getAllClass(){
            $DB = self::database();
            $DB->query("SELECT * FROM CLASSES ORDER BY ID ASC");
            return $DB->fetch_assoc_all();
        }
        
        public static function userNameValid($USER_NAME){
            $_SESSION['ERR_MSG'] = 'Invalid username: ';
            if(strlen(trim($USER_NAME)) === 0 || strlen(trim($USER_NAME)) < 6){
                $_SESSION['ERR_MSG'] .= 'Username must be at least six characters long.';
                return true;
            }
            if(preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $USER_NAME)){
                $_SESSION['ERR_MSG'] .= 'Username cannot contain special characters other than underscores.';
                return true;
            }
            if(count(explode(' ',$USER_NAME)) !== 1){
                $_SESSION['ERR_MSG'] .= 'Username cannot contain spaces.';
                return true;
            }
            unset($_SESSION['ERR_MSG']);
            return false;
        }
        
        public static function userPassValid($USER_PASS){
            if(strlen(trim($USER_PASS)) === 0 || strlen(trim($USER_PASS)) < 6){
                $_SESSION['ERR_MSG'] .= 'Password must be at least six characters long.';
                return true;
            }
            if(count(explode(' ',$USER_PASS)) !== 1){
                $_SESSION['ERR_MSG'] .= 'Password cannot contain spaces.';
                return true;
            }
            return false;
        }
        
        public static function userNameExists($USER_NAME){
            $DB = portal::database();
            $DB->query("SELECT USER_NAME FROM USER_ACCOUNTS WHERE USER_NAME = ?",array($USER_NAME));
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
    }
