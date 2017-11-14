<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Voucher";
}else{
    $pageTitle = "Add Voucher";
}
$error = array();

if(isset($_POST) && isset($_POST['add-coupon']) && trim($_POST['add-coupon'])=='submit') {
    extract($_POST);
    if(isset($_POST['coupon']) && trim($_POST['coupon'])=='') {
        $error[] = 'Voucher text is required';
    }else{
        $coupon = trim($_POST['coupon']);
    }
    if(isset($_POST['discount_type']) && trim($_POST['discount_type'])=='') {
        $error[] = 'Voucher discount type is required';
    }else{
        $discount_type = trim($_POST['discount_type']);
    }
    if(isset($_POST['discount']) && trim($_POST['discount'])=='') {
        $error[] = 'Voucher discount is required';
    }else{
        $discount = trim($_POST['discount']);
    }
    if(isset($_POST['expiry_date']) && trim($_POST['expiry_date'])=='') {
        $error[] = 'Voucher expiry date is required';
    }else{
        $expiry_date = trim($_POST['expiry_date']);
    }
    if(empty($error)) {
        if(isset($_POST['cid']) && trim($_POST['cid'])!=='') {
            $couponId = $_POST['cid'];
            $where = "id='".$couponId."'";
            $dataArray = array(
                'coupon' => $_POST['coupon'],
                'discount_type' => $_POST['discount_type'],
                'discount' => $_POST['discount'],
                'expiry_date' => date("Y-m-d", strtotime($_POST['expiry_date']))
            );
            $update = $globalManager->runUpdateQuery('coupons',$dataArray,$where);
            if($update){
                $_SESSION['message'] ="Coupon has been updated successfully.";
                redirect(ADMIN_SITE_URL."coupons.php");
            }else{
                $_SESSION['errmsg'] = "Update failed. Please try again.";
            }
            
        }else{
            $dataArray = array(
                'coupon' => $_POST['coupon'],
                'discount_type' => $_POST['discount_type'],
                'discount' => $_POST['discount'],
                'expiry_date' => date("Y-m-d", strtotime($_POST['expiry_date'])),
                'status' => '1',
                'created' => date("Y-m-d H:i:s")
            );
            $saveData = $globalManager->runInsertQuery('coupons',$dataArray);
            if($saveData){
                $_SESSION['message'] = "Coupon has been added.";
                redirect(ADMIN_SITE_URL."coupons.php");
            }else{
                $_SESSION['errmsg'] = "Coupon could not added. Please try again.";
            }

        }
        
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "coupons";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);
    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        extract($result[0]);
    }else{
        $_SESSION['errmsg'] = "Invalid coupon selected! Please select valid coupon to update";
        redirect(ADMIN_SITE_URL."coupons.php");
    }
}