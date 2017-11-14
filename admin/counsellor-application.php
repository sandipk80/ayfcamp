<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/counsellors/view-application-init.php');
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
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <!--<i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>-->
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="box row-fluid">
                                <div class="group-block topmarg20">Applicant Information</div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-4 col-md-4">
                                            <div class="thumbnail">
                                                <div class="thumb-wrapper">
                                                    <img alt="" src="<?php echo $id_photo;?>" class="img-responsive" id="imgArea" width="100%" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-8 col-md-8">
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td width="20%">First Name</td>
                                                    <td><?php echo $first_name;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Last Name </td>
                                                    <td><?php echo $last_name;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td><?php echo $gender=="F" ? "Female" : "Male";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Date of Birth</td>
                                                    <td><?php echo $date_of_birth!=='0000-00-00' ? date("m/d/Y", strtotime($date_of_birth)) : "";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email Address </td>
                                                    <td><?php echo $email;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Apt/Unit # </td>
                                                    <td><?php echo $apt_unit;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Address </td>
                                                    <td><?php echo $address;?></td>
                                                </tr>
                                                <tr>
                                                    <td>City </td>
                                                    <td><?php echo $city;?></td>
                                                </tr>
                                                <tr>
                                                    <td>State </td>
                                                    <td><?php echo $state;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Zip / Post Code </td>
                                                    <td><?php echo $zipcode;?></td>
                                                </tr>

                                                <tr>
                                                    <td>Primary Phone </td>
                                                    <td><?php echo $phone;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Secondary Phone </td>
                                                    <td><?php echo $phone2;?></td>
                                                </tr>
                                                <tr>
                                                    <td>T-shirt Size </td>
                                                    <td><?php echo $tshirt_size;?></td>
                                                </tr>
                                                <tr>
                                                    <td>AYF member? </td>
                                                    <td><?php echo $ayf_member=="1" ? "Yes" : "No";?></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Choose weeks you’re applying for (no consecutive weeks)</div>
                                            </div>

                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Preferred Week </td>
                                                    <td>
                                                        <?php
                                                        if(is_array($application['weeks']) && count($application['weeks'])>0){
                                                            foreach($application['weeks'] as $week){
                                                                if($week['is_alternate'] == "0"){
                                                                    echo $week['title'].' ('.date("m/d/Y", strtotime($week['start_from'])).' to '.date("m/d/Y", strtotime($week['end_at'])).')<br>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Alternate Choices and Availability </td>
                                                    <td>
                                                        <?php
                                                        if(is_array($application['weeks']) && count($application['weeks'])>0){
                                                            foreach($application['weeks'] as $week){
                                                                if($week['is_alternate'] == "1"){
                                                                    echo $week['title'].' ('.date("m/d/Y", strtotime($week['start_from'])).' to '.date("m/d/Y", strtotime($week['end_at'])).')<br>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Past Work History </div>
                                            </div>
                                            
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <?php
                                                if(is_array($application['works']) && count($application['works'])>0){
                                                    $w = 1;
                                                    foreach($application['works'] as $work){
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="blkhdr">Employer <?php echo $w;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Employer Name </td>
                                                    <td><?php echo $work['employer_name'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Dates </td>
                                                    <td><?php echo $work['dates'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Supervisor </td>
                                                    <td><?php echo $work['supervisor'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nature of Work </td>
                                                    <td><?php echo $work['work_nature'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Employer Address & Phone </td>
                                                    <td><?php echo $work['employer_info'];?></td>
                                                </tr>
                                                <?php
                                                    $w++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            </table>


                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">References </div>
                                            </div>

                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Reference 1 </td>
                                                    <td><?php echo $reference1;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Reference 2 </td>
                                                    <td><?php echo $reference2;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Reference 3 </td>
                                                    <td><?php echo $reference3;?></td>
                                                </tr>
                                            </tbody>
                                            </table>

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Emergency Contacts </div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Emergency Contact 1</td>
                                                    <td><?php echo $emergency_contact1;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Contact 2</td>
                                                    <td><?php echo $emergency_contact2;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Contact 3</td>
                                                    <td><?php echo $emergency_contact3;?></td>
                                                </tr>
                                            </tbody>
                                            </table>


                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Camp Experience </div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <?php
                                                if(is_array($application['experience']) && count($application['experience'])>0){
                                                    $e = 1;
                                                    foreach($application['experience'] as $experience){
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="blkhdr">Camp <?php echo $e;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Dates </td>
                                                    <td><?php echo $experience['dates'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Camp Name & Director </td>
                                                    <td><?php echo $experience['camp_name'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Camp Location </td>
                                                    <td><?php echo $experience['camp_locations'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Camper or Staff? </td>
                                                    <td><?php echo $experience['camper_or_staff'];?></td>
                                                </tr>
                                                <?php
                                                    $e++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            </table>
                                            

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Education (High School and Beyond)</div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <?php
                                                if(is_array($application['education']) && count($application['education'])>0){
                                                    $e = 1;
                                                    foreach($application['education'] as $education){
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="blkhdr">School <?php echo $e;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Years </td>
                                                    <td><?php echo $education['edu_year'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>School Name </td>
                                                    <td><?php echo $education['school_name'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Major </td>
                                                    <td><?php echo $education['major'];?></td>
                                                </tr>
                                                <tr>
                                                    <td>Degree Granted </td>
                                                    <td><?php echo $education['degree_granted'];?></td>
                                                </tr>
                                                <?php
                                                    $e++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            </table>

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Skills</div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Skills List</td>
                                                    <td><?php echo $skills;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Contributions at AYF Camp</td>
                                                    <td><?php echo $skills;?></td>
                                                </tr>
                                            </tbody>
                                            </table>

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Certifications</div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Certificate</td>
                                                    <td><?php echo $certificate;?></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <?php
                                                        if(is_array($application['education']) && count($application['education'])>0){
                                                            $e = 1;
                                                            foreach($application['education'] as $education){
                                                        ?>


                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>


                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Health History</div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Ever hospitalized?</td>
                                                    <td><?php echo $have_hospitalized=="1" ? "Yes" : "No";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Taking_medications</td>
                                                    <td><?php echo $taking_medications=="1" ? "Yes" : "No";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Medical restrictions?</td>
                                                    <td><?php echo $medical_conditions ? "Yes" : "No";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Explaination</td>
                                                    <td><?php echo $medical_condition_text;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Physician</td>
                                                    <td><?php echo $medical_condition_text;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Do smoke?</td>
                                                    <td><?php echo $do_smoke=="1" ? "Yes" : "No";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Handle not smoking</td>
                                                    <td><?php echo $handle_smoking;?></td>
                                                </tr>
                                                <tr>
                                                    <td>List medical conditions</td>
                                                    <td><?php echo $medical_condition_list;?></td>
                                                </tr>
                                            </tbody>
                                            </table>

                                            <div class="col-md-12">
                                                <div class="group-block topmarg20">Criminal Record</div>
                                            </div>
                                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                            <tbody>
                                                <tr>
                                                    <td>Convicted of a crime</td>
                                                    <td><?php echo $commited_crime ? "Yes" : "No";?></td>
                                                </tr>
                                                <tr>
                                                    <td>Explanation</td>
                                                    <td><?php echo $crime_explanations;?></td>
                                                </tr>
                                            </tbody>
                                            </table>

                                        </div>
                                        
                                    </div>
                                </div>


                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#counsellorsPage").addClass("active");
    
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>