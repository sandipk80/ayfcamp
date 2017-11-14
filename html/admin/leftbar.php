<!--sidebar left start-->
<aside class="sidebar sidebar-left">
    <div class="sidebar-profile">
        <div class="avatar">
            <img class="img-circle profile-image" src="<?php echo IMG_PATH;?>owner-icon.png" alt="profile">
        </div>
        <div class="profile-body dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><h4><?php echo $_SESSION['admin_full_name'];?><span class="caret"></span></h4></a>
            <small class="title">Admin Account</small>
            <ul class="dropdown-menu animated fadeInRight" role="menu">
                <li>
                    <a href="javascript:void(0);">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Admin Account</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo ADMIN_SITE_URL;?>change-password.php">
                        <span class="icon"><i class="fa fa-user"></i>
                        </span>Change Password</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo ADMIN_SITE_URL;?>logout.php">
                        <span class="icon"><i class="fa fa-sign-out"></i>
                        </span>Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <nav>
        <h5 class="sidebar-header">Navigation</h5>
        <ul class="nav nav-pills nav-stacked">
            <li id="dashboardPage" class="active">
                <a href="<?php echo ADMIN_SITE_URL;?>dashboard.php" title="Dashboard">
                    <i class="fa fa-fw fa-tachometer"></i> Dashboard
                </a>
            </li>
            <li id="campsPage">
                <a href="<?php echo ADMIN_SITE_URL;?>camps.php" title="">
                    <i class="fa fa-medkit fa-fw"></i>Camps Management
                </a>
            </li>
            <li id="usersPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>users.php" title="">
                    <i class="fa fa-fw fa-user"></i> Users
                </a>
            </li>
            <li id="campersPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>camp-registrations.php" title="">
                    <i class="fa fa-fw fa-user"></i> Camp Registrations
                </a>
            </li>
            <li id="couponsPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>coupons.php" title="">
                    <i class="fa fa-fw fa-heart"></i> Vouchers
                </a>
            </li>
            <li id="busfaresPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>busfares.php" title="">
                    <i class="fa fa-fw fa-bus"></i> Bus Fares
                </a>
            </li>
            <li id="counsellorsPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>counsellors.php" title="">
                    <i class="fa fa-fw fa-user"></i> Counsellors
                </a>
            </li>
            <li id="counsellorsAppPage" class="nav-dropdown">
                <a href="<?php echo ADMIN_SITE_URL;?>counsellor-applications.php" title="">
                    <i class="fa fa-fw fa-info-circle"></i> Counsellor Applications
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!--sidebar left end-->