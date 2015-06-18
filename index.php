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
                $('tr img').mouseenter(function(event){
                    event.stopPropagation();

                    $('.zoomContainer').remove();

                    switch($(this).prop('class')){
                        case 'imgA':
                            $(this).elevateZoom({zoomWindowOffetx:206,zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                            break;

                        case 'imgB':
                            $(this).elevateZoom({zoomWindowOffetx:103,zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                            break;

                        case 'imgC':
                            $(this).elevateZoom({zoomWindowPosition:2,zoomWindowWidth:300,zoomWindowHeight:300});
                            break;
                    }
                });
                $('.openListing').click(function(event){
                    event.stopPropagation();
                    event.preventDefault();
                });
                $('tr').click(function(){
                    if($('#edit').is(':visible')){
                        $('#edit').slideUp();
                    }
                });
                $('.advanced_control').click(function(event){
                    event.preventDefault();
                    $(this).blur();
                    switch($(this).attr('href')){
                        case 'select_all':
                            $.each($('tr').find(':checkbox'),function(){
                                $(this).prop("checked",true);
                                $(this).closest('tr').addClass('active');
                            });
                            break;
                        case 'deselect_all':
                            $.each($('tr').find(':checkbox'),function(){
                                $(this).prop("checked",false);
                                $(this).closest('tr').removeClass('active');
                            });
                            break;
                        case 'new':
                            if($('#new').is(':visible')){
                                $('#new').slideUp();
                            }
                            else{
                                $('#new').slideUp();
                                $('#edit').slideUp();
                                $('#new').slideToggle();
                            }
                            break;
                        case 'edit':
                            var checked = getChecked();
                            if(checked.length > 1){
                                alert('You can only edit one row at a time!');
                                return;
                            }
                            else if(checked.length === 0){
                                alert('In order to edit a row, please select one.');
                                return;
                            }
                            $('#NAME').text(checked[0]);
                            $('#edit form').attr('action','libraries/update.php?page=<?=(isset($_GET['subnav']) ? $_GET['subnav'] : '')?>&action=edit&names='+checked[0]);
                            if($('#edit').is(':visible')){
                                $('#edit').slideUp();
                            }
                            else{
                                $('#new').slideUp();
                                $('#edit').slideUp();
                                $('#edit').slideToggle();
                            }
                            break;
                        case 'delete':
                            var checked = getChecked();
                            if(checked.length === 0){
                                alert('In order to delete a row, please select one.');
                                return;
                            }
                            if(confirm("Are you sure you want to delete the selected items?")){
                                window.location.href = "libraries/update.php?page=<?=(isset($_GET['subnav']) ? $_GET['subnav'] : '')?>&action=delete&names="+JSON.stringify(checked);
                            }
                            break;
                    }
                });
            });

            function getChecked(){
                var checked = new Array();

                $.each($('tr').find('.checkbox:checked'),function(){
                    checked.push( $(this).val() );
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
