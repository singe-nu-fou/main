<?php
    class update{
        public static function newUser($DATA){
            $USER = array(
                'USER_NAME'=>NULL,
                'USER_PASS'=>NULL,
                'USER_TYPE_ID'=>NULL
            );
            foreach($DATA AS $KEY=>$VALUE){
                $USER[$KEY] = $VALUE;
            }
            switch(true){
                case portal::userNameValid($USER['USER_NAME']):
                    break;
                case portal::userPassValid($USER['USER_PASS']);
                    break;
                case portal::userNameExists($USER['USER_NAME']):
                    $_SESSION['ERR_MSG'] = "Invalid username: This username already exists.";
                    break;
                default:
                    $DB = portal::database();
                    $DB->query("INSERT INTO USER_ACCOUNTS (USER_TYPE_ID,USER_NAME,USER_PASS) VALUES (?,?,?)",array($USER['USER_TYPE_ID'],$USER['USER_NAME'],MD5($USER['USER_PASS'])));
                    break;
            }
        }
        
        public static function editUser($USER,$DATA){
            switch(true){
                case $DATA['USER_PASS'] !== $DATA['CONF_USER_PASS']:
                    $_SESSION['ERR_MSG'] = 'Please ensure the new password and the confirmation password match!';
                    break;
                default:
                    $DB = portal::database();
                    $SQL = "UPDATE USER_ACCOUNTS SET USER_TYPE_ID = ".$DATA['USER_TYPE_ID'].", USER_PASS = '".MD5($DATA['USER_PASS'])."' WHERE USER_NAME = '".$USER."'";
                    $DB->query($SQL);
                    break;
            }
        }
        
        public static function deleteUser($USERS){
            $DB = portal::database();
            $SQL = "DELETE FROM USER_ACCOUNTS WHERE ";
            foreach($USERS AS $KEY=>$VALUE){
                $SQL .= "USER_NAME = '".$VALUE."' ".((count($USERS) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }