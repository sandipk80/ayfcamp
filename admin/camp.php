<?php
include('../cnf.php');
##-----------CHECK ADMIN LOGIN START---------------##
validateAdminLogin();
##-----------CHECK ADMIN LOGIN END---------------##
include(LIB_PATH . 'admin/camps/view-init.php');
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
                <li><a href="<?php echo ADMIN_SITE_URL;?>camps.php">Camps</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <button class="btn btn-primary" id="btnBack">Back</button>
                            </div>
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%">Title</td>
                                    <td><?php echo $camp['title']; ?></td>
                                </tr>
                                <tr>
                                    <td>Total Sessions</td>
                                    <td><?php echo $camp['total_sessions'];?></td>
                                </tr>


                                <?php
                                if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                                    foreach($camp['sessions'] as $sKey=>$sVal){
                                        $k = $sKey+1;
                                ?>
                                <tr>
                                    <td colspan="2" class="form-group margin20">
                                        <h3 class="rowHeader">
                                            SESSION <?php echo $k;?>
                                            <a class="import-link" href="#">Download Campers</a>
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start From</td>
                                    <td><?php echo date("l F d, Y", strtotime($sVal['start_from']));?></td>
                                </tr>
                                <tr>
                                    <td>End at</td>
                                    <td><?php echo date("l F d, Y", strtotime($sVal['end_at']));?></td>
                                </tr>
                                <tr>
                                    <td>Rate</td>
                                    <td>$<?php echo $sVal['rate'];?></td>
                                </tr>
                                <tr>
                                    <td>Limit</td>
                                    <td><?php echo $sVal['camper_limit'];?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            </table>
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
    $("#campsPage").addClass("active");

	$(document).on('click', '#btnBack', function (e){
		window.location.href = "camps.php";
	});
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>