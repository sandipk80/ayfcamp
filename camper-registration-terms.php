<?php

include('cnf.php');

################# CHECK LOGGED IN USER ##############

validateUserLogin();

################# END OF LOGGED IN CHECK ############

require_once(LIB_PATH.'users/camps/camper-registration-terms-init.php');

include(LIB_HTML . 'header.php');

?>

<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>

<script src="<?php echo SCRIPT_SITE_URL;?>additional-methods.js"></script>

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

                        for($s=2; $s<$step; $s++){

                        ?>

                        <div class="sf">

                            <span><?php echo $s;?></span> Camper <?php echo $s-1;?> Information

                        </div>

                        <?php

                        }

                        ?>

                        <div class="sf-active">

                            <span><?php echo $step;?></span> Camp Rules & Rock Climbing Waiver

                        </div>

                    </div>

                </div>

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

                <form id="frmCamperRules" class="contact-form" name="frmCamperRules" method="post" role="form">

                    <div class="row">

                        <div class="col-md-12">

                            <div class=""><h3>AYF Summer Camp Camper Rules & Regulations</h3></div>

                            <ul>

                                <li>Follow all directions given by the director(s) and counselors.</li>

                                <li>NO weapons (including Swiss Army Knives, etc.)</li>

                                <li>NO cigarettes, electronic cigarettes, alcoholic beverages, or drugs.</li>

                                <li>NO leaving the campgrounds.</li>

                                <li>NO food or beverages.</li>

                                <li>NO destruction or stealing other's property, including the touching of other's personal belongings without their permission.</li>

                                <li>NO fighting.</li>

                                <li>NO use of foul language.</li>

                                <li>NO vandalizing or destruction of camp property. (Parents will be liable for any damage done by their children).</li>

                                <li>NO writing on camp property (i.e. walls).</li>

                                <li>NO shaving cream.</li>

                                <li>NO phones.</li>

                                <li>NO electronic devices (stereos, iPods, iPads, etc.)</li>

                                <li>NO use of the pool without supervision.</li>

                                <li>Dispose of trash appropriately. You are responsible for the cleanliness of the facilities you are using. The cabins are to be swept and trash is to be emptied daily.</li>

                            </ul>

                            <div class="">Campers violating any of these rules and regulations can be sent home at the discretion of the director. Parents will be expected to pick up their child should any of these rules be broken.</div>



                            <div class="form-group">

                                <input type="checkbox" class="required" name="terms" id="terms" value="1" style="float:left;width:20px;">

                                Electronic Signature Agreement. By selecting the "I Accept" button, you are signing this Agreement electronically. You agree your electronic signature is the legal equivalent of your manual signature.

                            </div>



                            <h3>Waiver and Release of Liability for Rock Climbing at AYF Camp</h3>

                            <p><strong>WARNING:</strong> AYF Camp has taken reasonable steps to provide your child with appropriate equipment and/or skilled instructors so they can enjoy an activity for which they may not be skilled. We wish to remind you this activity is not without risk. Certain risks cannot be eliminated without destroying the unique character of the activity. The same elements that contribute to the unique character of the activity can be causes of accidental injury. It is important for you to know in advance what to expect and to be informed of the inherent risks.</p>



                            <p><strong>ACKNOWLEDGMENT OF RISKS:</strong> I acknowledge that the following describes some, but not all of the risks:<br>

                            1) Slips, trips or falls while climbing rock.<br>

                            2) Risk associated with climbing, or down climbing.<br>

                            3) Misuse of equipment or facilities.<br>

                            4) Abrasion from or entanglement with ropes or equipment.<br>

                            5) The presence, actions or falls of other participants. I understand the description of these risks is not complete and that other unknown or unanticipated risks may result in injury.

                            </p>

                            

                            <p><strong>ASSUMPTION OF RISK AND RESPONSIBILITY:</strong> In recognition of the inherent risks of the activity, my minor will engage in, I confirm that my child is physically and mentally capable of participating in the activity and/or using equipment. My child will participate willingly and voluntarily and I assume responsibility for damages.</p>



                            <p><strong>RELEASE:</strong> In consideration of services or property provided, my minor children for whom I am parent, legal guardian or otherwise responsible, any heirs, personal representatives or assigns, do hereby release Armenian Youth Federation Camp of California, its principals, directors, officers, agents, employees, and volunteers, and each and every land owner, municipal and/or governmental agency upon whose property an activity is conducted, from all liability and waive any claim for damage arising from any cause whatsoever (except that which is result of gross negligence).</p>



                            <p>Please read and initial each of the following Rules and Regulations.</p>



                            <p>The AYF Camp Rock Wall requires that a parent or legal guardian of a participant under the age of 18 initial for that participant, after thoroughly explaining the guidelines to their children.</p>



                            <div class="form-group">

                                <input type="checkbox" class="required" name="wear_helmet" id="wear_helmet" value="1" style="float:left;width:20px;">

                                I acknowledge and understand that all climbers must be required to wear a helmet.

                            </div>



                            <div class="form-group">

                                <input type="checkbox" class="required" name="under_supervision" id="under_supervision" value="1" style="float:left;width:20px;">

                                I acknowledge and understand that the AYF Camp Rock Wall may ONLY be used while under the supervision of AYF Camp staff members.

                            </div>



                            <div class="form-group">

                                <input type="checkbox" class="required" name="running_terms" id="running_terms" value="1" style="float:left;width:20px;">

                                I acknowledge and understand that there is no running, no horseplay, no foul or derogatory language, and no swinging on the ropes permitted near the AYF Camp Rock Wall.

                            </div>



                            <div class="form-group">

                                <input type="checkbox" class="required" name="deny_access" id="deny_access" value="1" style="float:left;width:20px;">

                                I acknowledge and understand that Armenian Youth Federation Camp of California has the right to deny access to its Rock Wall to any camper, permanently or for a specific period of time, for any failure to adhere to the Safety Guidelines and Regulations, or for any conduct that is viewed as unsafe, inappropriate, or unhealthy, including, but or limited to, horseplay or foul language.

                            </div>



                        </div>



                        <div class="col-xs-12 text-center">

                            <input type="hidden" name="camper-register" value="submit">

                            <input type="hidden" name="camp_id" value="<?php echo $registerId;?>">

                            <input type="hidden" name="step" value="<?php echo $step;?>">

                            <input type="submit" class="btn btn-black text-uppercase" value="Next">

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

    $("#frmCamperRules").validate();

});



</script>

<?php include(LIB_HTML . 'footer.php');?>