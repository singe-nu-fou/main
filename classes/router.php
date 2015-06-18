<?php
    class router{
        public static function route($ZONE,$ACTION){
            switch($ZONE){
                case 'User Account Control':
                    return self::users($ACTION);
                case 'Classifications':
                    return self::classes($ACTION);
                case 'Types':
                    return self::types($ACTION);
                case 'Attributes':
                    return self::attributes($ACTION);
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
        
        private static function types($ACTION){
            require_once('types.php');
            switch($ACTION){
                case 'TBODY':
                    return types::getTBODY();
                case 'New Type':
                    return types::newType();
                case 'Edit Type':
                    return types::editType();
            }
        }
        
        private static function attributes($ACTION){
            require_once('attributes.php');
            switch($ACTION){
                case 'TBODY':
                    return attributes::getTBODY();
                case 'New Attribute':
                    return attributes::newAttribute();
                case 'Edit Attribute':
                    return attributes::editAttribute();
            }
        }
    }