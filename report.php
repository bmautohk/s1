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

if (isset($_POST['search_sale']))
{ $sale_ref=$_POST['sale_ref'];}
else {$sale_ref='';}
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
          <TD width=5><IMG src="admin_menu_1.gif" 
            width=5 height="39"></TD>
          <TD background="admin_menu_3.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="order_main.php">Order</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2.gif" width="6" height="39"></TD>
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
          <TD width=5><IMG src="admin_menu_1_h.gif" 
            width=5></TD>
          <TD background="admin_menu_3_h.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="report.php">Report</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2_h.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#E1F0F6>&nbsp;      </TD>
    <TD width="99%" background="admin_menu_bg.gif" 
    height=39>&nbsp;</TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><TABLE width="364" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="120"><A class=standard 
                  href="report.php">Report</A></TD>
                <TD width="196"><A class=standard 
                  href="report_prod.php">Items Sold</A></TD>
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
                <td><p> <FORM method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
				Order No: 
				<input name="sale_ref" type="text" id="sale_ref" value="<? echo $sale_ref;?>">
				 <input name="search_sale" type="submit" id="search_sale" value="search">
				 <br>
				 <br>
				 <input name="sale_or" type="radio" value="sale_date" checked>
				 Order Date  
				 <input name="sale_or" type="radio" value="sale_ref">
				 Order No.				 <br>
				 <br>
				 <input name="sale_as" type="radio" value="desc" checked>
DESC
<input name="sale_as" type="radio" value="asc">
				 ASC				 <br>
				 <br>
				 Top Product
                 <input name="sale_top" type="checkbox" id="sprod_top" value="1">
Top
<select name="sale_select" >
  <option value="10">10</option>
  <option value="20">20</option>
  <option value="30">30</option>
  <option value="40">40</option>
  <option value="50">50</option>
</select>
<br>
<br>
Group: 
				 <? getgroup($get_username); ?><br>
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
   
  <input name="Submit" type="submit" value="Check">
             </FORM>   </p>
                 <? 
				 $get_username = $_POST['get_username']; 
				 $print_link = "&nbsp;";
				 $today = date("Y-m-d"); 
				 $today_20 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) and isset($_POST['sale_top']))
				 {
				 $date_start = $_POST['date_start'];
				 $date_end = $_POST['date_end'];
				 $sale_top = $_POST['sale_top'];
				 $sale_select = $_POST['sale_select'];
				 getreport_top($date_start,$date_end,$sale_top,$sale_select);
				  
				 }
				 
				 if (!isset($_POST['date_start']) and !isset($_POST['date_end']) and !isset($_POST['search_sale']) and !isset($_POST['sale_top']))
				 {
				 getreport($today_20,$today, 'sale_date','desc','date','');
				 $print_link = "<a href=\"print_report.php?date_start=$today_20&date_end=$today&mod=date&sale_or=sale_date&sale_as=desc\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				  
				 }
				  
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) and !isset($_POST['search_sale']) and !isset($_POST['sale_top']))
				 {
				 $date_start = $_POST['date_start'];
				 $date_end = $_POST['date_end'];
				 $sale_or = $_POST['sale_or'];
				 $sale_as = $_POST['sale_as'];
				 $mod = "date";
				 getreport($date_start,$date_end,$sale_or,$sale_as,$mod,$get_username);
				 $print_link = "<a href=\"print_report.php?date_start=$date_start&date_end=$date_end&mod=$mod&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				  
				 }
				 if (isset($_POST['search_sale']))
				 {
				 $mod = $_POST['sale_ref'];
				 getreport('','',$sale_or,$sale_as,$mod);
				 $print_link = "<a href=\"print_report.php?date_start=&date_end=&mod=$mod&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				 }
				 
				 ?>
				 
                 <table width="525" border="0">
                        <tr>
                          <td width="175"><? echo $print_link;?></td>

                        </tr>
                      </table>       
					  
					  </td>
              </tr>
            </table>
            <p>&nbsp;</p>
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
