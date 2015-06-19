<?php
    class userType{
        public static function getUserType($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM USER_TYPE";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ? AND USER_TYPE = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE USER_TYPE = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealUserType($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM USER_TYPE WHERE ID = ? AND USER_TYPE = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM USER_TYPE WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM USER_TYPE WHERE USER_TYPE = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            
        }
        
        public static function update($DATA){
            
        }
        
        public static function delete($DATA){
            
        }
    }