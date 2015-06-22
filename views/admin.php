<?php
    $SUBNAV = isset($_GET['subnav']) ? $_GET['subnav'] : NULL;
    $LIST = array(
        'Mapping' => array(
            'subnav' => 'mapping',
            'params' => '&orderBy=ID&order=ASC'
        ),
        'Classifications' => array(
            'subnav' => 'classifications',
            'params' => '&orderBy=ID&order=ASC'
        ),
        'Types' => array(
            'subnav' => 'types',
            'params' => '&orderBy=ID&order=ASC'
        ),
        'Attributes' => array(
            'subnav' => 'attributes',
            'params' => '&orderBy=ID&order=ASC'
        ),
        'User Account Control' => array(
            'subnav' => 'users',
            'params' => '&orderBy=ID&order=ASC'
        ),
        'User Types' => array(
            'subnav' => 'userType',
            'params' => '&orderBy=ID&order=ASC'
        )
    );
?>
<div class="col-lg-2">
    <div class="panel panel-default">
        <ul class="list-group" style="list-style-type:none;">
            <?php
                foreach($LIST AS $KEY=>$VALUE){
                    echo '<li><a class="'.((isset($VALUE['subnav']) && $SUBNAV === $VALUE['subnav']) ? 'active ' : '').'list-group-item" href="?nav=admin&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
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
