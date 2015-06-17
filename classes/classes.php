<?php
    class classes{
        public static function newClass(){
            $PANEL = '<div id="newUser" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Class</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Class Name
                                            </span>
                                            <input type="text" name="USER_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create Class</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            return $PANEL;
        }
        
        public static function editClass(){
            $PANEL = '<div id="editUser" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Class - <span id="CLASS_NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="?'.$_SERVER['QUERY_STRING'].'">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Class Name
                                            </span>
                                            <input type="password" class="form-control">
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
            $DB->query("SELECT ID,CLASS_NAME,LAST_MODIFIED FROM CLASS ORDER BY ".$_GET['orderBy']." ".$_GET['order']);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['ID'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                $TBODY .= '<td>'.$RESULT['CLASS_NAME'].'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'</td></tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
    }