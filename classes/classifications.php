<?php
    class classifications{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM CLASSES
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CLASS_NAME.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Classification</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=classifications&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <input type="text" name="CLASS_NAME" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Classification</button>
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
                $SQL_CONCAT[] = " ID = ? ";
            }
            $DB->query("SELECT ID AS 'CLASS_ID',CLASS_NAME
                        FROM CLASSES
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Classifications</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=classifications&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="CLASSES['.$CLASS_ID.'][CLASS_ID]" value="'.$CLASS_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Classification
                                       </span>
                                       <input type="text" name="CLASSES['.$CLASS_ID.'][CLASS_NAME]" value="'.$CLASS_NAME.'" class="form-control">
                                   </div>
                               </div>
                           </div>';
            }
            $PANEL .= '     <div class="row">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <button type="submit" class="btn btn-default form-control">Update Classifications</button>
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
        
        public static function getClassification($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM CLASSES";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ? AND CLASS_NAME = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealClassification($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealClassification($DATA):
                    $DB->query($SQL." WHERE CLASS_NAME = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealClassification($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM CLASSES WHERE ID = ? AND CLASS_NAME = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM CLASSES WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM CLASSES WHERE CLASS_NAME = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealClassification(array('NAME'=>$CLASS_NAME)) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$CLASS_NAME)){
                $_SESSION['ERROR_MSG'] = 'Classifications cannot contain special characters, and cannot be the same as an existing classification.';
                return;
            }
            $DB = portal::database();
            $DB->insert("CLASSES",array("CLASS_NAME"=>$CLASS_NAME));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($CLASSES AS $ID=>$CLASS){
                if(self::isRealClassification(array('NAME'=>$CLASS['CLASS_NAME'])) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$CLASS['CLASS_NAME'])){
                    $_SESSION['ERROR_MSG'] = 'Classifications cannot contain special characters, and cannot be the same as an existing classification.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("CLASSES",array("CLASS_NAME"=>$CLASS['CLASS_NAME'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("CLASSES","ID = ?",array($ID));
            }
        }
    }