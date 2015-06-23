<?php
    require_once('classifications.php');
    require_once('types.php');
    require_once('attributes.php');

    class mapping{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT 
                        CHT.ID,
                        CLASSES.CLASS_NAME,
                        TYPES.TYPE_NAME,
                        CHT.LAST_MODIFIED
                        FROM CLASSES_HAS_TYPES AS CHT 
                        JOIN CLASSES ON CHT.CLASS_ID = CLASSES.ID 
                        JOIN TYPES ON CHT.TYPE_ID = TYPES.ID 
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CLASS_NAME.'</td>
                               <td>'.$TYPE_NAME.'</td>
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
                                    <input id="hidden_class" type="hidden" name="CLASS_ID" value="'.((isset($_POST['CLASS_ID'])) ? $_POST['CLASS_ID'] : '').'">
                                    <input id="hidden_type" type="hidden" name="TYPE_ID" value="'.((isset($_POST['TYPE_ID'])) ? $_POST['TYPE_ID'] : '').'">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                # of Attributes
                                            </span>
                                            <input type="text" name="ATTRIBUTE_COUNT" value="'.((isset($_POST['ATTRIBUTE_COUNT'])) ? $_POST['ATTRIBUTE_COUNT'] : 0).'" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">Update</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form method="POST" action="libraries/update.php?page=mapping&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <select id="MAP_CLASS" name="CLASS_ID" class="map_control form-control">';
            $CLASSIFICATIONS = portal::warp('classifications','getClassification');
            //$CLASSIFICATIONS = classifications::getClassification();
            foreach($CLASSIFICATIONS AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_POST['CLASS_ID']) && $ID === $_POST['CLASS_ID']) ? ' selected' : '').'>'.$CLASS_NAME.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select id="MAP_TYPE" name="TYPE_ID" class="map_control form-control">';
            $TYPES = portal::warp('types','getType');
            //$TYPES = types::getType();
            foreach($TYPES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'"'.((isset($_POST['TYPE_ID']) && $ID === $_POST['TYPE_ID']) ? ' selected' : '').'>'.$TYPE_NAME.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>';
            if(isset($_POST['ATTRIBUTE_COUNT']) && is_int(intval($_POST['ATTRIBUTE_COUNT']))){
                for($i = 0; $i !== intval($_POST['ATTRIBUTE_COUNT']);$i++){
                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute
                                            </span>
                                            <select name="ATTRIBUTE_ID['.$i.']" class="attribute_control form-control">';
            $ATTRIBUTES = portal::warp('attributes','getAttribute');
            //$ATTRIBUTES = attributes::getAttribute();
            foreach($ATTRIBUTES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$ATTRIBUTE_NAME.'</option>';
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
                            <form method="POST" action="libraries/update.php?page=templates&action=update">';
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->query('SELECT 
                            CHT.ID,
                            CLASSES.ID,
                            CLASSES.CLASS_NAME,
                            TYPES.ID,
                            TYPES.TYPE_NAME,
                            CONCAT(\'{\',GROUP_CONCAT(CONCAT(\'"\',ATTRIBUTES.ID,\'"\',\':"\',ATTRIBUTES.ATTRIBUTE_NAME,\'"\')),\'}\') AS ATTRIBUTES
                            FROM CLASSES_HAS_TYPES AS CHT 
                            JOIN TYPES_HAS_ATTRIBUTES AS THA ON CHT.ID = THA.CHT_ID 
                            JOIN CLASSES ON CHT.CLASS_ID = CLASSES.ID 
                            JOIN TYPES ON CHT.TYPE_ID = TYPES.ID 
                            JOIN ATTRIBUTES ON THA.ATTRIBUTE_ID = ATTRIBUTES.ID
                            WHERE CHT.ID = ?',array($ID));
                $RESULTS = $DB->fetch_assoc_all();
                foreach($RESULTS AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<div class="row" style="padding-bottom:15px;">';
                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Classification
                                       </span>
                                       <input type="text" value="'.$CLASS_NAME.'" class="form-control" disabled>
                                   </div>
                               </div>
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Type
                                       </span>
                                       <input type="text" value="'.$TYPE_NAME.'" class="form-control" disabled>
                                   </div>
                               </div>';
                    $ATTRIBUTES = json_decode($ATTRIBUTES);
                    if($ATTRIBUTES){
                        foreach($ATTRIBUTES AS $KEY=>$ATTRIBUTE){
                            $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    Attribute
                                                </span>
                                                <input type="text" value="'.$ATTRIBUTE.'" class="form-control" disabled>
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
            //extract(classifications::getClassification(array('ID'=>$CLASS_ID)));
            //extract(types::getType(array('ID'=>$TYPE_ID)));
            $DB->select("*","CLASSES_HAS_TYPES","CLASS_ID = ? AND TYPE_ID = ?",array($CLASS_ID,$TYPE_ID));
            if($EXISTS = $DB->fetch_assoc()){
                $DB->delete("CLASSES_HAS_TYPES","ID = ?",array($EXISTS['ID']));
                $DB->delete("TYPES_HAS_ATTRIBUTES","CHT_ID = ?",array($EXISTS['ID']));
            }
            $DB->insert("CLASSES_HAS_TYPES",array("CLASS_ID"=>$CLASS_ID,"TYPE_ID"=>$TYPE_ID));
            $DB->select("ID AS 'CHT_ID'","CLASSES_HAS_TYPES","CLASS_ID = ? AND TYPE_ID = ?",array($CLASS_ID,$TYPE_ID));
            extract($DB->fetch_assoc());
            foreach($ATTRIBUTE_ID AS $KEY=>$VALUE){
                $DB->insert("TYPES_HAS_ATTRIBUTES",array("CHT_ID"=>$CHT_ID,"ATTRIBUTE_ID"=>$VALUE,"SEQUENCE"=>$KEY));
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("CLASSES_HAS_TYPES","ID = ?",array($ID));
                $DB->delete("TYPES_HAS_ATTRIBUTES","CHT_ID = ?",array($ID));
            }
        }
    }