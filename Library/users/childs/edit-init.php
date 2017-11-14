<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

//check for patient login
$userId = $_SESSION['ayfcamp']['user']['userid'];

//signup submit
$error = array();
$output_dir = STORAGE_PATH."campers/";
if(isset($_POST['add-camper']) && trim($_POST['add-camper'])=='submit') {
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

    if (isset($_POST['relation']) && trim($_POST['relation']) == '') {
        $error[] = "Please enter your relation with this child";
    }else{
        $relation = trim($_POST['relation']);
    }

    if(isset($_POST['date_of_birth']) && trim($_POST['date_of_birth'])!==''){
        $date_of_birth = $_POST['date_of_birth'];
        $date_of_birth = date("Y-m-d", strtotime($date_of_birth));
    }else{
        $error[] ="Please select your date of birth";
    }

    if(empty($error)){
        $current_date = date("Y-m-d H:i:s");
        $imageFile = "";
        $insuranceFrontImg = "";
        $insuranceBackImg = "";
        $insRecordFileImg = "";
        $extensions = array("jpeg","jpg","png","bmp","gif");
        $extensions2 = array("jpeg","jpg","png","bmp","gif","pdf");

        //upload child photo
        if(is_array($_FILES['imgfile']) && trim($_FILES['imgfile']['name'])!=='' && isset($_FILES['imgfile']['error']) && trim($_FILES['imgfile']['error'])=='0') {
            $imgFile = $_FILES['imgfile'];
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
                $httpRootSmall = STORAGE_PATH . "campers/small/" . $filename;
                $httpRootThumb = STORAGE_PATH . "campers/thumbs/" . $filename;

                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                    #For 120x80 Thumb   
                    UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);               

                    $imageFile = $filename;
                }
            }
        }

        //upload child insurance front photo
        if(is_array($_FILES['insurance_card_front']) && trim($_FILES['insurance_card_front']['name'])!=='' && isset($_FILES['insurance_card_front']['error']) && trim($_FILES['insurance_card_front']['error'])=='0') {
            $insFrontFile = $_FILES['insurance_card_front'];
            $file_name = $insFrontFile['name'];
            $file_size = $insFrontFile['size'];
            $file_tmp = $insFrontFile['tmp_name'];
            $file_type = $insFrontFile['type'];

            //check the file extension
            $file_ext = pathinfo($insFrontFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions2 ) === false){
                $error[] = "Extension not allowed for file ".$file_name;
            }

            //check the file size
            if($file_size > 2097152){
                //$error[] = "File size for image ".$file_name." must be less than 2 MB";
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "campers/" . $filename;
                $httpRootSmall = STORAGE_PATH . "campers/small/" . $filename;
                $httpRootThumb = STORAGE_PATH . "campers/thumbs/" . $filename;

                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    if($file_ext!=="pdf"){
                        UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                        #For 120x80 Thumb   
                        UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);               
                    }
                    $insuranceFrontImg = $filename;
                }
            }
        }

        //upload child insurance back photo
        if(is_array($_FILES['insurance_card_back']) && trim($_FILES['insurance_card_back']['name'])!=='' && isset($_FILES['insurance_card_back']['error']) && trim($_FILES['insurance_card_back']['error'])=='0') {
            $insBackFile = $_FILES['insurance_card_back'];
            $file_name = $insBackFile['name'];
            $file_size = $insBackFile['size'];
            $file_tmp = $insBackFile['tmp_name'];
            $file_type = $insBackFile['type'];

            //check the file extension
            $file_ext = pathinfo($insBackFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions2 ) === false){
                $error[] = "Extension not allowed for file ".$file_name;
            }

            //check the file size
            if($file_size > 2097152){
                //$error[] = "File size for image ".$file_name." must be less than 2 MB";
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "campers/" . $filename;
                $httpRootSmall = STORAGE_PATH . "campers/small/" . $filename;
                $httpRootThumb = STORAGE_PATH . "campers/thumbs/" . $filename;

                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    if($file_ext!=="pdf"){
                        UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                        #For 120x80 Thumb   
                        UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);               
                    }
                    $insuranceBackImg = $filename;
                }
            }
        }

        //upload child immunization_record photo
        if(is_array($_FILES['immunization_record']) && trim($_FILES['immunization_record']['name'])!=='' && isset($_FILES['immunization_record']['error']) && trim($_FILES['immunization_record']['error'])=='0') {
            $insRecordFile = $_FILES['immunization_record'];
            $file_name = $insRecordFile['name'];
            $file_size = $insRecordFile['size'];
            $file_tmp = $insRecordFile['tmp_name'];
            $file_type = $insRecordFile['type'];

            //check the file extension
            $file_ext = pathinfo($insRecordFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions2 ) === false){
                $error[] = "Extension not allowed for file ".$file_name;
            }

            //check the file size
            if($file_size > 2097152){
                //$error[] = "File size for image ".$file_name." must be less than 2 MB";
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "campers/" . $filename;
                $httpRootSmall = STORAGE_PATH . "campers/small/" . $filename;
                $httpRootThumb = STORAGE_PATH . "campers/thumbs/" . $filename;

                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    if($file_ext!=="pdf"){
                        UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                        #For 120x80 Thumb   
                        UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);               
                    }
                    $insRecordFileImg = $filename;
                }
            }
        }

        if(isset($_POST['childId']) && $_POST['childId']!==""){
            $childArray = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                'gender' => $_POST['gender'],
                'email' => $_POST['email'],
                'is_ayfcamper' => $_POST['is_ayf_camper'],
                'ayf_junior_member' => $_POST['member_ayf_juniors'],
                'ayf_member' => $_POST['ayf_member'],
                'tshirt_size' => $_POST['tshirt_size'],
                'age' => $_POST['age'],
                'wear_protective_gear' => $_POST['wear_protective_gear'] ? $_POST['wear_protective_gear'] : '0',
                'under_supervision' => $_POST['under_supervision'] ? $_POST['under_supervision'] : '0',
                'foul_language' => $_POST['foul_language'] ? $_POST['foul_language'] : '0',
                'right_to_deny_access' => $_POST['right_to_deny_access'] ? $_POST['right_to_deny_access'] : '0',
                'modified' => $current_date
            );
            if($imageFile !== ""){
                $childArray['photo'] = $imageFile;
            }

            $updateChild = $globalManager->runUpdateQuery('childs', $childArray, "id='".$_POST['childId']."' AND user_id='".$userId."'");
            if($updateChild) {
                ############### UPDATE CHILD HEALTH INFO #################
                $arrHealth = array(
                    'physician_name' => $_POST['physician_name'],
                    'physician_phone' => $_POST['physician_phone'],
                    'insurance_carrier' => $_POST['insurance_carrier'],
                    'group_number' => $_POST['group_number'],
                    'agreement_number' => $_POST['agreement_number'],
                    'emergency_contact' => $_POST['emergency_contact'],
                    'emergency_phone' => $_POST['emergency_phone'],
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
                    'explanations' => $_POST['explanations'],
                    'medication_allergies' => $_POST['medication_allergies'],
                    'food_allergies' => $_POST['food_allergies'],
                    'other_allergies' => $_POST['other_allergies'],
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
                    'additional_information' => $_POST['additional_information']
                );

                if($insuranceFrontImg !== ""){
                    $arrHealth['insurance_card_front'] = $insuranceFrontImg;
                }
                if($insuranceBackImg !== ""){
                    $arrHealth['insurance_card_back'] = $insuranceBackImg;
                }
                if($insRecordFileImg !== ""){
                    $arrHealth['immunization_record'] = $insRecordFileImg;
                }

                $saveHealth = $globalManager->runUpdateQuery("child_health_info", $arrHealth, "child_id='".$_POST['childId']."'");


                //save medication history
                //prx($_POST);
                $delMedication = $globalManager->runDeleteQuery("child_medications", "child_id='".$_POST['childId']."'");
                if(is_array($_POST['medication_name']) && count($_POST['medication_name'])>0){
                    foreach($_POST['medication_name'] as $k=>$row){
                        $medicationArray = array(
                            'child_id' => $_POST['childId'],
                            'medication_name' => $_POST['medication_name'][$k],
                            'dosage' => $_POST['dosage'][$k],
                            'times_taken' => $_POST['times_taken'][$k]
                        );
                        $saveMedication = $globalManager->runInsertQuery("child_medications", $medicationArray);
                    }
                }
                
                $_SESSION['message'] = "Your child/camper has been updated.";
                redirect(USER_SITE_URL.'profile.php');
            }else{
                $_SESSION['errmsg'] = "Update failed. Your child/camper could not updated.";
            }

        }
    }
}

//find the details in case of edit
if(isset($_GET['id']) && $_GET['id']!==""){
    $getChild = $globalManager->runSelectQuery("childs", "*", "id='".$_GET['id']."'");
    //prx($getChild);
    if(is_array($getChild) && count($getChild)>0){
        extract($getChild[0]);
        //find out the child health info
        $getHealth = $globalManager->runSelectQuery("child_health_info", "*", "child_id='".$id."'");
        if(is_array($getHealth) && count($getHealth)>0){
            $healthInfo = $getHealth[0];
            if($healthInfo['insurance_card_front'] !== "" && file_exists(STORAGE_PATH.'campers/'.$healthInfo['insurance_card_front'])){
                $file_ext1 = pathinfo($healthInfo['insurance_card_front'], PATHINFO_EXTENSION);
                if($file_ext1 == "pdf"){
                    $insurance_card_front = STORAGE_HTTP_PATH.'campers/'.$healthInfo['insurance_card_front'];
                }else{
                    $insurance_card_front = STORAGE_HTTP_PATH.'campers/small/'.$healthInfo['insurance_card_front'];
                }
            }else{
                $insurance_card_front = IMG_PATH.'no-image.png';
            }
            if($healthInfo['insurance_card_back'] !== "" && file_exists(STORAGE_PATH.'campers/'.$healthInfo['insurance_card_back'])){
                $file_ext2 = pathinfo($healthInfo['insurance_card_back'], PATHINFO_EXTENSION);
                if($file_ext2 == "pdf"){
                    $insurance_card_back = STORAGE_HTTP_PATH.'campers/'.$healthInfo['insurance_card_back'];
                }else{
                    $insurance_card_back = STORAGE_HTTP_PATH.'campers/small/'.$healthInfo['insurance_card_back'];
                }
            }else{
                $insurance_card_back = IMG_PATH.'no-image.png';
            }
            if($healthInfo['immunization_record'] !== "" && file_exists(STORAGE_PATH.'campers/'.$healthInfo['immunization_record'])){
                $file_ext3 = pathinfo($healthInfo['immunization_record'], PATHINFO_EXTENSION);
                if($file_ext3 == "pdf"){
                    $immunization_record = STORAGE_HTTP_PATH.'campers/'.$healthInfo['immunization_record'];
                }else{
                    $immunization_record = STORAGE_HTTP_PATH.'campers/small/'.$healthInfo['immunization_record'];
                }
            }else{
                $immunization_record = IMG_PATH.'no-image.png';
            }
        }else{
            $healthInfo = array();
        }

        //find out the medication history
        $getMedHistory = $globalManager->runSelectQuery("child_medications", "*", "child_id='".$id."'");
    }else{
        $_SESSION['errmsg'] = "Invalid child.";
        redirect(USER_SITE_URL.'profile.php');
    }
}else{
    $_SESSION['errmsg'] = "Child not selected.";
    redirect(USER_SITE_URL.'profile.php');
}

//find out the parent details
$getParent = $globalManager->runSelectQuery("users", "email,first_name,last_name,phone,CONCAT(primary_address,' ',primary_address2) as address,city,state,zipcode", "id='".$userId."'");
//prx($getParent);
$parentInfo = $getParent[0];

//define array of month
$arrMonths = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
);

//find out the list of all the states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1'");