<?php
include('../../cnf.php');

require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

/* Array of database columns which should be read and sent back to DataTables. Use a space where
 * you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array('week_title', 'parent_name', 'child_name', 'reg_date');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "cmp.created";

/* DB table to use */
$sTable = "campers as cmp LEFT JOIN childs as cld ON cmp.child_id=cld.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN camps as cp ON cmp.camp_id=cp.id LEFT JOIN users as u ON cmp.user_id=u.id";
	
/* 
 * Paging
 */
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
	$sLimit = "LIMIT ".addslashes( $_GET['iDisplayStart'] ).", ".
        addslashes( $_GET['iDisplayLength'] );
}
	
/*
 * Ordering
 */
if (isset($_GET['iSortCol_0'])){
	$sOrder = "ORDER BY  ";
	for ($i=0; $i<intval($_GET['iSortingCols']); $i++){
		if ($_GET['bSortable_'.intval($_GET['iSortCol_'.$i])] == "true"){
			$sOrder .= $aColumns[ intval($_GET['iSortCol_'.$i])]."
				".addslashes( $_GET['sSortDir_'.$i] ) .", ";
		}
	}
	
	$sOrder = substr_replace($sOrder, "", -2);
	if($sOrder == "ORDER BY"){
		$sOrder = "";
	}
}

/* 
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = "cp.status='1' AND cmp.waitlist='1'";
if ($_GET['sSearch'] != ""){
	$flArray = array(
		'0' => 'week_title',
		'1' => 'parent_name',
		'2' => 'child_name'
	);
	$sWhere = " (";
	for ($i=0; $i<count($aColumns); $i++){
		$sWhere .= $flArray[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
	}
	$sWhere = substr_replace( $sWhere, "", -3 );
	$sWhere .= ')';
}
	
/* Individual column filtering */
for ($i=0; $i<count($aColumns); $i++){
	if ($_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != ''){
		$sWhere .= " AND ";
		$sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
	}
}

/* Data set length after filtering */
$rResultFilterTotal = $globalManager->runSelectQuery($sTable, "COUNT(".$sIndexColumn.") as total", $sWhere);
$iFilteredTotal = $rResultFilterTotal[0]['total'];

	
/* Total data set length */
$rWhere = " cp.status='1' AND cmp.waitlist='1'";
$aResultTotal = $globalManager->runSelectQuery($sTable, "COUNT(".$sIndexColumn.") as total", $rWhere);
$iTotal = $aResultTotal[0]['total'];
	
/*
 * Output
 */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $iTotal,
	"iTotalDisplayRecords" => $iFilteredTotal,
	"aaData" => array()
);

/*
 * SQL queries
 * Get data to display
 */
$dWhere = $sWhere.' '.$sOrder.' '.$sLimit;
$dTables = "campers as cmp LEFT JOIN childs as cld ON cmp.child_id=cld.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN camps as cp ON cmp.camp_id=cp.id LEFT JOIN users as u ON cmp.user_id=u.id";
$arrResult = $globalManager->runSelectQuery($dTables,'SQL_CALC_FOUND_ROWS cps.title as week_title,CONCAT(u.first_name," ",u.last_name) as parent_name,CONCAT(cld.first_name," ",cld.last_name) as child_name,cmp.created as reg_date',$dWhere);

if(is_array($arrResult) && count($arrResult)>0){
	foreach($arrResult as $aRow){
		$row = array();
		for($i=0; $i<count($aColumns); $i++){
			if ($aColumns[$i] == "version"){
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[$aColumns[$i]]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] == "reg_date" ){
				$row[] = date("m/d/Y", strtotime($aRow[$aColumns[$i]]));
			}
			else{
				/* General output */
				$row[] = $aRow[$aColumns[$i]];
			}
		}
		array_walk_recursive($row, function (&$value) {
			if (strpos($a,'<img') !== false) {
				$value = utf8_encode($value);
			}
		});
		$output['aaData'][] = $row;
	}
}
//echo '<pre>';print_r($output);die;
echo json_encode($output);
?>