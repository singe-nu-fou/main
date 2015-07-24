<?php
    /* =======================================================================
     * (C) 2015 Stephen Palmer
     * All Rights Reserved
     * File: update.php
     * Description: Navigateable script that takes advantage of portal's warp
     *              function. This is primarily used for insert, update, delete
     *              functionalities of the site. Accepts get parameters for the
     *              page/class and the action/function. Warp picks up the slack
     *              from there.
     * Author: Stephen Palmer <stephen.palmerjr@outlook.com>
     * PHP Version: 5.4
     * ======================================================================= */

    session_start();
    require_once('../classes/portal.php');
    
    if(portal::isSignedIn() && isset($_GET['page']) && isset($_GET['action'])){
        $ORIGIN = $_SERVER['HTTP_REFERER'];
        $ORIGIN = explode('?',$ORIGIN);
        $ORIGIN = '?'.$ORIGIN[1];
        $ORIGIN = explode('&action',$ORIGIN);
        $ORIGIN = $ORIGIN[0];
        
        if(!isset($_POST['cancel'])){
            portal::warp($_GET['page'], $_GET['action']);
        }
        portal::redirect('../'.$ORIGIN);
    }
    else{
        portal::redirect();
    }