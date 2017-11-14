<?php
include('../cnf.php');
##-----------CHECK ADMIN LOGIN START---------------##
validateAdminLogin();
##-----------CHECK ADMIN LOGIN END---------------##
include(LIB_PATH . 'admin/camps/add-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>

<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>camps.php">Camps</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <?php
                if(is_array($error) && count($error)>0) {
                ?>
                <!-- our error container -->
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>Oh snap! You got an error!</h4>
                <?php
                foreach($error as $key=>$val) {
                ?>
                <p><label class="error" for="<?php echo $key;?>"><?php echo $val;?></label></p>
                <?php
                    }
                }
                ?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>

                        <div class="panel-body">
							<form method="post" action="" name="frmAddCamp" id="frmAddCamp" class="form-horizontal form-border" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control width80p" name="title" placeholder="Camp Title" id="title" value="<?php echo $title; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Intro Text</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="intro_text" placeholder="Camp Intro Text" id="intro_text" value="<?php echo $intro_text; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Total Sessions</label>
                                    <div class="col-sm-10">
                                        <select class="form-control width80p" name="total_sessions" id="total_sessions">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10" selected="selected">10</option>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                for($i=0; $i<10; $i++){
                                    $k = $i+1;
                                ?>
                                <div id="session<?php echo $k;?>">
                                    <div class="form-group margin20"><h3 class="rowHeader">SESSION <?php echo $k;?></h3></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control width80p" name="session_title[]" placeholder="" id="session_title<?php echo $k;?>" value="<?php echo isset($arrSessions[$i]['title']) ? $arrSessions[$i]['title'] : '';?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Start From</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control width80p start_from" name="start_from[]" placeholder="" id="start_from<?php echo $k;?>" value="<?php echo isset($arrSessions[$i]['start_from']) ? date('m/d/Y', strtotime($arrSessions[$i]['start_from'])) : '';?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">End At</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control width80p end_at" name="end_at[]" placeholder="" id="end_at<?php echo $k;?>" value="<?php echo isset($arrSessions[$i]['end_at']) ? date('m/d/Y', strtotime($arrSessions[$i]['end_at'])) : '';?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Rate</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="rate[]" placeholder="" id="rate<?php echo $k;?>" value="<?php echo isset($arrSessions[$i]['rate']) ? $arrSessions[$i]['rate'] : '';?>">
                                        </div>
                                        <label class="col-sm-2 control-label">Limit</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="camper_limit[]" placeholder="" id="camper_limit<?php echo $k;?>" value="<?php echo isset($arrSessions[$i]['camper_limit']) ? $arrSessions[$i]['camper_limit'] : '';?>">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>

                                <div class="form-group btn-row">
                                    <input type="hidden" name="cid" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="add-camp" value="submit" />
									<input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
							</form>
						</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<script type="text/javascript">
$(function() {
    $(".start_from,.end_at").datetimepicker({
        defaultDate: "+1d",
        changeMonth: true,
        numberOfMonths: 1,
        format: "m/d/Y",
        timepicker:false,
        scrollInput: false,
        onClose: function() {
            this.focus();this.blur();
        }
    });
});
$(document).on("change", "#total_sessions", function (e) {
    var sessions = $(this).val();
    if(sessions=='' || sessions==null || sessions < 1) {
        alert("Session must be greater than 0");
        return false;
    }
    for(i=1; i<6; i++){
        if(i>sessions){
            $("#session"+i).hide();
        }else{
            $("#session"+i).show();
        }
    }
});

$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#campsPage").addClass("active");

	$("#frmAddCamp").validate({
		rules: {
            title: "required",
            intro_text: "required"
		}
    });
	$(document).on('click', '#btnCancel', function (e){
		window.location.href = "camps.php";
	});
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>