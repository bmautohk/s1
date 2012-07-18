<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

//require config and functions files
require('../config.php');
require('../functions.php');

//check for administrative rights
if (allow_access(@Administrators) != "yes")
{
	include ('../no_access.html');
	exit;
}

//make connection to dbase
$connection = @mysql_connect($server, $dbusername, $dbpassword)
			or die(mysql_error());
			
$db = @mysql_select_db($db_name,$connection)
			or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM $table_name";
$result = @mysql_query($sql,$connection) or die(mysql_error());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
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
<LINK href="../style1.css" type=text/css rel=STYLESHEET>
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
          <TD width=5><IMG src="../admin_menu_1.gif" 
            width=5></TD>
          <TD background="../admin_menu_3.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="order_main.php">Order</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="../admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="../admin_menu_1.gif" 
            width=5></TD>
          <TD background="../admin_menu_3.gif">
            <TABLE width="85" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="prod_list.php">Product List</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="../admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="../admin_menu_1.gif" 
            width=5></TD>
          <TD background="../admin_menu_3.gif">
            <TABLE width="78" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="admin/adminpage.php">User Page</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD width="26"><IMG 
        src="../admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="../admin_menu_1.gif" 
            width=5></TD>
          <TD background="../admin_menu_3.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="report.php">Report</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="../admin_menu_2.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#E1F0F6>&nbsp;      </TD>
    <TD width="99%" background="../admin_menu_bg.gif" 
    height=39>&nbsp;</TD></TR>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="102%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb>&nbsp;            </TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            
<table border="0" width="100%" id="table18" cellspacing="0" cellpadding="0">
	<tr>
		<td><b><i><font size="2">Login Administration Page</font></i></b><font size="2"><br>
</font>
<i><b><font size="2"><? echo $domain; ?></font></a></b></i></td>
		<td align="right" valign="top"><i><b><font size="2">
		<a href="../logs/index.php">View Access Log</a></font></b></i><br>
		<i><b><font size="2"><a href="../logout.php">Logout</a></font></b></i></td>
	</tr>
</table>

<table border="0" width="100%" id="table1">
	<tr>
		<td width="33%" valign="top" height="0">
	<font size="1" face="Tahoma">
<table border="1" width="100%" id="table14">
	<tr>
		<td width="33%" valign="top" height="0">
	<font size="1" face="Tahoma">
	<script Language="JavaScript" Type="text/javascript"><!--
function FrontPage_Form1_Validator(theForm)
{

  if (theForm.firstname.value == "")
  {
    alert("Please enter a value for the \"firstname\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (theForm.lastname.value == "")
  {
    alert("Please enter a value for the \"lastname\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.password.value == "")
  {
    alert("Please enter a value for the \"password\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.redirect.value == "")
  {
    alert("Please enter a value for the \"redirect\" field.");
    theForm.firstname.focus();
    return (false);
  }
}

function mod_user_Validator(modForm)
{

  if (modForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (modForm.modify.value == "")
  {
    alert("Please enter a value for the \"modify\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (modForm.change.value == "")
  {
    alert("Please enter a value for the \"change\" field.");
    theForm.firstname.focus();
    return (false);
  }
 }
//--></script>

		</font>

		<form method="POST" action="adduser.php" onsubmit="return FrontPage_Form1_Validator(add_user)" language="JavaScript" name="add_user">
			<table border="0" width="100%" id="table15" cellspacing="0" cellpadding="0">
				<tr>
					<td width="170"><b><font size="1" face="Tahoma">Add User</font></b></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">First Name:</font></td>
					<td><font size="1" face="Tahoma">
			<input type="text" name="firstname" size="20" style="font-size: 8pt; font-family: Tahoma"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Last Name:</font></td>
					<td><font size="1" face="Tahoma">

			<input type="text" name="lastname" size="20" style="font-size: 8pt; font-family: Tahoma"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Username:</font></td>
					<td><font size="1" face="Tahoma">

			<input type="text" name="username" size="20" style="font-size: 8pt; font-family: Tahoma"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Password:</font></td>
					<td><font size="1" face="Tahoma">

			<input type="text" name="password" size="20" style="font-size: 8pt; font-family: Tahoma" maxlength="667"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">E-Mail Address:</font></td>
					<td><font size="1" face="Tahoma">

			<input type="text" name="email" size="20" style="font-size: 8pt; font-family: Tahoma"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Group Memberships:</font></td>
					<td><font size="1" face="Tahoma">
			<select size="1" name="group1"style="font-size: 8pt; font-family: Tahoma">

<?php

echo "<option>Users</option>";
$i = 0;
while ($i < $num_groups)
{
	echo "<option value=\"$group_array[$i]\">$group_array[$i]</option>";
	$i++;
}
?>

			</select></font></td>
				</tr>
				<tr>
					<td width="170">&nbsp;</td>
					<td><font size="1" face="Tahoma">
			<select size="1" name="group2"style="font-size: 8pt; font-family: Tahoma">

<?php
	echo "<option></option>";
$i = 0;
while ($i < $num_groups)
{
	echo "<option value=\"$group_array[$i]\">$group_array[$i]</option>";
	$i++;
}
?>

			</select></font></td>
				</tr>
				<tr>
					<td width="170">&nbsp;</td>
					<td><font size="1" face="Tahoma">
			<select size="1" name="group3"style="font-size: 8pt; font-family: Tahoma">

<?php
	echo "<option></option>";
$i = 0;
while ($i < $num_groups)
{
	echo "<option value=\"$group_array[$i]\">$group_array[$i]</option>";
	$i++;
}
?>

			</select></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Redirect to:</font></td>
					<td><font size="1" face="Tahoma">
			<input type="text" name="redirect" size="20" style="font-size: 8pt; font-family: Tahoma" value="http://"></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Change Password Next Login:</font></td>
					<td><font size="1" face="Tahoma">
			<select size="1" name="pchange"style="font-size: 8pt; font-family: Tahoma">
			<option value="0" selected>No</option>
			<option value="1">Yes</option>
			</select></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1">E-Mail User Account 
					Information:</font></td>
					<td><font size="1" face="Tahoma">
			<select size="1" name="email_user" style="font-size: 8pt; font-family: Tahoma">
			<option value="No" selected>No</option>
			<option value="Yes">Yes</option>
			</select></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">
			<input type="submit" value="Submit" name="B4" style="font-size: 8pt; font-family: Tahoma"></font></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	<tr>
		<td width="33%" valign="top" height="0">
		<form method="POST" action="mod_user.php" onsubmit="return mod_user_Validator(mod_user)" language="JavaScript" name="mod_user">
			<table border="0" width="100%" id="table16" cellspacing="0" cellpadding="0">
				<tr>
					<td width="170"><b><font size="1" face="Tahoma">Modify User</font></b></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Username:</font></td>
					<td><font size="1" face="Tahoma">
					<select size="1" name="username" style="font-size: 8pt; font-family: Tahoma">
					<option></option>

<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM $table_name";
$result = @mysql_query($sql,$connection) or die(mysql_error());
	while ($sql = mysql_fetch_object($result)) 
	{
	    $uname = $sql -> username;
	    echo "<option value=\"$uname\">$uname</option>";
	}
?>
					</select></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">Change This:</font></td>
					<td><font size="1" face="Tahoma">
					<select size="1" name="modify" style="font-size: 8pt; font-family: Tahoma">
					<option></option>
					<option value="firstname">First Name</option>
					<option value="lastname">Last Name</option>
					<option value="password">Password</option>
					<option value="email">E-Mail</option>
					<option value="pchange">Password Change Req'd</option>
					<option value="redirect">Redirect To</option>
					<option value="group1">Group1</option>
					<option value="group2">Group2</option>
					<option value="group3">Group3</option>
					</select></font></td>
				</tr>
				<tr>
					<td width="170"><font size="1" face="Tahoma">To This:</font></td>
					<td><font size="1" face="Tahoma">
			<input type="text" name="change" size="20" style="font-size: 8pt; font-family: Tahoma"></font></td>
				</tr>
				<tr>
					<td width="170">
			<font size="1" face="Tahoma">
			<input type="submit" value="Submit" name="B5" style="font-size: 8pt; font-family: Tahoma"></font></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	<tr>
		<td width="33%" valign="top" height="0">
		<form method="POST" action="mod_user.php">
		<table border="0" width="100%" id="table17" cellspacing="0" cellpadding="0">
			<tr>
				<td width="169"><b><font size="1" face="Tahoma">User Maintenance</font></b></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Delete User</font></td>
				<td>
				<font size="1" face="Tahoma">
				<select size="1" name="del_user" style="font-size: 8pt; font-family: Tahoma">
				<option></option>
<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT username FROM $table_name ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());

while ($sql = mysql_fetch_object($result)) 
{
	$uname = $sql -> username;
	if ($uname != $_SESSION[user_name])
	{
	echo "<option value=\"$uname\">$uname</option>";
	}
}

?>
				</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Restore User</font></td>
				<td>
				<font size="1" face="Tahoma">
				<select size="1" name="restore" style="font-size: 8pt; font-family: Tahoma">
				<option></option>
<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT username FROM trash ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());

while ($sql = mysql_fetch_object($result)) 
{
	$uname = $sql -> username;
	if ($uname != $_SESSION[user_name])
	{
	echo "<option value=\"$uname\">$uname</option>";
	}
}

?>
				</select></font></td>
			</tr>

			<tr>
				<td width="169"><font size="1" face="Tahoma">Ban User</font></td>
				<td>
				<font size="1" face="Tahoma">
				<select size="1" name="ban_user" style="font-size: 8pt; font-family: Tahoma">
				<option></option>

<?php

//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT username FROM $table_name ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());

while ($sql = mysql_fetch_object($result)) 
{
	$uname = $sql -> username;
	
	if ($uname != $_SESSION[user_name])
	{
	echo "<option value=\"$uname\">$uname</option>";
	}
}
?>
				</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Block IP Address</font></td>
				<td>
				<font size="1" face="Tahoma">
				<input type="text" name="oct1" size="3" maxlength="3" style="font-family: Tahoma; font-size: 8pt">.<input type="text" name="oct2" size="3" maxlength="3" style="font-family: Tahoma; font-size: 8pt">.<input type="text" name="oct3" size="3" maxlength="3" style="font-family: Tahoma; font-size: 8pt">.<input type="text" name="oct4" size="3" maxlength="3" style="font-family: Tahoma; font-size: 8pt"></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Lift User Ban</font></td>
				<td>
				<font size="1" face="Tahoma">
				<select size="1" name="lift_user_ban" style="font-size: 8pt; font-family: Tahoma">
				<option></option>
<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM banned WHERE type = 'user'";
$result = @mysql_query($sql,$connection) or die(mysql_error());

while ($sql = mysql_fetch_object($result)) 
{
	$banned = $sql -> no_access;
	
	echo "<option value=\"$banned\">$banned</option>";
}
?>

				</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Lift IP Ban</font></td>
				<td>
				<font size="1" face="Tahoma">
				<select size="1" name="lift_ip_ban" style="font-size: 8pt; font-family: Tahoma">
				<option></option>
<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM banned WHERE type = 'ip'";
$result = @mysql_query($sql,$connection) or die(mysql_error());

while ($sql = mysql_fetch_object($result)) 
{
	$banned = $sql -> no_access;
	echo "<option value=\"$banned\">$banned</option>";
}
?>				
				</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">Empty Trash</font></td>
				<td><font size="1" face="Tahoma">
			<select size="1" name="empt_trash" style="font-size: 8pt; font-family: Tahoma">
			<option></option>
			<option value="yes">Yes</option>
			</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1">Purge Accounts Inactive for</font></td>
				<td><select size="1" name="amt_time">
				<option></option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				</select><font size="1" face="Tahoma"><select size="1" name="incr_time">
				<option></option>
				<option value="DAY">Days</option>
				<option value="MONTH">Months</option>
				<option value="YEAR">Years</option>
				</select></font></td>
			</tr>
			<tr>
				<td width="169"><font size="1" face="Tahoma">
				<input type="submit" value="Submit" name="B6" style="font-size: 8pt; font-family: Tahoma"></font></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
	<tr>
		<td width="33%" valign="top" height="100%">
		<font face="Tahoma" size="2" color="#FF0000">Please note that any 
modifications made to your account will require you login again.</font></td>
	</tr>
</table>

	<script Language="JavaScript" Type="text/javascript"><!--
function FrontPage_Form1_Validator(theForm)
{

  if (theForm.firstname.value == "")
  {
    alert("Please enter a value for the \"firstname\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (theForm.lastname.value == "")
  {
    alert("Please enter a value for the \"lastname\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.password.value == "")
  {
    alert("Please enter a value for the \"password\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.redirect.value == "")
  {
    alert("Please enter a value for the \"redirect\" field.");
    theForm.firstname.focus();
    return (false);
  }
}

function mod_user_Validator(theForm)
{

  if (theForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (theForm.modify.value == "")
  {
    alert("Please enter a value for the \"modify\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.change.value == "")
  {
    alert("Please enter a value for the \"change\" field.");
    theForm.firstname.focus();
    return (false);
  }
 }
//--></script>

		</font>

		</td>
		<td width="66%" valign="top">
		<table border="0" width="100%" id="table5" cellspacing="0" cellpadding="0">

<?php
//require the config file
require ("../config.php");

//make the connection to the database
$connection = @mysql_connect($server, $dbusername, $dbpassword) or die(mysql_error());
$db = @mysql_select_db($db_name,$connection)or die(mysql_error());

//build and issue the query
$sql ="SELECT * FROM $table_name ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());

	while ($sql = mysql_fetch_object($result)) 
{
	
$fname 		= $sql -> firstname;
$lname 		= $sql -> lastname;
$uname 		= $sql -> username;
$p_change	= $sql -> pchange;
$verif_d	= $sql -> verified;
$last 		= $sql -> last_login;
$re_direct 	= $sql -> redirect;
$groupA		= $sql -> group1;
$groupB		= $sql -> group2;
$groupC		= $sql -> group3;
$e_mail		= $sql -> email;
	
if ($p_change == 1)
{$p_change = "Yes";}else{$p_change = "No";}

if ($verif_d == "0")
{$verif_d= "No";}else{$verif_d= "Yes";}

echo "<tr>";
echo "<td>";
echo "<table border=\"1\" width=\"100%\" id=\"table5\">";
echo "<tr>";
echo "<td width=\"14%\"><b><font face=\"Tahoma\" size=\"1\">$uname</font></b></td>";
echo "<td width=\"18%\"><font face=\"Tahoma\" size=\"1\">$e_mail</font></td>";
echo "<td width=\"21%\"><font face=\"Tahoma\" size=\"1\">Password Change Req'd: $p_change</font></td>";
echo "<td width=\"21%\"><font face=\"Tahoma\" size=\"1\">Verified: $verif_d</font></td>";
echo "<td width=\"24%\"><font face=\"Tahoma\" size=\"1\">Last Login: $last</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td width=\"14%\">&nbsp;</td>";
echo "<td width=\"18%\"><font face=\"Tahoma\" size=\"1\">$fname</font></td>";
echo "<td width=\"21%\"><font face=\"Tahoma\" size=\"1\">$lname</font></td>";
echo "<td colspan=\"2\"><font face=\"Tahoma\" size=\"1\">$re_direct</font></td>";
echo "</tr>";

echo "<tr>";
echo "<td width=\"14%\">&nbsp;</td>";
echo "<td width=\"18%\"><font size=\"1\" face=\"Tahoma\">Group Membership:&nbsp;</font></td>";
echo "<td width=\"21%\"><font size=\"1\" face=\"Tahoma\">Group1: $groupA</font></td>";
echo "<td width=\"21%\"><font size=\"1\" face=\"Tahoma\">Group2: $groupB</font></td>";
echo "<td width=\"24%\"><font size=\"1\" face=\"Tahoma\">Group3: $groupC</font></td>";
echo "</tr>";

echo "</table>";


}
?>

		</td>
	</tr>
	</table></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
