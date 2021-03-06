<?php
    class characteristic{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM characteristic
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CHARACTERISTIC.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Characteristic</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=characteristic&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Characteristic
                                            </span>
                                            <input type="text" name="CHARACTERISTIC" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Characteristic</button>
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
                $SQL_CONCAT[] = " characteristic.ID = ? ";
            }
            $DB->query("SELECT ID AS 'CHARACTERISTIC_ID',CHARACTERISTIC
                        FROM characteristic
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Characteristic</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=characteristic&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="CHARACTERISTIC['.$CHARACTERISTIC_ID.'][CHARACTERISTIC_ID]" value="'.$CHARACTERISTIC_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Characteristic
                                       </span>
                                       <input type="text" name="CHARACTERISTIC['.$CHARACTERISTIC_ID.'][CHARACTERISTIC]" value="'.$CHARACTERISTIC.'" class="form-control">
                                   </div>
                               </div>
                           </div>';
            }
            $PANEL .= '     <div class="row">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <button type="submit" class="btn btn-default form-control">Update Characteristics</button>
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
        
        public static function getCharacteristic($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM characteristic";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealCharacteristic($DATA):
                    $DB->query($SQL." WHERE ID = ? AND CHARACTERISTIC = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealCharacteristic($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealCharacteristic($DATA):
                    $DB->query($SQL." WHERE CHARACTERISTIC = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealCharacteristic($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM characteristic WHERE ID = ? AND CHARACTERISTIC = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM characteristic WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM characteristic WHERE CHARACTERISTIC = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealCharacteristic(array('NAME'=>$CHARACTERISTIC))){
                $_SESSION[CLIENT]['ERROR_MSG'] = 'Characteristics cannot be the same as an existing characteristic.';
                return;
            }
            $DB = portal::database();
            $DB->insert("characteristic",array("CHARACTERISTIC"=>$CHARACTERISTIC));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($CHARACTERISTIC AS $ID=>$CHARACTERISTIC){
                if(self::isRealCharacteristic(array('NAME'=>$CHARACTERISTIC['CHARACTERISTIC']))){
                    $_SESSION[CLIENT]['ERROR_MSG'] = 'Characteristics cannot be the same as an existing characteristic.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("characteristic",array("CHARACTERISTIC"=>$CHARACTERISTIC['CHARACTERISTIC'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("characteristic","ID = ?",array($ID));
                $DB->delete("classification_has_characteristic","CHARACTERISTIC_ID = ?",array($ID));
            }
        }
    }