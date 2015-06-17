<?php
    session_start();
    require_once('../classes/portal.php');
    
    if(portal::isSignedIn()){
        require_once('../classes/update.php');

        $ORIGIN = $_SERVER['HTTP_REFERER'];
        $ORIGIN = explode('?',$ORIGIN);
        $ORIGIN = '?'.$ORIGIN[1];

        switch($_GET['action']){
            case 'newUser':
                update::newUser($_POST);
                break;
            case 'editUser':
                update::editUser($_GET['users'],$_POST);
                break;
            case 'deleteUsers':
                if(isset($_GET['users'])){
                    update::deleteUser(json_decode($_GET['users']));
                }
                break;
        }
    }

    header('Location: ../'.$ORIGIN);