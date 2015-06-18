<?php
    class attributes{
        public static function newAttribute(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Attribute</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=attributes&action=new">
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
                        <div class="panel-heading">Edit Attribute - <span id="NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Attribute Name
                                            </span>
                                            <input name="ATTRIBUTE_NAME" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-default form-control">Edit Attribute</button>
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
                                   <input type="checkbox" class="checkbox" value="'.$RESULT['ATTRIBUTE_NAME'].'" style="display:none;">'.$RESULT['ID'].'
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
        
        public static function insertAttribute($DATA){
            $ATTRIBUTE = array(
                'ATTRIBUTE_NAME'=>NULL
            );
            foreach($DATA AS $KEY=>$VALUE){
                $ATTRIBUTE[$KEY] = $VALUE;
            }
            $DB = portal::database();
            $DB->query("SELECT * FROM ATTRIBUTESS WHERE TYPE_NAME = ?",array($ATTRIBUTE['ATTRIBUTE_NAME']));
            if($results = $DB->fetch_assoc()){
                $_SESSION['ERR_MSG'] = "Attribute already exists!";
            }
            else{
                $DB->query("INSERT INTO ATTRIBUTES (ATTRIBUTE_NAME) VALUES (?)",array($ATTRIBUTE['ATTRIBUTE_NAME']));
            }
        }
        
        public static function updateAttribute($ATTRIBUTE,$DATA){
            $DB = portal::database();
            $SQL = "UPDATE ATTRIBUTES SET ATTRIBUTE_NAME = '".$DATA['ATTRIBUTE_NAME']."', LAST_MODIFIED = NOW()+0 WHERE ATTRIBUTE_NAME = '".$ATTRIBUTE."'";
            $DB->query($SQL);
        }
        
        public static function deleteAttribute($ATTRIBUTES){
            $DB = portal::database();
            $SQL = "DELETE FROM ATTRIBUTES WHERE ";
            foreach($ATTRIBUTES AS $KEY=>$VALUE){
                $SQL .= "ATTRIBUTE_NAME = '".$VALUE."' ".((count($ATTRIBUTES) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }