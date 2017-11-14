<?php
include('cnf.php');
require_once(LIB_PATH.'index-init.php');
include(LIB_HTML . 'header.php');
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.scrollTo.js"></script>
<!-- Main Container Starts -->
<div class="container">
    <?php include(LIB_HTML.'message.php');?>

    <!-- Welcome Section Starts -->
    <section class="welcome-area">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                
            </div>
            <div class="col-md-6 col-xs-12">
                
            </div>
        </div>
    </section>
    <!-- Welcome Section Ends -->
</div>
<!-- Main Container Ends -->

<script type="text/javascript">
$("#navServices").click(function() {
    $('html, body').animate({
        //scrollTop: $("#services").offset().top
    }, 2000);
});
$("#navSelection").click(function() {
    $('html, body').animate({
        //scrollTop: $("#selection").offset().top
    }, 2000);
});
$(document).ready(function() {

});

</script>
<?php include(LIB_HTML . 'footer.php');?>