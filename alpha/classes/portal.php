<?php
    date_default_timezone_set('America/Chicago');

    class portal{
        public static function warp($ZONE,$ACTION,$DATA = NULL){
            $DATA = ($DATA === NULL) ? array(
                'POST' => $_POST,
                'GET' => $_GET
            ) : $DATA;
            if($ZONE !== 'portal'){
                require_once(__DIR__.'/'.$ZONE.'/'.$ZONE.'.php');
                return $ZONE::$ACTION($DATA);
            }
            return self::$ACTION($DATA);
        }
        
        public static function navigate($NAV){
            if(file_exists('C:\\wamp\www\main\alpha\models\\'.$NAV.'\\'.$NAV.'.php') && $NAV !== 'admin' && $NAV !== 'inventory'){
                require_once('/models/'.$NAV.'/'.$NAV.'.php');
            }
            elseif(self::scrubString('/classes','',__DIR__.'/models/'.$NAV.'/'.$NAV.'.php') && $NAV !== 'admin' && $NAV !== 'inventory'){
                require_once(self::scrubString('/classes','',__DIR__.'/models/'.$NAV.'/'.$NAV.'.php'));
            }
            if(file_exists('C:\\wamp\www\main\alpha\views\\'.$NAV.'\\'.$NAV.'.php')){
                require_once('/views/'.$NAV.'/'.$NAV.'.php');
            }
            elseif(file_exists(self::scrubString('/classes','',__DIR__.'/views/'.$NAV.'/'.$NAV.'.php'))){
                require_once(self::scrubString('/classes','',__DIR__.'/views/'.$NAV.'/'.$NAV.'.php'));
            }
        }
        
        public static function database(){
            require_once(__DIR__.'/Zebra_Database/Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = true;
            $connection->connect('localhost','spalmer','Spalm04350','alpha');
            //$connection->connect('localhost','root','','alpha');
            $connection->set_charset();
            return $connection;
        }
        
        public static function signIn($DATA){
            if(self::isSignedIn()){
                self::redirect('../?nav=inventory');
            }
            if(is_array($DATA['POST'])){
                extract($DATA['POST']);
            }
            else{
                $_SESSION['ERROR_MSG'] = 'Incorrect username or password.';
                    self::signOut();
            }
            $DB = self::database();
            if(self::warp('user','userNameExists',array('USER_NAME'=>$USER_NAME)) && self::warp('user','validUsername',$USER_NAME) && self::warp('user','validPassword',$USER_PASSWORD)){
                $DB->query("SELECT user_account.ID,USER_NAME,USER_PASSWORD,USER_TYPE,LAST_LOGIN 
                            FROM user_account 
                            LEFT JOIN user_type ON USER_TYPE_ID = user_type.ID 
                            LEFT JOIN user_name ON USER_NAME_ID = user_name.ID 
                            WHERE USER_NAME = ?",array($DATA['POST']['USER_NAME']));
                $RESULT = $DB->fetch_obj();
                if(MD5($DATA['POST']['USER_PASSWORD']) !== $RESULT->USER_PASSWORD){
                    $_SESSION['ERROR_MSG'] = 'Incorrect username or password.';
                    self::signOut();
                }
                foreach($RESULT AS $KEY=>$VALUE){
                    if($KEY !== 'USER_PASSWORD'){
                        $_SESSION[$KEY] = $VALUE;
                    }
                }
                $DB->query("UPDATE user_account LEFT JOIN user_name ON USER_NAME_ID = user_name.ID SET LAST_LOGIN = NOW()+0 WHERE USER_NAME = ?",array($_SESSION['USER_NAME']));
                unset($_SESSION['ERROR_MSG']);
                self::redirect('../?nav=inventory');
            }
        }
        
        public static function signOut(){
            session_destroy();
            session_start();
            $_SESSION['ERROR_MSG'] = "Signed out successfully.";
            self::redirect('../');
        }
        
        public static function isSignedIn(){
            if(isset($_SESSION['USER_NAME']) && self::warp('user','userNameExists',array('USER_NAME'=>$_SESSION['USER_NAME']))){
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
