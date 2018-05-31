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


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>
<script LANGUAGE="JavaScript">
<!--

function cDelete()
{
var agree=confirm("Are you confirm to delete the item?");
if (agree)
	return true ;
else
	return false ;
}
// -->
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
<META content="MSHTML 6.00.2900.2722" name=GENERATOR>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</HEAD>
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
          <TD bgColor=#beddeb><TABLE width="650" cellPadding=5>
            <TBODY>
              <TR>
                <TD width="120"><A class=standard 
                  href="prod_add.php">Add New Product </A></TD>
                <TD width="116"><A class=standard 
                  href="prod_list.php">Products List </A></TD>
                <TD width="146"><A class=standard 
                  href="prod_search.php">Search Product</A></TD>
                <TD width="216"><A class=standard 
                  href="prod_list_stock.php">Products List (Out of Stock) </A></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            <p>
              <?

	
	@$product_name=$_POST['product_name'];
	@$product_id=$_POST['product_id'];
	$product_photo=$product_id;

	
?>
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?></p>
            <table width="939" height="24" border="0" cellpadding="0" cellspacing="0">
              <tr valign="middle">
                <td height="24" align="center">
				
				<br>
				Page <?  
				if (isset ($_GET['prod_order']))
				{$prod_order = $_GET['prod_order'];}
				else
				{$prod_order = "product_id";}
				
				//display code
$page=$_GET['page'];

$db=connectDatabase();

mysql_select_db("autopart_db",$db);


    $per_page = 30; 

    $sql_text = "SELECT * FROM ben_product order by product_id DESC"; 

    // Set page #, if no page isspecified, a
				    //     ssume page 1 

    if (!$page) { 
    $page = 1; 
    } 
    $prev_page = $page - 1; 
    $next_page = $page + 1; 
    $query = mysql_query($sql_text,$db);
    // Set up specified page 
    $page_start = ($per_page * $page) - $per_page; 
    $num_rows = mysql_num_rows($query); 
    if ($num_rows <= $per_page) { 
    $num_pages = 1; 
    } else if (($num_rows % $per_page) == 0) { 
    $num_pages = ($num_rows / $per_page); 
    } else { 
    $num_pages = ($num_rows / $per_page) + 1; 
    } 
    $num_pages = (int) $num_pages; 
    if (($page > $num_pages) || ($page < 0)) { 
    error("You have specified an invalid page number"); 
    } 
    // 
    // Now the pages are set right, we can 
    // perform the actual displaying... 
    if ($prev_page) {
    echo "<a href=\"$PHP_SELF?page=$prev_page\">Prev</a>";
    }
    // Page # direct links 
    // If you don't want direct links to eac
    //     h page, you should be able to
    // safely remove this chunk.
    for ($i = 1; $i <= $num_pages; $i++) { 
    if ($i != $page) { 
    echo " <a href=\"$PHP_SELF?page=$i\">$i</a> "; 
    } else { 
    echo " $i "; 
    } 
    } 
    // Next 
    if ($page != $num_pages) { 
    echo "<a href=\"$PHP_SELF?page=$next_page\">Next</a> ";
    }
				?>
                <br>
                <br>                  
                <form name="form1" method="post" action="prod_list_add.php">
                  <table width="1046" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr align="center" valign="top">
                      <td width="61" height="30"><div align="center">Product ID</div></td>
                      <td width="87"><div align="center">Product Name </div></td>
                      <td width="82"><div align="center">Photo</div></td>
                      <td width="74"><div align="center">Modify<br> 
                        (+/-) </div></td>
					  <td width="63"><div align="center">Modify JP<br>
					    (+/-) </div></td>
                      <td width="67">Real Stock PCS</td>
					  <td width="54">JP </td>
                      <td width="78">PCS-ORDER</td>
                      <td width="47">Color</td>
                      <td width="62">Price (Users)</td>
                      <td width="68">Price (Supplier) </td>
                      <td width="69">Catogery</td>
                      <td width="22">Web</td>
                      <td width="47"><div align="center">Dit</div></td>
                      <td width="57">Loc.</td>
                      <td width="74"><div align="center">Delete</div></td>
                    </tr>
                    <tr valign="top">
                      <td height="25">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><div align="center">&nbsp; </div></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
					  <td>&nbsp;</td>
					   <td>&nbsp;</td>
                    </tr>
                    <?
   
    getprod_list($prod_order,$page_start, $per_page);
 

   
				?>
                  </table>
                  <br>
                  <br>
				  <input name="pro_order" type="hidden" value="<?=$prod_order; ?>">
				  <input name="page_start" type="hidden" value="<?=$page_start; ?>">
                  <input name="per_page" type="hidden" value="<?=$per_page; ?>">
				  
			      <input type="submit" name="Submit" value="Submit">
                </form>
                <div align="center"><br>
				  
				
				    </div></td>
                </tr>
            </table>
            <p>&nbsp;</p></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
