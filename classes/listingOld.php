<?php
    require_once('portal.php');
    class listing{
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
        
        public function getListing($sku){
            $mysqli = new mysqli('localhost', 'root', '', 'lister');
            if($mysqli->connect_errno){
                echo 'Connection failed: '.$mysqli->connect_error;
            }
            $query = $mysqli->query("SELECT 
                                    listings.sku as 'sku',
                                    condition1,
                                    condition2,
                                    gender,
                                    title,
                                    price,
                                    classification.name AS class,
                                    types.name AS type,
                                    GROUP_CONCAT(listing_attributes.attribute) AS 'attributes',
                                    GROUP_CONCAT(listing_attributes.value) AS 'atttribute_value',
                                    submit_date,
                                    requestor,
                                    quantity,
                                    errored,
                                    redo,
                                    reshoot,
                                    revise,
                                    marketplace
                                    FROM listings 
                                    LEFT JOIN listing_attributes ON listings.sku = listing_attributes.sku
                                    LEFT JOIN classification ON listings.classification_id = classification.id
                                    LEFT JOIN types ON listings.type_id = types.id
                                    WHERE listings.sku = '$sku'");
            $result = $query->fetch_object();
            $listingAttributes = array();
            $attributes = explode(',',$result->attributes);
            $attribute_values = explode(',',$result->atttribute_value);
            foreach($attributes AS $key=>$value){
                $listingAttributes[$value] = $attribute_values[$key];
            }
            foreach($this AS $key=>$value){
                if($key === 'descriptor'){
                    //$this->$key = $result->$key;
                    $this->descriptor = explode(' - ',$result->title);
                    if($this->type === 'Jewelry'){
                        $this->descriptor = $this->descriptor[1];
                    }
                    else{
                        $this->descriptor = $this->descriptor[0];
                    }
                }
                elseif($key === 'marketplace' ){
                    $schedules = report::getArray('schedules');
                    if(isset($schedules[$result->marketplace])){
                        $this->marketplace = $schedules[$result->marketplace];
                    }
                    else{
                        $this->marketplace = $result->marketplace;
                    }
                }
                elseif($key === 'attributes'){
                    $this->attributes = $listingAttributes;
                }
                else{
                    $this->$key = $result->$key;
                }
            }
            return $this;
        }
        
        public function getNextSKU(){
            $mysqli = new mysqli('localhost', 'root', '', 'lister');
            if($mysqli->connect_errno){
                echo 'Connection failed: '.$mysqli->connect_error;
            }
            $query = $mysqli->query("SELECT sku FROM jobs WHERE requested_by = '".$_SESSION['userName']."' AND pool != 'deleted' LIMIT 1");
            $results = $query->fetch_object();
            $this->requestor = $_SESSION['userName'];
            $this->sku = $results->sku;
            $query = $mysqli->query("SELECT class,type,condition1,quantity FROM sku_entry WHERE sku = '".$this->sku."'");
            $result = $query->fetch_object();
            $this->type = $result->class;
            $this->class = $result->type;
            $this->condition1 = $result->condition1;
            $this->quantity = $result->quantity;
            $query = $mysqli->query("SELECT 
                                    GROUP_CONCAT(attribute) AS 'attribute',GROUP_CONCAT(value) AS 'value'
                                    FROM listing_attributes 
                                    WHERE sku = '".$this->sku."'");
            $results = $query->fetch_object();
            $attributes = explode(',',$results->attribute);
            $attribute_values = explode(',',$results->value);
            foreach($attributes AS $key=>$value){
                $listingAttributes[$value] = $attribute_values[$key];
            }
            $this->attributes = $listingAttributes;
            return $this;
        }
        
        public function saveListing(){
            
        }
        
        public function updateListing(){
            
        }
    }