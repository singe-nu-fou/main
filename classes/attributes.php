<?php
    class attributes{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM ATTRIBUTES
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$ATTRIBUTE_NAME.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Attribute</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=attributes&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute
                                            </span>
                                            <input type="text" name="ATTRIBUTE_NAME" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Attribute</button>
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
                $SQL_CONCAT[] = " ATTRIBUTES.ID = ? ";
            }
            $DB->query("SELECT ID AS 'ATTRIBUTES_ID',ATTRIBUTE_NAME
                        FROM ATTRIBUTES
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Attribute</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=attributes&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="ATTRIBUTES['.$ATTRIBUTES_ID.'][ATTRIBUTES_ID]" value="'.$ATTRIBUTES_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Attribute
                                       </span>
                                       <input type="text" name="ATTRIBUTES['.$ATTRIBUTES_ID.'][ATTRIBUTE_NAME]" value="'.$ATTRIBUTE_NAME.'" class="form-control">
                                   </div>
                               </div>
                           </div>';
            }
            $PANEL .= '     <div class="row">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <button type="submit" class="btn btn-default form-control">Update Attributes</button>
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
        
        public static function getUserAttribute($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM ATTRIBUTES";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserAttribute($DATA):
                    $DB->query($SQL." WHERE ID = ? AND ATTRIBUTE_NAME = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealUserAttribute($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealUserAttribute($DATA):
                    $DB->query($SQL." WHERE ATTRIBUTE_NAME = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealUserAttribute($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM ATTRIBUTES WHERE ID = ? AND ATTRIBUTE_NAME = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM ATTRIBUTES WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM ATTRIBUTES WHERE ATTRIBUTE_NAME = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealUserAttribute(array('NAME'=>$ATTRIBUTE_NAME)) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$ATTRIBUTE_NAME)){
                $_SESSION['ERROR_MSG'] = 'Attributes cannot contain special characters, and cannot be the same as an existing attribute.';
                return;
            }
            $DB = portal::database();
            $DB->insert("ATTRIBUTES",array("ATTRIBUTE_NAME"=>$ATTRIBUTE_NAME));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($ATTRIBUTES AS $ID=>$ATTRIBUTE){
                if(self::isRealUserAttribute(array('NAME'=>$ATTRIBUTE['ATTRIBUTE_NAME'])) || preg_match('/[\'^£$%&*()}{@#~?><>,.|=+¬-]/',$ATTRIBUTE['ATTRIBUTE_NAME'])){
                    $_SESSION['ERROR_MSG'] = 'Attributes cannot contain special characters, and cannot be the same as an existing attribute.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("ATTRIBUTES",array("ATTRIBUTE_NAME"=>$ATTRIBUTE['ATTRIBUTE_NAME'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("ATTRIBUTES","ID = ?",array($ID));
            }
        }
    }