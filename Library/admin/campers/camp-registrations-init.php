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

$relTable = "campers as cmp LEFT JOIN camp_registrations as cr ON cmp.camp_registration_id=cr.id LEFT JOIN childs as cld ON cmp.child_id=cld.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN snackshop as sn ON cmp.camp_registration_id=sn.camp_registration_id LEFT JOIN bus_fares as bf ON cmp.bus_opt=bf.id";
if(isset($_REQUEST['week']) && trim($_REQUEST['week'])!==""){
	$where = "cmp.camp_session_id='".$_REQUEST['week']."'";
}else{
	$where = "1=1";
}
$where .= " GROUP BY cmp.id ORDER BY cmp.id DESC";
$relFields = "cmp.id,cmp.child_id,CONCAT(cld.first_name,' ',cld.last_name) as childName,cmp.bus_opt,cps.title as campSession,cps.start_from,cps.end_at,sn.amount as snack_amount,cr.payment_status,cr.created,bf.name as bus_fare,bf.amount as bus_amount,bf.waitlist as bus_waitlist";
$result = $globalManager->runSelectQuery($relTable, $relFields, $where);
//prx($result);

//find out the list of camps
$arrCamps = $globalManager->runSelectQuery("camp_sessions as cmps LEFT JOIN camps as cp ON cmps.camp_id=cp.id", "cp.id as campId,cp.title as campTitle,cp.year as campYear,cmps.id,cmps.title,cmps.start_from,cmps.end_at", "1=1 ORDER BY cp.created DESC");
