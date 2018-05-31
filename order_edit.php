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


if (isset($_POST['isupdate']))
{ 
$sale_ref = trim($_POST['sale_ref']);
$sql = "update ben_sale SET 
		 sale_group = '".trim($_POST['sale_group'])."',
		 sale_email = '".trim($_POST['sale_email'])."',
		 sale_name = '".trim($_POST['sale_name'])."',
		 sale_yahoo_id = '".trim($_POST['sale_yahoo_id'])."',
		 sale_ship_fee = ".trim($_POST['sale_ship_fee']).",
		 sale_discount = ".trim($_POST['sale_discount']).",
		 sale_tax = ".trim($_POST['sale_tax']).",
		 sale_date = '".trim($_POST['orderdate'])."',
		 sale_dat = curdate() where sale_ref = '$sale_ref'";
		 
sqlinsert($sql);
$sale_row = getsale_data($sale_ref);
$sale_group = $sale_row['sale_group'];
$sale_email = $sale_row['sale_email'];
$sale_name = $sale_row['sale_name'];
$sale_yahoo_id = $sale_row['sale_yahoo_id'];
$sale_ship_fee = $sale_row['sale_ship_fee'];
$sale_discount = $sale_row['sale_discount'];
$sale_tax = $sale_row['sale_tax'];
$sale_date = $sale_row['sale_date'];
//echo $sql;
echo "<html><meta http-equiv='refresh' content='0; URL=order_edit.php?sale_ref=$sale_ref'></html>";
	exit; 
}

if (isset($_GET['sale_ref']) or isset($_POST['isfind'])) 
{
if (isset($_GET['sale_ref'])) {$sale_ref = trim($_GET['sale_ref']);}
//if (isset($_POST['isfind'])) {$sale_ref = $_POST['sale_ref'];}
$sale_row = getsale_data($sale_ref);
$sale_group = $sale_row['sale_group'];
$sale_email = $sale_row['sale_email'];
$sale_name = $sale_row['sale_name'];
$sale_yahoo_id = $sale_row['sale_yahoo_id'];

$sale_ship_fee = $sale_row['sale_ship_fee'];
$sale_discount = $sale_row['sale_discount'];
$sale_tax = $sale_row['sale_tax'];
$sale_date = $sale_row['sale_date'];

}
if (isset($_POST['isadd'])){
$sqla = "INSERT INTO ben_sale_prod SET
		 sprod_ref = '$sale_ref',
		 sprod_id = '".trim($_POST['sprod_id_1'])."',
		 sprod_name = '".trim($_POST['sprod_name_1'])."',
		 sprod_price = ".trim($_POST['sprod_price_1']).", 
		 sprod_unit = ".trim($_POST['sprod_unit_1']); 
		 
sqlinsert($sqla);
}

if (isset($_POST['isfindadd']))
{
$sprod_opt = $_POST['sprod_opt'];
$sprod_id_t = "sprod_id_".$sprod_opt;
$sprod_name_t = "sprod_name_".$sprod_opt;
$sprod_price_t = "sprod_price_".$sprod_opt;
$sprod_unit_t = "sprod_unit_".$sprod_opt;

$sqla = "INSERT INTO ben_sale_prod SET
		 sprod_ref = '$sale_ref',
		 sprod_id = '".trim($_POST[$sprod_id_t])."',
		 sprod_name = '".trim($_POST[$sprod_name_t])."',
		 sprod_price = ".trim($_POST[$sprod_price_t]).", 
		 sprod_unit = ".trim($_POST[$sprod_unit_t]); 
		 
sqlinsert($sqla);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function checkFields() {
missinginfo = "";
if (document.form1.sale_name.value == "") {
missinginfo += "\n     -  Name";
}


//if (document.form1.sprod_id_1.value == "") {
//missinginfo += "\n     -  Product id <?=$m?>";}
//if (document.form1.sprod_name_1.value == "") {
//missinginfo += "\n     -  Product Name <?=$m?>";}
//if (document.form1.sprod_unit_1.value == "") {
//missinginfo += "\n     -  Product Unit <?=$m?>";}
//if (document.form1.sprod_price_1.value == "") {
//missinginfo += "\n     -  Product Price <?=$m?>";}



//if ((document.form1.sale_email.indexOf('@') == -1) || (document.form1.sale_email.indexOf('.') == -1)) 
//{missinginfo += "\n     -  Email address";}


if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}
else return true;
}
//  End -->
</script>

<script type="text/javascript" src="calendarDateInput.js">
</script>
<SCRIPT>
	function confirmDelete(id, ask, url) //confirm order delete
	{
		temp = window.confirm(ask);
		if (temp) //delete
		{
			window.location=url+id;
		}
	}
	function open_window(link,w,h)
	{
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	}
</SCRIPT>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<META content="MSHTML 6.00.2900.2722" name=GENERATOR>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<?
 //echo $sqla."<br>";
// echo $sql."<br>";

?>
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD background="admin_head_bg.gif" colSpan=5 
    height=34>&nbsp;&nbsp;<A class=big 
      href="http://www.apmzone.com/shop/admin.php"><B>Administrative 
      tools</B></A> (<A 
      href="logout.php">Logout</A>)</TD>
    <TD vAlign=top align=right 
    background="admin_head_bg.gif" 
      height=34>&nbsp;<A href="http://www.apmzone.com/shop/index.php">Main page</A></TD>
  </TR>
  <TR>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1_h.gif" 
            width=5 height="39"></TD>
          <TD background="admin_menu_3_h.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="order_main.php">Order</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2_h.gif" width="6" height="39"></TD>
        </TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1.gif" 
            width=5></TD>
          <TD background="admin_menu_3.gif">
            <TABLE width="85" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="prod_list.php">Product List</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1.gif" 
            width=5></TD>
          <TD background="admin_menu_3.gif">
            <TABLE width="78" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="./admin/adminpage.php">User Page</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD width="26"><IMG 
        src="admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1.gif" 
            width=5></TD>
          <TD background="admin_menu_3.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="report.php">Report</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#E1F0F6>&nbsp;      </TD>
    <TD width="99%" background="admin_menu_bg.gif" 
    height=39>&nbsp;</TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><TABLE width="358" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="265"><span class="style1 style1"><a href="order_add.php" class="big">Add New sales </a></span></TD>
                <TD width="45">&nbsp;</TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            
            <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']."?sale_ref=".$sale_ref; ?>" onSubmit="return checkFields();">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td valign="top">
                    <br>
                    <table width="338" height="224" border="1" cellpadding="0" cellspacing="0">
        <tr align="right">
          <td width="140" align="left">Sales Date: </td>
          <td colspan="2"><script>DateInput('orderdate', true, 'YYYY-MM-DD', '<? echo $sale_date;?>')</script></td>
        </tr>
        <tr align="right">
          <td align="left">Order No. </td>
          <td colspan="2"><? echo $sale_ref?></td>
        </tr>
        <tr align="right">
          <td align="left">Client Name </td>
          <td colspan="2"><input name="sale_name" type="text" value="<? echo $sale_name;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Client Email</td>
          <td colspan="2"><input name="sale_email" type="text" value="<? echo $sale_email;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Client Yahoo ID </td>
          <td colspan="2"><input name="sale_yahoo_id" type="text" value="<? echo $sale_yahoo_id;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Sales Group</td>
          <td colspan="2"><input name="sale_group" type="text" value="<? echo $sale_group;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Shipping fee :</td>
          <td width="96">&yen;            </td>
          <td width="94"><div align="left">
            <input name="sale_ship_fee" type="text" id="sale_ship_fee" value="<? echo $sale_ship_fee;?>" size="10" maxlength="10">
          </div></td>
        </tr>
        <tr align="right">
          <td align="left">Discount:</td>
          <td>&yen;</td>
          <td><div align="left">      <input name="sale_discount" type="text" value="<? echo $sale_discount;?>" size="10" maxlength="10">
          </div></td>
        </tr>
        <tr align="right">
          <td align="left">Tax :</td>
          <td>&nbsp;            </td>
          <td><div align="left">
          <input name="sale_tax" type="text" id="sale_tax" value="<? echo $sale_tax;?>" size="10" maxlength="10">
          %</div></td>
        </tr>
      </table>
      <br>

      <table width="305" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right"><br>
              <input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
              <input name="isupdate" type="submit" id="isdis" value="Update">
            
          </td>
        </tr>
      </table>
      <br>
      
     
	   
	 
	  
	 
	
	
            <? 
	 if ($sale_ref!='')
	 getedit_list($sale_ref); 
	 ?>
            <br>
            <br>



      <br>
      <table width="654" border="1" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC">
          <td width="213"><div align="center">Product No. </div></td>
          <td width="162"><div align="center">Products Name</div></td>
          <td width="82"><div align="center">Qty Unit</div></td>
          <td width="117"><div align="center">Unit Price </div></td>
          <td width="68"><div align="center">&nbsp; </div></td>
        </tr>
        <tr>
          <td><div align="center">
              <input name="sprod_id_1" type="text" id="sprod_id_1">
              <input name="isfind" type="button" id="isfind" value="Find" onClick="window.open('order_find_product.php?prod_sel=1','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');">
</div></td>
          <td><div align="center">
            <input name="sprod_name_1" type="text" id="sprod_name_1">
          </div></td>
          <td>
                <div align="center">
                  <input name="sprod_unit_1" type="text" id="sprod_unit_1" size="3" maxlength="2">
              </div></td>
          <td> <div align="center">&yen;
                      <input name="sprod_price_1" type="text" id="sprod_price_1" size="7" maxlength="7">
          </div></td>
          <td>
                <div align="center">
                  <input type="submit" name="isadd" value="Add">
              </div></td></tr>
      </table>
      <br>
      <br>
     
	 <? 
	 if ($sprod_id!='' and isset($_POST['isfind']))
	 getprodlike_list($sprod_id); 
	 ?>
</td>
                </tr>
              </table>
      
            <br>
            <br><br>
              <p>&nbsp;              </p>
            </form> 
          
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
