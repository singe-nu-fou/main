<?php
    require_once('../classes/portal.php');
    $ORIGIN = $_SERVER['HTTP_REFERER'];
    $ORIGIN = explode('?',$ORIGIN);
    $ORIGIN = '?'.$ORIGIN[1];
    $USER = array(
        'USER_NAME'=>NULL,
        'USER_PASS'=>NULL,
        'USER_TYPE_ID'=>NULL
    );
    foreach($_POST AS $KEY=>$VALUE){
        if($key === 'USER_NAME' && (strlen(trim($VALUE)) === 0 || strlen(trim($VALUE)) < 6)){
            $_SESSION['ERR_MSG'] = 'Invalid username length. Required length is at least six characters';
        }
        $USER[$KEY] = $VALUE;
    }
    //header('Location: ../'.$ORIGIN);