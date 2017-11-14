<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Camp Registration Details";

if(isset($_GET['id'], $_GET['act']) && trim($_GET['id'])!=="" && trim($_GET['act'])=="view"){
	//find out the registration details
	$getResult = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cr ON cmp.camp_registration_id=cr.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN snackshop as sn ON cmp.camp_registration_id=sn.camp_registration_id LEFT JOIN camps as cp ON cmp.camp_id=cp.id LEFT JOIN bus_fares as bf ON cmp.bus_opt=bf.id", "cmp.*,cr.user_id,cp.title as campname,cps.title as campSession,cps.start_from,cps.end_at,sn.amount as snack_amount,cr.payment_status,cr.created,bf.name as bus_fare,bf.amount as bus_amount,bf.waitlist as bus_waitlist", "cmp.id='".$_GET['id']."' GROUP BY cmp.id");

	if(is_array($getResult) && count($getResult)>0){
		$result = $getResult[0];

		if($result['bus_fare'] !== ""){
	        if($result['bus_waitlist'] == "1"){
	            $busoption = $result['bus_fare']." $".$result['bus_amount'].' - Waitlist Only';
	        }else{
	            $busoption = $result['bus_fare']." $".$result['bus_amount'];
	        }
	    }
		$result['busoption'] = $busoption;
		//find out the patient profile info
		$getChild = $globalManager->runSelectQuery("childs as cld LEFT JOIN users as u ON cld.user_id=u.id LEFT JOIN states as st ON u.state=st.id", "cld.*,CONCAT(u.first_name,' ',u.last_name) as parent_name,st.name as state", "cld.id='".$result['child_id']."'");
		if(is_array($getChild) && !empty($getChild)){
	    	$camper = $getChild[0];
        	//find out the other details of child
        	$getChildDetails = $globalManager->runSelectQuery("child_health_info", "*", "child_id='".$camper['id']."'");
        	if(is_array($getChildDetails) && count($getChildDetails)>0){
        		$camper = array_merge($camper,$getChildDetails[0]);
        	}
        	//find out the medications
        	$getMedications = $globalManager->runSelectQuery("child_medications", "medication_name,dosage,times_taken", "child_id='".$camper['id']."'");
        	if(is_array($getMedications) && count($getMedications)>0){
        		$camper['medications'] = $getMedications;
        	}else{
        		$camper['medications'] = array();
        	}
		    $result['camper'] = $camper;
	    }else{
	    	$_SESSION['errmsg'] = "Camper does not exists.";
			redirect(ADMIN_SITE_URL.'camp-registrations.php');
	    }
	}else{
	    $_SESSION['errmsg'] = "Invalid request.";
		redirect(ADMIN_SITE_URL.'camp-registrations.php');
	}
}else{
	$_SESSION['errmsg'] = "Invalid request";
	redirect(ADMIN_SITE_URL.'camp-registrations.php');
}
