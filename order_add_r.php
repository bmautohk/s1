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
if (isset($_GET['sale_ref']))
{
   	$sale_ref = $_GET['sale_ref'];
   	
	
}

$sale_order_no_message = '';
if (isset($_GET['mod'])) {
if ($_GET['mod']=='same_ref')
$sale_order_no_message = "<font color=red>Please, insert different Order No.</font>";
}

//add new order
if (isset($_POST['isorder']))
{
if (!isset($_POST['sale_ref'])) {
if (isset($_POST['sale_ref_a']))
{
if ($_POST['sale_ref_a']=="a")
	{$sale_ref=$_POST['sale_ref_aa'];
		if (getsale_data($sale_ref)!='')
			{ 
			echo "<html>
<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['PHP_SELF']."?mod=same_ref\"></html>";
			
			exit;
			}
			
	 $sale_chk_ref = 0;
	 }
	 
if 	($_POST['sale_ref_a']=="b") 
	{$sale_ref=$_POST['sale_ref_bb'];
	$sale_chk_ref = 1;
	}	 
	 }
		} else {$sale_ref=$_POST['sale_ref'];}
		
		$sql = "INSERT INTO ben_sale SET
		 sale_ref = '$sale_ref',
		 sale_date = '".$_POST['orderdate']."',
		 sale_group = '".$_POST['sale_group']."',
		 sale_dat = curdate(), 
		 sale_chk_ref = $sale_chk_ref";
		 sqlinsert($sql);
}
// insert product
if (isset($_POST['isadd'])) {
$sqla = "INSERT INTO ben_sale_prod SET
		 sprod_ref = '$sale_ref',
		 sprod_id = '".$_POST['sprod_id']."',
		 sprod_name = '".$_POST['sprod_name']."',
		 sprod_price = ".$_POST['sprod_price'].", 
		 sprod_unit = ".$_POST['sprod_unit']; 
		 
sqlinsert($sqla);
}

// insert find products 
if (isset($_POST['isfindadd']))
{

$sprod_opt = $_POST['sprod_opt'];
$sprod_id_t = "sprod_id_".$sprod_opt;
$sprod_name_t = "sprod_name_".$sprod_opt;
$sprod_price_t = "sprod_price_".$sprod_opt;
$sprod_unit_t = "sprod_unit_".$sprod_opt;

$sqla = "INSERT INTO ben_sale_prod SET
		 sprod_ref = '$sale_ref',
		 sprod_id = '".$_POST[$sprod_id_t]."',
		 sprod_name = '".$_POST[$sprod_name_t]."',
		 sprod_price = ".$_POST[$sprod_price_t].", 
		 sprod_unit = ".$_POST[$sprod_unit_t]; 
		 
sqlinsert($sqla);
}

// add discount
if (isset($_POST['isdis']))
{

$sqldis="update ben_sale set 
		sale_ship_fee = ".$_POST['sale_ship_fee'].",
		sale_tax = ".$_POST['sale_tax'].",
		sale_discount = ".$_POST['sale_discount']." where sale_ref = '".$sale_ref."'";
sqlinsert($sqldis); 

}
if (isset($_GET['sale_ref']))
{
	$sale_row=getsale_data($sale_ref);
   	$sale_date=$sale_row['sale_date']; 
	$sale_group=$sale_row['sale_group'];	 
	$sale_tax=$sale_row['sale_tax'];	 
	$sale_discount=$sale_row['sale_discount'];	 
	$sale_ship_fee=$sale_row['sale_ship_fee'];	 
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
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
<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
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
          <TD bgColor=#beddeb><TABLE cellPadding=10>
            <TBODY>
              <TR>
                <TD>Add New sales </TD>
                <TD>&nbsp;</TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            
            <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?sale_ref=<?= $sale_ref;?>">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td><p>&nbsp;</p>
                      <? if($sale_ref=="") {?>
                      <br>
                      <br>
      Sales Date: 
      <script>DateInput('orderdate', true, 'YYYY-MM-DD')</script>
      <br>
      <? echo $sale_order_no_message; ?>
      <br>
      <table width="586" border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td width="140"><input name="sale_ref_a" type="radio" value="a" checked>
          Order No. </td>
          <td width="159"><input name="sale_ref_aa" type="text" id="sale_ref"></td>
          <td width="153"><input name="sale_ref_a" type="radio" value="b">
		  <input name="sale_ref_bb" type="hidden" value="<? echo getsale_ref_next();?>">
            Order No. (Auto)</td>
          <td width="106"><? echo getsale_ref_next(); ?>&nbsp;</td>
        </tr>
      </table>
      <br>
      Sales Group
      
      <input type="text" name="sale_group">
      <br>
      <br>
     
      <input type="submit" name="isorder" value="New Order">
      <br>
      
       <? }else {
	
	  echo "Order No. ". $sale_ref;
	  echo "<br>Order Date: " .$sale_date;
	  echo "<br>Group: " .$sale_group;
	
	  }?>
            <br>
            <br>
            <?
if ($sale_ref!="" ) {

 getsale_prod($sale_ref);


 
 
 ?><br>
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
              <input name="sprod_id" type="text" id="sprod_id">
              <input name="isfind" type="submit" id="isfind" value="Find">
</div></td>
          <td><div align="center">
            <input name="sprod_name" type="text" id="sprod_name">
          </div></td>
          <td>
                <div align="center">
                  <input name="sprod_unit" type="text" id="sprod_unit" size="3" maxlength="2">
              </div></td>
          <td> <div align="center">&yen;
                      <input name="sprod_price" type="text" id="sprod_price" size="7" maxlength="7">
          </div></td>
          <td>
                <div align="center">
                  <input type="submit" name="isadd" value="Add">
              </div></td></tr>
      </table>
	  <? } ?>
	  <br>
     <? 
	 if ($sprod_id!='' and isset($_GET['isfind']))
	 getprodlike_list($sprod_id); 
	 ?>
</td>
                </tr>
              </table>
      
            <br>
            <br><br>
				<? if ($sale_ref!="") {
				
				?>
			
              <table width="246" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><div align="right">Shipping fee :</div></td>
                  <td> <div align="right">&yen;
                          <input name="sale_ship_fee" type="text" id="sale_ship_fee" value="<? echo $sale_ship_fee;?>" size="10" maxlength="10">
                  </div></td>
                </tr>
                <tr>
                  <td><div align="right">Discount :</div></td>
                  <td><div align="right">&yen;
                          <input name="sale_discount" type="text" value="<? echo $sale_discount;?>" size="10" maxlength="10">
                  </div></td>
                </tr>
                <tr>
                  <td><div align="right">Tax :</div></td>
                  <td>
                        <div align="right">
                          <input name="sale_tax" type="text" id="sale_tax" value="<? echo $sale_tax;?>" size="3" maxlength="10">
                        %
                        </div></td>
                </tr>
                <tr>
                  <td colspan="2" align="right"><br>
                    <input name="isdis" type="submit" id="isdis" value="Update">
					<input name="ref_sale_h" type="hidden" value="<? echo $sale_ref;?>">
					</td>
                  </tr>
              </table>
              <? }?> 
              <p>&nbsp;              </p>
            </form> 
            <p>&nbsp;</p>
            <p>&nbsp;            </p>
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
