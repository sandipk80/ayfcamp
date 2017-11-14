<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Counsellor Application";

if(isset($_GET['id']) && trim($_GET['id'])!==""){
	//find out the patient profile info
	$getUser = $globalManager->runSelectQuery("counsellor_applications as ca LEFT JOIN states as st ON ca.state=st.id", "ca.*,st.name as state", "ca.id='".trim($_GET['id'])."'");
	if(is_array($getUser) && !empty($getUser)){
	    extract($getUser[0]);
	    $counsellorId = $counsellor_id;
	    $applicationId = $id;

	    if($id_photo !== "" && file_exists(STORAGE_PATH.'counsellors/'.$id_photo)){
	    	$id_photo = STORAGE_HTTP_PATH.'counsellors/'.$id_photo;
	    }else{
	    	$id_photo = IMG_PATH.'user.jpg';
	    }

	    $application = array();
	    //find out the selected camp
	    $getCamp = $globalManager->runSelectQuery("counsellor_preferred_weeks as cpw LEFT JOIN camp_sessions as cs ON cpw.camp_session_id=cs.id", "cpw.is_alternate,cs.title,cs.start_from,cs.end_at", "cpw.application_id='".$applicationId."'");
	    if(is_array($getCamp) && !empty($getCamp)){
	        $application['weeks'] = $getCamp;
	    }else{
	        $application['weeks'] = array();
	    }

	    //find out the work history
	    $getWorkHistory = $globalManager->runSelectQuery("counsellor_work_history", "employer_name,dates,supervisor,employer_info,work_nature", "application_id='".$applicationId."'");
	    if(is_array($getWorkHistory) && !empty($getWorkHistory)){
	        $application['works'] = $getWorkHistory;
	    }else{
	        $application['works'] = array();
	    }

	    //find out the education
	    $getEducation = $globalManager->runSelectQuery("counsellor_educations", "year,school_name,major,degree_granted", "application_id='".$applicationId."'");
	    if(is_array($getEducation) && !empty($getEducation)){
	        $application['education'] = $getEducation;
	    }else{
	        $application['education'] = array();
	    }

	    //find out the experince
	    $getExperience = $globalManager->runSelectQuery("counsellor_experiences", "dates,camp_name,camp_locations,camper_or_staff", "application_id='".$applicationId."'");
	    if(is_array($getExperience) && !empty($getExperience)){
	        $application['experience'] = $getExperience;
	    }else{
	        $application['experience'] = array();
	    }

	    //find out the certifications
	    $getCertificate = $globalManager->runSelectQuery("counsellor_certifications", "certificate_image", "application_id='".$applicationId."'");
	    if(is_array($getCertificate) && !empty($getCertificate)){
	    	$j = 0;
	    	foreach($getCertificate as $certificate){
	    		if($certificate['certificate_image'] !== "" && file_exists(STORAGE_PATH.'counsellors/'.$certificate['certificate_image'])){
	        		$application['certificate'][$j] = $certificate['certificate_image'];
	        		$j++;
	    		}
    		}
	    }else{
	        $application['certificate'] = array();
	    }
	    //prx($application);
	}else{
	    $_SESSION['errmsg'] = "Invalid parent selected.";
		redirect(ADMIN_SITE_URL.'users.php');
	}
}else{
	$_SESSION['errmsg'] = "No parent selected.";
	redirect(ADMIN_SITE_URL.'users.php');
}