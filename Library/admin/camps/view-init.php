<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Camp Details";

if(isset($_GET['id']) && trim($_GET['id'])!==""){
	$campId = trim($_GET['id']);

	//find out the camp details
	$getCamp = $globalManager->runSelectQuery("camps", "*", "id='".$campId."'");
	if(is_array($getCamp) && count($getCamp)>0){
		$camp = $getCamp[0];
		//find out the camp sessions
		$getSessions = $globalManager->runSelectQuery("camp_sessions", "*", "camp_id='".$campId."'");
		if(is_array($getSessions) && count($getSessions)>0){
			$camp['sessions'] = $getSessions;
			foreach($getSessions as $k=>$session){

			}
		}
	}
}