<?
include ("config.php");

//destroys the session, the variables are not longer set
session_start();
session_destroy();

$url = "http://www$domain/login.html";
$url = "login.html";
?>
<html>
<meta http-equiv="refresh" content="0;url=<?=$url ?>" >
</html>


