<?php
include('../cnf.php');

##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##

include(LIB_PATH . 'admin/busfares/index-init.php');
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
                                <button name="add-new-coupon" class="btn btn-primary" type="button" onclick="javascript:return addNewBusfare();"><i class="fa fa-plus-circle"></i> Add New Bus fare</button>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Fare</th>
                                            <th>Waitlist</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem = ADMIN_SITE_URL."busfares.php?act=delete&id=".$row['id'];
                                                $activeURL = ADMIN_SITE_URL."busfares.php?act=active&id=".$row['id'];
                                                $inactiveURL = ADMIN_SITE_URL."busfares.php?act=inactive&id=".$row['id'];
                                        ?>

                                        <tr>
                                            <td><?php echo ucwords($row['name']);?></td>
                                            <td>$<?php echo $row['amount'];?></td>
                                            <td><?php echo $row['waitlist']=="1" ? "Yes" : "No";?></td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo ADMIN_SITE_URL.'add-busfare.php?id='.$row['id'];?>">Edit</a>
                                                <a class="btn btn-danger" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
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
    $("#busfaresPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 3, "asc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 3 ] }
        ]
    });
});

function addNewBusfare(){
    location.href="<?php echo ADMIN_SITE_URL; ?>add-busfare.php";
    return false;
}

function confirmDelete() {
    if(!confirm("Are you sure you want to delete this busfare? Click 'OK' to continue.")) {
        return false;
    }
    else {
        return true;
    }
}

$(document).on("click", ".updateStatus", function (e) {
    var this_link = $(this);
    var status = $(this).attr("rel");
    var id = $(this).attr("data");
    if(confirm("Are you sure want to update the status of this busfare?")) {
        if(status == "0"){
            location.href = '<?php echo ADMIN_SITE_URL;?>busfares.php?act=inactive&id='+id;
            return false;
        }else{
            location.href = '<?php echo ADMIN_SITE_URL;?>busfares.php?act=active&id='+id;
            return false;
        }
    }
    return false;
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>