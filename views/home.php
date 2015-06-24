<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'Submit Listing' => array(
            'subnav' => '',
            'params' => ''
        ),
        'Edit Listing' => array(
            'subnav' => '',
            'params' => ''
        ),
        'Recently Listed' => array(
            'subnav' => 'recentlyListed',
            'params' => '&orderBy=&order=ASC'
        ),
        'Submit Inventory' => array(
            'subnav' => 'inventoryEntry',
            'params' => ''
        ),
        'Inventory Review' => array(
            'subnav' => 'inventoryReview',
            'params' => '&orderBy=SKU&order=ASC'
        ),
        'Photography Review' => array(
            'subnav' => 'photographyReview',
            'params' => '&orderBy=&order=ASC'
        )
    );
?>
<script>
    $(document).ready(function(){
        $('.submit-listing').click(function(){
            var w = window.open("listing.php?mode=submit","newwindow","width=800,height=900,scrollbars=yes,menubar=no");
            w.focus();
            return false;
        });
        $('#edit-sku').submit(function(event){
            event.preventDefault();
            var SKU = $('#sku').val();
            if(!SKU || SKU.trim().length === 0){
                alert('Please enter a SKU in order to edit.');
            }
            else{
                var w = window.open('listing.php?mode=edit&sku='+SKU.trim(),'newwindow','width=800,height=900,scrollbars=yes,menubar=no');
                w.focus();
            }
        });
    });
</script>
<div class="col-lg-2">
    <div class="panel panel-default">
        <ul class="list-group" style="list-style-type:none;">
            <?php
                foreach($LIST AS $KEY=>$VALUE){
                    switch($KEY){
                        case 'Submit Listing':
                            echo '<li><a class="submit-listing list-group-item" style="border:none;">'.$KEY.' - 0</a></li>';
                            break;
                        case 'Edit Listing':
                            echo '<li class="list-group-item">
                                      <form id="edit-sku">
                                          <div class="input-group">
                                              <span class="edit-sku input-group-addon">
                                                  '.$KEY.'
                                              </span>
                                              <input id="sku" type="text" class="form-control">
                                              <div class="input-group-btn">
                                                  <button class="btn btn-default">
                                                      Edit
                                                  </button>
                                              </div>
                                        </div>
                                      </form>
                                  </li>';
                            break;
                        default:
                            echo '<li><a class="'.((isset($VALUE['subnav']) && $SUBNAV === $VALUE['subnav']) ? 'active ' : '').'list-group-item" href="?nav=home&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
                            break;
                    }
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