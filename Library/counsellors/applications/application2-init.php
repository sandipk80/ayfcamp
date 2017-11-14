<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "AYF Summer Camp Counsellor Application";

//find out logged in counsellor id
$counsellorId = $_SESSION['ayfcamp']['counsellor']['userid'];

$error = array();
if(isset($_POST) && trim($_POST['add-application'])=="submit"){
	//pr($_POST); prx($_FILES);
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

    if(is_array($_POST['date_of_birth_birth']) && count($_POST['date_of_birth_birth'])>0){
        $date_of_birth = $_POST['date_of_birth_birth']['year']."-".$_POST['date_of_birth_birth']['month']."-".$_POST['date_of_birth_birth']['day'];
        $date_of_birth = date("Y-m-d", strtotime($date_of_birth));
    }else{
        $error[] ="Please select your date of birth";
    }

    if (is_array($_POST['certificate']) && count($_POST['certificate']) > 0) {
        //$error[] = "Please select any certificate";
    }else{
        $strCertificates = implode(",",$_POST['last_name']);
    }

    if(empty($error)){
        $current_date = date("Y-m-d H:i:s");
        $imageFile = "";
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
            	$output_dir = STORAGE_PATH."counsellors/";
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                $normalDestination = STORAGE_PATH . "counsellors/" . $filename;
                $httpRootSmall = STORAGE_PATH . "counsellors/small/" . $filename;
                $httpRootThumb = STORAGE_PATH . "counsellors/thumbs/" . $filename;

                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                    #For 120x80 Thumb   
                    UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);               

                    $imageFile = $filename;
                }
            }
        }

        //upload gallery images
        $arrImgCertifications = array();
        if(is_array($_FILES['contribution_image']) && count($_FILES['contribution_image']) > 0){
            foreach($_FILES['contribution_image']['tmp_name']  as $key => $tmp_name ){
                if(trim($_FILES['contribution_image']['name'][$key])=='') {
                    continue;
                }
                $imgNumber = $key+1;
                $file_name = $_FILES['contribution_image']['name'][$key];
                $file_size = $_FILES['contribution_image']['size'][$key];
                $file_tmp = $_FILES['contribution_image']['tmp_name'][$key];
                $file_type = $_FILES['contribution_image']['type'][$key];

                //check the file extension
                $extensions = array("jpeg","jpg","png","bmp","gif");
                $file_ext = pathinfo($_FILES['contribution_image']['name'][$key], PATHINFO_EXTENSION);
                $file_ext = strtolower($file_ext);
                if(in_array($file_ext,$extensions ) === false){
                    $error[] = "Extension not allowed for file ".$imgNumber." (".$file_name.")";
                }

                //check the file size
                if($file_size > 2097152){
                    $error[] = "File size for image ".$imgNumber." (".$file_name.") must be less than 2 MB";
                }
                $created = date('Y-m-d H:i:s');

                if(empty($error)){
                    $output_dir = STORAGE_PATH."counsellors/";
                    $arrImgCertifications[$key] = UtilityManager::generateImageName(18).'.' . $file_ext;
                    if(move_uploaded_file($file_tmp, $output_dir.$arrImgGallery[$key])) {
                        $normalDestination = STORAGE_PATH . "counsellors/" . $arrImgGallery[$key];
                        $l++;
                    }
                }
            }
        }

        $applicationArray = array(
            'type' => '2',
        	'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'date_of_birth' => $date_of_birth,
            'apt_unit' => $_POST['apt_unit'],
            'address' => $_POST['address'],
            'city' => $_POST['city'],
            'state' => $_POST['state_id'],
            'zipcode' => $_POST['zipcode'],
            'phone' => $_POST['phone'],
            'phone2' => $_POST['phone2'],
            'tshirt_size' => $_POST['tshirt_size'],
            'ayf_member' => $_POST['ayf_member'],
            'emergency_contact1' => $_POST['emergency_contact1'],
            'emergency_contact2' => $_POST['emergency_contact2'],
            'emergency_contact3' => $_POST['emergency_contact3'],
            'certifications' => $strCertificates,
            'have_hospitalized' => $_POST['have_hospitalized'],
            'taking_medications' => $_POST['taking_medications'],
            'medical_conditions' => $_POST['medical_conditions'],
            'medical_condition_text' => $_POST['medical_condition_text'],
            'physician_details' => $_POST['physician_details'],
            'do_smoke' => $_POST['do_smoke'],
            'handle_smoking' => $_POST['handle_smoking'],
            'medical_condition_list' => $_POST['medical_condition_list'],
            'commited_crime' => $_POST['commited_crime'],
            'crime_explanations' => $_POST['crime_explanations'],
            'year' => $_POST['curr_year'],
    		'status' => '1',
    		'modified' => $current_date,
    		'created' => $current_date
        );

        if($imageFile !== ""){
        	$applicationArray['id_photo'] = $imageFile;
        }
        $saveApplication = $globalManager->runInsertQuery("counsellor_applications", $applicationArray);
        if($saveApplication){
        	$applicationId = $saveApplication;

        	//store selected camp weeks
        	if(is_array($_POST['camp_session_id']) && count($_POST['camp_session_id'])>0){
        		foreach($_POST['camp_session_id'] as $sesion){
        			$sessionArray = array(
        				'counsellor_id' => $counsellorId,
        				'application_id' => $applicationId,
        				'camp_session_id' => $sesion,
        				'is_alternate' => '0'
    				);
    				$saveSession = $globalManager->runInsertQuery("counsellor_preferred_weeks", $sessionArray);
        		}
        	}

        	//store alternate camp weeks
        	if(is_array($_POST['alt_camp_session_id']) && count($_POST['alt_camp_session_id'])>0){
        		foreach($_POST['alt_camp_session_id'] as $sesion){
        			$sessionArray = array(
        				'counsellor_id' => $counsellorId,
        				'application_id' => $applicationId,
        				'camp_session_id' => $sesion,
        				'is_alternate' => '1'
    				);
    				$saveSession = $globalManager->runInsertQuery("counsellor_preferred_weeks", $sessionArray);
        		}
        	}

        	

        	//store camp experience
        	if(is_array($_POST['camp_name']) && count($_POST['camp_name'])>0){
        		foreach($_POST['camp_name'] as $e=>$erow){
        			$expArray = array(
        				'counsellor_id' => $counsellorId,
        				'application_id' => $applicationId,
        				'camp_name' => $erow,
        				'dates' => $_POST['camp_dates'][$e],
        				'camp_locations' => $_POST['camp_locations'][$e],
        				'camper_or_staff' => $_POST['camper_or_staff'][$e]
    				);
    				$saveExp = $globalManager->runInsertQuery("counsellor_experiences", $expArray);
        		}
        	}

        	//save certification images
        	if(is_array($arrImgCertifications) && count($arrImgCertifications)>0){
        		foreach($arrImgCertifications as $img){
        			$imgArray = array(
        				'counsellor_id' => $counsellorId,
        				'application_id' => $applicationId,
        				'certificate_image' => $img,
    				);
    				$saveImage = $globalManager->runInsertQuery("counsellor_certifications", $imgArray);
        		}
        	}

        	################### SEND NOTIFICATION EMAIL ##########################
            $owner_email = $_POST['email'];
            $owner_name = $first_name;

            $message = 'Dear '.$owner_name;
            $message .= '<p>Thanks for applying for counsellor application!</p>';
            $message .= '<p>Your application has been submitted successfully.</p>';

            //include email template
            $template = file_get_contents(LIB_HTML.'user_email_template.php');
            //replace content
            $message = str_replace('{CONTENT_FOR_LAYOUT}', $message, $template);

            $phpmailer = new phpmailer();
            $phpmailer->SetLanguage("en", LIB_PATH. "PHPMailer/language/");
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->Priority = 1;
            $phpmailer->AddCustomHeader("X-MSMail-Priority: High");
            $phpmailer->AddCustomHeader("Importance: High");
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "smtp.gmail.com";
            $phpmailer->SMTPDebug  = 0;
            $phpmailer->Mailer = "smtp";
            $phpmailer->Port = 465;
            $phpmailer->Username = SUPPORT_EMAIL;
            $phpmailer->Password = SUPPORT_EMAIL_PASSWORD;
            $phpmailer->From = SUPPORT_EMAIL;
            $phpmailer->FromName = SUPPORT_EMAIL_USERNAME;

            $phpmailer->IsHTML(TRUE);
            $phpmailer->AddAddress($owner_email, $owner_name);
            $phpmailer->Body = $message;
            $phpmailer->MsgHTML = $message;
            $phpmailer->Subject = "Counsellor application | ".SITE_NAME;
            $sendmail = $phpmailer->send();

            ################### END SEND ACCOUNT ACTIVATION EMAIL ######################
            
            $_SESSION['message'] = "Thank you, your AYF Summer Camp Application has been submitted. An application submission does not ensure you a position in the AYF Summer Camp program. Please keep in mind that the Mandatory Counselor Orientation will be April 28-30, 2017 at AYF Camp.";
            redirect(COUNSELLOR_SITE_URL.'home.php');


        }

    }
}

//first find out the camp details
$currYear = date('Y');
$getCamp = $globalManager->runSelectQuery("camps", "*", "year='".$currYear."'");
if(is_array($getCamp) && count($getCamp)>0){
	$camp = $getCamp[0];
	//find out the camp sessions
	$getSessions = $globalManager->runSelectQuery("camp_sessions", "*", "camp_id='".$camp['id']."'");
	if(is_array($getSessions) && count($getSessions)>0){
		foreach($getSessions as $k=>$session){
			$camperLimit = $session['camper_limit'];
			$sessionEndDate = date("Y-m-d", strtotime($session['end_at']));
			$currentDate = date("Y-m-d");
			//find out the total registered campers for session
			$getCampers = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cmpr ON cmp.camp_registration_id=cmpr.id", "IFNULL(COUNT(cmp.id),0) as total", "cmp.camp_session_id='".$session['id']."' AND cmpr.status='1' AND cmpr.payment_status='SUCCESS'");

			$totalCampers = $getCampers[0]['total'];
			if($totalCampers >= $camperLimit){
				$getSessions[$k]['waitlist'] = '1';
			}else{
				$getSessions[$k]['waitlist'] = '0';
			}

			//check session duration
			if($currentDate >= $sessionEndDate){
				$getSessions[$k]['expire'] = '1';
			}else{
				$getSessions[$k]['expire'] = '0';
			}
		}
		$camp['sessions'] = $getSessions;
	}
}

//find out the list of all the states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "status='1'");

//find out the counsellor details
$arrCounsellor = $globalManager->runSelectQuery("counsellors", "*", "id='".$counsellorId."'");
$counsellor_email = $arrCounsellor[0]['email'];