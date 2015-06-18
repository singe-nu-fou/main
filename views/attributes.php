<?php
    require_once('classes/router.php');
    require_once('classes/table.php');
    $HEADER = 'Attributes';
    $ADVANCED_CONTROL = array(
        'Select All'=>'select_all',
        'Deselect All'=>'deselect_all',
        'New Attribute'=>'new',
        'Edit Attribute'=>'edit',
        'Delete Attribute'=>'delete'
    );
    $SPECIAL_CONTROL = array(
        'New Attribute',
        'Edit Attribute'
    );
    $THEAD = array(
        'ID'=>'ID',
        'Attribute'=>'ATTRIBUTE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,'selectable');
    echo $TABLE->getTable();