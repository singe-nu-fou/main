<?php
    session_start();
    require_once('classes/portal.php');
    require_once('classes/listing.php');
    listing::getCurrentAttributesBeta('3','4');
    
    //$DB = portal::database();
    /*$DB->query('SELECT 
                CHT.ID,
                CLASSES.ID,
                CLASSES.CLASS_NAME,
                TYPES.ID,
                TYPES.TYPE_NAME,
                CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',ATTRIBUTES.ID,\'"\',\':"\',ATTRIBUTES.ATTRIBUTE_NAME,\'"\')),\'}\') AS ATTRIBUTES
                FROM CLASSES_HAS_TYPES AS CHT 
                JOIN TYPES_HAS_ATTRIBUTES AS THA ON CHT.ID = THA.CHT_ID 
                JOIN CLASSES ON CHT.CLASS_ID = CLASSES.ID 
                JOIN TYPES ON CHT.TYPE_ID = TYPES.ID 
                JOIN ATTRIBUTES ON THA.ATTRIBUTE_ID = ATTRIBUTES.ID
                WHERE CHT.ID = 21');
    $RESULTS = $DB->fetch_assoc_all();
    $ATTRIBUTES = $RESULTS[0]['ATTRIBUTES'];
    var_dump($ATTRIBUTES);
    $ATTRIBUTES = json_decode($ATTRIBUTES);
    var_dump($ATTRIBUTES);*/