<?php
    class inventoryReview{
        public static function tbody(){
            extract($_GET);
            $DB = portal::database();
            $DB->query('SELECT INVENTORY.ID,
                        CONCAT(SKU,CASE WHEN LOT = 0 THEN "" ELSE LOT END) AS SKU,
                        CLASSES.CLASS_NAME,
                        TYPES.TYPE_NAME,
                        SORTER_NAME.USER_NAME AS SORTER,
                        SKUER_NAME.USER_NAME AS SKUER,
                        PHOTOGRAPHER_NAME.USER_NAME AS PHOTOGRAPHER,
                        CROPPER_NAME.USER_NAME AS CROPPER,
                        LISTER_NAME.USER_NAME AS LISTER,
                        INVENTORY.LAST_MODIFIED
                        FROM INVENTORY 
                        LEFT JOIN CLASSES ON CLASS_ID = CLASSES.ID 
                        LEFT JOIN TYPES ON TYPE_ID = TYPES.ID
                        LEFT JOIN INVENTORY_WORKERS ON INVENTORY.ID = INVENTORY_ID
                        LEFT JOIN USER_ACCOUNT AS SORTER ON SORTER_ID = SORTER.ID
                        LEFT JOIN USER_NAME AS SORTER_NAME ON SORTER.USER_NAME_ID = SORTER_NAME.ID
                        LEFT JOIN USER_ACCOUNT AS SKUER ON SKUER_ID = SKUER.ID
                        LEFT JOIN USER_NAME AS SKUER_NAME ON SKUER.USER_NAME_ID = SKUER_NAME.ID
                        LEFT JOIN USER_ACCOUNT AS PHOTOGRAPHER ON PHOTOGRAPHER_ID = PHOTOGRAPHER.ID
                        LEFT JOIN USER_NAME AS PHOTOGRAPHER_NAME ON PHOTOGRAPHER.USER_NAME_ID = PHOTOGRAPHER_NAME.ID
                        LEFT JOIN USER_ACCOUNT AS CROPPER ON CROPPER_ID = CROPPER.ID
                        LEFT JOIN USER_NAME AS CROPPER_NAME ON CROPPER.USER_NAME_ID = CROPPER_NAME.ID
                        LEFT JOIN USER_ACCOUNT AS LISTER ON LISTER_ID = LISTER.ID
                        LEFT JOIN USER_NAME AS LISTER_NAME ON LISTER.USER_NAME_ID = LISTER_NAME.ID
                        ORDER BY '.$orderBy.' '.$order);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                extract($RESULT);
                $TBODY .= '<tr>
                               <td><input type="checkbox" class="checkbox" style="display:none;" value="'.$ID.'">'.$SKU.'</td>
                               <td>'.$CLASS_NAME.'</td>
                               <td>'.$TYPE_NAME.'</td>
                               <td>'.$SORTER.'</td>
                               <td>'.$SKUER.'</td>
                               <td>'.$CROPPER.'</td>
                               <td>'.$PHOTOGRAPHER.'</td>
                               <td>'.$LISTER.'</td>
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
                        CONCAT(SKU,CASE WHEN LOT = 0 THEN '' ELSE LOT END) AS SKU,
                        CLASS_ID,
                        TYPE_ID,
                        INVENTORY.WEIGHT,
                        ATTRIBUTES
                        FROM INVENTORY 
                        LEFT JOIN CLASSES ON CLASS_ID = CLASSES.ID 
                        LEFT JOIN TYPES ON TYPE_ID = TYPES.ID
                        LEFT JOIN INVENTORY_ATTRIBUTES ON INVENTORY.ID = INVENTORY_ID
                        WHERE ".implode(' OR ',$SQL_CONCAT),$IDS);
            $INVENTORY = $DB->fetch_assoc_all();
            $CLASSIFICATIONS = portal::warp('classifications','getClassification');
            $TYPES = portal::warp('types','getType');
            $PANEL = '<div class="panel panel-default">
                          <form method="POST" action="libraries/update.php?page=inventoryReview&action=update">
                          <div class="panel-heading">
                              Edit Inventory
                          </div>';
            foreach($INVENTORY AS $KEY=>$VALUE){
                extract($VALUE);
                $DEFAULT_ATTRIBUTES = portal::warp('types','getTypeAttribute',array('CLASS_ID'=>$CLASS_ID,'TYPE_ID'=>$TYPE_ID));
                $ATTRIBUTES = json_decode($ATTRIBUTES);
                $PANEL .= '<div class="row" style="padding-bottom:15px;">
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Class
                                       </span>
                                       <select class="form-control">';
                foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<option value="'.$ID.'"'.(($ID === $CLASS_ID) ? ' selected' : '').'>'.$CLASS_NAME.'</option>';
                }
                $PANEL .=             '</select>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Type
                                       </span>
                                       <select class="form-control">';
                foreach($TYPES AS $KEY=>$VALUE){
                    extract($VALUE);
                    $PANEL .= '<option value="'.$ID.'"'.(($ID === $TYPE_ID) ? ' selected' : '').'>'.$TYPE_NAME.'</option>';
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
                                            'Vintage',
                                            'New',
                                            'Pre-Owned',
                                            'Fashion',
                                            'Damaged'
                                        );
                                        foreach($OPTIONS AS $OPTION){
                                            $PANEL .= '<option value="'.$OPTION.'"'.(($OPTION === $ATTRIBUTES->Condition) ? ' selected' : '').'>'.$OPTION.'</option>';
                                        }
                $PANEL .=             '</select>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                           Quantity
                                       </span>
                                       <input type="text" class="form-control" value="'.$ATTRIBUTES->Quantity.'">
                                   </div>
                               </div>';
                foreach($DEFAULT_ATTRIBUTES AS $KEY=>$VALUE){
                    extract($VALUE);
                    switch($ATTRIBUTE_NAME){
                        case 'Metal':
                        case 'Metal Purity':
                        case 'Hallmarks':
                            break;
                        case 'Metal Weight':
                            $PANEL .= '<div class="col-lg-4">
                                           <div class="input-group">
                                               <span class="input-group-addon">
                                                   '.$ATTRIBUTE_NAME.'
                                               </span>
                                               <input type="text" class="form-control" value="'.$WEIGHT.'">
                                           </div>
                                       </div>';
                            break;
                        default:
                            $PANEL .= '<div class="col-lg-4">
                                           <div class="input-group">
                                               <span class="input-group-addon">
                                                   '.$ATTRIBUTE_NAME.'
                                               </span>
                                               <input type="text" class="form-control" value="'.$ATTRIBUTES->$ATTRIBUTE_NAME.'">
                                           </div>
                                       </div>';
                            break;
                    }
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
    }