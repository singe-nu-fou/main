<?php
    class table{
        private $HEADER;
        private $ADVANCED_CONTROL;
        private $SPECIAL_CONTROL = NULL;
        private $TABLE;
        private $FOOTER = '<div class="panel-footer"></div>';
        
        public function __construct($HEADER,$ADVANCED_CONTROL,$SPECIAL_CONTROL,$THEAD,$SELECTABLE = ''){
            $this->HEADER = '<div class="panel-heading">'.$HEADER.'</div>';
            $this->ADVANCED_CONTROL = '<ul class="nav nav-pills nav-justified">';
            
            foreach($ADVANCED_CONTROL AS $KEY=>$VALUE){
                $this->ADVANCED_CONTROL .= '<li><a href="'.$VALUE.'" class="advanced_control list-group-item">'.$KEY.'</a></li>';
            }
            
            $this->ADVANCED_CONTROL .= '</ul>';
            
            if($SPECIAL_CONTROL !== NULL){
                foreach($SPECIAL_CONTROL AS $KEY=>$VALUE){
                    $this->SPECIAL_CONTROL .= router::route($_GET['subnav'],$VALUE);
                }
            }
            
            $this->TABLE = '<table class="'.$SELECTABLE.' table table-hover">';
            $this->TABLE .= '<thead><tr>';
            
            foreach($THEAD AS $KEY=>$VALUE){
                $this->TABLE .= '<th><a href="?'.self::orderBy($VALUE).'" class="list-group-item">'.$KEY.' <span class="'.self::orderByIcon($VALUE).'"></span></a></th>';
            }
            
            $this->TABLE .= '</tr></thead>';
            $this->TABLE .= router::route($_GET['subnav'],'TBODY');
            $this->TABLE .= '</table>';
        }
        
        public function getTable(){
            return $this->compile();
        }
        private function compile(){
            return '<div class="panel panel-default">'.$this->HEADER.$this->ADVANCED_CONTROL.$this->SPECIAL_CONTROL.$this->TABLE.$this->FOOTER.'</div>';
        }
        
        public static function orderBy($COLUMN){
            $URL = $_SERVER['QUERY_STRING'];
            $URL = str_replace($_GET['orderBy'],$COLUMN,$URL);
            
            return (($_GET['orderBy'] === $COLUMN) ? ($_GET['order'] === 'DESC' ? str_replace("DESC", "ASC", $URL) : str_replace("ASC", "DESC", $URL)) : str_replace("ASC", "DESC", $URL));
        }
        
        public static function orderByIcon($COLUMN){
            return (($_GET['orderBy'] === $COLUMN) ? (($_GET['order'] === 'ASC') ? 'glyphicon glyphicon-chevron-up' : 'glyphicon glyphicon-chevron-down') : '');
        }
    }
