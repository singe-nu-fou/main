<?php
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <title>Loading...</title>
        <style>
            
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                if(location.hash === ''){
                    location.hash = '#home';
                }
                else{
                    navigation();
                }
                /*$('.nav li a').click(function(){
                    if($(this).attr('href') === location.hash){
                        navigation();
                    }
                });*/
            });

            $(window).on('hashchange',function(){
                $('title').text('Loading...');
                navigation();
            });

            function navigation(){
                $('.nav li a').each(function(){
                    $(this).attr('href') === location.hash ? $(this).parents('li').addClass('active') : $(this).parents('li').removeClass('active');
                });
                $('#content').fadeOut('slow',function(){
                    $('#content').load('views/'+location.hash.replace('#','')+'.php',function(responseText,textStatus,XMLHttpRequest){
                        switch(XMLHttpRequest.status){
                            case 404:
                                $('title').text('Where are you trying to go?');
                                //$('#content').html(responseText);
                                $('#content').load('views/redirect.php',function(){
                                    
                                });
                                break;
                            case 500:
                                break;
                        }
                        $('#content').fadeIn('slow');
                    });
                });
            }
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
                    <a class="navbar-brand" href="#home">Project name</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#portfolio">Portfolio</a>
                        </li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="content" class="container" style="padding-top:50px;">
            
        </div>
    </body>
</html>