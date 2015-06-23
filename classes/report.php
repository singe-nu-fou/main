<?php
    class report{
        public static function tbody(){
            return '<tr>
                        <td><input class="checkbox" type="checkbox" style="display:none;">Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                        <td>Test</td>
                    </tr>';
        }
        
        public static function resultControl(){
            return '<div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Results
                                </span>
                                <select class="form-control">
                                
                                </select>
                                <span class="input-group-addon">
                                    Filter
                                </span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>';
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
    }