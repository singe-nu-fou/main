<?php
    $URL = '?'.$_SERVER['QUERY_STRING'];
    if(isset($_GET['id'])){
        $TEMP = explode('&id',$URL);
        $URL = $TEMP[0];
    }
    $ACTION = array(
        'create'=>'&action=create',
        'edit'=>'&action=edit'
    );
    $TITLE = 'Recently Listed';
    $CONTROL_PANEL = array();
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'create':
                unset($CONTROL_PANEL['New User']);
                break;
            case 'edit':
                unset($CONTROL_PANEL['Edit User']);
                break;
        }
    }
    $THEAD = array(
        'SKU'=>'SKU',
        'Category'=>'CATEGORY',
        'Classification'=>'CLASSIFICATION',
        'Weight'=>'WEIGHT',
        'Worked By'=>'USER_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,NULL,$THEAD,'selectable');