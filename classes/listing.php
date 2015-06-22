<?php
    require_once("report.php");
    
    class listing{
        public $mode;
        public $sku;
        public $type;
        public $class;
        public $condition1;
        public $condition2 = '';
        public $gender = 'Female';
        public $title = '';
        public $price = '';
        public $submit_date = '0000-00-00 00:00:00';
        public $requestor;
        public $quantity;
        public $errored = 0;
        public $redo = 0;
        public $reshoot = 0;
        public $revise = 0;
        public $descriptor = '';
        public $marketplace = 'To Be Edited';
        public $attributes = array();
        
        public function __construct($SKU = NULL){
            $this->requestor = $_SESSION['USER_NAME'];
            $this->mode = (!$SKU) ? 'create' : 'edit';
            switch($this->mode){
                case 'create':
                    $this->getJob()->getSkuerData()->getCurrentAttributes();
                    break;
                case 'edit':
                    $this->sku = $SKU;
                    $DATA = $this->getListing();
                    foreach($DATA AS $KEY=>$VALUE){
                        switch($KEY){
                            case 'marketplace':
                            case 'mode':
                            case 'descriptor':
                                break;
                            default:
                                $this->$KEY = $DATA->$KEY;
                                break;
                        }
                    }
                    $this->getCurrentAttributes()->getDescriptor()->getMarketplace($DATA);
                    break;
            }
        }
        
        private function getJob(){
            $DBlister = portal::databaseOld();
            $DBlister->select("sku","jobs","requested_by = ? AND pool != ?",array($_SESSION['USER_NAME'],'deleted'),'request_time','1');
            $JOB = $DBlister->fetch_obj();
            $this->sku = $JOB->sku;
            return $this;
        }
        
        private function getSkuerData(){
            $DBlister = portal::databaseOld();
            $DBlister->select("class,type,condition1,quantity","sku_entry","sku = ?",array($this->sku));
            $SKU_ENTRY = $DBlister->fetch_obj();
            $this->type = $SKU_ENTRY->class;
            $this->class = $SKU_ENTRY->type;
            $this->condition1 = $SKU_ENTRY->condition1;
            $this->quantity = $SKU_ENTRY->quantity;
            return $this;
        }
        
        private function getCurrentAttributes(){
            $DBlister = portal::databaseOld();
            $DBlister->select("GROUP_CONCAT(attribute) AS 'attribute',GROUP_CONCAT(value) AS 'value'","listing_attributes","sku = ?",array($this->sku));
            $ATTRIBUTES = $DBlister->fetch_obj();
            $ATTRIBUTE_NAMES = explode(',',$ATTRIBUTES->attribute);
            $ATTRIBUTE_VALUES = explode(',',$ATTRIBUTES->value);
            $FINAL_ATTRIBUTES = array();
            foreach($ATTRIBUTE_VALUES AS $KEY=>$VALUE){
                $FINAL_ATTRIBUTES[$ATTRIBUTE_NAMES[$KEY]] = $VALUE;
            }
            $this->attributes = $FINAL_ATTRIBUTES;
            return $this;
        }
        
        public static function getCurrentAttributesBeta($CLASS_ID,$TYPE_ID){
            $DB = portal::database();
            $DB->query('SELECT 
                        CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',ATTRIBUTES.ID,\'"\',\':"\',ATTRIBUTES.ATTRIBUTE_NAME,\'"\')),\'}\') AS ATTRIBUTES
                        FROM CLASSES_HAS_TYPES AS CHT 
                        JOIN TYPES_HAS_ATTRIBUTES AS THA ON CHT.ID = THA.CHT_ID 
                        JOIN CLASSES ON CHT.CLASS_ID = CLASSES.ID 
                        JOIN TYPES ON CHT.TYPE_ID = TYPES.ID 
                        JOIN ATTRIBUTES ON THA.ATTRIBUTE_ID = ATTRIBUTES.ID
                        WHERE CLASSES.ID = ? AND TYPES.ID = ?',array($CLASS_ID,$TYPE_ID));
            $TEST = new stdClass();
            foreach($DB->fetch_assoc() AS $KEY=>$VALUE){
                $TEST->$KEY = ($KEY === 'ATTRIBUTES') ? json_decode($VALUE) : $VALUE;
            }
            var_dump($TEST);
            exit;
            return $this;
        }
        
        private function getDescriptor(){
            switch($this->type){
                case 'Shopify':
                    $this->descriptor = explode($this->class,$this->title);
                    if(is_array($this->descriptor)){
                        $this->descriptor = $this->descriptor[0];
                    }
                    break;
                default:
                    $this->descriptor = explode(' - ',$this->title);
                    if(is_array($this->descriptor)){
                        $this->descriptor = $this->descriptor[1];
                        $this->descriptor = ((strpos($this->descriptor, $this->attributes['Metal Weight'])) ? str_replace(' '.$this->attributes['Metal Weight'].'g','',$this->descriptor) : $this->descriptor);
                        $this->descriptor = ((strpos($this->descriptor, 'HEAVY')) ? str_replace('HEAVY ','',$this->descriptor) : $this->descriptor);
                    }
                    break;
            }
            return $this;
        }
        
        private function getMarketplace($result){
            $schedules = report::getArray('schedules');
            if(isset($schedules[$result->marketplace])){
                $this->marketplace = $schedules[$result->marketplace];
            }
            else{
                $this->marketplace = $result->marketplace;
            }
            return $this;
        }
        
        public function getAttributes(){
            $DBlister = portal::databaseOld();
            $DBlister->query("SELECT new_attributes.attribute 
                                FROM classification 
                                LEFT JOIN new_attributes ON classification.id = new_attributes.class_id 
                                LEFT JOIN types ON types.id = classification.type_id 
                                WHERE classification.name = '".$this->class."' AND types.name = '".$this->type."'
                                ORDER BY new_attributes.order");
            return $DBlister->fetch_assoc_all();
        }
        
        public function getClasses(){
            $DBlister = portal::databaseOld();
            $DBlister->query("SELECT classification.id as 'id', classification.name as 'name' FROM classification JOIN `types` ON `types`.id = classification.type_id WHERE `types`.name = ?",array($this->type));
            return $DBlister->fetch_assoc_all();
        }
        
        private function getListing(){
            $DBlister = portal::databaseOld();
            $DBlister->query("SELECT 
                            condition1,
                            condition2,
                            gender,
                            title,
                            price,
                            classification.name AS class,
                            types.name AS type,
                            submit_date,
                            requestor,
                            quantity,
                            errored,
                            redo,
                            reshoot,
                            revise,
                            marketplace
                            FROM listings 
                            LEFT JOIN classification ON listings.classification_id = classification.id
                            LEFT JOIN types ON listings.type_id = types.id
                            WHERE listings.sku = '$this->sku'");
            return $DBlister->fetch_obj();
        }
    }