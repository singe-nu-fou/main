<?php
    require_once('classes/table.php');
    $URL = '?'.$_SERVER['QUERY_STRING'];
    if(isset($_GET['id'])){
        $TEMP = explode('&id',$URL);
        $URL = $TEMP[0];
    }
    $ACTION = array(
        'create'=>'&action=create',
        'view'=>'&action=view'
    );
    $TITLE = 'Map Classification, Type, Attribute';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'New Mapping'=>array(
            'id'=>'create',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=create')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['create'])
        ),
        'View Mapping'=>array(
            'id'=>'view',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=view')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['view'])
        ),
        'Delete Mapping'=>array(
            'id'=>'delete'
        )
    );
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'create':
                unset($CONTROL_PANEL['New Mapping']);
                break;
            case 'view':
                unset($CONTROL_PANEL['View Mapping']);
                break;
        }
    }
    $THEAD = array(
        'ID'=>'ID',
        'Classification'=>'CLASS_NAME',
        'Type'=>'TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,((isset($_GET['action'])) ? $_GET['action'] : NULL),$THEAD,'selectable');
    echo $TABLE->getTable();