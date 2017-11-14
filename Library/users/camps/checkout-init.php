<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];

$pageTitle = "Checkout";

$error = array();

if(isset($_GET['q']) && trim($_GET['q']) !== ""){
    $registerCode = UtilityManager::decrypt(trim($_GET['q']));
    //find the registration details
    $getRegistration = $globalManager->runSelectQuery("camp_registrations", "*", "code='".$registerCode."' AND user_id='".$userId."'");
    //prx($getRegistration);
    if(is_array($getRegistration) && count($getRegistration)>0){
        $campInfo = $getRegistration[0];
    }else{
        $_SESSION['errmsg'] = "Invalid camp registration.";
        redirect(USER_SITE_URL.'camp-registration.php');
    }
}

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
  throw new Exception('Stripe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Stripe needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
  throw new Exception('Stripe needs the Multibyte String PHP extension.');
}
// Stripe singleton
require(LIB_PATH.'stripe/Stripe/Stripe.php');
// Utilities
require(LIB_PATH.'stripe/Stripe/Util.php');
require(LIB_PATH.'stripe/Stripe/Util/Set.php');
// Errors
require(LIB_PATH.'stripe/Stripe/Error.php');
require(LIB_PATH.'stripe/Stripe/ApiError.php');
require(LIB_PATH.'stripe/Stripe/ApiConnectionError.php');
require(LIB_PATH.'stripe/Stripe/AuthenticationError.php');
require(LIB_PATH.'stripe/Stripe/CardError.php');
require(LIB_PATH.'stripe/Stripe/InvalidRequestError.php');
require(LIB_PATH.'stripe/Stripe/RateLimitError.php');
// Plumbing
require(LIB_PATH.'stripe/Stripe/Object.php');
require(LIB_PATH.'stripe/Stripe/ApiRequestor.php');
require(LIB_PATH.'stripe/Stripe/ApiResource.php');
require(LIB_PATH.'stripe/Stripe/SingletonApiResource.php');
require(LIB_PATH.'stripe/Stripe/AttachedObject.php');
require(LIB_PATH.'stripe/Stripe/List.php');
// Stripe API Resources
require(LIB_PATH.'stripe/Stripe/Account.php');
require(LIB_PATH.'stripe/Stripe/Card.php');
require(LIB_PATH.'stripe/Stripe/Balance.php');
require(LIB_PATH.'stripe/Stripe/BalanceTransaction.php');
require(LIB_PATH.'stripe/Stripe/Charge.php');
require(LIB_PATH.'stripe/Stripe/Customer.php');
require(LIB_PATH.'stripe/Stripe/Invoice.php');
require(LIB_PATH.'stripe/Stripe/InvoiceItem.php');
require(LIB_PATH.'stripe/Stripe/Plan.php');
require(LIB_PATH.'stripe/Stripe/Subscription.php');
require(LIB_PATH.'stripe/Stripe/Token.php');
require(LIB_PATH.'stripe/Stripe/Coupon.php');
require(LIB_PATH.'stripe/Stripe/Event.php');
require(LIB_PATH.'stripe/Stripe/Transfer.php');
require(LIB_PATH.'stripe/Stripe/Recipient.php');
require(LIB_PATH.'stripe/Stripe/ApplicationFee.php');

if(isset($_POST['payment-submit']) && trim($_POST['payment-submit'])=="submit") {//prx($_POST);
    $registerId = $_POST['registrationId'];
  	Stripe::setApiKey("sk_live_63TNVBgY1vFqIuBBoMrvT9aY");
  	$error = '';
  	$success = '';
  	try {
		if (empty($_POST['street']) || empty($_POST['city']) || empty($_POST['zip']))
      		throw new Exception("Fill out all required fields.");
    	if (!isset($_POST['stripeToken']))
      		throw new Exception("The Stripe Token was not generated correctly");

        if($campInfo['total_payable'] > 0){
            $pay_amount = $campInfo['total_payable'];
        }else{
            $pay_amount = $campInfo['total_amount'];
        }
        
        $pay_amount = str(int($pay_amount)*100);
    	Stripe_Charge::create(
    		array(
    			"amount" => $pay_amount,
                "currency" => "usd",
                "card" => $_POST['stripeToken'],
				"description" => $_POST['email']
			)
		);
        ########## SET PAYMENT STATUS #############
        $paymentId = $_POST['stripeToken'];

        //store details in database
        $paymentArray = array(
            'user_id' => $userId,
            'registration_id' => $registerId,
            'transaction_id' => $_POST['stripeToken'],
            'amount' => $campInfo['total_payable'] > 0 ? $campInfo['total_payable'] : $campInfo['total_amount'],
            'data' => serialize($_POST),
            'status' => 'Success',
            'created' => date("Y-m-d H:i:s")
        );

        $savePayment = $globalManager->runInsertQuery("registration_payments", $paymentArray);

        $adPaymentArray = array(
            'payment_id' => $savePayment,
            'status' => '1',
            'payment_status' => 'Success',
            'modified' => date("Y-m-d H:i:s")
        );

        $updateRegistration = $globalManager->runUpdateQuery("camp_registrations", $adPaymentArray, "id='".$registerId."'");

        ####################### SEND EMAIL NOTIFICATION TO ADVERTISER FOR ADDED CREDITS #####################
        $amount = $campInfo['total_amount'];
        //find out the parent details
        $getParent = $globalManager->runSelectQuery("users", "first_name,last_name,email", "id='".$userId."'");
        $contact_to_email = $getParent[0]['email'];
        $visitor_name = ucwords($getParent[0]['first_name'].' '.$getParent[0]['last_name']);
        $message .= "<p>Dear ".$visitor_name.",</p><p>Thank you for registering your childs for our camps.</p>";
    
        $message .= "<p>Transaction ID: <em>".$paymentId."</em></p>";
        $message .= "<p>Total Registration Fee: <em>$".number_format($amount,2)."</em></p>";
        $message .= "<p>If you have any questions, please email us at <a style='color:#fda12c;text-decoration:none;' href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a>.</p>";

        //include email template
        $template = file_get_contents(LIB_HTML.'user_email_template.php');

        //replace content
        $message = str_replace('{CONTENT_FOR_LAYOUT}', $message, $template);

        $phpmailer = new phpmailer();
        $phpmailer->SetLanguage("en", LIB_PATH. "PHPMailer/language/");
        $phpmailer->CharSet = "UTF-8";
        $phpmailer->Priority = 1;
        $phpmailer->AddCustomHeader("X-MSMail-Priority: High");
        $phpmailer->AddCustomHeader("Importance: High");
        $phpmailer->IsSMTP();
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com";
        $phpmailer->SMTPDebug  = 0;
        $phpmailer->Mailer = "smtp";
        $phpmailer->Port = 465;
        $phpmailer->Username = SUPPORT_EMAIL;
        $phpmailer->Password = SUPPORT_EMAIL_PASSWORD;
        $phpmailer->From = SUPPORT_EMAIL;
        $phpmailer->FromName = SUPPORT_EMAIL_USERNAME;

        $phpmailer->IsHTML(TRUE);
        $phpmailer->AddAddress($contact_to_email, $visitor_name);
        $phpmailer->Body = $message;
        $phpmailer->MsgHTML = $message;
        $phpmailer->Subject = "Camp registration confirmation | ".SITE_NAME;
        $sendmail = $phpmailer->send();

        ##################### SEND EMAIL NOTIFICATION TO ADVERTISER FOR ADDED CREDITS END ###################

        //encrypt payment id
        $pid = UtilityManager::encrypt($savePayment);
        $_SESSION['message'] = 'Your payment has been successfully made and your camp registration has been confirmed. Your payment receipt will be sent to <em>'.$getParent[0]['email'].'</em>.';
        redirect(USER_SITE_URL.'payment-receipt.php?p='.$pid);

    	//$_SESSION['message'] = "Success!</strong> Your payment was successful";
  	}
  	catch (Exception $e) {
		$_SESSION['errmsg'] = $e->getMessage();
  	}
}


//prx($campInfo);