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
	//echo "". $debt_row['debt_tel']."<br>";
	//echo "". $debt_row['debt_mobile']."<br>";
    //echo "". $debt_row['debt_cust_address1']."<br>";
	//echo "". $debt_row['debt_cust_address2']."<br>";
	//echo "". $debt_row['debt_cust_address3']."<br>";
	//echo "". $debt_row['debt_post_co']."<br>";
     //$ship_row=getship_data($sale_ref);
    //echo "".$ship_row['check_shipping']."<br>";
	//echo getdate_data($sale_ref);
	//echo "<br><br>";
	 
// Email the new password to the person. 
  
//$to_string = iconv("UTF-8", "iso-8859-1", $e_message);

/*
   mail($_POST['member_email'],"Your Password for www.polygon-cafe.com", 
        $message, "From:Polygon <info@polygon-cafe.com>");
 */
///////////////////////mailer start
 require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                   // send via SMTP
//$mail->Host     = "mail.superior-autoparts.com"; // SMTP servers
$mail->SMTPAuth = true;     // turn on SMTP authentication
//$mail->helo = '';
//$mail->Username = "superior-autopartscom1";  // SMTP username
//$mail->Password = "info"; // SMTP password

$mail->Host     = "mail.can.com.hk"; // SMTP servers
$mail->Username = "cancomhk2";  // SMTP username
$mail->Password = "cancan"; // SMTP password


$mail->CharSet ="euc-jp";
$mail->From     = "newup5918@ybb.ne.jp";//
$mail->FromName = "Takamoto";
$mail->AddAddress($debt_email); 
//$mail->AddAddress("car_ins88jp@yahoo.co.jp"); 
//$mail->AddAddress("amen_htm@hotmail.com"); 
           // optional name
$mail->AddReplyTo("newup5918@ybb.ne.jp","Takamoto");


$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(true);                               // send as HTML

//$mail->Subject=iconv("UTF-8", "iso-8859-1","Your Password for www.polygon-cafe.com");
$getsprodrow = getsprod_data($sale_ref);
$mail->Subject=$sale_ref."  ".$getsprodrow["sprod_name"]." ".$getsprodrow["sprod_id"]; 

$mail->Body=$e_content;

$mail->AltBody="This is the text-only body";

if ($mail->Send())
{echo "";

if ($debt_row['debt_email_sent']=='')
{$sqla = "Insert into ben_debt SET debt_email_sent='1', debt_dat = curdate(), debt_ref= '".$sale_ref."'";}
else
{$sqla = "Update ben_debt SET debt_email_sent='1', debt_dat = curdate() where debt_ref= '".$sale_ref."'";}

//echo $sqla;
sqlinsert($sqla);

}
else {
echo $mail->ErrorInfo;

echo "false";}


///////////////////////mailer end 


	?></td>
      </tr>
      <tr>
        <td> <br><br><strong>Email Sent to <? echo $debt_email;?></strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</body>
</html>
