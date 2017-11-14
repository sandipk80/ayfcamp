<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$userId = $_SESSION['moore']['user']['userid'];

//set page title
$pageTitle = "Appointments";

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where="id='".$_REQUEST['id']."' AND user_id='".$userId."'";
	$getStatus = $globalManager->runDeleteQuery("appointments",$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."appointments.php");
	}
}
##----------------ACT DELETE END--------------##

$pWhere = "apt.user_id='".$userId."'";
$relTable = "appointments as apt LEFT JOIN doctors as doc ON apt.doctor_id=doc.id LEFT JOIN categories as cat ON apt.category_id=cat.id LEFT JOIN services as sv ON apt.service_id=sv.id";
$relFields = "apt.*,CONCAT(doc.first_name,' ',doc.last_name) as docname,cat.name as catname,sv.name as service";
$result = $globalManager->runSelectQuery($relTable,$relFields,$pWhere);