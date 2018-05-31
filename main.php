<?php
$groupCheckList = array("Administrators", "Suppliers", "Partners", "Users", "Wholesale");
include_once('security_check.php');
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
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<? require ('header_script.php');?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <? include_once("page_header.php");?>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=11 height="100%">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb>&nbsp;            </TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            <TABLE width="358" cellPadding=10>
              <TBODY>
              <TR>
                <TD width="332">
                  <P><FONT class=big>&nbsp;</FONT>
<font class="big"><strong><u><font color="brown">Welcome ! </font></u></strong></font></TD></TR></TBODY></TABLE>
            <TABLE width="500" cellPadding=10>
              <TBODY>
                <TR>
                  <TD width="332"><div align="left"><strong>JP ID </strong></div></TD>
                  <TD width="332"><div align="left"><strong>HK ID                    </strong></div></TD>
                </TR>
                <TR valign="top">
                  <TD><?
								   
				    if (($_SESSION[group1]==Admin_name) and ($_SESSION[group2]==Admin_name))
				   {$_SESSION[userlist]='YES';}
				   
	if ($_SESSION[userlist]=='YES') {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM authorize where group3='JP' order by username", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);


	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	//$group_id=$row["group_id"];
	$uname=$row["username"];
	$g2=$row["group2"];
	echo "<a href='main.php?uname=".$uname."&g2=".$g2."'>".$uname."</a><br>";
	
	}


				   
				   
				   }
				   ?></TD>
                  <TD width="332"><?
								   
				    if (($_SESSION[group1]==Admin_name) and ($_SESSION[group2]==Admin_name))
				   {$_SESSION[userlist]='YES';}
				   
	if ($_SESSION[userlist]=='YES') {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM authorize where group3='HK' order by username ", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);



	 for ($i=0;$i<$num_results;$i++)
        {

        $row=mysql_fetch_array($result);
	 if ($row["username"]=="ben"){
        //$group_id=$row["group_id"];
        $uname=$row["username"];
        $g2=$row["group2"];
        echo "<a href='main.php?uname=".$uname."&g2=".$g2."'>".$uname."</a><br>";
        break;
        }

        }

        $result = mysql_query("SELECT * FROM authorize where group3='HK' order by username ", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	for ($i=0;$i<$num_results;$i++)
	{

	$row=mysql_fetch_array($result);
	if ($row["username"]!="ben"){
	//$group_id=$row["group_id"];
	$uname=$row["username"];
	$g2=$row["group2"];
	echo "<a href='main.php?uname=".$uname."&g2=".$g2."'>".$uname."</a><br>";
	}
	
	}


				   
				   
				   }
				   ?></TD>
                </TR>
              </TBODY>
            </TABLE>
            <br>
            <br></TD>
        </TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
