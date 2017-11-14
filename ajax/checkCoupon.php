<?php
include('../cnf.php');

require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//define advertiser id
$userId = $_SESSION['ayfcamp']['user']['userid'];

if(isset($_REQUEST['c']) && trim($_REQUEST['c'])!==""){
	$getCoupon = $globalManager->runSelectQuery("coupons", "*", "coupon='".trim($_REQUEST['c'])."' AND status='1'");
	if(is_array($getCoupon) && count($getCoupon)>0){
		$coupon = $getCoupon[0];
		$curr_date = date("Y-m-d");
		if($coupon['expiry_date'] < $curr_date){
			$arr = array('status'=>'error', 'message'=>'Coupon code has expired');
			echo json_encode($arr);
			exit;
		}else{
			$arr = array('status'=>'success', 'discount_type'=>$coupon['discount_type'], 'discount'=>$coupon['discount']);
			echo json_encode($arr);
			exit;
		}
	}else{
		$arr = array('status'=>'error', 'message'=>'Invalid Coupon');
		echo json_encode($arr);
		exit;
	}
}else{
	$arr = array('status'=>'error', 'message'=>'Invalid Coupon');
	echo json_encode($arr);
	exit;
}