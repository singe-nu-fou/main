<?php
    class inventoryEntry{
        public static function insert($DATA){
            extract($DATA['POST']);
            foreach($inventory AS $KEY=>$VALUE){
                if($KEY === 'sku'){
                    echo $KEY.' - '.substr_replace($VALUE,'',5).'<br>';
                    echo 'lot - '.(empty(substr($VALUE,5)) ? 0 : substr($VALUE,5));
                }
                else{
                    echo $KEY.' - '.$VALUE.'<br>';
                }
            }
            exit;
        }
    }