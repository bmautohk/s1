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
<title>Print EMS</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<style type="text/css">
<!--
.style1 {font-size: 16px}
.style2 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>

<body>

	
	<?
	$debt_row=getdebt_data($sale_ref);
	$order_row=getsale_data($sale_ref);

     $ship_row=getship_data($sale_ref);
	 
	 $office_addr=getOfficeAddress($addr_id);
 
	?>
    <table width="711" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="23" height="29">&nbsp;</td>
        <td width="210"><span class="style2"><? echo "". $debt_row['debt_post_co'];?></span>
        <div align="right"></div></td>
        <td width="204"><span class="style2"><? echo "".$sale_ref;?></span></td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td height="78" colspan="2" ><span class="style2"><? echo "". $debt_row['debt_cust_address1'];?> <? echo "". $debt_row['debt_cust_address2'];?> <? echo "". $debt_row['debt_cust_address3'];?> Japan</span></td>
        <td colspan="4" valign="top"><? getsprod_ship_data($sale_ref); ?>&nbsp;<br>
        <span class="style2">Auto Parts</span></td>
      </tr>
      <tr>
        <td colspan="2"><span class="style2">
          <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>
        </span></td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="style2"><? echo "".$order_row['sale_name'];?> </td>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td height="26" colspan="2" class="style2">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="38">&nbsp;</td>
      <td width="76">&nbsp;</td>
      <td width="160">&nbsp;</td>
      </tr>
      <tr>
        <td class="style2">        ¢©</td>
        <td class="style2">&nbsp;</td>
        <td rowspan="4">&nbsp;</td>
        <td colspan="3" rowspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="style2"><?=$office_addr['address1']?> <?=$office_addr['address2']?> <?=$office_addr['address3']?><br>
</span></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;<span class="style2">Superior</span></td>
      </tr>
      <tr>
        <td colspan="2" class="style2">Tel: (852)98348574</td>
      </tr>
    </table>
<p>&nbsp; </p>
</body>
</html>
