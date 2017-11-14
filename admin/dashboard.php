<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
require_once(LIB_PATH.'admin/dashboard-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1>Dashboard</h1>
        <p class="description">Welcome to Admin Portal</p>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active"><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>

            <!---------------------- WEEK OVERVIEWS ------------------------>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Week Overviews</h3>
                        <div class="actions pull-right">
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tblWeekOverviews">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>Start From</th>
                                    <th>End At</th>
                                    <th>Rate</th>
                                    <th>Camper Limit</th>
                                    <th>Total Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---------------------- END OF WEEK OVERVIEWS ------------------------>

            <!---------------------- PARENT REGISTRATION ------------------------>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Parent Registration</h3>
                        <div class="actions pull-right">
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tblParents">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Join Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---------------------- END OF PARENT REGISTRATIONS ------------------------>

            <!---------------------- WAITLIST REGISTRATION ------------------------>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Waitlist Registration</h3>
                        <div class="actions pull-right">
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tblWaitlist">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>Parent</th>
                                    <th>Camper</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---------------------- END OF WAITLIST REGISTRATIONS ------------------------>

            <!---------------------- Camp Registrations ------------------------>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Camp Registration</h3>
                        <div class="actions pull-right">
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tblCampRegistration">
                            <thead>
                                <tr>
                                    <th>Camp</th>
                                    <th>Parent Name</th>
                                    <th>Campers</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(is_array($arrRegistrations) && count($arrRegistrations)>0){
                                    foreach($arrRegistrations as $row){
                                ?>
                                <tr id="tr<?php echo $row['id'];?>">
                                    <td><?php echo $row['camp_title'];?></td>
                                    <td><?php echo ucwords($row['first_name'].' '.$row['last_name']);?></td>
                                    <td><a id="btn<?php echo $row['id'];?>" rel="<?php echo $row['id'];?>" class="btnViewCamp" href="javascript:void(0)"><?php echo $row['total_campers'];?></a></td>
                                    <td><i class="fa fa-dollar"></i><?php echo $row['total_amount'];?></td>
                                    <td align="center"><?php echo $row['payment_status'];?></td>
                                    <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
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
            <!---------------------- End of Camp Registrations ------------------------>

            <!---------------------- COUNSELLOR APPLICATIONS ------------------------>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Counsellor Applications</h3>
                        <div class="actions pull-right">
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tblCounsellorApplications">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date of Birth</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---------------------- END OF PARENT REGISTRATIONS ------------------------>


        </div>
    </section>
</section>
<style>
div.dataTables_length label{font-size: 12px !important;}
.span6 label,.dataTables_info,.pagination{font-size: 12px !important;}
</style>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#dashboardPage").addClass("active");
    $('#tblWeekOverviews').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "aaSorting": [[0,'asc']],
        "sAjaxSource": "<?php echo AJAX_PATH;?>admin/ajax_data_source_week_overviews.php",
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': []}
        ]
    });

    $('#tblParents').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "aaSorting": [[4,'desc']],
        "sAjaxSource": "<?php echo AJAX_PATH;?>admin/ajax_data_source_parents.php",
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': []}
        ]
    });

    $('#tblCounsellorApplications').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "aaSorting": [[4,'desc']],
        "sAjaxSource": "<?php echo AJAX_PATH;?>admin/ajax_data_source_counsellor_applications.php",
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [3]}
        ]
    });

    $('#tblWaitlist').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "aaSorting": [[3,'desc']],
        "sAjaxSource": "<?php echo AJAX_PATH;?>admin/ajax_data_source_waitlist.php",
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': []}
        ]
    });

    $('#tblCampRegistration').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 5, "DESC" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ ] }
        ]
    });

    $(document).on("click", ".btnViewCamp", function (e) {
        var rid = $(this).attr("rel");
        if(rid !== ""){
            $.ajax({
                url:'<?php echo AJAX_PATH;?>admin/getCampRegisterDetails.php',
                type:"get",
                data:{rid:rid},
                dataType: "html",
                success:function(data){
                    $('#tr'+rid).after(data);
                    $("#btn"+rid).removeClass("btnViewCamp");
                    $("#btn"+rid).addClass("btnHideCamp");
                    $("#btn"+rid).text("Hide Details");
                }
            });
        }
    });

    $(document).on("click", ".btnHideCamp", function (e) {
        var rid = $(this).attr("rel");
        if(rid !== ""){
            $("#crow"+rid).closest('tr').remove();
            $("#btn"+rid).removeClass("btnHideCamp");
            $("#btn"+rid).addClass("btnViewCamp");
            $("#btn"+rid).text("Show Details");
        }
    });
});

</script>
<?php include(LIB_HTML . 'admin/footer.php');?>