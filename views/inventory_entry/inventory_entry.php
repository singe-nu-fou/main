<script>
    $(document).ready(function(){
        $('.inventory-control').change(function(){
            window.location.href = hrefScrub($(this).attr('name'),$(this).val(),window.location.href);
        });
    });
    
    function hrefScrub(index,value,href){
        var get;
        switch(index){
            case 'inventory[CATEGORY_ID]':
                get = '&category=';
                break;
            case 'inventory[CLASSIFICATION_ID]':
                get = '&classification=';
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
        <form action="processes/update.php?page=inventory_entry&action=insert" method="post">
            <div class="row">
                <div class="col-lg-4">
                    Category
                    <select name="inventory[CATEGORY_ID]" class="inventory-control form-control">
                        <option></option>
                        <?=(isset($CATEGORY_OPTIONS) ? $CATEGORY_OPTIONS : NULL)?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Classification
                    <select name="inventory[CLASSIFICATION_ID]" class="inventory-control form-control">
                        <option></option>
                        <?=(isset($CLASSIFICATION_OPTIONS) ? $CLASSIFICATION_OPTIONS : NULL)?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Condition
                    <select name="inventory[Condition]" class="form-control">
                        <option></option>
                        <?=(isset($CONDITION_OPTIONS) ? $CONDITION_OPTIONS : NULL)?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Quantity
                    <input type="text" class="form-control" name="inventory[Quantity]">
                </div>
                <div class="col-lg-4">
                    Weight
                    <input type="text" class="form-control" name="inventory[WEIGHT]">
                </div>
                <?=(isset($CHARACTERISTIC_FIELDS) ? $CHARACTERISTIC_FIELDS : NULL)?>
                <div class="col-lg-4">
                    SKU
                    <input type="text" class="form-control" name="inventory[SKU]">
                </div>
            </div>
            <div class="row" style="padding-top:15px;">
                <div class="col-xs-6 col-xs-offset-3">
                    <button type="submit" class="btn btn-default form-control">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer"></div>
</div>