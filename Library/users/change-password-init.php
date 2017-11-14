<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$userId = $_SESSION['moore']['user']['userid'];

if(isset($_POST['change-password']) && trim($_POST['change-password'])=='Submit') {
    //first find out the user current password
    $where = "id='".$userId."'";
    $getCurrentPassword = $globalManager->runSelectQuery("users", "password", $where);

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
        $where = "id='".$userId."'";
        $row = array(
            'password' => UtilityManager::encrypt_password(trim($_POST['password'])),
            'modified' => date("Y-m-d H:i:s")
        );
        $result = $globalManager->runUpdateQuery("users", $row, $where);
        if($result) {
            $_SESSION['message'] = "Your password has been changed successfully.";
        }
    }
}