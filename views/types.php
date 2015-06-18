<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'Types';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New Type'=>'new',
        'Edit Type'=>'edit',
        'Delete Type'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New Type',
        'Edit Type'
    );
    $THEAD = array(
        'ID'=>'ID',
        'Type'=>'TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();