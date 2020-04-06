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
if (isset($_GET['prod_id']))
{$prod_id = $_GET['prod_id'];} else {$prod_id='';}

if (isset($_GET['prod_sel']))
{$prod_sel = $_GET['prod_sel'];} else {$prod_sel='';}

if (isset($_GET['cust_cd']))
{$sale_group = $_GET['cust_cd'];} else {$cust_cd='';}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
<script type="text/javascript" src="calendarDateInput.js">
</script>
<script type="text/javascript">
function updateARPORT(prod_id,prod_name,product_price)
{
	opener.document.form1.sprod_id_<?= $prod_sel;?>.value=prod_id;
	opener.document.form1.sprod_name_<?= $prod_sel;?>.value=prod_name;
	opener.document.form1.sprod_price_<?= $prod_sel;?>.value=product_price;

	// Calculate product's stock (for Order Add only)
	opener.getProductStock(<?= $prod_sel?>, prod_id);
	
	window.close();
}
</script>

<LINK href="style1.css" type=text/css rel=STYLESHEET>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="MSHTML 6.00.2900.2722" name=GENERATOR>
</HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="20" marginwidth="20">
<TABLE height="100%" cellPadding=10 width="100%" border=0>
  <TBODY>
  <TR>
    <TD width="104%" height="100%" vAlign=top bgColor=#eefafc>  
	    <form name="search" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?prod_id=<?= $prod_id;?>&prod_sel=<?= $prod_sel;?>">
        <strong>Fill in a Product ID </strong><br>
        <input name="prod_id" type="text" id="prod_id" value="<? echo $prod_id;?>">
        <input type="submit" name="Submit" value="search">
		<input type="hidden" name="prod_sel" value="<?= $prod_sel;?>">
		<input type="hidden" name="cust_cd" value="<?= $cust_cd;?>">
        <br>
        <br>
        <br>
        <?
		if ($prod_id!='') 
		getFind_prodWithPrice($prod_id, $cust_cd);?>
		</form>
																
																</TD>
  </TR></TBODY></TABLE>
</BODY></HTML>
