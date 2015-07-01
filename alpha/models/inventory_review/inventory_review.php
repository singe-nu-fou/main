<?php
    $FILTERS = (isset($_GET['filters'])) ? json_decode($_GET['filters']) : NULL;
    $CATEGORIES = portal::warp('category','getCategory');
    $CATEGORY_OPTIONS = array(
        '<option></option>'
    );
    foreach($CATEGORIES AS $KEY=>$VALUE){
        extract($VALUE);
        $CATEGORY_OPTIONS[] = '<option value="'.$ID.'">'.$CATEGORY.'</option>';
    }
    $CATEGORY_OPTIONS = implode(',',$CATEGORY_OPTIONS);
    $CLASSIFICATIONS = portal::warp('classification','getClassification');
    $CLASSIFICATION_OPTIONS = array(
        '<option></option>'
    );
    foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
        extract($VALUE);
        $CLASSIFICATION_OPTIONS[] = '<option value="'.$ID.'">'.$CLASSIFICATION.'</option>';
    }
    $CLASSIFICATION_OPTIONS = implode(',',$CLASSIFICATION_OPTIONS);
    $CONDITIONS = array(
        'New',
        'Pre-Owned',
        'Damaged'
    );
    $CONDITION_OPTIONS = array(
        '<option></option>'
    );
    foreach($CONDITIONS AS $VALUE){
        $CONDITION_OPTIONS[] = '<option value="'.$VALUE.'">'.$VALUE.'</option>';
    }
    $CONDITION_OPTIONS = implode(',',$CONDITION_OPTIONS);
    $URL = '?'.$_SERVER['QUERY_STRING'];
    if(isset($_GET['id'])){
        $TEMP = explode('&id',$URL);
        $URL = $TEMP[0];
    }
    $ACTION = array(
        'edit'=>'&action=edit'
    );
    $TITLE = 'Review Inventory Items';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'Edit Item'=>array(
            'id'=>'edit',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=edit')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['edit'])
        ),
        'Delete Item'=>array(
            'id'=>'delete'
        )
    );
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'edit':
                unset($CONTROL_PANEL['Edit Item']);
                break;
        }
    }
    $THEAD = array(
        'SKU'=>'SKU',
        'Category'=>'CATEGORY',
        'Classification'=>'CLASSIFICATION',
        'Weight'=>'WEIGHT',
        'Worked By'=>'USER_NAME',
        'Date Created'=>'DATE_CREATED',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $MODE = array(
        'filters',
        ((isset($_GET['action'])) ? $_GET['action'] : NULL)
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,$MODE,$THEAD,'selectable');