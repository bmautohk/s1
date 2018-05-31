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
$sprod_no=$_GET['sprod_no'];
$sale_ref=$_GET['sale_ref'];
$sql = "delete from ben_sale_prod where sprod_no = $sprod_no";
sqlinsert($sql);

echo "<html><meta http-equiv='refresh' content='0; URL=order_edit.php?sale_ref=$sale_ref'></html>";
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
