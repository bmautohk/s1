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
<META content="MSHTML 6.00.2900.2722" name=GENERATOR><meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">

<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD width="104%" height="100%" vAlign=top bgColor=#eefafc>
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb>&nbsp;</TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
           
<br>
<?
				if (isset($_REQUEST['issubmit'])) {
				$sql = "INSERT INTO ben_sale_group SET group_name = '".$_POST['group_name']."'";
				
				
			//echo "$sql";
			sqlinsert($sql);
								
				}
								
				?>

    <table width="448" border="0" cellpadding="10">
              <tr>
                <td width="304">
          <?
				if (isset($_REQUEST['isdelete'])) {
				$sql = "delete from ben_sale_group where group_id = '".$_POST['group_id']."'";
			//echo "$sql";
			sqlinsert($sql);
								
				}
								
				?>
		   <form name="form1" method="post" action="group_list.php">
		   <select name="group_id">
		  		   <?
		   $db=connectDatabase();
			mysql_select_db("SUPERIOR_AUTOPARTS",$db);
				$result = mysql_query("SELECT * FROM ben_sale_group order by group_name", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);

	echo "<option value=\"".$row["group_id"]."\">".$row["group_name"]."</option>";
	
	}
			
			
		   ?>		   
</select>  
<input name="isdelete" type="submit" id="isdelete" value="Delete">
<br>
  <br>
                      </form>           
        </td>
                <td width="98">&nbsp;</td>
              </tr>
            </table>			    
				
			   			   --------------------------------------------------------
			   			   <form name="form1" method="post" action="group_list.php">
                             <table width="297" border="0">
                  <tr>
                    <td width="67">Name ¡§</td>
                    <td><input name="group_name" type="text">
                      <input name="issubmit" type="submit" id="issubmit" value="Add"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="220">&nbsp;</td>
                  </tr>
                </table>
			   </form>
			    </TD>
        </TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
</BODY></HTML>
