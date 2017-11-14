<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/campers/index-init.php');
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
                            <div class="actions pull-right" style="margin-top:-6px;">
                                <form name="frmFilter" action="" method="get">
                                <select name="week" id="week" class="">
                                    <option value="">-- All Weeks --</option>
                                    <?php
                                    if(is_array($arrCamps) && count($arrCamps)>0){
                                        foreach($arrCamps as $week){
                                            if(isset($_REQUEST['week']) && $week['id']==$_REQUEST['week']){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                            echo '<option value="'.$week['id'].'" '.$selected.'>'.$week['title'].' - '.$week['campTitle'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-primary btnFilter">Filter</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <!--<th><input name="chkRecordId" value="0" onclick="checkAll(this.form)" type='checkbox' class="checkbox" /></th>-->
                                        <th>Camp</th>
                                        <th>Year</th>
                                        <th>Parent Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Total Campers</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th width="120">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(is_array($result) && count($result)>0){
                                        foreach($result as $row){
                                            $deleteItem=ADMIN_SITE_URL."campers.php?act=delete&id=".$row['id'];
                                            $address = "";
                                            if($row['primary_address'] !== ""){
                                                $address .= $row['primary_address'];
                                            }
                                            if($row['primary_address2'] !== ""){
                                                $address .= ", ".$row['primary_address2'];
                                            }
                                            if($row['city'] !== ""){
                                                $address .= ", ".$row['city'];
                                            }
                                            if($row['state'] !== ""){
                                                $address .= ", ".$row['state'];
                                            }
                                            if($row['zipcode'] !== ""){
                                                $address .= " - ".$row['zipcode'];
                                            }
                                    ?>
                                    <tr id="tr<?php echo $row['id'];?>">
                                        <!--<td align="center"><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $row['id'];?>" /></td>-->
                                        <td><?php echo $row['camp_title'];?></td>
                                        <td><?php echo $row['campyear'];?></td>
                                        <td><?php echo ucwords($row['first_name'].' '.$row['last_name']);?></td>
                                        <td><?php echo $address;?></td>
                                        <td><?php echo $row['phone'];?></td>
                                        <td><?php echo $row['total_campers'];?></td>
                                        <td>$<?php echo $row['total_amount'];?></td>
                                        <td align="center">
                                            <?php echo $row['payment_status'];?>
                                        </td>
                                        <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                                        <td>
                                            <a id="btn<?php echo $row['id'];?>" rel="<?php echo $row['id'];?>" class="btn btn-primary btnViewCamp" href="javascript:void(0)">View Details</a>
                                            <a class="btn btn-danger" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
                                        </td>
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
<style type="text/css">
select{padding:4px; border:1px solid #CCC;}
.btnFilter{padding:5px 10px !important;}
</style>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#campersPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 8, "DESC" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,9 ] }
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
function confirmDelete() {
    if(!confirm("Are you sure you want to delete this record?")) {
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
    if(confirm("Are you sure want to update the status of this registration?")) {
        $.ajax({
            url:'<?php echo AJAX_PATH;?>admin/ajaxUpdateStatus.php',
            dataType: "json",
            method: "post",
            data: {id:id,st:status,tb:'camp_registrations'},
            cache: false,
            success:function(data){
                var obj = jQuery.parseJSON(JSON.stringify(data));
                alert(obj.message);
                if(obj.result == "success"){
                    if(status==0){
                        $(this_link).attr("rel",1).html('<img src="<?php print IMG_PATH;?>/deactivate.png" title="Click to activate" alt="Inactive" border="0" />');
                    }else{
                        $(this_link).attr("rel",0).html('<img src="<?php print IMG_PATH;?>/activate.png" title="Click to deactivate" alt="Active" border="0" />');
                    }
                    return false;
                }else{
                    alert(obj.message);
                    return false;
                }
            }
        });
    }
    return false;
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>