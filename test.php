<?php
    require_once('classes/portal.php');
    $DB = portal::database();
    $DB->query("SELECT 
                INVENTORY.ID,
                INVENTORY.CLASS_ID,
                CLASSES.CLASS_NAME,
                INVENTORY.TYPE_ID,
                TYPES.TYPE_NAME,
                INVENTORY_ATTRIBUTES.ATTRIBUTES,
                INVENTORY.WEIGHT
                FROM INVENTORY 
                LEFT JOIN CLASSES ON CLASSES.ID = CLASS_ID
                LEFT JOIN TYPES ON TYPES.ID = TYPE_ID
                LEFT JOIN INVENTORY_ATTRIBUTES ON INVENTORY.ID = INVENTORY_ID");
    $TEST = $DB->fetch_assoc_all();
    print_r('<pre>');
    foreach($TEST[0] AS $KEY=>$VALUE){
        switch($KEY){
            case 'WEIGHT':
                $TEST[0]['ATTRIBUTES']->{'Metal Weight'} = $VALUE;
                unset($TEST[0]['WEIGHT']);
                break;
            case 'ATTRIBUTES':
                $TEST[0][$KEY] = json_decode($VALUE);
                break;
        }
    }
    print_r($TEST[0]);
    $TEST_ATTRIBUTES = portal::warp('types','getTypeAttribute',array('CLASS_ID'=>$TEST[0]['CLASS_ID'],'TYPE_ID'=>$TEST[0]['TYPE_ID']));
    foreach($TEST_ATTRIBUTES AS $KEY=>$VALUE){
        
    }
    print_r($TEST_ATTRIBUTES);