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
    $TITLE = 'Templates';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'New Template'=>array(
            'id'=>'create',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=create')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['create'])
        ),
        'View Template'=>array(
            'id'=>'view',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=view')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['view'])
        ),
        'Delete Templates'=>array(
            'id'=>'delete'
        )
    );
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'create':
                unset($CONTROL_PANEL['New Template']);
                break;
            case 'view':
                unset($CONTROL_PANEL['View Template']);
                break;
        }
    }
    $THEAD = array(
        'ID'=>'ID',
        'Template'=>'TEMPLATE_NAME',
        'Classification'=>'CLASS_NAME',
        'Type'=>'TYPE_NAME',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,((isset($_GET['action'])) ? $_GET['action'] : NULL),$THEAD,'selectable');
    echo $TABLE->getTable();