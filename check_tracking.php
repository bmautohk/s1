<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above


?>
<? 
$sale_ref = '';
if ($_POST['sale_ref']);
$sale_ref = $_POST['sale_ref']; 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<? require ('header_script.php'); ?>
<title>Superior</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</head>

<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb>&nbsp;</TD>
        </TR>
        <TR>
          <TD vAlign=top bgColor=#eefafc>
            
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
	<table width="500" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="190">Please, fill in your order no. :</td>
    <td width="310"><input name="sale_ref" type="text" value="<? echo $sale_ref;?>"></td>
  </tr>
  <tr>
    <td>Tracking NO: </td>
    <td><?
	
	
    $ship_row=getship_data($sale_ref);
    echo "".$ship_row['check_shipping']."<br>";

	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="Submit" type="submit" value="Submit"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Please, contact us at info@superior-autoarts.com </td>
    </tr>
</table>
<br>
<br>
	</form>
<p>&nbsp;</p>
          </TD></TR></TBODY></TABLE>
	
</body>
</html>
