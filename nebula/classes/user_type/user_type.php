<?php
    class user_type{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM user_type
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$USER_TYPE.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User Type</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=user_type&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <input type="text" name="USER_TYPE" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Type</button>
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
        
        public static function edit(){
            $DB = portal::database();
            extract($_GET);
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $SQL_CONCAT[] = " user_type.ID = ? ";
            }
            $DB->query("SELECT ID AS 'USER_TYPE_ID',USER_TYPE
                        FROM user_type
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit User Type</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=user_type&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="TYPES['.$USER_TYPE_ID.'][USER_TYPE_ID]" value="'.$USER_TYPE_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Type
                                       </span>
                                       <input type="text" name="TYPES['.$USER_TYPE_ID.'][USER_TYPE]" value="'.$USER_TYPE.'" class="form-control">
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
        
        public static function getUserType($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM user_type";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ? AND USER_TYPE = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE USER_TYPE = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealUserType($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM user_type WHERE ID = ? AND USER_TYPE = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM user_type WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM user_type WHERE USER_TYPE = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealUserType(array('NAME'=>$USER_TYPE)) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$USER_TYPE)){
                $_SESSION[CLIENT]['ERROR_MSG'] = 'User types cannot contain special characters, and cannot be the same as an existing type.';
                return;
            }
            $DB = portal::database();
            $DB->insert("user_type",array("USER_TYPE"=>$USER_TYPE));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($TYPES AS $ID=>$TYPE){
                if(self::isRealUserType(array('NAME'=>$TYPE['USER_TYPE'])) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$TYPE['USER_TYPE'])){
                    $_SESSION[CLIENT]['ERROR_MSG'] = 'User types cannot contain special characters, and cannot be the same as an existing type.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("user_type",array("USER_TYPE"=>$TYPE['USER_TYPE'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("user_type","ID = ?",array($ID));
            }
        }
    }