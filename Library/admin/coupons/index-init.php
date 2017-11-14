<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Vouchers";

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where = "id='".$_REQUEST['id']."'";
	$deleteCoupon = $globalManager->runDeleteQuery("coupons", $where);
	if($deleteCoupon) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."coupons.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where = "id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("coupons",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
		redirect(ADMIN_SITE_URL."coupons.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("coupons",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
		redirect(ADMIN_SITE_URL."coupons.php");
	}
}

##----------------ACT DELETE END--------------##
$result = $globalManager->runSelectQuery("coupons","*","1=1");
//prx($result);