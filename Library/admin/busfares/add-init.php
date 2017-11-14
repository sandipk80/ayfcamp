<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Bus Fare";
}else{
    $pageTitle = "Add Bus Fare";
}
$error = array();

if(isset($_POST) && isset($_POST['add-fare']) && trim($_POST['add-fare'])=='submit') {
    extract($_POST);
    if(isset($_POST['name']) && trim($_POST['name'])=='') {
        $error[] = 'Bus fare name is required';
    }else{
        $name = trim($_POST['name']);
    }
    if(isset($_POST['amount']) && trim($_POST['amount'])=='') {
        $error[] = 'us fare amount is required';
    }else{
        $amount = trim($_POST['amount']);
    }
    if(empty($error)) {
        if(isset($_POST['fid']) && trim($_POST['fid'])!=='') {
            $fareId = $_POST['fid'];
            $where = "id='".$fareId."'";
            $dataArray = array(
                'name' => $_POST['name'],
                'waitlist' => $_POST['waitlist'],
                'amount' => $_POST['amount']
            );
            $update = $globalManager->runUpdateQuery('bus_fares',$dataArray,$where);
            if($update){
                $_SESSION['message'] ="Bus fare has been updated successfully.";
                redirect(ADMIN_SITE_URL."busfares.php");
            }else{
                $_SESSION['errmsg'] = "Update failed. Please try again.";
            }
            
        }else{
            $dataArray = array(
                'name' => $_POST['name'],
                'waitlist' => $_POST['waitlist'],
                'amount' => $_POST['amount'],
                'created' => date("Y-m-d H:i:s")
            );
            $saveData = $globalManager->runInsertQuery('bus_fares',$dataArray);
            if($saveData){
                $_SESSION['message'] = "Bus fare has been added.";
                redirect(ADMIN_SITE_URL."busfares.php");
            }else{
                $_SESSION['errmsg'] = "Bus fare could not added. Please try again.";
            }

        }
        
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "bus_fares";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);
    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        extract($result[0]);
    }else{
        $_SESSION['errmsg'] = "Invalid bus fare selected! Please select valid bus fare to update";
        redirect(ADMIN_SITE_URL."busfares.php");
    }
}