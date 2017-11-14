<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//signup submit
$error = array();
if(isset($_POST['user-signup']) && trim($_POST['user-signup'])=='signup') {
    //first check out for duplicate email
    $condition = "email='".$_POST['email']."'";
    $result = $globalManager->runSelectQuery("users", "COUNT(id) as total", $condition);
    if($result[0]['total'] > 0){
        $error[] = "Email address already exists";
    }else {
        $email = trim($_POST['email']);
    }

    //first check out for duplicate username
    $condition = "username='".$_POST['username']."'";
    $result = $globalManager->runSelectQuery("users", "COUNT(id) as total", $condition);
    if($result[0]['total'] > 0){
        $error[] = "Username already exists";
    }else {
        $username = trim($_POST['username']);
    }

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

    if (trim($_POST['password']) == '') {
        $error[] = "Please enter the password";
    }

    if (trim($_POST['confirm_password']) == '') {
        $error[] = "Please confirm the password";
    }
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error[] = "Please enter the same password to confirm";
    }

    if (isset($_POST['phone']) && trim($_POST['phone']) == '') {
        $error[] = "Please enter your phone number";
    }else{
        $phone = trim($_POST['phone']);
    }

    if (isset($_POST['hear_from']) && trim($_POST['hear_from']) == '') {
        $hear_from = "";
    }else{
        $hear_from = trim($_POST['hear_from']);
    }
    
    extract($_POST);
    if (empty($error)) {
        $current_date = date("Y-m-d H:i:s");
        $code = UtilityManager::generateUniqueSecurityCode(12);
        $userArray = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => UtilityManager::encrypt_password($_POST['password']),
            'phone' => $_POST['phone'],
            'hear_from' => $_POST['hear_from'],
            'primary_parent_name' => $_POST['parent_name'],
            'primary_parent_phone' => $_POST['parent_phone'],
            'primary_parent_email' => $_POST['parent_email'],
            'secondary_parent_name' => $_POST['secondary_parent_name'],
            'secondary_parent_phone' => $_POST['secondary_parent_phone'],
            'secondary_parent_email' => $_POST['secondary_parent_email'],
            'primary_address' => $_POST['primary_address'],
            'primary_address2' => $_POST['address2'],
            'city' => $_POST['city'],
            'state' => $_POST['state_id'],
            'zipcode' => $_POST['zipcode'],
            'emergency_contact1' => $_POST['emergency_contact1'],
            'emergency_contact2' => $_POST['emergency_contact2'],
            'token' => $code,
            'status' => '1',
            'active' => '1',
            'modified' => $current_date,
            'created' => $current_date
        );

        $addUser = $globalManager->runInsertQuery('users', $userArray);
            
        if($addUser) {
            $userId = $addUser;

            //allow to login
            $_SESSION['ayfcamp']['user']['userid'] = $userId;
            $_SESSION['ayfcamp']['user']['email'] = $_POST['email'];
            $_SESSION['ayfcamp']['user']['name'] = ucwords($_POST['first_name'].' '.$_POST['last_name']);

            ################### SEND ACCOUNT ACTIVATION EMAIL ##########################
            $owner_email = $email;
            $owner_name = $first_name;

            $message = 'Dear '.$owner_name;
            $message .= '<p>Thanks for signing up!</p>';
            $message .= '<p>Welcome to the '.SITE_NAME.' family. Your account has been created, you can login with the credentials below.</p>';
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
            
            $_SESSION['message'] = "Thank you for signing up with AYF Camp!";
            redirect(USER_SITE_URL.'profile.php');
        } else {
            $_SESSION['errmsg'] = "Submission failed! Please try again";
        }
    }
}

//find out the list of all the states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1'");