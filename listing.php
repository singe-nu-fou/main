<?php
    session_start();
    
    require_once("classes/portal.php");
    require_once("classes/listing.php");
    
    if(portal::isSignedIn()){
        if(isset($_GET['sku'])){
            $listing = new listing($_GET['sku']);
       }
       
        else{
            $listing = new listing;
        }
        
        $classes = $listing->getClasses();
        //echo 'Item Type<select class="form-control">';
        //echo '</select>';
        
        $attributes = $listing->getAttributes();
        $metalOptions = array(
            "Silver",
            "Silver Plated",
            "German Silver",
            "Nickel Silver",
            "White Gold",
            "White Gold Plated",
            "Yellow Gold",
            "Yellow Gold Plated",
            "Multi-Tone Gold",
            "Gold Filled",
            "Gold Plated",
            "Rose Gold",
            "Rose Gold Plated",
            "Silver & Gold",
            "Silver & Gold Filled",
            "Platinum",
            "Alpaca",
            "Alpaca & Sterling Silver",
            "Rolled Gold Plate",
            "Palladium",
            "Stainless Steel",
            "Platina P4",
            "Other"
        );
        //echo 'Metal<select class="form-control">';
        
        //echo '/<select>';
        
        switch($listing->attributes['Metal']){
            case 'Silver':
            case 'Silver Plated':
            case 'Alpaca & Sterling Silver':
                $purityOptions =  array('.500','.720','.800','.830','.835','.875','.900','.925','.935','.950','.970','.980','.999','');
                break;

            case 'Gold':
            case 'White Gold':
            case 'Yellow Gold':
            case 'Rose Gold':
            case 'Multi-Tone Gold':
            case 'Gold Filled':
            case 'Gold Plated':
            case 'Rolled Gold Plate':
            case 'Rose Gold Plated':
            case 'Yellow Gold Plated':
            case 'White Gold Plated': 
                $purityOptions = array('8K','9K','10K','12K','14K','18K','22K','24K','');
                break;

            case "Silver & Gold Filled":
            case "Silver & Gold":
                $purityOptions = array('.925 & 8K','.800 & 10k','.925 & 10K','.925 & 12K','.925 & 14K','.900 & 18k','.925 & 18K','.950 & 18k','.925 & 22K','.925 & 24K');
                break;

            case 'Palladium':
                $purityOptions = array('.500','.950','.999');
                break;

            case 'Platinum':
                $purityOptions = array('.585','.950');
                break;

            case 'Alpaca':
            case 'Stainless Steel':
            case 'P4':
            case 'German Silver':
            case 'Nickel Silver':
            case 'Other':
                $purityOptions = NULL;
                break;
        }
        
        $conditionOptions = array("Vintage","New","Pre-Owned","Fashion","Damaged");
        echo 'Condition<select class="form-control">';
        foreach($conditionOptions AS $option){
            echo '<option'.(($listing->condition1 === $option) ? ' selected' : '').'>'.$option.'</option>';
        }
        echo '</select>';
        
        echo 'Descriptor<input class="form-control" type="text" value="'.$listing->descriptor.'">';
        foreach($attributes AS $KEY=>$VALUE){
            switch($VALUE['attribute']){
                case 'Metal':
                case 'Metal Purity':
                    break;
                case 'Stone Color':
                    $options = array('Hoop','Huggie','Dangle','Post','Stud','Clip-On','Screw-Back','French Clip','Chandelier','Leverback');
                    break;
                case 'Style':
                    $options = array('Souvenir', 'Demitasse', 'Serving', 'Dinner', 'Salt', 'Tasting', 'Bon Bon');
                    break;
                case 'Hallmarks':
                    echo $VALUE['attribute'].'<input class="form-control" type="text" value="'.$listing->attributes[$VALUE['attribute']].'">';
                    break;
                default:
                    echo $VALUE['attribute'].'<input class="form-control" type="text" value="'.$listing->attributes[$VALUE['attribute']].'">';
                    break;
            }
        }
        
        echo "Title<input class='form-control' type='text' value='".$listing->title."'>";
        
        echo 'Defects/Features<input class="form-control" type="text" value="'.$listing->condition2.'">';
        
        $genderOptions = array("Male","Female");
        echo 'Gender<select class="form-control">';
        foreach($options AS $option){
            echo '<option'.(($listing->gender === $option) ? ' selected' : '').'>'.$option.'</option>';
        }
        echo '</select>';
        
        echo 'Quantity<input class="form-control" type="text" value="'.$listing->quantity.'">';
        
        echo 'Marketplace<input class="form-control" type="text" value="'.$listing->marketplace.'">';
        
        echo 'Lister<input class="form-control" type="text" value="'.$listing->requestor.'">';
    }
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<div class="col-lg-3">
    <div class="row">
        Item Types
        <select class="form-control">
<?php
                foreach($classes AS $key=>$value){
                    echo '<option value="'.$value['id'].'"'.(($value['name'] === $listing->class) ? ' selected' : '').'>'.$value['name'].'</option>';
                }
?>
        </select>
        
        Metal
        <select class="form-control">
<?php
                foreach($metalOptions AS $option){
                    echo '<option'.(($listing->attributes['Metal'] === $option) ? ' selected' : '').'>'.$option.'</option>';
                }
?>
        </select>
        
<?php
            if($purityOptions !== NULL){
?>
        Metal Purity
        <select class="form-control">
<?php
                foreach($purityOptions AS $option){
                    echo '<option'.(($listing->attributes['Metal Purity'] === $option) ? ' selected' : '').'>'.$option.'</option>';
                }
?>
        </select>
<?php
            }
?>
        
    </div>
</div>