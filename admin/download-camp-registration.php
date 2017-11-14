<?php
include('../cnf.php');
//define('K_PATH_MAIN', '../Library/tcpdf/');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
include(LIB_PATH."TCPDF-master/tcpdf.php");
if(isset($_GET['id'], $_GET['act']) && trim($_GET['id'])!=="" && trim($_GET['act'])=="download"){
    //find out the registration details
    $getResult = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cr ON cmp.camp_registration_id=cr.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN snackshop as sn ON cmp.camp_registration_id=sn.camp_registration_id LEFT JOIN camps as cp ON cmp.camp_id=cp.id", "cmp.*,cr.user_id,cp.title as campname,cps.title as campSession,cps.start_from,cps.end_at,sn.amount as snack_amount,cr.payment_status,cr.created", "cmp.id='".$_GET['id']."' GROUP BY cmp.id");

    if(is_array($getResult) && count($getResult)>0){
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AYF Camp');
        $pdf->SetTitle('Camper Information');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // disable header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        define(PDF_MARGIN_TOP2, 10);
        define(PDF_MARGIN_LEFT2, 10);
        define(PDF_MARGIN_RIGHT2, 10);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT2, PDF_MARGIN_TOP2, PDF_MARGIN_RIGHT2);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage();
        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('dejavusans', '', 8);

        $html = UtilityManager::get_remote_data(ADMIN_SITE_URL.'registration-pdf.php?id='.$_GET['id']);
       //prx($html);
        // output the HTML content
        $pdf->writeHTML($html, true, 0, true, 0);

        // reset pointer to the last page
        $pdf->lastPage();
 
        // ---------------------------------------------------------
        $pdfFile = UtilityManager::generateImageName(12);
        
        //Close and output PDF document
        $pdf->Output(STORAGE_PATH.'campers/'.$pdfFile.'.pdf', 'I');
        if(file_exists(STORAGE_PATH.'campers/'.$pdfFile.'.pdf')){
            $camperArray = array(
                'pdf_file' => $pdfFile.'.pdf'
            );
            $updateCamper = $globalManager->runUpdateQuery("campers", $camperArray, "id='".$_GET['id']."'");
        }

    }else{
        $_SESSION['errmsg'] = "Invalid request.";
        redirect(ADMIN_SITE_URL.'camp-registrations.php');
    }
}else{
    $_SESSION['errmsg'] = "Invalid request";
    redirect(ADMIN_SITE_URL.'camp-registrations.php');
}

?>
