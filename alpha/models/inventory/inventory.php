<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'Submit Inventory' => array(
            'subnav' => 'inventory_entry',
            'params' => ''
        ),
        'Inventory Review' => array(
            'subnav' => 'inventory_review',
            'params' => '&orderBy=SKU&order=ASC'
        )
    );