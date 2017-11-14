<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Change Password";

//find out logged in user id
$adminId = $_SESSION['admin_userid'];
$errors = array();
if(isset($_POST['change-password']) && trim($_POST['change-password'])=='Submit') {
    //first find out the user current password
    $where = "id='".$adminId."'";
    $getCurrentPassword = $globalManager->runSelectQuery("admin", "password", $where);

    //match the current password
    if(trim($_POST['curr_password']) == ''){
        $error[] = "Please enter your current password";
    }elseif($getCurrentPassword[0]['password'] !== UtilityManager::encrypt_password($_POST['curr_password'])){
        $error[] = "Your current password does not match with your record";
    }

    if(trim($_POST['password']) == ''){
        $error[] = "Please enter the new password";
    }
    if(trim($_POST['confirm_password']) == ''){
        $error[] = "Please confirm the new password";
    }
    if($_POST['password'] !== $_POST['confirm_password']){
        $error[] = "Please enter the same password as above";
    }
    if(empty($error)){
        $where = "id='".$adminId."'";
        $row = array(
            'password' => UtilityManager::encrypt_password(trim($_POST['password']))
        );
        $result = $globalManager->runUpdateQuery("admin", $row, $where);
        if($result) {
            $_SESSION['message'] = "Your password has been changed successfully. Please <a href='" . ADMIN_SITE_URL . "dashboard.php'>click here</a> to go to <a href='" . ADMIN_SITE_URL . "dashboard.php'>Dashboard</a>";
        }
    }
}