<?php
    session_start();
    require_once('classes/portal.php');
    require_once('classes/table.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alpha Build</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="libraries/common.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script>
            var nav = <?=((isset($_GET['subnav'])) ?  "'".$_GET['subnav']."'" : "'index'")?>;
        </script>
        <script src="libraries/common.js"></script>
    </head>
    <body>
        <div class="col-lg-12">
            <?php
                if(portal::isSignedIn()){
            ?>
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle Navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <a href="?nav=main" class="navbar-brand"><img class="navbar-brand" src="images/logo.jpg" style="margin:-26px -15px 0px -18px;width:139.16px;height:76.16px;"></a>
                        </div>

                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="visible-lg<?=isset($_GET['nav']) && $_GET['nav'] === 'main' ? ' active' : ''?>"><a href="?nav=main">Home</a></li>
                                <ul class="nav navbar-nav hidden-lg">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                include('models/main/main.php');
                                                foreach($LIST AS $KEY=>$VALUE){
                                                    echo '<li><a href="?nav=main&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                                    if($_SESSION['USER_TYPE'] === 'ADMIN'){
                                ?>
                                <li class="visible-lg<?=isset($_GET['nav']) && $_GET['nav'] === 'admin' ? ' active' : ''?>"><a href="?nav=admin">Settings</a></li>
                                <ul class="nav navbar-nav hidden-lg">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                include('models/admin/admin.php');
                                                foreach($LIST AS $KEY=>$VALUE){
                                                    echo '<li><a href="?nav=admin&subnav='.$VALUE['subnav'].$VALUE['params'].'">'.$KEY.'</a></li>';
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                                <?php
                                    }
                                ?>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Currently signed in as <?=$_SESSION['USER_NAME']?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">User Profile</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="processes/warp.php?nav=portal&action=signOut">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row no-gutter">
                <?php
                    portal::getMsg();
                    if(isset($_GET['nav'])){
                        portal::navigate($_GET['nav']);
                    }
                ?>
            </div>
            <?php
                }
                else{
            ?>
            <div class="container">
                <form method="post" action="processes/warp.php?nav=portal&action=signIn" style="padding-top:30vh;" autocomplete="off">
                    <div class="col-lg-4 col-lg-offset-4">
                        <img style="width:100%;padding-bottom:15px;" src="images/logo.jpg">

                        <input type="text" name="USER_NAME" class="form-control" autocomplete="off">

                        <input type="password" name="USER_PASSWORD" class="form-control" autocomplete="off">

                        <button type="submit" class="btn btn-default form-control">Sign In</button>
                        <?php
                            portal::getMsg();
                        ?>
                    </div>
                </form>
            </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>