<?php
include('cnf.php');
##-----------CHECK advertisers LOGIN START---------------##
validateUserLogin();
##-----------CHECK advertisers LOGIN END---------------##
$pageTitle = "Payment Receipt";
include(LIB_PATH . 'users/camps/payment-receipt-init.php');
include(LIB_HTML . 'header.php');
?>
<div class="container main-container">
    
    <div class="contact-content">
        
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <h2><span>Payment Confirmation</span></h2>
                <?php include(LIB_HTML.'message.php'); ?>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <img src="<?php echo IMG_PATH;?>logo.png" width="140" alt="">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <p>
                                    <em>Date: <?php echo date("F d, Y", strtotime($receipt['created']));?></em>
                                </p>
                                <p>
                                    <em>Transaction #: <?php echo $receipt['transaction_id'];?></em>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <h1>Receipt</h1>
                            </div>
                            </span>
                            <table class="table table-hover">
                                <!--<thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>#</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>-->
                                <tbody>
                                    <tr>
                                        <td class="col-md-9">Title</td>
                                        <td class="col-md-9"><em>Camp Registration</em></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-9">Total Camper</td>
                                        <td class="col-md-9"><em><?php echo $receipt['total_campers'];?></em></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right col-md-9"><h4><strong>Total: </strong></h4></td>
                                        <td class="col-md-9 text-danger"><h4><strong>$<?php echo number_format($receipt['total_amount'],2);?></strong></h4></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right col-md-9"><h4><strong>Discount: </strong></h4></td>
                                        <td class="col-md-9 text-danger"><h4><strong>$<?php echo number_format($receipt['coupon_discount'],2);?></strong></h4></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right col-md-9">
                                            <p><strong>Subtotal: </strong></p>
                                        </td>
                                        <td class="col-md-9">
                                            <p><strong>$<?php echo number_format($receipt['amount'],2);?></strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right col-md-9"><h4><strong>Total: </strong></h4></td>
                                        <td class="col-md-9 text-danger"><h4><strong>$<?php echo number_format($receipt['total_payable'],2);?></strong></h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">
$(document).ready(function(){
    $(".nav-main li").removeClass("active");
    $("#homePage").addClass("active");
});
</script>
<?php include(LIB_HTML.'footer.php');?>