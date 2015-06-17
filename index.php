<?php
    session_start();
    require_once('classes/portal.php');
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
        <script src="libraries/selectable.js"></script>
        <script src="libraries/elevatezoom-master/jquery.elevatezoom.js"></script>
        <script src="libraries/common.js"></script>
    </head>
    <body>
        <div class="col-lg-12">
            <?php
                if(portal::isSignedIn()){
            ?>
            <div class="row">
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <a href="?nav=home" class="navbar-brand"><!--<img class="navbar-brand" src="images/logo.png">-->ALPHA BUILD</a>
                        </div>

                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li <?=isset($_GET['nav']) && $_GET['nav'] === 'home' ? 'class="active"' : ''?>><a href="?nav=home">Home</a></li>
                                <li <?=isset($_GET['nav']) && $_GET['nav'] === 'admin' ? 'class="active"' : ''?>><a href="?nav=admin">Admin</a></li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="libraries/gate.php?portal=close">Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row" style="padding-top:60px;">
                <?php
                    if(isset($_GET['nav'])){
                        include('views/'.$_GET['nav'].'.php');
                    }
                ?>
            </div>
            <?php
                }
                else{
            ?>
            <div class="container">
                <form method="post" action="libraries/gate.php?portal=open" style="padding-top:35vh;" autocomplete="off">
                    <div class="col-lg-4 col-lg-offset-4">
                        <!--<img style="width:100%;padding-bottom:15px;" src="images/logo.png">-->

                        <input type="text" name="USER_NAME" class="form-control" autocomplete="off">

                        <input type="password" name="USER_PASS" class="form-control" autocomplete="off">

                        <button type="submit" class="btn btn-default form-control">Sign In</button>
                        <?php
                            if(isset($_SESSION['ERR_MSG'])){
                                echo '<div class="alert alert-danger text-center" role="alert">'.$_SESSION['ERR_MSG'].'</div>';
                                unset($_SESSION['ERR_MSG']);
                            }
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
