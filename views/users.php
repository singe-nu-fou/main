<?php
    require_once('classes/table.php');
    $TITLE = 'User Account Control';
    $CONTROL_PANEL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New User'=>'create',
        'Edit User'=>'edit',
        'Delete Users'=>'delete'
    );
    $THEAD = array(
        'ID'=>'ID',
        'User'=>'USER_NAME',
        'Type'=>'USER_TYPE_ID',
        'Last Login'=>'USER_LOGIN',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,$THEAD,'selectable');
    echo $TABLE->getTable();