<?php
include('../cnf.php');

##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##

include(LIB_PATH . 'admin/coupons/index-init.php');
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

                                <button name="add-new-coupon" class="btn btn-primary" type="button" onclick="javascript:return addNewCoupon();"><i class="fa fa-plus-circle"></i> Add New Voucher</button>

                            </div>

                        </div>

                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Coupon</th>
                                            <th>Discount</th>
                                            <th>Expiry Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem = ADMIN_SITE_URL."coupons.php?act=delete&id=".$row['id'];
                                                $activeURL = ADMIN_SITE_URL."coupons.php?act=active&id=".$row['id'];
                                                $inactiveURL = ADMIN_SITE_URL."coupons.php?act=inactive&id=".$row['id'];
                                        ?>

                                        <tr>
                                            <td><?php echo ucwords($row['coupon']);?></td>
                                            <td><?php echo $row['discount_type']=="fixed" ? "$".$row['discount'] : $row['discount']."%";?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['expiry_date']));?></td>
                                            <td align="center">
                                                <?php
                                                if ($row['status'] == "1") {
                                                ?>
                                                    <a rel="0" class="updateStatus" title="Click to deactivate" data="<?php echo $row['id'];?>" href="javascript:void(0)"><img src="<?php print IMG_PATH;?>/activate.png" title="Click to deactivate" alt="Click to deactivate" border="0"/></a>
                                                <?php
                                                }
                                                else {
                                                ?>
                                                    <a rel="1" class="updateStatus" title="Click to activate" data="<?php echo $row['id'];?>" href="javascript:void(0)"><img src="<?php print IMG_PATH;?>/deactivate.png" title="Click to activate" alt="Click to activate" border="0" /></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo ADMIN_SITE_URL.'add-coupon.php?id='.$row['id'];?>">Edit</a>
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
    $("#couponsPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 4 ] }
        ]
    });
});

function addNewCoupon(){
    location.href="<?php echo ADMIN_SITE_URL; ?>add-coupon.php";
    return false;
}

function confirmDelete() {
    if(!confirm("Are you sure you want to delete this coupon? Click 'OK' to continue.")) {
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
    if(confirm("Are you sure want to update the status of this coupon?")) {
        if(status == "0"){
            location.href = '<?php echo ADMIN_SITE_URL;?>coupons.php?act=inactive&id='+id;
            return false;
        }else{
            location.href = '<?php echo ADMIN_SITE_URL;?>coupons.php?act=active&id='+id;
            return false;
        }
    }
    return false;
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>