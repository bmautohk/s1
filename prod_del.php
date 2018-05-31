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
$product_id=$_GET['product_id'];

	$db=connectDatabase();
	mysql_select_db(MAIN_DB,$db);
	$result = mysql_query("SELECT * FROM ben_product where product_id = '$product_id'",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	$product_name=$row["product_name"];
	$product_photo=$row["product_photo"];
	$product_dit=$row["product_dit"];
	$pro_image = "pro_image/".$product_photo;
	$pro_dit = "dit_file/".$product_dit;
	
	if ($product_photo!=''){unlink($pro_image);}
	
	if ($product_dit!=''){unlink($pro_dit);}
	

$sql = "delete from ben_product where product_id = '$product_id'";
sqlinsert($sql);

//echo $sql;

echo "<html><meta http-equiv='refresh' content='0; URL=prod_list.php'></html>";
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
