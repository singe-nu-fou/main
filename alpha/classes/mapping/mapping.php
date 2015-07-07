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
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Template</div>
                        <div class="panel-body">
                            <div class="row" style="padding-bottom:15px;">
                                <form action="" method="post">
                                    <input id="hidden_category" type="hidden" name="CATEGORY_ID" value="'.((isset($_POST['CATEGORY_ID'])) ? $_POST['CATEGORY_ID'] : '').'">
                                    <input id="hidden_classification" type="hidden" name="CLASSIFICATION_ID" value="'.((isset($_POST['CLASSIFICATION_ID'])) ? $_POST['CLASSIFICATION_ID'] : '').'">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                # of Characteristics
                                            </span>
                                            <input type="text" name="CHARACTERISTIC_COUNT" value="'.((isset($_POST['CHARACTERISTIC_COUNT'])) ? $_POST['CHARACTERISTIC_COUNT'] : 0).'" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">Update</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form method="POST" action="processes/update.php?page=mapping&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Category
                                            </span>
                                            <select id="MAP_CLASS" name="CATEGORY_ID" class="map_control form-control">';
            $CATEGORY = portal::warp('category','getCategory');
            foreach($CATEGORY AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_POST['CATEGORY_ID']) && $ID === $_POST['CATEGORY_ID']) ? ' selected' : '').'>'.$CATEGORY.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <select id="MAP_TYPE" name="CLASSIFICATION_ID" class="map_control form-control">';
            $CLASSIFICATION = portal::warp('classification','getClassification');
            foreach($CLASSIFICATION AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_POST['CLASSIFICATION_ID']) && $ID === $_POST['CLASSIFICATION_ID']) ? ' selected' : '').'>'.$CLASSIFICATION.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>';
            if(isset($_POST['CHARACTERISTIC_COUNT']) && is_int(intval($_POST['CHARACTERISTIC_COUNT']))){
                for($i = 0; $i !== intval($_POST['CHARACTERISTIC_COUNT']);$i++){
                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Characteristic
                                            </span>
                                            <select name="CHARACTERISTIC_ID['.$i.']" class="characteristic_control form-control">';
            $CHARACTERISTICS = portal::warp('characteristic','getCharacteristic');
            foreach($CHARACTERISTICS AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$CHARACTERISTIC.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>';
                }
            }
                                $PANEL .= '</div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Template</button>
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
                            CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',characteristics.ID,\'"\',\':"\',characteristics.CHARACTERISTIC_NAME,\'"\')),\'}\') AS CHARACTERISTICS
                            FROM category_has_classification 
                            JOIN classification_has_characteristics AS THA ON CATEGORY_HAS_CLASSIFICATION.ID = THA.CATEGORY_HAS_CLASSIFICATION_ID 
                            JOIN category ON category_has_classification.CATEGORY_ID = category.ID 
                            JOIN classification ON category_has_classification.CLASSIFICATION_ID = classification.ID 
                            JOIN characteristics ON THA.CHARACTERISTIC_ID = characteristics.ID
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
            $DB = portal::database();
            extract($DATA['POST']);
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
    }