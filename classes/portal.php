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
            $db->query("SELECT USER_NAME,USER_PASS,USER_TYPE,USER_LOGIN FROM USER_ACCOUNTS JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID WHERE USER_NAME = ?",array($USER_NAME));
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
        
        public static function getUserTypes(){
            $DB = self::database();
            $DB->query("SELECT * FROM USER_TYPES ORDER BY ID ASC");
            return $DB->fetch_assoc_all();
        }
        
        public static function getAllClass(){
            $DB = self::database();
            $DB->query("SELECT * FROM CLASS ORDER BY ID ASC");
            return $DB->fetch_assoc_all();
        }
    }