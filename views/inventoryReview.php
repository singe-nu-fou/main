<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchModalLabel">Filter Inventory</h4>
            </div>
            <div class="modal-body">
            <?php
            $FILTERS = (isset($_GET['filters'])) ? json_decode($_GET['filters']) : NULL;
                        $CLASSIFICATIONS = portal::warp('classifications','getClassification');
                        $CLASS_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $CLASS_OPTIONS[] = '<option value="'.$ID.'">'.$CLASS_NAME.'</option>';
                        }
                        $TYPES = portal::warp('types','getType');
                        $TYPE_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($TYPES AS $KEY=>$VALUE){
                            extract($VALUE);
                            $TYPE_OPTIONS[] = '<option value="'.$ID.'">'.$TYPE_NAME.'</option>';
                        }
                        $CONDITIONS = array(
                            'Vintage',
                            'New',
                            'Pre-Owned',
                            'Fashion',
                            'Damaged'
                        );
                        $CONDITION_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($CONDITIONS AS $VALUE){
                            $CONDITION_OPTIONS[] = '<option value="'.$VALUE.'">'.$VALUE.'</option>';
                        }
                        $SORTERS = portal::warp('users','getUserGroup',array('USER_TYPE'=>'SORTER'));
                        $SORTER_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($SORTERS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $SORTER_OPTIONS[] = '<option value="'.$ID.'">'.$USER_NAME.'</option>';
                        }
                        $SKUERS = portal::warp('users','getUserGroup',array('USER_TYPE'=>'SKUER'));
                        $SKUER_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($SKUERS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $SKUER_OPTIONS[] = '<option value="'.$ID.'">'.$USER_NAME.'</option>';
                        }
                        $PHOTOGRAPHERS = portal::warp('users','getUserGroup',array('USER_TYPE'=>'PHOTOGRAPHER'));
                        $PHOTOGRAPHER_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($PHOTOGRAPHERS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $PHOTOGRAPHER_OPTIONS[] = '<option value="'.$ID.'">'.$USER_NAME.'</option>';
                        }
                        $CROPPERS = portal::warp('users','getUserGroup',array('USER_TYPE'=>'CROPPER'));
                        $CROPPER_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($CROPPERS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $CROPPER_OPTIONS[] = '<option value="'.$ID.'">'.$USER_NAME.'</option>';
                        }
                        $LISTERS = portal::warp('users','getUserGroup',array('USER_TYPE'=>'LISTER'));
                        $LISTER_OPTIONS = array(
                            '<option></option>'
                        );
                        foreach($LISTERS AS $KEY=>$VALUE){
                            extract($VALUE);
                            $LISTER_OPTIONS[] = '<option value="'.$ID.'">'.$USER_NAME.'</option>';
                        }
                        echo '<div class="row">
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
                                                Class
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$CLASS_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Type
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$TYPE_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Condition
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$CONDITION_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Sorter
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$SORTER_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Skuer
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$SKUER_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Photographer
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$PHOTOGRAPHER_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Cropper
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$CROPPER_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                Lister
                                            </span>
                                            <select class="form-control">
                                                '.implode('',$LISTER_OPTIONS).'
                                            </select>
                                        </div>
                                    </div>
                                </div>';
            ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default">Filter</button>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('classes/table.php');
    $URL = '?'.$_SERVER['QUERY_STRING'];
    if(isset($_GET['id'])){
        $TEMP = explode('&id',$URL);
        $URL = $TEMP[0];
    }
    $ACTION = array(
        'edit'=>'&action=edit'
    );
    $TITLE = 'Review Inventory Items';
    $CONTROL_PANEL = array(
        'Select All'=>array(
            'id'=>'select_all'
        ),
        'Deselect All'=>array(
            'id'=>'deselect_all'
        ),
        'Edit Item'=>array(
            'id'=>'edit',
            'href'=>((strpos($_SERVER['QUERY_STRING'],'&action=edit')) ? portal::scrubString($ACTION,'',$URL) : portal::scrubString($ACTION,'',$URL).$ACTION['edit'])
        ),
        'Delete Item'=>array(
            'id'=>'delete'
        )
    );
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'edit':
                unset($CONTROL_PANEL['Edit Item']);
                break;
        }
    }
    $THEAD = array(
        'SKU'=>'SKU',
        'Class'=>'CLASS_NAME',
        'Type'=>'TYPE_NAME',
        'Sorter'=>'SORTER',
        'Skuer'=>'SKUER',
        'Photographer'=>'PHOTOGRAPHER',
        'Cropper'=>'CROPPER',
        'Lister'=>'LISTER',
        'Last Modified'=>'LAST_MODIFIED'
    );
    $MODE = array(
        'filters',
        ((isset($_GET['action'])) ? $_GET['action'] : NULL)
    );
    $TABLE = new table($TITLE,$CONTROL_PANEL,$MODE,$THEAD,'selectable');
    echo $TABLE->getTable();