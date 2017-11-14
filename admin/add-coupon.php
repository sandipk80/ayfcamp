<?php
include('../cnf.php');
##-----------CHECK ADMIN LOGIN START---------------##
validateAdminLogin();
##-----------CHECK ADMIN LOGIN END---------------##
include(LIB_PATH . 'admin/coupons/add-init.php');
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
							<form method="post" action="" name="frmAddCoupon" id="frmAddCoupon" class="form-horizontal form-border" enctype="multipart/form-data">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Vouchers Text</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <input type="text" class="form-control" name="coupon" placeholder="Coupon" id="coupon" value="<?php echo $coupon; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Discount Type</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option value="percent" <?php echo $discount_type=="percent" ? "selected" : "";?>>Percent</option>
                                                <option value="fixed" <?php echo $discount_type=="fixed" ? "selected" : "";?>>Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Discount</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <input type="text" class="form-control" name="discount" placeholder="Discount" id="discount" value="<?php echo $discount; ?>">
                                            <span class="input-group-addon" id="disType">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Expiry Date</label>
                                        <div class="col-sm-8 input-group m-bot15">
                                            <input type="text" class="form-control" name="expiry_date" placeholder="Expiry Date" id="expiry_date" value="<?php echo ($expiry_date!=='0000-00-00' && isset($expiry_date) && $expiry_date!=='') ? date('m/d/Y', strtotime($expiry_date)) : '';?>" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group btn-row">
                                        <input type="hidden" name="cid" value="<?php echo $_GET['id'];?>" />
                                        <input type="hidden" name="add-coupon" value="submit" />
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
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#couponsPage").addClass("active");

    $( "#expiry_date" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-0:+10", // this is the option you're looking for
    });

    $(document).on('change', '#discount_type', function (e){
        var dtype = $(this).val();
        if(dtype == "fixed"){
            $("#disType").html("$");
        }else{
            $("#disType").html("%");
        }
    });

	$("#frmAddCoupon").validate({
		rules: {
            coupon: "required",
            discount_type: "required",
            discount: "required",
            expiry_date: "required"
		}
    });
	$(document).on('click', '#btnCancel', function (e){
		window.location.href = "coupons.php";
	});
    
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>