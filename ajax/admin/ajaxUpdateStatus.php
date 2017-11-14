<?php
include('../../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$json = array();
if(isset($_POST['tb']) && isset($_POST['st'])){
	$tblname = trim($_POST['tb']);
	$status = trim($_POST['st']);
	if(isset($_POST['id'])){
		$id = trim($_POST['id']);
		$where = "id='".trim($_POST['id'])."'";
	}elseif(isset($_GET['opt']) && $_GET['opt'] == 'all'){
		$where = "";
	}
	$data = array('status' => $status);
    
	$result = $globalManager->runUpdateQuery($tblname, $data, $where);
	if($result){
		$json["result"] = "success";
		$json["message"] = "Record has been updated";
	}else{
		$json["result"] = "error";
		$json["message"] = "Action failed! Please try again";
	}
}else{
	$json["result"] = "error";
	$json["message"] = "Invalid option! Please check valid option";
}
header('Content-Type: application/json');
echo json_encode($json);
exit;