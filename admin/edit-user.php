<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/users/edit-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>

<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>users.php">Users</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
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
                        <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" name="frmEditUser" id="frmEditUser" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $parent['first_name'];?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $parent['last_name'];?>">
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $parent['email'];?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Primary Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $parent['phone'];?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Primary Parent or Guardian Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="primary_parent_name" id="primary_parent_name" value="<?php echo $parent['primary_parent_name'];?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Primary Parent or Guardian Phone Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="primary_parent_phone" id="primary_parent_phone" value="<?php echo $parent['primary_parent_phone'];?>">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Primary Parent or Guardian Email <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="primary_parent_email" id="primary_parent_email" value="<?php echo $parent['primary_parent_email'];?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 30px;">
                                        <input type="checkbox" name="reset_password" id="reset_password" value="1"> Reset Password
                                    </div>
                                </div>
                                <div class="col-md-10" id="pwdRow" style="display:none;background:#CCC;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="required">*</span></label>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Secondary Parent or Guardian Name </label>
                                    <input type="text" class="form-control" name="secondary_parent_name" id="secondary_parent_name" value="<?php echo $parent['secondary_parent_name'];?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Secondary Parent or Guardian Phone Number </label>
                                    <input type="text" name="secondary_parent_phone" id="secondary_parent_phone" class="form-control" value="<?php echo $parent['secondary_parent_phone'];?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Secondary Parent or Guardian Email </label>
                                    <input type="text" name="secondary_parent_email" id="secondary_parent_email" class="form-control" value="<?php echo $parent['secondary_parent_email'];?>">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Primary Home Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="primary_address" id="primary_address" value="<?php echo $parent['primary_address'];?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address2 </label>
                                    <input type="text" class="form-control" name="primary_address2" id="primary_address2" value="<?php echo $parent['primary_address2'];?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $parent['city'];?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State <span class="required">*</span></label>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">-- Select State --</option>
                                        <?php
                                        if(is_array($arrStates) && count($arrStates)>0){
                                            foreach($arrStates as $state){
                                                echo '<option value="'.$state['id'].'">'.$state['name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Zip / Post Code <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo $parent['zipcode'];?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Emergency Contact 1: Name, phone number & relation <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact1" id="emergency_contact1" value="<?php echo $parent['emergency_contact1'];?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Emergency Contact 2: Name, phone number & relation <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact2" id="emergency_contact2" value="<?php echo $parent['emergency_contact2'];?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group btn-row">
                                    <input type="hidden" name="uid" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="edit-user" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<style>
.panel .actions {top: 2px;}
.rwheader {
  background: #777777 none repeat scroll 0 0;
  border-bottom: 1px solid #cccccc;
  color: #ffffff !important;
  margin: 5px 20px 20px;
  overflow: hidden;
  padding: 10px;
}
.dtheader {
  border-bottom: 1px solid #cccccc;
  color: #ffffff !important;
  margin: 10px 10px 20px 10px;
  overflow: hidden;
  padding: 10px 5px;
}
</style>
<script type="text/javascript">
$("#reset_password").change(function() {
    if($(this).is(":checked")) {
        $("#pwdRow").show();
    }else{
        $("#pwdRow").hide();
    }
});

$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#usersPage").addClass("active");

    $("#state").val("<?php echo $parent['state'];?>");

    $("#frmEditUser").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: "required",
            phone: "required",
            primary_parent_name: "required",
            primary_parent_phone: "required",
            primary_parent_email: "required",
            primary_address: "required",
            city: "required",
            state: "required",
            zipcode: "required",
            emergency_contact1: "required",
            emergency_contact2: "required"
        }
    });
    $(document).on('click', '#btnCancel', function (e){
        window.location.href = "users.php";
    });
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>