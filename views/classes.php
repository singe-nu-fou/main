<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'Classifications';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New Class'=>'new',
        'Edit Class'=>'edit',
        'Delete Class'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New Class' => 'create',
        'Edit Class' => 'edit'
    );
    $THEAD = array(
        'ID'=>'ID',
        'Class'=>'CLASS_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();