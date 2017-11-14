<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//define advertiser id
$userId = $_SESSION['ayfcamp']['user']['userid'];

//find out the details of payment
if(isset($_GET['p']) && trim($_GET['p']) !== ""){
	//decode payment id
	$pid = UtilityManager::decrypt(trim($_GET['p']));
	$pWhere = "ap.id='".$pid."'";
	$getDetails = $globalManager->runSelectQuery("registration_payments as ap LEFT JOIN camp_registrations as a ON ap.registration_id=a.id", "ap.*,a.total_amount as total_amount,a.total_payable,a.total_campers", $pWhere);
	
	//prx($data);
	if(is_array($getDetails) && count($getDetails)>0){
		$receipt = $getDetails[0];
	}else{
		//$_SESSION['errmsg'] = "Invalid Request found";
		redirect(USER_SITE_URL.'profile.php');
	}
	
}else{
	$_SESSION['errmsg'] = "Invalid Request found";
	redirect(USER_SITE_URL.'profile.php');
}