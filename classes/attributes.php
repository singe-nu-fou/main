<?php
    class attributes{
        public static function newAttribute(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Attribute</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute Name
                                            </span>
                                            <input type="text" name="ATTRIBUTE_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create Attribute</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function editAttribute(){
            $PANEL = '<div id="edit" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Attribute - <span id="ATTRIBUTE_NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="?'.$_SERVER['QUERY_STRING'].'">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute Name
                                            </span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button class="btn btn-default form-control">Edit Attribute/button>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function getTBODY(){
            $DB = portal::database();
            $DB->query("SELECT ID,ATTRIBUTE_NAME,LAST_MODIFIED FROM ATTRIBUTES ORDER BY ? ?",array($_GET['orderBy'],$_GET['order']));
            
            $TBODY = "<tbody>";
            
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr>
                               <td>
                                   <input type="checkbox" class="checkbox" value="'.$RESULT['ID'].'" style="display:none;">'.$RESULT['ID'].'
                               </td>
                               <td>
                                   '.$RESULT['ATTRIBUTE_NAME'].'
                               </td>
                               <td>
                                   '.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'
                               </td>
                           </tr>';
            }
            
            $TBODY .= "</tbody>";
            
            return $TBODY;
        }
    }