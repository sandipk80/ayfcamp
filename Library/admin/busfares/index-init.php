<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Bus Fare";

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where = "id='".$_REQUEST['id']."'";
	$deleteCoupon = $globalManager->runDeleteQuery("bus_fares", $where);
	if($deleteCoupon) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."busfares.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where = "id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("bus_fares",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
		redirect(ADMIN_SITE_URL."busfares.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("bus_fares",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
		redirect(ADMIN_SITE_URL."busfares.php");
	}
}

##----------------ACT DELETE END--------------##
$result = $globalManager->runSelectQuery("bus_fares","*","1=1");
//prx($result);