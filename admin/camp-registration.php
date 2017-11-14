<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/campers/view-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>

<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>camp-registrations.php">Camp Registrations</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                        <div class="actions pull-right">
                            <a class="btn btn-success" href="<?php echo ADMIN_SITE_URL.'download-camp-registration.php?act=download&id='.$_GET['id'];?>">Download Details</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                        <td><?php echo $result['busoption'];?></td>
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
                            </div>

                            <div class="row">
                                <?php
                                if(is_array($result['camper']) && count($result['camper'])>0){
                                    $child = $result['camper'];
                                ?>
                                <div class="child-block">
                                <div class="rwheader">
                                    <div class="col-md-6">Camper Information</div>
                                    <!--div class="pull-right"><a href="<?php echo ADMIN_SITE_URL.'edit-child.php?id='.$child['id'];?>">Edit</a></div-->
                                </div>
                                <div class="col-md-12">
                                    <div class="col-sm-4 col-md-4">
                                        <div class="thumbnail">
                                            <div class="thumb-wrapper">
                                                <?php
                                                $childPhoto = $child['photo'];
                                                if($childPhoto !== "" && file_exists(STORAGE_PATH."campers/".$childPhoto)){
                                                    $childPhoto = STORAGE_HTTP_PATH."campers/".$childPhoto;
                                                }else{
                                                    $childPhoto = IMG_PATH."user.jpg";
                                                }
                                                ?>
                                                <img alt="" src="<?php echo $childPhoto;?>" class="img-responsive" id="imgArea" width="100%" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-8 col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name </label>
                                                <div class="form-control"><?php echo $child['first_name'];?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name </label>
                                                <div class="form-control"><?php echo $child['last_name'];?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="fullW">Gender </label>
                                                <div class="form-control"><?php echo $child['gender']=="F" ? "Female" : "Male";?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth </label>
                                                <div class="form-control"><?php echo $child['date_of_birth']!=='0000-00-00' ? date("m/d/Y", strtotime($child['date_of_birth'])) : "";?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Address </label>
                                                <div class="form-control"><?php echo $child['email'];?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relation </label>
                                                <div class="form-control"><?php echo $child['relation'];?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First time AYF camper? </label>
                                                <div class="form-control"><?php echo $child['is_ayf_camper'] ? "Yes" : "No";?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Is member of AYF juniors? </label>
                                                <div class="form-control"><?php echo $child['member_ayf_juniors'] ? "Yes" : "No";?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Is member of AYF? </label>
                                                <div class="form-control"><?php echo $child['ayf_member'] ? "Yes" : "No";?></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">T-shirt Size </label>
                                                <div class="form-control"><?php echo $child['tshirt_size'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-md-12">
                                    <div class="dtheader"><h3>Child <?php echo $k;?> Health Information</h3></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Name of Parent/Legal Guardian </label>
                                            <div class="form-control"><?php echo $child['parent_name'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Relation </label>
                                            <div class="form-control"><?php echo $child['relation'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Family Physician/Pediatrician Name </label>
                                            <div class="form-control"><?php echo $child['physician_name'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Family Physician/Pediatrician Phone </label>
                                            <div class="form-control"><?php echo $child['physician_phone'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12">Insurance Card Front </label>
                                            <?php
                                            if($child['insurance_card_front']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['insurance_card_front'])){
                                                $file_ext1 = pathinfo($child['insurance_card_front'], PATHINFO_EXTENSION);
                                                if($file_ext1 == "pdf"){
                                                    echo '<a href="'.$child['immunization_record'].'" target="_new">'.$child['immunization_record'].'</a>';
                                                }else{
                                                    echo '<img src="'.STORAGE_HTTP_PATH.'campers/'.$child['insurance_card_front'].'" alt="" width="300" height="200" />';
                                                }
                                            }else{
                                                echo '<img src="'.IMG_PATH.'no-image.png" alt="" width="300" height="200" />';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12">Insurance Card Back </label>
                                            <?php
                                            if($child['insurance_card_back']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['insurance_card_back'])){
                                                $backImg = STORAGE_HTTP_PATH.'campers/'.$child['insurance_card_back'];
                                            }else{
                                                $backImg = IMG_PATH.'no-image.png';
                                            }
                                            ?>
                                            <img src="<?php echo $backImg;?>" alt="" width="300" height="200"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12">Immunization Records </label>
                                            <?php
                                            if($child['immunization_record']!=="" && file_exists(STORAGE_PATH.'campers/'.$child['immunization_record'])){
                                                $immunization_record = STORAGE_HTTP_PATH.'campers/'.$child['immunization_record'];
                                            }else{
                                                $immunization_record = IMG_PATH.'no-image.png';
                                            }
                                            ?>
                                            <img src="<?php echo $immunization_record;?>" alt="" width="300" height="200"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Health Insurance Carrier </label>
                                            <div class="form-control"><?php echo $child['insurance_carrier'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Group Number </label>
                                            <div class="form-control"><?php echo $child['group_number'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Agreement Number </label>
                                            <div class="form-control"><?php echo $child['agreement_number'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">In case of emergency </label>
                                            <div class="form-control"><?php echo $child['emergency_contact'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number </label>
                                            <div class="form-control"><?php echo $child['emergency_phone'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Dizziness during or after exercise?</label>
                                            <div class="form-control"><?php echo $child['excercise_dizziness']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Seizures?</label>
                                            <div class="form-control"><?php echo $child['seizures']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Chest pain during/after exercise?</label>
                                            <div class="form-control"><?php echo $child['chest_pain']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>High blood pressure?</label>
                                            <div class="form-control"><?php echo $child['high_blood_pressure']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Heart murmurs?</label>
                                            <div class="form-control"><?php echo $child['heart_murmurs']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Back problems?</label>
                                            <div class="form-control"><?php echo $child['back_problem']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Asthama?</label>
                                            <div class="form-control"><?php echo $child['asthama']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Diabetes?</label>
                                            <div class="form-control"><?php echo $child['diabetes']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Diarrhea?</label>
                                            <div class="form-control"><?php echo $child['diarrhea']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sleepwalking?</label>
                                            <div class="form-control"><?php echo $child['sleepwalking']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bed-wetting?</label>
                                            <div class="form-control"><?php echo $child['bed_wetting']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>An eating disorder?</label>
                                            <div class="form-control"><?php echo $child['eating_disorder']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Any joint problems?</label>
                                            <div class="form-control"><?php echo $child['joint_problem']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Strep Throat?</label>
                                            <div class="form-control"><?php echo $child['strep_throat']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Skin problems?</label>
                                            <div class="form-control"><?php echo $child['skin_problem']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Any orthodontic appliance?</label>
                                            <div class="form-control"><?php echo $child['brought_orthodontic_appliance']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Any Emotional difficulties?</label>
                                            <div class="form-control"><?php echo $child['emotional_difficulties']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Explanation</label>
                                            <div class="form-control"><?php echo $child['explanations'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Medication Allergies</label>
                                            <div class="form-control"><?php echo $child['medication_allergies'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Food Allergies</label>
                                            <div class="form-control"><?php echo $child['food_allergies'];?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Other (i.e. Bee Stings)</label>
                                            <div class="form-control"><?php echo $child['other_allergies'];?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="dtheader"><h3>Child <?php echo $k;?> Current Medications</h3></div>
                                    <?php
                                    if(is_array($child['medications']) && count($child['medications'])>0){
                                        foreach($child['medications'] as $mval){
                                    ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Medication</label>
                                            <div class="form-control"><?php echo $mval['medication_name'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dosage</label>
                                            <div class="form-control"><?php echo $mval['dosage'];?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Times Taken</label>
                                            <div class="form-control"><?php echo $mval['times_taken'];?></div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }else{
                                        echo '<div class="text-center btm-margin20"><h3 class="txtred">No medication mentioned</h3></div>';
                                    }
                                    ?>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Recent injury, illness?</label>
                                            <div class="form-control"><?php echo $child['recent_illness']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Chronic or recurring illness?</label>
                                            <div class="form-control"><?php echo $child['chronic_illness']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mononucleosis?</label>
                                            <div class="form-control"><?php echo $child['past_mononucleosis']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Any eye wear?</label>
                                            <div class="form-control"><?php echo $child['eye_wear']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Hospitalization?</label>
                                            <div class="form-control"><?php echo $child['hospitalization']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Surgery?</label>
                                            <div class="form-control"><?php echo $child['surgery']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Frequent headaches?</label>
                                            <div class="form-control"><?php echo $child['frequent_headache']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Any head injury?</label>
                                            <div class="form-control"><?php echo $child['head_injury']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Being knocked unconscious?</label>
                                            <div class="form-control"><?php echo $child['knocked_unconscious']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Frequent ear infections?</label>
                                            <div class="form-control"><?php echo $child['ear_infections']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fainting during or after exercise?</label>
                                            <div class="form-control"><?php echo $child['excercise_fainting']=="1" ? "Yes" : "No";?></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Additional Information</label>
                                            <div class="form-control"><?php echo $child['additional_information'];?></div>
                                        </div>
                                    </div>

                                </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        


                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<style>
.panel .actions {top: 2px;}
.rwheader {
  background: #777777 none repeat scroll 0 0;
  border-bottom: 1px solid #cccccc;
  color: #ffffff !important;
  margin: 5px 20px 20px;
  overflow: hidden;
  padding: 10px;
}
.dtheader {
  border-bottom: 1px solid #cccccc;
  color: #ffffff !important;
  margin: 10px 10px 20px 10px;
  overflow: hidden;
  padding: 10px 5px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#campersPage").addClass("active");
});
$("#downloadBtn").click(function(){
    location.href = '<?php echo ADMIN_SITE_URL;?>download-childs-info.php?uid=<?php echo $_GET['id'];?>';
    return false;
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>