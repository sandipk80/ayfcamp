<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Edit Profile";

//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];

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

    if(empty($error)){
        $where = "id='".$adminId."'";
        $docArray = array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'modified' => date("Y-m-d H:i:s")
        );
        $updateUser = $globalManager->runUpdateQuery('doctors',$docArray,$where);
        if($updateUser){
            //reset login session
            $_SESSION['moore']['doctor']['name'] = $_POST['first_name'].' '.$_POST['last_name'];
        }
        $_SESSION['message'] ="Your doctor account has been updated successfully.";
        redirect(DOCTOR_SITE_URL."dashboard.php");
    }
}

//find out the logged in owner details
$where = "id='".$doctorId."'";
$result = $globalManager->runSelectQuery("doctors","*",$where);
if(is_array($result) && count($result)>0){
    $first_name = $result[0]['first_name'];
    $last_name = $result[0]['last_name'];
    $email = $result[0]['email'];
}