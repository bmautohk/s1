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
/*
if (isset($_GET['sale_ref']) and getship_data($_GET['sale_ref']))
{
$sale_ref=$_GET['sale_ref'];
$row = getship_data($sale_ref);
$check_shipping=$row['check_shipping'];
$check_print=$row['check_print'];
$check_date=$row['check_date'];

}

else{
$check_shipping='';
$check_print='';
$check_date='';
}

if (isset($_GET['sale_ref']))
{$sale_ref=$_GET['sale_ref'];}

if (isset($_POST['isupdate']))
		{
		*/
		
$sale_ref=$_POST['sale_ref'];
if (getship_data($sale_ref)) {


//update debt note



$sqla = "Update ben_check SET
check_date='".$_POST['check_date']."',
check_dat = curdate() where check_ref= '".$sale_ref."'";

sqlinsert($sqla);
$row = getship_data($sale_ref);
$check_shipping=$row['check_shipping'];
$check_print=$row['check_print'];
$check_date=$row['check_date'];


$check = "update";

}

/*
else 
{


}
		}
*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<script language="javascript" src="cal2.js"></script>
<script language="javascript" src="cal_conf2.js"></script>

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
<? require ('header_script.php');?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<? //echo $sqla;?>
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
          <TD bgColor=#beddeb><TABLE width="440" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="190"><span class="cat cat"><a href="order_add.php" class="big">Add New sales</a> </span></TD>
                <TD width="202"><span class="cat cat"><a href="ship_report.php" class="big">Shipping Report</a></span></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
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

	?>
	</font>
	<?
	$debt_row=getdebt_data($sale_ref);
	//echo "Customer Name:". $debt_row['debt_cust_name']."<br>";
	echo "Tel.:". $debt_row['debt_tel']."<br>";
	echo "Mobile:". $debt_row['debt_mobile']."<br>";
    echo "Address1:". $debt_row['debt_cust_address1']."<br>";
	echo "Address2:". $debt_row['debt_cust_address2']."<br>";
	echo "Address3:". $debt_row['debt_cust_address3']."<br>";
	echo "Post Code:". $debt_row['debt_post_co']."<br>";


	echo getdate_data($sale_ref);
	echo "<br><br>";
	getsale_prod($sale_ref); 
	?>
	
	</td>
  </tr>
</table>

            
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?sale_ref=<?= $sale_ref;?>">
              <table width="587" height="236" border="0" cellspacing="10">
                <tr>
                  <td width="600" height="216" valign="top"><table width="600" height="146" border="0" cellpadding="0" cellspacing="0">
                      <tr valign="top">
                        <td width="121" height="64">Order No: </td>
                        <td width="467"><input name="sale_ref" type="text" class="standard" id="check_shipping2">                            </tr>
                      <tr valign="top">
                        <td height="64">Shipping Date: </td>
                        <td>&nbsp; <input name="check_date" type="text" value="<? echo date("Y-m-j"); ?>" size=20>
                          <small>
						  <!-- <a href="javascript:showCal('Calendar1')">Select Date</a> -->
						  </small></td>
                      </tr>
                      <tr valign="top">
                        <td height="18">&nbsp;</td>
						<td>
						<input name="isupdate" type="submit" value="Update">
						
						&nbsp; </td>
                      </tr>
                    </table>
                      <br>
                      <br>
                      <br>                      
                      </td>
                </tr>
              </table>
            </form>
            
        
           
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
