<?php
include('../cnf.php');

require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//define advertiser id
$userId = $_SESSION['ayfcamp']['user']['userid'];

if(isset($_GET['n']) && $_GET['n']!==""){
	$num = (int)$_GET['n'];
	$numCamper = $num+1;
	//find out the childs
	$arrChilds = $globalManager->runSelectQuery("childs", "id,first_name,last_name", "user_id='".$userId."'");
	//prx($arrChilds);
	if(is_array($arrChilds) && count($arrChilds)>0) {
		$firstCamper = $arrChilds[0]['id'];
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
}
//find out the list of all the bus fares
$arrBusFares = $globalManager->runSelectQuery("bus_fares", "id,name,waitlist,amount", "1=1");
?>
<div class="camp-block">
    <div class="col-md-6 topmarg20">
        <div class="form-group">
            <label>Select Camper <?php echo $numCamper;?></label>
            <select name="camper_id[<?php echo $num;?>]" class="form-control">
                <option value="">-- Select Camper --</option>
                <?php
                if(is_array($arrChilds) && count($arrChilds)>0){
                    foreach($arrChilds as $child){
                        echo '<option value="'.$child['id'].'">'.ucwords($child['first_name'].' '.$child['last_name']).'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-6 topmarg20">
        <div class="form-group cmpWeek">
            <label for="camp_session_id">Select Week(s) <span class="required">*</span></label>
            <select name="camp_session_id[<?php echo $num;?>][]" id="camp_session_id<?php echo $numCamper;?>" class="form-control ddcampsessions" multiple>
                <?php
                if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                    foreach($camp['sessions'] as $session){
                        $disable = "";
                        $dateRange = date("l F d, Y", strtotime($session['start_from'])).' to '.date("l F d, Y", strtotime($session['end_at']));
                        if($session['expire'] == "1"){
                            $disable = "disabled";
                        }elseif($session['waitlist'] == "1"){
                            //$style = "color:yellow;";
                        }
                        echo '<option value="'.$session['id'].'">'.$session['title'].' ('.$dateRange.')</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-12" id="optBus<?php echo $num;?>"></div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="snack_shop">Would you like to add funds to your child's snack shop account? No cash will be accepted at camp. </label>
            <select name="snack_shop_amount[]" id="snack_shop_amount<?php echo $numCamper;?>" rel="<?php echo $numCamper;?>" class="form-control snackshop_amount">
                <option value="">-- Select Option --</option>
                <option value="25">Yes, I would like to add $25 to my child's snack shop fee</option>
                <option value="0">No, I do not want my child to make any purchases from the snack shop.</option>
            </select>
        </div>
    </div>

    <!--div class="col-md-6" id="snackShopAmount<?php echo $numCamper;?>" style="display:none;">
        <div class="form-group has-success has-feedback">
            <label for="">Specify amount</label>
            <div class="col-sm-12">
                <span class="fa fa-usd form-control-feedback"></span>
                <input type="text" name="snack_shop_amount[]" id="snack_shop_amount<?php echo $numCamper;?>" rel="<?php echo $numCamper;?>" class="form-control snackshop_amount" value="0">
            </div>
        </div>
    </div-->
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function() {
	$('.ddcampsessions').multiselect({
        columns: 1,
        placeholder: 'Select Session'
    });

    $('.cmpWeek').on("change", ":checkbox", function () {
        var wid = $(this).val();
        var wtitle = $("#weektitle-"+wid).val();
        var bus_fares = '<?php echo json_encode($arrBusFares);?>';
        if($(this).attr('checked')){
            var bhtm = '<div class="col-md-12" id="busWeek<?php echo $num;?>'+wid+'"><div class="form-group"><label>Bus Fare for week '+wtitle+' </label><select name="bus_fare[<?php echo $num;?>][]" class="form-control busfare"><option value="">-- Select Bus Fare --</option><option value="0">None</option>'
            bus_fares = $.parseJSON(bus_fares);
            $.each(bus_fares, function(i) {
                if(bus_fares[i].waitlist == '1'){
                    bhtm += '<option value="'+bus_fares[i].id+'">'+bus_fares[i].name+' $'+bus_fares[i].amount+' - Waitlist Only</option>';
                }else{
                    bhtm += '<option value="'+bus_fares[i].id+'">'+bus_fares[i].name+' $'+bus_fares[i].amount+'</option>';
                }
            });
            bhtm += '</select></div></div>';
            //<option value="1">To Camp $15</option><option value="2">From Camp $15</option><option value="3">Round Trip $25</option><option value="4">To Camp $15 - WAITLIST ONLY</option><option value="5">From Camp $15 - WAITLIST ONLY</option><option value="6">Round Trip $25 - WAITLIST ONLY</option></select></div></div>';
            $("#optBus<?php echo $num;?>").append(bhtm);
        }else{
            $("#busWeek<?php echo $num;?>"+wid).remove();
        }

        $.ajax({
            url:'<?php echo AJAX_PATH;?>getCampPrice.php',
            type: "POST",
            data: $("#frmCampRegistration").serialize(),
            cache: false,
            dataType: "html",
            success:function(res){
                if(res){
                    $("#total_amount").val(res);
                }
                $(".loading").remove();
            }
        });
    });

    $(document).on('change', '.snack_shop', function() {
        var num = $(this).attr('id');
        num = num.replace('snack_shop', '');
        var snakshop_opt = $("#snack_shop"+num).val();
        if(snakshop_opt == "1"){
            $("#snackShopAmount"+num).show();
            $("snack_shop_amount"+num).val('0');
        }else{
            $("snack_shop_amount"+num).val('0');
            $("#snackShopAmount"+num).hide();
        }
    });

    $(".snackshop_amount").bind("change paste keyup", function() {
        $.ajax({
            url:'<?php echo AJAX_PATH;?>getCampPrice.php',
            type: "POST",
            data: $("#frmCampRegistration").serialize(),
            cache: false,
            dataType: "html",
            success:function(res){
                if(res){
                    $("#total_amount").val(res);
                }
                $(".loading").remove();
            }
        });
    });
});
</script>