<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST_ITEMS = array(
        'Categories' => array(
            'subnav' => 'category',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'category') ? 'active ' : ''
        ),
        'Classifications' => array(
            'subnav' => 'classification',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'classification') ? 'active ' : ''
        ),
        'Characteristics' => array(
            'subnav' => 'characteristic',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'characteristic') ? 'active ' : ''
        ),
        'Inventory Mapping' => array(
            'subnav' => 'mapping',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'mapping') ? 'active ' : ''
        ),
        'User Account Control' => array(
            'subnav' => 'user',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'user') ? 'active ' : ''
        ),
        'User Types' => array(
            'subnav' => 'user_type',
            'params' => '&orderBy=ID&order=ASC',
            'selected' => ($SUBNAV === 'user_type') ? 'active ' : ''
        )
    );
    foreach($LIST_ITEMS AS $KEY=>$VALUE){
        $LIST[] = '<li><a class="'.$VALUE['selected'].'list-group-item" href="?nav=admin&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
    }
    $LIST = implode('',$LIST);