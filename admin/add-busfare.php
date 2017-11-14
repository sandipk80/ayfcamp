<?php
include('../cnf.php');
##-----------CHECK ADMIN LOGIN START---------------##
validateAdminLogin();
##-----------CHECK ADMIN LOGIN END---------------##
include(LIB_PATH . 'admin/busfares/add-init.php');
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
                <li><a href="<?php echo ADMIN_SITE_URL;?>coupons.php">Vouchers</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
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
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>

                        <div class="panel-body panel-form">
							<form method="post" action="" name="frmAddBusfare" id="frmAddBusfare" class="form-horizontal form-border" enctype="multipart/form-data">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <input type="text" class="form-control" name="name" placeholder="Name" id="name" value="<?php echo $name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Waitlist</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <select class="form-control" name="waitlist" id="waitlist">
                                                <option value="0" <?php echo $waitlist=="0" ? "selected" : "";?>>No</option>
                                                <option value="1" <?php echo $waitlist=="1" ? "selected" : "";?>>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Fare</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <span class="input-group-addon" id="disType">$</span>
                                            <input type="text" class="form-control" name="amount" placeholder="Fare" id="amount" value="<?php echo $amount; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group btn-row">
                                        <input type="hidden" name="fid" value="<?php echo $_GET['id'];?>" />
                                        <input type="hidden" name="add-fare" value="submit" />
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
    </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#busfaresPage").addClass("active");

	$("#frmAddBusfare").validate({
		rules: {
            name: "required",
            amount: "required"
		}
    });
	$(document).on('click', '#btnCancel', function (e){
		window.location.href = "busfares.php";
	});
    
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>