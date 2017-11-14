<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/camps/index-init.php');
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
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <button name="add-new-doctor" class="btn btn-primary" type="button" onclick="javascript:return addNewCamp();"><i class="fa fa-plus-circle"></i> Add New Camp</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th>Title</th>
                                            <th>Total Sessions</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem=ADMIN_SITE_URL."camps.php?act=delete&id=".$row['id'];
                                        ?>
                                        <tr>
                                            <td><?php echo $row['year'];?></td>
                                            <td><?php echo ucwords($row['title']);?></td>
                                            <td><?php echo $row['total_sessions'];?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo ADMIN_SITE_URL.'add-camp.php?id='.$row['id'];?>">Edit</a>
                                                <a class="btn btn-primary" href="<?php echo ADMIN_SITE_URL.'camp.php?id='.$row['id'];?>">View</a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#campsPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 4 ] }
        ]
    });
});

function addNewCamp(){
    location.href="<?php echo ADMIN_SITE_URL; ?>add-camp.php";
    return false;
}
function confirmDelete() {
    if(!confirm("Are you sure you want to delete this camp?")) {
        return false;
    }
    else {
        return true;
    }
}
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>