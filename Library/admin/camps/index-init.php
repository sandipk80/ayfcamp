<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Camps";

$pWhere = "1=1";
$relTable = "camps";
$relFields = "id,title,total_sessions,year,created";
$result = $globalManager->runSelectQuery($relTable,$relFields,$pWhere);