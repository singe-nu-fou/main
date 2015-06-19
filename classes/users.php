<?php
    require_once('userType.php');

    class users{
        public static function userNameExists($ID,$USER_NAME){
            $DB = portal::database();
            $DB->query("SELECT * FROM USER_ACCOUNT LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID WHERE USER_ACCOUNT.ID = ? AND USER_NAME = ?",array($ID,$USER_NAME));
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function validUsername($USER_NAME){
            $_SESSION['ERROR_MSG'] = 'Invalid username: ';
            switch(true){
                case strlen(trim($USER_NAME)) === 0:
                case strlen(trim($USER_NAME)) < 6:
                case count(explode(' ',$USER_NAME)) !== 1:
                    $_SESSION['ERROR_MSG'] .= "Username must be at least six characters long, cannot contain special character or underscores, and cannot contain spaces.";
                    return false;
            }
            unset($_SESSION['ERROR_MSG']);
            return true;
        }
        
        public static function validPassword($USER_PASS){
            $_SESSION['ERROR_MSG'] = "Invalid password: ";
            switch(true){
                case strlen(trim($USER_PASS)) === 0:
                case strlen(trim($USER_PASS)) < 6:
                case count(explode(' ',$USER_PASS)) !== 1:
                    $_SESSION['ERROR_MSG'] .= 'Passwords must be at least six characters long and contain no spaces!';
                    return false;
            }
            unset($_SESSION['ERROR_MSG']);
            return true;
        }
        
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT USER_ACCOUNT.ID,
                               USER_NAME,
                               IFNULL(USER_TYPE,"UNAVAILABLE") AS USER_TYPE,
                               LAST_LOGIN,
                               USER_ACCOUNT.LAST_MODIFIED 
                        FROM USER_ACCOUNT 
                             LEFT JOIN USER_TYPE ON USER_TYPE_ID = USER_TYPE.ID 
                             LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.json_encode($RESULT).'" style="display:none;">'.$RESULT['ID'].'</td>
                               <td>'.$USER_NAME.'</td>
                               <td>'.$USER_TYPE.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_LOGIN)).'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
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
            $USER_TYPES = userType::getUserType();
            foreach($USER_TYPES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$USER_TYPE.'</option>';
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
        
        public static function edit(){
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
            $USER_TYPES = userType::getUserType();
            foreach($USER_TYPES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$USER_TYPE.'</option>';
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
        
        public static function insert($DATA){
            extract($DATA);
            /*$USER = array(
                'USER_NAME'=>NULL,
                'USER_PASS'=>NULL,
                'USER_TYPE_ID'=>NULL
            );
            foreach($DATA['POST'] AS $KEY=>$VALUE){
                $USER[$KEY] = $VALUE;
            }*/
            switch(true){
                case portal::validUsername($USER_NAME):
                    break;
                case portal::validPassword($USER_PASS);
                    break;
                case portal::userNameExists($USER_NAME):
                    $_SESSION['ERR_MSG'] = "Invalid username: This username already exists.";
                    break;
                default:
                    $DB = portal::database();
                    if(!$DB->query("INSERT INTO USER_ACCOUNT (USER_TYPE_ID,USER_NAME,USER_PASS) VALUES (?,?,?)",array($USER_TYPE_ID,$USER_NAME,MD5($USER_PASS)))){
                        die('Error');
                    }
                    break;
            }
        }
        
        public static function update($DATA){
            switch(true){
                case $DATA['POST']['USER_PASS'] !== $DATA['POST']['CONF_USER_PASS']:
                    $_SESSION['ERR_MSG'] = 'Please ensure the new password and the confirmation password match!';
                    break;
                default:
                    $DB = portal::database();
                    if(strlen(trim($DATA['USER_PASS'])) === 0){
                        $SQL = "UPDATE USER_ACCOUNT SET USER_TYPE_ID = ".$DATA['POST']['USER_TYPE_ID'].", LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$DATA['GET']."'";
                    }
                    else{
                        $SQL = "UPDATE USER_ACCOUNT SET USER_TYPE_ID = ".$DATA['POST']['USER_TYPE_ID'].", USER_PASS = '".MD5($DATA['POST']['USER_PASS'])."', LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$DATA['GET']."'";
                    }
                    $DB->query($SQL);
                    break;
            }
        }
        
        public static function delete($DATA){
            $DB = portal::database();
            $SQL = "DELETE FROM USER_ACCOUNT WHERE ";
            foreach($DATA['GET'] AS $KEY=>$VALUE){
                $SQL .= "USER_NAME = '".$VALUE."' ".((count($USERS) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }