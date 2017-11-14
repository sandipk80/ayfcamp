<?php 
include('../cnf.php');
session_destroy();
if(isset($_COOKIE['wcookname']) && isset($_COOKIE['wcookpass'])){
    setcookie("wcookname", "", time()-60*60*24*100, "/");
    setcookie("wcookpass", "", time()-60*60*24*100, "/");
    setcookie("wcookuserid", "", time()-60*60*24*100, "/");
    setcookie("wcookname", "", time()-60*60*24*100, "/");
}
header("Location: ".COUNSELLOR_SITE_URL);
exit;
?>