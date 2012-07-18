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

if (isset($_POST['issubmit'])) {
	$sql = "update authorize SET email_txt = '".$_POST['email_txt']."'  where username='".$_POST['sale_group']."'";
		
	//echo "$sql";
	sqlinsert($sql);
								
	}

if ($_GET['sale_group']!='')
	{$sale_group=$_GET['sale_group'];
	 $email_txt=getemail_txt_data($sale_group);}
if ($_POST['sale_group']!='')
	{$sale_group=$_POST['sale_group'];
	 $email_txt=getemail_txt_data($sale_group);}


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
          <TD height="360" vAlign=top bgColor=#eefafc>
           
<br>

    <br>
    <form name="form1" method="get" action="email_list.php">
    <? getgroup_select($sale_group); ?>
    <input type="submit" name="Submit" value="Select">
    </form>
    <br>
    --------------------------------------------------------
     <form name="form1" method="post" action="email_list.php">
    Content
    <table width="280" border="0">
                  <tr>
                    <td colspan="2"><input name="sale_group" type="hidden" value="<? echo $sale_group; ?>" >                      <br>                      <textarea name="email_txt" cols="50" rows="6" id="email_txt"><?=$email_txt; ?></textarea></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="180"><input name="issubmit" type="submit" id="issubmit" value="Update"></td>
                  </tr>
                </table>
          </form>		      </TD>
        </TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
</BODY></HTML>
