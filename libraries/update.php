<?php
    session_start();
    require_once('../classes/portal.php');
    require_once('../classes/router.php');
    
    if(portal::isSignedIn()){
        $ORIGIN = $_SERVER['HTTP_REFERER'];
        $ORIGIN = explode('?',$ORIGIN);
        $ORIGIN = '?'.$ORIGIN[1];
        
        router::route($_GET['page'], $_GET['action']);
    }

    header('Location: ../'.$ORIGIN);