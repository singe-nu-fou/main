<?php
    require_once('../classes/portal.php');
    portal::redirect(portal::warp($_GET['nav'],$_GET['action']));
