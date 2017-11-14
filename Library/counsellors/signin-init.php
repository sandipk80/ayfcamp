<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//check for already logged in
if(isset($_SESSION['ayfcamp']['counsellor']['userid']) && trim($_SESSION['ayfcamp']['counsellor']['userid'])!=='') {
    //check for valid id
    $logUser = $globalManager->runSelectQuery("counsellors", "id", "id='".$_SESSION['ayfcamp']['counsellor']['userid']."'");
    if(is_array($logUser) && count($logUser)>0){
        redirect(COUNSELLOR_SITE_URL.'home.php');
        exit;
    }else{
        redirect(COUNSELLOR_SITE_URL.'logout.php');
    }
}

$errors = array();
if(isset($_POST['user-login']) && trim($_POST['user-login'])=='login') {
	if(isset($_POST['username']) && trim($_POST['username'])=='') {	
		$errors[] = "E-mail cannot be left blank";
	}
	
	if(isset($_POST['password']) && trim($_POST['password'])=='') {
		$errors[] = "Password cannot be left blank";
	}
	
	if(count($errors)==0) {
		$password = UtilityManager::encrypt_password($_POST['password']);
		##-------GET DOCTOR USER INFO---------##
		$where="email='".$_POST['username']."' AND password='".$password."' AND status='1'";
		$getUser = $globalManager->runSelectQuery('counsellors',"*",$where);

		if(is_array($getUser) && count($getUser)>0) {
			$_SESSION['ayfcamp']['counsellor']['name'] = $getUser[0]['first_name'] . ' ' . $getUser[0]['last_name'];
            $_SESSION['ayfcamp']['counsellor']['userid'] = $getUser[0]['id'];
            $_SESSION['ayfcamp']['counsellor']['email'] = $getUser[0]['email'];
            
            //update last login date
            $condition = "id='" . $getUser[0]['id'] . "'";
            $logindate = array('last_login' => date("Y-m-d H:i:s"));
            $updateLoginDate = $globalManager->runUpdateQuery("counsellors", $logindate, $condition);
            redirect(COUNSELLOR_SITE_URL.'home.php');
		}else {
			$errors[] = "Please enter valid E-mail and password";
		}
	}

}

?>