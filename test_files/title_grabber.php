<?php
    error_reporting(E_ERROR | E_PARSE);
    if(isset($_POST['site'])){
        if($site = fopen($_POST['site'],"r")){
            while(!feof($site)){
                $line = fgets($site,1024);
                if(preg_match("@\<title\>(.*)\</title\>@i",$line,$title)){
                    $siteTitle = '<a href="'.$_POST['site'].'" target="__blank" style="text-decoration:none;">'.$title[1].'</a>';
                }
            }
        }
        else{
            $siteTitle = 'Error - There Was An Issue Grabbing This Title';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <style>
            
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $('input').keyup(function(){
                    var siteURL = $(this).val();
                    switch(true){
                        case validCheck(siteURL):
                            $('button').prop('disabled',false);
                            break;
                        default:
                            $('button').prop('disabled',true);
                            break;
                    }
                });
            });
            
            function validCheck(siteURL){
                if(/^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(siteURL) && siteURL.match(/^http([s]?):\/\/.*/)){
                    return true;
                }
                return false;
            }
        </script>
    </head>
    <body>
        <div class="col-xs-6 col-xs-offset-3">
            <form method="POST" action="">
                <h4 style="text-align:center;">Web Page Title Grabber</h4>
                <div class="input-group">
                    <span class="input-group-addon">
                        <?=(isset($_POST['site'])) ? $siteTitle: 'Enter a URL';?>
                    </span>
                    <input name="site" type="text" value="<?=(isset($_POST['site'])) ? $_POST['site'] : 'http://';?>" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Grab It!</button>
                    </span>
                </div>
                <h4 style="text-align:center;"><?=(isset($siteLink)) ? $siteLink: '';?></h4>
            </form>
        </div>
    </body>
</html>