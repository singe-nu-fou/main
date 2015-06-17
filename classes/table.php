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
                    switch($VALUE[0]){
                        case 'New User':
                            $this->SPECIAL_CONTROL .= self::newUser();
                            break;
                        case 'Edit User':
                            $this->SPECIAL_CONTROL .= self::editUser();
                            break;
                    }
                }
            }
            $this->TABLE = '<table class="'.$SELECTABLE.' table table-hover">';
            $this->TABLE .= '<thead><tr>';
            foreach($THEAD AS $KEY=>$VALUE){
                $this->TABLE .= '<th><a href="?'.self::orderBy($VALUE).'" class="list-group-item">'.$KEY.' <span class="'.self::orderByIcon($VALUE).'"></span></a></th>';
            }
            $this->TABLE .= '</tr></thead>';
            $this->TABLE .= $this->tBody($_GET['subnav']);
            $this->TABLE .= '</table>';
        }
        
        public function getTable(){
            return $this->compile();
        }
        
        private function tBody($TYPE){
            switch($TYPE){
                case 'users':
                    $DB = portal::database();
                    $DB->query("SELECT USER_ACCOUNTS.ID,USER_NAME,USER_TYPE,USER_LOGIN FROM USER_ACCOUNTS JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID ORDER BY ".$_GET['orderBy']." ".$_GET['order']);
                    $TBODY = "<tbody>";
                    while($RESULT = $DB->fetch_assoc()){
                        $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['USER_NAME'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                        $TBODY .= '<td>'.$RESULT['USER_NAME'].'</td>';
                        $TBODY .= '<td>'.$RESULT['USER_TYPE'].'</td>';
                        $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['USER_LOGIN'])).'</td></tr>';
                    }
                    $TBODY .= "</tbody>";
                    return $TBODY;
            }
        }
        
        private function compile(){
            return '<div class="panel panel-default">'.$this->HEADER.$this->ADVANCED_CONTROL.$this->SPECIAL_CONTROL.$this->TABLE.$this->FOOTER.'</div>';
        }
        
        public static function newUser(){
            $PANEL = '<div id="newUser" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?action=newUser" autocomplete="off">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Username
                                            </span>
                                            <input type="text" name="USER_NAME" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Password
                                            </span>
                                            <input type="password" name="USER_PASS" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select name="USER_TYPE_ID" class="form-control">';
            $USER_TYPES = portal::getUserTypes();
            foreach($USER_TYPES AS $KEY=>$VALUE){
                $PANEL .= '<option value="'.$VALUE['ID'].'">'.$VALUE['USER_TYPE'].'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create User</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            return $PANEL;
        }
        
        public static function editUser(){
            $PANEL = '<div id="editUser" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit User - <span id="USER_NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?action=editUser" autocomplete="off">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                New Password
                                            </span>
                                            <input type="password" name="USER_PASS" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Confrim Pass.
                                            </span>
                                            <input type="password" name="CONF_USER_PASS" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select name="USER_TYPE_ID" class="form-control">';
            $USER_TYPES = portal::getUserTypes();
            foreach($USER_TYPES AS $KEY=>$VALUE){
                $PANEL .= '<option value="'.$VALUE['ID'].'">'.$VALUE['USER_TYPE'].'</option>';
            }                      
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-default form-control">Edit Users</button>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>';
            return $PANEL;
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