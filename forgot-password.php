<?php
include('cnf.php');
require_once(LIB_PATH.'users/forgot-password-init.php');
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>AYF CAMP ‹ Log In</title>
    <!-- Bootstrap -->
    <link href="<?php echo CSS_SITE_URL;?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS_SITE_URL;?>login.css" rel="stylesheet">

    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-1.11.3.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-ui-1.10.1.custom.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>bootstrap.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
    <meta content="noindex,follow" name="robots">
    <style type="text/css">
    .login * {
        margin: 0;
        padding: 0;
    }
    </style>
</head>
<body class="login login-action-login wp-core-ui locale-en-us">
<div id="login">
    <h1><a tabindex="-1" title="" href="http://www.ayfcamp.org">AYF CAMP</a></h1>
    <?php
    if(is_array($error) && count($error)>0) {
        ?>
        <!-- our error container -->
        <div class="error-container" style="display:block;">
            <ol>
                <?php
                foreach($error as $key=>$val) {
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
    <form id="loginform" name="loginform" method="post" action="" role="form">
    <p>
        <label for="email">Username or Email</label>
        <input type="text" size="20" value="" class="input" id="email" name="email">
    </p>
    <p class="submit">
        <input type="hidden" name="forgot-password" value="Submit" />
        <input type="submit" value="Log In" class="button button-primary button-large" id="submit" name="submit">&nbsp;&nbsp;
        <button type="button" class="button button-primary button-large" style="margin:0 10px;" onclick="location.href='<?php echo USER_SITE_URL;?>'">Back</button>
    </p>
    </form>

</div>


<script type="text/javascript">
$(document).ready(function() {
    // USer login validation & submission
    $("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            }
        }
    });
});
</script>
</body>
</html>