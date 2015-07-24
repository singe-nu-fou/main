<?php
    /* =======================================================================
     * (C) 2015 Stephen Palmer
     * All Rights Reserved
     * File: warp.php
     * Description: Navigateable script that takes advantage of portal's warp
     *              function. This is primarily used for signing into the site. 
     *              Accepts get parameters for the page/class and the 
     *              action/function. Warp picks up the slack from there.
     * Author: Stephen Palmer <stephen.palmerjr@outlook.com>
     * PHP Version: 5.4
     * ======================================================================= */

    session_start();
    require_once('../classes/portal.php');
    portal::warp($_GET['nav'],$_GET['action']);