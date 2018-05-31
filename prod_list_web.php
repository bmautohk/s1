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

<META content="MSHTML 6.00.2900.2722" name=GENERATOR>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></HEAD>
<BODY bgColor=#000000 leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">

<table width="500" height="24" border="0" cellpadding="0" cellspacing="0">
              <tr valign="middle">
                <td height="24" align="center">
				
				  <br>
				  <?
$temp_link_sel='';


$cat_id = $_GET['cat_id'];
$temp_link_sel = "cat_id=".$cat_id."&";

if ($_GET['make_id']=='')
{$make_id='';} else {
$make_id = $_GET['make_id'];
$temp_link_sel = "make_id=".$make_id."&";

}

if ($_GET['model_id']=='')
{$model_id='';} else {
$model_id = $_GET['model_id'];
}



getmake_web($cat_id,$make_id);

getmodel_web($cat_id,$make_id,$model_id);

	
	@$product_name=$_POST['product_name'];
	@$product_id=$_POST['product_id'];
	$product_photo=$product_id;

	
?>
                  <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?>
                  <br>
				<font color=#FFFFFF>Page <?  
				if (isset ($_GET['prod_order']))
				{$prod_order = $_GET['prod_order'];}
				else
				{$prod_order = "product_id";}
				
				//display code
$page=$_GET['page'];

$db=connectDatabase();

mysql_select_db(MAIN_DB,$db);


    $per_page = 30; 

	if ($make_id=='')
	{$sql_text = "SELECT * FROM ben_product where cat_id='$cat_id' order by product_index DESC"; }
	else
	{$sql_text = "SELECT * FROM ben_product where cat_id='$cat_id' and make_id='$make_id' order by product_index DESC"; }
	

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
    echo "<a href=\"$PHP_SELF?".$temp_link_sel."page=$prev_page\">Prev</a>";
    }
    // Page # direct links 
    // If you don't want direct links to eac
    //     h page, you should be able to
    // safely remove this chunk.
    for ($i = 1; $i <= $num_pages; $i++) { 
    if ($i != $page) { 
    echo " <a href=\"$PHP_SELF?".$temp_link_sel."page=$i\">$i</a> "; 
    } else { 
    echo " $i "; 
    } 
    } 
    // Next 
    if ($page != $num_pages) { 
    echo "<a href=\"$PHP_SELF?".$temp_link_sel."page=$next_page\">Next</a> ";
    }
				?></font>
                <br>
                <br>                  
                <form name="form1" method="post" action="prod_list_add.php">
                  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?
   
    getprod_list_web($prod_order,$page_start, $per_page,$cat_id,$make_id);
 

   
				?>
                  </table>
                  <br>
                  <br>
				  <input name="pro_order" type="hidden" value="<?=$prod_order; ?>">
				  <input name="page_start" type="hidden" value="<?=$page_start; ?>">
                  <input name="per_page" type="hidden" value="<?=$per_page; ?>">
				  
                </form>
                <div align="center"><br>
				  
				
		        </div></td>
  </tr>
            </table>
</BODY></HTML>