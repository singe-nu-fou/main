<?php
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <style>
            
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script src="assets/javascript/navigator.js"></script>
        <script>
            $(document).ready(function(){
                
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="?nav=home">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="?nav=portfolio">Portfolio</a>
                        </li>
                        <li>
                            <a href="?nav=about">About</a>
                        </li>
                        <li>
                            <a href="?nav=contact">Contact</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <?php
                            if(!isset($thing)){
                        ?>
                        <div class="form-group">
                            <input type="text" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success form-control">Sign in</button>
                        <?php
                            }
                            else{
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <?=$_SESSION['username']?>
                            </div>
                            <button type="submit" class="btn btn-success">Sign Out</button>
                        </div>
                        <?php
                            }
                        ?>
                    </form>
                </div>
            </div>
        </nav>
        <div id="content" class="container" style="padding-top:50px;">
            <?php
                $file_path = 'views/'.((isset($_GET['nav'])) ? $_GET['nav'] : 'home').'.php';
                if(file_exists($file_path)){
                    include($file_path);
                }
            ?>
        </div>
    </body>
</html>