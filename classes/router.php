<?php
    class router{
        public static function route($ZONE,$ACTION){
            switch($ZONE){
                case 'User Account Control':
                    return self::users($ACTION);
                case 'Classifications':
                    return self::classes($ACTION);
            }
        }
        
        private static function users($ACTION){
            require_once('users.php');
            switch($ACTION){
                case 'TBODY':
                    return users::getTBODY();
                case 'New User':
                    return users::newUser();
                case 'Edit User':
                    return users::editUser();
            }
        }
        
        private static function classes($ACTION){
            require_once('classes.php');
            switch($ACTION){
                case 'TBODY':
                    return classes::getTBODY();
                case 'New Class':
                    return classes::newClass();
                case 'Edit Class':
                    return classes::editClass();
            }
        }
    }