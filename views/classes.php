<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'Classifications';
    $ADVANCED_CONTROL = array(
        'New Class'=>'new_user',
        'Edit Class'=>'edit_user',
        'Delete Class'=>'delete_users'
    );
    $SPECIAL_CONTROL = array(
        'New Class',
        'Edit Class'
    );
    $THEAD = array(
        'ID'=>'ID',
        'Class'=>'CLASS_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();