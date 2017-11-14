<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Edit Profile";

//find out logged in user id
$adminId = $_SESSION['admin_userid'];

if(isset($_POST['edit-profile']) && trim($_POST['edit-profile'])=='Submit') {
    if(isset($_POST['first_name']) && trim($_POST['first_name'])=='') {
        $error[] ="Please enter your first name";
    }else{
        $first_name = trim($_POST['first_name']);
    }

    if(isset($_POST['last_name']) && trim($_POST['last_name'])=='') {
        $error[] ="Please enter your last name";
    }else{
        $last_name = trim($_POST['last_name']);
    }

    if(isset($_POST['email']) && trim($_POST['email'])=='') {
        $error[] ="Please enter your email";
    }else{
        $email = trim($_POST['email']);
    }

    if(empty($error)){
        $where = "id='".$adminId."'";
        $adminArray = array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email']
        );
        $updateUser = $globalManager->runUpdateQuery('admin',$adminArray,$where);
        if($updateUser){
            //reset login session
            $_SESSION['admin_username'] = $_POST['email'];
            $_SESSION['admin_full_name'] = $_POST['first_name'].' '.$_POST['last_name'];
        }
        $_SESSION['message'] ="Admin account has been updated successfully.";
        redirect(SITE_URL."admin/dashboard.php");
    }
}

//find out the logged in owner details
$where = "id='".$adminId."'";
$result = $globalManager->runSelectQuery("admin","*",$where);
if(is_array($result) && count($result)>0){
    $first_name = $result[0]['first_name'];
    $last_name = $result[0]['last_name'];
    $email = $result[0]['email'];
}