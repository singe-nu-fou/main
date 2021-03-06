<?php
    /* =======================================================================
     * (C) 2015 Stephen Palmer
     * All Rights Reserved
     * File: user.php
     * Description: The user class containing functions specific to user account
     *              management, as well as common functions related to users
     *              used across the scope of portal.php. This, along with user
     *              type are currently essential in order to use portal.php.
     * Author: Stephen Palmer <stephen.palmerjr@outlook.com>
     * PHP Version: 5.4
     * ======================================================================= */

    class user{
        /*
         * Used by the table class. Contains the specifics for generating the
         * tbody content when a user table is created.
         */
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT user_account.ID,
                               USER_NAME,
                               IFNULL(USER_TYPE,"UNAVAILABLE") AS USER_TYPE,
                               IFNULL(USER_EMAIL,"UNAVAILABLE") AS USER_EMAIL,
                               LAST_LOGIN,
                               user_account.LAST_MODIFIED 
                        FROM user_account 
                             LEFT JOIN user_type ON USER_TYPE_ID = user_type.ID 
                             LEFT JOIN user_name ON USER_NAME_ID = user_name.ID
                             LEFT JOIN user_email ON USER_EMAIL_ID = user_email.ID
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$USER_NAME.'</td>
                               <td>'.$USER_TYPE.'</td>
                               <td>'.$USER_EMAIL.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_LOGIN)).'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        /*
         * Function for creating the form shown when New User is clicked.
         */
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=user&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Username
                                            </span>
                                            <input type="text" name="USER_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Password
                                            </span>
                                            <input type="password" name="USER_PASS" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select name="USER_TYPE_ID" class="form-control">';
            $USER_TYPES = portal::warp('user_type','getUserType');
            foreach($USER_TYPES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$USER_TYPE.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Email Address
                                            </span>
                                            <input type="text" name="USER_EMAIL" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create User</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button name="cancel" type="submit" class="btn btn-default form-control">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            return $PANEL;
        }
        
        /*
         * Function for creating the form shown when Edit User is clicked.
         */
        public static function edit(){
            $DB = portal::database();
            extract($_GET);
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $SQL_CONCAT[] = " user_account.ID = ? ";
            }
            $DB->query("SELECT user_account.ID AS 'USER_ACCOUNT_ID',
                               USER_NAME_ID,
                               USER_NAME,
                               USER_TYPE_ID,
                               USER_EMAIL 
                        FROM user_account 
                               LEFT JOIN user_name ON USER_NAME_ID = user_name.ID 
                               LEFT JOIN user_email ON USER_EMAIL_ID = user_email.ID
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit User</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=user&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="USERS['.$USER_ACCOUNT_ID.'][USER_NAME_ID]" value="'.$USER_NAME_ID.'">
                               <div class="col-lg-6">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Username
                                       </span>
                                       <input type="text" name="USERS['.$USER_ACCOUNT_ID.'][USER_NAME]" value="'.$USER_NAME.'" class="form-control">
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Password
                                       </span>
                                       <input type="password" name="USERS['.$USER_ACCOUNT_ID.'][USER_PASS]" class="form-control">
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Type
                                       </span>
                                       <select name="USERS['.$USER_ACCOUNT_ID.'][USER_TYPE_ID]" class="form-control">';
                $USER_TYPES = portal::warp('user_type','getUserType');
                foreach($USER_TYPES AS $VALUE){
                    extract($VALUE);
                    $PANEL .= '<option value="'.$ID.'"'.(($ID === $USER_TYPE_ID) ? ' selected' : '').'>'.$USER_TYPE.'</option>';
                }
                
                $PANEL .= '            </select>
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Conf Password
                                       </span>
                                       <input type="password" name="USERS['.$USER_ACCOUNT_ID.'][CONF_PASS]" class="form-control">
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Email Address
                                       </span>
                                       <input type="text" name="USERS['.$USER_ACCOUNT_ID.'][USER_EMAIL]" value="'.$USER_EMAIL.'" class="form-control">
                                   </div>
                               </div>
                           </div>';
            }
                $PANEL .= '     <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Update Users</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button name="cancel" type="submit" class="btn btn-default form-control">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            return $PANEL;
        }
        
        /*
         * When a new user form is submitted and passed to warp.php, insert is 
         * called to validate and insert the new values into the database.
         */
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::userNameExists(array('USER_NAME'=>$USER_NAME))){
                return;
            }
            switch(false){
                case self::validUsername($USER_NAME):
                case self::validPassword($USER_PASS);
                    return;
                default:
                    $DB = portal::database();
                    $DB->insert("user_name",array("USER_NAME"=>$USER_NAME));
                    $DB->select("ID","user_name","USER_NAME = ?",array($USER_NAME));
                    $USER_NAME_ID = $DB->fetch_assoc();
                    $INSERT = array("USER_NAME_ID"=>$USER_NAME_ID['ID'],
                                    "USER_TYPE_ID"=>$USER_TYPE_ID,
                                    "USER_PASSWORD"=>MD5($USER_PASS));
                    if(filter_var($USER_EMAIL,FILTER_VALIDATE_EMAIL) && !self::userEmailExists(array('USER_EMAIL'=>$USER_EMAIL))){
                        $DB->insert("user_email",array('USER_EMAIL'=>$USER_EMAIL));
                        $DB->select("ID","user_email","USER_EMAIL = ?",array($USER_EMAIL));
                        $USER_EMAIL_ID = $DB->fetch_assoc();
                        $USER_EMAIL_ID = $USER_EMAIL_ID['ID'];
                    }
                    else{
                        $USER_EMAIL_ID = 1;
                    }
                    $INSERT['USER_EMAIL_ID'] = $USER_EMAIL_ID;
                    $DB->insert("user_account",$INSERT);
            }
        }
        
        /*
         * When an edit user form is submitted and passed to warp.php, update is 
         * called to validate and update the existing values into the database.
         */
        public static function update($DATA){
            $DB = portal::database();
            extract($DATA['POST']);
            $ERROR_MSG = array();
            $ERR_REASON = array();
            foreach($USERS AS $ID=>$USER){
                $DB->select("USER_TYPE_ID,USER_NAME_ID,USER_EMAIL_ID","user_account","ID = ?",array($ID));
                extract($DB->fetch_assoc());
                $DB->select("USER_NAME","user_name","ID = ?",array($USER_NAME_ID));
                extract($DB->fetch_assoc());
                switch(true){
                    case strlen(trim($USER['USER_PASS'])) === 0:
                        if($USER['USER_NAME'] !== $USER_NAME){
                            switch(false){
                                case self::validUsername($USER['USER_NAME']);
                                case !self::userNameExists(array('USER_NAME',$USER['USER_NAME'])):
                                    $ERROR_MSG[] = $USER_NAME;
                                    $ERR_REASON[] = 'Please ensure the new username does not contain any special characters, is at least six characters long, and does not already exist!';
                                    break;
                                default:
                                    $DB->update("USER_NAME",array("USER_NAME" => $USER['USER_NAME']),"ID = ?",array($USER_NAME_ID));
                                    if($USER['USER_TYPE_ID'] !== $USER_TYPE_ID){
                                        $DB->update("user_account",array("USER_TYPE_ID" => $USER['USER_TYPE_ID']),"USER_TYPE_ID = ?",array($USER_TYPE_ID));
                                    }
                                    break;
                            }
                        }
                        if($USER['USER_TYPE_ID'] !== $USER_TYPE_ID){
                            $DB->update("user_account",array("USER_TYPE_ID" => $USER['USER_TYPE_ID']),"ID = ?",array($ID));
                        }
                        if(filter_var($USER['USER_EMAIL'],FILTER_VALIDATE_EMAIL) && !self::userEmailExists(array('USER_EMAIL'=>$USER['USER_EMAIL']))){
                            $DB->update("user_email",array("USER_EMAIL"=>$USER['USER_EMAIL']),"ID = ? ",array($USER_EMAIL_ID));
                        }
                        break;
                    case self::validPassword($USER['USER_PASS']):
                        if($USER['USER_NAME'] !== $USER_NAME){
                            switch(false){
                                case self::validUsername($USER['USER_NAME']);
                                case !self::userNameExists(array('USER_NAME',$USER['USER_NAME'])):
                                    $ERROR_MSG[] = $USER_NAME;
                                    $ERR_REASON[] = 'Please ensure the new username does not contain any special characters, is at least six characters long, and does not already exist!';
                                    break;
                                default:
                                    $DB->update("user_name",array("USER_NAME" => $USER['USER_NAME']),"ID = ?",array($USER_NAME_ID));
                                    break;
                            }
                        }
                        if($USER['USER_PASS'] == $USER['CONF_PASS']){
                            $DB->query("UPDATE user_account SET USER_TYPE_ID = ".$USER['USER_TYPE_ID'].", USER_PASSWORD = '".MD5($USER['USER_PASS'])."', LAST_MODIFIED = NOW()+0 WHERE ID = '".$ID."'");
                        }
                        else{
                            $ERR_REASON[] = '<br>Please ensure the new password and the confirmation password match!';
                            $ERROR_MSG[] = $USER['USER_NAME'];
                        }
                        if($USER['USER_TYPE_ID'] !== $USER_TYPE_ID){
                            $DB->update("user_account",array("USER_TYPE_ID" => $USER['USER_TYPE_ID']),"ID = ?",array($ID));
                        }
                        if(filter_var($USER_EMAIL,FILTER_VALIDATE_EMAIL) && !self::userEmailExists(array('USER_EMAIL'=>$USER['USER_EMAIL']))){
                            $DB->update("user_email",array("USER_EMAIL"=>$USER['USER_EMAIL']),"ID = ? ",array($USER_EMAIL_ID));
                        }
                        break;
                    default:
                        if($USER['USER_PASS'] !== $USER['CONF_PASS']){
                            $ERR_REASON[] = '<br>Please ensure the new password and the confirmation password match!';
                        }
                        elseif(!self::validPassword($USER['USER_PASS'])){
                            $ERR_REASON[] = '<br>Passwords must be at least six characters long and contain no spaces!';
                        }
                        $ERROR_MSG[] = $USER['USER_NAME'];
                        break;
                }
                if(count($ERROR_MSG) > 0){
                    $_SESSION[CLIENT]['ERROR_MSG'] = 'Failed to update the following users: '.implode(', ',$ERROR_MSG).implode('',$ERR_REASON);
                }
            }
        }
        
        /*
         * When delete user is clicked and passed to warp.php, delete is 
         * called to remove the values from the database.
         */
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->select("USER_NAME_ID","user_account","ID = ?",array($ID));
                extract($DB->fetch_assoc());
                $DB->delete("user_name","ID = ?",array($USER_NAME_ID));
                $DB->delete("user_account","ID = ?",array($ID));
                $DB->delete("user_email","ID = ?",array($USER_EMAIL_ID));
            }
        }
        
        /*
         * Bool function used to determine if a passed username exists in the
         * system.
         */
        public static function userNameExists($DATA){
            extract($DATA);
            $DB = portal::database();
            if(isset($ID)){
                $DB->select("USER_NAME","user_name","ID = ?",array($ID));
                if($DB->fetch_assoc()){
                    return true;
                }
            }
            elseif(isset($USER_NAME)){
                $DB->select("USER_NAME","user_name","USER_NAME = ?",array($USER_NAME));
                if($DB->fetch_assoc()){
                    return true;
                }
            }
            return false;
        }
        
        /*
         * Bool function used to determine if a passed email exists in the
         * system.
         */
        public static function userEmailExists($DATA){
            extract($DATA);
            $DB = portal::database();
            if(isset($ID)){
                $DB->select("USER_EMAIL","user_email","ID = ?",array($ID));
                if($DB->fetch_assoc()){
                    return true;
                }
            }
            elseif(isset($USER_EMAIL)){
                $DB->select("USER_EMAIL","user_email","USER_EMAIL = ?",array($USER_EMAIL));
                if($DB->fetch_assoc()){
                    return true;
                }
            }
            return false;
        }
        
        /*
         * Bool function used to determine if a passed username is acceptable
         * for use in the current app.
         */
        public static function validUsername($USER_NAME){
            $_SESSION[CLIENT]['ERROR_MSG'] = 'Invalid username: ';
            switch(true){
                case preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/', $USER_NAME):
                case strlen(trim($USER_NAME)) === 0:
                case strlen(trim($USER_NAME)) < 6:
                case count(explode(' ',$USER_NAME)) !== 1:
                    $_SESSION[CLIENT]['ERROR_MSG'] .= "Username must be at least six characters long, cannot contain special character or underscores, and cannot contain spaces.";
                    return false;
            }
            unset($_SESSION[CLIENT]['ERROR_MSG']);
            return true;
        }
        
        /*
         * Bool function used to determine if a passed password is acceptable
         * for use in the current app.
         */
        public static function validPassword($USER_PASS){
            $_SESSION[CLIENT]['ERROR_MSG'] = "Invalid password: ";
            switch(true){
                case strlen(trim($USER_PASS)) === 0:
                case strlen(trim($USER_PASS)) < 6:
                case count(explode(' ',$USER_PASS)) !== 1:
                    $_SESSION[CLIENT]['ERROR_MSG'] .= 'Passwords must be at least six characters long and contain no spaces!';
                    return false;
            }
            unset($_SESSION[CLIENT]['ERROR_MSG']);
            return true;
        }
    }
