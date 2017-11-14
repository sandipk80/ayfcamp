<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$userId = $_SESSION['ayfcamp']['user']['userid'];
$amount = 0;
if(isset($_POST) && count($_POST)>0) {
	$total_campers = count($_POST['camper_id']);
    $arrCampers = array();
    if(is_array($_POST['camper_id']) && count($_POST['camper_id'])>0){
    	$camperCount = 0;
        foreach($_POST['camper_id'] as $num=>$cmpRow){
            if($cmpRow !== ""){
            	$camperId = $cmpRow;
	            if(is_array($_POST['camp_session_id'][$num]) && count($_POST['camp_session_id'][$num])>0){
	            	foreach($_POST['camp_session_id'][$num] as $w=>$week){
	            		//find out the price of selected week
	            		$weekId = $week;
	            		$getRate = $globalManager->runSelectQuery("camp_sessions", "rate", "id='".$weekId."'");
		            	if(is_array($getRate) && count($getRate)>0){
		            		$amount = $amount+$getRate[0]['rate'];
		            		if($camperCount > 0){
		            			$amount = $amount-50;
		            		}
		            	}

		            	//Add selected bus fare
			            $busopt = $_POST['bus_fare'][$num][$w];

			            //find out the fee for selected bus fare
			            $getBusFare = $globalManager->runSelectQuery("bus_fares", "name,waitlist,amount", "id='".$busopt."'");
			            if(is_array($getBusFare) && count($getBusFare)>0){
			            	if($getBusFare[0]['waitlist']=="1"){
			            		$charge = 0;
			            	}else{
			            		$charge = $getBusFare[0]['amount'];
			            	}
			            }
			            $amount = $amount+$charge;
	            	}
	            	if(count($_POST['camp_session_id'][$num])>1){
	            		$amount = $amount-50;
	            	}
	            	$camperCount++;

		            
				}
	            //add selected snack shop amount
	            /*$snackshop_opt = $_POST['snack_shop'][$num];
	            if($snackshop_opt == "1"){
		            $snackshop_amount = $_POST['snack_shop_amount'][$num];
		            if($snackshop_amount !== "" && $snackshop_amount>0){
		            	$amount = $amount+$snackshop_amount;
		            }
	            }*/
	            $snackshop_amount = $_POST['snack_shop_amount'][$num];
	            if($snackshop_amount !== "" && $snackshop_amount>0){
	            	$amount = $amount+$snackshop_amount;
	            }
            }
        }
        if($camperCount>1){
        	//$amount = $amount-50;
        }
    }

    echo $amount;
}