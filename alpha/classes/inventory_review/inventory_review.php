<?php
    class inventory_review{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT INVENTORY.ID,
                        SKU,
                        CATEGORY,
                        CLASSIFICATION,
                        WEIGHT,
                        USER_NAME,
                        DATE_CREATED,
                        INVENTORY.LAST_MODIFIED
                        FROM INVENTORY 
                        LEFT JOIN CATEGORY ON CATEGORY_ID = CATEGORY.ID 
                        LEFT JOIN CLASSIFICATION ON CLASSIFICATION_ID = CLASSIFICATION.ID
                        LEFT JOIN INVENTORY_WORKED_BY ON INVENTORY.ID = INVENTORY_ID
                        LEFT JOIN USER_ACCOUNT ON USER_ACCOUNT_ID = USER_ACCOUNT.ID
                        LEFT JOIN USER_NAME ON USER_NAME_ID = USER_NAME.ID
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
                $SQL_CONCAT[] = " INVENTORY.ID = ? ";
            }
            $DB->query("SELECT INVENTORY.ID AS 'INVENTORY_ID',
                        SKU,
                        CATEGORY_ID,
                        CLASSIFICATION_ID,
                        INVENTORY.WEIGHT,
                        CHARACTERISTICS
                        FROM INVENTORY 
                        LEFT JOIN CATEGORY ON CATEGORY_ID = CATEGORY.ID 
                        LEFT JOIN CLASSIFICATION ON CLASSIFICATION_ID = CLASSIFICATION.ID
                        LEFT JOIN INVENTORY_CHARACTERISTIC ON INVENTORY.ID = INVENTORY_ID
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
        
        public static function delete(){
            
        }
    }