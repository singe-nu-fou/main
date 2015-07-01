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
    $TITLE = 'User Account Control';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'New User'=>array(
            'id'=>'create',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=create')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['create'])
        ),
        'Edit User'=>array(
            'id'=>'edit',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=edit')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['edit'])
        ),
        'Delete Users'=>array(
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
        'User'=>'USER_NAME',
        'Type'=>'USER_TYPE',
        'Email'=>'USER_EMAIL',
        'Last Login'=>'LAST_LOGIN',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,((isset($_GET['action'])) ? $_GET['action'] : NULL),$THEAD,'selectable');