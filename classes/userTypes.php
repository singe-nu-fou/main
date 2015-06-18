<?php
    class userTypes{
        public static function newUserType(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User Type</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=userTypes&action=new">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                User Type Name
                                            </span>
                                            <input type="text" name="USER_TYPE_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create User Type</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function editUserType(){
            $PANEL = '<div id="edit" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit User Type - <span id="NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="?'.$_SERVER['QUERY_STRING'].'">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                User Type Name
                                            </span>
                                            <input name="USER_TYPE_NAME" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button class="btn btn-default form-control">Edit User Type Name</button>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function getTBODY(){
            $DB = portal::database();
            $DB->query("SELECT ID,USER_TYPE_NAME,LAST_MODIFIED FROM USER_TYPES ORDER BY ? ?",array($_GET['orderBy'],$_GET['order']));
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['USER_TYPE_NAME'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_TYPE_NAME'].'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'</td></tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function insertUserType($DATA){
            $USER = array(
                'USER_TYPE_NAME'=>NULL
            );
            foreach($DATA AS $KEY=>$VALUE){
                $TYPE[$KEY] = $VALUE;
            }
            $DB = portal::database();
            $DB->query("SELECT * FROM USER_TYPES WHERE USER_TYPE_NAME = ?",array($TYPE['USER_TYPE_NAME']));
            if($results = $DB->fetch_assoc()){
                $_SESSION['ERR_MSG'] = "User type already exists!";
            }
            else{
                $DB->query("INSERT INTO USER_TYPES (USER_TYPE_NAME) VALUES (?)",array($TYPE['USER_TYPE_NAME']));
            }
        }
        
        public static function updateUserType($TYPE,$DATA){
            $DB = portal::database();
            $SQL = "UPDATE USER_TYPES SET USER_TYPE_NAME = '".$DATA['USER_TYPE_NAME']."', LAST_MODIFIED = NOW()+0 WHERE USER_TYPE_NAME = '".$TYPE."'";
            $DB->query($SQL);
        }
        
        public static function deleteUserType($TYPES){
            $DB = portal::database();
            $SQL = "DELETE FROM USER_TYPES WHERE ";
            foreach($TYPES AS $KEY=>$VALUE){
                $SQL .= "USER_TYPE_NAME = '".$VALUE."' ".((count($TYPES) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }