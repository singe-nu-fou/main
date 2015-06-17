<?php
    class users{
        public static function newUser(){
            $PANEL = '<div id="newUser" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New User</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php">
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
                                            <select name="USER_TYPE" class="form-control">';
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
                        <div class="panel-heading">Edit User</div>
                        <div class="panel-body">
                            <form method="POST" action="?'.$_SERVER['QUERY_STRING'].'">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                New Password
                                            </span>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Confrim Pass.
                                            </span>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Old Password
                                            </span>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select class="form-control">';
            $USER_TYPES = portal::getUserTypes();
            foreach($USER_TYPES AS $KEY=>$VALUE){
                $PANEL .= '<option value="'.$VALUE['ID'].'">'.$VALUE['USER_TYPE'].'</option>';
            }                      
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-4">
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
            $DB->query("SELECT USER_ACCOUNTS.ID,USER_NAME,USER_TYPE,USER_LOGIN FROM USER_ACCOUNTS JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID ORDER BY ".$_GET['orderBy']." ".$_GET['order']);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['ID'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_NAME'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_TYPE'].'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['USER_LOGIN'])).'</td></tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
    }