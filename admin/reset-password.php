<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
include(LIB_HTML . 'header.php');

$showError="";
if(!isset($_REQUEST['cid'])) {
	$showError ="Link provided by you is not valid";
}

if(isset($_REQUEST['cid']) && trim($_REQUEST['cid'])=='') {
	$showError ="Link provided by you is not valid";
}
$result=array();
if(trim($showError)=='') {
	$condition = "unique_code='".$_REQUEST['cid']."'";
	$result = $globalManager->runSelectQuery("owners", "id,first_name,last_name,email", $condition);
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
		$where="id='".$result[0]['id']."'";
		$recordArray=array(
			'password'=>md5($_POST['password']),
			'unique_code'=>''
		);		
		$globalManager->runUpdateQuery('owners',$recordArray,$where);		
		$_SESSION['message']="Password updated successfully. Please login to continue.";
		redirect(OWNER_SITE_URL."index.php");				
	}	
}
?>
<style>
.container2_signup{float:none; height:250px;}
</style>
<div class="container_signup">
    <!-------------- FOR LOGIN ---------------->
    <div class="container2_signup">
        <div class="register_signup">
            <h2 class="h2_new"> Reset Password </h2>
        </div>
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
		}
		else {
	        include(LIB_HTML . 'message.php');?>
	        <?php
			if(is_array($error) && count($error)>0) {
			?>
				<div class="msg msg-error">
					<p><strong>
					<?php
					foreach($error as $key=>$val) {
						echo $val."<br />";
					}
					?></strong></p>
				</div>
			<?php
			}		
			?>
			
            <form action="" id="frmForgotPassword" name="frmForgotPassword" method="post" class="form-signin">
                <input type="password" name="password" id="password" placeholder="New Password" class="signupbox_signup">
                   
				<input type="password" name="repassword" id="repassword" placeholder="Confirm Password" class="signupbox_signup">
				<input type="hidden" name="reset-password" value="Submit" />
                <div class="button_sign_up">
	                <input class="border_button_chat float_right" title="Send" id="submit" type="submit" value="Submit">
	            </div>
            </form>
		<?php
		}
		?>
            
	</div>

</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#frmForgotPassword").validate({        
       rules: {        	        		
			password :"required",
			repassword:{
				equalTo: "#password"
		    }		
    	}
    });	
});
</script>

<?php include(LIB_HTML . 'footer.php');?>