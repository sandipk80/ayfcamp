<?php 
include('../cnf.php');
session_destroy();

header("Location: ".ADMIN_SITE_URL);
exit;
?>