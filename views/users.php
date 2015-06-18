<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'User Account Control';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New User'=>'new',
        'Edit User'=>'edit',
        'Delete Users'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New User',
        'Edit User'
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