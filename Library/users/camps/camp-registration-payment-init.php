<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];

$paypal_username    = "sandip-facilitator_api1.wegile.com";
$paypal_password    = "HB5ZUN96VTQUAPPM";
$paypal_signature   = "AvLd-d9dlMBLAvS4uLzx4bTSCZc.AmE24KHmNgKT4ye8V5qIbJjoKzFG";
include(LIB_PATH . 'paypal-pro/paypal_pro_signature.inc.php');

$error = array();
if(isset($_POST) && trim($_POST['camper-payment'])=="submit"){
    $registerId = $_POST['registrationId'];

    if (isset($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $error[] = "Please enter your first name";
    }
    if (isset($_POST['last_name']) && trim($_POST['last_name']) == '') {
        $error[] = "Please enter your last name";
    }

    if (trim($_POST['card_type']) == '') {
        $error[] = "Please select your credit card type";
    }
    if (trim($_POST['card_number']) == '') {
        $error[] = "Please enter your credit card number";
    }

    if (trim($_POST['expiry_month']) == '') {
        $error[] = "Please select expiry month of your credit card";
    }

    if (trim($_POST['expiry_year']) == '') {
       $error[] = "Please select expiry year of your credit card";
    }

    if (trim($_POST['cvv_number']) == '') {
        $error[] = "Please select cvv number of your credit card";
    }

    if (empty($error)) {
        //find out the registration details
        $regArray = $globalManager->runSelectQuery("camp_registrations", "*", "id='".$registerId."' AND user_id='".$userId."'");
        $amount = $regArray[0]['total_amount'];

        ################ PayPal Pro Payment Gateway Integration ##################
        $firstName          = urlencode($_POST['first_name']);
        $lastName           = urlencode($_POST['last_name']);
        $creditCardType     = urlencode($_POST['card_type']);
        $creditCardNumber   = urlencode($_POST['card_number']);
        $expDateMonth       = urlencode($_POST['expiry_month']);
        $padDateMonth       = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
        $expDateYear        = urlencode($_POST['expiry_year']);
        $cvv2Number         = urlencode($_POST['cvv_number']);
        $address1           = "";
        $address2           = "";
        $city               = "";
        $state              = "";
        $zip                = "";
        $amount             = urlencode($amount);
        $currencyCode       = urlencode("USD");
        $paymentAction      = urlencode("Sale");
        $methodToCall       = 'DoDirectPayment';

        $nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.$padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode;

        //echo $nvpstr;die;
        $environment = 'sandbox'; // or 'beta-sandbox' or live

        //$paypalPro  = new paypal_pro($paypal_username, $paypal_password, $paypal_signature, $environment);

        //$resArray   = $paypalPro->PPHttpPost('DoDirectPayment', $nvpstr);

        $resArray = array(
            "TIMESTAMP" => date("Y-m-d H:i:s"),
            "CORRELATIONID" => "95caf831c2e86",
            "ACK" => "Success",
            "VERSION" => "51.0",
            "BUILD" => "000000",
            "AMT" =>$amount,
            "CURRENCYCODE" => "USD",
            "AVSCODE" => "X",
            "CVV2MATCH" => "M",
            "TRANSACTIONID" => "5371443257420393B"
        );

        $ack    = strtoupper($resArray["ACK"]);
        $currentDate = date("Y-m-d H:i:s");
        if(stristr($ack, 'SUCCESS') || stristr($ack, 'SUCCESSWITHWARNING')){
            $paymentId = $resArray['TRANSACTIONID'];

            //store details in database
            $paymentArray = array(
                'user_id' => $userId,
                'registration_id' => $registerId,
                'transaction_id' => $paymentId,
                'amount' => $amount,
                'data' => serialize($resArray),
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

            $updateAdvertiser = $globalManager->runUpdateQuery("camp_registrations", $adPaymentArray, "id='".$registerId."'");

            ####################### SEND EMAIL NOTIFICATION TO ADVERTISER FOR ADDED CREDITS #####################

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
            $_SESSION['message'] = 'Payment has successfully been made and your campaign ad has been scheduled. Payment receipt will be sent to <em>'.$getParent[0]['email'].'</em>.';
            redirect(USER_SITE_URL.'payment-receipt.php?p='.$pid);
        }else {
            $paymentId = $resArray['CORRELATIONID'];

            //store details in database
            $paymentArray = array(
                'user_id' => $userId,
                'registration_id' => $registerId,
                'transaction_id' => $paymentId,
                'amount' => $amount,
                'data' => serialize($resArray),
                'status' => 'Failed',
                'created' => date("Y-m-d H:i:s")
            );

            $savePayment = $globalManager->runInsertQuery("registration_payments", $paymentArray);

            $_SESSION['errmsg'] = "Payment failed! Please try again";
        }
    }

    //redirect(USER_SITE_URL.'profile.php');
}



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

$pageTitle = "Summer Camp Registration";

//define array of month
$arrMonths = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
);