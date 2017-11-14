<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Parent Profile";

if(isset($_GET['id']) && trim($_GET['id'])!==""){
	//find out the patient profile info
	$getUser = $globalManager->runSelectQuery("users as u LEFT JOIN states as st ON u.state=st.id", "u.*,st.name as state", "u.id='".trim($_GET['id'])."'");
	if(is_array($getUser) && !empty($getUser)){
	    $parent = $getUser[0];

	    //find out the child details
	    $getChilds = $globalManager->runSelectQuery("childs", "*", "user_id='".trim($_GET['id'])."'");
	    if(is_array($getChilds) && !empty($getChilds)){
	        foreach($getChilds as $j=>$crow){
	        	$chdId = $crow['id'];
	        	//find out the other details of child
	        	$getChildDetails = $globalManager->runSelectQuery("child_health_info", "*", "child_id='".$crow['id']."'");
	        	if(is_array($getChildDetails) && count($getChildDetails)>0){
	        		$childInfo = array_merge($crow,$getChildDetails[0]);
	        	}else{
	        		$childInfo = $crow;
	        	}
	        	//find out the medications
	        	$getMedications = $globalManager->runSelectQuery("child_medications", "medication_name,dosage,times_taken", "child_id='".$crow['id']."'");
	        	if(is_array($getMedications) && count($getMedications)>0){
	        		$childInfo['medications'] = $getMedications;
	        	}else{
	        		$childInfo['medications'] = array();
	        	}
	        	$parent['childs'][$j] = $childInfo;
	        	$parent['childs'][$j]['id'] = $chdId;
	        }
	        
	    }else{
	        $parent['childs'] = array();
	    }
	}else{
	    $_SESSION['errmsg'] = "Invalid parent selected.";
		redirect(ADMIN_SITE_URL.'users.php');
	}
}else{
	$_SESSION['errmsg'] = "No parent selected.";
	redirect(ADMIN_SITE_URL.'users.php');
}
//prx($parent);