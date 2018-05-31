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

function goToURL(obj) {
   //i = obj.listBox.selectedIndex;
   top.location = "<? echo $_SERVER['PHP_SELF']."?product_id=".$_GET['product_id']."&make_id="; ?>" + obj;
}

 </script>
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
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?>
            </p>
            <table width="677" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="400"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td height="18" bgcolor="#666666"><div align="left" class="whead">&nbsp;<span class="style1">Upload your own picture</span></div></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table width="400" border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td width="150"><div align="center">
                                  <?php

require("fileupload-class.php");

$upload_message = "<font color='red'>Please upload your picture</font>";

#--------------------------------#
# Variables
#--------------------------------#

// The path to the directory where you want the 
// uploaded files to be saved. This MUST end with a 
// trailing slash unless you use $path = ""; to 
// upload to the current directory. Whatever directory
// you choose, please chmod 777 that directory.

	$path = "pro_image/";

// The name of the file field in your form.

	$upload_file_name = "userfile";

// ACCEPT mode - if you only want to accept
// a certain type of file.
// possible file types that PHP recognizes includes:
//
// OPTIONS INCLUDE:
//  text/plain
//  image/gif
//  image/jpeg
//  image/png
	
	// Accept ONLY gifs's
	#$acceptable_file_types = "image/gifs";
	
	// Accept GIF and JPEG files
	$acceptable_file_types = "../image/jpeg|image/pjpeg";
	
	// Accept ALL files
	#$acceptable_file_types = "";

// If no extension is supplied, and the browser or PHP
// can not figure out what type of file it is, you can
// add a default extension - like ".jpg" or ".txt"

	$default_extension = "";

// MODE: if your are attempting to upload
// a file with the same name as another file in the
// $path directory
//
// OPTIONS:
//   1 = overwrite mode
//   2 = create new with incremental extention
//   3 = do nothing if exists, highest protection

	$mode = 1;
	
	
#--------------------------------#
# PHP
#--------------------------------#
	if (isset($_REQUEST['submitted'])) {
	
	$product_name=$_POST['product_name'];
	$product_id=$_POST['product_id'];
	$product_pcs=$_POST['product_pcs'];
	$make_id=$_POST['make_id'];
	$model_id=$_POST['model_id'];

	$product_stock_level=$_POST['product_stock_level'];
	$product_stock_jp=$_POST['product_stock_jp'];
	
	$product_location=$_POST['product_location'];
	
	$product_colour=$_POST['product_colour'];
	$product_remark=$_POST['product_remark'];


	
	
	
	
	$product_photo=$product_id;
	if (getprod_data($product_id)!='' and $product_id!=$_GET['product_id'])
	{echo "<html><meta http-equiv='refresh' content='0; URL=prod_mod.php?mod=same_id&product_id=".$_GET['product_id']."'></html>";
	exit; }
	//remove dit and photo
	 
	$o_getprod_row = getprod_data($product_id);
	$o_product_photo=$o_getprod_row["product_photo"];
	$o_product_dit=$o_getprod_row["product_dit"];
	
	
	
	$o_pro_image = "pro_image/".$o_product_photo;
	$o_pro_dit = "dit_file/".$o_product_dit;
	
	if ($_POST['chk_photo']==1){
	unlink($o_pro_image);
	$product_photo='';}else {$product_photo=$o_product_photo;}
	if ($_POST['chk_dit']==1){
	unlink($o_pro_dit);
	$dit_name='';}else {$dit_name=$o_product_dit;} 

	
	//----------------------Sumit Dit File
	
	if ($_FILES["dit_file"]['name']!=""){
			
	if ($o_product_dit!='' and $_POST['chk_dit']!=1){
	unlink($o_pro_dit);}
	
	$uploaddir = 'dit_file/'; 
	$uploaddit = $uploaddir . $_FILES['dit_file']['name']; 
	$fileOK=true;
	//echo $uploadfile."<br>";
	//echo $_FILES['dit_file']['tmp_name'];
	$getExt = substr ($_FILES['dit_file']['name'],strrpos($_FILES['dit_file']['name'],'.'),strlen ($_FILES['dit_file']['name']));
	$uploaddit = $uploaddir . $product_id . $getExt; 
	$dit_name = $product_id . $getExt;	
	if (move_uploaded_file($_FILES['dit_file']['tmp_name'], $uploaddit)) { 
   		//echo "File is valid, and was successfully uploaded. "; 
   		//echo "Here's some more debugging info:\n"; 
	//print_r($_FILES);
	} 
	else {
	$fileOK=false;
   print "Possible file upload attack!  Here's some debugging info:\n";

   }
 } 
   //--------------------------------------end file submit
   
	
		/* 
			A simpler way of handling the submitted upload form
			might look like this:
			
			$my_uploader = new uploader('en'); // errors in English
	
			$my_uploader->max_filesize(30000);
			$my_uploader->max_image_size(800, 800);
			$my_uploader->upload('userfile', 'image/gif', '.gif');
			$my_uploader->save_file('uploads/', 2);
			
			if ($my_uploader->error) {
				print($my_uploader->error . "<br><br>\n");
			} else {
				print("Thanks for uploading " . $my_uploader->file['name'] . "<br><br>\n");
			}
		*/
			
		// Create a new instance of the class
		$my_uploader = new uploader('en'); // for error messages in french, try: uploader('fr');
		
		// OPTIONAL: set the max filesize of uploadable files in bytes
		$my_uploader->max_filesize(1024000);
		
		// OPTIONAL: if you're uploading images, you can set the max pixel dimensions 
		$my_uploader->max_image_size(1500, 1500); // max_image_size($width, $height)
		
				
		// UPLOAD the file
		//Remove file
		if ($_FILES["userfile"]['name']!=""){
		if ($o_product_photo!='' and $_POST['chk_photo']!=1){
		unlink($o_pro_image);}
		
		}
		//add
		if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
			$my_uploader->save_file($path, $mode, $product_id);
		}
		
		if ($my_uploader->error) {
			echo $my_uploader->error . "<br><br>\n";
		$sql = "UPDATE ben_product SET product_id = '$product_id', product_name = '$product_name',product_photo = '$product_photo',product_dit = '$dit_name'
				,cat_id = '$cat_id',
				product_price_u = $product_price_u,
				product_price_s = $product_price_s, 
				make_id = '$make_id',
				model_id = '$model_id', 
				product_pcs = '$product_pcs',
				product_stock_level = '$product_stock_level',
				product_stock_jp = '$product_stock_jp',
			    product_location = '$product_location',
				product_colour = '$product_colour',
				product_remark = '$product_remark',
				product_web = '$product_web' where product_id = '".$_GET['product_id']."'";
			
			//echo "$sql";
			sqlinsert($sql);
		} else {
		
		
			$product_photo=$product_id.$my_uploader->file['extention'];
			
			$sql = "UPDATE ben_product SET product_id = '$product_id', product_name = '$product_name',product_photo = '$product_photo',product_dit = '$dit_name'
			,cat_id = '$cat_id',product_price_u = $product_price_u
			product_price_s = $product_price_s, 
			make_id = '$make_id',
			model_id = '$model_id', 
			product_pcs = '$product_pcs',
			product_stock_level = '$product_stock_level',
			product_stock_jp = '$product_stock_jp',
			product_location = '$product_location',
			product_colour = '$product_colour',
			product_remark = '$product_remark',
			product_web = '$product_web' where product_id = '".$_GET['product_id']."'";
			//echo "$sql";
			sqlinsert($sql);
			//$result = mysql_query($sql); 


						
			// Successful upload!
			
			//print($my_uploader->file['name'] . " was successfully uploaded!");
			$upload_message = "Your picture was successfully uploaded!";
			
			// Print all the array details...
			//print_r($my_uploader->file);
			
			// ...or print the file
			if(stristr($my_uploader->file['type'], "image")) {
				echo "<img src=\"image.php?w=120&h=120&name=" . $product_id.$my_uploader->file['extention'] . "\" border=\"0\" alt=\"\">";
			} else {
				$fp = fopen($path . $my_uploader->file['name'], "r");
				while(!feof($fp)) {
					$line = fgets($fp, 255);
					echo $line;
				}
				if ($fp) { fclose($fp); }
			}
			
 		}
 	}
else {
if (@$product_photo =='') {$disply_photo = "images/002.gif";} else {$disply_photo = "image.php?w=120&h=120&name=".@$product_photo;}
echo "<img src=\"".$disply_photo."\" >";

}


#--------------------------------#
# HTML FORM
#--------------------------------#
?>
                              </div></td>
                              <td colspan="2">
                                <form action="<?= $_SERVER['PHP_SELF']."?product_id=".$product_id; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return formCheck(this);">
                                  <div align="left">
                    <? 
			
			 echo "<input type='hidden' name='ID' value='".@$ID."'>"; 
			 ?>
			 <? 
					if (isset($_GET['mod']))
					echo "<font color=red>Please, use different Product ID</font>";
					
					?>
                    <? //$product_id = $_GET['product_id']; 
$getprod_row = getprod_data ($product_id)

?>
                    <br>
                    <table width="245" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td>Make</td>
                        <td><? 
						 if (!isset($_GET['make_id']) )
						 {
						$make_id= $getprod_row['make_id'];
						getmake_selection($make_id);
						}
						else
						{
						$make_id =$_GET['make_id'] ;
						getmake_selection($make_id);
						}
						
						
						?></td>
                      </tr>
                      <tr>
                        <td>Model</td>
                        <td><? 
						
						 if (isset($_GET['make_id']) )
						 {
						getmodel_selection($_GET['make_id']);
						echo "<a href=\"add_model.php?make_id=".$_GET['make_id']."\" target=\"_blank\">add model</a>";
						}
						 
						 else
						 {
						if ($getprod_row['model_id']!='')
						$model_id = $getprod_row['model_id'];
						{getmodel_data($model_id);}
						}
						
						
						
						
						
						?></td>
                      </tr>
                      <tr>
                        <td width="120">Model Code  </td>
                      <td width="104"><? 
			 echo $product_id;
			  ?><input name="product_id" type="hidden" value="<?=$product_id ?>"></td>
                      </tr>
                      <tr>
                        <td>Product Name</td>
                      <td><? 
			 echo "<input type=text name='product_name' value='".$getprod_row['product_name']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Category</td>
						<td><? getprod_cat($getprod_row['cat_id']);	?></td>
                      </tr>
                      <tr>
                        <td>User Price </td>
                        <td>&yen;                          <? 
			 echo "<input type=text name='product_price_u' value='".$getprod_row['product_price_u']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>PCS</td>
                        <td><? 
			 echo "<input type=text name='product_pcs' value='".$getprod_row['product_pcs']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>PCS (JP)</td>
                        <td><? 
			 echo "<input type=text name='product_stock_jp' value='".$getprod_row['product_stock_jp']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Stock Level </td>
                        <td><? 
			 echo "<input type=text name='product_stock_level' value='".$getprod_row['product_stock_level']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td><? 
			 echo "<input type=text name='product_location' value='".$getprod_row['product_location']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Colour</td>
                        <td><? 
			 echo "<input type=text name='product_colour' value='".$getprod_row['product_colour']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Remark</td>
                        <td><? 
			 echo "<input type=text name='product_remark' value='".$getprod_row['product_remark']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>User Price </td>
                        <td>&yen;
                            <? 
			 echo "<input type=text name='product_price_u' value='".$getprod_row['product_price_u']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Suppliers Price </td>
                        <td>&yen;                          <? 
			 echo "<input type=text name='product_price_s' value='".$getprod_row['product_price_s']."'>";
			  ?></td>
                      </tr>
                      <tr>
                        <td>Display on Web </td>
                        <td><input name="product_web" type="checkbox" id="product_web" value="1" <?if  ($getprod_row['product_web']!="") {echo "checked";} ?>></td>
                      </tr>
                    </table> 
                                    <br>
                    <input type="hidden" name="submitted" value="true">
                  Upload photo:<br>
                  <br>
                  <input name="<?= $upload_file_name; ?>" type="file" class="content">
                  <br>
                  <?
				  if  ($getprod_row['product_photo']!="") {
				  echo "Delete: <input name=\"chk_photo\" type=\"checkbox\" id=\"chk_photo\" value=\"1\" >";
				  echo "<a href='pro_image/".$getprod_row['product_photo']."' target=_blank>".$getprod_row['product_photo']."</a>";
				  } 
				  
				  ?>                  
                  <br>
                  <br>
                  Upload Dit file:<br>
                  <input name="dit_file" type="file" class="content">
                  <br>
                  <?
				  if  ($getprod_row['product_dit']!="") {
				  echo "Delete: <input name=\"chk_dit\" type=\"checkbox\" id=\"chk_dit\" value=\"1\" >";
				  echo "<a href='dit_file/".$getprod_row['product_dit']."' target=_blank>".$getprod_row['product_dit']."</a>";
				  } 
				  
				  ?>
                  <br>
                  <br>
                  <input name="submit" type="submit" class="content" value="Submit">
                                  </div>
                                </form>
                                <hr align="left">
                                <div align="left">
                                <?php
	
	
	if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
		echo "The best upload image size is 1024 * 768 px.<br> Image size is limited at 1MB.<br>Image only support jpeg.<br><br> ";
	}
	
echo $upload_message;

?></div></td>
                            </tr>
                          </table>
                          <br></td>
                    </tr>
                  </table></td>
                </tr>
              <? for ($fCount=0;$fCount<1;$fCount++)   { ?>
              <? } ?>
            </table>
            <p><br>
            </p></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
