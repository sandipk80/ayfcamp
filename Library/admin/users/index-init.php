<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Users";

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
				$result = $globalManager->runDeleteQuery("users",$where);
				$delInfo = $globalManager->runDeleteQuery("user_informations","user_id='".$statusVal."'");
			}
			else {
				if($statusVal!=='') {
					$where="id='".$statusVal."'";
					$value=array('status'=>$status);
					$result = $globalManager->runUpdateQuery("users",$value,$where);
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
	$getStatus = $globalManager->runDeleteQuery("users",$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."users.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("users",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
        redirect(ADMIN_SITE_URL."users.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("users",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
        redirect(ADMIN_SITE_URL."users.php");
	}
}

##----------------ACT DELETE END--------------##

$where = "1=1";
$relTable = "users as u LEFT JOIN states as st ON u.state=st.id";
$relFields = "u.*,st.name as state";
$result = $globalManager->runSelectQuery($relTable, $relFields, $where);