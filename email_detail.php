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
<? $email_no = $_GET['email_no']; 
$email_row=getemail_detail(trim($_GET['email_no']));

?>
<html>
<head>
<? require ('header_script.php'); ?>
<title>Email Page</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>

<body>
	
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<?
	
	$email_row=getemail_detail($email_no);
	echo $email_row['email_text'];

	?></td>
      </tr>
      <tr>
        <td>
          
          <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	</table>
	<br>
	
    <table width="700" border="0" cellspacing="0" cellpadding="0">
    </table>

</body>
</html>
