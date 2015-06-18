<?php
    class template{
        public static function newTemplate(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Type</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=types&action=new">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type Name
                                            </span>
                                            <input type="text" name="TYPE_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create Type</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function editTemplate(){
            $PANEL = '<div id="edit" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Class - <span id="NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type Name
                                            </span>
                                            <input name="TYPE_NAME" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-default form-control">Edit Type</button>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function getTBODY(){
            $DB = portal::database();
            $DB->query("SELECT TEMPLATES.ID,CLASS_NAME,TYPE_NAME,TEMPLATES.LAST_MODIFIED FROM TEMPLATES LEFT JOIN CLASSES ON CLASSES.ID = CLASS_ID LEFT JOIN TYPES ON TYPES.ID = TYPE_ID ORDER BY ? ?",array($_GET['orderBy'],$_GET['order']));
            
            $TBODY = "<tbody>";
            
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr>
                               <td>
                                   <input type="checkbox" class="checkbox" value="'.$RESULT['ID'].'" style="display:none;">'.$RESULT['ID'].'
                               </td>
                               <td>
                                   '.$RESULT['CLASS_NAME'].'
                               </td>
                               <td>
                                   '.$RESULT['TYPE_NAME'].'
                               </td>
                               <td>
                                   '.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'
                               </td>
                           </tr>';
            }
            
            $TBODY .= "</tbody>";
            
            return $TBODY;
        }
        
        public static function insertTemplate($DATA){
            $TYPE = array(
                'TYPE_NAME'=>NULL
            );
            foreach($DATA AS $KEY=>$VALUE){
                $TYPE[$KEY] = $VALUE;
            }
            $DB = portal::database();
            $DB->query("SELECT * FROM TYPES WHERE TYPE_NAME = ?",array($TYPE['TYPE_NAME']));
            if($results = $DB->fetch_assoc()){
                $_SESSION['ERR_MSG'] = "Type already exists!";
            }
            else{
                $DB->query("INSERT INTO TYPES (TYPE_NAME) VALUES (?)",array($TYPE['TYPE_NAME']));
            }
        }
        
        public static function updateTemplate($TYPE,$DATA){
            $DB = portal::database();
            $SQL = "UPDATE TYPES SET TYPE_NAME = '".$DATA['TYPE_NAME']."', LAST_MODIFIED = NOW()+0 WHERE TYPE_NAME = '".$TYPE."'";
            $DB->query($SQL);
        }
        
        public static function deleteTemplate($TYPES){
            $DB = portal::database();
            $SQL = "DELETE FROM TYPES WHERE ";
            foreach($TYPES AS $KEY=>$VALUE){
                $SQL .= "TYPE_NAME = '".$VALUE."' ".((count($TYPES) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }