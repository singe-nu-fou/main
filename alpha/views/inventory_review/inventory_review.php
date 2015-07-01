<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchModalLabel">Filter Inventory</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                SKU
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Category
                            </span>
                            <select class="form-control">
                                <?=$CATEGORY_OPTIONS?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Classifcaiton
                            </span>
                            <select class="form-control">
                                <?=$CLASSIFICATION_OPTIONS?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Condition
                            </span>
                            <select class="form-control">
                                <?=$CONDITION_OPTIONS?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default">Filter</button>
            </div>
        </div>
    </div>
</div>
<?=$TABLE->getTable();?>