<?php
    class users{
        public static function newUser(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=users&action=new">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Username
                                            </span>
                                            <input type="text" name="USER_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Password
                                            </span>
                                            <input type="password" name="USER_PASS" class="form-control">
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
                $PANEL .= '<option value="'.$VALUE['ID'].'">'.$VALUE['USER_TYPE_NAME'].'</option>';
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
            $PANEL = '<div id="edit" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit User - <span id="NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                New Password
                                            </span>
                                            <input name="USER_PASS" type="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Confrim Pass.
                                            </span>
                                            <input name="CONF_USER_PASS" type="password" class="form-control">
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
                $PANEL .= '<option value="'.$VALUE['ID'].'">'.$VALUE['USER_TYPE_NAME'].'</option>';
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
        
        public static function getTBODY(){
            $DB = portal::database();
            $DB->query('SELECT USER_ACCOUNTS.ID,USER_NAME,IFNULL(USER_TYPE_NAME,"UNAVAILABLE") AS USER_TYPE_NAME,USER_LOGIN,USER_ACCOUNTS.LAST_MODIFIED FROM USER_ACCOUNTS LEFT JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID ORDER BY '.$_GET['orderBy'].' '.$_GET['order']);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['USER_NAME'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_NAME'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_TYPE_NAME'].'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['USER_LOGIN'])).'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'</td></tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function insertUser($DATA){
            $USER = array(
                'USER_NAME'=>NULL,
                'USER_PASS'=>NULL,
                'USER_TYPE_ID'=>NULL
            );
            foreach($DATA AS $KEY=>$VALUE){
                $USER[$KEY] = $VALUE;
            }
            switch(true){
                case portal::userNameValid($USER['USER_NAME']):
                    break;
                case portal::userPassValid($USER['USER_PASS']);
                    break;
                case portal::userNameExists($USER['USER_NAME']):
                    $_SESSION['ERR_MSG'] = "Invalid username: This username already exists.";
                    break;
                default:
                    var_dump($USER);
                    $DB = portal::database();
                    if(!$DB->query("INSERT INTO USER_ACCOUNTS (USER_TYPE_ID,USER_NAME,USER_PASS) VALUES (?,?,?)",array($USER['USER_TYPE_ID'],$USER['USER_NAME'],MD5($USER['USER_PASS'])))){
                        die('Error');
                    }
                    break;
            }
        }
        
        public static function updateUser($USER,$DATA){
            switch(true){
                case $DATA['USER_PASS'] !== $DATA['CONF_USER_PASS']:
                    $_SESSION['ERR_MSG'] = 'Please ensure the new password and the confirmation password match!';
                    break;
                default:
                    $DB = portal::database();
                    if(strlen(trim($DATA['USER_PASS'])) === 0){
                        $SQL = "UPDATE USER_ACCOUNTS SET USER_TYPE_ID = ".$DATA['USER_TYPE_ID'].", LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$USER."'";
                    }
                    else{
                        $SQL = "UPDATE USER_ACCOUNTS SET USER_TYPE_ID = ".$DATA['USER_TYPE_ID'].", USER_PASS = '".MD5($DATA['USER_PASS'])."', LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$USER."'";
                    }
                    $DB->query($SQL);
                    break;
            }
        }
        
        public static function deleteUser($USERS){
            $DB = portal::database();
            $SQL = "DELETE FROM USER_ACCOUNTS WHERE ";
            foreach($USERS AS $KEY=>$VALUE){
                $SQL .= "USER_NAME = '".$VALUE."' ".((count($USERS) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }