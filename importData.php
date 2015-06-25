<pre>
<?php
    require_once('classes/portal.php');
    $DB = portal::databaseOld();
    $DBalpha = portal::database();
    /*$DB->query("SELECT lister.users.uname AS USER_NAME, alpha.USER_TYPE.ID AS USER_TYPE_ID FROM lister.users LEFT JOIN alpha.user_type ON grp = user_type GROUP BY USER_NAME ORDER BY lister.users.uname ASC");
    $USERS = $DB->fetch_assoc_all();
    $i = 1;
    foreach($USERS AS $KEY=>$VALUE){
        var_dump($VALUE);
        $DBalpha->insert("USER_NAME",array("USER_NAME"=>$VALUE['USER_NAME']));
        $DBalpha->insert("USER_EMAIL",array("USER_EMAIL"=>$i.'@bellaandchloe.com'));
        $DBalpha->insert("USER_ACCOUNT",array("USER_NAME_ID"=>$i,"USER_EMAIL_ID"=>$i,"USER_TYPE_ID"=>$VALUE['USER_TYPE_ID'],"USER_PASSWORD"=>MD5('P@$$w0rd!')));
        $i++;
    }*/
    /*$DB->query("SELECT substr(lister.listing_attributes.sku,1,5) AS SKU, 
                CASE WHEN LENGTH(substr(lister.listing_attributes.sku,6,1)) < 1 THEN 0 ELSE substr(lister.listing_attributes.sku,6,1) END AS LOT,
                alpha.classes.id AS CLASS_ID,
                alpha.types.id AS TYPE_ID,
                lister.listings.exported AS EXPORTED,
                lister.listings.queued AS QUEUED,
                lister.listings.errored AS ERRORED,
                lister.listings.redo AS REDO,
                lister.listings.reshoot AS RESHOOT,
                lister.listings.revise AS REVISE,
                lister.listings.deleted AS DELETED,
                lister.listings.title AS INVENTORY_TITLE,
                alpha.user_account.id AS LISTER_ID,
                CONCAT('{\"Condition\":\"',lister.listings.condition1,'\",\"Defects/Features\":\"',CASE WHEN LENGTH(lister.listings.condition2) < 1 THEN lister.listings.notes ELSE lister.listings.condition2 END,'\",\"Price\":\"',lister.listings.price,'\",\"Quantity\":\"',lister.listings.quantity,'\",',GROUP_CONCAT(CONCAT('\"',attribute,'\":\"',value,'\"')),'}') AS ATTRIBUTES
                FROM lister.listing_attributes 
                JOIN lister.listings ON lister.listings.sku = lister.listing_attributes.sku
                JOIN lister.classification ON lister.classification.id = lister.listings.classification_id
                JOIN lister.types ON lister.types.id = lister.listings.type_id
                JOIN alpha.classes ON lister.types.name = alpha.classes.class_name
                JOIN alpha.types ON lister.classification.name = alpha.types.type_name
                JOIN alpha.user_name ON lister.listings.requestor = alpha.user_name.user_name
                JOIN alpha.user_account ON alpha.user_account.user_name_id = alpha.user_name.id
                WHERE LENGTH(lister.listing_attributes.sku) > 4 
                AND LENGTH(lister.listing_attributes.sku) < 7 
                AND lister.listings.exported = 0
                AND lister.listings.deleted = 0
                GROUP BY lister.listing_attributes.sku ORDER BY LOT,SKU ASC ");
    $OLD = $DB->fetch_assoc_all();
    $i = 1;
    foreach($OLD AS $KEY=>$DATA){
        $DATA['ATTRIBUTES'] = json_decode($DATA['ATTRIBUTES']);
        $DBalpha->insert("INVENTORY",array("SKU"=>$DATA['SKU'],"LOT"=>$DATA['LOT'],"CLASS_ID"=>$DATA['CLASS_ID'],"TYPE_ID"=>$DATA['TYPE_ID'],"WEIGHT"=>$DATA['ATTRIBUTES']->{'Metal Weight'}));
        unset($DATA['ATTRIBUTES']->{'Metal Weight'});
        $DBalpha->insert("INVENTORY_TITLE",array("INVENTORY_ID"=>$i,"INVENTORY_TITLE"=>$DATA['INVENTORY_TITLE']));
        $DBalpha->insert("INVENTORY_WORKERS",array("INVENTORY_ID"=>$i,"LISTER_ID"=>$DATA['LISTER_ID']));
        $DBalpha->insert("INVENTORY_STATUS",array("INVENTORY_ID"=>$i,"EXPORTED"=>$DATA['EXPORTED'],"QUEUED"=>$DATA['QUEUED'],"REDO"=>$DATA['REDO'],"ERRORED"=>$DATA['ERRORED'],"RESHOOT"=>$DATA['RESHOOT'],"REVISE"=>$DATA['DELETED']));
        $DBalpha->insert("INVENTORY_ATTRIBUTES",array("INVENTORY_ID"=>$i,"ATTRIBUTES"=>json_encode($DATA['ATTRIBUTES'])));
        $i++;
    }*/
    /*$DB->query("SELECT 
                alpha.classes.id AS CLASS_ID,
                alpha.types.id AS TYPE_ID
                FROM lister.classification 
                JOIN lister.types ON lister.classification.type_id = lister.types.id
                JOIN alpha.classes ON lister.types.name = alpha.classes.class_name
                JOIN alpha.types ON lister.classification.name = alpha.types.type_name
                ORDER BY CLASS_ID,TYPE_ID");
    $DATA = $DB->fetch_assoc_all();
    foreach($DATA AS $KEY=>$VALUE){
        extract($VALUE);
        $DBalpha->insert("CLASSES_HAS_TYPES",array("CLASS_ID"=>$CLASS_ID,"TYPE_ID"=>$TYPE_ID));
    }*/
    $DB->query("SELECT 
                alpha.classes.id AS CLASS_ID,
                alpha.types.id AS TYPE_ID,
                alpha.attributes.id AS ATTRIBUTE_ID
                FROM lister.new_attributes
                JOIN lister.classification ON lister.new_attributes.class_id = lister.classification.id
                JOIN lister.types ON lister.classification.type_id = lister.types.id
                JOIN alpha.classes ON lister.types.name = alpha.classes.class_name
                JOIN alpha.types ON lister.classification.name = alpha.types.type_name
                JOIN alpha.attributes ON lister.new_attributes.attribute = alpha.attributes.attribute_name
                ORDER BY CLASS_ID,TYPE_ID,lister.new_attributes.order");
    $DATA = $DB->fetch_assoc_all();
    $SEQUENCE = 0;
    $PREV_TYPE = NULL;
    foreach($DATA AS $KEY=>$VALUE){
        extract($VALUE);
        $SEQUENCE = ($TYPE_ID === $PREV_TYPE) ? $SEQUENCE : 0;
        $DBalpha->select("ID AS CHT_ID","CLASSES_HAS_TYPES","CLASS_ID = ? AND TYPE_ID = ?",array($CLASS_ID,$TYPE_ID));
        extract($DBalpha->fetch_assoc());
        $DBalpha->insert("TYPES_HAS_ATTRIBUTES",array("CHT_ID"=>$CHT_ID,"ATTRIBUTE_ID"=>$ATTRIBUTE_ID,"SEQUENCE"=>$SEQUENCE));
        $PREV_TYPE = $TYPE_ID;
        $SEQUENCE++;
    }
?>
</pre>