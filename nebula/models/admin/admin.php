<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
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