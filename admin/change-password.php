<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/change-password-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo OWNER_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
ZZ            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <?php
                if(is_array($error) && count($error)>0) {
                ?>
                <!-- our error container -->
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>Oh snap! You got an error!</h4>
                <?php
                foreach($error as $key=>$val) {
                ?>
                <p><label class="error" for="<?php echo $key;?>"><?php echo $val;?></label></p>
                <?php
                    }
                }
                ?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Change Password</h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form method="post" action="" name="frmChangePassword" id="frmChangePassword" class="form-horizontal form-border" novalidate="novalidate">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Current Password</label>
                                    <div class="col-sm-6">
                                        <input value="" type="password" class="form-control" name="curr_password" placeholder="Current Password" id="curr_password">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-6">
                                        <input value="" type="password" class="form-control" name="password" placeholder="New Password" id="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Confirm Password</label>
                                    <div class="col-sm-6">
                                        <input value="" type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm_password">
                                    </div>
                                </div>
                                
                                <div class="form-group btn-row">
                                    <input type="submit" class="btn btn-success btn-square" name="change-password" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

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
        window.location.href = "<?php echo ADMIN_SITE_URL;?>dashboard.php";
    });

});
</script>
<?php include(LIB_HTML . 'admin/footer.php');?>