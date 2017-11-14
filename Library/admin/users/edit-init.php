<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Edit User";

$userId = $_GET['id'];

$error = array();
if(isset($_POST['edit-user']) && trim($_POST['edit-user'])=='submit') {

    if (isset($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $error[] = "Please enter your first name";
    }else{
        $first_name = trim($_POST['first_name']);
    }

    if (isset($_POST['last_name']) && trim($_POST['last_name']) == '') {
        $error[] = "Please enter your last name";
    }else{
        $last_name = trim($_POST['last_name']);
    }

    if($_POST['reset_password'] == "1"){
	    if (trim($_POST['password']) == '') {
	        $error[] = "Please enter the password";
	    }

	    if (trim($_POST['confirm_password']) == '') {
	        $error[] = "Please confirm the password";
	    }
	    if ($_POST['password'] !== $_POST['confirm_password']) {
	        $error[] = "Please enter the same password to confirm";
	    }
    }

    if (isset($_POST['phone']) && trim($_POST['phone']) == '') {
        $error[] = "Please enter your phone number";
    }else{
        $phone = trim($_POST['phone']);
    }

    if (isset($_POST['primary_parent_name']) && trim($_POST['primary_parent_name']) == '') {
        $error[] = "Please enter the primary parent name";
    }else{
        $primary_parent_name = trim($_POST['primary_parent_name']);
    }

    if (isset($_POST['city']) && trim($_POST['city']) == '') {
        $error[] = "Please enter the city";
    }else{
        $city = trim($_POST['city']);
    }

    if (isset($_POST['state']) && trim($_POST['state']) == '') {
        $error[] = "Please select the state";
    }else{
        $state = trim($_POST['state']);
    }

    if (isset($_POST['zipcode']) && trim($_POST['zipcode']) == '') {
        $error[] = "Please enter the zipcode";
    }else{
        $zipcode = trim($_POST['zipcode']);
    }

    if (isset($_POST['emergency_contact1']) && trim($_POST['emergency_contact1']) == '') {
        $error[] = "Please enter the first emergency contact";
    }else{
        $emergency_contact1 = trim($_POST['emergency_contact1']);
    }

    if (isset($_POST['emergency_contact2']) && trim($_POST['emergency_contact2']) == '') {
        $error[] = "Please enter the second emergency contact";
    }else{
        $emergency_contact2 = trim($_POST['emergency_contact2']);
    }
    
    extract($_POST);
    if (empty($error)) {
        $current_date = date("Y-m-d H:i:s");
        $userArray = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $_POST['phone'],
            'primary_parent_name' => $_POST['primary_parent_name'],
            'primary_parent_phone' => $_POST['primary_parent_phone'],
            'primary_parent_email' => $_POST['primary_parent_email'],
            'secondary_parent_name' => $_POST['secondary_parent_name'],
            'secondary_parent_phone' => $_POST['secondary_parent_phone'],
            'secondary_parent_email' => $_POST['secondary_parent_email'],
            'primary_address' => $_POST['primary_address'],
            'primary_address2' => $_POST['primary_address2'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'emergency_contact1' => $_POST['emergency_contact1'],
            'emergency_contact2' => $_POST['emergency_contact2'],
            'modified' => $current_date
        );

        if($_POST['reset_password'] == "1" && $_POST['password'] !== ""){
        	$userArray['password'] = UtilityManager::encrypt_password($_POST['password']);
        }

        $updateUser = $globalManager->runUpdateQuery('users', $userArray, "id='".$userId."'");
            
        if($updateUser) {
        	if($_POST['reset_password'] == "1" && $_POST['password'] !== ""){
        		################### SEND ACCOUNT ACTIVATION EMAIL ##########################
	            $owner_email = $_POST['email'];
	            $owner_name = $_POST['first_name'];

	            $message = 'Dear '.$owner_name;
	            $message .= '<p>Your AYFCamp account passowrd has been reset by our support team. Below are the details:</p>';
	            $message .= '<p>------------------------------------------------------------------------</p>';
	            $message .= '<p>Email: '.$owner_email.'</p>';
	            $message .= '<p>Password: '.$_POST['password'].'</p>';
	            $message .= '<p>------------------------------------------------------------------------</p>';

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
	            $phpmailer->AddAddress($owner_email, $owner_name);
	            $phpmailer->Body = $message;
	            $phpmailer->MsgHTML = $message;
	            $phpmailer->Subject = "Account Confirmation | ".SITE_NAME;
	            $sendmail = $phpmailer->send();

	            ################### END SEND ACCOUNT ACTIVATION EMAIL ######################
            }
        	$_SESSION['message'] = "User has been updated successfully";
        	redirect(ADMIN_SITE_URL.'users.php');
    	}else{
    		$_SESSION['errmsg'] = "Update failed!";
    		redirect(ADMIN_SITE_URL.'users.php');
    	}
	}
}

if(isset($_GET['id']) && trim($_GET['id'])!==""){
	//find out the patient profile info
	$getUser = $globalManager->runSelectQuery("users", "*", "id='".trim($_GET['id'])."'");
	if(is_array($getUser) && !empty($getUser)){
	    $parent = $getUser[0];
	    //find out the list of states
	    $arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1' ORDER BY name");
	}else{
	    $_SESSION['errmsg'] = "Invalid user selected.";
		redirect(ADMIN_SITE_URL.'users.php');
	}
}else{
	$_SESSION['errmsg'] = "No user selected.";
	redirect(ADMIN_SITE_URL.'users.php');
}
//prx($parent);