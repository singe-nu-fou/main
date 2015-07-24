<?php
    /* =======================================================================
     * (C) 2015 Stephen Palmer
     * All Rights Reserved
     * File: portal.php
     * Description: Portal master class file. Library of commonly used functions
     *              as well as functions built to access class, model, and view
     *              files within the scope of the app using Portal.
     * Author: Stephen Palmer <stephen.palmerjr@outlook.com>
     * PHP Version: 5.4
     * ======================================================================= */

    //sets timezone to central standard
    date_default_timezone_set('America/Chicago');
    
    /*
     * Define the constant CLIENT for encapsulating session data, and allows for 
     * hosting multiple apps using this framework on the same server.
     */
    define('CLIENT','NEBULA');

    class portal{
        /*
         * Core function of the portal class file. Accepts pointer information 
         * to dynamically call any class function from anywhere in the scope of 
         * portal.
         */
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
        
        /*
         * Autoloader function for basic navigation in the app. Built for both 
         * local and server use. Determines the existence of model and view 
         * files and loads them accordingly.
         */
        public static function navigate($NAV){
            if(file_exists('C:\\wamp\www\main\nebula\models\\'.$NAV.'\\'.$NAV.'.php') && $NAV !== 'admin' && $NAV !== 'main'){
                require_once('/models/'.$NAV.'/'.$NAV.'.php');
            }
            elseif(self::scrubString('/classes','',__DIR__.'/models/'.$NAV.'/'.$NAV.'.php') && $NAV !== 'admin' && $NAV !== 'main'){
                require_once(self::scrubString('/classes','',__DIR__.'/models/'.$NAV.'/'.$NAV.'.php'));
            }
            if(file_exists('C:\\wamp\www\main\nebula\views\\'.$NAV.'\\'.$NAV.'.php')){
                require_once('/views/'.$NAV.'/'.$NAV.'.php');
            }
            elseif(file_exists(self::scrubString('/classes','',__DIR__.'/views/'.$NAV.'/'.$NAV.'.php'))){
                require_once(self::scrubString('/classes','',__DIR__.'/views/'.$NAV.'/'.$NAV.'.php'));
            }
        }
        
        /*
         * Basic database connection function. Set up so that anywhere in the
         * scope of portal can call this to open a connection to the database.
         */
        public static function database(){
            require_once(__DIR__.'/Zebra_Database/Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = true;
            $connection->connect('localhost','spalmer','Spalm04350','alpha');
            //$connection->connect('localhost','root','','alpha');
            $connection->set_charset();
            return $connection;
        }
        
        /*
         * Basic handler for authenticating users. Ties into portal's warp
         * function to access the user class to validate entered user info
         * and uses portal's redirect to navigate the user after validation.
         */
        public static function signIn($DATA){
            if(self::isSignedIn()){
                self::redirect('../?nav=main');
            }
            if(is_array($DATA['POST'])){
                extract($DATA['POST']);
            }
            else{
                $_SESSION[CLIENT]['ERROR_MSG'] = 'Incorrect username or password.';
                self::redirect('../');
            }
            $DB = self::database();
            if(self::warp('user','userNameExists',array('USER_NAME'=>$USER_NAME)) && self::warp('user','validUsername',$USER_NAME) && self::warp('user','validPassword',$USER_PASSWORD)){
                $DB->query("SELECT user_account.ID,USER_NAME,USER_PASSWORD,USER_TYPE,LAST_LOGIN 
                            FROM user_account 
                            LEFT JOIN user_type ON USER_TYPE_ID = user_type.ID 
                            LEFT JOIN user_name ON USER_NAME_ID = user_name.ID 
                            WHERE USER_NAME = ?",array($USER_NAME));
                $RESULT = $DB->fetch_obj();
                if(MD5($USER_PASSWORD) !== $RESULT->USER_PASSWORD){
                    $_SESSION[CLIENT]['ERROR_MSG'] = 'Incorrect username or password.';
                    self::redirect('../');
                }
                foreach($RESULT AS $KEY=>$VALUE){
                    if($KEY !== 'USER_PASSWORD'){
                        $_SESSION[CLIENT][$KEY] = $VALUE;
                    }
                }
                $DB->query("UPDATE user_account LEFT JOIN user_name ON USER_NAME_ID = user_name.ID SET LAST_LOGIN = NOW()+0 WHERE USER_NAME = ?",array($_SESSION[CLIENT]['USER_NAME']));
                unset($_SESSION[CLIENT]['ERROR_MSG']);
                self::redirect('../?nav=main');
                return;
            }
            $_SESSION[CLIENT]['ERROR_MSG'] = 'Incorrect username or password.';
            self::redirect('../');
        }
        
        /*
         * Basic session destruction and appends a message to ERROR_MSG to be
         * displayed identifying you have signed out.
         */
        public static function signOut(){
            session_destroy();
            session_start();
            $_SESSION[CLIENT]['ERROR_MSG'] = "Signed out successfully.";
            self::redirect('../');
        }
        
        /*
         * Bool function to determine if use is currently signed in, and said
         * user actually exists.
         */
        public static function isSignedIn(){
            if(isset($_SESSION[CLIENT]['USER_NAME']) && self::warp('user','userNameExists',array('USER_NAME'=>$_SESSION[CLIENT]['USER_NAME']))){
                return true;
            }
            return false;
        }
        
        /*
         * Personal use substr function that allows me to either do a basic
         * substr, or a substr of multiple values at the same time by passing
         * an array.
         */
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
        
        /*
         * Core function used to display session ERROR_MSG or MSG session
         * variables. Currently only used for ERROR_MSG, but is still ready to
         * display regular MSG.
         */
        public static function getMsg(){
            if(isset($_SESSION[CLIENT]['ERROR_MSG'])){
                echo '<div class="alert alert-danger">'.$_SESSION[CLIENT]['ERROR_MSG'].'</div>';
                unset($_SESSION[CLIENT]['ERROR_MSG']);
            }
            if(isset($_SESSION[CLIENT]['MSG'])){
                echo '<div class="alert alert-success">'.$_SESSION[CLIENT]['MSG'].'</div>';
                unset($_SESSION[CLIENT]['MSG']);
            }
        }
        
        /*
         * Simple redirect function that modifies the header information based
         * on passed information, default navigates to index.
         */
        public static function redirect($location = '../'){
            header('Location: '.$location);
        }
    }
