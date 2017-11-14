<?php
include('../cnf.php');
################# CHECK LOGGED IN USER ##############
validateCounsellorLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'counsellors/home-init.php');
include(LIB_HTML . 'counsellors/header.php');
?>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery-birthday-picker.min.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<div class="main-banner five">
    <div class="container">
        <h2><?php echo $pageTitle;?></h2>
    </div>
</div>

<div class="container main-container">
    <!-- Doctor Profile Starts -->
    <?php include(LIB_HTML.'message.php');?>
    <div id="tab-general">
        <div class="row mbl">
            <div class="col-lg-12">
                <div class="row row-fluid">
                    <div class="content-box">
                        <div class="col-sm-12">
                            <p><a class="font22" href="<?php echo COUNSELLOR_SITE_URL;?>application.php" title="AYF Summer Camp First Time Counsellor Application">AYF Summer Camp First Time Counsellor Application </a>
                            <p><a class="font22" href="<?php echo COUNSELLOR_SITE_URL;?>application2.php" title="AYF Summer Camp Experienced (1+ Years) Counselor Application">AYF Summer Camp Experienced (1+ Years) Counsellor Application</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $(".navbar-nav li").removeClass("active");
});
</script>
<?php include(LIB_HTML . 'footer.php');?>