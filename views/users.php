<?php
    require_once('classes/table.php');
    $HEADER = 'User Account Control';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New User'=>'new_user',
        'Edit Users'=>'reset_password',
        'Delete Users'=>'delete_user'
    );
    $SPECIAL_CONTROL = array(
        array('New User'),
        array('Edit Users')
    );
    $THEAD = array(
        'ID'=>'ID',
        'User'=>'USER_NAME',
        'Type'=>'USER_TYPE',
        'Last Login'=>'USER_LOGIN'
    );
    $TBODY = 'USERS';
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();