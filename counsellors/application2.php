<?php
include('../cnf.php');
require_once(LIB_PATH.'counsellors/applications/application2-init.php');
include(LIB_HTML . 'counsellors/header.php');
?>
<style>
.birthMonth,.birthDate,.birthYear{background:#FFF; width:25%; color:#000; margin-right:10px; border:1px solid #d4d6d7;
    height: 40px; line-height: normal; padding: 7px 14px;}
select{padding: 7px 14px !important; height: 40px !important;}
</style>

<div class="container main-container">
    <div class="contact-content">
        <div class="row">
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

            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <h3>AYF Summer Camp First Time Counsellor Application</h3>
                <p class"" style="font:20px;color:#FF0000;">Application Deadline: March 31, 2017</p>
                <p class"" style="font:20px;color:#FF0000;">MANDATORY Counsellor Orientation: April 29-30, 2017 at AYF Camp</p>
                <p>Please have the following items uploaded onto your computer and ready prior to beginning the application.</p>
                <ul>
                    <li>Photo upload of A Valid ID (i.e. license, passport)</li>
                    <li>Uploads of any certificates (i.e. lifeguard, CPR, First Aid)</li>
                    <li>Emergency Contact(s) and references information</li>
                    <li>Physician information</li>
                </ul>

                    
                <form id="frmApplication" class="contact-form form" name="frmApplication" method="post" enctype="multipart/form-data" role="form">

                    <div class="box row-fluid">
                        <div class="camp-block topmarg20">
                            <h3>Applicant Information</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-4 col-md-4">
                                    <div class="thumbnail">
                                        <div class="thumb-wrapper">
                                            <?php
                                            $childPhoto = IMG_PATH."IDplaceholder.jpg";
                                            if(isset($_GET['id']) && trim($_GET['id'])!==""){
                                                if($childPhoto !== "" && file_exists(STORAGE_PATH."campers/".$childPhoto)){
                                                    $childPhoto = STORAGE_HTTP_PATH."campers/".$childPhoto;
                                                }
                                            }
                                            ?>
                                            <img alt="" src="<?php echo $childPhoto;?>" class="img-responsive" id="imgArea" width="100%" />
                                        </div>
                                            
                                        <div class="marginT marginL20">
                                            <div class="form-group">
                                                <?php
                                                if(isset($_GET['id']) && trim($_GET['id'])!==""){
                                                ?>
                                                <label class="control-label">Change Photo</label>
                                                <?php
                                                }else{
                                                ?>
                                                <label class="control-label">Upload Photo <span class="required">*</span></label>
                                                <?php
                                                }
                                                ?>
                                                <input type="file" name="imgfile" id="imgfile" class="border">
                                                <p class="font12">(.jpg,.png,.pdf, 6mb max size)</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-8 col-md-8">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $last_name;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="fullW">Gender <span class="required">*</span></label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth <span class="required">*</span></label>
                                            <div id="date_of_birth" class="d_o_b"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="address" id="address" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apt_unit">Apt/Unit # </label>
                                            <input type="text" class="form-control" name="apt_unit" id="apt_unit" value="">
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="city" id="city" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state_id">State <span class="required">*</span></label>
                                            <select class="form-control" name="state_id" id="state_id">
                                                <option value="">-- Select State --</option>
                                                <?php
                                                if(is_array($arrStates) && count($arrStates)>0){
                                                    foreach($arrStates as $state){
                                                        $selected = "";
                                                        echo '<option value="'.$state['id'].'" '.$selected.'>'.$state['name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zipcode">Zip / Post Code <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Primary Phone <span class="required">*</span></label>
                                            <input type="text" class="form-control required" name="phone" id="phone" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone2">Secondary Phone </label>
                                            <input type="text" class="form-control" name="phone2" id="phone2" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tshirt_size">T-shirt Size </label>
                                            <select class="form-control" name="tshirt_size" id="tshirt_size">
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="X-Large">X-Large</option>
                                                <option value="XX-Large">XX-Large</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ayf_member">Are you an AYF member? </label>
                                            <select class="form-control" name="ayf_member" id="ayf_member">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Choose weeks you’re applying for (no consecutive weeks)</div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Preferred Week(s) </label>
                                            <select name="camp_session_id[]" id="camp_session_id" class="form-control ddcampsessions" multiple>
                                                <?php
                                                if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                                                    foreach($camp['sessions'] as $session){
                                                        $dateRange = date("l F d, Y", strtotime($session['start_from'])).' to '.date("l F d, Y", strtotime($session['end_at']));
                                                        if($session['expire'] == "1"){
                                                            //$style = "text-decoration:line-through;";
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Alternate Choices and Availability </label>
                                            <select name="alt_camp_session_id[]" id="alt_camp_session_id" class="form-control ddcampsessions" multiple>
                                                <?php
                                                if(is_array($camp['sessions']) && count($camp['sessions'])>0){
                                                    foreach($camp['sessions'] as $session){
                                                        $dateRange = date("l F d, Y", strtotime($session['start_from'])).' to '.date("l F d, Y", strtotime($session['end_at']));
                                                        if($session['expire'] == "1"){
                                                            //$style = "text-decoration:line-through;";
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

                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Emergency Contacts </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Emergency Contact 1: Name, phone & relation <span class="required">*</span></label>
                                            <input type="text" class="form-control required" name="emergency_contact1" id="emergency_contact1" value="<?php echo $emergency_contact1;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Emergency Contact 2: Name, phone & relation <span class="required">*</span></label>
                                            <input type="text" class="form-control required" name="emergency_contact2" id="emergency_contact2" value="<?php echo $emergency_contact2;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Emergency Contact 3: Name, phone & relation <span class="required">*</span></label>
                                            <input type="text" class="form-control required" name="emergency_contact3" id="emergency_contact3" value="<?php echo $emergency_contact3;?>">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Camp Experience </div>
                                    </div>
                                    <div class="input_fields_wrap">
                                        <div class="blkhdr">Camp 1</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Dates </label>
                                                <input type="text" class="form-control" name="camp_dates[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Name & Director </label>
                                                <input type="text" class="form-control" name="camp_name[]" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Location </label>
                                                <input type="text" class="form-control" name="camp_locations[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camper or Staff? </label>
                                                <select class="form-control" name="camper_or_staff[]">
                                                    <option value="staff">Staff</option>
                                                    <option value="camper">Camper</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input_fields_wrap">
                                        <div class="blkhdr">Camp 2</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Dates </label>
                                                <input type="text" class="form-control" name="camp_dates[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Name & Director </label>
                                                <input type="text" class="form-control" name="camp_name[]" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Location </label>
                                                <input type="text" class="form-control" name="camp_locations[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camper or Staff? </label>
                                                <select class="form-control" name="camper_or_staff[]">
                                                    <option value="staff">Staff</option>
                                                    <option value="camper">Camper</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input_fields_wrap">
                                        <div class="blkhdr">Camp 3</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Dates </label>
                                                <input type="text" class="form-control" name="camp_dates[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Name & Director </label>
                                                <input type="text" class="form-control" name="camp_name[]" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Location </label>
                                                <input type="text" class="form-control" name="camp_locations[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camper or Staff? </label>
                                                <select class="form-control" name="camper_or_staff[]">
                                                    <option value="staff">Staff</option>
                                                    <option value="camper">Camper</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input_fields_wrap">
                                        <div class="blkhdr">Camp 4</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Dates </label>
                                                <input type="text" class="form-control" name="camp_dates[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Name & Director </label>
                                                <input type="text" class="form-control" name="camp_name[]" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camp Location </label>
                                                <input type="text" class="form-control" name="camp_locations[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Camper or Staff? </label>
                                                <select class="form-control" name="camper_or_staff[]">
                                                    <option value="staff">Staff</option>
                                                    <option value="camper">Camper</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Certifications</div>
                                        <p>Please mark a check next to each certificate you have. Attach a copy of the certificate to this application.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Please select each certificate you have</label>
                                            <input type="checkbox" name="certificate[]" id="certificateCPR" value="CPR" style="margin-left:40px;"> CPR
                                            <input type="checkbox" name="certificate[]" id="certificateEMT" value="EMT" style="margin-left:40px;"> EMT
                                            <input type="checkbox" name="certificate[]" id="certificateFirstAid" value="First Aid" style="margin-left:40px;"> First Aid
                                            <input type="checkbox" name="certificate[]" id="certificateNursing" value="Nursing" style="margin-left:40px;"> Nursing
                                            <input type="checkbox" name="certificate[]" id="certificateLifeguard" value="Lifeguard" style="margin-left:40px;"> Lifeguard
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Upload a copy of each certificate to this application. </label>
                                            <input type="file" name="contribution_image[]" multiple>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Health History</div>
                                        <p><i>The information provided is kept confidential, only reviewed by the Management Board, directors of your week and the EMT.</i></p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">Have you ever been hospitalized?</div>
                                        <select class="form-control" name="have_hospitalized" id="have_hospitalized">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">Taking_medications</div>
                                        <select class="form-control" name="taking_medications" id="taking_medications">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">Have any medical or significant restrictions?</div>
                                        <select class="form-control" name="medical_conditions" id="medical_conditions">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12" id="medical_restriction">
                                        <div class="form-group">
                                            <label for="email">Please explain</label>
                                            <textarea class="form-control" rows="5" name="medical_condition_text" id="medical_condition_text"><?php echo $medical_condition_text;?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Please provide the name and phone number of your physician</label>
                                            <input type="text" class="form-control" name="physician_details" id="physician_details" value="<?php echo $medical_condition_text;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">Do you smoke?</div>
                                        <select class="form-control" name="do_smoke" id="do_smoke">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" id="smoketext">
                                        <div class="form-group">
                                            <label for="email">How often and can you handle not smoking during your stay at camp? </label>
                                            <input type="text" class="form-control" name="handle_smoking" id="handle_smoking" value="<?php echo $handle_smoking;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">List any and all medical conditions that may affect you up at camp and any medications that you will need to take during your stay at camp (include all allergies, asthma, and medication)</label>
                                            <textarea class="form-control" rows="5" name="medical_condition_list" id="medical_condition_list"><?php echo $medical_condition_list;?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">Criminal Record</div>
                                        <p><i>The information provided is kept confidential, only reviewed by the Management Board.</i></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">Have you ever been convicted of a crime, other than a minor traffic offense? If yes, please describe. (Note: a prior conviction is not an automatic bar of eligibility. The camp will evaluate the type of conviction and when it occurred before any decision is made.)</div>
                                        <select class="form-control" name="commited_crime" id="commited_crime">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" id="crimeinfo">
                                        <div class="form-group">
                                            <label for="email">Please explain</label>
                                            <textarea class="form-control" rows="5" name="crime_explanations" id="crime_explanations"><?php echo $crime_explanations;?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="crimeinfo">
                                        <div class="form-group">
                                            <p>I authorize investigation of all statements herein, including any checks of criminal records, and release the camp and all others from liability in connection with same. I further agree to adhere to all AYF Camp regulations and to abide by all of the decisions made by the AYF Summer Camp Committee, Camp Director, and Board of Directors. I understand that untrue, misleading, or omitted information herein or in other documents by the applicant may result in dismissal, regardless of the time of discovery by the camp. I also understand that this application will be void should I not attend the mandatory counsellor orientation at AYF Camp April 29-30, 2017. All applicants are subject to mandatory drug testing prior to being approved as a counsellor. Once approved, all counsellors are also subject to random drug testing during their stay at camp.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" class="required" name="accept_term" id="accept_term" value="1" style="float:left;width:20px;">
                                            I accept the above statement
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="group-block topmarg20">CODE OF ETHICS AND CONDUCT FOR AYF CAMP STAFF</div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>That I am volunteering to provide direct and/or indirect supervision of children and/or young adults attending the camp sessions. And in that position, I take responsibility over the health and well being of each camper assigned to my care, and will put their needs and interest first when making decisions. I understand that in an emergency situation it is my primary responsibility to secure the safety of each camper assigned to my care, and secondarily to assist in the security of other campers and staff.</p>

                                        <p>That I will refrain from participating in any activities that are contradictory to or violate any of the rules as set forth by the AYF Summer Camp Management and Committee. And in my position, I will uphold the rules to all campers. I have read and understand those rules (a copy of which is attached and is a part of this document).</p>

                                        <p>That in my position I will be serving as a role model for the campers and that within my actions, I will strive to set a positive example of conduct at all times.</p>

                                        <p>That I will abide the following Child Abuse Guidelines for staff relationships with the campers. At no time should campers be left unsupervised (where they cannot be seen by the supervising adult). Staff behavior and disciplinary actions with children must avoid all abusive behavior as defined in the following definition of child abuse.</p>

                                        <div class="" style="font-weight:bold;">
                                            <p>Child Abuse – A physical injury which is inflicted by other than accidental means on a child by another person. Sexual abuse, including both sexual assault and sexual exploitation. Willful cruelty or unjustifiable punishment of a child, resulting in physical pain or mental suffering. Corporal punishment or injury, neglect, including both severe and general neglect.</p>
                                            <ul>
                                                <li>Possession of any of the following items:</li>
                                                <li>Alcohol Possession of firearm or other weapons</li>
                                                <li>Replica firearm or any other weapons</li>
                                                <li>Illegal drugs or controlled substances</li>
                                                <li>Fireworks or other flammable materials</li>
                                            </ul>
                                            <p>Fires are restricted to the campfire which can only be started by designated staff, and only in the campfire area.</p>

                                            <p>All campers and staff are required to stay within camp areas at all times. Any departure from the camp facility requires permission from the Camp Director.</p>

                                            <p>That my person and/or property may be subject to search upon request by Camp Management, Camp Committee, and the Camp Director, should the need arise for the safety and protection of those attending camp.</p>

                                            <p>That I will obey all laws of the Sate of California.</p>

                                            <p>In accepting the position of staff or volunteer with the Armenian Youth Federation summer camp program, I further agree that failure to abide by any of the above items may result in my dismissal from the position, expulsion from camp and denial of a return to the Armenian Youth Federation Summer Camp program for any specified period of time. I have read, understand and agree to abide by all the above rules.</p>

                                            <p>Abuse Policy</p>

                                            <p>This policy on child abuse was approved by the Camp Committee in order to help safeguard the health and well–being of all campers, counseling staff, program staff and directing staff participating in the Armenian Youth Federation Summer Camp program.</p>

                                            <p>Personal Rights ¹</p>

                                            <p>The Armenian Youth Federation Summer Camp Committee endorses the following personal rights for all staff and campers. All staff and campers are entitled to:</p>
                                            <ul>
                                                <li>Dignity in person relationships with staff and campers.</li>
                                                <li>Safe and healthful accommodations, furnishing and equipment.</li>
                                                <li>Freedom from corporal or unusual punishment, infliction of pain, humiliation, intimidation, ridicule, coercion, threat, mental abuse or other actions of a punitive nature including but not limited to: interference with function of daily living including eating, sleeping or toileting; or withholding of shelter, clothing, medication or aids to physically functioning.</li>
                                                <li>Not be locked in any room, building or center premises by day or night.</li>
                                            </ul>

                                            <p>Prohibitions²</p>

                                            <p>Inappropriate behavior or disciplinary measures, including but not limited to the following, shall be prohibited.</p>
                                            <ul>
                                                <li>Corporal punishment, including hitting, spanking, beating, shaking, pinching, and other measures that produce physical pain.</li>
                                                <li>Withdrawal or the threat of withdrawal of food, rest, or bathroom opportunities.</li>
                                                <li>Abusive or profane language.</li>
                                                <li>Any form of public or private humiliation, including threats of physical punishment.</li>
                                                <li>Any form of sexual abuse</li>
                                            </ul>

                                            <p>Any form of emotional abuse, including rejecting, terrorizing, ignoring, isolating, or corrupting a child. Any staff member must report any such known abuse immediately to the Armenian Youth Federation Summer Camp Director. Any staff member or camper engaging in such behavior faces dismissal by the Armenian Youth Federation Summer Camp Committee.</p>

                                            <p>Definition 3</p>

                                            <p>The following are descriptions of four major type of maltreatment: Physical abuse, neglect, sexual abuse, and emotional abuse. While state definitions may vary, operational definitions include, but are not limited to, the following:</p>
                                            
                                            <p>Physical Abuse</p>

                                            <p>Characterized by the infliction of physical injury as a result of punching, beating, kicking, biting, burning, shaking, or otherwise harming a child. The parent or caretaker may not have intended to hurt the child; rather the injury may have resulted from over-discipline or physical punishment.
                                            Child Neglect</p>

                                            <p>Characterized by failure to provide for the child’s basic needs. Neglect can be physical, education, or emotional.</p>
                                            
                                            <p>Sexual Abuse</p>

                                            <p>Includes fondling a child’s genitals, intercourse, incest, rape sodomy, exhibitionism, and commercial exploitation.</p>

                                            <p>Emotional Abuse (psychological / verbal abuse / mental injury)</p>

                                            <p>Includes acts or omission by the staff, or could cause serious behavioral, cognitive, emotional, or mental disorders. Examples include extreme or bizarre forms of punishment, such as confinement of a child in a dark closet, as well as less severe acts, such as habitual scapegoat, belittling, or rejecting treatment.</p>

                                            <p>1. Derived from the Sate of California Regulations for Child Care Centers</p>

                                            <p>2. Derived from policies outlined by the Nation Resource Center for Health and Safety in Child Care, located at the University of Colorado Health Sciences Center in Denver, Colorado, and funded by the Maternal and Child Health Bureau, U.S Department of Health and Human Services.</p>

                                            <p>3. Derived from the definitions provided by the National Clearinghouse for Child Abuse and Neglect.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Electronic Signature <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="signature" id="signature" value="<?php echo $signature;?>">
                                            <p class="help-text">Please type your First and Last Name</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="curr_date" id="curr_date" value="<?php echo date("m/d/Y");?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="counsellor_email" id="counsellor_email" value="<?php echo $counsellor_email;?>" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" class="required" name="legal_terms" id="legal_terms" value="1" style="float:left;width:20px;">
                                            I understand that checking this box constitutes a legal signature confirming that I acknowledge and agree to the above terms and have been fully truthful in my responses.
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">What year is it? <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="curr_year" id="curr_year" value="">
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>


                        
                    </div>

                    <div class="col-md-12 col-xs-12">
                        <input type="hidden" name="add-application" value="submit">
                        <input type="hidden" name="applicationId" value="<?php echo $_GET['id'];?>">
                        <button type="button" class="btn-default text-capitalize back btn">Back</button>
                        <button type="submit" class="btn-primary text-capitalize submit btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo CSS_SITE_URL;?>jquery.multiselect.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>build.css" type="text/css" />
<link href="<?php echo CSS_SITE_URL;?>jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery-birthday-picker.min.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.multiselect.js"></script>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#imgArea').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgfile").change(function(){
    readURL(this);
});

$(function() {
    //invite more artists
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><p>Employer '+x+'</p><div class="col-md-6"><div class="form-group"><label for="email">Employer Name </label><input type="text" class="form-control" name="employer_name[]" value=""></div></div><div class="col-md-6"><div class="form-group"><label for="email">Dates </label><input type="text" class="form-control" name="dates[]" value=""></div></div><div class="col-md-6"><div class="form-group"><label for="email">Supervisor </label><input type="text" class="form-control" name="supervisor[]" value=""></div></div><div class="col-md-6"><div class="form-group"><label for="email">Nature of Work Performed </label><input type="text" class="form-control" name="work_nature[]" value=""></div></div><div class="col-md-10"><div class="form-group"><label for="email">Employer Address & Phone </label><input type="text" class="form-control" name="employer_info[]" value=""></div></div><div class="col-sm-2"><a href="javascript:;" class="remove_field"><i class="fa fa-minus-circle top_margin"></i></a><div class="clierfix"></div></div></div></div>');
        }
    });
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    });
});

$(document).ready(function() {
    $(".navbar-nav li").removeClass("active");

    $("#date_of_birth").birthdayPicker({
        "defaultDate": "<?php echo ($date_of_birth!=='0000-00-00' || !isset($date_of_birth)) ? date('Y-m-d', strtotime($date_of_birth)) : '';?>",
        "maxYear": "<?php echo date('Y');?>",
        "maxAge": 100,
        "minAge": 1,
        "placeholder": true,
        "defaultDate": false,
        "sizeClass": "span2"
    });

    $('.ddcampsessions').multiselect({
        columns: 1,
        placeholder: 'Select Session'
    });

    $.validator.addMethod("uploadFile", function (val, element) {
        if(jQuery.type(element.files[0]) != 'undefined'){
            var size = element.files[0].size;
            if (size > 2097152){
                return false;
            } else {
                return true;
            }
        }else{
            return true;
        }
    }, "File size must be less than 2 MB");


    // USer login validation & submission
    $("#frmApplication").validate({
        rules: {
            first_name  : "required",
            last_name : "required",
            email : {required : true, email:true},
            address  : "required",
            city  : "required",
            state_id  : "required",
            zipcode  : "required",
            emergency_contact1  : "required",
            emergency_contact2  : "required",
            emergency_contact3  : "required",
            reference1  : "required",
            reference2  : "required",
            reference3  : "required",
            imgfile: {
                required:true,
                extension: "png|jpg|jpeg|bmp|gif",
                uploadFile:true
            },
            accept_term : "required",
            signature : "required",
            counsellor_email : "required",
            legal_terms : "required",
            curr_year : "required"
        },
        messages: {
            accept_term : "Please accept the camper terms and services",
            legal_terms : "Please accept the terms"
        }
    });
});
</script>
<?php include(LIB_HTML . 'footer.php');?>