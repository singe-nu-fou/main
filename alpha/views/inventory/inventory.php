<?php
    include('models/inventory/inventory.php');
?>
<div id="sidebar" class="visible-lg col-lg-2">
    <ul class="list-group" style="list-style-type:none;">
        <?php
            foreach($LIST AS $KEY=>$VALUE){
                echo '<li><a class="'.((isset($VALUE['subnav']) && $SUBNAV === $VALUE['subnav']) ? 'active ' : '').'list-group-item" href="?nav=inventory&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
            }
        ?>
    </ul>
</div>
<div id="content" class="col-lg-10">
    <?php
        portal::getMsg();
        if(isset($SUBNAV)){
            portal::navigate($SUBNAV);
        }
    ?>
</div>