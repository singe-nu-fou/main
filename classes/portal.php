<?php
    class portal{
        public static function warp($ZONE,$ACTION){
            $DATA = array(
                'POST' => $_POST,
                'GET' => (isset($_GET['names'])) ? ((portal::isJson($_GET['names'])) ? json_decode($_GET['names']) : $_GET['names']) : NULL
            );
            if($ZONE !== 'portal'){
                require_once($ZONE.'.php');
                return $ZONE::$ACTION($DATA);
            }
            return self::$ACTION($DATA);
        }
        
        public static function database(){
            require_once('Zebra_Database\Zebra_Database.php');
            $connection = new Zebra_Database();
            $connection->debug = false;
            $connection->connect('localhost','root','','alpha');
            $connection->set_charset();
            return $connection;
        }
        
        public static function signIn($DATA){
            $DB = self::database();
            var_dump($DATA);
            //exit;
            if(portal::validUsername($DATA['POST']['USER_NAME']) && portal::validPassword($DATA['POST']['USER_PASSWORD'])){
                $DB->query("SELECT USER_ACCOUNT.ID,USER_NAME,USER_PASSWORD,USER_TYPE,LAST_LOGIN 
                            FROM USER_ACCOUNT 
                            LEFT JOIN USER_TYPE ON USER_TYPE_ID = USER_TYPE.ID 
                            LEFT JOIN USER_NAME ON USER_TYPE_ID = USER_NAME.ID 
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
        
        public static function validUsername($USER_NAME){
            $_SESSION['ERROR_MSG'] = 'Invalid username: ';
            switch(true){
                case strlen(trim($USER_NAME)) === 0:
                case strlen(trim($USER_NAME)) < 6:
                case count(explode(' ',$USER_NAME)) !== 1:
                    $_SESSION['ERROR_MSG'] .= "Username must be at least six characters long, cannot contain special character or underscores, and cannot contain spaces.";
                    return false;
            }
            unset($_SESSION['ERROR_MSG']);
            return true;
        }
        
        public static function validPassword($USER_PASS){
            $_SESSION['ERROR_MSG'] = "Invalid password: ";
            switch(true){
                case strlen(trim($USER_PASS)) === 0:
                case strlen(trim($USER_PASS)) < 6:
                case count(explode(' ',$USER_PASS)) !== 1:
                    $_SESSION['ERROR_MSG'] .= 'Passwords must be at least six characters long and contain no spaces!';
                    return false;
            }
            unset($_SESSION['ERROR_MSG']);
            return true;
        }
        
        public static function isSignedIn(){
            if(isset($_SESSION['USER_NAME']) && self::userNameExists($_SESSION['ID'],$_SESSION['USER_NAME'])){
                return true;
            }
            return false;
        }
        
        public static function userNameExists($ID,$USER_NAME){
            $DB = portal::database();
            $DB->query("SELECT * FROM USER_ACCOUNT LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID WHERE USER_ACCOUNT.ID = ? AND USER_NAME = ?",array($ID,$USER_NAME));
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
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
