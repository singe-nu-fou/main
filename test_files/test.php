<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<style>
    .navbar{
        margin-bottom:0px;
    }
    .no-gutter > div[class*="col-"]{
        padding-left:0px;
        padding-right:0px;
        height:94.5%;
        //max-height:100vh;
        overflow-y:auto;
    }
    #sidebar{
        border-right: 3px double #E7E7E7;
        background-color:#E7E7E7;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<div class="col-lg-12">
    <div class="row">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a href="?nav=inventory" class="navbar-brand"><!--<img class="navbar-brand" src="images/logo.png">-->ALPHA BUILD</a>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Currently signed in as <span class="caret"></span></a>
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
        <div id="sidebar" class="visible-lg col-lg-2">
            
        </div>
        <div id="content" class="col-lg-10">
            
        </div>
    </div>
</div>