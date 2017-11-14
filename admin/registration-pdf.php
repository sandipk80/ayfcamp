<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
//validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(isset($_GET['id']) && trim($_GET['id'])!==""){
    //find out the registration details
    $getResult = $globalManager->runSelectQuery("campers as cmp LEFT JOIN camp_registrations as cr ON cmp.camp_registration_id=cr.id LEFT JOIN camp_sessions as cps ON cmp.camp_session_id=cps.id LEFT JOIN snackshop as sn ON cmp.camp_registration_id=sn.camp_registration_id LEFT JOIN camps as cp ON cmp.camp_id=cp.id", "cmp.*,cr.user_id,cp.title as campname,cps.title as campSession,cps.start_from,cps.end_at,sn.amount as snack_amount,cr.payment_status,cr.created", "cmp.id='".$_GET['id']."' GROUP BY cmp.id");

    if(is_array($getResult) && count($getResult)>0){
        $result = $getResult[0];
        //find out the patient profile info
        $getChild = $globalManager->runSelectQuery("childs as cld LEFT JOIN users as u ON cld.user_id=u.id LEFT JOIN states as st ON u.state=st.id", "cld.*,CONCAT(u.first_name,' ',u.last_name) as parent_name,st.name as state", "cld.id='".$result['child_id']."'");
        if(is_array($getChild) && !empty($getChild)){
            $camper = $getChild[0];
            //find out the other details of child
            $getChildDetails = $globalManager->runSelectQuery("child_health_info", "*", "child_id='".$camper['id']."'");
            if(is_array($getChildDetails) && count($getChildDetails)>0){
                $camper = array_merge($camper,$getChildDetails[0]);
            }
            //find out the medications
            $getMedications = $globalManager->runSelectQuery("child_medications", "medication_name,dosage,times_taken", "child_id='".$camper['id']."'");
            if(is_array($getMedications) && count($getMedications)>0){
                $camper['medications'] = $getMedications;
            }else{
                $camper['medications'] = array();
            }
            $result['camper'] = $camper;
        }else{
            $_SESSION['errmsg'] = "Camper does not exists.";
            redirect(ADMIN_SITE_URL.'camp-registrations.php');
        }
    }else{
        $_SESSION['errmsg'] = "Invalid request.";
        redirect(ADMIN_SITE_URL.'camp-registrations.php');
    }
}else{
    $_SESSION['errmsg'] = "Invalid request";
    redirect(ADMIN_SITE_URL.'camp-registrations.php');
}
$child = $result['camper'];
$childPhoto = $child['photo'];
if($childPhoto !== "" && file_exists(STORAGE_PATH."campers/".$childPhoto)){
    $childPhoto = STORAGE_HTTP_PATH."campers/".$childPhoto;
}else{
    $childPhoto = IMG_PATH."user.jpg";
}

if($child['insurance_card_front']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['insurance_card_front'])){
    $frontInsImg = STORAGE_HTTP_PATH.'campers/'.$child['insurance_card_front'];
}else{
    $frontInsImg = IMG_PATH.'no-image.png';
}

if($child['insurance_card_back']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['insurance_card_back'])){
    $backInsImg = STORAGE_HTTP_PATH.'campers/'.$child['insurance_card_back'];
}else{
    $backInsImg = IMG_PATH.'no-image.png';
}

if($child['immunization_record']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['immunization_record'])){
    $immunization_record = STORAGE_HTTP_PATH.'campers/'.$child['immunization_record'];
}else{
    $immunization_record = IMG_PATH.'no-image.png';
}

// bus options
$arrBusOptions = array(
    '0' => 'None',
    '1' => 'To Camp $15',
    '2' => 'From Camp $15',
    '3' => 'Round Trip $25',
    '4' => 'To Camp $15 - WAITLIST ONLY',
    '5' => 'From Camp $15 - WAITLIST ONLY',
    '6' => 'Round Trip $25 - WAITLIST ONLY'
);
?>
<style>
/*table,tr,th{border:1px solid #CCC; font-size: 12px;}
.noborder{border:0px solid #FFF !important;}
.thead{background: #cecece;}*/
</style>
<table cellpadding="5" cellspacing="0" width="100%" align="center">
<tr>
    <td width="30%"><img src="<?php echo IMG_PATH;l?>logo.png" alt="" title=""></td>
    <td width="70%" valign="middle"><h3>Camper Information</h3></td>
</tr>
</table>

<table cellpadding="5" cellspacing="0" border="1" width="100%" align="center">
    <thead>
        <tr>
            <th>Camp</th>
            <th>Week</th>
            <th>Bus Option</th>
            <th>Snackshop Amount</th>
            <th>Start From</th>
            <th>End At</th>
            <th>Status</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $result['campname'];?></td>
            <td><?php echo $result['campSession'];?></td>
            <td><?php echo $arrBusOptions[$result['bus_opt']];?></td>
            <td><?php echo $result['snack_amount'] ? '$'.$result['snack_amount'] : 'None';?></td>
            <td><?php echo date("l F d, Y", strtotime($result['start_from']));?></td>
            <td><?php echo date("l F d, Y", strtotime($result['end_at']));?></td>
            <td align="center">
                <?php echo $result['payment_status'];?>
            </td>
            <td><?php echo date("F d, Y", strtotime($result['created']));?></td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<table cellpadding="5" cellspacing="0" border="1" width="100%" align="center">
    <thead>
        <tr>
            <th colspan="2"><h3>Camper Information</h3></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="40%">
                <img src="<?php echo $childPhoto;?>" />
            </td>
            <td width="60%">
                <table cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td align="left"><strong>First Name:</strong><br><?php echo $child['first_name'];?></td>
                        <td align="left"><strong>Last Name:</strong><br><?php echo $child['last_name'];?></td>
                    </tr>
                    <tr>
                        <td align="left"><strong>Gender:</strong><br><?php echo $child['gender']=="F" ? "Female" : "Male";?></td>
                        <td align="left"><strong>Date of Birth:</strong><br><?php echo $child['date_of_birth']!=='0000-00-00' ? date("m/d/Y", strtotime($child['date_of_birth'])) : "";?></td>
                    </tr>
                    <tr>
                        <td align="left"><strong>Email Address:</strong><br><?php echo $child['email'];?></td>
                        <td align="left"><strong>Relation:</strong><br><?php echo $child['relation'];?></td>
                    </tr>
                    <tr>
                        <td align="left"><strong>First time AYF camper?</strong><br><?php echo $child['is_ayf_camper'] ? "Yes" : "No";?></td>
                        <td align="left"><strong>Is member of AYF juniors?</strong><br><?php echo $child['member_ayf_juniors'] ? "Yes" : "No";?></td>
                    </tr>
                    <tr>
                        <td align="left"><strong>Is member of AYF?</strong><br><?php echo $child['ayf_member'] ? "Yes" : "No";?></td>
                        <td align="left"><strong>T-shirt Size:</strong><br><?php echo $child['tshirt_size'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3>Child Health Information</h3>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table cellpadding="5" cellspacing="0" width="100%" align="left" border="1">
                    <tr>
                        <td><strong>Name of Parent/Legal Guardian</strong><br><?php echo $child['parent_name'];?></td>
                        <td><strong>Relation</strong><br><?php echo $child['relation'];?></td>
                    </tr>
                    <tr>
                        <td><strong>Family Physician/Pediatrician Name</strong><br><?php echo $child['physician_name'];?></td>
                        <td><strong>Family Physician/Pediatrician Phone</strong><br><?php echo $child['physician_phone'];?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table cellpadding="5" cellspacing="0" width="100%" border="1">
                                <tr>
                                    <td>
                                        <strong>Insurance Card Front</strong><br>
                                        <img src="<?php echo $frontInsImg;?>" alt="" width="300" height="200" />
                                    </td>
                                    <td>
                                        <strong>Insurance Card Front</strong><br>
                                        <img src="<?php echo $backInsImg;?>" alt="" width="300" height="200" />
                                    </td>
                                    <td>
                                        <strong>Insurance Card Front</strong><br>
                                        <img src="<?php echo $immunization_record;?>" alt="" width="300" height="200" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table cellpadding="5" cellspacing="0" width="100%" border="1">
                                <tr>
                                    <td colspan="2">
                                        <strong>Health Insurance Carrier</strong><br>
                                        <?php echo $child['insurance_carrier'];?>
                                    </td>
                                    <td>
                                        <strong>Group Number</strong><br>
                                        <?php echo $child['group_number'];?>
                                    </td>
                                    <td>
                                        <strong>Agreement Number</strong><br>
                                        <?php echo $child['agreement_number'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>In case of Emergency</strong><br>
                                        <?php echo $child['emergency_contact'];?>
                                    </td>
                                    <td colspan="2">
                                        <strong>Phone number</strong><br>
                                        <?php echo $child['emergency_phone'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Dizziness during or after exercise?</strong><br>
                                        <?php echo $child['excercise_dizziness']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Seizures?</strong><br>
                                        <?php echo $child['seizures']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Chest pain during/after exercise?</strong><br>
                                        <?php echo $child['chest_pain']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>High blood pressure?</strong><br>
                                        <?php echo $child['high_blood_pressure']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Heart murmurs?</strong><br>
                                        <?php echo $child['heart_murmurs']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Back problems?</strong><br>
                                        <?php echo $child['back_problem']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Asthama?</strong><br>
                                        <?php echo $child['asthama']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Diabetes?</strong><br>
                                        <?php echo $child['diabetes']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Diarrhea?</strong><br>
                                        <?php echo $child['diarrhea']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Sleepwalking?</strong><br>
                                        <?php echo $child['sleepwalking']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Bed-wetting?</strong><br>
                                        <?php echo $child['bed_wetting']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>An eating disorder?</strong><br>
                                        <?php echo $child['eating_disorder']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Any joint problems?</strong><br>
                                        <?php echo $child['joint_problem']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Strep Throat?</strong><br>
                                        <?php echo $child['strep_throat']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Skin problems?</strong><br>
                                        <?php echo $child['skin_problem']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Any orthodontic appliance?</strong><br>
                                        <?php echo $child['brought_orthodontic_appliance']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Any Emotional difficulties?</strong><br>
                            <?php echo $child['emotional_difficulties']=="1" ? "Yes" : "No";?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>Explanation</strong><br>
                            <?php echo $child['explanations'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Medication Allergies</strong><br>
                            <?php echo $child['medication_allergies'];?>
                        </td>
                        <td>
                            <strong>Food Allergies</strong><br>
                            <?php echo $child['food_allergies'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Other (i.e. Bee Stings)</strong><br>
                            <?php echo $child['other_allergies'];?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table cellpadding="5" cellspacing="0" width="100%" border="1">
                                <tr>
                                    <td>
                                        <strong>Recent injury, illness?</strong><br>
                                        <?php echo $child['recent_illness']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Chronic or recurring illness?</strong><br>
                                        <?php echo $child['chronic_illness']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Mononucleosis?</strong><br>
                                        <?php echo $child['past_mononucleosis']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Any eye wear?</strong><br>
                                        <?php echo $child['eye_wear']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Hospitalization?</strong><br>
                                        <?php echo $child['hospitalization']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Surgery?</strong><br>
                                        <?php echo $child['surgery']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Frequent headaches?</strong><br>
                                        <?php echo $child['frequent_headache']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Any head injury?</strong><br>
                                        <?php echo $child['head_injury']=="1" ? "Yes" : "No";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Being knocked unconscious?</strong><br>
                                        <?php echo $child['knocked_unconscious']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Frequent ear infections?</strong><br>
                                        <?php echo $child['ear_infections']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Fainting during or after exercise?</strong><br>
                                        <?php echo $child['excercise_fainting']=="1" ? "Yes" : "No";?>
                                    </td>
                                    <td>
                                        <strong>Additional Information</strong><br>
                                        <?php echo $child['additional_information'];?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

    </tbody>

</table>