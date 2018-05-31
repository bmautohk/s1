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

//if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
//include ('http://www.superior-autoparts.com/no_access.html'); //this should the the absolute path to the no_access.html file - see above
//exit;
//}
?>
<? 
if (isset($_GET['sale_ref'])){
$sale_ref = $_GET['sale_ref'];}

if (isset($_POST['sale_ref'])){
$sale_ref = $_POST['sale_ref'];}
 
 if (isset($_GET['group3'])){
$group3 = $_GET['group3'];}

if (isset($_GET['group3'])){
$group3 = $_GET['group3'];}
 
//$email_name=trim($_GET['email_name']); 
//$email_row=getdebtemail_data(trim($_GET['email_Id']));

?>
<html>
<head>

<title>Email Page</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">

</head>

<body>
	
	<table width="700" border="0">
      <tr>
        <td><?
	$e_message="";
	$debt_row=getdebt_data($sale_ref);
    $sale_row=getsale_data($sale_ref);
	$group_row=getgroup_sale_data($sale_ref);
	
	//----------------update
	//if (isset($_POST['isupdate']))
	//{$email_txt=nl2br(($_POST['email_txt']));	}
	
	//----------------submit
	if (isset($_POST['issubmit']))
    {

	
	
	$email_txt=($_POST['email_txt']);	

	}

	
    $db=connectDatabase();
	mysql_select_db(MAIN_DB,$db);
	
	$sub_total=0;
	
	//$email_text = $email_text . "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	//$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$email_text = $sale_row["sale_yahoo_id"]. " 様；<br>";
	$email_text = $email_text . "ご入金有難うございます；<br>
これから商品発送の手配をいたします。<br>
発送後、問い合わせ番号をメールで知らせ致します。<br>
どうぞ宜しくお願い致します。<br>";

$email_text = $email_text . $sale_row["sale_group"];
	
	
	
	$email_txt = iconv("EUC-JP", "shift_jis",$email_txt);
	//$email_txt = mb_convert_encoding($email_txt, "EUC-JP", "auto");
	$email_text = $email_text . $email_txt."<br>";  
	if (!isset($_GET['outlook']))
	{
	echo $email_text;
	}
	else 
	{
	$email_text= str_replace("<br>", "\n", $email_text);
	

	}

///////////////////////mailer end 
	
	$debt_row=getdebt_data($sale_ref);
	$sale_row = getsale_data($sale_ref);
	$debt_email = $sale_row['sale_email'];
	$debt_email2 = $sale_row['sale_email2'];
	
	
	
	
	if (isset($_POST['issubmit']))
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

$mail->CharSet ="shift_jis";
$mail->From     = $group_row['email'];//
$mail->FromName = $sale_group;
$mail->AddAddress($debt_email);

if ($debt_email2!='')
{
$mail->AddAddress($debt_email2);
}


$mail->AddBCC ("info@superior-autoparts.com");
$mail->AddBCC ($group_row['email']);
//$mail->AddAddress("car_ins88jp@yahoo.co.jp"); 
//$mail->AddAddress("amen_htm@hotmail.com"); 
           // optional name
$mail->AddReplyTo($email_email,$email_name);


$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(true);                               // send as HTML

//$mail->Subject=iconv("UTF-8", "iso-8859-1","Your Password for www.polygon-cafe.com");
$getsprodrow = getsprod_data($sale_ref);
$mail->Subject=iconv("EUC-JP", "shift_jis",$sale_ref."  ".$getsprodrow["sprod_name"]); //." ".$getsprodrow["sprod_id"]; 

$mail->Body=$email_text;

$mail->AltBody=$email_text;

if ($mail->Send())
{echo "";


 

//echo $sqlb;
sqlinsert($sqla);
sqlinsert($sqlb);

}
else {
echo $mail->ErrorInfo;

echo "false";}


	}

	?></td>
      </tr>
    </table>
    <br>	 
    <? if (!isset($_GET['outlook']))
	{
	 ?>
	
	<form name="form1" method="POST" action="balance_email.php">
	 <? }else { ?>
	  <form action="mailto:<? echo $debt_email; ?>?subject=<? echo $sale_ref."  ".$getsprodrow["sprod_name"]." "; ?>" method="post" enctype="text/plain">
	          <textarea name="=======================" cols="350" style="width:300px;height:200px;overflow:auto">

<? echo $email_text;?></textarea>		
	 <? } ?>

<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;		</td>
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
	<? if (isset($_POST['issubmit'])) {echo "Your email sent"; } else {
	
	if (!isset($_GET['outlook']))
	{
	echo "<input name=\"issubmit\" type=\"submit\" value=\"Send Email\">"; 
	echo "<input name=\"sale_ref\" type=\"hidden\" value=\"$sale_ref\">";	
    echo "<input name=\"email_txt\" type=\"hidden\" value=\"$email_txt\">"; 
	echo "<input name=\"sale_group\" type=\"hidden\" value=\"$sale_group\"> ";   
	
	} else
	{
	echo "<input name=\"isoutlook\" type=\"submit\" value=\"Send Outlook Email\">"; 
	
	}
	
	
     }?>
    

	
	<table width="700" border="0" cellspacing="0" cellpadding="0">
    </table>
</form>
</body>
</html>
