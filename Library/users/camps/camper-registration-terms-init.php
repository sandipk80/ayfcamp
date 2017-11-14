<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];
$error = array();
if(isset($_POST) && trim($_POST['camper-register'])=="submit"){
	$step = $_POST['step'];
	$registerId = UtilityManager::encrypt($_POST['camp_id']);
	redirect(USER_SITE_URL.'registration-payment.php?q='.$registerId);
}

if(isset($_GET['q']) && trim($_GET['q']) !== ""){
	$registerId = UtilityManager::decrypt(trim($_GET['q']));
	//find the registration details
	$getRegistration = $globalManager->runSelectQuery("camp_registrations", "*", "id='".$registerId."' AND user_id='".$userId."'");
	if(is_array($getRegistration) && count($getRegistration)>0){
		$campInfo = $getRegistration[0];
	}else{
		$_SESSION['errmsg'] = "Invalid camp registration.";
		redirect(USER_SITE_URL.'camp-registration.php');
	}

	if(isset($_GET['step']) && trim($_GET['step'])!==""){
		$step = $_GET['step'];
	}else{
		$step = "3";
	}

}

$pageTitle = "Summer Camp Registration";