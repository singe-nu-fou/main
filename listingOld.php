<?php
    session_start();
    include('classes/listing.php');
    $listing = new listing;
    $data = (isset($_GET['sku']) ? $listing->getListing($_GET['sku']) : $listing->getNextSKU());
    //var_dump($data);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<div class="col-xs-12" style="padding-left:0;padding-right:0;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?=($_GET['mode'] === 'submit') ? 'Create '.$data->type.' Listing #'.$data->sku : 'Edit '.$data->type.' Listing #'.$data->sku?>
        </div>
        <div class="panel-body">
            <div class="row" style="padding-bottom:20px;">
                <div class="col-xs-3">
                    <img width="100%" src="http://images.bellaandchloe.net/image.php?sku=<?=$data->sku?>&number=1&resample=182.75">
                </div>
                <div class="col-xs-3">
                    <img width="100%" src="http://images.bellaandchloe.net/image.php?sku=<?=$data->sku?>&number=2&resample=182.75">
                </div>
                <div class="col-xs-3">
                    <img width="100%" src="http://images.bellaandchloe.net/image.php?sku=<?=$data->sku?>&number=3&resample=182.75">
                </div>
                <div class="col-xs-3">
                    <img width="100%" src="http://images.bellaandchloe.net/image.php?sku=<?=$data->sku?>&number=4&resample=182.75">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <ul class="list-group" style="list-style-type:none;">
                        <li>
                            Item Type
                            <select class="form-control">
                                <?php
                                    $mysqli = new mysqli('localhost', 'root', '', 'lister');
                                    $query = $mysqli->query("SELECT classification.id,classification.name FROM `classification` JOIN types ON classification.type_id = types.id WHERE types.name = '".$data->type."' ORDER BY classification.id");
                                    while($result = $query->fetch_object()){
                                        echo '<option value="'.$result->id.'" '.(($result->name === $data->class) ? 'selected' : '').'>'.$result->name.'</option>';
                                    }
                                ?>
                            </select>
                        </li>
                        <li>
                            Metal
                            <select class="form-control">
                                <option>Silver</option>
                                <option>Silver Plated</option>
                                <option>German Silver</option>
                                <option>Nickel Silver</option>
                                <option>White Gold</option>
                                <option>White Gold Plated</option>
                                <option>Yellow Gold</option>
                                <option>Yellow Gold Plated</option>
                                <option>Multi-Tone Gold</option>
                                <option>Gold Filled</option>
                                <option>Gold Plated</option>
                                <option>Rose Gold</option>
                                <option>Rose Gold Plated</option>
                                <option>Silver & Gold</option>
                                <option>Silver & Gold Filled</option>
                                <option>Platinum</option>
                                <option>Alpaca</option>
                                <option>Alpaca & Sterling Silver</option>
                                <option>Rolled Gold Plate</option>
                                <option>Palladium</option>
                                <option>Stainless Steel</option>
                                <option>Platina P4</option>
                                <option>Other</option>
                            </select>
                        </li>
                        <li>
                            Metal Purity 
                            <select class='form-control'>
                            <?php
                                switch($data->attributes['Metal']){
                                    case ('Silver'):
                                    case ('Silver Plated'):
                                    case ('Alpaca & Sterling Silver'):
                                        $options =  array('.500','.720','.800','.830','.835','.875','.900','.925','.935','.950','.970','.980','.999','');
                                        break;

                                    case ('Gold'):
                                    case ('White Gold'):
                                    case ('Yellow Gold'):
                                    case ('Rose Gold'):
                                    case ('Multi-Tone Gold'):
                                    case ('Gold Filled'):
                                    case ('Gold Plated'):
                                    case ('Rolled Gold Plate'):
                                    case ('Rose Gold Plated'):
                                    case ('Yellow Gold Plated'):
                                    case ('White Gold Plated'): 
                                        $options = array('8K','9K','10K','12K','14K','18K','22K','24K','');
                                        break;

                                    case ("Silver & Gold Filled") :
                                    case ("Silver & Gold") :
                                        $options = array('.925 & 8K','.800 & 10k','.925 & 10K','.925 & 12K', '.925 & 14K','.900 & 18k','.925 & 18K','.950 & 18k','.925 & 22K','.925 & 24K');
                                        break;

                                    case ('Palladium'):
                                        $options = array('.500','.950','.999');
                                        break;

                                    case ('Platinum'):
                                        $options = array('.585','.950');
                                        break;

                                    case 'Alpaca':
                                    case 'Stainless Steel':
                                    case 'P4':
                                    case 'German Silver':
                                    case 'Nickel Silver':
                                    case 'Other':
                                        $options = array('');
                                        break;
                                }
                                foreach($options AS $option){
                                    echo '<option value="'.$option.'" '.(($data->attributes['Metal Purity'] === $option) ? 'selected' : '').'>'.$option.'</option>';
                                }
                            ?>
                            </select>
                        </li>
                        <li>
                            Metal Weight
                            <input type="text" class="form-control" value='<?=$data->attributes['Metal Weight']?>'>
                        </li>
                        <li>
                            Width
                            <input type="text" class="form-control" value='<?=((isset($data->attributes['Width'])) ? $data->attributes['Width'] : '')?>'>
                        </li>
                        <li>
                            Condition
                            <select class="form-control">
                                <?php
                                    $options = array('Vintage','New','Pre-Owned','Fashion','Damaged');
                                    foreach($options AS $option){
                                        echo "<option value='".$option."' ".(($option === $data->condition1) ? 'selected' : '').">".$option."</option>";
                                    }
                                ?>
                                <option>Vintage</option>
                                <option>New</option>
                                <option>Pre-Owned</option>
                                <option>Fashion</option>
                                <option>Damaged</option>
                            </select>
                        </li>
                        <li>
                            Descriptor
                            <input type="text" class="form-control" value='<?=$data->descriptor?>'>
                        </li>
                        
                        <!--specific attributes here-->
                        
                        <li>
                            Hallmarks
                            <input type="text" class="form-control" value='<?=(isset($data->attributes['Hallmarks']) ? $data->attributes['Hallmarks'] : '')?>'>
                        </li>
                        <li>
                            Title
                            <input type="text" class="form-control" value='<?=$data->title?>'>
                        </li>
                        <li>
                            Defects/Features
                            <input type="text" class="form-control" value='<?=$data->condition2?>'>
                        </li>
                        <li>
                            Gender
                            <select class="form-control">
                                <?php
                                    $options = array('Male','Female');
                                    foreach($options AS $option){
                                        echo "<option value='".$option."' ".(($option === $data->gender) ? 'selected' : '').">".$option."</option>";
                                    }
                                ?>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </li>
                        <li>
                            Quantity
                            <input type="number" class="form-control" value='<?=$data->quantity?>'>
                        </li>
                        <li>
                            Marketplace
                            <input type="text" class="form-control" value='<?=$data->marketplace?>' disabled>
                        </li>
                        <li>
                            Submit Date
                            <input type="text" class="form-control" value='<?=$data->submit_date?>' disabled>
                        </li>
                        <li>
                            Lister
                            <input type="text" class="form-control" value='<?=$data->requestor?>' disabled>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <img width="100%" src="http://images.bellaandchloe.net/image.php?sku=<?=$data->sku?>&amp;number=4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 col-xs-offset-10">
                    <button class="btn btn-success form-control">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>