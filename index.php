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
        <script>
            $(document).ready(function(){
                $('.selectable').selectable();
                $('.CONTROL_PANEL').click(function(event){
                    switch($(this).attr('ID')){
                        case 'view':
                            event.preventDefault();
                            var checked = getChecked();
                            if(checked.length < 1){
                                alert('Please select one row in order to view.');
                            }
                            else{
                                window.location.href = $(this).attr('href')+'&id='+JSON.stringify(checked);
                            }
                            break;
                        case 'edit':
                            event.preventDefault();
                            var checked = getChecked();
                            if(checked.length < 1){
                                alert('Please select one row in order to edit.');
                            }
                            else{
                                window.location.href = $(this).attr('href')+'&id='+JSON.stringify(checked);
                            }
                            break;
                        case 'delete':
                            event.preventDefault();
                            var checked = getChecked();
                            if(checked.length < 1){
                                alert('Please select one row in order to edit.');
                            }
                            else{
                                window.location.href = 'libraries/update.php?page='+<?=((isset($_GET['subnav'])) ?  "'".$_GET['subnav']."'" : 'index')?>+'&action=delete&id='+JSON.stringify(checked);
                            }
                            break;
                        case 'select_all':
                            $.each($('tr').find('.checkbox:checkbox'),function(){
                                $(this).prop("checked",true);
                                $(this).closest('tr').addClass('active');
                            });
                            break;
                        case 'deselect_all':
                            $.each($('tr').find('.checkbox:checkbox'),function(){
                                $(this).prop("checked",false);
                                $(this).closest('tr').removeClass('active');
                            });
                            break;
                    }
                });
            });
            function getChecked(){
                var checked = new Array();

                $.each($('tr').find('.checkbox:checked'),function(){
                    checked.push($(this).val());
                });

                return checked;
            }
        </script>
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
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Currently signed in as <?=$_SESSION['USER_NAME']?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">User Profile</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="libraries/warp.php?nav=portal&action=signOut">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row" style="padding-top:70px;">
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
                <form method="post" action="libraries/warp.php?nav=portal&action=signIn" style="padding-top:35vh;" autocomplete="off">
                    <div class="col-lg-4 col-lg-offset-4">
                        <!--<img style="width:100%;padding-bottom:15px;" src="images/logo.png">-->

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
