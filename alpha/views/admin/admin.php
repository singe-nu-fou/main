<div class="col-lg-2">
    <div class="panel panel-default">
        <ul class="list-group" style="list-style-type:none;">
            <?=$LIST?>
        </ul>
    </div>
</div>
<div class="col-lg-10">
    <?php
        portal::getMsg();
        if(isset($SUBNAV)){
            portal::navigate($SUBNAV);
        }
    ?>
</div>