<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();		

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='logout') {
	session_destroy();
	redirect(SITE_URL."admin/index.php");
	exit;
}

//find out the total registration in last 30 days
$arrRegistrations = $result = $globalManager->runSelectQuery("camp_registrations as cr LEFT JOIN users as u ON cr.user_id=u.id LEFT JOIN camps as cs ON cr.camp_id=cs.id", "cr.*, u.email,u.first_name,u.last_name,cs.title as camp_title", "cr.created>=DATE_SUB(CURDATE(), INTERVAL 30 DAY) ORDER BY cr.created DESC");
?>