<?php
include('cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$showError = "";
if(!isset($_REQUEST['cid'])) {
	$showError = "Link provided by you is not valid";
}

if(isset($_REQUEST['cid']) && trim($_REQUEST['cid'])=='') {
	$showError = "Link provided by you is not valid";
}
$result = array();

if(trim($showError) == '') {
	$condition = "pwd_reset_code='".$_REQUEST['cid']."'";
	$result = $globalManager->runSelectQuery("users", "id,first_name,last_name,email", $condition);
	if(is_array($result) && count($result)>0) {
		if(isset($_POST['reset-password']) && trim($_POST['reset-password'])=='Submit') {
		}
		else {
			$_SESSION['message']="Please enter a new password for this account.";
		}
	}
	else {
		$showError ="Link provided by you is not valid";
	}
}
if(isset($_POST['reset-password']) && trim($_POST['reset-password'])=='Submit') {
	if(isset($_POST['password']) && trim($_POST['password'])=='') {
		$error[] ="Password can not be left blank";
	}
	
	if(isset($_POST['repassword']) && trim($_POST['repassword'])=='') {
		$error[] ="Confirm password can not be left blank";
	}
	
	if(isset($_POST['password']) && trim($_POST['password'])!=='' && isset($_POST['repassword']) && trim($_POST['repassword'])!=='') {
		if(trim($_POST['password'])!==trim($_POST['repassword'])) {
			$error[] ="Please enter same re password as password";
		}
	}
	if(count($error)=='0') {
		$where = "id='".$result[0]['id']."'";
		$recordArray=array(
			'password' => md5($_POST['password']),
			'pwd_reset_code' => ''
		);		
		$globalManager->runUpdateQuery('users',$recordArray,$where);
		$_SESSION['message'] = "Password updated successfully. Please login to continue.";
		redirect(USER_SITE_URL."login.php");
	}	
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>AYF CAMP ‹ Log In</title>
    <!-- Bootstrap -->
    <link href="<?php echo CSS_SITE_URL;?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS_SITE_URL;?>login.css" rel="stylesheet">

    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-1.11.3.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-ui-1.10.1.custom.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>bootstrap.min.js"></script>
    <script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
    <meta content="noindex,follow" name="robots">
    <style type="text/css">
    .login * {
        margin: 0;
        padding: 0;
    }
    </style>
</head>
<body class="login login-action-login wp-core-ui locale-en-us">
<div id="login">
    <h1><a tabindex="-1" title="" href="http://www.ayfcamp.org">AYF CAMP</a></h1>
    <?php
	if(trim($showError)!=='') {
	?>
		<div class="msg msg-error">
			<p><strong>
			<?php
			echo $showError;
			?></strong></p>
		</div>
	<?php
	}else {
	    if(is_array($error) && count($error)>0) {
	        ?>
	        <!-- our error container -->
	        <div class="error-container" style="display:block;">
	            <ol>
	                <?php
	                foreach($error as $key=>$val) {
	                    ?>
	                    <li>
	                        <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
	                    </li>
	                    <?php
	                }
	                ?>
	            </ol>
	        </div>
	        <?php
	    }
	    include(LIB_HTML.'message.php');
    ?>
    <form id="loginform" name="loginform" method="post" action="" role="form">
    	<p>
	        <label for="password">New Password</label>
	        <input type="password" size="20" value="" class="input" id="password" name="password">
	    </p>
	    <p>
			<label for="repassword">Confirm Password</label>
			<input type="password" size="20" class="input" name="repassword" id="repassword">
		</p>
		<p class="submit">
	        <input type="hidden" name="reset-password" value="Submit" />
	        <input type="submit" value="Log In" class="button button-primary button-large" id="submit" name="submit">
	        <button type="button" class="button button-primary button-large" style="margin:0 10px;" onclick="location.href='<?php echo USER_SITE_URL;?>'">Back</button>
	    </p>
    </form>
    <?php
	}
	?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#loginform").validate({
       rules: {        	        		
			password :"required",
			repassword:{
				equalTo: "#password"
		    }		
    	}
    });	
});
</script>
</body>
</html>