<?php
include('../cnf.php');
require_once(LIB_PATH.'admin/signin-init.php');
?>
    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!-->
    <html class="no-js">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo (isset($pageTitle) ? $pageTitle.' | ' : '');?> <?php echo SITE_NAME;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo ASSET_SITE_URL;?>img/favicon.ico" type="image/x-icon">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/bootstrap/css/bootstrap.min.css">
        <!-- Fonts  -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>css/simple-line-icons.css">
        <!-- CSS Animate -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>css/animate.css">
        <!-- Daterange Picker -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- Calendar demo -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>css/clndr.css">
        <!-- Switchery -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/switchery/switchery.min.css">
        <!-- Custom styles for this theme -->
        <link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>css/main.css">
        <!-- Feature detection -->
        <script src="<?php echo ASSET_SITE_URL;?>js/vendor/modernizr-2.6.2.min.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/js/vendor/html5shiv.js"></script>
        <script src="assets/js/vendor/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo ASSET_SITE_URL;?>js/vendor/jquery-1.11.1.min.js"></script>
        <script src="<?php echo ASSET_SITE_URL;?>plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo SCRIPT_SITE_URL;?>jquery-ui-1.10.1.custom.min.js"></script>
        <script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
        <script src="<?php echo SCRIPT_SITE_URL;?>jquery.metadata.js"></script>
        <script src="<?php echo SCRIPT_SITE_URL;?>jquery.form.js"></script>
        <script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?php echo ASSET_SITE_URL;?>js/vendor/html5shiv.js"></script>
        <script src="<?php echo ASSET_SITE_URL;?>js/vendor/respond.min.js"></script>
        <![endif]-->
        <style>
            #header .logo img {
                margin-right: 6px;
                margin-top: -30px;
                width: 200px;
            }
        </style>
    </head>

<body>
<section id="main-wrapper" class="theme-default">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div id="login-wrapper">
            <header>
                
                <div class="brand">
                    <img src="<?php echo IMG_PATH;?>logo.png" alt="" title="" />
                </div>
            </header>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Sign In
                    </h3>
                </div>
                <div class="panel-body">
                    <p> Login to access your account.</p>
                    <?php
                    if(is_array($errors) && count($errors)>0) {
                        ?>
                        <!-- our error container -->
                        <div class="error-container" style="display:block;">
                            <ol>
                                <?php
                                foreach($errors as $key=>$val) {
                                    ?>
                                    <li>
                                        <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ol>
                        </div>
                    <?php
                    }
                    include(LIB_HTML.'message.php');
                    ?>
                    <form name="frmLogin" id="frmLogin" class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="username" id="username"
                                       placeholder="Email">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <!--<a href="javascript:void(0)" class="help-block">Forgot Your Password?</a>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="loginsubmit" value="login">
                                <input type="submit"  class="btn btn-primary btn-block" value="Sign in" />
                                
                                <!--<a href="javascript:void(0)" class="btn btn-default btn-block">Not a member? Sign Up</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    // USer login validation & submission
    $("#frmLogin").validate({
        rules: {
            username: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter the password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });
});
</script>
<?php include(LIB_HTML . 'admin/footer.php');?>