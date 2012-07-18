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
<title>Print Parcel</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<style type="text/css">
<!--
.style2 {	font-size: 14px;
	font-weight: bold;
}
.style4 {font-size: 12; font-weight: bold; }
.style5 {font-size: 12px}
.style6 {font-size: 12px; font-weight: bold; }
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>

<body>

	
	<?
	$debt_row=getdebt_data($sale_ref);
	$order_row=getsale_data($sale_ref);

	$office_addr=getOfficeAddress($addr_id);
	?>
    <table width="567" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="18">&nbsp;</td>
        <td colspan="2" class="style2"><span class="style6">Superior</span> 
        <br></td>
        <td width="260" class="style2"><span class="style6"><? echo "". $sale_ref;?>        </span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="style2"><span class="style6" ><?=$office_addr['address1']?> <?=$office_addr['address2']?> <?=$office_addr['address3']?></span> </td>
        <td rowspan="2" valign="top" class="style2"><? getsprod_ship_data($sale_ref); ?>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="style2 style5">Tel: (852)98348574</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2"><? echo "". $order_row['sale_name'];?> <span class="style2">ÍÍ&nbsp;&nbsp;</span> <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2"><? echo "". $debt_row['debt_cust_address1'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2"><? echo "". $debt_row['debt_cust_address2'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="245" class="style2"><? echo "". $debt_row['debt_cust_address3'];?> Japan</td>
        <td colspan="2" class="style2">¢© <? echo "". $debt_row['debt_post_co'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2">&nbsp; </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="style2"><span class="style2">Auto Parts</span></td>
      </tr>
    </table>
<p>&nbsp; </p>
</body>
</html>
