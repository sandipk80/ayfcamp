<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo isset($pageTitle) ? $pageTitle." | ".SITE_NAME : SITE_NAME;?></title>

    <!-- Bootstrap -->
    <link href="<?php echo CSS_SITE_URL;?>bootstrap.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,100italic,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">

    <!-- Template CSS Files  -->
    <link href="<?php echo CSS_SITE_URL;?>font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo SCRIPT_SITE_URL;?>plugins/camera/css/camera.css" rel="stylesheet">
    <link href="<?php echo SCRIPT_SITE_URL;?>plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="<?php echo CSS_SITE_URL;?>style.css" rel="stylesheet">
    <link href="<?php echo CSS_SITE_URL;?>responsive.css" rel="stylesheet">
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-1.11.3.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-ui-1.10.1.custom.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>bootstrap.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo IMG_PATH;?>fav-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo IMG_PATH;?>fav-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo IMG_PATH;?>fav-72.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo IMG_PATH;?>fav-57.png">
    <link rel="shortcut icon" href="<?php echo IMG_PATH;?>fav.png">

</head>
<body>
<!-- Header Starts -->
<header class="main-header">
    <!-- Nested Container Starts -->
    <div class="container">
        <!-- Top Bar Starts -->
        <div class="top-bar">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    
                </div>
                <div class="col-sm-6 col-xs-12">
                    <ul class="list-unstyled list-inline">
                        <?php
                        if(isset($_SESSION['ayfcamp']['user']['userid']) && trim($_SESSION['ayfcamp']['user']['userid'])!=='') {
                        ?>
                        <li class=" hidden-sm hidden-xs">Welcome <?php echo isset($_SESSION['ayfcamp']['user']['name']) ? $_SESSION['ayfcamp']['user']['name'] : "";?></li>
                        <li>
                            <i class="fa fa-user"></i> <a href="<?php echo USER_SITE_URL;?>profile.php">User Portal</a>
                        </li>
                        <li>
                            <i class="fa fa-sign-out"></i> <a href="<?php echo USER_SITE_URL;?>logout.php">Logout</a>
                        </li>
                        <?php
                        }else{
                        ?>
                        <li>
                            <i class="fa fa-sign-in"></i> <a href="<?php echo USER_SITE_URL;?>login.php">User Login</a>
                        </li>
                        <li>
                            <i class="fa fa-user"></i> <a href="<?php echo USER_SITE_URL;?>signup.php">Signup</a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Top Bar Ends -->
        <!-- Navbar Starts -->
        <nav id="nav" class="navbar navbar-default" role="navigation">
            <div class="container-fluid bot-border">
                <!-- Navbar Header Starts -->
                <div class="navbar-header">
                    <!-- Collapse Button Starts -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collapse Button Ends -->
                    <!-- Logo Starts -->
                    <a href="<?php echo SITE_URL;?>" class="navbar-brand">
                        <?php echo '<img src="'.IMG_PATH.'logo.png" alt="">';?>
                    </a>
                    <!-- Logo Ends -->
                </div>
                <!-- Navbar Header Ends -->
                <!-- Navbar Collapse Starts -->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li id="registerCamp">
                            <a href="<?php echo SITE_URL;?>camp-registration.php">Summer Camp Registration</a>
                        </li>                        
                    </ul>
                </div>
                <!-- Navbar Collapse Ends -->
            </div>
        </nav>
        <!-- Navbar Ends -->
    </div>
    <!-- Nested Container Ends -->
</header>
<!-- Header Ends -->