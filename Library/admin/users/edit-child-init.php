<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$pageTitle = "Edit Child";

//signup submit
$error = array();
$output_dir = STORAGE_PATH."campers/";
if(isset($_POST['add-camper']) && trim($_POST['add-camper'])=='submit') {
    if (isset($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $error[] = "Please enter the first name";
    }else{
        $first_name = trim($_POST['first_name']);
    }

    if (isset($_POST['last_name']) && trim($_POST['last_name']) == '') {
        $error[] = "Please enter the last name";
    }else{
        $last_name = trim($_POST['last_name']);
    }

    if(is_array($_POST['date_of_birth_birth']) && count($_POST['date_of_birth_birth'])>0){
        $date_of_birth = $_POST['date_of_birth_birth']['year']."-".$_POST['date_of_birth_birth']['month']."-".$_POST['date_of_birth_birth']['day'];
        $date_of_birth = date("Y-m-d", strtotime($date_of_birth));
    }else{
        $error[] ="Please select the date of birth";
    }
    $patientId = $_POST['patient_id'];
    if(empty($error)){
        $current_date = date("Y-m-d H:i:s");
        $imageFile = "";
        $insuranceFrontImg = "";
        $insuranceBackImg = "";
        $extensions = array("jpeg","jpg","png","bmp","gif");

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

                    $insuranceBackImg = $filename;
                }
            }
        }

        $childId = $_GET['id'];
        $childArray = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'date_of_birth' => $date_of_birth,
            'is_ayfcamper' => $_POST['is_ayf_camper'],
            'ayf_junior_member' => $_POST['member_ayf_juniors'],
            'ayf_member' => $_POST['ayf_member'],
            'tshirt_size' => $_POST['tshirt_size'],
            'modified' => $current_date
        );
        if($imageFile !== ""){
            $childArray['photo'] = $imageFile;
        }
        $saveChild = $globalManager->runUpdateQuery('childs', $childArray, "id='".$childId."'");
        if($saveChild) {
            ############### SAVE CHILD HEALTH INFO #################
            $arrHealth = array(
                'child_id' => $childId,
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
                'tetanus_vacination_date' => $_POST['tetanus_vacination_date'] !== "" ? date("Y-m-d", strtotime($_POST['tetanus_vacination_date'])) : '',
                'medication_allergies' => $_POST['medication_allergies'],
                'food_allergies' => $_POST['food_allergies'],
                'other_allergies' => $_POST['other_allergies']
            );
            if($insuranceFrontImg !== ""){
                $arrHealth['insurance_card_front'] = $arrHealth;
            }
            if($insuranceBackImg !== ""){
                $arrHealth['insurance_card_back'] = $arrHealth;
            }

            $saveHealth = $globalManager->runUpdateQuery("child_health_info", $arrHealth, "child_id='".$childId."'");

            //save medication history
            if(is_array($_POST['medication_name']) && count($_POST['medication_name'])>0){
                //delete earlier medication info
                $deleteMedications = $globalManager->runDeleteQuery("child_medications", "child_id='".$childId."'");
                foreach($_POST['medication_name'] as $k=>$row){
                    $medicationArray = array(
                        'child_id' => $childId,
                        'medication_name' => $_POST['medication_name'],
                        'dosage' => $_POST['dosage'],
                        'times_taken' => $_POST['times_taken']
                    );
                    $saveMedication = $globalManager->runInsertQuery("child_medications", $medicationArray);
                }
            }

            //find out the total camper
            $_SESSION['message'] = "Child/camper has been updated.";
            redirect(ADMIN_SITE_URL.'user.php?id='.$patientId);
        } else {
            $_SESSION['errmsg'] = "Submission failed! Please try again";
        }
    }
}

//find the details in case of edit
if(isset($_GET['id']) && $_GET['id']!==""){
    $childId = $_GET['id'];
    $getChild = $globalManager->runSelectQuery("childs", "*", "id='".$childId."'");
    if(is_array($getChild) && count($getChild)>0){
        //find out the other details of child
        $getChildDetails = $globalManager->runSelectQuery("child_health_info", "*", "child_id='".$childId."'");
        if(is_array($getChildDetails) && count($getChildDetails)>0){
            $childInfo = array_merge($getChild[0],$getChildDetails[0]);
        }else{
            $childInfo = $getChild[0];
        }
        extract($childInfo);

        //find out the child medication list
        $arrMedications = $globalManager->runSelectQuery("child_medications", "medication_name,dosage,times_taken", "child_id='".$childId."'");

        //find out the parent details
        $getParent = $globalManager->runSelectQuery("users", "email,first_name,last_name,phone,address,city,state_id,zipcode", "id='".$getChild[0]['user_id']."'");
        $parentInfo = $getParent[0];

    }else{
        $_SESSION['errmsg'] = "Invalid child.";
    }
}



//find out the list of all the states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1'");