<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Camp";
}else{
    $pageTitle = "Add Camp";
}
$error = array();

if(isset($_POST) && isset($_POST['add-camp']) && trim($_POST['add-camp'])=='submit') {
    if(isset($_POST['title']) && trim($_POST['title'])=='') {
        $error[] = 'Camp title is required';
    }else{
        $title = trim($_POST['title']);
    }
    if(isset($_POST['intro_text']) && trim($_POST['intro_text'])=='') {
        $error[] = 'Camp intro text is required';
    }else{
        $intro_text = trim($_POST['intro_text']);
    }
    if(isset($_POST['total_sessions']) && trim($_POST['total_sessions'])=='') {
        $error[] = 'Total sessions of camp is required';
    }else{
        $total_sessions = trim($_POST['total_sessions']);
        for($i=0; $i<$total_sessions; $i++){
            $k = $i+1;
            if(isset($_POST['start_from'][$i]) && trim($_POST['start_from'][$i])=='') {
                $error[] = 'Start date for session '.$k.' is required';
            }else{
                $start_from[$i] = trim($_POST['start_from'][$i]);
            }
            if(isset($_POST['end_at'][$i]) && trim($_POST['end_at'][$i])=='') {
                $error[] = 'End date for session '.$k.' is required';
            }else{
                $end_at[$i] = trim($_POST['end_at'][$i]);
            }
            if(isset($_POST['rate'][$i]) && trim($_POST['rate'][$i])=='') {
                $error[] = 'Rate for session '.$k.' is required';
            }else{
                $rate[$i] = trim($_POST['rate'][$i]);
            }
            if(isset($_POST['camper_limit'][$i]) && trim($_POST['camper_limit'][$i])=='') {
                $error[] = 'Limit for session '.$k.' is required';
            }else{
                $camper_limit[$i] = trim($_POST['camper_limit'][$i]);
            }
        }
    }

    if(empty($error)){
        if(isset($_POST['cid']) && trim($_POST['cid'])!=='') {
            $campId = $_POST['cid'];
            $where = "id='".$campId."'";
            $campArray = array(
                'title' => $_POST['title'],
                'intro_text' => $_POST['intro_text']
            );

            $saveCamp = $globalManager->runUpdateQuery('camps',$campArray,$where);
            if($saveCamp){
                //update sessions data
                $getSessions = $globalManager->runSelectQuery("camp_sessions", "id", "camp_id='".$campId."'");
                if(is_array($getSessions) && count($getSessions)>0){
                    $i = 0;
                    foreach($getSessions as $session){
                        $sessionArray = array(
                            'title' => $_POST['session_title'][$i],
                            'start_from' => date("Y-m-d", strtotime($_POST['start_from'][$i])),
                            'end_at' => date("Y-m-d", strtotime($_POST['end_at'][$i])),
                            'rate' => $_POST['rate'][$i],
                            'camper_limit' => $_POST['camper_limit'][$i],
                        );
                        $i++;
                        $saveSession = $globalManager->runUpdateQuery("camp_sessions", $sessionArray, "id='".$session['id']."' AND camp_id='".$campId."'");
                    }
                }
                $_SESSION['message'] ="Camp has been updated successfully.";
                redirect(ADMIN_SITE_URL."camps.php");
            }else{
                $_SESSION['errmsg'] = "Update failed. Please try again.";
                redirect(ADMIN_SITE_URL."camps.php");
            }
        }else{
            //add new camp
            $campArray = array(
                'title' => $title,
                'intro_text' => $intro_text,
                'total_sessions' => $total_sessions,
                'year' => date("Y"),
                'created' => date("Y-m-d H:i:s")
            );
            $addCamp = $globalManager->runInsertQuery('camps',$campArray);
            if($addCamp){
                //find out the menu id
                $campId = $addCamp;

                //save sessions details of camp
                for($i=0; $i<$total_sessions; $i++){
                    $sessionArray = array(
                        'camp_id' => $campId,
                        'title' => $_POST['session_title'][$i],
                        'start_from' => date("Y-m-d", strtotime($_POST['start_from'][$i])),
                        'end_at' => date("Y-m-d", strtotime($_POST['end_at'][$i])),
                        'rate' => $_POST['rate'][$i],
                        'camper_limit' => $_POST['camper_limit'][$i],
                    );
                    
                    $saveSession = $globalManager->runInsertQuery("camp_sessions", $sessionArray);
                }
                $_SESSION['message'] = "Camp has been created.";
                redirect(ADMIN_SITE_URL."camps.php");
            }

        }
        
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "camps";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);
    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        $title = $result[0]['title'];
        $intro_text = $result[0]['intro_text'];
        $total_sessions = $result[0]['total_sessions'];
        //find out the details of camp sessions
        $arrSessions = $globalManager->runSelectQuery("camp_sessions", "title,start_from,end_at,rate,camper_limit", "camp_id='".$_GET['id']."'");
    }else{
        $_SESSION['errmsg'] = "Invalid camp selected! Please select valid camp to update";
        redirect(ADMIN_SITE_URL."camps.php");
    }
}