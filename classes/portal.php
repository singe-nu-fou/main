<?php
    date_default_timezone_set('America/Chicago');

    class portal{
        public static function warp($ZONE,$ACTION,$DATA = NULL){
            $DATA = ($DATA === NULL) ? array(
                'POST' => $_POST,
                'GET' => $_GET
            ) : $DATA;
            if($ZONE !== 'portal'){
                require_once($ZONE.'.php');
                return $ZONE::$ACTION($DATA);
            }
            return self::$ACTION($DATA);
        }
        
        public static function navigate($NAV){
            $URL = 'views/'.$NAV.'.php';
            include($URL);
        }
        
        public static function database(){
            require_once('Zebra_Database\Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = true;
            $connection->connect('localhost','root','','alpha');
            $connection->set_charset();
            return $connection;
        }
        
        public static function databaseOld(){
            require_once('Zebra_Database\Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = true;
            $connection->connect('localhost','root','','lister');
            $connection->set_charset();
            return $connection;
        }
        
        public static function signIn($DATA){
            if(self::isSignedIn()){
                return '../?nav=home';
            }
            require_once('users.php');
            if(is_array($DATA['POST'])){
                extract($DATA['POST']);
            }
            else{
                $_SESSION['ERROR_MSG'] = 'Incorrect username or password.';
                return '../';
            }
            $DB = self::database();
            if(users::userNameExists(array('USER_NAME'=>$USER_NAME)) && users::validUsername($USER_NAME) && users::validPassword($USER_PASSWORD)){
                $DB->query("SELECT USER_ACCOUNT.ID,USER_NAME,USER_PASSWORD,USER_TYPE,LAST_LOGIN 
                            FROM USER_ACCOUNT 
                            LEFT JOIN USER_TYPE ON USER_TYPE_ID = USER_TYPE.ID 
                            LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID 
                            WHERE USER_NAME = ?",array($DATA['POST']['USER_NAME']));
                $RESULT = $DB->fetch_obj();
                if(MD5($DATA['POST']['USER_PASSWORD']) !== $RESULT->USER_PASSWORD){
                    $_SESSION['ERROR_MSG'] = 'Incorrect username or password.';
                    return false;
                }
                foreach($RESULT AS $KEY=>$VALUE){
                    if($KEY !== 'USER_PASSWORD'){
                        $_SESSION[$KEY] = $VALUE;
                    }
                }
                $DB->query("UPDATE USER_ACCOUNT LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID SET LAST_LOGIN = NOW()+0 WHERE USER_NAME = ?",array($_SESSION['USER_NAME']));
                return '../?nav=home';
            }
            $_SESSION['ERROR_MSG'] = 'Incorrect username or password.';
            return '../';
        }
        
        public static function signOut(){
            session_destroy();
            session_start();
            $_SESSION['ERROR_MSG'] = "Signed out successfully.";
            return '../';
        }
        
        public static function isSignedIn(){
            require_once('users.php');
            if(isset($_SESSION['USER_NAME']) && users::userNameExists(array('USER_NAME'=>$_SESSION['USER_NAME']))){
                return true;
            }
            return false;
        }
        
        public static function scrubString($NEEDLE,$REPLACE,$HAYSTACK){
            if(is_array($NEEDLE)){
                $NEEDLES = $NEEDLE;
                unset($NEEDLE);
                foreach($NEEDLES AS $THREAD=>$NEEDLE){
                    $HAYSTACK = str_replace($NEEDLE,$REPLACE,$HAYSTACK);
                }
                return $HAYSTACK;
            }
            return str_replace($NEEDLE,$REPLACE,$HAYSTACK);
        }
        
        public static function getMsg(){
            if(isset($_SESSION['ERROR_MSG'])){
                echo '<div class="alert alert-danger">'.$_SESSION['ERROR_MSG'].'</div>';
                unset($_SESSION['ERROR_MSG']);
            }
            if(isset($_SESSION['MSG'])){
                echo '<div class="alert alert-success">'.$_SESSION['MSG'].'</div>';
                unset($_SESSION['MSG']);
            }
        }
        
        public static function redirect($location = '../'){
            header('Location: '.$location);
        }
    }
