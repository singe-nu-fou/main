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
    $TITLE = 'Types';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'New Type'=>array(
            'id'=>'create',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=create')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['create'])
        ),
        'Edit Type'=>array(
            'id'=>'edit',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=edit')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['edit'])
        ),
        'Delete Types'=>array(
            'id'=>'delete'
        )
    );
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'create':
                unset($CONTROL_PANEL['New Type']);
                break;
            case 'edit':
                unset($CONTROL_PANEL['Edit Type']);
                break;
        }
    }
    $THEAD = array(
        'ID'=>'ID',
        'Type'=>'TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,((isset($_GET['action'])) ? $_GET['action'] : NULL),$THEAD,'selectable');
    echo $TABLE->getTable();