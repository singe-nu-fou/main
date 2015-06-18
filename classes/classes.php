<?php
    class classes{
        public static function create(){
            $PANEL = '<div id="new" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">New Class</div>
                        <div class="panel-body">
                            <form method="POST" action="libraries/update.php?page=classes&action=insert">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Class Name
                                            </span>
                                            <input type="text" name="CLASS_NAME" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default form-control">Create Class</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function edit(){
            $PANEL = '<div id="edit" class="panel panel-default" style="margin-bottom:0px;">
                        <div class="panel-heading">Edit Class - <span id="NAME"></span></div>
                        <div class="panel-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Class Name
                                            </span>
                                            <input name="CLASS_NAME" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-default form-control">Edit Class</button>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>';
            
            return $PANEL;
        }
        
        public static function tbody(){
            $DB = portal::database();
            $DB->query("SELECT ID,CLASS_NAME,LAST_MODIFIED FROM CLASSES ORDER BY ? ?",array($_GET['orderBy'],$_GET['order']));
            
            $TBODY = "<tbody>";
            
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr>
                               <td>
                                   <input type="checkbox" class="checkbox" value="'.$RESULT['CLASS_NAME'].'" style="display:none;">'.$RESULT['ID'].'
                               </td>
                               <td>
                                   '.$RESULT['CLASS_NAME'].'
                               </td>
                               <td>
                                   '.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'
                               </td>
                           </tr>';
            }
            
            $TBODY .= "</tbody>";
            
            return $TBODY;
        }
        
        public static function insert($DATA){
            $CLASS = array(
                'CLASS_NAME'=>NULL
            );
            foreach($DATA['POST'] AS $KEY=>$VALUE){
                $CLASS[$KEY] = $VALUE;
            }
            $DB = portal::database();
            $DB->query("SELECT * FROM CLASSES WHERE CLASS_NAME = ?",array($CLASS['CLASS_NAME']));
            if($results = $DB->fetch_assoc()){
                $_SESSION['ERR_MSG'] = "Class already exists!";
            }
            else{
                $DB->query("INSERT INTO CLASSES (CLASS_NAME) VALUES (?)",array($CLASS['CLASS_NAME']));
            }
        }
        
        public static function update($DATA){
            $DB = portal::database();
            $SQL = "UPDATE CLASSES SET CLASS_NAME = '".$DATA['POST']['CLASS_NAME']."', LAST_MODIFIED = NOW()+0 WHERE CLASS_NAME = '".$DATA['GET']."'";
            $DB->query($SQL);
        }
        
        public static function delete($DATA){
            $DB = portal::database();
            $SQL = "DELETE FROM CLASSES WHERE ";
            foreach($DATA['GET'] AS $KEY=>$VALUE){
                $SQL .= "CLASS_NAME = '".$VALUE."' ".((count($DATA['GET']) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }