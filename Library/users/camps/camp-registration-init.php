<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Summer Camp Registration";

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];

//find out the total childs added
$arrChilds = $globalManager->runSelectQuery("childs", "id,first_name,last_name", "user_id='".$userId."'");
if(is_array($arrChilds) && count($arrChilds)>0) {
	$firstCamper = $arrChilds[0]['id'];
}else{
	$_SESSION['errmsg'] = "You did not added any child in your profile. Please add atleast one child for camper registration.";
	redirect(USER_SITE_URL.'add-child.php');
}

if(isset($_POST) && trim($_POST['camp-register'])=="submit"){
	$total_campers = 0;
    $arrCampers = array();
    if(is_array($_POST['camper_id']) && count($_POST['camper_id'])>0){
        foreach($_POST['camper_id'] as $num=>$cmpRow){
            if($cmpRow !== "" && $cmpRow > 0){
                $arrCampers[$num]['camperId'] = $cmpRow;
                if(is_array($_POST['camp_session_id'][$num]) && count($_POST['camp_session_id'][$num])>0){
                    $arrCampers[$num]['weeks'] = $_POST['camp_session_id'][$num];
                    $total_campers++;
                }else{
                    $error[] = "Please select the week for all selected camper to register";
                }
                $arrCampers[$num]['bus_fare'] = $_POST['bus_fare'][$num];
            }
        }
    }else{
        $error[] = "Please select atleast one camper to register";
    }

    if(count($arrCampers) < 1){
        $error[] = "Please select atleast one camper to register";
    }
    
    if(empty($error)){
    	$curr_date = date("Y-m-d H:i:s");
        $registerCode = $registrationId.UtilityManager::generateUniqueKey(20,4).rand();
        $stepCode = UtilityManager::encrypt($registerCode);

        //check out the coupon code
        if(isset($_POST['coupon']) && trim($_POST['coupon'])!==""){
            $getCoupon = $globalManager->runSelectQuery("coupons", "*", "coupon='".trim($_POST['coupon'])."' AND status='1' AND DATE(expiry_date)>=CURDATE()");
            if(is_array($getCoupon) && count($getCoupon)>0){
                $coupon = $getCoupon[0];
                $coupon_id = $coupon['id'];
                $discount_type = $coupon['discount_type'];
                $discount = $coupon['discount'];
                if($discount_type == "percent"){
                    $total_discount = ($_POST['total_amount']*$discount)/100;
                    $total_payable = $_POST['total_amount']-$total_discount;
                }else{
                    $total_payable = $_POST['total_amount']-$discount;
                }
            }
        }else{
            $coupon_id = "0";
            $total_discount = "0";
            $total_payable = $_POST['total_amount'];
        }

    	$campArray = array(
    		'user_id' => $userId,
    		'camp_id' => $_POST['camp_id'],
    		'total_campers' => count($_POST['camper_id']),
    		'total_amount' => $_POST['total_amount'],
            'coupon_id' => $coupon_id,
            'coupon_discount' => $total_discount,
            'total_payable' => $total_payable,
            'code' => $registerCode,
    		'status' => '0',
    		'payment_status' => 'Pending',
    		'modified' => $curr_date,
    		'created' => $curr_date
		);



		$saveRegistration = $globalManager->runInsertQuery("camp_registrations", $campArray);
		if($saveRegistration){
			$registrationId = $saveRegistration;

            //deactivate coupon if selected
            if($coupon_id !== "0"){
                $carray = array('status'=>'0');
                $updateCoupon = $globalManager->runUpdateQuery("coupons", $carray, "id='".$coupon_id."'");
            }

            //save selected camper
            if(is_array($arrCampers) && count($arrCampers)){
                foreach($arrCampers as $ck=>$cpRow){
                    if(is_array($cpRow['weeks']) && count($cpRow['weeks'])>0){
                        foreach($cpRow['weeks'] as $h=>$wRow){
                            //find out the total registered campers for session
                            $getCampers = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cmpr ON cmp.camp_registration_id=cmpr.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id", "IFNULL(COUNT(cmp.id),0) as total,cps.camper_limit", "cmp.camp_session_id='".$wRow."' AND cmpr.status='1' AND cmpr.payment_status='SUCCESS'");
                            if($getCampers[0]['total'] >= $getCampers[0]['camper_limit']){
                                $waitlist = "1";
                            }else{
                                $waitlist = "0";
                            }

                            $camperArray = array(
                                'user_id' => $userId,
                                'child_id' => $cpRow['camperId'],
                                'camp_id' => $_POST['camp_id'],
                                'camp_session_id' => $wRow,
                                'camp_registration_id' => $registrationId,
                                'bus_opt' => $cpRow['bus_fare'][$h],
                                'snack_shop_amount' => $_POST['snack_shop_amount'][$ck],
                                'waitlist' => $waitlist,
                                'code' => $registerCode,
                                'status' => '0',
                                'created' => $curr_date
                            );
                            $saveCamper = $globalManager->runInsertQuery("campers", $camperArray);
                        }

                        //save snack shop amount
                        if($_POST['snack_shop_amount'][$ck] !== '0' && $_POST['snack_shop_amount'][$ck] > 0){
                            $snackshopArray = array(
                                'camper_id' => $cpRow['camperId'],
                                'camp_registration_id' => $registrationId,
                                'amount' => $_POST['snack_shop_amount'][$ck]
                            );
                            $saveShop = $globalManager->runInsertQuery("snackshop", $snackshopArray);
                        }
                    }
                }
            }
            $regCode = UtilityManager::decrypt(trim($_GET['q']));
            //$_SESSION['message'] = "You will be charged $".$_POST['total_amount']." after submission";
            //redirect(USER_SITE_URL.'registration-payment.php?q='.$stepCode);
            redirect(USER_SITE_URL.'checkout.php?q='.$stepCode);
		}else{
			$_SESSION['errmsg'] = "Registration failed. Please try again.";
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

//find out the parent details
$getParent = $globalManager->runSelectQuery("users", "email,first_name,last_name,phone,address,city,state_id,zipcode", "id='".$userId."'");
$parentInfo = $getParent[0];

//find out the list of all the bus fares
$arrBusFares = $globalManager->runSelectQuery("bus_fares", "id,name,waitlist,amount", "1=1");
//prx($arrBusFares);