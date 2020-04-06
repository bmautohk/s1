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

include('report/report_list_logic.php');
?>


<html>
<head>
<? require ('header_script.php');?>
<title>Print Report</title>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</head>

<body>
 <table width="1200" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><div align="center">Superior Summer <br>
       <br>       
     </div>
     <? 
 				 $date_start = $_GET['date_start'];
				 $date_end = $_GET['date_end'];
				 $sale_or = $_GET['sale_or'];
				 $sale_as = $_GET['sale_as'];
				 $mod = $_GET['mod'];
				 $mod2 = $_GET['mod2'];
				 if ($_GET['date_start']!='')
				 {
				 getOrderReport($date_start,$date_end,$sale_or,$sale_as,$mod,$mod2,"");
				  
				 }else
				 {
				 getOrderReport('','',$sale_or,$sale_as,$mod,$mod2,"");
				
				 }


?></td>
   </tr>
 </table>
</body>
</html>
