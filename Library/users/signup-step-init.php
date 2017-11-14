<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//signup submit
$error = array();
if(isset($_POST['user-signup']) && trim($_POST['user-signup'])=='signup') {
    $error = array();
    if(empty($error)) {
        $userId = $_POST['uid'];
        $current_date = date("Y-m-d H:i:s");
        $infoArray = array(
            "user_id" => $userId,
            "is_dilated" => $_POST['is_dilated'],
            "dilated_date" => $_POST['dilated_date']!=="" ? date("Y-m-d", strtotime($_POST['dilated_date'])) : "0000-00-00",
            "is_medication_allergy" => $_POST['is_medication_allergy'],
            "medication_allergies" => $_POST['medication_allergies'],
            "taking_medication" => $_POST['taking_medication'],
            "medication_list" => $_POST['medication_list'],
            "is_pregnant_nursing" => $_POST['is_pregnant_nursing'],
            "pregnant_nursing_time" => $_POST['pregnant_nursing_time'],
            "have_eye_injury_surgery" => $_POST['have_eye_injury_surgery'],
            "wear_glass" => $_POST['wear_glass'],
            "wear_glass_per_week" => $_POST['wear_glass_per_week'],
            "wear_glass_start_date" => $_POST['wear_glass_start_date']!=="" ? date("Y-m-d", strtotime($_POST['wear_glass_start_date'])) : "0000-00-00",
            "wear_lense" => $_POST['wear_lense'],
            "wear_lense_per_week" => $_POST['wear_lense_per_week'],
            "lense_complication" => $_POST['lense_complication'],
            "sleep_with_lense" => $_POST['sleep_with_lense'],
            "continue_wear_lense_days" => $_POST['continue_wear_lense_days'],
            "work_type" => $_POST['work_type'],
            "is_drop_lense_reaction" => $_POST['is_drop_lense_reaction'],
            "drop_lense_reaction" => $_POST['drop_lense_reaction'],
            "use_computer" => $_POST['use_computer'],
            "computer_hours_per_day" => $_POST['computer_hours_per_day'],
            "do_extended_reading_work" => $_POST['do_extended_reading_work'],
            "close_work_type" => $_POST['close_work_type'],
            "is_eye_dry_gritty" => $_POST['is_eye_dry_gritty'],
            "eye_dry_gritty_scale" => $_POST['eye_dry_gritty_scale'],
            "experience_eye_problem" => $_POST['experience_eye_problem'],
            "eye_problem_type" => $_POST['eye_problem_type'],
            "driving_visual_difficulty" => $_POST['driving_visual_difficulty'],
            "bright_light_glare_problem" => $_POST['bright_light_glare_problem'],
            "experience_strained_tired_eyes" => $_POST['experience_strained_tired_eyes'],
            "hobbies_sports" => $_POST['hobbies_sports'],
            "is_blindness" => $_POST['is_blindness'],
            "blindness_from" => $_POST['blindness_from'],
            "is_cataract" => $_POST['is_cataract'],
            "cataract_from" => $_POST['cataract_from'],
            "is_crossed_eyes" => $_POST['is_crossed_eyes'],
            "crossed_eyes_from" => $_POST['crossed_eyes_from'],
            "is_glaucoma" => $_POST['is_glaucoma'],
            "glaucoma_from" => $_POST['glaucoma_from'],
            "is_macular_degeneration" => $_POST['is_macular_degeneration'],
            "macular_degeneration_from" => $_POST['macular_degeneration_from'],
            "is_retinal_detachment" => $_POST['is_retinal_detachment'],
            "retinal_detachment_from" => $_POST['retinal_detachment_from'],
            "is_diabetes" => $_POST['is_diabetes'],
            "diabetes_from" => $_POST['diabetes_from'],
            "is_heart_disease" => $_POST['is_heart_disease'],
            "heart_disease_from" => $_POST['heart_disease_from'],
            "is_high_blood_pressure" => $_POST['is_high_blood_pressure'],
            "high_blood_pressure_from" => $_POST['high_blood_pressure_from'],
            "is_cancer" => $_POST['is_cancer'],
            "cancer_from" => $_POST['cancer_from'],
            "is_thyroid_disease" => $_POST['is_thyroid_disease'],
            "thyroid_disease_from" => $_POST['thyroid_disease_from'],
            "is_vision_loss" => $_POST['is_vision_loss'],
            "is_blurred_vision" => $_POST['is_blurred_vision'],
            "is_distorted_vision" => $_POST['is_distorted_vision'],
            "is_side_vision_loss" => $_POST['is_side_vision_loss'],
            "is_double_vision" => $_POST['is_double_vision'],
            "is_burning" => $_POST['is_burning'],
            "is_redness" => $_POST['is_redness'],
            "is_itching" => $_POST['is_itching'],
            "is_excess_tearing_watering" => $_POST['is_excess_tearing_watering'],
            "is_dryness" => $_POST['is_dryness'],
            "is_sandy_gritty_feeling" => $_POST['is_sandy_gritty_feeling'],
            "is_mucous_discharge" => $_POST['is_mucous_discharge'],
            "is_eyepain_soreness" => $_POST['is_eyepain_soreness'],
            "is_vision_flashes" => $_POST['is_vision_flashes'],
            "headaches" => $_POST['headaches'],
            "migraines" => $_POST['migraines'],
            "seizures" => $_POST['seizures'],
            "heart_pain" => $_POST['heart_pain'],
            "sinus_congestion" => $_POST['sinus_congestion'],
            "dry_throat_mouth" => $_POST['dry_throat_mouth'],
            "chronic_cough" => $_POST['chronic_cough'],
            "asthma" => $_POST['asthma'],
            "chronic_bronchitis" => $_POST['chronic_bronchitis'],
            "emphysema" => $_POST['emphysema'],
            "rheumatoid_athritis" => $_POST['rheumatoid_athritis'],
            "joint_pain" => $_POST['joint_pain'],
            "anemia" => $_POST['anemia'],
            "bleeding_problem" => $_POST['bleeding_problem'],
            "skin" => $_POST['skin'],
            "genitals_kidney_bladder" => $_POST['genitals_kidney_bladder'],
            "psychiatric" => $_POST['psychiatric'],
            "thyroid_other_glands" => $_POST['thyroid_other_glands'],
            "explanations" => $_POST['explanations'],
            'modified' => $current_date
        );

        $saveInfo = $globalManager->runInsertQuery('user_informations', $infoArray);
        if($saveInfo) {
            //make active to user
            $userArray = array(
                'active' => '1',
                'code' => '',
                'modified' => date("Y-m-d H:i:s")
            );
            $updateUser = $globalManager->runUpdateQuery("users", $userArray, "id='".$userId."'");
            //find out the user details
            $arrUser = $globalManager->runSelectQuery("users", "CONCAT(firstname,' ',lastname) as name,email", "id='".$userId."'");

            //allow to login
            $_SESSION['moore']['user']['userid'] = $userId;
            $_SESSION['moore']['user']['email'] = $arrUser[0]['email'];
            $_SESSION['moore']['user']['name'] = ucwords($arrUser[0]['name']);

            $_SESSION['message'] = "Your medical information have been saved successfully. Your account is activated now.";
            redirect(USER_SITE_URL);
        } else {
            $_SESSION['errmsg'] = "Submission failed! Please try again";
        }
    }
}

//check for valid user registration code
$condition = "code='".$_GET['t']."'";
$arrUser = $globalManager->runSelectQuery("users", "id,firstname,lastname", $condition);
if(is_array($arrUser) && count($arrUser)>0){
    $userId = $arrUser[0]['id'];
}else{
    $_SESSION['errmsg'] = "Invalid code! Please signup again and complete the next step to complete the signup process";
    redirect(USER_SITE_URL."signup.php");
}