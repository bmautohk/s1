<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('config.php');  //this should the the absolute path to the config.php file 
                                    //(ie /home/website/yourdomain/login/config.php or 
                                    //the location in relationship to the page being protected - ie ../login/config.php )
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above

if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
exit;
}
?>
<?

$sale_ref=$_GET['sale_ref'];
$sql1= "delete from ben_bal where bal_ref = '$sale_ref'";
$sql2= "delete from ben_check where check_ref = '$sale_ref'";
$sql3= "delete from ben_debt where check_debt = '$sale_ref'";
$sql4= "delete from ben_email where email_ref = '$sale_ref'";
$sql5= "delete from ben_email_shipped where email_ref = '$sale_ref'";
$sql6= "delete from ben_return where return_ref = '$sale_ref'";
$sql7= "delete from ben_return_photo where return_ref = '$sale_ref'";
$sql8= "delete from ben_sale where sale_ref = '$sale_ref'";
$sql9 = "delete from ben_sale_prod where sprod_ref = '$sprod_ref'";

sqlinsert($sql1);
sqlinsert($sql2);
sqlinsert($sql3);
sqlinsert($sql4);
sqlinsert($sql5);
sqlinsert($sql6);
sqlinsert($sql7);
sqlinsert($sql8);
sqlinsert($sql9);




//echo "<html><meta http-equiv='refresh' content='0; URL=order_edit.php?sale_ref=$sale_ref'></html>";
echo "You order deleted."	;
	exit; 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<? require ('header_script.php');?>
<title>無標題文件</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</head>

<body>
</body>
</html>
