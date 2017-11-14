<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Parent Profile";

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];

if(isset($_POST) && $_POST['edit-profile'] == "submit"){
	if (isset($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $error[] = "Please enter your first name";
    }else{
        $first_name = trim($_POST['first_name']);
    }

    if (isset($_POST['last_name']) && trim($_POST['last_name']) == '') {
        $error[] = "Please enter your last name";
    }else{
        $last_name = trim($_POST['last_name']);
    }

    if (isset($_POST['phone']) && trim($_POST['phone']) == '') {
        $error[] = "Please enter your phone number";
    }else{
        $phone = trim($_POST['phone']);
    }

    if (empty($error)) {
        $current_date = date("Y-m-d H:i:s");
        $userArray = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $_POST['phone'],
            'state' => $_POST['state_id'],
            'city' => $_POST['city'],
            'zipcode' => $_POST['zipcode'],
            'primary_parent_name' => $_POST['parent_name'],
            'primary_parent_phone' => $_POST['parent_phone'],
            'primary_parent_email' => $_POST['parent_email'],
            'secondary_parent_name' => $_POST['secondary_parent_name'],
            'secondary_parent_phone' => $_POST['secondary_parent_phone'],
            'secondary_parent_email' => $_POST['secondary_parent_email'],
            'primary_address' => $_POST['primary_address'],
            'primary_address2' => $_POST['address2'],
            'state' => $_POST['state_id'],
            'zipcode' => $_POST['zipcode'],
            'emergency_contact1' => $_POST['emergency_contact1'],
            'emergency_contact2' => $_POST['emergency_contact2'],
            'modified' => $current_date
        );

        $saveParent = $globalManager->runUpdateQuery('users', $userArray, "id='".$userId."'");
            
        if($saveParent) {
        	$_SESSION['message'] = "Parent profile has been updated successfully.";
    	}else{
    		$_SESSION['errmsg'] = "Update failed. Please try again";
    	}
	}
}

//find out the patient profile info
$getUser = $globalManager->runSelectQuery("users as u LEFT JOIN states as st ON u.state=st.id", "u.*,u.state as state_id,st.name as state", "u.id='".$userId."'");
if(is_array($getUser) && !empty($getUser)){
    $parent = $getUser[0];
    extract($parent);

    //find out the child details
    $arrChilds = $globalManager->runSelectQuery("childs", "*", "user_id='".$userId."'");

    //find out the camp registration history
    $arrHistory = $globalManager->runSelectQuery("camp_registrations as cr LEFT JOIN camps as cp ON cr.camp_id=cp.id", "cr.id,cr.camp_id,cr.total_campers,cr.total_amount,cr.payment_status,cp.title,cp.year,cr.created", "cr.user_id='".$userId."' ORDER BY cr.created DESC");
    if(is_array($arrHistory) && count($arrHistory)>0){
        foreach($arrHistory as $key=>$value){
            //find out the selected camper details
            $getCamper = $globalManager->runSelectQuery("campers as cmp LEFT JOIN childs as cld ON cmp.child_id=cld.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id", "CONCAT(cld.first_name,' ',cld.last_name) as childName,cps.title as campSession,cps.start_from,cps.end_at", "cmp.camp_id='".$value['camp_id']."' ORDER BY cmp.id ASC");
            if(is_array($getCamper) && count($getCamper)>0){
                $arrHistory[$key]['campers'] = $getCamper;
            }else{
                $arrHistory[$key]['campers'] = array();
            }
        }
    }

}else{
    redirect(USER_SITE_URL);
}
//prx($arrHistory);
//find out the list of states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "country_id='237'");