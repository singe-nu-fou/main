<?php
    class mapping{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT 
                        category_has_classification.ID,
                        CATEGORY,
                        classification.CLASSIFICATION,
                        category_has_classification.LAST_MODIFIED
                        FROM category_has_classification 
                        JOIN category ON category_has_classification.CATEGORY_ID = category.ID 
                        JOIN classification ON category_has_classification.CLASSIFICATION_ID = classification.ID 
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CATEGORY.'</td>
                               <td>'.$CLASSIFICATION.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $DB = portal::database();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Template</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=mapping&action=insert">
                                <div id="dataRow" class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Category
                                            </span>
                                            <select id="MAP_CLASS" name="mapping[CATEGORY_ID]" class="mapping-control form-control">
                                                <option></option>';
            $CATEGORY = portal::warp('category','getCategory');
            foreach($CATEGORY AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_GET['category']) && $ID === $_GET['category']) ? ' selected' : '').'>'.$CATEGORY.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>';
            if(isset($_GET['category'])){
                                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <select id="MAP_TYPE" name="mapping[CLASSIFICATION_ID]" class="mapping-control form-control">
                                                <option></option>';
            $CLASSIFICATION = portal::warp('classification','getClassification');
            foreach($CLASSIFICATION AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_GET['classification']) && $ID === $_GET['classification']) ? ' selected' : '').'>'.$CLASSIFICATION.'</option>';
            }
            $PANEL .= '                     </select>
                                        </div>';
            }
            $PANEL .= '             </div>';

            if(isset($_GET['category']) && isset($_GET['classification'])){
                $DEFAULT_CHARACTERISTICS = portal::warp('characteristic','getCharacteristic');
                $DB->query('SELECT
                            CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',characteristic.ID,\'"\',\':"\',characteristic.CHARACTERISTIC,\'"\')),\'}\') AS CHARACTERISTICS
                            FROM category_has_classification 
                            JOIN classification_has_characteristic ON category_has_classification.ID = CATEGORY_HAS_CLASSIFICATION_ID
                            JOIN category ON CATEGORY_ID = category.ID
                            JOIN classification ON CLASSIFICATION_ID = classification.ID
                            JOIN characteristic ON CHARACTERISTIC_ID = characteristic.ID
                            WHERE category.ID = ? AND classification.ID = ?',array($_GET['category'],$_GET['classification']));
                $RESULT = $DB->FETCH_ASSOC();
                if($RESULT['CHARACTERISTICS']){
                    $CHARACTERISTICS = json_decode($RESULT['CHARACTERISTICS']);
                    foreach($CHARACTERISTICS AS $KEY=>$VALUE){
                        $PANEL .= ' <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Characteristic
                                            </span>
                                            <select class="form-control" name="mapping[CHARACTERISTIC_ID][]">
                                                <option></option>';
                        foreach($DEFAULT_CHARACTERISTICS AS $CHARACTERISTIC){
                            extract($CHARACTERISTIC);
                            $PANEL .= '         <option value="'.$ID.'"'.(($ID === $KEY) ? ' selected' : '').'>'.$CHARACTERISTIC.'</option>';
                        }
                        $PANEL .= '         </select>
                                            <span class="input-group-btn">
                                                <button type="button" class="removeCharacteristic btn btn-default">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>';
                    }
                }

            }
            $PANEL .= '     </div>
                                <div class="row">';
            if(isset($_GET['category']) && isset($_GET['classification'])){
                $PANEL .= '         <div class="col-lg-2 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Template</button>
                                    </div>
                                    <div class="col-lg-2">
                                         <button id="addCharacteristic" type="button" class="btn btn-default form-control">Add Characteristic</button>
                                    </div>';
            }
            $PANEL .= '             <div class="'.((isset($_GET['category']) && isset($_GET['classification'])) ? 'col-lg-2' : 'col-lg-2 col-lg-offset-3').'">
                                        <button name="cancel" type="submit" class="btn btn-default form-control">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            return $PANEL;
        }
        
        public static function view(){
            $DB = portal::database();
            extract($_GET);
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">View Templates</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=templates&action=update">';
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->query('SELECT
                            category_has_classification.ID,
                            category.ID,
                            category.CATEGORY,
                            classification.ID,
                            classification.CLASSIFICATION,
                            CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',characteristic.ID,\'"\',\':"\',characteristic.CHARACTERISTIC,\'"\')),\'}\') AS CHARACTERISTICS
                            FROM category_has_classification 
                            JOIN classification_has_characteristic ON category_has_classification.ID = CATEGORY_HAS_CLASSIFICATION_ID
                            JOIN category ON CATEGORY_ID = category.ID
                            JOIN classification ON CLASSIFICATION_ID = classification.ID
                            JOIN characteristic ON CHARACTERISTIC_ID = characteristic.ID
                            WHERE category_has_classification.ID = ?',array($ID));
                $RESULTS = $DB->fetch_assoc_all();
                foreach($RESULTS AS $KEY=>$VALUE){
                    var_dump($RESULTS);
                    extract($VALUE);
                    $PANEL .= '<div class="row" style="padding-bottom:15px;">';
                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Classification
                                       </span>
                                       <input type="text" value="'.$CATEGORY.'" class="form-control" disabled>
                                   </div>
                               </div>
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Type
                                       </span>
                                       <input type="text" value="'.$CLASSIFICATION.'" class="form-control" disabled>
                                   </div>
                               </div>';
                    $CHARACTERISTICS = json_decode($CHARACTERISTICS);
                    if($CHARACTERISTICS){
                        foreach($CHARACTERISTICS AS $KEY=>$CHARACTERISTIC){
                            $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    Characteristic
                                                </span>
                                                <input type="text" value="'.$CHARACTERISTIC.'" class="form-control" disabled>
                                            </div>
                                        </div>';
                        }
                    }
                }
                $PANEL .= "</div>";
            }
            $PANEL .= '     <div class="row">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button name="cancel" type="submit" class="btn btn-default form-control">Close View</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>';
            return $PANEL;
        }
        
        public static function insert($DATA){
            foreach($DATA['POST']['mapping']['CHARACTERISTIC_ID'] AS $KEY=>$VALUE){
                if(strlen(trim($VALUE)) === 0){
                    $_SESSION['ERROR_MSG'] = 'Bad value in characterisitcs.';
                    return;
                }
            }
            $DB = portal::database();
            extract($DATA['POST']['mapping']);
            $DB->select("*","category_has_classification","CATEGORY_ID = ? AND CLASSIFICATION_ID = ?",array($CATEGORY_ID,$CLASSIFICATION_ID));
            if($EXISTS = $DB->fetch_assoc()){
                $DB->delete("category_has_classification","ID = ?",array($EXISTS['ID']));
                $DB->delete("classification_has_characteristic","CATEGORY_HAS_CLASSIFICATION_ID = ?",array($EXISTS['ID']));
            }
            $DB->insert("category_has_classification",array("CATEGORY_ID"=>$CATEGORY_ID,"CLASSIFICATION_ID"=>$CLASSIFICATION_ID));
            $DB->select("ID AS 'CATEGORY_HAS_CLASSIFICATION_ID'","category_has_classification","CATEGORY_ID = ? AND CLASSIFICATION_ID = ?",array($CATEGORY_ID,$CLASSIFICATION_ID));
            extract($DB->fetch_assoc());
            foreach($CHARACTERISTIC_ID AS $KEY=>$VALUE){
                $DB->insert("classification_has_characteristic",array("CATEGORY_HAS_CLASSIFICATION_ID"=>$CATEGORY_HAS_CLASSIFICATION_ID,"CHARACTERISTIC_ID"=>$VALUE,"SEQUENCE"=>$KEY));
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("category_has_classification","ID = ?",array($ID));
                $DB->delete("classification_has_characteristic","CATEGORY_HAS_CLASSIFICATION_ID = ?",array($ID));
            }
        }
        
        public static function selectCharacteristic($ECHO = TRUE){
            $DEFAULT_CHARACTERISTICS = portal::warp('characteristic','getCharacteristic');
            $SELECT = ' <div class="col-lg-6 col-lg-offset-3">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Characteristic
                                </span>
                                <select class="form-control" name="mapping[CHARACTERISTIC_ID][]">
                                    <option></option>';
            foreach($DEFAULT_CHARACTERISTICS AS $CHARACTERISTIC){
                extract($CHARACTERISTIC);
                $SELECT .= '        <option value="'.$ID.'">'.$CHARACTERISTIC.'</option>';
            }
            $SELECT .= '        </select>
                                <span class="input-group-btn">
                                    <button type="button" class="removeCharacteristic btn btn-default">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </span>
                            </div>
                        </div>';
            if(!$ECHO){
                return $SELECT;
            }
            echo $SELECT;
        }
    }