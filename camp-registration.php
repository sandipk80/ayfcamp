<?php
include('cnf.php');

################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############

require_once(LIB_PATH.'users/camps/camp-registration-init.php');
include(LIB_HTML . 'header.php');
?>

<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>build.css" type="text/css" />
<link href="<?php echo CSS_SITE_URL;?>jquery.multiselect.css" rel="stylesheet" type="text/css">
<style>
.padding20{padding: 20px 0;}
.form-control-feedback {font-size: 16px; left:15px; top: 12px; color: #333 !important;}
.has-feedback .form-control {padding-left: 28px !important;}
.camp-block{border-bottom: 2px solid #CCC;}
</style>

<!-- Breadcrumb Starts -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled list-inline">
            <li><a href="index.html">Home</a></li>
            <li class="active">Camp Registration</li>
        </ul>
    </div>
</div>

<div class="container main-container">
    <h2><span>Camp Registration</span></h2>
    <div class="contact-content">
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <div class="status alert alert-success contact-status"></div>
                <?php
                if(is_array($error) && count($error)>0) {
                ?>
                    <!-- our error container -->
                    <div class="error-container" style="display:block;">
                        <ol>
                            <?php
                            foreach($error as $key=>$val) {
                            ?>
                                <li>
                                    <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
                                </li>
                            <?php
                            }
                            ?>
                        </ol>
                    </div>

                <?php
                }
                include(LIB_HTML.'message.php');
                ?>

                <p><?php echo $camp['intro_text'];?></p>
                <div class="" style="margin:20px 0px;">
                    <?php
                    if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                        foreach($camp['sessions'] as $session){
                            if($session['expire'] == "1"){
                                $style = "text-decoration:line-through;";
                            }elseif($session['waitlist'] == "1"){
                                $style = "color:yellow;";
                            }else{
                                $style = "";
                            }
                    ?>

                    <p style="<?php echo $style;?>">
                        <strong><?php echo $session['title'];?> Registration</strong>
                        <span> - </span>
                        <span><?php echo date("l F d, Y", strtotime($session['start_from']));?></span>
                        <span> to </span>
                        <span><?php echo date("l F d, Y", strtotime($session['end_at']));?></span>
                    </p>

                    <?php
                        }
                    }
                    ?>

                    <p>&nbsp;</p>
                    <p>
                        <strong>Sibling Discount</strong>
                        <span> - </span>
                        <span>$50 off (each additional sibling after the first - not applied for additional weeks)</span>
                    </p>

                    <p>
                        <strong>Multiple Week Discount</strong>
                        <span> - </span>
                        <span>$50 off (each additional week after the first)</span>
                    </p>
                </div>

                <form id="frmCampRegistration" class="contact-form" name="frmCampRegistration" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="camp-block">
                            <div class="col-md-6 topmarg20">
                                <div class="form-group">
                                    <label>Select Camper 1</label>
                                    <select name="camper_id[0]" class="form-control">
                                        <option value="">-- Select Camper --</option>
                                        <?php
                                        if(is_array($arrChilds) && count($arrChilds)>0){
                                            foreach($arrChilds as $child){
                                                echo '<option value="'.$child['id'].'">'.ucwords($child['first_name'].' '.$child['last_name']).'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 topmarg20">
                                <div class="form-group cmpWeek">
                                    <label for="camp_session_id">Select Week(s) <span class="required">*</span></label>
                                    <select name="camp_session_id[0][]" id="camp_session_id1" class="form-control ddcampsessions" multiple>
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
                                                echo '<option value="'.$session['id'].'">'.$session['title'].' ('.$dateRange.')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" id="optBus0">
                                
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="snack_shop">Would you like to add funds to your child's snack shop account? No cash will be accepted at camp. </label>
                                    <select name="snack_shop_amount[]" id="snack_shop_amount1" rel="<?php echo $numCamper;?>" class="form-control snackshop_amount">
                                        <option value="">-- Select Option --</option>
                                        <option value="25">Yes, I would like to add $25 to my child's snack shop fee</option>
                                        <option value="0">No, I do not want my child to make any purchases from the snack shop</option>
                                    </select>
                                </div>
                            </div>

                            <!--div class="col-md-6" id="snackShopAmount1" style="display:none;">
                                <div class="form-group has-success has-feedback">
                                    <label for="">Specify amount</label>
                                    <div class="col-sm-12">
                                        <span class="fa fa-usd form-control-feedback"></span>
                                        <input type="text" name="snack_shop_amount[]" id="snack_shop_amount1" rel="1" class="form-control snackshop_amount" value="0">
                                    </div>
                                </div>
                            </div-->
                        </div>
                        <div class="clear"></div>

                        <?php
                        if(is_array($arrChilds) && count($arrChilds)>0){
                        ?>
                        <div id="loadCamper"></div>
                        <div class="col-md-12" style=""><button type="button" class="btnAddCamper btn btn-primary">Add Another Camper</button></div>
                        <?php
                        }
                        ?>

                        <div class="col-md-12">
                            <div class="form-group padding20">
                                <label for="total_amount">Total Amount </label>
                                <input type="text" class="form-control" name="total_amount" id="total_amount" value="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group padding20">
                                <label for="total_amount">Apply Voucher </label>
                                <input type="text" class="form-control" style="width:60%;" name="coupon" id="coupon" value="">
                                <button type="button" class="btn" id="btnCoupon">Apply</button>
                                <span id="couponAlert" class="alert"></span>
                            </div>
                        </div>

                        <div id="discrow" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group padding20">
                                    <label for="total_amount">Total Discount </label>
                                    <input type="text" class="form-control" name="total_discount" id="total_discount" readonly value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group padding20">
                                    <label for="total_amount">Total Payable </label>
                                    <input type="text" class="form-control" name="total_payable" id="total_payable" readonly value="">
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div class="col-xs-12 text-center">
                            <input type="hidden" name="camp-register" value="submit">
                            <input type="hidden" name="camp_id" value="<?php echo $camp['id'];?>">
                            <?php
                            if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                                foreach($camp['sessions'] as $session){
                                    echo '<input type="hidden" id="weekrate-'.$session['id'].'" value="'.$session['rate'].'">';
                                    echo '<input type="hidden" id="weektitle-'.$session['id'].'" value="'.$session['title'].'">';
                                }
                            }
                            ?>
                            <input type="hidden" name="total_campers" id="total_campers" value="1">
                            <input type="submit" class="btn btn-black text-uppercase" value="Next">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo SCRIPT_SITE_URL;?>jquery.multiselect.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".navbar-nav li").removeClass("active");
    $("#registerCamp").addClass("active");
    

    $(".snackshop_amount").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // USer login validation & submission
    $("#frmCampRegistration").validate();
});

$(function() {
    $('.ddcampsessions').multiselect({
        columns: 1,
        placeholder: 'Select Session'
    });

    $('.cmpWeek').on("change", ":checkbox", function () {
        var wid = $(this).val();
        var wtitle = $("#weektitle-"+wid).val();
        var bus_fares = '<?php echo json_encode($arrBusFares);?>';
        if($(this).attr('checked')){
            var bhtm = '<div id="busWeek0'+wid+'"><div class="form-group"><label>Bus Fare for week '+wtitle+' </label><select name="bus_fare[0][]" class="form-control busfare"><option value="">-- Select Bus Fare --</option><option value="0">None</option>';
            bus_fares = $.parseJSON(bus_fares);
            $.each(bus_fares, function(i) {
                if(bus_fares[i].waitlist == '1'){
                    bhtm += '<option value="'+bus_fares[i].id+'">'+bus_fares[i].name+' $'+bus_fares[i].amount+' - Waitlist Only</option>';
                }else{
                    bhtm += '<option value="'+bus_fares[i].id+'">'+bus_fares[i].name+' $'+bus_fares[i].amount+'</option>';
                }
            });
            bhtm += '</select></div></div>';
                //<option value="2">From Camp $15</option><option value="3">Round Trip $25</option><option value="4">To Camp $15 - WAITLIST ONLY</option><option value="5">From Camp $15 - WAITLIST ONLY</option><option value="6">Round Trip $25 - WAITLIST ONLY</option>';
            $("#optBus0").append(bhtm);
        }else{
            $("#busWeek0"+wid).remove();
        }
        
        $.ajax({
            url:'<?php echo AJAX_PATH;?>getCampPrice.php',
            type: "POST",
            data: $("#frmCampRegistration").serialize(),
            cache: false,
            dataType: "html",
            success:function(res){
                if(res){
                    $("#total_amount").val(res);
                }
                $(".loading").remove();
            }
        });
    });

    $(document).on('change', '.busfare', function() {
        $.ajax({
            url:'<?php echo AJAX_PATH;?>getCampPrice.php',
            type: "POST",
            data: $("#frmCampRegistration").serialize(),
            cache: false,
            dataType: "html",
            success:function(res){
                if(res){
                    $("#total_amount").val(res);
                }
                $(".loading").remove();
            }
        });
    });

    $(document).on('change', '.snack_shop', function() {
        var num = $(this).attr('id');
        num = num.replace('snack_shop', '');
        var snakshop_opt = $("#snack_shop"+num).val();
        if(snakshop_opt == "1"){
            $("#snackShopAmount"+num).show();
            $("snack_shop_amount"+num).val('0');
        }else{
            $("snack_shop_amount"+num).val('0');
            $("#snackShopAmount"+num).hide();
        }
    });

    $(".snackshop_amount").bind("change paste keyup", function() {
        $.ajax({
            url:'<?php echo AJAX_PATH;?>getCampPrice.php',
            type: "POST",
            data: $("#frmCampRegistration").serialize(),
            cache: false,
            dataType: "html",
            success:function(res){
                if(res){
                    $("#total_amount").val(res);
                }
                $(".loading").remove();
            }
        });
    });

    $(".btnAddCamper").click(function(){
        var num = $("#total_campers").val();
        num = parseInt(num);
        var totalCampers = <?php echo count($arrChilds);?>;
        if(num < totalCampers){
            $.ajax({
                url:'<?php echo AJAX_PATH;?>loadCamperRegistration.php?n='+num,
                cache: false,
                dataType: "html",
                success:function(res){
                    $("#loadCamper").append(res);
                    var nextCamper = parseInt(num)+1;
                    $("#total_campers").val(nextCamper);
                }
            });
        }else{
            alert("You have added all your children");
            return false;
        }
    });

    $("#btnCoupon").click(function(){
        var coupon = $("#coupon").val();
        var total_amount = $("#total_amount").val();
        if(coupon !== ""){
            $.ajax({
                url:'<?php echo AJAX_PATH;?>checkCoupon.php?c='+coupon,
                cache: false,
                dataType: "html",
                success:function(data){
                    var res = $.parseJSON(data);
                    if(res.status == "success"){
                        var dis_type = res.discount_type;
                        var discount = res.discount;
                        if(dis_type == "fixed"){
                            var dis_amount = total_amount-discount;
                        }else{
                            discount = (total_amount*discount)/100;
                            var dis_amount = total_amount-discount;
                        }
                        $("#couponAlert").removeClass("alert-error");
                        $("#couponAlert").addClass("alert-success");
                        $("#couponAlert").html("Voucher applied successfully.");
                        $("#total_discount").val(discount);
                        $("#total_payable").val(dis_amount);
                        $("#discrow").show();
                    }else{
                        $("#couponAlert").removeClass("alert-success");
                        $("#couponAlert").addClass("alert-error");
                        $("#couponAlert").html("Invalid Voucher.");
                        $("#total_discount").val('');
                        $("#total_payable").val('');
                        $("#discrow").hide();
                    }
                }
            });
        }
    });

});
</script>
<?php include(LIB_HTML . 'footer.php');?>