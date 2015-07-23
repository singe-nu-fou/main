<?php
    class classification{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM classification
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CLASSIFICATION.'</td>
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
                            <form method="POST" action="processes/update.php?page=classification&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <input type="text" name="CLASSIFICATION" class="form-control">
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
            $DB->query("SELECT ID AS 'CLASSIFICATION_ID',CLASSIFICATION
                        FROM classification
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Classifications</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=classification&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="CLASSIFICATION['.$CLASSIFICATION_ID.'][CLASSIFICATION_ID]" value="'.$CLASSIFICATION_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Classification
                                       </span>
                                       <input type="text" name="CLASSIFICATION['.$CLASSIFICATION_ID.'][CLASSIFICATION]" value="'.$CLASSIFICATION.'" class="form-control">
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
            $SQL = "SELECT * FROM classification";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserClassification($DATA):
                    $DB->query($SQL." WHERE ID = ? AND CLASSIFICATION = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealClassification($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealClassification($DATA):
                    $DB->query($SQL." WHERE CLASSIFICATION = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function getClassificationCharacteristic($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $DB->query("SELECT category_has_classification.ID AS CATEGORY_HAS_CLASSIFICATION_ID FROM category_has_classification LEFT JOIN classification ON CLASSIFICATION_ID = classification.ID WHERE CATEGORY_ID = ? AND classification.ID = ?",array($CATEGORY_ID,$CLASSIFICATION_ID));
            if($DATA = $DB->fetch_assoc()){
                extract($DATA);
            }
            if(isset($CATEGORY_HAS_CLASSIFICATION_ID)){
                $DB->query("SELECT characteristic.ID,CHARACTERISTIC FROM classification_has_characteristic LEFT JOIN characteristic ON CHARACTERISTIC_ID = characteristic.ID WHERE CATEGORY_HAS_CLASSIFICATION_ID = ? ORDER BY SEQUENCE",array($CATEGORY_HAS_CLASSIFICATION_ID));
                return $DB->fetch_assoc_all();
            }
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
                    $DB->query("SELECT * FROM classification WHERE ID = ? AND CLASSIFICATION = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM classification WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM classification WHERE CLASSIFICATION = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealClassification(array('NAME'=>$CLASSIFICATION))){
                $_SESSION[CLIENT]['ERROR_MSG'] = 'Classifications cannot be the same as an existing type.';
                return;
            }
            $DB = portal::database();
            $DB->insert("classification",array("CLASSIFICATION"=>$CLASSIFICATION));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($CLASSIFICATION AS $ID=>$CLASSIFICATION){
                if(self::isRealClassification(array('NAME'=>$CLASSIFICATION['CLASSIFICATION']))){
                    $_SESSION[CLIENT]['ERROR_MSG'] = 'Classifications cannot be the same as an existing type.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("classification",array("CLASSIFICATION"=>$CLASSIFICATION['CLASSIFICATION'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("classification","ID = ?",array($ID));
                $DB->select("ID","category_has_classification","CLASSIFICATION_ID = ?",array($ID));
                $CHC_IDS = $DB->fetch_assoc_all();
                $DB->delete("category_has_classification","CLASSIFICATION_ID = ?",array($ID));
                foreach($CHC_IDS AS $KEY=>$VALUE){
                    $DB->delete("classification_has_characteristic","CATEGORY_HAS_CLASSIFICATION_ID = ?",array($VALUE['ID']));
                }
            }
        }
    }