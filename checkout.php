<?php
include('cnf.php');
################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'users/camps/checkout-init.php');
include(LIB_HTML . 'header.php');
?>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>bootstrap-min.css">
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>bootstrap-formhelpers-min.css" media="screen">
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>bootstrapValidator-min.css"/>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>bootstrap-side-notes.css" />
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>bootstrap-formhelpers-min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>bootstrapValidator-min.js"></script>
<style>
.contact-content {
  font-family: "Lato",sans-serif !important;
}
.psection {
  border: 1px solid #f0f0f0;
}
.has-feedback .form-control-feedback {right: 10px; top: 4px;}
.tabheader{background: #CCC; padding:10px; overflow: hidden;}
.tabheader .hdtext{margin:0; padding:0; font-size:26px;}
.width99{width:98%;}
.contact-form .form-group{display: flex;}
.marginT20{margin-top: 20px;}
</style>

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
                <!-- Important notice -->
                <div class="form-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="margin: 0; padding:0; border:none;">Checkout Summary</h3>
                        </div>
                        <div class="panel-body">
                            <p>Your card will be charged $<?php echo $campInfo['total_payable'] > 0 ? $campInfo['total_payable'] : $campInfo['total_amount'];?> after submission.</p>
                            <p>Your registration will be confirm after a successful payment.</p>
                        </div>
                    </div>
                </div>
                <form name="frmCheckout" id="frmCheckout" method="POST" class="contact-form" role="form">
                    <div class="psection">
                        <div class="tabheader">
                            <div class="hdtext">Billing Details</div>
                        </div>
                        <div class="col-sm-6 col-sm-offset-3 marginT20">
                            <!-- Street -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">Street</label>
                                <div class="col-sm-9">
                                    <input type="text" name="street" placeholder="Street" class="address form-control">
                                </div>
                            </div>
                    
                            <!-- City -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">City</label>
                                <div class="col-sm-9">
                                    <input type="text" name="city" placeholder="City" class="city form-control">
                                </div>
                            </div>
  
                            <!-- State -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">State</label>
                                <div class="col-sm-9">
                                    <input type="text" name="state" maxlength="65" placeholder="State" class="state form-control">
                                </div>
                            </div>
                    
                            <!-- Postcal Code -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">Postal Code</label>
                                <div class="col-sm-9">
                                    <input type="text" name="zip" maxlength="9" placeholder="Postal Code" class="zip form-control">
                                </div>
                            </div>
          
                            <!-- Country -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">Country</label>
                                <div class="col-sm-9"> 
                                <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                                    <div class="country bfh-selectbox bfh-countries" name="country" placeholder="Select Country" data-flags="true" data-filter="true"> </div>
                                </div>
                            </div>
      
                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="textinput">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" name="email" maxlength="65" placeholder="Email" class="email form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tabheader">
                                    <div class="hdtext">Card Details</div>
                                </div>
                                <div class="col-sm-6 col-sm-offset-3 marginT20">
                                    <!-- Card Holder Name -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"  for="textinput">Card Holder's Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="cardholdername" maxlength="70" placeholder="Card Holder Name" class="card-holder-name form-control">
                                        </div>
                                    </div>
                                    
                                    <!-- Card Number -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="textinput">Card Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="cardnumber" maxlength="19" placeholder="Card Number" class="card-number form-control">
                                        </div>
                                    </div>
                    
                                    <!-- Expiry-->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="textinput">Card Expiration Date</label>
                                        <div class="col-sm-9">
                                            <div class="form-inline">
                                                <select name="select2" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                                                    <option value="01" selected="selected">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                                <span> / </span>
                                                <select name="select2" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                                                </select>
                                                <script type="text/javascript">
                                                var select = $(".card-expiry-year"),
                                                year = new Date().getFullYear();
                                                for (var i = 0; i < 12; i++) {
                                                    select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                                                }
                                                </script> 
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- CVV -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="textinput">CVV/CVV2</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="cvv" placeholder="CVV" maxlength="4" class="card-cvc form-control">
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                        </div>
                    </div>

                    
                        
                    <!-- Submit -->
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="payment-submit" value="submit">
                            <input type="hidden" name="registrationId" value="<?php echo $campInfo['id'];?>">
                            <center><button class="btn btn-success" type="submit">Pay Now</button></center>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#frmCheckout').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            // createToken returns immediately - the supplied callback submits the form if there are no errors
            Stripe.card.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                name: $('.card-holder-name').val(),
                address_line1: $('.address').val(),
                address_city: $('.city').val(),
                address_zip: $('.zip').val(),
                address_state: $('.state').val(),
                address_country: $('.country').val()
            }, stripeResponseHandler);
            return false; // submit from callback
        },
        fields: {
            street: {
                validators: {
                    notEmpty: {
                        message: 'The street is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 96,
                        message: 'The street must be more than 6 and less than 96 characters long'
                    }
                }
            },
            city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required and cannot be empty'
                    }
                }
            },
            zip: {
                validators: {
                    notEmpty: {
                        message: 'The zip is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 9,
                        message: 'The zip must be more than 3 and less than 9 characters long'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    stringLength: {
                        min: 6,
                        max: 65,
                        message: 'The email must be more than 6 and less than 65 characters long'
                    }
                }
            },
            cardholdername: {
                validators: {
                    notEmpty: {
                        message: 'The card holder name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 70,
                        message: 'The card holder name must be more than 6 and less than 70 characters long'
                    }
                }
            },
            cardnumber: {
                selector: '#cardnumber',
                validators: {
                    notEmpty: {
                        message: 'The credit card number is required and can\'t be empty'
                    },
                    creditCard: {
                        message: 'The credit card number is invalid'
                    },
                }
            },
            expMonth: {
                selector: '[data-stripe="exp-month"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration month is required'
                    },
                    digits: {
                        message: 'The expiration month can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var year         = validator.getFieldElements('expYear').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < 0 || value > 12) {
                                return false;
                            }
                            if (year == '') {
                                return true;
                            }
                            year = parseInt(year, 10);
                            if (year > currentYear || (year == currentYear && value > currentMonth)) {
                                validator.updateStatus('expYear', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            expYear: {
                selector: '[data-stripe="exp-year"]',
                validators: {
                    notEmpty: {
                        message: 'The expiration year is required'
                    },
                    digits: {
                        message: 'The expiration year can contain digits only'
                    },
                    callback: {
                        message: 'Expired',
                        callback: function(value, validator) {
                            value = parseInt(value, 10);
                            var month        = validator.getFieldElements('expMonth').val(),
                                currentMonth = new Date().getMonth() + 1,
                                currentYear  = new Date().getFullYear();
                            if (value < currentYear || value > currentYear + 100) {
                                return false;
                            }
                            if (month == '') {
                                return false;
                            }
                            month = parseInt(month, 10);
                            if (value > currentYear || (value == currentYear && month > currentMonth)) {
                                validator.updateStatus('expMonth', 'VALID');
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            cvv: {
                selector: '#cvv',
                validators: {
                    notEmpty: {
                        message: 'The cvv is required and can\'t be empty'
                    },
                    cvv: {
                        message: 'The value is not a valid CVV',
                        creditCardField: 'cardnumber'
                    }
                }
            },
        }
    });
});
// this identifies your website in the createToken call below
Stripe.setPublishableKey('pk_live_XpuPPJglgAaazr1AcjkocO0J');

function stripeResponseHandler(status, response) {
    if (response.error) {
        // re-enable the submit button
        $('.submit-button').removeAttr("disabled");
        // show hidden div
        document.getElementById('a_x200').style.display = 'block';
        // show the errors on the form
        $(".payment-errors").html(response.error.message);
    } else {
        var form$ = $("#frmCheckout");
        // token contains id, last4, and card type
        var token = response['id'];
        //alert(token);
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // and submit
        form$.get(0).submit();
    }
}
 
</script>
<?php include(LIB_HTML . 'footer.php');?>