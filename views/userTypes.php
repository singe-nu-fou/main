<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'User Types';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New User Type'=>'new',
        'Edit User Type'=>'edit',
        'Delete User Types'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New User Type',
        'Edit User Type'
    );
    $THEAD = array(
        'ID'=>'ID',
        'User Type'=>'USER_TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TBODY = 'USERS';
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();