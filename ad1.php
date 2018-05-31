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
<script>
function ClearText(){

sup_info.sup_name.value="";
sup_info.sup_name.value="";
sup_info.sup_contact.value="";
sup_info.sup_phone.value="";
sup_info.sup_fax.value="";
sup_info.sup_email.value="";
sup_info.sup_add1.value="";
sup_info.sup_add2.value="";
sup_info.sup_add3.value="";

}
</script>
<script>
function CheckText(){
var name = sup_info.new_job_name;

if(name.value == null || name.value == ""){
		alert("New Job Name cannot be empty!");
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
      height=34>&nbsp;</TD>
  </TR>
  <TR>
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
                  href="order_main.php">Order</A></TD>
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
          <TD bgColor=#beddeb>&nbsp;            </TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>   
		  <form name="form2" method="post" action="ad1.php">
		    <table width="350" border="0" cellpadding="0" cellspacing="5">
              <tr>
                <td width="120">Make</td>
                <td width="104"><? 
						if (isset($_GET['make_id']))
						{getmake_selection($_GET['make_id']);}
						else
						{getmake_selection('');}
						
						?></td>
              </tr>
              <tr>
                <td>Model</td>
                <td><? 
						if (isset($_GET['make_id']))
						if ($_GET['make_id']!=''){
						{getmodel_selection($_GET['make_id']);
						}}
						?></td>
              </tr>
              <tr>
                <td>Category</td>
                <td><? getprod_cat('');	?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="isgo" type="submit" id="isgo" value="Go"> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
	            </form>
		       <form name="form1" method="post" action="table.php">
  <table width="400" border="1">
    <tr>
      <td width="111">Main Photo Link </td>
      <td width="273"><input name="pro_main" type="text" id="pro_main"></td>
    </tr>
    <tr>
      <td>Space</td>
      <td><input name="pro_space" type="text" id="pro_space"></td>
    </tr>
  </table>
  <br>
  <br>
  <br>
 

  
  
   

  
  <table width="602" border="1">
    <tr>
      <td width="75">No</td>
      <td width="166">Name</td>
      <td width="179">Link</td>
      <td width="154">Detail</td>
    </tr>
  <? 
  
    if (isset($_POST['isgo'])) {
    $db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$sql="SELECT * FROM ben_product where cat_id = $cat_id";
	if (isset($_POST['make_id'])) {$sql = $sql." and make_id=$make_id";}
	if (isset($_POST['model_id'])) {$sql = $sql." and model_id=$model_id";}
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
  $num_results=mysql_num_rows($result);
  
  for ($j=0;$j<$num_results;$j++) {
  $row=mysql_fetch_array($result);
  ?>
    <tr>
      <td><?=$j+1;?></td>
      <td><input name="pro_name_<?=$j+1;?>" type="text" id="pro_name" value="<?=$row["product_name"]; ?>">
      &nbsp;</td>
      <td><input name="pro_link_<?=$j+1;?>" type="text" id="pro_link" value="<? if ($row["product_photo"]!='') {echo "http://www.superior-autoparts.com/pro_image/".$row["product_photo"];} ?>">
      &nbsp;</td>
      <td><input name="pro_detail_<?=$j+1;?>" type="text" id="pro_link">&nbsp;</td>
    </tr>
  <? } }?>
  </table>
  <br>
  <br>
  <input name="issubmit" type="submit" id="issubmit" value="submit">
  <input name="pro_num" type="hidden" id="pro_num" value="<?=$num_results; ?>">
  <br>
</form>    <br>
            <br>
            <br>
            <br>
            <br></TD>
        </TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
