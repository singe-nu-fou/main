<?php
    portal::database();
?>
<script>
    $(document).ready(function(){
        $('.inventory-control').change(function(){
            window.location.href = hrefScrub($(this).attr('name'),$(this).val(),window.location.href);
        });
    });
    
    function hrefScrub(index,value,href){
        var get;
        switch(index){
            case 'inventory[class]':
                get = '&class=';
                break;
            case 'inventory[type]':
                get = '&type=';
                break;
        }
        if(href.indexOf(get) === -1){
            return href+get+value;
        }
        href = href.substring(0, href.lastIndexOf(get));
        return href+get+value;
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        Inventory Entry
    </div>
    <div class="panel-body">
        <form action="libraries/update.php?page=inventoryEntry&action=insert" method="post">
            <div class="row">
                <div class="col-lg-4">
                    Type
                    <select name="inventory[class]" class="inventory-control form-control">
                        <?php
                            $CLASSIFICATIONS = portal::warp('classifications','getClassification');
                            foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
                                extract($VALUE);
                                echo '<option value="'.$ID.'"'.((isset($_GET['class']) && $ID === $_GET['class']) ? ' selected' : '').'>'.$CLASS_NAME.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Classification
                    <select name="inventory[type]" class="inventory-control form-control">
                        <?php
                            if(isset($_GET['class'])){
                                $TYPES = portal::warp('classifications','getClassificationType',array('ID'=>$_GET['class']));
                                foreach($TYPES AS $KEY=>$VALUE){
                                    extract($VALUE);
                                    echo '<option value="'.$ID.'"'.((isset($_GET['type']) && $ID === $_GET['type']) ? ' selected' : '').'>'.$TYPE_NAME.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Condition
                    <select name="inventory[Condition]" class="form-control">
                        <?php
                        $OPTIONS = array(
                            'Vintage',
                            'New',
                            'Pre-Owned',
                            'Fashion',
                            'Damaged'
                        );
                        foreach($OPTIONS AS $OPTION){
                            echo '<option value="'.$OPTION.'">'.$OPTION.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Quantity
                    <input type="text" class="form-control" name="inventory[Quantity]">
                </div>
                <?php
                    if(isset($_GET['class']) && isset($_GET['type'])){
                        $ATTRIBUTES = portal::warp('types','getTypeAttribute',array('CLASS_ID'=>$_GET['class'],'TYPE_ID'=>$_GET['type']));
                        if(isset($ATTRIBUTES)){
                            foreach($ATTRIBUTES AS $KEY=>$VALUE){
                                extract($VALUE);
                                switch($ATTRIBUTE_NAME){
                                    case 'Metal':
                                    case 'Metal Purity':
                                    case 'Hallmarks':
                                        break;
                                    default:
                                        ?>
                                        <div class="col-lg-4">
                                            <?=$ATTRIBUTE_NAME?>
                                            <input type="text" class="form-control" name="inventory[<?=$ATTRIBUTE_NAME?>]">
                                        </div>
                                        <?php
                                        break;
                                }
                            }
                        }
                    }
                ?>
                <div class="col-lg-4">
                    SKU
                    <input type="text" class="form-control" name="inventory[sku]">
                </div>
            </div>
            <div class="row" style="padding-top:15px;">
                <!--<div class="col-xs-3 col-xs-offset-3">
                    <button class="btn btn-default form-control">
                        Cancel
                    </button>
                </div>-->
                <div class="col-xs-6 col-xs-offset-3">
                    <button type="submit" class="btn btn-default form-control">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer">
        
    </div>
</div>