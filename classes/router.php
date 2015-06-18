<?php
    class router{
        public static function route($NAV,$ACTION){
            require_once($NAV.'.php');
            
            $DATA = array(
                'POST' => $_POST,
                'GET' => (isset($_GET['names'])) ? ((portal::isJson($_GET['names'])) ? json_decode($_GET['names']) : $_GET['names']) : NULL
            );
            
            return $NAV::$ACTION($DATA);
        }
    }