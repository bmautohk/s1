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
<? $sale_ref = $_GET['sale_ref']; ?>

<html>
<head>
<? require ('header_script.php');?>
<title>Print AIr Mail</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<style type="text/css">
<!--
.style1 {font-size: 24px}
.barcode {

font-family: C39HrP24DhTt;
font-size: 30px;
}

-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>

<body>
<p class="style1">&nbsp; 
	<? 
	//echo "Order No. :".$sale_ref."<br>";
	//echo "Sale Date: ";
	//echo getdate_data($sale_ref);
	echo "<br>";
	?>
	
	<?
	$debt_row=getdebt_data($sale_ref);
	$order_row=getsale_data($sale_ref);
	echo "". $order_row['sale_name']."<br>";
	//echo "". $debt_row['debt_tel']."<br>";
	//echo "". $debt_row['debt_mobile']."<br>";
    echo "". $debt_row['debt_cust_address1']."<br>";
	echo "". $debt_row['debt_cust_address2']."<br>";
	echo "". $debt_row['debt_cust_address3']."<br>";
	echo "Japan <br>";
	
	echo "¢©". $debt_row['debt_post_co']."<br>";
   
 	$ship_row=getship_data($sale_ref);
    //echo "".$ship_row['check_shipping']."<br>";
	//echo getdate_data($sale_ref);
	echo "<br><br>";
	//getsale_prod($sale_ref); 
	?>
    <br>
	<br>
<br>
<br>
<br>
<br>
<br>

</p>
    <?  echo "Order No: ". $sale_ref." <span class=\"barcode\">*". $sale_ref."*</span>";
	getsale_prod($sale_ref); ?>

</body>
</html>
