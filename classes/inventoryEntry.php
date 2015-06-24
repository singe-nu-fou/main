<?php
    class inventoryEntry{
        public static function insert($DATA){
            $DB = portal::database();
            extract($DATA['POST']);
            $INVENTORY = array();
            $ATTRIBUTES = array();
            foreach($inventory AS $KEY=>$VALUE){
                switch($KEY){
                    case 'sku':
                        $INVENTORY[$KEY] = strtoupper(substr_replace($VALUE,'',5));
                        $INVENTORY['lot'] = (empty(substr($VALUE,5)) ? 0 : substr($VALUE,5));
                        break;
                    case 'Metal Weight':
                    case 'class':
                    case 'type':
                        $INVENTORY[$KEY] = $VALUE;
                        break;
                    default:
                        $ATTRIBUTES[$KEY] = $VALUE;
                        break;
                }
            }
            $DB->select("ID AS INVENTORY_ID","INVENTORY","SKU = ? AND LOT = ?",array($INVENTORY['sku'],$INVENTORY['lot']));
            if($DB->fetch_assoc()){
                $_SESSION['ERROR_MSG'] = 'Duplicate SKU, please resubmit with a valid SKU.';
                return;
            }
            print_r('<pre>');
            print_r($INVENTORY);
            echo json_encode($ATTRIBUTES);
            echo '<br>';
            $DB->insert("INVENTORY",array("SKU"=>$INVENTORY['sku'],"LOT"=>$INVENTORY['lot'],"CLASS_ID"=>$INVENTORY['class'],"TYPE_ID"=>$INVENTORY['type'],"WEIGHT"=>$INVENTORY['Metal Weight']));
            $DB->select("ID AS INVENTORY_ID","INVENTORY","SKU = ? AND LOT = ?",array($INVENTORY['sku'],$INVENTORY['lot']));
            extract($DB->fetch_assoc());
            $DB->insert("INVENTORY_ATTRIBUTES",array("INVENTORY_ID"=>$INVENTORY_ID,"ATTRIBUTES"=>json_encode($ATTRIBUTES)));
            $DB->insert("INVENTORY_WORKERS",array("INVENTORY_ID"=>$INVENTORY_ID,"SKUER_ID"=>$_SESSION['ID']));
        }
    }