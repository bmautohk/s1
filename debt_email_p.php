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
<? $sale_ref = $_GET['sale_ref']; 
$email_name= trim($_GET['email_name']); 
?>
<html>
<head>
<? require ('header_script.php'); ?>
<title>Email Page</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</head>

<body>
	
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?
	$e_message="";
	$debt_row=getdebt_data($sale_ref);
	$sale_row = getsale_data($sale_ref);
	$debt_email = $sale_row['sale_email'];
	//$e_message = "Dear ". $sale_row['sale_name']."<br><br>";
	//$debt_email = $debt_row['debt_email'];
	//$e_message = $e_message . "Order No." . $sale_ref ."<br><br>";
	$word_email = getsale_prod_email_1($sale_ref, $email_name);
	$e_message = $word_email;
	$email_wording = '';
	
	//echo getsale_prod_email($sale_ref);
	$e_message = $e_message. $email_wording;
	$e_content = $e_message;
	//$e_message = $e_message. "</body></html>";
echo $e_content;



	?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</body>
</html>
