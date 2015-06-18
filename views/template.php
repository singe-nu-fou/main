<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'Template Constructor';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New Template'=>'newTemplate',
        'Edit Template'=>'editTemplate',
        'Delete Template'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New Template',
        'Edit Template'
    );
    $THEAD = array(
        'ID'=>'ID',
        'Classification'=>'CLASS_NAME',
        'Type'=>'TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TBODY = 'USERS';
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();