<?php
    require_once('classes/table.php');
    $URL = '?'.$_SERVER['QUERY_STRING'];
    $ACTION = array(
        'create'=>'&action=create',
        'edit'=>'&action=edit'
    );
    $TITLE = 'User Account Control';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'New User'=>array(
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=create')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['create'])
        ),
        'Edit User'=>array(
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=edit')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['edit'])
        ),
        'Delete Users'=>array(
            'href'=>'#'
        )
    );
    $THEAD = array(
        'ID'=>'ID',
        'User'=>'USER_NAME',
        'Type'=>'USER_TYPE_ID',
        'Last Login'=>'LAST_LOGIN',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,((isset($_GET['action'])) ? $_GET['action'] : NULL),$THEAD,'selectable');
    echo $TABLE->getTable();