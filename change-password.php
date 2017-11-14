<?php
include('cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateUserLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'users/change-password-init.php');
include(LIB_HTML . 'header.php');
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<div class="main-banner five">
    <div class="container">
        <h2><span>Change Password</span></h2>
    </div>
</div>
<div class="container main-container">
    <div class="contact-content">
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <h3>Change your account password below</h3>
                <div class="status alert alert-success contact-status"></div>
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
                <form id="frmChangePassword" class="contact-form" name="frmChangePassword" method="post" action="" role="form">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="curr_password">Current Password <span class="required">*</span></label>
                                <input type="password" class="form-control" name="curr_password" id="curr_password" value="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="password">New Password <span class="required">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" value="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="">
                            </div>
                        </div>

                        <div class="col-xs-8">
                            <input type="hidden" name="change-password" value="Submit" />
                            <input type="submit" class="btn btn-black text-uppercase" value="Submit">
                            <input type="button" class="btn btn-black text-uppercase" value="Cancel" id="btnCancel" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    // validate signup form on keyup and submit
    $("#frmChangePassword").validate({
        rules: {
            curr_password: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        messages: {
            curr_password: {
                required: "Please enter your current password",
                minlength: "Your current password must be at least 5 characters long"
            },
            password: {
                required: "Please enter the new password",
                minlength: "Your new password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please enter the new password again",
                minlength: "Confirm password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });

    $("#btnCancel").click(function () {
        window.location.href = "<?php echo USER_SITE_URL;?>";
    });

});
</script>
<?php include(LIB_HTML . 'footer.php');?>