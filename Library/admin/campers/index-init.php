<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Camp Registrations";

##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['hidAct']) && trim($_REQUEST['hidAct'])!=='') {
	//prx($_REQUEST);
	$Ids = explode(",",$_REQUEST['hidAllId']);
	if(isset($_REQUEST['hidAct']) && (trim($_REQUEST['hidAct'])=='Activate' || trim($_REQUEST['hidAct'])=='activate')) {
		$status="1";
	}
	else {
		$status="0";
	}

	if(is_array($Ids) && count($Ids)>0) {
		foreach($Ids as $stausKey=>$statusVal) {
			if($_REQUEST['hidAct']=='Delete') {
				$where="id='".$statusVal."'";
				$result = $globalManager->runDeleteQuery("camp_registrations",$where);
				$delInfo = $globalManager->runDeleteQuery("campers","camp_registration_id='".$statusVal."'");
				$delPayment = $globalManager->runDeleteQuery("registration_payments","registration_id='".$statusVal."'");
			}
			else {
				if($statusVal!=='') {
					$where="id='".$statusVal."'";
					$value=array('status'=>$status);
					$result = $globalManager->runUpdateQuery("camp_registrations",$value,$where);
				}
			}
		}
		if($result) {
			$_SESSION['message'] =	"Record(s) ".$_REQUEST['hidAct']."d successfully.";
			redirect($_SERVER['PHP_SELF']);
		}
		else {
			$_SESSION['message'] =	"Record(s) not ".$_REQUEST['hidAct']."d. Please try again";
			redirect($_SERVER['PHP_SELF']);
		}
	}
}

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where="id='".$_REQUEST['id']."'";
	$getStatus = $globalManager->runDeleteQuery("camp_registrations",$where);
	if($getStatus) {
		$delInfo = $globalManager->runDeleteQuery("campers","camp_registration_id='".$statusVal."'");
		$delPayment = $globalManager->runDeleteQuery("registration_payments","registration_id='".$_REQUEST['id']."'");
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."campers.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("camp_registrations",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
        redirect(ADMIN_SITE_URL."campers.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("camp_registrations",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
        redirect(ADMIN_SITE_URL."campers.php");
	}
}

##----------------ACT DELETE END--------------##

if(isset($_REQUEST['week']) && trim($_REQUEST['week'])!==""){
	$relTable = "camp_registrations as cr LEFT JOIN users as u ON cr.user_id=u.id LEFT JOIN registration_payments as rp ON cr.id=rp.registration_id LEFT JOIN camps as cm ON cr.camp_id=cm.id LEFT JOIN campers as cpr ON cr.id=cpr.camp_registration_id";
	$where = "cpr.camp_session_id='".$_REQUEST['week']."' GROUP BY cr.id ORDER BY cr.created DESC";
}else{
	$relTable = "camp_registrations as cr LEFT JOIN users as u ON cr.user_id=u.id LEFT JOIN registration_payments as rp ON cr.id=rp.registration_id LEFT JOIN camps as cm ON cr.camp_id=cm.id";
	$where = "1=1 ORDER BY cr.created DESC";
}
$relFields = "cr.*, u.email,u.first_name,u.last_name,u.phone,u.primary_address,u.primary_address2,u.city,u.state,u.zipcode,cm.title as camp_title,cm.year as campyear";
$result = $globalManager->runSelectQuery($relTable, $relFields, $where);
//prx($result);

//find out the list of camps
$arrCamps = $globalManager->runSelectQuery("camp_sessions as cmps LEFT JOIN camps as cp ON cmps.camp_id=cp.id", "cp.id as campId,cp.title as campTitle,cp.year as campYear,cmps.id,cmps.title,cmps.start_from,cmps.end_at", "1=1 ORDER BY cp.created DESC");
