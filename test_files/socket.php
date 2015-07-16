<?php
    date_default_timezone_set('America/Chicago');
    $ACTIONS = array();
    $i = 0;
    $timeA = time();
    while(true){
        $timeB = time();
        $time_difference = round(abs($timeB - $timeA) / 60,2);
        if($time_difference > 1){
            echo date('D, M dS g:iA').'/n';
            $timeA = time();
        }
        if(isset($ACTIONS[$i])){
            $ACTIONS[$i];
            switch($ACTIONS[$i]){
                case 'status';
                    echo 'running';
                    unset($ACTIONS[$i]);
                    break;
            }
            unset($ACTION);
        }
        else{
            //break;
            $i = 0;
        }
        $i++;
    }
    echo 'stopped';