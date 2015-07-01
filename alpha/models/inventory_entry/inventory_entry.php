<?php
    $CATEGORIES = portal::warp('category','getCategory');
    $CATEGORY_OPTIONS = array();
    foreach($CATEGORIES AS $KEY=>$VALUE){
        extract($VALUE);
        $CATEGORY_OPTIONS[] = '<option value="'.$ID.'"'.((isset($_GET['category']) && $ID === $_GET['category']) ? ' selected' : '').'>'.$CATEGORY.'</option>';
    }
    $CATEGORY_OPTIONS = implode(',',$CATEGORY_OPTIONS);
    if(isset($_GET['category'])){
        $CLASSIFICATIONS = portal::warp('category','getCategoryClassification',array('ID'=>$_GET['category']));
        $CLASSIFICATION_OPTIONS = array();
        foreach($CLASSIFICATIONS AS $KEY=>$VALUE){
            extract($VALUE);
            $CLASSIFICATION_OPTIONS[] = '<option value="'.$ID.'"'.((isset($_GET['classification']) && $ID === $_GET['classification']) ? ' selected' : '').'>'.$CLASSIFICATION.'</option>';
        }
        $CLASSIFICATION_OPTIONS = implode('',$CLASSIFICATION_OPTIONS);
    }
    $CONDITION_OPTIONS = array(
        'New',
        'Pre-Owned',
        'Damaged'
    );
    foreach($CONDITION_OPTIONS AS $OPTION){
        $CONDITION_OPTIONS[] = '<option value="'.$OPTION.'">'.$OPTION.'</option>';
    }
    $CONDITION_OPTIONS = implode('',$CONDITION_OPTIONS);
    if(isset($_GET['category']) && isset($_GET['classification'])){
        $CHARACTERISTICS = portal::warp('classification','getClassificationCharacteristic',array('CATEGORY_ID'=>$_GET['category'],'CLASSIFICATION_ID'=>$_GET['classification']));
        $CHARACTERISTIC_FIELDS = array();
        foreach($CHARACTERISTICS AS $KEY=>$VALUE){
            extract($VALUE);
            $CHARACTERISTIC_FIELDS[] = '<div class="col-lg-4">
                                          '.$CHARACTERISTIC.'<input type="text" class="form-control" name="inventory['.$CHARACTERISTIC.']">
                                      </div>';
        }
        $CHARACTERISTIC_FIELDS = implode('',$CHARACTERISTIC_FIELDS);
    }