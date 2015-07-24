<?php
    class inventory_review{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT inventory.ID,
                        SKU,
                        CATEGORY,
                        CLASSIFICATION,
                        WEIGHT,
                        USER_NAME,
                        DATE_CREATED,
                        inventory.LAST_MODIFIED
                        FROM inventory 
                        LEFT JOIN category ON CATEGORY_ID = category.ID 
                        LEFT JOIN classification ON CLASSIFICATION_ID = classification.ID
                        LEFT JOIN inventory_worked_by ON inventory.ID = INVENTORY_ID
                        LEFT JOIN user_account ON USER_ACCOUNT_ID = user_account.ID
                        LEFT JOIN user_name ON USER_NAME_ID = user_name.ID
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" style="display:none;" value="'.$ID.'">'.$SKU.'</td>
                               <td>'.$CATEGORY.'</td>
                               <td>'.$CLASSIFICATION.'</td>
                               <td>'.$WEIGHT.'</td>
                               <td>'.$USER_NAME.'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($DATE_CREATED)).'</td>
                               <td>'.date('l, F Y h:i:sA',strtotime($LAST_MODIFIED)).'</td>
                           </tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function edit(){
            $DB = portal::database();
            extract($_GET);
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $SQL_CONCAT[] = " inventory.ID = ? ";
            }
            $DB->query("SELECT inventory.ID AS 'INVENTORY_ID',
                        SKU,
                        CATEGORY_ID,
                        CLASSIFICATION_ID,
                        inventory.WEIGHT,
                        CHARACTERISTICS
                        FROM inventory 
                        LEFT JOIN category ON CATEGORY_ID = category.ID 
                        LEFT JOIN classification ON CLASSIFICATION_ID = classification.ID
                        LEFT JOIN inventory_characteristic ON inventory.ID = INVENTORY_ID
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $INVENTORY = $DB->fetch_assoc_all();
            $CATEGORIES = portal::warp('category','getCategory');
            $CLASSIFICATIONS = portal::warp('classification','getClassification');
            $PANEL = '<div class="panel panel-default">
                          <form method="POST" action="processes/update.php?page=inventoryReview&action=update">
                          <div class="panel-heading">
                              Edit Inventory
                          </div>';
            foreach($INVENTORY AS $KEY=>$VALUE){
                extract($VALUE);
                $DEFAULT_CHARACTERISTIC = portal::warp('classification','getClassificationCharacteristic',array('CATEGORY_ID'=>$CATEGORY_ID,'CLASSIFICATION_ID'=>$CLASSIFICATION_ID));
                $CHARACTERISTICS = json_decode($CHARACTERISTICS);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Category
                                       </span>
                                       <select class="form-control">';
                foreach($CATEGORIES AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<option value="'.$ID.'"'.(($ID === $CATEGORY_ID) ? ' selected' : '').'>'.$CATEGORY.'</option>';
                }
                $PANEL .=             '</select>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Classification
                                       </span>
                                       <select class="form-control">';
                foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<option value="'.$ID.'"'.(($ID === $CLASSIFICATION_ID) ? ' selected' : '').'>'.$CLASSIFICATION.'</option>';
                }
                $PANEL .=             '</select>
                                   </div>
                               </div>';
                $PANEL .=     '<div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Condition
                                       </span>
                                       <select name="inventory[Condition]" class="inventory-control form-control">';
                                        $OPTIONS = array(
                                            'New',
                                            'Pre-Owned',
                                            'Damaged'
                                        );
                                        foreach($OPTIONS AS $OPTION){
                                            $PANEL .= '<option value="'.$OPTION.'"'.(($OPTION === $CHARACTERISTICS->Condition) ? ' selected' : '').'>'.$OPTION.'</option>';
                                        }
                $PANEL .=             '</select>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Quantity
                                       </span>
                                       <input type="text" class="form-control" value="'.$CHARACTERISTICS->Quantity.'">
                                   </div>
                               </div>';
                foreach($DEFAULT_CHARACTERISTIC AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           '.$CHARACTERISTIC.'
                                       </span>
                                       <input type="text" class="form-control" value="'.$CHARACTERISTICS->$CHARACTERISTIC.'">
                                   </div>
                               </div>';
                }
                $PANEL .= '    <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           SKU
                                       </span>
                                       <input type="text" class="form-control" value="'.$SKU.'">
                                   </div>
                               </div>
                           </div>';
            }
            $PANEL .= '   <div class="row">
                              <div class="col-xs-3 col-xs-offset-3">
                                  <button type="submit" class="btn btn-default form-control">
                                      Update
                                  </button>
                              </div>
                              <div class="col-xs-3">
                                  <button name="cancel" type="submit" class="btn btn-default form-control">
                                      Cancel
                                  </button>
                              </div>
                          </div>
                          </form>
                      </div>';
            return $PANEL;
        }
        
        public static function filters(){
            return '<button type="button" class="btn btn-default form-control" data-toggle="modal" data-target="#searchModal">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>';
        }
        
        public static function delete($DATA){
            extract($DATA['GET']);
            $DB = portal::database();
            $IDS = json_decode($id);
            foreach($IDS AS $ID){
                $DB->delete("inventory","ID = ?",array($ID));
                $DB->delete("inventory_worked_by","INVENTORY_ID = ?",array($ID));
                $DB->delete("inventory_characteristic","INVENTORY_ID = ?",array($ID));
                $DB->delete("inventory_status","INVENTORY_ID = ?",array($ID));
                $DB->delete("inventory_title","INVENTORY_ID = ?",array($ID));
            }
        }
    }