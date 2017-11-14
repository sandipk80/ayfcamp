<?php
include('cnf.php');
################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'users/camps/camper-registration-init.php');
include(LIB_HTML . 'header.php');
$currStep = $step;
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>build.css" type="text/css" />
<link href="<?php echo CSS_SITE_URL;?>jquery.multiselect.css" rel="stylesheet" type="text/css">
<style>
.padding20{padding: 20px 0;}
.sf-steps-content > div{padding: 10px 10px 10px 40px; font-size:18px;}
li{list-style: none;}
</style>
<!-- Breadcrumb Starts -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled list-inline">
            <li><a href="index.html">Home</a></li>
            <li class="active">Camp Registration</li>
        </ul>
    </div>
</div>
<div class="container main-container">
    
    <div class="contact-content">
        
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <div class="sf-steps">
                    <div class="sf-steps-content">
                        <div class="sf">
                            <span>1</span> Select Camp and campers
                        </div>
                        <?php
                        for($s=2; $s<=$currStep; $s++){
                            if($s == $currStep){
                                $class = "sf-active";
                            }else{
                                $class = "sf";
                            }
                        ?>
                        <div class="<?php echo $class;?>">
                            <span><?php echo $s;?></span> Camper <?php echo $s-1;?> Information
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <h2><span>Step <?php echo $s;?>: Camper <?php echo $num;?> Information</span></h2>
                <div class="status alert alert-success contact-status"></div>
                <?php
                if(is_array($error) && count($error)>0) {
                    ?>
                    <!-- our error container -->
                    <div class="error-container" style="display:block;">
                        <ol>
                            <?php
                            foreach($error as $key=>$val) {
                                ?>
                                <li>
                                    <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
                                </li>
                                <?php
                            }
                            ?>
                        </ol>
                    </div>
                    <?php
                }
                include(LIB_HTML.'message.php');
                ?>
                <form id="frmCamperRegistration" class="contact-form" name="frmCamperRegistration" method="post" enctype="multipart/form-data" role="form">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="panel widget light-widget panel-bd-top">
                                <div class="panel-heading no-title"><strong><?php echo ucwords($camperInfo['first_name'].' '.$camperInfo['last_name']);?></strong></div>
                                <div class="panel-body">
                                    <div class="text-center vd_info-parent">
                                        <img src="<?php echo $camperImage;?>" alt="" />
                                    </div>

                                    <h3 class="font-semibold mgbt-xs-5"><?php echo ucwords($camperInfo['first_name'].' '.$camperInfo['last_name']);?></h3>
                                    <p><?php echo $camperInfo['email'];?></p>
                                    <p><strong>DOB: </strong><?php echo date("F d, Y", strtotime($patient['date_of_birth']));?></p>
                                    <p><strong>Relation: </strong><?php echo $patient['relation'];?></p>
                                    <p><strong>Already AYF camper: </strong><?php echo $patient['is_ayfcamper'] ? "Yes" : "No";?></p>
                                    <p><strong>T-shirt Size: </strong><?php echo $patient['tshirt_size'];?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Name of Parent/Legal Guardian <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="parent_name" id="parent_name" value="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Phone Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="parent_phone" id="parent_phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="address" id="address" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="location">City, State Zip  <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="location" id="location" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="physician_name">Family Physician/Pediatrician Name </label>
                                    <input type="text" class="form-control" name="physician_name" id="physician_name" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_phone">Family Physician/Pediatrician Phone Number </label>
                                    <input type="text" class="form-control" name="physician_phone" id="physician_phone" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insurance_card_front">Insurance Card Front </label>
                                    <input type="file" name="insurance_card_front" id="insurance_card_front">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insurance_card_back">Insurance Card Back </label>
                                    <input type="file" name="insurance_card_back" id="insurance_card_back">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insurance_carrier">Health Insurance Carrier </label>
                                    <input type="text" class="form-control" name="insurance_carrier" id="insurance_carrier">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="group_number">Group Number </label>
                                    <input type="text" class="form-control" name="group_number" id="group_number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="agreement_number">Agreement Number </label>
                                    <input type="text" class="form-control" name="agreement_number" id="agreement_number">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emergency_contact">In case of emergency I can be reached at </label>
                                    <input type="text" class="form-control" name="emergency_contact" id="emergency_contact">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emergency_phone">Phone number </label>
                                    <input type="text" class="form-control" name="emergency_phone" id="emergency_phone">
                                </div>
                            </div>

                            <div class="clear"></div>

                            <div class="camp-block topmarg20">
                                <h3>GENERAL QUESTIONS</h3>
                                <p>Has the camper ever had a history of:(Explain "yes" answers below)</p>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="recent_illness">Recent injury, illness or infectious disease? </label>
                                    <select class="form-control" name="recent_illness" id="recent_illness">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chronic_illness">Chronic or recurring illness/condition? </label>
                                    <select class="form-control" name="chronic_illness" id="chronic_illness">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="past_mononucleosis">Mononucleosis in the past 12 months?</label>
                                    <select class="form-control" name="past_mononucleosis" id="past_mononucleosis">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="eye_wear">Glasses, contacts or protective eye wear?</label>
                                    <select class="form-control" name="eye_wear" id="eye_wear">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hospitalization">Hospitalization? </label>
                                    <select class="form-control" name="hospitalization" id="hospitalization">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chronic_illness">Surgery? </label>
                                    <select class="form-control" name="surgery" id="surgery">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="frequent_headache">Frequent headaches?</label>
                                    <select class="form-control" name="frequent_headache" id="frequent_headache">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="head_injury">A head injury?</label>
                                    <select class="form-control" name="head_injury" id="head_injury">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="knocked_unconscious">Being knocked unconscious? </label>
                                    <select class="form-control" name="knocked_unconscious" id="knocked_unconscious">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ear_infections">Frequent ear infections?</label>
                                    <select class="form-control" name="ear_infections" id="ear_infections">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="excercise_fainting">Fainting during or after exercise?</label>
                                    <select class="form-control" name="excercise_fainting" id="excercise_fainting">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="excercise_dizziness">Dizziness during or after exercise?</label>
                                    <select class="form-control" name="excercise_dizziness" id="excercise_dizziness">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="seizures">Seizures? </label>
                                    <select class="form-control" name="seizures" id="seizures">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chest_pain">Chest pain during/after exercise?</label>
                                    <select class="form-control" name="chest_pain" id="chest_pain">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="high_blood_pressure">High blood pressure?</label>
                                    <select class="form-control" name="high_blood_pressure" id="high_blood_pressure">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="heart_murmurs">Heart murmurs?</label>
                                    <select class="form-control" name="heart_murmurs" id="heart_murmurs">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="back_problem">Back problems? </label>
                                    <select class="form-control" name="back_problem" id="back_problem">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="asthama">Asthama?</label>
                                    <select class="form-control" name="asthama" id="asthama">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="diabetes">Diabetes?</label>
                                    <select class="form-control" name="diabetes" id="diabetes">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="diarrhea">Diarrhea?</label>
                                    <select class="form-control" name="diarrhea" id="diarrhea">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sleepwalking">Sleepwalking? </label>
                                    <select class="form-control" name="sleepwalking" id="sleepwalking">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bed_wetting">Bed-wetting?</label>
                                    <select class="form-control" name="bed_wetting" id="bed_wetting">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="eating_disorder">An eating disorder?</label>
                                    <select class="form-control" name="eating_disorder" id="eating_disorder">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="joint_problem">Any joint problems (e.g. knees or ankles)?</label>
                                    <select class="form-control" name="joint_problem" id="joint_problem">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="strep_throat">Has had strep throat in the past 12 months?</label>
                                    <select class="form-control" name="strep_throat" id="strep_throat">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="skin_problem">Skin problems (e.g ., itching, rash, acne)?</label>
                                    <select class="form-control" name="skin_problem" id="skin_problem">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="brought_orthodontic_appliance">An orthodontic appliance being brought to camp?</label>
                                    <select class="form-control" name="brought_orthodontic_appliance" id="brought_orthodontic_appliance">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="emotional_difficulties">Emotional difficulties for which professional help was sought?</label>
                                    <select class="form-control" name="emotional_difficulties" id="emotional_difficulties">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_information">Use this space to provide any additional information about the participant’s behavior and physical, emotional, or mental health about which the camp should be aware.</label>
                                    <textarea class="form-control" name="additional_information" id="additional_information" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="explanations">Please explain any “yes” answers. </label>
                                    <textarea class="form-control" name="explanations" id="explanations" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-xs-12 text-center">
                                <input type="hidden" name="camper-register" value="submit">
                                <input type="hidden" name="camp_id" value="<?php echo $camperInfo['camp_id'];?>">
                                <input type="hidden" name="camp_register_code" value="<?php echo $registerCode;?>">
                                <input type="hidden" name="step" value="<?php echo $currStep;?>">
                                <input type="submit" class="btn btn-black text-uppercase" value="Next">
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $(".navbar-nav li").removeClass("active");
    $("#navBook").addClass("active");

    // USer login validation & submission
    $("#frmCamperRegistration").validate();
});

</script>
<?php include(LIB_HTML . 'footer.php');?>