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
$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-1)\">";
 
if (isset($_GET['sale_ref']) and getdebt_data($_GET['sale_ref']))
{
$sale_ref=$_GET['sale_ref'];
$row = getdebt_data($sale_ref);
$debt_pay_name=$row['debt_pay_name'];
$debt_tel=$row['debt_tel'];
$debt_mobile=$row['debt_mobile'];
//$debt_email=$row['debt_email'];
$debt_cust_address1=$row['debt_cust_address1'];
$debt_cust_address2=$row['debt_cust_address2'];
$debt_cust_address3=$row['debt_cust_address3'];
$debt_post_co=$row['debt_post_co'];
$debt_bank=$row['debt_bank'];
$debt_pay_method=$row['debt_pay_method'];
$debt_shipping_method=$row['debt_shipping_method'];
$debt_remark=$row['debt_remark'];

}
else{
$debt_pay_name="";
$debt_tel="";
$debt_mobile="";
$debt_email="";
$debt_cust_address1="";
$debt_cust_address2="";
$debt_cust_address3="";
$debt_post_co="";
$debt_bank="";
$debt_pay_method="";
$debt_shipping_method="";
$debt_remark="";

}

if (isset($_GET['sale_ref']))
{$sale_ref=$_GET['sale_ref'];}

if (isset($_POST['isupdate']))
		{
$sale_ref=$_POST['sale_ref'];

if (!getdebt_data($sale_ref)) {


$sqla = "INSERT INTO ben_debt SET
debt_ref='".$_POST['sale_ref']."',
debt_tel='".$_POST['debt_tel']."',
debt_pay_name='".$_POST['debt_pay_name']."',
debt_mobile='".$_POST['debt_mobile']."',
debt_cust_address1='".$_POST['debt_cust_address1']."',
debt_cust_address2='".$_POST['debt_cust_address2']."',
debt_cust_address3='".$_POST['debt_cust_address3']."',
debt_post_co='".$_POST['debt_post_co']."',
debt_bank='".$_POST['debt_bank']."',
debt_pay_method='".$_POST['debt_pay_method']."',
debt_remark='".$_POST['debt_remark']."',
debt_shipping_method='".$_POST['debt_shipping_method']."'";
//debt_dat = now()";
		 //debt_email='".$_POST['debt_email']."',
		 //debt_cust_name='".$_POST['debt_cust_name']."',
$sqlb = "Update ben_sale SET
sale_name ='".$_POST['sale_name']."',
sale_email2 ='".$_POST['sale_email2']."',
sale_email ='".$_POST['sale_email']."' where sale_ref= '".$_POST['sale_ref']."'";
		 
sqlinsert($sqla);
sqlinsert($sqlb);

$row = getdebt_data($sale_ref);
$debt_tel=$row['debt_tel'];
$debt_pay_name=$row['debt_pay_name'];
$debt_mobile=$row['debt_mobile'];
$debt_cust_address1=$row['debt_cust_address1'];
$debt_cust_address2=$row['debt_cust_address2'];
$debt_cust_address3=$row['debt_cust_address3'];
$debt_post_co=$row['debt_post_co'];
$debt_bank=$row['debt_bank'];
$debt_pay_method=$row['debt_pay_method'];
$debt_shipping_method=$row['debt_shipping_method'];
$debt_remark=$row['debt_remark'];

$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-2)\">";
//$debt_email=$row['debt_email'];
//$debt_cust_name=$row['debt_cust_name'];
}
else 
{

//update debt note
$sqla = "Update ben_debt SET
debt_tel='".$_POST['debt_tel']."',
debt_mobile='".$_POST['debt_mobile']."',
debt_pay_name='".$_POST['debt_pay_name']."',
debt_cust_address1='".$_POST['debt_cust_address1']."',
debt_cust_address2='".$_POST['debt_cust_address2']."',
debt_cust_address3='".$_POST['debt_cust_address3']."',
debt_post_co='".$_POST['debt_post_co']."',
debt_bank='".$_POST['debt_bank']."',
debt_pay_method='".$_POST['debt_pay_method']."',
debt_remark='".$_POST['debt_remark']."',
debt_shipping_method='".$_POST['debt_shipping_method']."' where debt_ref= '".$_POST['sale_ref']."'";

$sqlb = "Update ben_sale SET
sale_name ='".$_POST['sale_name']."',
sale_email2 ='".$_POST['sale_email2']."',
sale_email ='".$_POST['sale_email']."' where sale_ref= '".$_POST['sale_ref']."'";

//debt_email='".$_POST['debt_email']."',

sqlinsert($sqla);
sqlinsert($sqlb);

$row =getdebt_data($sale_ref);
$debt_pay_name=$row['debt_pay_name'];
$debt_tel=$row['debt_tel'];
$debt_mobile=$row['debt_mobile'];
//$debt_email=$row['debt_email'];
$debt_cust_address1=$row['debt_cust_address1'];
$debt_cust_address2=$row['debt_cust_address2'];
$debt_cust_address3=$row['debt_cust_address3'];
$debt_post_co=$row['debt_post_co'];
$debt_bank=$row['debt_bank'];
$debt_pay_method=$row['debt_pay_method'];
$debt_remark=$row['debt_remark'];
$debt_shipping_method=$row['debt_shipping_method'];
$check = "update";
$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-2)\">";
}
		}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
<script type="text/javascript" src="calendarDateInput.js">

/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/

</script>

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
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<? require('header_script.php'); ?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<? //echo $sqla; ?>
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
    height=39>&nbsp;<span class=big>Username: <? echo $_SESSION[user_name];?>&nbsp; </span></TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><? echo $tool_bar; ?></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
           
<br>
<table width="600" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
	<font color="red">
	<? 
	echo "Order No. :".$sale_ref."<br>";
	$getsale_row=getsale_data($sale_ref);
	echo "Sale Date: ";
	echo $getsale_row['sale_date']."<br>";
	echo "Client Name: ";
	echo $getsale_row['sale_name']."<br>";
	echo "Client Email: ";
	echo $getsale_row['sale_email']."<br>";
	echo "<br><br>";
	getsale_prod($sale_ref); 
	?></font>
	
	</td>
  </tr>
</table>

            
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
              <table width="587" height="381" border="0" cellspacing="10">
                <tr>
                  <td width="600"><table width="600" height="343" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td>Client Name</td>
                        <td><input name="sale_name" type="text" class="standard" id="sale_name" value="<? echo $getsale_row['sale_name'];?>"></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Client Email </td>
                        <td><input name="sale_email" type="text" class="standard" id="sale_email" value="<? echo $getsale_row['sale_email'];?>"></td>
                        <td>Client Email </td>
                        <td><input name="sale_email2" type="text" class="standard" id="sale_email2" value="<? echo $getsale_row['sale_email2'];?>"></td>
                      </tr>
                      <tr>
                        <td width="79">Tel.</td>
                        <td width="176"><input name="debt_tel" type="text" class="standard" id="debt_tel" value="<? echo $debt_tel;?>"></td>
                        <td width="94">Mobile</td>
                        <td width="239"><input name="debt_mobile" type="text" class="standard" id="debt_mobile" value="<? echo $debt_mobile;?>"></td>
                      </tr>
                      <!-- <tr>
                        <td>Email</td>
                        <td colspan="3"><input name="debt_email" type="text" class="standard" id="debt_email" value="<? //echo $debt_email;?>" size="50"></td>
                      </tr> -->
                      <tr>
                        <td height="5">&nbsp;</td>
                        <td height="5" colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Client Address</td>
                        <td colspan="3"><input name="debt_cust_address1" type="text" class="standard" id="debt_cust_address1" value="<? echo $debt_cust_address1;?>" size="50"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="3"><input name="debt_cust_address2" type="text" class="standard" id="debt_cust_address2" value="<? echo $debt_cust_address2;?>" size="50"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="3"><input name="debt_cust_address3" type="text" class="standard" id="debt_cust_address3" value="<? echo $debt_cust_address3;?>" size="50"></td>
                      </tr>
                      <tr>
                        <td>Post code</td>
                        <td colspan="3"><input name="debt_post_co" type="text" class="standard" id="debt_post_co" value="<? echo $debt_post_co;?>" size="10" maxlength="50"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Remark</td>
                        <td colspan="3">                          <input name="debt_remark" type="text" class="standard" id="debt_remark" value="<? echo $debt_remark;?>" size="70"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Client's Payment Name </td>
                        <td colspan="3"><input name="debt_pay_name" type="text" class="standard" id="debt_pay_name" value="<? echo $debt_pay_name;?>" size="50">                          </td>
                      </tr>
                      <tr>
                        <td>Bank </td>
                        <td colspan="3"><input name="debt_bank" type="text" class="standard" id="debt_bank" value="<? echo $debt_bank;?>" size="50"></td>
                      </tr>
                      <tr>
                        <td>Pay method</td>
                        <td colspan="3"><select name="debt_pay_method" class="standard" id="debt_pay_method">
                            <option value="Bank in" <? if ($debt_pay_method=="Bank in"){echo "selected";}?>>Bank in</option>
                            <option value="Cash" <? if ($debt_pay_method=="Cash"){echo "selected";}?>>Cash</option>
                            <option value="Cheque" <? if ($debt_pay_method=="Cheque"){echo "selected";}?>>Cheque</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td>Shipping Method</td>
                        <td colspan="3"><select name="debt_shipping_method" class="standard" id="debt_shipping_method">
                          <option value="Air Mail">Air Mail</option>
                          <option value="EMS">EMS</option>
                          <option value="Air Parcel">Air Parcel</option>
                        </select></td>
                      </tr>
                    </table>
                      <br>
                      <input name="isupdate" type="submit" id="isupdate" value="Update">
                      <input name="sale_ref" type="hidden" value="<? echo $sale_ref;?>">
                      <? //echo $back_button;?><br></td>
                </tr>
              </table>
            </form>
            <?
			
			// if ($debt_email!='') {
			$sale_row = getsale_data($sale_ref);
			$sale_email = $sale_row['sale_email'];
			if ($sale_email!='') {
			?>
            <br>
			    <table width="448" height="24" border="0" cellpadding="10">
              <tr>
                <td width="354">
           <form name="form1" method="get" target="_blank" action="debt_email_t.php">
		  <? getgroup_select($_SESSION[user_name]); ?>
		    <a href="email_list.php?sale_group=ben" onClick="NewWindow(this.href,'mywin','400','420','no','center');return false" onFocus="this.blur()">Edit Email List</a>
<br>
  <br>
  <!--<input type="submit" name="Submit" value="Sent Email to client">-->
  <input name="Submit" type="Submit" id="preview" value="Preview">  
  <input name="outlook" type="Submit" id="outlook" value="Preview Outlook">  
  <input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
           </form>           
        </td>
                <td width="48">&nbsp;</td>
              </tr>
            </table>
			    <br>
			    <? }			?>
            <p>&nbsp;</p>
           
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
