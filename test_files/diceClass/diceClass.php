<?php
    interface dice_interface{
        public function calc_dice();
    }
    
    class dX implements dice_interface{
        private $count;
        private $limit;
        private $crit_state;
        private $fail_state;
        private $pool = array();
        
        public function __construct($parameters){
            foreach($parameters AS $key=>$value){
                if(property_exits($this,$key)){
                    $this->$key = $value;
                }
            }
        }
        
        public function calc_dice(){
            for($i = 0; $i < $this->count; $i++){
                $roll = rand(1,$this->limit);
                switch(TRUE){
                    case $this->crit_state === TRUE && $roll === $this->limit:
                        $i--;
                        break;
                    case $this->fail_state === TRUE && $roll === 1:
                        $i = $this->count + 1;
                        break;
                }
                $this->pool[] = ($this->limit === 10 && $roll === 10) ? 0 : $roll;
            }
        }
    }
    
    class dice_roll{
        private $output;
        
        public function set_dice(dice_interface $diceType){
            $this->output = $diceType;
        }
        
        public function roll_dice(){
            $this->output->calc_dice();
        }
        
        public function get_pool(){
            return $this->output->pool;
        }
    }
    
    function new_roll($count = 1,$limit = 6,$crit_state = FALSE,$fail_state = FALSE){
        $diceRoll = new dice_roll();
        $diceRoll->set_dice(new dX(array('count'=>$count,'limit'=>$limit,'crit_state'=>$crit_state,'fail_state'=>$fail_state)));
        $diceRoll->roll_dice();
        return $diceRoll->get_pool();
    }