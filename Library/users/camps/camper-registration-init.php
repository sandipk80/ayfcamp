<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];
$error = array();
$output_dir = STORAGE_PATH."campers/";
if(isset($_POST) && trim($_POST['camper-register'])=="submit"){
	//check for valid code
	if(isset($_POST['camp_register_code']) && trim($_POST['camp_register_code'])!==""){
		$getCode = $globalManager->runSelectQuery("campers", "camp_id,camp_registration_id", "registration_code='".trim($_POST['camp_register_code'])."' AND user_id='".$userId."'");
		if(is_array($getCode) && count($getCode)>0){
			$campId = $getCode[0]['camp_id'];
			$campRegisterId = $getCode[0]['camp_registration_id'];
		}else{
			$error[] = "Invalid regiter code.";
		}
	}

	if($_POST['step'] && $_POST['step']!==""){
		$stepCount = $_POST['step'];
	}else{
		$stepCount = "3";
	}
	if(empty($error)){
		//upload identity front document
		$frontImageFile = "";
		$backImageFile = "";
        $extensions = array("jpeg","jpg","png","bmp","gif");
        if(is_array($_FILES['insurance_card_front']) && trim($_FILES['insurance_card_front']['name'])!=='' && isset($_FILES['insurance_card_front']['error']) && trim($_FILES['insurance_card_front']['error'])=='0') {
            $imgFile = $_FILES['insurance_card_front'];
            $file_name = $imgFile['name'];
            $file_size = $imgFile['size'];
            $file_tmp = $imgFile['tmp_name'];
            $file_type = $imgFile['type'];

            //check the file extension
            $file_ext = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions ) === false){
                $error[] = "Extension not allowed for file ".$file_name;
            }

            //check the file size
            if($file_size > 2097152){
                //$error[] = "File size for image ".$file_name." must be less than 2 MB";
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "campers/" . $filename;
                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    $frontImageFile = $filename;
                }
            }
        }

        if(is_array($_FILES['insurance_card_back']) && trim($_FILES['insurance_card_back']['name'])!=='' && isset($_FILES['insurance_card_back']['error']) && trim($_FILES['insurance_card_back']['error'])=='0') {
            $imgFile = $_FILES['insurance_card_back'];
            $file_name = $imgFile['name'];
            $file_size = $imgFile['size'];
            $file_tmp = $imgFile['tmp_name'];
            $file_type = $imgFile['type'];

            //check the file extension
            $file_ext = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions ) === false){
                $error[] = "Extension not allowed for file ".$file_name;
            }

            //check the file size
            if($file_size > 2097152){
                //$error[] = "File size for image ".$file_name." must be less than 2 MB";
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "campers/" . $filename;
                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    $backImageFile = $filename;
                }
            }
        }


		//update camper info
		$camperArray = array(
			'parent_name' => $_POST['parent_name'],
			'parent_phone' => $_POST['parent_phone'],
			'address' => $_POST['address'],
		    'location' => $_POST['location'],
		    'physician_name' => $_POST['physician_name'],
		    'physician_phone' => $_POST['physician_phone'],
		    'insurance_carrier' => $_POST['insurance_carrier'],
		    'group_number' => $_POST['group_number'],
		    'agreement_number' => $_POST['agreement_number'],
		    'emergency_contact' => $_POST['emergency_contact'],
		    'emergency_phone' => $_POST['emergency_phone'],
		    'recent_illness' => $_POST['recent_illness'],
		    'chronic_illness' => $_POST['chronic_illness'],
		    'past_mononucleosis' => $_POST['past_mononucleosis'],
		    'eye_wear' => $_POST['eye_wear'],
		    'hospitalization' => $_POST['hospitalization'],
		    'surgery' => $_POST['surgery'],
		    'frequent_headache' => $_POST['frequent_headache'],
		    'head_injury' => $_POST['head_injury'],
		    'knocked_unconscious' => $_POST['knocked_unconscious'],
		    'ear_infections' => $_POST['ear_infections'],
		    'excercise_fainting' => $_POST['excercise_fainting'],
		    'excercise_dizziness' => $_POST['excercise_dizziness'],
		    'seizures' => $_POST['seizures'],
		    'chest_pain' => $_POST['chest_pain'],
		    'high_blood_pressure' => $_POST['high_blood_pressure'],
		    'heart_murmurs' => $_POST['heart_murmurs'],
		    'back_problem' => $_POST['back_problem'],
		    'asthama' => $_POST['asthama'],
		    'diabetes' => $_POST['diabetes'],
		    'diarrhea' => $_POST['diarrhea'],
		    'sleepwalking' => $_POST['sleepwalking'],
		    'bed_wetting' => $_POST['bed_wetting'],
		    'eating_disorder' => $_POST['eating_disorder'],
		    'joint_problem' => $_POST['joint_problem'],
		    'strep_throat' => $_POST['strep_throat'],
		    'skin_problem' => $_POST['skin_problem'],
		    'brought_orthodontic_appliance' => $_POST['brought_orthodontic_appliance'],
		    'emotional_difficulties' => $_POST['emotional_difficulties'],
		    'additional_information' => $_POST['additional_information'],
		    'explanations' => $_POST['explanations'],
		    'status' => '1'
		);
		$saveCamper = $globalManager->runUpdateQuery("campers", $camperArray, "registration_code='".$_POST['camp_register_code']."'");
		if($saveCamper){
			$_SESSION['message'] = "Camper details has been saved successfully";
			//find out the next camper update
			$getNextCamper = $globalManager->runSelectQuery("campers", "registration_code", "camp_id='".$campId."' AND camp_registration_id='".$campRegisterId."' AND user_id='".$userId."' AND status='0'");
			if(is_array($getNextCamper) && count($getNextCamper)>0){
				$nextRegisterCode = $getNextCamper[0]['registration_code'];
				$nextCode = UtilityManager::encrypt($nextRegisterCode);
				redirect(USER_SITE_URL.'camper-information.php?q='.$nextCode.'&step='.$stepCount);
			}else{
				$camp_registration_id = UtilityManager::encrypt($campRegisterId);
				redirect(USER_SITE_URL.'camper-registration-terms.php?q='.$camp_registration_id.'&step='.$stepCount);
			}
		}
	}
}

if(isset($_GET['q']) && trim($_GET['q']) !== ""){
	$registerCode = UtilityManager::decrypt(trim($_GET['q']));
	//find the registration details
	$getRegistration = $globalManager->runSelectQuery("campers", "child_id,camp_id,camp_session_id,camp_registration_id,step,status", "	registration_code='".$registerCode."'");
	if(is_array($getRegistration) && count($getRegistration)>0){
		$camperInfo = $getRegistration[0];
	}else{
		$_SESSION['errmsg'] = "Invalid camp registration.";
		redirect(USER_SITE_URL.'camp-registration.php');
	}

	//check for camper
	if(isset($camperInfo['child_id']) && trim($camperInfo['child_id']) !== ""){
		$getCamper = $globalManager->runSelectQuery("childs", "*", "id='".$camperInfo['child_id']."' AND user_id='".$userId."'");
		if(is_array($getCamper) && count($getCamper)>0){
			$camperInfo = $getCamper[0];
			if($camperInfo['photo'] !== "" && file_exists(STORAGE_PATH.'campers/'.$camperInfo['photo'])){
				$camperImage = STORAGE_HTTP_PATH.'campers/'.$camperInfo['photo'];
			}else{
				$camperImage = IMG_PATH.'user.jpg';
			}
		}else{
			$_SESSION['errmsg'] = "Invalid camper registration.";
			redirect(USER_SITE_URL.'camp-registration.php?rid='.$camperInfo['camp_registration_id']);
		}
	}else{
		$_SESSION['errmsg'] = "No camper selected. Please select any camper to register";
		redirect(USER_SITE_URL.'camp-registration.php?rid='.$_GET['rid']);
	}

	if(isset($_GET['step']) && trim($_GET['step'])!==""){
		$step = $_GET['step'];
	}else{
		$step = $camperInfo['step']+1;
	}

}

$pageTitle = "Summer Camp Registration";