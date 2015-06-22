<?php
    require_once('classifications.php');
    require_once('types.php');
    require_once('attributes.php');

    class templates{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT TEMPLATES.ID,
                        TEMPLATE_NAME,
                        CLASS_NAME,
                        TYPE_NAME,
                        TEMPLATES.LAST_MODIFIED
                        FROM TEMPLATES
                        LEFT JOIN CLASSES ON CLASS_ID = CLASSES.ID
                        LEFT JOIN TYPES ON TYPE_ID = TYPES.ID
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$TEMPLATE_NAME.'</td>
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
                            <form method="POST" action="libraries/update.php?page=templates&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Classification
                                            </span>
                                            <select name="CLASS_ID" class="form-control">';
            $CLASSIFICATIONS = classifications::getClassification();
            foreach($CLASSIFICATIONS AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$CLASS_NAME.'</option>';
            }
            $PANEL .= '</select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select name="TYPE_ID" class="form-control">';
            $TYPES = types::getType();
            foreach($TYPES AS $VALUE){
                extract($VALUE);
                $PANEL .= '<option value="'.$ID.'">'.$TYPE_NAME.'</option>';
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
                                            <select name="ATTRIBUTE_ID['.$i.']" class="form-control">';
            $ATTRIBUTES = attributes::getAttribute();
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
                $DB->query("SELECT TEMPLATE_NAME,
                        CLASS_NAME,
                        TYPE_NAME,
                        GROUP_CONCAT(ATTRIBUTE_NAME) AS 'ATTRIBUTE_NAME'
                        FROM TEMPLATES
                        LEFT JOIN CLASSES ON CLASSES.ID = CLASS_ID
                        LEFT JOIN TYPES ON TYPES.ID = TYPE_ID
                        LEFT JOIN TEMPLATE_ATTRIBUTES ON TEMPLATES.ID = TEMPLATE_ID
                        LEFT JOIN ATTRIBUTES ON ATTRIBUTES.ID = ATTRIBUTE_ID
                        WHERE TEMPLATES.ID = ".$ID);
                $RESULTS = $DB->fetch_assoc_all();
                foreach($RESULTS AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<div class="row" style="padding-bottom:15px;">';
                    $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Template
                                       </span>
                                       <input type="text" value="'.$TEMPLATE_NAME.'" class="form-control" disabled>
                                   </div>
                               </div>
                               <div class="col-lg-6 col-lg-offset-3">
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
                    $ATTRIBUTES = explode(',',$ATTRIBUTE_NAME);
                    foreach($ATTRIBUTES AS $KEY=>$ATTRIBUTE){
                        $PANEL .= '<div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute '.($KEY+1).'
                                            </span>
                                            <input type="text" value="'.$ATTRIBUTE.'" class="form-control" disabled>
                                        </div>
                                    </div>';
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
        
        public static function getTemplate($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM TEMPLATES";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserTemplate($DATA):
                    $DB->query($SQL." WHERE ID = ? AND TEMPLATE_NAME = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealTemplate($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealTemplate($DATA):
                    $DB->query($SQL." WHERE TEMPLATE_NAME = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function isRealTemplate($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM TEMPLATES WHERE ID = ? AND TEMPLATE_NAME = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM TEMPLATES WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM TEMPLATES WHERE TEMPLATE_NAME = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            $DB = portal::database();
            extract($DATA['POST']);
            extract(classifications::getClassification(array('ID'=>$CLASS_ID)));
            extract(types::getType(array('ID'=>$TYPE_ID)));
            if(self::isRealTemplate(array('NAME'=>$CLASS_NAME.'/'.$TYPE_NAME))){
                $_SESSION['ERROR_MSG'] = 'Template cannot be the same as an existing template.';
                return;
            }
            $DB->insert("TEMPLATES",array("TEMPLATE_NAME"=>$CLASS_NAME.'/'.$TYPE_NAME,"CLASS_ID"=>$CLASS_ID,"TYPE_ID"=>$TYPE_ID));
            $DB->select("ID AS 'TEMPLATE_ID'","TEMPLATES","TEMPLATE_NAME = ?",array($CLASS_NAME.'/'.$TYPE_NAME));
            extract($DB->fetch_assoc());
            foreach($ATTRIBUTE_ID AS $KEY=>$VALUE){
                $DB->insert("TEMPLATE_ATTRIBUTES",array("TEMPLATE_ID"=>$TEMPLATE_ID,"ATTRIBUTE_ID"=>$VALUE,"SEQUENCE"=>$KEY));
            }
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($TEMPLATES AS $ID=>$TEMPLATE){
                if(self::isRealTemplate(array('NAME'=>$TEMPLATE['TEMPLATE_NAME']))){
                    $_SESSION['ERROR_MSG'] = 'Templates cannot be the same as an existing classification.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("TEMPLATES",array("TEMPLATE_NAME"=>$TEMPLATE['TEMPLATE_NAME'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("TEMPLATES","ID = ?",array($ID));
                $DB->delete("TEMPLATE_ATTRIBUTES","TEMPLATE_ID = ?",array($ID));
            }
        }
    }