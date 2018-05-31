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

$order_success = '';

//get sale order
if (isset($_GET['sale_ref']))
{$sale_ref = trim($_GET['sale_ref']);}

//get Number of product
if (isset($_GET['prod_n']))
{$prod_n =trim($_GET['prod_n']);} else {$prod_n=1;}

$sale_order_no_message = '';
if (isset($_GET['mod'])) {
if ($_GET['mod']=='same_ref')
$sale_order_no_message = "<font color=red>Please, insert different Order No.</font>";
}

// add new order
if (isset($_POST['isorder']) and !isset($_GET['mod']))
{
if (isset($_POST['prod_n']))
$prod_n = trim($_POST['prod_n']); 
//check sale order no, same order no

	if (isset($_POST['sale_ref_a']))
	{
		if ($_POST['sale_ref_a']=="a")
		{$sale_chk_ref = 0;
		 $sale_ref=trim($_POST['sale_ref_aa']);
			if (getsale_data($sale_ref)!='')
			{echo "<html><meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['PHP_SELF']."?mod=same_ref\"></html>";
			exit;
			}
		}
	 
		if 	($_POST['sale_ref_a']=="b") 
		{$sale_chk_ref = 1;
		 $sale_ref=trim($_POST['sale_ref_bb']);
		}	 
	}
	 //insert record
	 if ($_POST['sale_ship_fee']!='') {$sale_ship_fee = trim($_POST['sale_ship_fee']);} else {$sale_ship_fee = 0;}
	 if ($_POST['sale_discount']!='') {$sale_discount = trim($_POST['sale_discount']);} else {$sale_discount = 0;}
	 if ($_POST['sale_tax']!='') {$sale_tax = trim($_POST['sale_tax']);} else {$sale_tax = 0;}
				
	$sql = "INSERT INTO ben_sale SET
		 	sale_ref = '$sale_ref',
		 	sale_date = '".trim($_POST['orderdate'])."',
		 	sale_group = '".trim($_POST['sale_group'])."',
		 	sale_email = '".trim($_POST['sale_email'])."',
		 	sale_name = '".trim($_POST['sale_name'])."',
			sale_yahoo_id = '".trim($_POST['sale_yahoo_id'])."',
		 	sale_dat = curdate(), 
		 	sale_chk_ref = $sale_chk_ref,
			sale_ship_fee = ".$sale_ship_fee.",
		 	sale_discount = ".$sale_discount.",
		 	sale_tax = ".$sale_tax;
	sqlinsert($sql);
	
	//insert product
	for ($k=1;$k<=$prod_n;$k++)
	{
	$sprod_id = "sprod_id_".$k;
	$sprod_name = "sprod_name_".$k;
	$sprod_price = "sprod_price_".$k;
	$sprod_unit = "sprod_unit_".$k;
	$sqla = "INSERT INTO ben_sale_prod SET
		 	sprod_ref = '$sale_ref',
		 	sprod_id = '".trim($_POST[$sprod_id])."',
		 	sprod_name = '".trim($_POST[$sprod_name])."',
		 	sprod_price = ".trim($_POST[$sprod_price]).", 
		 	sprod_unit = ".trim($_POST[$sprod_unit]); 
		 
	sqlinsert($sqla);
	}
	$order_success = 1;
}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
<script language="javascript" type="text/javascript">
<!--
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin




function IsInteger(varString) 
{ 
	return /^[0-9]+$/i.test(varString);	
}
function checkFields() {
missinginfo = "";
//if (document.form1.sale_name.value == "") {
//missinginfo += "\n     -  Name";
//}


if ((document.form1.sale_ref_a[0].checked) && (document.form1.sale_ref_aa.value == "" )) {
missinginfo += "\n     -  Order Number";
}
<? for ($m=1;$m<=$prod_n;$m++) {?>



if (document.form1.sprod_id_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product id ";}
if (document.form1.sprod_name_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Name ";}
if (document.form1.sprod_unit_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Unit ";}
else {
if (!IsInteger(document.form1.sprod_unit_<?=$m?>.value)) {
missinginfo += "\n     -  <?=$m?> Product Unit. Please fill in a integer.";}
}
if (document.form1.sprod_price_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Price ";}

else {

if (/\./.test(document.form1.sprod_price_<?=$m?>.value) || IsInteger(document.form1.sprod_price_<?=$m?>.value))
{missinginfo += "";} else
{missinginfo += "\n     -  <?=$m?> Product Price. Please fill in a number.";}


}

<? }?>

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


</HEAD>
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
    height=39>&nbsp;&nbsp;<span class=big>&nbsp;&nbsp;Username: <? echo $_SESSION[user_name];?>&nbsp; </span> </TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><? echo $tool_bar; ?></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
           <? //echo $sql;
		?>
		   <? if ($order_success==''){
           ?>
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?sale_ref=<?= $sale_ref;?>" onSubmit="return checkFields();">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td>
                      <br>
                      Number of Product 

                      <select name="prod_n" onChange=javascript:location.href='order_add.php?prod_n='+this.options[this.selectedIndex].value>
                        <? 
 for ($i=1;$i<=10;$i++)
  {
  if ($prod_n==$i)
  echo "<option value='$i' selected>$i</option>";
  else
  echo "<option value='$i'>$i</option>";
  
 }
 ?>
                      </select>
                      <br>
                      <br>
      Sales Date: 
      <script>DateInput('orderdate', true, 'YYYY-MM-DD')</script>
      <br>
     
      <? echo $sale_order_no_message; ?><br>
      <table width="586" border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td width="140"><input name="sale_ref_a" type="radio" value="a" checked>
          Order No. (Yahoo) </td>
          <td width="159"><input name="sale_ref_aa" type="text"></td>
          <td width="153"><input name="sale_ref_a" type="radio" value="b">		    
            <input name="sale_ref_bb" type="hidden" value="<? echo getsale_ref_next();?>">
              Order No. (Auto)</td><td width="106"><? echo getsale_ref_next(); ?>&nbsp;</td>
        </tr>
      </table>
      <br>
      <table width="609" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>Client Email:
            <input name="sale_email" type="text" id="sale_email"></td>
          <td>Client Name:
            <input name="sale_name" type="text" id="sale_name"></td>
        </tr>
        <tr>
          <td width="324" height="43"><br>
            Sales Group
  <? getgroup_select($_SESSION[user_name]);?>
			   <!--  <a href="group_list.php" onClick="NewWindow(this.href,'mywin','250','400','no','center');return false" onFocus="this.blur()">Edit Group List</a> -->              </td>
          <td width="285"><br>Client Yahoo ID:
            <input name="sale_yahoo_id" type="text" id="sale_yahoo_id"></td>
        </tr>
      </table>
      <br> <br>
            <br>

            
      <table width="584" border="1" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC">
          <td width="213"><div align="center">Product No. </div></td>
          <td width="162"><div align="center">Products Name</div></td>
          <td width="82"><div align="center">Qty Unit</div></td>
          <td width="117"><div align="center">Unit Price </div></td>
          </tr>
        <? for ($j=1;$j<=$prod_n;$j++) {?>
          
		<tr>
          <td><div align="center">
		      <input name="sprod_id_<? echo $j?>" type="text" id="sprod_id_<? echo $j?>">
              <input name="isfind" type="button" id="isfind" value="Find" onClick="window.open('order_find_product.php?prod_sel=<? echo $j?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');">
</div></td>
          <td><div align="center">
            <input name="sprod_name_<? echo $j?>" type="text" id="sprod_name_<? echo $j?>">
          </div></td>
          <td>
                    <div align="center">
                      <input name="sprod_unit_<? echo $j?>" type="text" id="sprod_unit_<? echo $j?>" size="3" maxlength="2">
                    </div></td>
          <td> <div align="center">&yen;
                      <input name="sprod_price_<? echo $j?>" type="text" id="sprod_price_<? echo $j?>" size="10" maxlength="10">
          </div></td>
          </tr> <? }?>
      </table>
	  	  <br>
</td>
                </tr>
              </table>
                            <br>
            <br><br>
              <table width="246" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="120"><div align="right">Shipping fee :</div></td>
                  <td width="25"> <div align="right">&yen;
                  </div></td>
                  <td width="101"><input name="sale_ship_fee" type="text" id="sale_ship_fee" value="<? echo $sale_ship_fee;?>" size="10" maxlength="10"></td>
                </tr>
                <tr>
                  <td><div align="right">Discount :</div></td>
                  <td><div align="right">&yen;
                  </div></td>
                  <td><input name="sale_discount" type="text" value="<? echo $sale_discount;?>" size="10" maxlength="10"></td>
                </tr>
                <tr>
                  <td><div align="right">Tax :</div></td>
                  <td>
                        <div align="right">                        </div></td>
                  <td><input name="sale_tax" type="text" id="sale_tax" value="<? echo $sale_tax;?>" size="10" maxlength="10">
%</td>
                </tr>
                <tr>
                  <td colspan="3" align="right"><br>
					<input name="ref_sale_h" type="hidden" value="<? echo $sale_ref;?>">
					</td>
                  </tr>
              </table>
                  <p>
                    <input type="submit" name="isorder" value="New Order">
</p>
            </form> 
            <table width="964" border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td width="20">&nbsp; </td>
                <td width="882"><? }else {
	echo "Order No. :".$sale_ref."<br>";
	$getsale_row=getsale_data($sale_ref);
	echo "Sale Date: ";
	echo $getsale_row['sale_date']."<br>";
	echo "Client Name: ";
	echo $getsale_row['sale_name']."<br>";
	echo "Client Email: ";
	echo $getsale_row['sale_email']."<br>";
	echo "Client Yahoo ID: ";
	echo $getsale_row['sale_yahoo_id']."<br>";
	
	echo "<br><br>";
	getsale_prod($sale_ref); 
	echo "<br><font size=3 color=red >Order Success ! Click&quot; Add New Order&quot; for New Order.</font>" ;
	}
	?></td>
              </tr>
            </table>
            
	        <p>&nbsp;</p>
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
