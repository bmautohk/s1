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
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<script>
function CheckText(){
var name = form1.model_name;

if(name.value == null || name.value == ""){
		alert("New model No cannot be empty!");
		name.focus();
		return false;
	}
	

}
</script>

<script>

function goToURL(obj) {
   //i = obj.listBox.selectedIndex;
   top.location = "<? echo $_SERVER['PHP_SELF']."?make_id="; ?>" + obj;
}

 </script>

</HEAD>



<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">

<script language="JavaScript">
<!--

/***********************************************
* Required field(s) validation v1.10- By NavSurf
* Visit Nav Surf at http://navsurf.com
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function formCheck(formobj){
	// Enter name of mandatory fields
	var fieldRequired = Array("product_id", "product_name");
	// Enter field description to appear in the dialog box
	var fieldDescription = Array("Product ID", "Product Name");
	// dialog message
	var alertMsg = "Please complete the following fields:\n";
	
	var l_Msg = alertMsg.length;
	
	for (var i = 0; i < fieldRequired.length; i++){
		var obj = formobj.elements[fieldRequired[i]];
		if (obj){
			switch(obj.type){
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "select-multiple":
				if (obj.selectedIndex == -1){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
				break;
			default:
			}
			if (obj.type == undefined){
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					alertMsg += " - " + fieldDescription[i] + "\n";
				}
			}
		}
	}

	if (alertMsg.length == l_Msg){
		return true;
	}else{
		alert(alertMsg);
		return false;
	}
}
// -->
</script>


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
          <TD width=5><IMG src="admin_menu_1_h.gif" 
            width=5></TD>
          <TD background="admin_menu_3_h.gif">
            <TABLE width="85" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="prod_add.php">Product List</A></TD>
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
    <TD vAlign=top bgColor=#eefafc colSpan=6 height="745">
      <TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><TABLE width="564" cellPadding=10>
            <TBODY>
              <TR>
                <TD width="155"><A class=standard 
                  href="prod_add.php">Add New Product </A></TD>
                <TD width="150"><A class=standard 
                  href="prod_list.php">Products List (Delete) </A></TD>
                <TD width="189"><A class=standard 
                  href="prod_search.php">Search Product</A></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            <p>&nbsp;            </p>
            <table width="677" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="568"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td height="18" bgcolor="#666666"><div align="left" class="whead"><? $added_message='';

if (isset($_POST['isadd']))
{
		
	$sql = "Insert into ben_model SET
		 model_name= '".$_POST['model_name']."',
		 make_id = '".$_POST['make_id']."'";
	
	sqlinsert($sql);
$added_message = "The new model name \"".$_POST['model_name']."\" is added.";

}?>

</div></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table width="537" border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td width="150"><div align="center">
                                  
                              </div></td>
                              <td colspan="2">
                                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" name="form1" id="form1" onSubmit="return CheckText()">
                    <table width="350" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="120">Make</td>
                        <td width="104">						 <? 
						if (isset($_GET['make_id']))
						{getmake_selection($_GET['make_id']);}
						else
						{getmake_selection('');}
						
						?>                        </td>
                      </tr>
                      <tr>
                        <td>Model</td>
                        <td><input name="model_name" type="text" id="model_name"></td>
                      </tr>
                    </table> 
                                    <br>
                                    <? if (isset($_GET['make_id']))
									{
									if ($_GET['make_id']!=''){
									?>
									<input name="isadd" type="submit" id="isadd" value="Add">
                                    <? }}?>
									<br>
									<br><br>
<? echo $added_message;?>
                                  </div>
                                </form>
                                <hr align="left">
                                <div align="left">                                </div></td>
                            </tr>
                          </table>
                          <br></td>
                    </tr>
                  </table></td>
                </tr>
           
            </table>
            <p><br>
            </p></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
