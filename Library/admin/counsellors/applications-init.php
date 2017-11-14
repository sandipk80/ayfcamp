<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Counsellor Applications";

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
				$result = $globalManager->runDeleteQuery("counsellor_applications",$where);
				$delInfo = $globalManager->runDeleteQuery("counsellor_certifications","counsellor_id='".$statusVal."'");
				$delInfo = $globalManager->runDeleteQuery("counsellor_educations","counsellor_id='".$statusVal."'");
				$delInfo = $globalManager->runDeleteQuery("counsellor_experiences","counsellor_id='".$statusVal."'");
				$delInfo = $globalManager->runDeleteQuery("counsellor_preferred_weeks","counsellor_id='".$statusVal."'");
				$delInfo = $globalManager->runDeleteQuery("counsellor_work_history","counsellor_id='".$statusVal."'");
			}
			else {
				if($statusVal!=='') {
					$where="id='".$statusVal."'";
					$value=array('status'=>$status);
					$result = $globalManager->runUpdateQuery("counsellor_applications", $value, $where);
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
	$getStatus = $globalManager->runDeleteQuery("counsellors",$where);
	if($getStatus) {
		$delInfo = $globalManager->runDeleteQuery("counsellor_applications","counsellor_id='".$statusVal."'");
		$delInfo = $globalManager->runDeleteQuery("counsellor_certifications","counsellor_id='".$statusVal."'");
		$delInfo = $globalManager->runDeleteQuery("counsellor_educations","counsellor_id='".$statusVal."'");
		$delInfo = $globalManager->runDeleteQuery("counsellor_experiences","counsellor_id='".$statusVal."'");
		$delInfo = $globalManager->runDeleteQuery("counsellor_preferred_weeks","counsellor_id='".$statusVal."'");
		$delInfo = $globalManager->runDeleteQuery("counsellor_work_history","counsellor_id='".$statusVal."'");
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."counsellors.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("counsellors",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
        redirect(ADMIN_SITE_URL."counsellors.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("counsellors",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
        redirect(ADMIN_SITE_URL."counsellors.php");
	}
}

##----------------ACT DELETE END--------------##
if(isset($_GET['cid']) && trim($_GET['cid'])!==""){
	$where = "counsellor_id='".$_GET['cid']."'";
}else{
	$where = "1=1";
}
$relTable = "counsellor_applications as ca LEFT JOIN states as st ON ca.state=st.id";
$relFields = "ca.*,st.name as state";
$result = $globalManager->runSelectQuery($relTable, $relFields, $where);
