<?php
    class users{
        public static function tbody(){
            $DB = portal::database();
            $DB->query('SELECT USER_ACCOUNTS.ID,USER_NAME,IFNULL(USER_TYPE_NAME,"UNAVAILABLE") AS USER_TYPE_NAME,USER_LOGIN,USER_ACCOUNTS.LAST_MODIFIED FROM USER_ACCOUNTS LEFT JOIN USER_TYPES ON USER_TYPE_ID = USER_TYPES.ID ORDER BY '.$_GET['orderBy'].' '.$_GET['order']);
            $TBODY = "<tbody>";
            while($RESULT = $DB->fetch_assoc()){
                $TBODY .= '<tr><td><input type="checkbox" class="checkbox" value="'.$RESULT['USER_NAME'].'" style="display:none;">'.$RESULT['ID'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_NAME'].'</td>';
                $TBODY .= '<td>'.$RESULT['USER_TYPE_NAME'].'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['USER_LOGIN'])).'</td>';
                $TBODY .= '<td>'.date('l, F Y h:i:sA',strtotime($RESULT['LAST_MODIFIED'])).'</td></tr>';
            }
            $TBODY .= "</tbody>";
            return $TBODY;
        }
        
        public static function insert($DATA){
            $USER = array(
                'USER_NAME'=>NULL,
                'USER_PASS'=>NULL,
                'USER_TYPE_ID'=>NULL
            );
            foreach($DATA['POST'] AS $KEY=>$VALUE){
                $USER[$KEY] = $VALUE;
            }
            switch(true){
                case portal::validUsername($USER['USER_NAME']):
                    break;
                case portal::validPassword($USER['USER_PASS']);
                    break;
                case portal::userNameExists($USER['USER_NAME']):
                    $_SESSION['ERR_MSG'] = "Invalid username: This username already exists.";
                    break;
                default:
                    var_dump($USER);
                    $DB = portal::database();
                    if(!$DB->query("INSERT INTO USER_ACCOUNTS (USER_TYPE_ID,USER_NAME,USER_PASS) VALUES (?,?,?)",array($USER['USER_TYPE_ID'],$USER['USER_NAME'],MD5($USER['USER_PASS'])))){
                        die('Error');
                    }
                    break;
            }
        }
        
        public static function update($DATA){
            switch(true){
                case $DATA['POST']['USER_PASS'] !== $DATA['POST']['CONF_USER_PASS']:
                    $_SESSION['ERR_MSG'] = 'Please ensure the new password and the confirmation password match!';
                    break;
                default:
                    $DB = portal::database();
                    if(strlen(trim($DATA['USER_PASS'])) === 0){
                        $SQL = "UPDATE USER_ACCOUNTS SET USER_TYPE_ID = ".$DATA['POST']['USER_TYPE_ID'].", LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$DATA['GET']."'";
                    }
                    else{
                        $SQL = "UPDATE USER_ACCOUNTS SET USER_TYPE_ID = ".$DATA['POST']['USER_TYPE_ID'].", USER_PASS = '".MD5($DATA['POST']['USER_PASS'])."', LAST_MODIFIED = NOW()+0 WHERE USER_NAME = '".$DATA['GET']."'";
                    }
                    $DB->query($SQL);
                    break;
            }
        }
        
        public static function delete($DATA){
            $DB = portal::database();
            $SQL = "DELETE FROM USER_ACCOUNTS WHERE ";
            foreach($DATA['GET'] AS $KEY=>$VALUE){
                $SQL .= "USER_NAME = '".$VALUE."' ".((count($USERS) - 1 === $KEY) ? '' : 'OR ');
            }
            $DB->query($SQL);
        }
    }