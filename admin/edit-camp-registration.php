<?php
include('../cnf.php');
##-----------CHECK ADMIN LOGIN START---------------##
validateAdminLogin();
##-----------CHECK ADMIN LOGIN END---------------##
require_once(LIB_PATH.'admin/campers/edit-registration-init.php');
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
                <li><a href="<?php echo ADMIN_SITE_URL;?>camp-registrations.php">Camp Registrations</a></li>
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

                        <div class="panel-body">
							<form method="post" action="" name="frmEditCamper" id="frmEditCamper" class="form-horizontal form-border" enctype="multipart/form-data">
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Week</label>
                                    <div class="col-sm-8">
                                        <select name="camp_session_id" id="camp_session_id" class="form-control">
	                                        <?php
	                                        if(is_array($camp['sessions']) && count($camp['sessions'])>0){
	                                            foreach($camp['sessions'] as $session){
	                                                $disable = "";
	                                                $dateRange = date("l F d, Y", strtotime($session['start_from'])).' to '.date("l F d, Y", strtotime($session['end_at']));
	                                                if($session['expire'] == "1"){
	                                                    $disable = "disabled";
	                                                }elseif($session['waitlist'] == "1"){
	                                                    //$style = "color:yellow;";
	                                                }
	                                                if($session['id'] == $camp_session_id){
	                                                	$selected = "selected";
	                                                }else{
	                                                	$selected = "";
	                                                }
	                                                echo '<option value="'.$session['id'].'" '.$selected.'>'.$session['title'].' ('.$dateRange.')</option>';
	                                            }
	                                        }
	                                        ?>
	                                    </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                	<label class="col-sm-2 control-label">Snackshop Amount</label>
                                	<div class="col-sm-4">
                                		<span class="fa fa-usd form-control-feedback"></span>
                                		<input type="text" name="snack_shop_amount" id="snack_shop_amount" class="form-control has-feedback" value="<?php echo $snack_shop_amount;?>">
                                	</div>
                            	</div>
                            	<div class="form-group">
                            		<label class="col-sm-2 control-label">Bus Option </label>
                            		<div class="col-sm-6">
	                            		<select name="bus_fare" id="bus_fare" class="form-control">
	                            			<option value="">-- Select Bus Fare --</option>
	                            			<option value="0">None</option>
	                            			<option value="1">To Camp $15</option>
	                            			<option value="2">From Camp $15</option>
	                            			<option value="3">Round Trip $25</option>
	                            			<option value="4">To Camp $15 - WAITLIST ONLY</option>
	                            			<option value="5">From Camp $15 - WAITLIST ONLY</option>
	                            			<option value="6">Round Trip $25 - WAITLIST ONLY</option>
	                        			</select>
                        			</div>
                    			</div>

                    			<div class="form-group btn-row">
                                    <input type="hidden" name="cid" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="edit-camper" value="submit" />
									<input type="submit" class="btn btn-success btn-square" value="Submit" />
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
<style>
.form-control-feedback {
  color: #333 !important;
  font-size: 16px;
  left: 15px;
  top: 10px;
}
.has-feedback {
  padding-left: 28px !important;
}
</style>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#campersPage").addClass("active");

	$("#camp_session_id").val("<?php echo $camp_session_id;?>");
    $("#bus_fare").val("<?php echo $bus_opt;?>");

	$("#frmEditCamper").validate({
		rules: {
            camp_session_id: "required"
		}
    });
	$(document).on('click', '#btnCancel', function (e){
		window.location.href = "camp-registrations.php";
	});
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>