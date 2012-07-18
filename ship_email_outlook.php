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
	$e_message="";
	$ship_row=getship_data($sale_ref);
	
	//----------------update
	
	
	//----------------submit
		
	$email_text ="お世話になっております。<br>商品は問い合わせ番号 ";
	$email_text =$email_text. $ship_row['check_shipping']. " で香港から送りました。到着まで暫く待ってください。\n";
	$email_text =$email_text."商品は日本に着いたら、日本の郵便ページ<a href=\"http://www.postjapanpost.jp/tsuiseki/index.html\">http://www.postjapanpost.jp/tsuiseki/index.html</a> \n";
	$email_text =$email_text."のＥＭＳ欄で追跡ができます。日本にまだ着いてない時にHKの郵便郵便ページ<a href=\"http://app1.hongkongpost.com/CGI/mt/c_enquiry.jsp\">http://app1.hongkongpost.com/CGI/mt/c_enquiry.jsp</a> \n";
	$email_text =$email_text."の確定欄で追跡ができます \n";
	$email_text =$email_text."どうぞ宜しくお願いいたします。 \n\n\n";
	$email_text =$email_text."小林 \n";
	
	
	
	$debt_row=getdebt_data($sale_ref);
	$sale_row = getsale_data($sale_ref);
	$debt_email = $sale_row['sale_email'];
	$debt_email2 = $sale_row['sale_email2'];
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
	 <form action="mailto:<? echo $debt_email; ?>?subject=<? echo $sale_ref."  ".$getsprodrow["sprod_name"]." 発送しました。"; ?>" method="post" enctype="text/plain">
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <textarea name="=======================" cols="250" style="width:300px;height:200px;overflow:auto">

<? echo $email_text;?></textarea>		
<br>


</td>
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
	<input type="submit" id="issubmit" value="Send Email"> 
	
	<? }?>
    
	
	
    <table width="700" border="0" cellspacing="0" cellpadding="0">
    </table>
	 </form>
</body>
</html>
