<?php
    /* =======================================================================
     * (C) 2015 Stephen Palmer
     * All Rights Reserved
     * File: table.php
     * Description: Just a simple object class I devised that serves as a
     *              blueprint for my own way of making tables.
     * Author: Stephen Palmer <stephen.palmerjr@outlook.com>
     * PHP Version: 5.4
     * ======================================================================= */

    class table{
        public $HEADER;
        public $CONTROL_PANEL;
        public $MODE;
        public $TABLE;
        public $FOOTER = '<div class="panel-footer"></div>';
        
        /*
         * Construct takes care of most of the initial grunt work with the 
         * parameters passed in. Selectable is a future implementation for
         * a jQuery plugin I created some time ago but am currently rewriting.
         * 
         * Mode determines if the user is currently, just for example, creating
         * a new user or editing a user.
         */
        public function __construct($TITLE,$CONTROL_PANEL,$MODE = NULL,$THEAD,$SELECTABLE = ''){
            $this->HEADER = '<div class="panel-heading">'.$TITLE.'</div>';
            $this->CONTROL_PANEL = '<ul class="nav nav-pills nav-justified">';
            
            foreach($CONTROL_PANEL AS $KEY=>$VALUE){
                $this->CONTROL_PANEL .= '<li><a'.((isset($VALUE['href'])) ? ' href="'.$VALUE['href'].'"' : '').((isset($VALUE['id'])) ? ' id="'.$VALUE['id'].'"' : '').' class="CONTROL_PANEL list-group-item'.((isset($VALUE['class'])) ? ' '.$VALUE['class'] : '').'">'.$KEY.'</a></li>';
            }
            
            $this->CONTROL_PANEL .= '</ul>';
            
            if(isset($MODE) && is_array($MODE)){
                foreach($MODE AS $KEY=>$VALUE){
                    $this->MODE[] = (isset($VALUE)) ? portal::warp($_GET['subnav'],$VALUE) : '';
                }
            }
            else{
                $this->MODE = (isset($MODE)) ? portal::warp($_GET['subnav'],$MODE) : '';
            }
            
            $this->TABLE = '<table class="'.$SELECTABLE.' table table-hover">';
            $this->TABLE .= '<thead><tr>';
            
            foreach($THEAD AS $KEY=>$VALUE){
                $this->TABLE .= '<th><a href="?'.self::orderBy($VALUE).'" class="list-group-item">'.$KEY.' <span class="'.self::orderByIcon($VALUE).'"></span></a></th>';
            }
            
            $this->TABLE .= '</tr></thead>';
            $this->TABLE .= portal::warp($_GET['subnav'],'TBODY');
            $this->TABLE .= '</table>';
        }
        
        /*
         * Basic function that takes the object and puts all the pieces together.
         */
        public function getTable(){
            $this->MODE = is_array($this->MODE) ? implode('',$this->MODE) : $this->MODE;
            return '<div class="panel panel-default">'.$this->HEADER.$this->CONTROL_PANEL.$this->MODE.$this->TABLE.$this->FOOTER.'</div>';
        }
        
        /*
         * Order by is a function that parses the get variables to determine if
         * the table is sorted in a specific way, and if each column header
         * needs to be adjusted according to those variables.
         */
        public static function orderBy($COLUMN){
            $URL = $_SERVER['QUERY_STRING'];
            $URL = str_replace($_GET['orderBy'],$COLUMN,$URL);
            
            return (($_GET['orderBy'] === $COLUMN) ? ($_GET['order'] === 'ASC' ? str_replace("ASC", "DESC", $URL) : str_replace("DESC", "ASC", $URL)) : str_replace("DESC", "ASC", $URL));
        }
        
        /*
         * Order by icon plays in with order by in a similar manner. Instead of
         * adjusting the sort information of the column headers, this just
         * determines if the current column is the sort index, and if it needs
         * and up arrow or down arrow. Pretty simple, eh?
         */
        public static function orderByIcon($COLUMN){
            return (($_GET['orderBy'] === $COLUMN) ? (($_GET['order'] === 'ASC') ? 'glyphicon glyphicon-chevron-up' : 'glyphicon glyphicon-chevron-down') : '');
        }
    }
