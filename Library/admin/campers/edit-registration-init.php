<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Edit Camper";

if(isset($_GET['act'],$_GET['id']) && trim($_GET['act'])=="edit" && trim($_GET['id'])!==""){
	//find out the registration details
	$getDetails = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cr ON cmp.camp_registration_id=cr.id", "cmp.*", "cmp.id='".$_GET['id']."'");
	if(is_array($getDetails) && count($getDetails)>0){
		extract($getDetails[0]);
	}else{
		$_SESSION['errmsg'] = "Camper does not exists";
		redirect(ADMIN_SITE_URL.'camp-registrations.php');
	}
}

$error = array();
if(isset($_POST) && trim($_POST['edit-camper'])=="submit"){
	if($_POST['camp_session_id'] == ""){
		$error[] = "Camp session/week is required";
	}else{
		//check for earlier assigned
		if($camp_session_id !== $_POST['camp_session_id']){
			$checkCamper = $globalManager->runSelectQuery("campers", "IFNULL(COUNT(id),0) as total", "child_id='".$child_id."' AND camp_session_id='".$_POST['camp_session_id']."' AND camp_id='".$camp_id."'");
			if($checkCamper[0]['total'] > 0){
				$error[] = "This week is already assigned to this child";
			}else{
				$camp_session_id = $_POST['camp_session_id'];
			}
		}else{
			$camp_session_id = $_POST['camp_session_id'];
		}
	}

	if($_POST['bus_fare'] !== ""){
		$bus_fare = $_POST['bus_fare'];
	}else{
		$bus_fare = "";
	}

	if($_POST['snack_shop_amount'] !== ""){
		$snack_shop_amount = $_POST['snack_shop_amount'];
	}else{
		$snack_shop_amount = "";
	}


    if(empty($error)){
		//find out the total registered campers for session
	    $getCampers = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cmpr ON cmp.camp_registration_id=cmpr.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id", "IFNULL(COUNT(cmp.id),0) as total,cps.camper_limit", "cmp.camp_session_id='".$camp_session_id."' AND cmpr.status='1' AND cmpr.payment_status='SUCCESS'");
	    if($getCampers[0]['total'] >= $getCampers[0]['camper_limit']){
	        $waitlist = "1";
	    }else{
	        $waitlist = "0";
	    }

		$cWhere = "id='".$_POST['cid']."'";
		$camperArray = array(
			'camp_session_id' => $camp_session_id,
			'bus_opt' => $bus_fare,
			'snack_shop_amount' => $snack_shop_amount,
			'waitlist' => $waitlist
		);
		$updateCamper = $globalManager->runUpdateQuery("campers", $camperArray, $cWhere);
		if($updateCamper){
			$_SESSION['message'] = "Camper has been updated successfully.";
			redirect(ADMIN_SITE_URL.'camp-registrations.php');
		}else{
			$_SESSION['errmsg'] = "Action failed. Please try again.";
			redirect(ADMIN_SITE_URL.'camp-registrations.php');
		}
	}
}

//first find out the camp details
$getCamp = $globalManager->runSelectQuery("camps", "*", "status='1' LIMIT 0,1");
if(is_array($getCamp) && count($getCamp)>0){
	$camp = $getCamp[0];
	//find out the camp sessions
	$getSessions = $globalManager->runSelectQuery("camp_sessions", "*", "camp_id='".$camp['id']."'");
	if(is_array($getSessions) && count($getSessions)>0){
		foreach($getSessions as $k=>$session){
			$camperLimit = $session['camper_limit'];
			$sessionEndDate = date("Y-m-d", strtotime($session['end_at']));
			$currentDate = date("Y-m-d");
			//find out the total registered campers for session
			$getCampers = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cmpr ON cmp.camp_registration_id=cmpr.id", "IFNULL(COUNT(cmp.id),0) as total", "cmp.camp_session_id='".$session['id']."' AND cmpr.status='1' AND cmpr.payment_status='SUCCESS'");

			$totalCampers = $getCampers[0]['total'];
			if($totalCampers >= $camperLimit){
				$getSessions[$k]['waitlist'] = '1';
			}else{
				$getSessions[$k]['waitlist'] = '0';
			}

			//check session duration
			if($currentDate >= $sessionEndDate){
				$getSessions[$k]['expire'] = '1';
			}else{
				$getSessions[$k]['expire'] = '0';
			}
		}
		$camp['sessions'] = $getSessions;
	}
}