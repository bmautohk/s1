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
<?

	if (isset($_REQUEST['submitted'])) {
	@$sale_ref=$_GET['sale_ref'];

	$product_photo=getreturn_next();
	 $photo_id = getreturn_next() ;
	}
	
?>

<?
$debt_remark ='';
if (isset($_GET['sale_ref']) and getbal_data($_GET['sale_ref']))
{
$sale_ref=$_GET['sale_ref'];
$row = getbal_data($sale_ref);
$bal_pay=$row['bal_pay'];
$bal_pay_type=$row['bal_pay_type'];
$bal_ship_type=$row['bal_ship_type'];
$row_debt = getdebt_data($sale_ref);
$debt_remark = $row_debt['debt_remark'];
}
else{
$bal_pay='';
$row_debt = getdebt_data($sale_ref);
$debt_remark = $row_debt['debt_remark'];

}

//----------------------------------
if (isset($_GET['sale_ref']) and getreturn_data($_GET['sale_ref']))
{
$sale_ref=$_GET['sale_ref'];
$return_row = getreturn_data($sale_ref);

$return_pay=$return_row['return_pay'];
$return_remark=$return_row['return_remark'];
$return_track=$return_row['return_track'];
$return_date=$return_row['return_date'];}
else{
$return_pay='';
$return_remark='';
$return_track='';
$return_date='';
}
//========================================

if (isset($_GET['sale_ref']))
{$sale_ref=$_GET['sale_ref'];}

if (isset($_POST['isupdate']) and $_POST['bal_pay']!='')
		{
$sale_ref=$_POST['sale_ref'];

if (!getbal_data($sale_ref)) {

$sqla = "INSERT INTO ben_bal SET
bal_ref='".$_POST['sale_ref']."',
bal_pay='".$_POST['bal_pay']."',
bal_pay_type='".$_POST['bal_pay_type']."',
bal_ship_type='".$_POST['bal_ship_type']."',
bal_dat = curdate()";
		 
sqlinsert($sqla);
$row = getbal_data($sale_ref);
$bal_pay=$row['bal_pay'];
$bal_pay_type=$row['bal_pay_type'];
$bal_ship_type=$row['bal_ship_type'];
}
else 
{
if ($_POST['return_date']=='') {
//update bal note
$sqla = "Update ben_bal SET
bal_pay='".$_POST['bal_pay']."',
bal_pay_type='".$_POST['bal_pay_type']."',
bal_ship_type='".$_POST['bal_ship_type']."',
bal_dat = curdate() where bal_ref= '".$_POST['sale_ref']."'";

sqlinsert($sqla);
$row = getbal_data($sale_ref);
$bal_pay=$row['bal_pay'];
$bal_pay_type=$row['bal_pay_type'];
$bal_ship_type=$row['bal_ship_type'];


//$bal_return=$row['bal_return'];
$check = "update";
								}
}
		}
// insert return
if (isset($_POST['isupdate']) and (isset($_POST['return_pay']) or isset($_POST['return_remark']) or isset($_POST['return_track'])))
		{
$sale_ref=$_POST['sale_ref'];

if (!getreturn_data($sale_ref)) {
if ($_POST['return_date']=='')
{$return_date_t = "NULL";} else {$return_date_t = "'".$_POST['return_date']."'";}

$sqla = "INSERT INTO ben_return SET
return_ref='".$_POST['sale_ref']."',
return_remark='".$_POST['return_remark']."',
return_track='".$_POST['return_track']."',
return_pay='".$_POST['return_pay']."',
return_date=".$return_date_t.",
return_dat = curdate()";
		 
sqlinsert($sqla);
$row = getreturn_data($sale_ref);
$return_pay=$row['return_pay'];
$return_remark=$row['return_remark'];
$return_track=$row['return_track'];
$return_date=$row['return_date'];

}
else 
{
if ($_POST['return_date']=='')
{$return_date_t = "NULL";} else {$return_date_t = "'".$_POST['return_date']."'";}

//update debt note
$sqla = "Update ben_return SET
return_remark='".$_POST['return_remark']."',
return_pay='".$_POST['return_pay']."',
return_track='".$_POST['return_track']."',
return_date=".$return_date_t.",
return_dat = curdate() where return_ref= '".$_POST['sale_ref']."'";

sqlinsert($sqla);
$row = getreturn_data($sale_ref);
$return_pay=$row['return_pay'];
$return_remark=$row['return_remark'];
$return_track=$row['return_track'];
$return_date=$row['return_date'];
}
		}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML><HEAD><TITLE>Administrative tools</TITLE>

<script language="javascript" src="cal2.js"></script>
<script language="javascript" src="cal_conf2.js"></script>

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
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<? require ('header_script.php');?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<? //echo $sqla;?>
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
          <TD width=5><IMG src="admin_menu_1_h.gif" 
            width=5 height="39"></TD>
          <TD background="admin_menu_3_h.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="order_main.php">Order</A></TD>
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
          <TD bgColor=#beddeb><TABLE cellPadding=10>
            <TBODY>
              <TR>
                <TD><a href="http://www.apmzone.com/ben/order_add.php">Add New sales</a> </TD>
                <TD>&nbsp;</TD>
              </TR>
            </TBODY>
          </TABLE></TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
           
<br>
<table width="600" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>
	<font color="red">
		<? 
	echo "Order No. :".$sale_ref."<br>";
	$getsale_row=getsale_data($sale_ref);
	echo "Sale Date: ";
	echo $getsale_row['sale_date']."<br>";
	echo "Client Name: ";
	echo $getsale_row['sale_name']."<br>";
	echo "Client Email: ";
	echo $getsale_row['sale_email']."<br>";
	echo "Client Yahoo ID: ";
	echo $getsale_row['sale_yahoo_id']."<br>";
	
	echo "<br><br>";
	getsale_prod($sale_ref); 
	?></font>
	
	</td>
  </tr>
</table>

            
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']."?sale_ref=".$sale_ref; ?>">
              <table width="806" height="269" border="0" cellspacing="10">
                <tr>
                  <td width="650" valign="top"><table width="775" height="154" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="131" valign="top">Payment :</td>
                        <td>&yen;
                          <input name="bal_pay" type="text" class="standard" id="bal_pay" value="<? echo $bal_pay;?>"></td>
                        <td width="87"><div align="left">Payment Type:</div></td>
                        <td width="262"><div align="left">JNB
                              <input name="bal_pay_type" type="radio" value="JNB" <? if ($bal_pay_type=='JNB') {echo "checked";} ?>>
                            Bank
                            <input name="bal_pay_type" type="radio" value="Bank" <? if ($bal_pay_type=='Bank') {echo "checked";} ?>>
                            Yahoo
                            <input name="bal_pay_type" type="radio" value="Yahoo" <? if ($bal_pay_type=='Yahoo') {echo "checked";} ?>>
                            Post Office                          
                            <input name="bal_pay_type" type="radio" value="Post Office" <? if ($bal_pay_type=='Post Office') {echo "checked";} ?>>
                        </div></td>
                      </tr>
                      <tr>
                        <td valign="top">Rest Payment :</td>
                        <td width="158">
						&yen;
						<? 
						
						$sale_row = getsale_data($sale_ref);
						
						$sale_tax = $sale_row['sale_tax'];
						$sale_discount = $sale_row['sale_discount'];
						$sale_ship_fee = $sale_row['sale_ship_fee'];
						
						$sub_total = getsale_total($sale_ref);
						
						$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	
						
						$balance = number_format($total - $bal_pay,2,'.','');
						echo $balance;
												 ?>
						
						</td>
                        <td>Shipping Tpye:</td>
                        <td>COD
                          <input name="bal_ship_type" type="radio" value="COD" <? if ($bal_ship_type=='COD') {echo "checked";} ?>>
                          Charge Buyer 
                          <input name="bal_ship_type" type="radio" value="CB" <? if ($bal_ship_type=='CB') {echo "checked";} ?>>
                          None
                          <input name="bal_ship_type" type="radio" value="" >
</td>
                      </tr>
                      <tr>
                        <td valign="top">&nbsp;</td>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top">Re- send Tracking : </td>
                        <td colspan="3">
                          <p>
                                <input name="return_track" type="text" class="standard" id="return_track" value="<? echo $return_track;?>">
                                <br>
                                <br>
                          </p>
                      </td></tr>
                      <tr>
                        <td valign="top">Re - send Date : </td>
                        <td colspan="3"> 
						 <input name="return_date" type="text" value="<? echo $return_date; ?>" size=20>
                          <small><a href="javascript:showCal('Calendar')">Select Date</a></small>
                          <? 
						//if ($return_date!='')
						/*echo "<script>DateInput('return_date', true, 'YYYY-MM-DD','$return_date')</script>";
						else 
                        echo "<script>DateInput('return_date', true, 'YYYY-MM-DD')</script>";
						*/
						?>
                          <br>
                          <br></td>
                      </tr>
                      <tr>
                        <td valign="top">Remark : </td>
                        <td colspan="3"> <? echo $debt_remark;?>                         <br>
                          <br></td>
                      </tr>
                      <tr>
                        <td valign="top">Return</td>
                        <td colspan="3">&yen;
                          <input name="return_pay" type="text" class="standard" value="<? echo $return_pay;?>"></td>
                      </tr>
                    </table>
                      <br>
                      <input name="isupdate" type="submit" id="isupdate" value="Update">
                      <input name="sale_ref" type="hidden" value="<? echo $sale_ref;?>">
                      <br></td>
                </tr>
              </table>
            </form>
            
            <?
			
			// if ($debt_email!='') {
			$sale_row = getsale_data($sale_ref);
			$sale_email = $sale_row['sale_email'];
			if ($sale_email!='') {
			$group_row=getgroup_sale_data($sale_ref);
			$group3=$group_row["group3"];
			?>
            <br>
			    <table width="448" height="24" border="0" cellpadding="10">
              <tr>
                <td width="354">
				
           <form name="form2" method="get" target="_blank" action="balance_email.php">
		    After Payment <br>
  <br>
  <!--<input type="submit" name="Submit" value="Sent Email to client">-->
  <input name="Submit" type="Submit" id="preview" value="Preview">  
  <input name="outlook" type="Submit" id="outlook" value="Preview Outlook">  
  <input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
  <input name="group3" type="hidden" id="group3" value="<? echo $group3;?>">

           </form>           
        </td>
                <td width="48">&nbsp;</td>
              </tr>
            </table>
			    <br>
			    <? }			?>
<br>
            <br>
			
			
            <table width="800" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="400"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td height="18" bgcolor="#666666"><div align="left" class="whead">&nbsp;<span class="style1">Upload your Return pictures</span></div></td>
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

	$path = "return_photo/";

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
		if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
			$my_uploader->save_file($path, $mode, $photo_id);
		}
		
		if ($my_uploader->error) {
			echo $my_uploader->error . "<br><br>\n";
		
		} else {
		/*
				$connection = @mysql_connect('localhost', 'amen', 'amen338')
				or die(mysql_error());
				
				$db = @mysql_select_db('ben',$connection)
				or die(mysql_error());
		*/
		
			$product_photo=$photo_id.$my_uploader->file['extention'];
			
			$sql = "INSERT INTO ben_return_photo SET return_ref = '$sale_ref', return_photo = '$product_photo'";
			
			sqlinsert($sql);
			//echo $sql;
			//$result = mysql_query($sql); 


						
			// Successful upload!
			
			//print($my_uploader->file['name'] . " was successfully uploaded!");
			$upload_message = "Your picture was successfully uploaded!";
			
			// Print all the array details...
			//print_r($my_uploader->file);
			
			// ...or print the file
			if(stristr($my_uploader->file['type'], "image")) {
				echo "<img src=\"return_image.php?w=120&h=120&name=".$photo_id.$my_uploader->file['extention'] . "\" border=\"0\" alt=\"\">";
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
//if (@$product_photo =='') {$disply_photo = "images/002.gif";} else {$disply_photo = "return_image.php?w=120&h=120&name=".@$product_photo;}
//echo "<img src=\"".$disply_photo."\" >";

}


#--------------------------------#
# HTML FORM
#--------------------------------#
?>
                              </div></td>
                              <td colspan="2">
                                <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']."?sale_ref=".$sale_ref; ?>" method="POST">
                                  <div align="left">
                    <? 
			
			 echo "<input type='hidden' name='ID' value='".@$ID."'>"; 
			 ?>
                    <br>
                    
                     
                    <? 
			 echo "<input type=hidden name='sale_ref' value='".@$sale_ref."'>";
			  ?>
                    <br>
                    <input type="hidden" name="submitted" value="true">
                  Upload this file:<br>
                  <input name="<?= $upload_file_name; ?>" type="file" class="content">
                  <br>
                  <br>
                  <br>
                  <input name="submit" type="submit" class="content" value="Submit">
                                  </div>
                                </form>
                                <hr align="left">
                                <div align="left">
                                <?php
	
	
	if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
		echo "The best upload image size is 800 * 600 px.<br> Image size is limited at 1MB.<br>Image only support jpeg.<br><br> ";
	}
	
echo $upload_message;

?></div></td>
                            </tr>
                          </table>
                          <br></td>
                    </tr>
                  </table>
                  <br>
                  <? getreturn_list(@$sale_ref);?></td>
                </tr>
              <? for ($fCount=0;$fCount<1;$fCount++)   { ?>
              <? } ?>
            </table>
           
            </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
