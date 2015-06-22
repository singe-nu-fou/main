<?php
    class table{
        public $HEADER;
        public $CONTROL_PANEL;
        public $MODE;
        public $TABLE;
        public $FOOTER = '<div class="panel-footer"></div>';
        
        public function __construct($TITLE,$CONTROL_PANEL,$MODE = NULL,$THEAD,$SELECTABLE = ''){
            $this->HEADER = '<div class="panel-heading">'.$TITLE.'</div>';
            $this->CONTROL_PANEL = '<ul class="nav nav-pills nav-justified">';
            
            foreach($CONTROL_PANEL AS $KEY=>$VALUE){
                $this->CONTROL_PANEL .= '<li><a'.((isset($VALUE['href'])) ? ' href="'.$VALUE['href'].'"' : '').((isset($VALUE['id'])) ? ' id="'.$VALUE['id'].'"' : '').' class="CONTROL_PANEL list-group-item'.((isset($VALUE['class'])) ? ' '.$VALUE['class'] : '').'">'.$KEY.'</a></li>';
            }
            
            $this->CONTROL_PANEL .= '</ul>';
            
            $this->MODE = (isset($MODE)) ? portal::warp($_GET['subnav'],$MODE) : '';
            
            $this->TABLE = '<table class="'.$SELECTABLE.' table table-hover">';
            $this->TABLE .= '<thead><tr>';
            
            foreach($THEAD AS $KEY=>$VALUE){
                $this->TABLE .= '<th><a href="?'.self::orderBy($VALUE).'" class="list-group-item">'.$KEY.' <span class="'.self::orderByIcon($VALUE).'"></span></a></th>';
            }
            
            $this->TABLE .= '</tr></thead>';
            $this->TABLE .= portal::warp($_GET['subnav'],'TBODY');
            $this->TABLE .= '</table>';
        }
        
        public function getTable(){
            return '<div class="panel panel-default">'.$this->HEADER.$this->CONTROL_PANEL.$this->MODE.$this->TABLE.$this->FOOTER.'</div>';
        }
        
        public static function orderBy($COLUMN){
            $URL = $_SERVER['QUERY_STRING'];
            $URL = str_replace($_GET['orderBy'],$COLUMN,$URL);
            
            return (($_GET['orderBy'] === $COLUMN) ? ($_GET['order'] === 'ASC' ? str_replace("ASC", "DESC", $URL) : str_replace("DESC", "ASC", $URL)) : str_replace("DESC", "ASC", $URL));
        }
        
        public static function orderByIcon($COLUMN){
            return (($_GET['orderBy'] === $COLUMN) ? (($_GET['order'] === 'ASC') ? 'glyphicon glyphicon-chevron-up' : 'glyphicon glyphicon-chevron-down') : '');
        }
    }
