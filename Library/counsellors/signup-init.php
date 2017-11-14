<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//signup submit
$error = array();
if(isset($_POST['user-signup']) && trim($_POST['user-signup'])=='signup') {
    //first check out for duplicate email
    $condition = "email='".$_POST['email']."'";
    $result = $globalManager->runSelectQuery("counsellors", "IFNULL(COUNT(id),0) as total", $condition);
    if($result[0]['total'] > 0){
        $error[] = "Email address already exists";
    }else {
        $email = trim($_POST['email']);
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
    

    if (empty($error)) {
        $current_date = date("Y-m-d H:i:s");
        $code = UtilityManager::generateUniqueSecurityCode(12);
        $userArray = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $_POST['email'],
            'password' => UtilityManager::encrypt_password($_POST['password']),
            'phone' => $_POST['phone'],
            'status' => '1',
            'modified' => $current_date,
            'created' => $current_date
        );

        $addUser = $globalManager->runInsertQuery('counsellors', $userArray);
            
        if($addUser) {
            $userId = $addUser;

            //allow to login
            $_SESSION['ayfcamp']['counsellor']['userid'] = $userId;
            $_SESSION['ayfcamp']['counsellor']['email'] = $_POST['email'];
            $_SESSION['ayfcamp']['counsellor']['name'] = ucwords($_POST['first_name'].' '.$_POST['last_name']);

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
            
            $_SESSION['message'] = "Thank you for registering with AYF Camp!";
            redirect(COUNSELLOR_SITE_URL.'home.php');
        } else {
            $_SESSION['errmsg'] = "Submission failed! Please try again";
        }
    }
}

//find out the list of all the states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1'");