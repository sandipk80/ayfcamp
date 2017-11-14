<?php
include('cnf.php');
################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'users/camps/camp-registration-payment-init.php');
include(LIB_HTML . 'header.php');
?>

<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<style>
.padding20{padding: 20px 0;}
.sf-steps-content > div{padding: 10px 10px 10px 40px; font-size:18px;}
li{list-style: none;}
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
    <div class="contact-content">
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <h2><span>FINAL STEP: Payment Page</span></h2>
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

                <div class="">
                    <p>1. Campers must be between the ages of eight and seventeen (unless noted otherwise for certain weeks). The maximum capacity provision of the camp will be strictly enforced. To secure your position, please apply early, as priority will be given to early registration. All applications will be processed daily on a first-come-first-serve basis.</p>
                    <p>2. Camp fees must be PAID IN FULL with the application. A $200.00 non-refundable application-processing fee will be applied in case of cancellation. This fee is included in the participation fee. A minimum of one-week notice is required for all cancellations. Absolutely NO REFUNDS will be applied for cancellations made within seven days of the registered week.</p>
                    <p>3. Acceptance is conditional upon receipt of a completed application and payment of all fees.</p>
                </div>

                <div class="col-md-10 topmarg20">
                    <form action="" method="post" name="formPayment" id="formPayment" class="form-horizontal">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label">First Name: <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="" />
                            </div>

                            <div class="form-group">
                                <label class="control-label">Last Name: <span>*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="" />
                            </div>

                            <div class="form-group">
                                <label class="control-label">Card Type: <span>*</span></label>
                                <select name="card_type" id="card_type" class="form-control">
                                    <option value="">-- Select Card Type --</option>
                                    <option value="visa">Visa</option>
                                    <option value="master">Master Card</option>
                                    <option value="maestro">Maestro</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Card Number: <span>*</span></label>
                                <input type="text" class="form-control" name="card_number" id="card_number" value="" />
                            </div>

                            <div class="form-group">
                                <label class="control-label">CVV Number: <span>*</span></label>
                                <input type="text" class="form-control" name="cvv_number" id="cvv_number" value="" />
                            </div>

                            <div class="form-group">
                                <label class="control-label">Expiry Month: <span>*</span></label>
                                <select name="expiry_month" id="expiry_month" class="form-control">
                                    <option value="">-- Select Expiry Month --</option>
                                    <?php
                                    foreach($arrMonths as $key=>$value){
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Expiry Year: <span>*</span></label>
                                <select name="expiry_year" id="expiry_year" class="form-control">
                                    <option value="">-- Select Expiry Year --</option>
                                    <?php
                                    $max_year = date("Y")+5;
                                    for($i=date("Y"); $i<=$max_year; $i++){
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-xs-12 text-center">
                                <input type="hidden" name="camper-payment" value="submit">
                                <input type="hidden" name="registrationId" value="<?php echo $campInfo['id'];?>">
                                <input type="submit" class="btn btn-black text-uppercase" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $(".navbar-nav li").removeClass("active");
    $("#navBook").addClass("active");

    // USer login validation & submission
    $("#formPayment").validate({   
        rules: {
            amount: {
                required: true
            },
            first_name: {
              required: true,
              minlength: 3
            },
            last_name: {
              required: true,
              minlength: 3
            },
            card_type: {
                required: true
            },
            card_number: {
                required: true
            },
            cvv_number: {
                required: true
            },
            expiry_month: {
                required: true
            },
            expiry_year: {
                required: true
            }
        }
    });
});
</script>
<?php include(LIB_HTML . 'footer.php');?>