<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'Submit Listing - 0' => array(
            'subnav' => 'recentlyListed',
            'params' => '&orderBy=&order=ASC'
        ),
        'Edit Listing' => array(
            'subnav' => 'editListing',
            'params' => ''
        ),
        'Submit Inventory' => array(
            'subnav' => 'inventoryEntry',
            'params' => ''
        ),
        'Edit Inventory' => array(
            'subnav' => 'inventoryEdit',
            'params' => ''
        ),
        'Recently Listed' => array(
            'subnav' => 'recentlyListed',
            'params' => '&orderBy=&order=ASC'
        ),
        'Inventory Review' => array(
            'subnav' => 'inventoryReview',
            'params' => ''
        ),
        'Photography Review' => array(
            'subnav' => 'photographyReview',
            'params' => ''
        )
    );
?>
<div class="col-lg-2">
    <div class="panel panel-default">
        <ul class="list-group" style="list-style-type:none;">
            <?php
                foreach($LIST AS $KEY=>$VALUE){
                    echo '<li><a class="'.((isset($VALUE['subnav']) && $SUBNAV === $VALUE['subnav']) ? 'active ' : '').'list-group-item" href="?nav=home&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
                }
            ?>
        </ul>
    </div>
</div>
<div class="col-lg-10">
    <?php
        portal::getMsg();
        if(isset($_GET['subnav'])){
            portal::navigate($_GET['subnav']);
        }
    ?>
</div>