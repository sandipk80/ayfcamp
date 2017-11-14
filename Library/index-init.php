<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out the list of doctors
$arrDoctors = $globalManager->runSelectQuery("doctors as d LEFT JOIN categories as cat ON d.category_id=cat.id LEFT JOIN services as sv ON d.service_id=sv.id", "d.id,CONCAT(d.first_name,' ',d.last_name) as name,d.picture,d.intro_text,d.category_id as catid,cat.name as catname,d.service_id as servid,sv.name as servname", "d.status='1' ORDER BY d.id DESC");
?>