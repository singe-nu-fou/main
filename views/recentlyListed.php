<?php
    require_once('classes/table.php');
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
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'Bulk Edit'=>array(
            'id'=>'create'
        ),
        'Redo'=>array(
            'id'=>'edit'
        ),
        'Delete'=>array(
            'id'=>'delete'
        )
    );
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
        'ID'=>'ID',
        'SKU'=>'USER_NAME',
        'Title'=>'USER_TYPE',
        'Weight'=>'USER_EMAIL',
        'Class'=>'CLASS_ID',
        'Type'=>'TYPE_ID',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,'resultControl',$THEAD,'selectable');
    echo $TABLE->getTable();