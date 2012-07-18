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
.style2 {	font-size: 12px;
	font-weight: bold;
}
.small2 {
	FONT-SIZE: 9px
}
.style4 {font-size: 12; font-weight: bold; }
.style5 {font-size: 12px}
.style6 {font-size: 12px; font-weight: bold; }
.style9 {font-size: 12; font-weight: bold; }
.style11 {font-family: NW-7; font-size: 20px;}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>
<body>

	
	<?
	$debt_row=getdebt_data($sale_ref);
	$order_row=getsale_data($sale_ref);
	$ship_row=getship_data($sale_ref);
	?>
    <br>
    <br>	
<table width="600" border="0">
      <tr>
        <td width="300" valign="top"><table width="286" border="0" cellspacing="0" cellpadding="0">
          <tr valign="top">
            <td width="286" class="style2"> <div align="right"><span class="style6"> </span></div>              <div align="left"><span class="style4"><span class="style6">¢©<? echo "". $debt_row['debt_post_co'];?></span></span></div></td>
          </tr>
          <tr>
            <td class="style2">            <span class="style2"></span>        &nbsp;<? echo "". $debt_row['debt_cust_address1'];?></td>
          </tr>
          <tr>
            <td class="style2 style4"><? echo "". $debt_row['debt_cust_address2'];?></td>
          </tr>
          <tr>
            <td class="style2"><? echo "". $debt_row['debt_cust_address3'];?></td>
          </tr>
          <tr>
            <td class="style2"><? echo "". $order_row['sale_name'];?> ÕÕ</td>
          </tr>
          <tr>
            <td align="left" class="style2"><span class="style6"><span class="style4">
              <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>
            </span></span></td>
          </tr>
          <tr>
            <td class="style2"><span class="style6"><br>
            </span><span class="small2"><strong>594-0073<br>
¬Á∫Â…‹œ¬¿Ùª‘œ¬µ§ƒÆ 

2-3-2-1311<br>
≥§≈œπÒ∫›≥Ùº∞≤Òº“</strong></span><span class="style5"><br>
            </span><span class="style6"><br>
            <span class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?></span> <span class="small2">Group:
            <?=$order_row['sale_group']; ?>
            <br>
yahooID
<?=$order_row['sale_yahoo_id']; ?>
            </span> </span></td>
          </tr>
          <tr>
            <td class="style2"><span class="style5">
              </span>
              <table width="250" border="0">
                <tr>
                  <td><span class="style5">
                  </span></td>
                  <td><span class="style5">
                  </span></td>
                  <td><span class="style5"></span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="style2"><span class="style5">
            </span></td>
          </tr>
        </table></td>
        <td colspan="3" valign="top"><br>
          <br>          
          <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11" class="style2">
              <div align="left"></div></td>
            <td colspan="4" class="style2"><span class="style4"><span class="style6">¢©<? echo "". $debt_row['debt_post_co'];?></span></span></td>
          </tr>
          <tr>
            <td class="style2">&nbsp; </td>
            <td height="18" colspan="4" valign="top" class="style2"><span class="style4"><? echo "". $debt_row['debt_cust_address1'];?></span></td>
          </tr>
          <tr>
            <td class="style2 style5">&nbsp;</td>
            <td colspan="4" class="style2"><span class="style4"><? echo "". $debt_row['debt_cust_address2'];?></span></td>
          </tr>
          <tr>
            <td class="style2">&nbsp;</td>
            <td colspan="4" class="style2 style4"><span class="style4"><? echo "". $debt_row['debt_cust_address3'];?></span></td>
          </tr>
          <tr>
            <td align="right" class="style2">&nbsp;  </td>
            <td colspan="4" class="style2"><span class="style4"><? echo "". $order_row['sale_name'];?> ÕÕ</span></td>
          </tr>
          <tr>
            <td width="11" class="style2">&nbsp;</td>
            <td colspan="4" class="style2"><span class="style6"><span class="style4">
              <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>
            </span></span></td>
          </tr>
          <tr>
            <td colspan="5" class="style2">&nbsp;</td>
          </tr>
          <tr>
            <td class="style4"><em> <br>
            <br>
            </em></td>
            <td height="110" colspan="4" valign="top" class="style6"><span class="small2">594-0073<br>
¬Á∫Â…‹œ¬¿Ùª‘œ¬µ§ƒÆ 
2-3-2-1311<br>
≥§≈œπÒ∫›≥Ùº∞≤Òº“°°</span><br>

<span class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?></span>
<span class="small2">Group: <?=$order_row['sale_group']; ?><br>
yahooID <?=$order_row['sale_yahoo_id']; ?>
</span></td>
          </tr>
          <tr>
            <td colspan="5" class="style2">             </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td width="178"><div align="right"><span class="style6"><? echo "". $ship_row['check_shipping_jp'];?></span>&nbsp;</div></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>  <em></font></em></td>
            <td colspan="3" align="center" valign="middle"><span class="style11">a<? echo "". $ship_row['check_shipping_jp'];?>a</span><br>
              <span class="style6">a<? echo "". $ship_row['check_shipping_jp'];?>a</span>            <br>
            </td>
            <td width="83">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="75" valign="top"><br>  </td>
        <td height="50" colspan="3" valign="top"><br>  </td>
  </tr>
      <tr>
        <td valign="top"><table width="286" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="style6">
              <div align="left"></div>              <span class="style9">¢©<? echo "". $debt_row['debt_post_co'];?></span></td>
          </tr>
          <tr>
            <td height="18" colspan="2" class="style6"> <span class="style9"><? echo "". $debt_row['debt_cust_address1'];?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="style2 style5"><span class="style9"><? echo "". $debt_row['debt_cust_address2'];?></span></td>
          </tr>
          <tr>
            <td colspan="2" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address3'];?></span></td>
          </tr>
          <tr>
            <td colspan="2" align="right" class="style6"> <div align="left"><span class="style9"><? echo "". $order_row['sale_name'];?> ÕÕ</span></div></td>
          </tr>
          <tr>
            <td colspan="2" class="style6"><span class="style9">
              <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>
            </span></td>
          </tr>
          <tr>
            <td colspan="2" class="style6">&nbsp;</td>
          </tr>
          <tr align="left" valign="top">
            <td height="200" colspan="2" class="style9"><em> 
            </em><span class="small2">594-0073<br>
      ¬Á∫Â…‹œ¬¿Ùª‘œ¬µ§ƒÆ 2-3-2-1311<br>
      ≥§≈œπÒ∫›≥Ùº∞≤Òº“</span><br>
      <br>
      <span class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?></span> <span class="small2">Group:
      <?=$order_row['sale_group']; ?>
      <br>
yahooID
<?=$order_row['sale_yahoo_id']; ?>
      </span></td>
          </tr>
          <tr>
            <td colspan="2" class="style6"> </td>
          </tr>
          <tr>
            <td width="204" height="10"><div align="center"><span class="style11">a<? echo "". $ship_row['check_shipping_jp'];?>a</span> <br>
                 <span class="style6">a<? echo "". $ship_row['check_shipping_jp'];?>a</span><br>
            </div></td>
            <td width="82">&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="3" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" class="style6">
              <div align="left"></div></td>
            <td colspan="3" class="style6"><span class="style9">¢©<? echo "". $debt_row['debt_post_co'];?></span></td>
          </tr>
          <tr>
            <td class="style6">&nbsp; </td>
            <td height="18" colspan="3" valign="top" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address1'];?></span></td>
          </tr>
          <tr>
            <td class="style2 style5">&nbsp;</td>
            <td colspan="3" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address2'];?></span></td>
          </tr>
          <tr>
            <td class="style6">&nbsp;</td>
            <td colspan="3" class="style2 style4"><span class="style9"><? echo "". $debt_row['debt_cust_address3'];?></span></td>
          </tr>
          <tr>
            <td align="right" class="style6">&nbsp; </td>
            <td colspan="3" class="style6"><span class="style9"><? echo "". $order_row['sale_name'];?> ÕÕ</span></td>
          </tr>
          <tr>
            <td width="10" class="style6">&nbsp;</td>
            <td colspan="3" class="style6"><span class="style9">
              <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>
            </span></td>
          </tr>
          <tr>
            <td colspan="4" class="style6">&nbsp;</td>
          </tr>
          <tr>
            <td width="10" class="style9"><em> <br>
                  <br>
            </em></td>
            <td height="140" colspan="3" valign="top" class="style6"><span class="small2">594-0073<br>
      ¬Á∫Â…‹œ¬¿Ùª‘œ¬µ§ƒÆ 2-3-2-1311<br>
      ≥§≈œπÒ∫›≥Ùº∞≤Òº“°°</span><br>
      <br>
      <span class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?></span> <span class="small2">Group:
      <?=$order_row['sale_group']; ?>
      <br>
yahooID
<?=$order_row['sale_yahoo_id']; ?>
      </span></td>
          </tr>
          <tr>
            <td colspan="4" class="style6"> </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td width="132" colspan="2"><div align="left"><span class="style9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <? echo "". $ship_row['check_shipping_jp'];?></span></div></td>
          </tr>
          <tr>
            <td colspan="4"> <em></em></td>
          </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
