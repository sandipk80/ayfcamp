<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
?>
<tr id="crow<?php echo $_GET['rid'];?>">
	<td colspan="10">
	<?php
	if(isset($_GET['rid']) && trim($_GET['rid'])!== ""){
		$rid = trim($_GET['rid']);
		//find out the selected camper details
		$getCamper = $globalManager->runSelectQuery("campers as cmp LEFT JOIN childs as cld ON cmp.child_id=cld.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN snackshop as sn ON cmp.camp_registration_id=sn.camp_registration_id LEFT JOIN bus_fares as bf ON cmp.bus_opt=bf.id", "cmp.child_id,CONCAT(cld.first_name,' ',cld.last_name) as childName,cps.title as campSession,cps.start_from,cps.end_at,bf.name as bus_fare,bf.amount as bus_amount,bf.waitlist as bus_waitlist", "cmp.camp_registration_id='".$rid."' GROUP BY cmp.id ORDER BY cmp.id ASC");
		if(is_array($getCamper) && count($getCamper)>0){
			$cid = "";
	?>

		<table class="table table-striped table-bordered" width="100%">
		<tr>
			<th>Camper</th>
			<th>Camp Session</th>
			<th>Snackshop Amount</th>
			<th>Bus Opt</th>
			<th>Start From</th>
			<th>End at</th>
		</tr>
	<?php
	$c = $pre_k = 0;
	foreach($getCamper as $k=>$value){
		$rowspan = 1;
		if($value['bus_fare'] !== ""){
			if($value['bus_waitlist'] == "1"){
				$busoption = $value['bus_fare']." $".$value['bus_amount'].' - Waitlist Only';
			}else{
				$busoption = $value['bus_fare']." $".$value['bus_amount'];
			}
		}
		//find out the snackshop amount
		$getSnackshopAmt = $globalManager->runSelectQuery("snackshop", "amount", "camper_id='".$value['child_id']."' AND camp_registration_id='".$rid."'");
		if(is_array($getSnackshopAmt) && count($getSnackshopAmt)>0){
			$amount = $getSnackshopAmt[0]['amount'];
		}else{
			$amount = 0;
		}
		$k2 = $k+1;
		$k3 = $k+2;
		$k4 = $k+3;
		$k5 = $k+4;
		if($k > 0){
			$pre_k = $k-1;
		}
		if($getCamper[$k2]['child_id'] && $getCamper[$k]['child_id'] == $getCamper[$k2]['child_id']){
			$rowspan = 2;
			$c = 2;
			if($getCamper[$k3]['child_id'] && $getCamper[$k2]['child_id'] == $getCamper[$k3]['child_id']){
				$rowspan = 3;
				if($getCamper[$k4]['child_id'] && $getCamper[$k3]['child_id'] == $getCamper[$k4]['child_id']){
					$rowspan = 4;
				}
			}
		}else{
			$c = 0;
		}
	?>
		<tr>
			<td rowspan2="<?php echo $rowspan;?>"><?php echo $value['childName'];?></td>
			<td><?php echo $value['campSession'];?></td>
			<td rowspan2="<?php echo $rowspan;?>">$<?php echo $amount;?></td>
			<td><?php echo $busoption;?></td>
			<td><?php echo date("l F d, Y", strtotime($value['start_from']));?></td>
			<td><?php echo date("l F d, Y", strtotime($value['end_at']));?></td>
			
		</tr>
	<?php
	}
	?>
	</table>
	<?php
	}else{
		echo 'No registration available';
	}
}else{
	echo 'No registration available';
}
?>
</td>
</tr>