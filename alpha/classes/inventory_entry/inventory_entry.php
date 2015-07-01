<?php
    class inventory_entry{
        public static function insert($DATA){
            $DB = portal::database();
            extract($DATA['POST']);
            $INVENTORY = array();
            $CHARACTERISTIC = array();
            foreach($inventory AS $KEY=>$VALUE){
                switch($KEY){
                    case 'SKU':
                    case 'CATEGORY_ID':
                    case 'CLASSIFICATION_ID':
                    case 'WEIGHT':
                        $INVENTORY[$KEY] = $VALUE;
                        break;
                    default:
                        $CHARACTERISTIC[$KEY] = $VALUE;
                        break;
                }
            }
            $DB->select("ID AS INVENTORY_ID","INVENTORY","SKU = ?",array($INVENTORY['SKU']));
            if($DB->fetch_assoc()){
                $_SESSION['ERROR_MSG'] = 'Duplicate SKU, please resubmit with a valid SKU.';
                return;
            }
            $DB->insert("INVENTORY",array("SKU"=>$INVENTORY['SKU'],"CATEGORY_ID"=>$INVENTORY['CATEGORY_ID'],"CLASSIFICATION_ID"=>$INVENTORY['CLASSIFICATION_ID'],"WEIGHT"=>$INVENTORY['WEIGHT']));
            $DB->select("ID AS INVENTORY_ID","INVENTORY","SKU = ?",array($INVENTORY['SKU']));
            extract($DB->fetch_assoc());
            $DB->insert("INVENTORY_CHARACTERISTIC",array("INVENTORY_ID"=>$INVENTORY_ID,"CHARACTERISTICS"=>json_encode($CHARACTERISTIC)));
            $DB->insert("INVENTORY_WORKED_BY",array("INVENTORY_ID"=>$INVENTORY_ID,"USER_ACCOUNT_ID"=>$_SESSION['ID']));
        }
    }