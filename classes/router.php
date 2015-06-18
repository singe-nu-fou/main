<?php
    class router{
        public static function route($ZONE,$ACTION){
            switch($ZONE){
                case 'users':
                    return self::users($ACTION);
                case 'userTypes':
                    return self::userTypes($ACTION);
                case 'classes':
                    return self::classes($ACTION);
                case 'types':
                    return self::types($ACTION);
                case 'attributes':
                    return self::attributes($ACTION);
                case 'template':
                    return self::templates($ACTION);
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
                case 'new':
                    return users::insertUser($_POST);
                case 'edit':
                    var_dump($_POST);
                    return users::updateUser($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return users::deleteUser(json_decode($_GET['names']));
                    }
                    break;
            }
        }
        
        private static function userTypes($ACTION){
            require_once('userTypes.php');
            switch($ACTION){
                case 'TBODY':
                    return userTypes::getTBODY();
                case 'New User Type':
                    return userTypes::newUserType();
                case 'Edit User Type':
                    return userTypes::editUserType();
                case 'new':
                    return userTypes::insertUserType($_POST);
                case 'edit':
                    return userTypes::updateUserType($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return userTypes::deleteUserType(json_decode($_GET['names']));
                    }
                    break;
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
                case 'new':;
                    return classes::insertClass($_POST);
                case 'edit':
                    return classes::updateClass($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return classes::deleteClass(json_decode($_GET['names']));
                    }
                    break;
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
                case 'new':
                    return types::insertType($_POST);
                case 'edit':
                    return types::updateType($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return types::deleteType(json_decode($_GET['names']));
                    }
                    break;
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
                case 'new':
                    return attributes::insertAttribute($_POST);
                case 'edit':
                    return attributes::updateAttribute($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return attributes::deleteAttribute(json_decode($_GET['names']));
                    }
                    break;
            }
        }
        
        private static function templates($ACTION){
            require_once('template.php');
            switch($ACTION){
                case 'TBODY':
                    return template::getTBODY();
                case 'New Template':
                    return template::newTemplate();
                case 'Edit Template':
                    return template::editTemplate();
                case 'new':
                    return template::insertTemplate($_POST);
                case 'edit':
                    return template::updateTemplate($_GET['names'],$_POST);
                case 'delete':
                    if(isset($_GET['names'])){
                        return template::deleteTemplate(json_decode($_GET['names']));
                    }
                    break;
            }
        }
    }