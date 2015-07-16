<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'New Character' => array(
            'subnav' => 'new',
            'params' => '',
            'selected' => ($SUBNAV === 'new') ? 'active ' : ''
        )
    );