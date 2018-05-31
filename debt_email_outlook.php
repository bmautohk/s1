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

if (isset($_GET['sale_ref'])){
$sale_ref = $_GET['sale_ref'];}

if (isset($_POST['sale_ref'])){
$sale_ref = $_POST['sale_ref'];}

	$e_message="";
	$debt_row=getdebt_data($sale_ref);
	if ($_GET['sale_group']!='')
	{$sale_group=$_GET['sale_group'];
	 $email_txt=getemail_txt_data($sale_group);}
		
	if (isset($_POST['issubmit']))
    {
	$sale_group=$_POST['sale_group'];
	$email_txt=($_POST['email_txt']);	
	}
	//----------------update
	
	
	//----------------submit
		
	   $db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$sub_total=0;
	$num_results=mysql_num_rows($result);
	$email_text = $email_text . "はじめまして ". $email_name."と申します<br>このたびは当方の商品を落札いただきありがとうございます。つきましては下\n
記口座へお振り込みいただきましたら、確認次第発送手配させていただきます。 <br>なお、商品に関する内容はオークション記載の通りです。<br>十分ご納得の上でのお取引をお願いします。\n\n";

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
	$email_text = $email_text . "落札商品：".$sprod_name."\n"; //.$sprod_id."<br>";
	}
	
	$email_text = $email_text . "ヤフーID：　http://page8.auctions.yahoo.co.jp/jp/auction/".$sale_ref."\n";
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
	
	$email_text = $email_text . "= ".number_format($total_temp_ship_sub,0,'.','')."円\n";
	$email_text = $email_text . $email_txt."\n";  
	
	
	
	
	$debt_row=getdebt_data($sale_ref);
	$sale_row = getsale_data($sale_ref);
	$debt_email = $sale_row['sale_email'];
	//$debt_email2 = $sale_row['sale_email2'];
	$getsprodrow = getsprod_data($sale_ref);
$debt_email = "amen_htm@hotmail.com";


?>
<html>
<head>
<? require ('header_script.php'); ?>
<title>Email Page</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
</head>

<body>
	 <form action="mailto:<? echo $debt_email; ?>?subject=<? echo $sale_ref."  ".$getsprodrow["sprod_name"]." "; ?>" method="post" enctype="text/plain">
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <textarea name="=======================" cols="350" style="width:300px;height:200px;overflow:auto">

<? echo $email_text;?></textarea>		
<br>


</td>
      </tr>
      <tr>
        <td>
          
         <? echo $debt_email; ?>
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
	<input type="submit" id="issubmit" value="Send Email"> 
	
	<? }?>
    
	
	
    <table width="700" border="0" cellspacing="0" cellpadding="0">
    </table>
	 </form>
</body>
</html>
