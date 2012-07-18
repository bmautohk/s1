<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('../config.php');  //this should the the absolute path to the config.php file 
//(ie /home/website/yourdomain/login/config.php or 
//the location in relationship to the page being protected - ie ../login/config.php )
require('../functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above

if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
	include ('../no_access.html'); //this should the the absolute path to the no_access.html file - see above
	exit;
}

$added_message = '';

if (isset($_POST['cat_name'])) {
	$cat_name = trim($_POST['cat_name']);
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_cat where cat_name = '".$cat_name."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num=mysql_num_rows($result);
	
	if ($num != 0) {
		$added_message = "<font color='red'>The category name \"$cat_name\" has already existed.</font>";
	}
	else {
		$sql = "Insert into ben_cat SET
				cat_name = '$cat_name'";
	
		sqlinsert($sql);
		$added_message = "The new category name \"$cat_name\" is added.";
	}
}

?>

<LINK href="../style1.css" type=text/css rel=STYLESHEET>
<? require('../header_script.php'); ?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR><meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">

<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR>
<TD width="104%" height="100%" vAlign=top bgColor=#eefafc>
	<table width="537" border="0" cellspacing="0" cellpadding="0">
	<td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"></td>
		<tr><td height="50" width="150"><div align="center"></div></td></tr>
		<tr class="content">
			<td colspan="2">
				<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" name="form1" id="form1">
					<table width="350" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="80">Category:</td>
						<td><input name="cat_name" type="text">
                        <input name="isadd" type="submit" id="isadd" value="Add">
						</td>
					</tr>
					</table>
                    <br>
					<br>
					<br>
					<? echo $added_message;?>
				</form>
			</td>
		</tr>
	</table>
</TD>
</TR>
</TBODY>
</TABLE>
</BODY>