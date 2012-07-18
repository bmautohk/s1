<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}
if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}

$group2=$_SESSION[group2];
$user_name=$_SESSION[user_name];

require('config.php');  //this should the the absolute path to the config.php file 
                                    //(ie /home/website/yourdomain/login/config.php or 
                                    //the location in relationship to the page being protected - ie ../login/config.php )
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above

if (allow_access(@Administrators) != "yes" ){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
exit;
}

if (isset($_GET['issearch']))
{ $sale_ref=$_GET['sale_ref'];
$sale_name=$_GET['sale_name'];
$sale_email=$_GET['sale_email'];
$sale_yhoo_id=$_GET['sale_yahoo_id'];
$sale_name=$_GET['sale_name'];
$debt_cust_address1=$_GET['debt_cust_address1'];
$debt_cust_address2=$_GET['debt_cust_address2'];
$debt_post_co=$_GET['debt_post_co'];
$min_m=$_GET['min_m'];
$max_m=$_GET['max_m'];
$total_m=$_GET['total_m'];
$total_price=$_GET['total_price'];
}
else {
$sale_ref='';
$sale_name='';
$sale_email='';
$sale_yhoo_id='';
$sale_name='';
$debt_cust_address1='';
$debt_cust_address2='';
$debt_post_co='';
$min_m=0;
$max_m='';
$total_m='';
}


				

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>

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
<? require ('header_script.php');?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD background="admin_head_bg.gif" colSpan=5 
    height=34>&nbsp;&nbsp;<A class=big 
      href="http://www.apmzone.com/shop/admin.php"><B>Administrative 
      tools</B></A> (<A 
      href="logout.php">Logout</A>)

	  
</TD>
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
                  href="prod_add.php">Product List</A></TD>
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
    height=39>&nbsp;<span class=big>&nbsp;&nbsp;Username: <? echo $_SESSION[user_name];?>&nbsp; </span> </TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><TABLE width="800" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="156"><span class="cat cat"><a href="order_add.php" class="big">Add New<br> 
                  sales</a> </span></TD>
                <TD width="167"><span class="cat cat"><a href="ship_report.php" class="big">Shipping<br> 
                  Report</a></span></TD>
                <TD width="144"><span class="cat cat"><a href="email_report.php" class="big">Email<br> 
                  Report</a></span></TD>
                <TD width="168"><span class="cat cat"><a href="pay_report.php" class="big">Payment<br> 
                  Report</a></span></TD>
                <TD width="273"><span class="cat cat"><a href="sent_report.php" class="big">Sent<br> 
                  Report</a></span></TD>
                <TD width="273"><span class="cat cat"><a href="main.php" class="big">Main <br>
                  Page</a></span></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            ---------------------------------------------------------------------------------------------------------------------------------------------------<br>
              
            <br>
            <table width="777" border="0" cellspacing="10">
              <tr>
                <td><p> <FORM method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
				<table width="647" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100">Order No : </td>
                    <td width="210"><input name="sale_ref" type="text" id="sale_ref" value="<? echo $sale_ref;?>"></td>
                    <td width="34">&nbsp;</td>
                    <td width="100">Email:</td>
                    <td width="268"><input name="sale_email" type="text" id="sale_email" value="<? echo $sale_email;?>">
                        </td>
                  </tr>
                  <tr>
                    <td>Name : </td>
                    <td><input name="sale_name" type="text" id="sale_name" value="<? echo $sale_name;?>">
                      </td>
                    <td>&nbsp;</td>
                    <td>Yahoo ID : </td>
                    <td><input name="sale_yahoo_id" type="text" id="sale_yahoo_id" value="<? echo $sale_yahoo_id;?>">
                            </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Address 1:</td>
                    <td><input name="debt_cust_address1" type="text" value="<? echo $debt_cust_address1;?>" ></td>
                    <td>&nbsp;</td>
                    <td>Address 2:</td>
                    <td><input name="debt_cust_address2" type="text" value="<? echo $debt_cust_address2;?>" ></td>
                  </tr>
                  <tr>
                    <td>Post code </td>
                    <td><input name="debt_post_co" type="text" value="<? echo $debt_post_co;?>" ></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Price Total:<br>
                      Min</td>
                    <td><input name="min_m" type="text" value="<? echo $min_m;?>"></td>
                    <td>&nbsp;</td>
                    <td>Price Total:<br> 
                      Max</td>
                    <td><input name="max_m" type="text" value="<? echo $max_m;?>"></td>
                  </tr>
                  <tr>
                    <td>Product Total:</td>
                    <td><input name="total_m" type="text" value="<? echo $total_m;?>"></td>
                    <td>&nbsp;</td>
                    <td>Price Total : </td>
                    <td><input name="total_price" type="text" value="<? echo $total_price;?>"></td>
                  </tr>
                </table>
                <br>
                <br>                
                <input name="issearch" type="submit" id="issearch" value="Search">				
                <br>
				<br>
				<table width="406" border="0">
  <tr>
    <td width="30">From</td>
    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>&nbsp;</td>
    <td width="16">To </td>
    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>&nbsp;</td>
  </tr>
</table>
                <br>
                <br>
   
  <input name="Submit" type="submit" value="Check / Edit Record">
             </FORM>   </p>
                 <? 
				 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) )
				 {
				  $today = date("Y-m-d"); 
				  $today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
 				if (!isset($_SESSION['date_start'])) {getorder_list_by_date_delete($today_10,$today,$group2, $user_name);;}
				else{getorder_list_by_date_delete($_SESSION['date_start'],$_SESSION['date_end'],$group2, $user_name);}
				}				   
				 if (isset($_GET['date_start']) and isset($_GET['date_end']) and !isset($_GET['issearch']))
				 {
				 $_SESSION['date_start'] = $_GET['date_start'];
				 $_SESSION['date_end'] = $_GET['date_end'];
				 
				 getorder_list_by_date_delete($_SESSION['date_start'],$_SESSION['date_end'],$group2, $user_name);
				 }
				 
				  if (isset($_GET['issearch']))
				 {
				  $today = date("Y-m-d"); 
				  $today_60 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-60,date("Y")));
				 getorder_list_by_filter_delete($sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$today_60,$today,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m, $total_price,$group2, $user_name);
				 }
				
				
				
				
				 ?>
                 
				  <br></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
