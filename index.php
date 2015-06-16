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
                                <li <?=isset($_GET['nav']) && $_GET['nav'] === 'Link A' ? 'class="active"' : ''?>><a href="?nav=Link+A">Link A</a></li>
                                <li <?=isset($_GET['nav']) && $_GET['nav'] === 'Link B' ? 'class="active"' : ''?>><a href="?nav=Link+B">Link B</a></li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="libraries/gate.php?portal=close">Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row" style="padding-top:60px;">
                <div class="col-lg-12">
                    Test
                </div>
            </div>
            <?php
                }
                else{
            ?>
            <div class="container">
                <form method="post" action="libraries/gate.php?portal=open" style="padding-top:35vh;">
                    <div class="col-lg-4 col-lg-offset-4">
                        <img style="width:100%;padding-bottom:15px;" src="images/logo.png">

                        <input type="text" name="USER_NAME" class="form-control">

                        <input type="password" name="USER_PASS" class="form-control">

                        <button type="submit" class="btn btn-default form-control">Sign In</button>
                        <?php
                            if(isset($_SESSION['ERR_MSG'])){
                                echo '<div class="alert alert-danger text-center" role="alert">'.$_SESSION['ERR_MSG'].'</div>';
                                unset($_SESSION['messages']);
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
