<?php
    class category{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT *
                        FROM CATEGORY
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" value="'.$ID.'" style="display:none;">'.$ID.'</td>
                               <td>'.$CATEGORY.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Category</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=category&action=insert">
                                <div class="row" style="padding-bottom:15px;">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Category
                                            </span>
                                            <input type="text" name="CATEGORY" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <button type="submit" class="btn btn-default form-control">Create Category</button>
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
            $DB->query("SELECT ID AS 'CATEGORY_ID',CATEGORY
                        FROM CATEGORY
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $RESULTS = $DB->fetch_assoc_all();
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Categorys</div>
                        <div class="panel-body">
                            <form method="POST" action="processes/update.php?page=category&action=update">';
            foreach($RESULTS AS $KEY=>$VALUE){
                extract($VALUE);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <input type="hidden" name="CATEGORY['.$CATEGORY_ID.'][CATEGORY_ID]" value="'.$CATEGORY_ID.'">
                               <div class="col-lg-6 col-lg-offset-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Category
                                       </span>
                                       <input type="text" name="CATEGORY['.$CATEGORY_ID.'][CATEGORY]" value="'.$CATEGORY.'" class="form-control">
                                   </div>
                               </div>
                           </div>';
            }
            $PANEL .= '     <div class="row">
                                <div class="col-lg-3 col-lg-offset-3">
                                    <button type="submit" class="btn btn-default form-control">Update Categorys</button>
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
        
        public static function getCategory($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $SQL = "SELECT * FROM CATEGORY";
            switch(true){
                case isset($ID) && isset($NAME) && self::isRealUserType($DATA):
                    $DB->query($SQL." WHERE ID = ? AND CATEGORY = ?",array($ID,$NAME));
                    return $DB->fetch_assoc();
                case isset($ID) && self::isRealCategory($DATA):
                    $DB->query($SQL." WHERE ID = ?",array($ID));
                    return $DB->fetch_assoc();
                case isset($NAME) && self::isRealCategory($DATA):
                    $DB->query($SQL." WHERE CATEGORY = ?",array($NAME));
                    return $DB->fetch_assoc();
                default:
                    $DB->query($SQL);
                    return $DB->fetch_assoc_all();
            }
            return NULL;
        }
        
        public static function getCategoryClassification($DATA = NULL){
            if($DATA !== NULL){
                extract($DATA);
            }
            $DB = portal::database();
            $DB->query("SELECT CLASSIFICATION.ID,CLASSIFICATION FROM CATEGORY_HAS_CLASSIFICATION LEFT JOIN CATEGORY ON CATEGORY_ID = CATEGORY.ID LEFT JOIN CLASSIFICATION ON CLASSIFICATION.ID = CLASSIFICATION.ID WHERE CATEGORY.ID = ?",array($ID));
            return $DB->fetch_assoc_all();
        }
        
        public static function isRealCategory($DATA){
            if($DATA !== NULL){
                extract($DATA);
            }
            else{
                return false;
            }
            $DB = portal::database();
            switch(true){
                case isset($ID) && isset($NAME):
                    $DB->query("SELECT * FROM CATEGORY WHERE ID = ? AND CATEGORY = ?",array($ID,$NAME));
                    break;
                case isset($ID):
                    $DB->query("SELECT * FROM CATEGORY WHERE ID = ?",array($ID));
                    break;
                case isset($NAME):
                    $DB->query("SELECT * FROM CATEGORY WHERE CATEGORY = ?",array($NAME));
                    break;
            }
            if($DB->fetch_assoc()){
                return true;
            }
            return false;
        }
        
        public static function insert($DATA){
            extract($DATA['POST']);
            if(self::isRealCategory(array('NAME'=>$CATEGORY))){
                $_SESSION['ERROR_MSG'] = 'Categorys cannot be the same as an existing category.';
                return;
            }
            $DB = portal::database();
            $DB->insert("CATEGORY",array("CATEGORY"=>$CATEGORY));
        }
        
        public static function update($DATA){
            extract($DATA['POST']);
            foreach($CATEGORY AS $ID=>$CATEGORY){
                if(self::isRealCategory(array('NAME'=>$CATEGORY['CATEGORY']))){
                    $_SESSION['ERROR_MSG'] = 'Categorys cannot be the same as an existing category.';
                }
                else{
                    $DB = portal::database();
                    $DB->update("CATEGORY",array("CATEGORY"=>$CATEGORY['CATEGORY'],"LAST_MODIFIED"=>date('Y-m-d H:i:s')),"ID = ?",array($ID));
                }
            }
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("CATEGORY","ID = ?",array($ID));
            }
        }
    }