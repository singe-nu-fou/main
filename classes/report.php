<?php
    class report{
        public static function body($report){
            if(isset($_GET['report']) && $_GET['report'] === $report){
                $results = self::reports();
                foreach($results AS $key=>$value){
                    echo '<tr>
                      <td style="width:100px;text-align:center;padding-left:0px;margin-left:0px;">
                          <input type="checkbox" class="skubox" value="'.$value['sku'].'" style="display:none;">
                          <div class="input-group" style="padding:0px;margin:0px;">
                              <div class="input-group" style="width:100px;text-align:right:">
                                  <div class="input-group-addon" style="font-size:20px;font-weight:bold;height:115px;">
                                      <span>'.$value['sku'].'</span>
                                      <br>
                                      <span class="openListing close glyphicon glyphicon-folder-open" style="padding-right:35%;padding-top:15px;" onclick="var w = window.open(\'listing.php?mode=edit&sku='.$value['sku'].'\',\'newwindow\',\'width=800,height=900,scrollbars=yes,menubar=no\');w.focus();return false;"></span>
                                  </div>
                              </div>
                              <div class="input-group-addon">
                                  <img class="imgA" src="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=100&number=1" data-zoom-image="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=400&number=1">
                                  <img class="imgB" src="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=100&number=2" data-zoom-image="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=400&number=2">
                                  <img class="imgC" src="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=100&number=3" data-zoom-image="http://images.bellaandchloe.net/image.php?sku='.$value['sku'].'&resample=400&number=3">
                              </div>
                          </div>
                      </td>
                      <td>'.$value['title'].'</td>
                      <td>'.$value['submit_date'].'</td>
                      <td>'.$value['type'].'</td>
                      <td>'.$value['weight'].'</td>
                      <td>'.$value['lister'].'</td>
                  </tr>';
                }
            }
        }
        
        public static function reports(){
            $connection = open_connection();
            $select = "listings.sku AS 'sku', listings.title AS 'title', DATE_FORMAT(submit_date, '%M %D, %Y %l:%i%p') AS 'submit_date',classification.name AS 'type', listing_attributes.value AS 'weight',listings.requestor AS 'lister'";
            //$select .= ",IFNULL(envelopes.user,'Not Available') AS 'skuer',IFNULL(photography.photographer,'Not Available') AS 'photographer',IFNULL(croppers.cropper,'Not Available') AS 'cropper',IFNULL(sorting.sorter,'Not Available') AS 'sorter'";
            $from = "listings JOIN classification ON listings.classification_id = classification.id LEFT JOIN listing_attributes ON listing_attributes.sku = listings.sku AND listing_attributes.attribute = 'Metal Weight'";
            switch($_GET['subnav']){
                case 'recentlyListed':
                    if($_GET['report'] === 'recentlyListed'){
                        $where = "requestor = '".$_SESSION['userName']."' AND deleted = 0";
                    }
                    break;
                case 'notExportedEBAY':
                    $allNotExported = self::getArray('allNotExported');
                    switch($_GET['report']){
                        case 'All Items':
                            $where = "listings.type_id = 1 AND marketplace != 'signed off' AND marketplace != 'to be edited' AND marketplace != 'similar items' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'New Listings (Edit)':
                            $where = "listings.type_id = 1 AND marketplace = 'to be edited' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Similar Items':
                            $where = "listings.type_id = 1 AND marketplace = 'similar items' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Signed Off (All)':
                            $where = "listings.type_id = 1 AND marketplace = 'signed off' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        default:
                            $where = "listings.type_id = 1 AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0 AND ".$allNotExported[$_GET['report']];
                            break;
                    }
                    break;
                case 'notExportedSHOPIFY':
                    $allNotExportedSHOPIFY = self::getArray('allNotExportedSHOPIFY');
                    switch($_GET['report']){
                        case 'All Items':
                            $where = "listings.type_id = 2 AND marketplace != 'signed off' AND marketplace != 'to be edited' AND marketplace != 'similar items' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'New Listings (Edit)':
                            $where = "listings.type_id = 2 AND marketplace = 'to be edited' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Similar Items':
                            $where = "listings.type_id = 1 AND marketplace = 'similar items' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Signed Off (All)':
                            $where = "listings.type_id = 2 AND marketplace = 'signed off' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        default:
                            $where = "listings.type_id = 2 AND marketplace = 'signed off' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0 AND ".$allNotExportedSHOPIFY[$_GET['report']];
                            break;
                    }
                    break;
                case 'needsAttention':
                    $needsAttention = self::getArray('needsAttention');
                    foreach($needsAttention AS $key=>$value){
                        if($value === $_GET['report']){
                            $where = "redo = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0 AND marketplace = '".$key."'";
                            break;
                        }
                    }
                    break;
                case 'listers':
                    $where = "requestor = '".$_GET['report']."' AND deleted = 0 AND exported = 0 AND queued = 0 AND redo = 1";
                    break;
                case 'skuers':
                    $from .= "LEFT JOIN envelopes ON LENGTH(listings.sku) = LENGTH(envelopes.start) AND LENGTH(listings.sku) = LENGTH(envelopes.end) AND listings.sku BETWEEN envelopes.start AND envelopes.end";
                    $where = "errored = 1 AND deleted = 0 AND queued = 0 AND exported = 0 AND envelopes.user = '".$_GET['report']."'";
                    break;
                case 'photographers':
                    $from .= " LEFT JOIN photography ON LENGTH(listings.sku) = LENGTH(photography.start) AND listings.sku BETWEEN photography.start AND photography.end";
                    $where = "reshoot = 1 AND deleted = 0 AND queued = 0 AND exported = 0 AND photographer = '".$_GET['report']."'";
                    break;
                case 'priority':
                    switch($_GET['report']){
                        case 'Priority Edit (Damaged)':
                            $where = "marketplace = 'Priority Damaged' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Priority Edit (Wearable)':
                            $where = "marketplace = 'Priority Edits' AND reshoot = 0 AND redo = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0";
                            break;
                        case 'Needs Redo':
                            $where = 'redo = 1 AND deleted = 0';
                            break;
                        case 'Needs Reshoot':
                            $where = 'reshoot = 1 AND deleted = 0';
                            break;
                        case 'Needs Review':
                            $where = 'revise = 1 AND deleted = 0';
                            break;
                        case 'Missing Info':
                            $where = 'errored = 1 AND deleted = 0';
                            break;
                        case 'Test':
                            $where = "marketplace = 'holding 57' AND deleted = 0";
                            break;
                    }
                    break;
                case 'schedules':
                    $schedules = self::getArray('schedules');
                    foreach($schedules AS $key=>$value){
                        if($value === $_GET['report']){
                            $where = "redo = 0 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0 AND marketplace = '".$key."'";
                            break;
                        }
                    }
                    break;
                case 'queueManager':
                    switch($_GET['report']){
                        case 'In Queue':
                            $where = 'redo = 0 AND reshoot = 0 AND queued = 1 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0';
                            break;

                        case 'Successfully Submitted':
                            $where = 'ad_id IS NOT NULL AND ad_id != -1';
                            break;

                        case 'Failed Submission':
                            $where = 'ad_id = -1 AND redo = 0 AND reshoot = 0 AND queued = 0 AND errored = 0 AND deleted = 0 AND exported = 1 AND revise = 0';
                            break;

                    }
                    break;
            }
            $sql = "SELECT ".$select." FROM ".$from." ";
            /*$sql .= "LEFT OUTER JOIN photography 
                ON LENGTH( listings.sku ) = LENGTH( photography.start )
                AND listings.sku
                BETWEEN photography.start
                AND photography.end
                LEFT OUTER JOIN envelopes ON LENGTH( listings.sku ) = LENGTH( envelopes.start )
                AND LENGTH( listings.sku ) = LENGTH( envelopes.end )
                AND listings.sku
                BETWEEN envelopes.start
                AND envelopes.end
                LEFT OUTER JOIN croppers ON LENGTH( listings.sku ) = LENGTH( croppers.start )
                AND LENGTH( listings.sku ) = LENGTH( croppers.end )
                AND listings.sku
                BETWEEN croppers.start
                AND croppers.end
                LEFT OUTER JOIN sorting ON LENGTH( listings.sku ) = LENGTH( sorting.start )
                AND LENGTH( listings.sku ) = LENGTH( sorting.end )
                AND listings.sku
                BETWEEN sorting.start
                AND sorting.end";*/
            $sql .= " WHERE ".$where." GROUP BY listings.sku ORDER BY ".$_GET['orderBy']." ".$_GET['order']." LIMIT ".$_GET['range'];
            $connection->query($sql);
            $report = $connection->fetch_assoc_all();
            return $report;
        }
        
        public static function sidebar($subnav){
            if(isset($_GET['subnav']) && $_GET['subnav'] === $subnav){
                $results = self::totals();
                foreach($results AS $key=>$value){
                    if($value['count'] > 0){
                        echo '<li><a class="list-group-item '.((isset($_GET['report']) && $_GET['report'] === str_replace('+',' ',$value['href'])) ? 'active' : '').'" href="?nav=report&subnav='.$subnav.'&report='.$value['href'].'&results=25&orderBy=submit_date&order=DESC&range=0,25&page=1">'.$key.'<span class="badge">'.$value['count'].'</span></a></li>';
                    }
                }
            }
        }
        
        public static function totals(){
            $mysqli = new mysqli('localhost', 'root', '', 'lister');
            if($mysqli->connect_errno){
                die('Connection failed: '.$mysqli->connect_error);
            }
            switch($_GET['subnav']){
                case 'listedToday':
                    $query = $mysqli->query("SELECT GROUP_CONCAT(DISTINCT requestor) AS 'listers' FROM listings");
                    $listers = $query->fetch_object();
                    $listers = explode(',',$listers->listers);
                    foreach($listers as $lister){
                        $listerSQL[] = "sum(case when requestor = '".$lister."' AND DATE(submit_date) = CURDATE() AND YEAR(submit_Date) = YEAR(CURDATE()) AND deleted = 0 then 1 else 0 end) AS '".$lister."'";
                    }
                    $sql = "SELECT SUM(CASE WHEN DATE(submit_date) = CURDATE() THEN 1 ELSE 0 END) AS 'Listed Today',
                            SUM(CASE WHEN DATE(submit_date) = CURDATE() AND marketplace = 'signed off' THEN 1 ELSE 0 END) AS 'Signed Off'
                            "/*.implode(',',$listerSQL)*/."
                            FROM listings";
                    break;
                case 'notExportedEBAY':
                    $allNotExported = self::getArray('allNotExported');
                    foreach($allNotExported AS $key=>$value){
                        if($key == 'All Items'){
                            $sql[] = "SUM(CASE WHEN listings.type_id = 1 AND marketplace != 'to be edited' AND marketplace != 'signed off' AND marketplace != 'similar items' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'New Listings (Edit)'){
                            $sql[] = "sum(case when marketplace = 'to be edited' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'Signed Off (All)'){
                            $sql[] = "sum(case when marketplace = 'signed off' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'Similar Items'){
                            $sql[] = "sum(case when marketplace LIKE '%similar items%' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else{
                            $sql[] = "sum(case when ".$value." THEN 1 ELSE 0 END) AS '".$key."'";
                        }
                    }
                    $sql = "SELECT ".implode(',',$sql)." FROM listings 
                            WHERE type_id = 1 
                            AND redo = 0
                            AND queued = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND revise = 0
                            AND reshoot = 0
                            AND classification_id != 0";
                    break;
                case 'notExportedSHOPIFY':
                    $shopifyNotExported = self::getArray('allNotExportedSHOPIFY');
                    foreach($shopifyNotExported AS $key=>$value){
                        if($key == 'All Items'){
                            $sql[] = "SUM(CASE WHEN listings.type_id = 2 AND marketplace != 'to be edited' AND marketplace != 'signed off' AND marketplace != 'similar items' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'New Listings (Edit)'){
                            $sql[] = "sum(case when marketplace = 'to be edited' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'Signed Off (All)'){
                            $sql[] = "sum(case when marketplace = 'signed off' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else if($key == 'Similar Items'){
                            $sql[] = "sum(case when signedOff = 0 AND marketplace = 'similar items' THEN 1 ELSE 0 END) AS '".$key."'";
                        }

                        else{
                            $sql[] = "sum(case when marketplace = 'signed off' AND ".$value." THEN 1 ELSE 0 END) AS '".$key."'";
                        }
                    }
                    $sql = "SELECT ".implode(',',$sql)." 
                            FROM listings 
                            WHERE type_id = 2 
                            AND redo = 0
                            AND queued = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND revise = 0
                            AND reshoot = 0
                            AND classification_id != 0";
                    break;
                case 'needsAttention':
                    $needsAttention = self::getArray('needsAttention');
                    foreach($needsAttention as $key=>$value){
                        $sql[] = "sum(case when marketplace = '".$key."' AND signedOff = 0 then 1 else 0 end) AS '".$value."'";
                    }
                    $sql = "SELECT 
                            ".implode(',',$sql)."
                            FROM listings 
                            WHERE redo = 0
                            AND queued = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND revise = 0
                            AND reshoot = 0";
                    break;
                case 'listers':
                    $sql = "SELECT count(listings.sku) AS 'Count', listings.requestor AS 'User' FROM listings
                            WHERE deleted = 0
                            AND exported = 0
                            AND queued = 0
                            AND redo = 1
                            GROUP BY requestor";
                    break;
                case 'skuers':
                    $sql = "SELECT count(listings.sku) AS 'Count', envelopes.user AS 'User' FROM envelopes
                            RIGHT JOIN listings ON listings.sku
                            BETWEEN
                            envelopes.start
                            AND
                            envelopes.end
                            WHERE LENGTH(listings.sku) = LENGTH(envelopes.end)
                            AND deleted = 0
                            AND exported = 0
                            AND queued = 0
                            AND errored = 1
                            GROUP BY user";
                    break;
                case 'photographers':
                    $sql = "SELECT count(listings.sku) AS 'Count', photography.photographer AS 'User' FROM photography
                            RIGHT JOIN listings ON listings.sku
                            BETWEEN
                            photography.start
                            AND
                            photography.end
                            WHERE LENGTH(listings.sku) = LENGTH(photography.end)
                            AND deleted = 0
                            AND exported = 0
                            AND queued = 0
                            AND reshoot = 1
                            GROUP BY photography.photographer";
                    break;
                case 'priority':
                    $sql = "SELECT sum(case when marketplace = 'Priority Damaged' AND redo = 0
                            AND queued = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND reshoot = 0
                            AND revise = 0 then 1 else 0 end) AS 'Priority Edit (Damaged)',
                            sum(case when marketplace = 'Priority Edits' AND redo = 0
                            AND queued = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND reshoot = 0
                            AND revise = 0 then 1 else 0 end) AS 'Priority Edit (Wearable)',
                            SUM(CASE WHEN marketplace = 'holding 57' AND deleted = 0 THEN 1 ELSE 0 END) AS 'Test',
                            sum(case when errored = 1 AND deleted = 0 then 1 else 0 end) AS 'Missing Info',
                            sum(case when revise = 1 AND deleted = 0 then 1 else 0 end) AS 'Needs Review',
                            sum(case when redo = 1 AND deleted = 0 then 1 else 0 end) AS 'Needs Redo',
                            sum(case when reshoot = 1 AND deleted = 0 then 1 else 0 end) AS 'Needs Reshoot' FROM listings";
                    break;
                case 'schedules':
                    $schedules = self::getArray('schedules');
                    foreach($schedules as $key=>$value){
                        $sql[] = "sum(case when marketplace = '".$key."' then 1 else 0 end) AS '".$value."'";
                    }
                    $sql = "SELECT ".implode(',',$sql)."
                            FROM listings
                            WHERE redo = 0
                            AND errored = 0
                            AND deleted = 0
                            AND exported = 0
                            AND revise = 0
                            AND reshoot = 0";
                    break;
                case 'queueManager':
                    $sql = "SELECT 
                            sum(case when redo = 0 AND queued = 1 AND errored = 0 AND deleted = 0 AND exported = 0 AND revise = 0 AND reshoot = 0 then 1 else 0 end) AS 'In Queue',
                            sum(case when ad_id IS NOT NULL AND ad_id != -1 then 1 else 0 end) AS 'Successfully Submitted',
                            sum(case when queued = 0 AND exported = 1 AND ad_id = -1 AND deleted = 0 then 1 else 0 end) AS 'Failed Submission'
                            FROM listings";
                    break;
            }
            $query = $mysqli->query($sql);
            switch($_GET['subnav']){
                case 'listers':
                case 'skuers':
                case 'photographers':
                    while($result = $query->fetch_object()){
                        $report[$result->User] = array('href'=>str_replace(' ','+',$result->User),'count'=>$result->Count);
                    }
                    break;
                default:
                    while($result = $query->fetch_object()){
                        foreach($result AS $key=>$value){
                            $report[$key] = array('href'=>str_replace(' ','+',$key),'count'=>$value);
                        }
                    }
                    break;
            }
            return $report;
        }
        public static function listerSkuerPhotographer($sql){
            $mysqli = new mysqli('localhost', 'root', '', 'lister');
            if($mysqli->connect_errno){
                die('Connection failed: '.$mysqli->connect_error);
            }
        }
        
        public static function getArray($name){
            switch($name){
                case 'allNotExported':
                    $allNotExported = array("All Items" => "",
                                            "New Listings (Edit)" => "",
                                            "Similar Items" => "",
                                            "Signed Off (All)" => "",
                                            "Alpaca" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND listings.type_id = 1 AND MATCH(title) AGAINST('+alpaca -damaged -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Anklets" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 17 AND MATCH(title) AGAINST('+anklet -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Belly Navel Ring" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 16 AND MATCH(title) AGAINST('+\"belly navel ring\" -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Bracelets" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -charm -bangle -mens -chain -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Charm Bracelets" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +charm -chain -bangle -mens -chain -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Bracelets (Bangle)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bangle -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Bracelets (Bead & Bar)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bead & bar chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Bead)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bead chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Bismark)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bismark chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Boston)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"boston chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Box)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"box chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Byzantine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"byzantine chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (C-Link)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"c-link chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Cable)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"cable chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Charm)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"charm chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Cobra)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"cobra chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Cuff)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"cuff chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Glitter Snake)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"glitter snake chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Herringbone)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"herringbone chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Liquid Silver)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"liquid silver chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Mesh)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"mesh chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Omega)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"omega chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Other)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +chain -mens -alpaca -damaged -heavy -navajo -zuni -hopi -bangle -\"bead & bar chain\" -\"bead chain\" -\"bismark chain\" -\"boston chain\" -\"box chain\" -\"byzantine chain\" -\"c-link chain\" -\"cable chain\" -\"charm chain\" -\"cobra chain\" -\"cuff chain\" -\"glitter snake chain\" -\"herringbone chain\" -\"liquid silver chain\" -\"mesh chain\" -\"omega chain\" -\"panther chain\" -\"popcorn chain\" -\"prince of wales chain\" -\"ring & connector chain\" -\"rope chain\" -\"san marco chain\" -\"saturn chain\" -\"serpentine chain\" -\"singapore chain\" -\"snake chain\" -\"sparkle chain\" -\"tennis chain\" -\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Panther)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"panther chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Popcorn)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"popcorn chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Prince Of Wales)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"prince of wales chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Ring & Connector)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"ring & connector chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Rope)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"rope chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (San Marco)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"san marco\"' IN BOOLEAN MODE)",
                                            "Bracelets (Saturn)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"saturn chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Serpentine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"serpentine chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Singapore)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"singapore chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Snake)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"snake chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Sparkle)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"sparkle chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Tennis)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"tennis chain\"' IN BOOLEAN MODE)",
                                            "Bracelets (Wheat)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Brooches" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 7 AND MATCH(title) AGAINST('+brooch -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Belt Buckle" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 22 AND MATCH(title) AGAINST('+\"belt buckle\" -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Chain (Bead & Bar)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bead & bar chain\"' IN BOOLEAN MODE)",
                                            "Chain (Bead)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bead chain\"' IN BOOLEAN MODE)",
                                            "Chain (Bismark)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"bismark chain\"' IN BOOLEAN MODE)",
                                            "Chain (Boston)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"boston chain\"' IN BOOLEAN MODE)",
                                            "Chain (Box)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"box chain\"' IN BOOLEAN MODE)",
                                            "Chain (Byzantine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"byzantine chain\"' IN BOOLEAN MODE)",
                                            "Chain (C-Link)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"c-link chain\"' IN BOOLEAN MODE)",
                                            "Chain (Cobra)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"cobra chain\"' IN BOOLEAN MODE)",
                                            "Chain (Glitter Snake)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"glitter snake chain\"' IN BOOLEAN MODE)",
                                            "Chain (Herringbone)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"herringbone chain\"' IN BOOLEAN MODE)",
                                            "Chain (Liquid Silver)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"liquid silver chain\"' IN BOOLEAN MODE)",
                                            "Chain (Mesh)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"mesh chain\"' IN BOOLEAN MODE)",
                                            "Chain (Omega)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"omega chain\"' IN BOOLEAN MODE)",
                                            "Chain (Other)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +chain -mens -alpaca -damaged -heavy -navajo -zuni -hopi -\"bead & bar chain\" -\"bead chain\" -\"bismark chain\" -\"boston chain\" -\"box chain\" -\"byzantine chain\" -\"c-link chain\" -\"cobra chain\" -\"glitter snake chain\" -\"herringbone chain\" -\"liquid silver chain\" -\"mesh chain\" -\"omega chain\" -\"popcorn chain\" -\"prince of wales chain\" -\"ring & connector chain\" -\"rope chain\" -\"saturn chain\" -\"serpentine chain\" -\"singapore chain\" -\"snake chain\" -\"sparkle chain\" -\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Chain (Popcorn)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"popcorn chain\"' IN BOOLEAN MODE)",
                                            "Chain (Prince Of Wales)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"prince of wales chain\"' IN BOOLEAN MODE)",
                                            "Chain (Ring & Connector)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"ring & connector chain\"' IN BOOLEAN MODE)",
                                            "Chain (Rope)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"rope chain\"' IN BOOLEAN MODE)",
                                            "Chain (Saturn)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"saturn chain\"' IN BOOLEAN MODE)",
                                            "Chain (Serpentine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"serpentine chain\"' IN BOOLEAN MODE)",
                                            "Chain (Singapore)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"singapore chain\"' IN BOOLEAN MODE)",
                                            "Chain (Snake)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"snake chain\"' IN BOOLEAN MODE)",
                                            "Chain (Sparkle)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"sparkle chain\"' IN BOOLEAN MODE)",
                                            "Chain (Wheat)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -alpaca -damaged -heavy -navajo -zuni -hopi +\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Charm Pendant" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 5 AND MATCH(title) AGAINST('+\"charm pendant\" -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Cufflinks" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 11 AND MATCH(title) AGAINST('+cufflinks -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Cufflinks (Single)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 24 AND MATCH(title) AGAINST('+\"(SINGLE) cufflink\" -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Damaged" => "quantity = 1 AND listings.type_id = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND MATCH(title) AGAINST('+damaged -alpaca' IN BOOLEAN MODE)",
                                            "Duplicate" => "quantity > 1 AND listings.type_id = 1 AND marketplace = 'signed off' AND quantity > 1",
                                            "Earrings" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 8 AND MATCH(title) AGAINST('+earrings -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Earrings (Single)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 25 AND MATCH(title) AGAINST('+\"(SINGLE) Earring\" -mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Heavy" => "quantity = 1 AND listings.type_id = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND MATCH(title) AGAINST('+heavy -damaged -alpaca -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Jewelry Pieces" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 26 AND MATCH(title) AGAINST('+\"Jewelry Piece\" -mens' IN BOOLEAN MODE)",
                                            "Lapel Pins" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 14 AND MATCH(title) AGAINST('+\"Lapel Pin\" -mens' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Bismark)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"bismark chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Box)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"box chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Byzantine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"byzantine chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Cable)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"cable chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Cuban)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"cuban chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Curb)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"curb chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Figaro)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"figaro chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Mariner)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"mariner chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Other)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +chain +mens -alpaca -damaged -heavy -navajo -zuni -hopi -\"bismark chain\" -\"box chain\" -\"byzantine chain\" -\"cable chain\" -\"cuban chain\" -\"curb chain\" -\"figaro chain\" -\"mariner chain\" -\"panther chain\" -\"prince of wales chain\" -\"ring & connector chain\" -\"rolo chain\" -\"scroll chain\" -\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Panther)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"panther chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Prince Of Wales)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"prince of wales chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Ring & Connector)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"ring & connector chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Rolo)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"rolo chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Rope)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"rope chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Scroll)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"scroll chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Bracelets (Wheat)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +mens +\"wheat chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Bismark)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"bismark chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Byzantine)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"byzantine chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Cable)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"cable chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Cuban)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"cuban chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Figaro)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"figaro chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Mariner)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"mariner chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Other)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +chain +mens -alpaca -damaged -heavy -navajo -zuni -hopi -\"bismark chain\" -\"byzantine chain\" -\"cable chain\" -\"cuban chain\" -\"figaro chain\" -\"mariner chain\" -\"panther chain\" -\"prince of wales chain\" -\"ring & connector chain\" -\"rolo chain\" -\"rope chain\" -\"scroll chain\" -\"wheat chain\"' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Panther)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"panther chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Prince Of Wales)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"prince of wales chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Ring & Connector)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"ring & connector chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Rope)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"rope chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Rolo)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"rolo chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Scroll)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"scroll chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens Necklaces (Wheat)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace +mens +\"wheat chain\" -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens (Other)" => "quantity = 1 AND listings.type_id = 1 AND classification_id != 2 AND classification_id != 4 AND classification_id != 6 AND classification_id != 12 AND classification_id != 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND MATCH(title) AGAINST('+mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Mens (Pendants)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 4 AND MATCH(title) AGAINST('+pendant +mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Mens (Rings)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 1 AND MATCH(title) AGAINST('+ring +mens -alpaca -damaged -heavy' IN BOOLEAN MODE)",
                                            "Misc" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 12 AND title NOT REGEXP 'zuni|hopi|navajo'",
                                            "Money Clip" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 10 AND MATCH(title) AGAINST('+\"money clip\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Native American" => "quantity = 1 AND listings.type_id = 1 AND marketplace = 'signed off' AND  title REGEXP 'NAVAJO|ZUNI|HOPI'",
                                            "Necklaces" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 6 AND MATCH(title) AGAINST('+necklace -mens -chain -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Pendants" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 4 AND MATCH(title) AGAINST('+pendant -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Pendant Brooch" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 21 AND MATCH(title) AGAINST('+\"pendant brooch\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Pill Box" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 15 AND MATCH(title) AGAINST('+\"pill box\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Rings" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 1 AND MATCH(title) AGAINST('+ring -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Set" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 13 AND MATCH(title) AGAINST('+set -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Similar Items (Bracelets)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet -charm -zuni -hopi- navajo' IN BOOLEAN MODE)",
                                            "Similar Items (Brooches)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 7 AND MATCH(title) AGAINST('+brooch -zuni -hopi- navajo' IN BOOLEAN MODE)",
                                            "Similar Items (Charms)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 2 AND MATCH(title) AGAINST('+bracelet +charm -zuni -hopi- navajo' IN BOOLEAN MODE)",
                                            "Similar Items (Earrings)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 8 AND MATCH(title) AGAINST('+earrings -zuni -hopi -navajo' IN BOOLEAN MODE)",
                                            "Similar Items (Other)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id != 2 AND classification_id != 7 AND classification_id != 8 AND classification_id != 4 AND classification_id != 1 AND title NOT REGEXP 'zuni|hopi|navajo'",
                                            "Similar Items (Pendants)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 4 AND MATCH(title) AGAINST('+pendant -zuni -hopi- navajo' IN BOOLEAN MODE)",
                                            "Similar Items (Rings)" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket LIKE '%similar items%' AND classification_id = 1 AND MATCH(title) AGAINST('+ring -zuni -hopi- navajo' IN BOOLEAN MODE)",
                                            "Spoons" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 50 AND MATCH(title) AGAINST('+spoon -alpaca -damaged -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Tie Clip" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 9 AND MATCH(title) AGAINST('+\"tie clip\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Tie Tack" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 51 AND MATCH(title) AGAINST('+\"tie tacl\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Toe Rings" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 18 AND MATCH(title) AGAINST('+\"toe ring\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)",
                                            "Watches" => "quantity = 1 AND marketplace = 'signed off' AND prevmarket NOT LIKE '%similar items%' AND classification_id = 23 AND MATCH(title) AGAINST('+\"watch\" -mens -alpaca -damaged -heavy -navajo -zuni -hopi' IN BOOLEAN MODE)");
                    return $allNotExported;
                case 'allNotExportedSHOPIFY':
                    $shopifyNotExported = array("All Items" => "",
                                                "New Listings (Edit)" => "",
                                                "Signed Off (All)" => "",
                                                "Ring" => "classification_id = 58",
                                                "Bracelet" => "classification_id = 59",
                                                "Pendant" => "classification_id = 60",
                                                "Charm Pendant" => "classification_id = 62",
                                                "Necklace" => "classification_id = 63",
                                                "Brooch" => "classification_id = 64",
                                                "Earrings" => "classification_id = 65",
                                                "Misc" => "classification_id = 66");
                    return $shopifyNotExported;
                case 'needsAttention':
                    $needsAttention = array('Holding 41' => 'Diana',
                                            'Holding 42' => 'Darby',
                                            'Holding 44' => 'Kaydee',
                                            'Holding 43' => 'Maria',
                                            'Holding 61' => 'Holding (Already Tested)',
                                            'Holding 48' => 'Training 1',
                                            'Holding 49' => 'Training 2',
                                            'Holding 50' => 'Training 3',
                                            'Holding 46' => 'Holding (Test)',
                                            'Holding 55' => 'Holding (Edits)',
                                            'Holding 47' => 'Holding (Additional Info)',
                                            'Holding 56' => 'Holding (Needs Review)',
                                            'Holding 45' => 'Holding (Redo)');
                    return $needsAttention;
                case 'schedules':
                    $schedules = array('Holding 1' => 'BC 1 7-Day (6:00-6:10)',
                                        'Holding 2' => 'BC 1 7-Day (6:10-6:20)',
                                        'Holding 3' => 'BC 1 7-Day (6:20-6:30)',
                                        'Holding 4' => 'BC 1 7-Day (6:30-6:40)',
                                        'Holding 5' => 'BC 1 7-Day (6:40-6:50)',
                                        'Holding 6' => 'BC 1 7-Day (6:50-7:00)',
                                        'Holding 7' => 'BC 1 7-Day (7:00-7:10)',
                                        'Holding 8' => 'BC 1 7-Day (7:10-7:20)',
                                        'Holding 9' => 'BC 1 7-Day (7:20-7:30)',
                                        'Holding 10' => 'BC 1 7-Day (7:30-7:40)',
                                        'Holding 11' => 'BC 1 7-Day (7:40-7:50)',
                                        'Holding 12' => 'BC 1 7-Day (7:50-8:00)',
                                        'Holding 13' => 'BC 1 7-Day (8:00-8:10)',
                                        'Holding 14' => 'BC 1 7-Day (8:10-8:20)',
                                        'Holding 15' => 'BC 1 7-Day (8:20-8:30)',
                                        'Holding 16' => 'BC 1 7-Day (8:30-8:40)',
                                        'Holding 17' => 'BC 1 7-Day (8:40-8:50)',
                                        'Holding 18' => 'BC 1 7-Day (8:50-9:00)',
                                        'Holding 19' => 'BC 1 3-Day (7:00-9:00)',
                                        'Holding 20' => 'BC 1 10-Day (7:00-9:00)',
                                        'Holding 21' => 'BC 2 7-Day (9:00-9:10)',
                                        'Holding 22' => 'BC 2 7-Day (9:10-9:20)',
                                        'Holding 23' => 'BC 2 7-Day (9:20-9:30)',
                                        'Holding 24' => 'BC 2 7-Day (9:30-9:40)',
                                        'Holding 25' => 'BC 2 7-Day (9:40-9:50)',
                                        'Holding 26' => 'BC 2 7-Day (9:50-10:00)',
                                        'Holding 27' => 'BC 2 7-Day (10:00-10:10)',
                                        'Holding 28' => 'BC 2 7-Day (10:10-10:20)',
                                        'Holding 29' => 'BC 2 7-Day (10:20-10:30)',
                                        'Holding 30' => 'BC 2 7-Day (10:30-10:40)',
                                        'Holding 31' => 'BC 2 7-Day (10:40-10:50)',
                                        'Holding 32' => 'BC 2 7-Day (10:50-11:00)',
                                        'Holding 33' => 'BC 2 7-Day (11:00-11:10)',
                                        'Holding 34' => 'BC 2 7-Day (11:10-11:20)',
                                        'Holding 35' => 'BC 2 7-Day (11:20-11:30)',
                                        'Holding 36' => 'BC 2 7-Day (11:30-11:40)',
                                        'Holding 37' => 'BC 2 7-Day (11:40-11:50)',
                                        'Holding 38' => 'BC 2 7-Day (11:50-12:00)',
                                        'Holding 39' => 'BC 2 3-Day (9:00-11:00)',
                                        'Holding 40' => 'BC 2 10-Day (10:00-12:00)',
                                        'Holding 58' => 'BC 3 3-Day (6:00-12:00)',
                                        'Holding 59' => 'BC 3 5-Day (6:00-12:00)',
                                        'Holding 60' => 'BC 3 7-Day (6:00-12:00)',
                                        'Holding 51' => 'BC 1 30-Day (FIXED)',
                                        'Holding 52' => 'BC 2 30-Day (FIXED)',
                                        'Holding 53' => 'BC 3 30-Day (FIXED)',
                                        'Holding 54' => 'Shopify',
                                        'Shopify BC' => 'Shopify BC',
                                        'Shopify Bretheren' => 'Shopify Bretheren');
                    return $schedules;
            }
        }
        
        public static function orderBy($column){
            $url = $_SERVER['QUERY_STRING'];
            $url = str_replace($_GET['orderBy'],$column,$url);
            return (($_GET['orderBy'] === $column) ? ($_GET['order'] === 'DESC' ? str_replace("DESC", "ASC", $url) : str_replace("ASC", "DESC", $url)) : str_replace("ASC", "DESC", $url));
        }
        
        public static function orderByIcon($column){
            return (($_GET['orderBy'] === $column) ? (($_GET['order'] === 'ASC') ? 'glyphicon glyphicon-chevron-up' : 'glyphicon glyphicon-chevron-down') : '');
        }
    }