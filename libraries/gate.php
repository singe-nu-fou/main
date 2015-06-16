<?php
    session_start();
    require_once('../classes/portal.php');
    $portal = new portal;
    switch($_GET['portal']){
        case 'open':
            $portal->signIn($_POST['USER_NAME'],MD5($_POST['USER_PASS']));
            portal::redirect(NULL,'../?nav=home');
            break;
        case 'close':
            portal::signOut();
            portal::redirect();
            break;
        default:
            portal::redirect(NULL,(portal::isSignedIn()) ? '../?nav=home' : '../');
            break;
    }