<div class="col-lg-2">
    <div class="panel panel-default">
        <ul class="list-group" style="list-style-type:none;">
            <!--<li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'adsReport') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=adsReport">Ads Report</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'itemAttributes') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=itemAttributes">Item Attributes</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'itemClasses') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=itemClasses">Item Classes</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'itemTypes') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=itemTypes">Item Types</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'jobManagement') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=jobManagement">Job Management</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'metrics') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=metrics">Metrics</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'payrollReports') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=payrollReports">Payroll Reports</a></li>
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'scheduleManagement') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=scheduleManagement">Schedule Management</a></li>-->
            <li><a class="<?=(isset($_GET['subnav']) && $_GET['subnav'] === 'users') ? 'active' : ''?> list-group-item" href="?nav=admin&subnav=users&orderBy=ID&order=ASC">Users</a></li>
        </ul>
    </div>
</div>
<div class="col-lg-10">
    <?php
        if(isset($_GET['subnav'])){
            include('views/'.$_GET['subnav'].'.php');
        }
    ?>
</div>