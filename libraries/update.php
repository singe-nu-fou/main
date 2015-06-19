<?php
    session_start();
    require_once('../classes/portal.php');
    
    if(portal::isSignedIn() && isset($_GET['page']) && isset($_GET['action'])){
        $ORIGIN = $_SERVER['HTTP_REFERER'];
        $ORIGIN = explode('?',$ORIGIN);
        $ORIGIN = '?'.$ORIGIN[1];
        
        portal::warp($_GET['page'], $_GET['action']);
        portal::redirect('../'.$ORIGIN);
    }
    else{
        portal::redirect();
    }