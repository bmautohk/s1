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
//$email_name=trim($_GET['email_name']); 
//$email_row=getdebtemail_data(trim($_GET['email_Id']));

?>
<html>
<head>
<? require ('header_script.php'); ?>
<title>Email Page</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
</head>

<body>
	 <form name="form1" method="get" action="ship_email.php">
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<?
	$e_message="";
	$ship_row=getship_data($sale_ref);
	
	//----------------update
	
	
	//----------------submit
		
	$email_text ="お世話になっております。<br>商品は問い合わせ番号 ";
	$email_text =$email_text. $ship_row['check_shipping']. " で香港から送りました。到着まで暫く待ってください。<br>";
	$email_text =$email_text."商品は日本に着いたら、日本の郵便ページ<a href=\"http://www.postjapanpost.jp/tsuiseki/index.html\">http://www.postjapanpost.jp/tsuiseki/index.html</a> <br>";
	$email_text =$email_text."のＥＭＳ欄で追跡ができます。日本にまだ着いてない時にHKの郵便郵便ページ<a href=\"http://app1.hongkongpost.com/CGI/mt/c_enquiry.jsp\">http://app1.hongkongpost.com/CGI/mt/c_enquiry.jsp</a> <br>";
	$email_text =$email_text."の確定欄で追跡ができます <br>";
	$email_text =$email_text."どうぞ宜しくお願いいたします。 <br><br><br>";
	$email_text =$email_text."小林 <br>";
	
	echo $email_text;
			
	$debt_row=getdebt_data($sale_ref);
	$sale_row = getsale_data($sale_ref);
	$debt_email = $sale_row['sale_email'];
	$debt_email2 = $sale_row['sale_email2'];
	
	//echo $debt_email;
	
	
	if (isset($_GET['issubmit']))
	{
	///////////////////////mailer start
 require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                   // send via SMTP
//$mail->Host     = "mail.superior-autoparts.com"; // SMTP servers
$mail->SMTPAuth = true;     // turn on SMTP authentication
//$mail->helo = '';
//$mail->Username = "superior-autopartscom1";  // SMTP username
//$mail->Password = "info"; // SMTP password

$mail->Host     = "mail.superior-autoparts.com"; // SMTP servers
$mail->Username = "superior-autopartscom1";  // SMTP username
$mail->Password = "benben"; // SMTP password

$mail->CharSet ="euc-jp";
$mail->From     = "info@superior-autoparts.com";//
$mail->FromName = $sale_group;
$mail->AddAddress($debt_email); 
if ($debt_email2!='')
{
$mail->AddAddress($debt_email2);
}
$mail->AddBCC ("info@superior-autoparts.com");

$mail->AddReplyTo($email_email,$email_name);


$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(true);                               // send as HTML

//$mail->Subject=iconv("UTF-8", "iso-8859-1","Your Password for www.polygon-cafe.com");
$getsprodrow = getsprod_data($sale_ref);
//$mail->Subject=$sale_ref."  ".$getsprodrow["sprod_name"]."発送"; //." ".$getsprodrow["sprod_id"]; 
$mail->Subject=$sale_ref."  ".$getsprodrow["sprod_name"]." 発送しました。"; //." ".$getsprodrow["sprod_id"]; 

$mail->Body=$email_text;

$mail->AltBody=$email_text;

if ($mail->Send())
{echo "Email sent";

}
else {
echo $mail->ErrorInfo;

echo "false";}


	}

	?> </td>
      </tr>
      <tr>
        <td>
          
          <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	</table>
	<br>
	<? if (isset($_GET['issubmit'])) {
	echo "Your email sent"; 
	 $db=connectDatabase();
	$sqlb = "insert ben_email_shipped set email_ref = '$sale_ref ', email_text = '$email_text', email_datetime=now()";
 sqlinsert($sqlb);
	
	} else {?>
	<input name="issubmit" type="submit" id="issubmit" value="Send Email"> 
	
	<? }?>
    
	<input name="sale_ref" type="hidden" id="sale_ref" value="<?=$sale_ref;?>">	
	
    <table width="700" border="0" cellspacing="0" cellpadding="0">
    </table>
	 </form>
</body>
</html>
