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

if (isset($_GET['search_sale']))
{ $sale_ref=$_GET['sale_ref'];}
else {$sale_ref='';
}

if (isset($_GET['search_name']))
{ $sale_name=$_GET['sale_name'];}
else {$sale_name='';
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
    height=39>&nbsp;</TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><TABLE width="887" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="156"><span class="cat cat"><a href="order_add.php" class="big">Add New sales</a> </span></TD>
                <TD width="167"><span class="cat cat"><a href="ship_report.php" class="big">Shipping Report</a></span></TD>
                <TD width="144"><span class="cat cat"><a href="email_report.php" class="big">Email Report</a></span></TD>
                <TD width="168"><span class="cat cat"><a href="pay_report.php" class="big">Payment Report</a></span></TD>
                <TD width="273"><span class="cat cat"><a href="sent_report.php" class="big">Sent Report</a></span></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            ---------------------------------------------------------------------------------------------------------------------------------------------------<br>
              
            <br>
            <table width="180" border="0" cellspacing="10">
              <tr>
                <td><p> <FORM method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
				<table width="319" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>Order No : </td>
                    <td><input name="sale_ref" type="text" id="sale_ref" value="<? //echo $sale_ref;?>">
                      <input name="search_sale" type="submit" id="search_sale" value="Search"></td>
                  </tr>
                  <tr>
                    <td>Name : </td>
                    <td><input name="sale_name" type="text" id="sale_name">
                      <input name="search_name" type="submit" id="search_name" value="Search"></td>
                  </tr>
                </table>
				<br>
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
   
  <input name="Submit" type="submit" value="Check / Edit Record">
             </FORM>   </p>
                 <? 
				 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) and !isset($_GET['search_sale']))
				 {
				  $today = date("Y-m-d"); 
				  $today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
 				if (!isset($_SESSION['date_start'])) {getorder_list_by_date($today_10,$today);}
				else{getorder_list_by_date($_SESSION['date_start'],$_SESSION['date_end']);}
				}				   
				 if (isset($_GET['date_start']) and isset($_GET['date_end']) and !isset($_GET['search_sale']) and !isset($_GET['search_name']))
				 {
				 $_SESSION['date_start'] = $_GET['date_start'];
				 $_SESSION['date_end'] = $_GET['date_end'];
				 
				 getorder_list_by_date($_SESSION['date_start'],$_SESSION['date_end']);
				 }
				 
				 if (isset($_GET['search_sale']))
				 {
				 getorder_list_by_no($sale_ref,'sno');
				 }
				 if (isset($_GET['search_name']))
				 {
				 getorder_list_by_no($sale_name,'sname');
				 }
				 ?>
                 
				  <br></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
