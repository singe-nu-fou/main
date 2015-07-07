<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
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