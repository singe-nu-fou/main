<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'Recently Worked' => array(
            'subnav' => 'recently_worked',
            'params' => '&orderBy=&order=ASC'
        ),
        'Submit Inventory' => array(
            'subnav' => 'inventory_entry',
            'params' => ''
        ),
        'Inventory Review' => array(
            'subnav' => 'inventory_review',
            'params' => '&orderBy=SKU&order=ASC'
        )
    );