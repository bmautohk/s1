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
 
if (isset($_GET['sale_group'])){
$sale_group = $_GET['sale_group'];}

	if (isset($_POST['issubmit']))
    {

	$sale_group=$_POST['sale_group'];
	
	$email_txt=($_POST['email_txt']);	

	}
 
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

	
	
	
	
	//----------------update
	//if (isset($_POST['isupdate']))
	//{$email_txt=nl2br(($_POST['email_txt']));	}
	
	//----------------submit


	//$e_message = "Dear ". $sale_row['sale_name']."<br><br>";
	//$debt_email = $debt_row['debt_email'];
	//$e_message = $e_message . "Order No." . $sale_ref ."<br><br>";
	//$word_email = getsale_prod_email_1($sale_ref, $email_name);
	//$e_message = $word_email;
	//$email_wording = '';
	

	//$e_message = $e_message. $email_wording;
	//$e_content = $e_message;
    $db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$sub_total=0;
	$num_results=mysql_num_rows($result);
	$email_text = $email_text . "はじめまして ". $email_name."と申します<br>このたびは当方の商品を落札いただきありがとうございます。つきましては下<br>
記口座へお振り込みいただきましたら、確認次第発送手配させていただきます。 <br>なお、商品に関する内容はオークション記載の通りです。<br>十分ご納得の上でのお取引をお願いします。<br><br>";

	//$email_text = $email_text . "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	//$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,0,'.','');	
	$email_text = $email_text . "落札商品：".iconv("EUC-JP", "shift_jis",$sprod_name)."<br>"; //.$sprod_id."<br>";
	}
	
	$email_text = $email_text . "ヤフーID：　http://page8.auctions.yahoo.co.jp/jp/auction/".$sale_ref."<br>";
	$email_text = $email_text . "落札金額：".number_format($sprod_sub,0,'.','')."円+";
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	
	$total = number_format($sub_total-$sale_discount,0,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),0,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,0,'.','');
	$total_temp_ship_sub = $sprod_sub + $sale_ship_fee;
	$email_text = $email_text . "送料 ".number_format($sale_ship_fee,0,'.','')."円";
	
	$email_text = $email_text . "= ".number_format($total_temp_ship_sub,0,'.','')."円<br><br>";
	
	
		if ($sale_group!='')
	{
	if (!isset($_GET['outlook']))
	{
	 $email_txt=nl2br((getemail_txt_data($sale_group)));
	 } else
	 {
	 $email_txt=(getemail_txt_data($sale_group));
	 }
	 
	 }
	 
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
	$group_row=getgroup_sale_data($sale_ref);
	
	
	
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
//$mail->AddBCC ($group_row['email']);

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

if ($debt_row['debt_email_sent']=='')
{
$sqla = "Insert ben_debt SET debt_email_sent='1', debt_dat = now(), debt_ref= '".$sale_ref."'";
}
else
{
$sqla = "Update ben_debt SET debt_email_sent='1', debt_dat = now() where debt_ref= '".$sale_ref."'";
}
$sqlb = "insert ben_email set email_ref = '$sale_ref ', email_text = '$email_text', email_datetime=now()";
 

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
	
	<form name="form1" method="POST" action="debt_email_t.php">
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
