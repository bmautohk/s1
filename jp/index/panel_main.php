<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('../../config.php');  //this should the the absolute path to the config.php file 
                                    //(ie /home/website/yourdomain/login/config.php or 
                                    //the location in relationship to the page being protected - ie ../login/config.php )
require('../../functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above



?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=Shift_JIS">
<meta http-equiv="pragma" content="no-cache">
<meta name="description" content="車のドレスアップパーツの製造販売。ホイールやインテリアパーツ等の製造販売。">
<title>Superior-Autoparts</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>

function goToURL(obj) {
   //i = obj.listBox.selectedIndex;
   top.location = "<? echo $_SERVER['PHP_SELF']."?cat_id=1&start=0&amount=6&make_id="; ?>" + obj;
}

 </script>
<? require ('../../header_script.php');?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.whitefont {color: #FFFFFF}
-->
</style>
</head>
<body bgcolor="#000000" leftmargin="0" topmargin="0" onLoad="MM_preloadImages('img/b/b_top_on.gif','img/b/b_product_on.gif','img/b/b_about_on.gif','img/b/b_seikyuu_on.gif','img/b/b_pub_on.gif','img/b/b_mailorder_on.gif','img/b/b_download_on.gif','images/bt_newlist_on.gif','images/bt_07_over.jpg','images/dad_benz_on.jpg','images/bt_09_over.jpg','images/bt_12_on.jpg')">
<table border="0" cellpadding="0" cellspacing="0" width="914">
  <tr> 
    <td colspan="11">
	<table border="0" cellpadding="0" cellspacing="0" width="700" background="top.jpg" height="70" bgcolor="#000000">
        <tr height="50"> 
          <td height="69">&nbsp;
		  </td>
        </tr>
        <tr> 
          <td><img src="b_bar.gif" width="70" height="20" border="0"><a href="index.html" onMouseOver="MM_swapImage('Image9','','img/b/b_top_off.gif',1)" onmouseout="MM_swapImgRestore()" href="http://www.superior-autoparts.com//jp/index/index.html"><img height="20" alt="TOPへ戻ります" src="b_top_off.gif" width="70" border="0" name="Image36" oSrc="b_top_off.gif"></a><a onmouseover="MM_swapImage('Image30','','img/b/b_product_on.gif',1)" onmouseout="MM_swapImgRestore()" href="main.html"><img height="20" alt="SuperiorカタログをWEBでご覧いただけます" src="b_product_off.gif" width="70" border="0" name="Image37"></a><a href="aboutus.htm"><img src="b_about_off.gif" alt="会社概要がご覧頂けます。" name="Image10" width="70" height="20" border="0"></a><img src="b_outlet_off.gif" name="Image39" width="70" height="20" border="0"><img src="b_outlet_off.gif" name="Image38" width="70" height="20" border="0"><img src="b_outlet_off.gif" name="Image31" width="70" height="20" border="0"><img src="b_outlet_off.gif" name="Image42" width="70" height="20" border="0"><a onMouseOver="MM_swapImage('Image15','','img/b/b_download_on.gif',1)" onMouseOut="MM_swapImgRestore()" href="download.htm"><img src="b_download_off.gif" alt="壁紙ダウンロード" name="Image41" width="70" height="20" border="0"></a><img src="b_bar.gif" width="70" height="20" border="0"></td>
        </tr>
      </table></td>
    <td width="4"><img src="spacer.gif" width="1" height="70" border="0" alt=""></td>
  </tr>
  <tr> 
    <td width="133"><img src="spacer.gif" width="27" height="1" border="0" alt=""></td>
    <td width="395"><img src="spacer.gif" width="101" height="1" border="0" alt=""></td>
    <td width="65"><img src="spacer.gif" width="40" height="1" border="0" alt=""></td>
    <td width="82"><img src="spacer.gif" width="51" height="1" border="0" alt=""></td>
    <td width="49"><img src="spacer.gif" width="30" height="1" border="0" alt=""></td>
    <td width="129"><img src="spacer.gif" width="81" height="1" border="0" alt=""></td>
    <td width="127"><img src="spacer.gif" width="80" height="1" border="0" alt=""></td>
    <td width="98"><img src="spacer.gif" width="62" height="1" border="0" alt=""></td>
    <td width="14"><img src="spacer.gif" width="8" height="1" border="0" alt=""></td>
    <td width="317"><img src="spacer.gif" width="200" height="1" border="0" alt=""></td>
    <td width="40"><img src="spacer.gif" width="25" height="1" border="0" alt=""></td>
    <td width="4"><img src="spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>
  <tr> 
    <td colspan="11">　</td>
    <td width="4"><img src="spacer.gif" width="1" height="6" border="0" alt=""></td>
  </tr>
  <tr> 
    <td width="133" rowspan="10" valign="top">    <form name="form1" method="get" action="<?= $_SERVER['PHP_SELF']; ?>">
      <table width="144" border="0">
        <tr>
          <td width="45"><span class="style1">Make</span></td>
          <td width="72"><? 
						if (isset($_GET['make_id']))
						{getmake_selection($_GET['make_id']);}
						else
						{getmake_selection('');}
						
						?></td>
        </tr>
        <tr>
          <td><span class="style1">Model</span></td>
          <td><? 
						if (isset($_GET['make_id']))
						if ($_GET['make_id']!=''){
						{getmodel_selection($_GET['make_id']);
						}}
						?></td>
        </tr>
      </table>
      <br>
      <input name="cat_id" type="hidden" id="cat_id" value="1">
      <input name="isgo" type="submit" id="isgo" value="Go">
    </form></td>
    <td colspan="7" valign="top" bgcolor="#000000">	  
      <table width="200" border="0">
        <tr>
          <td height="22">
          <div align="center"><? 
	if (isset($_GET['cat_id']))
	{
	if (isset($_GET['start']))
	{	
	produc_list_web ($_GET['cat_id'],$_GET['start'],6,$_GET['model_id'],$_GET['make_id']);
	}
	else 
	produc_list_web ($_GET['cat_id'],1,6,$_GET['model_id'],$_GET['make_id']);
	} 
	
	?></div></td>
        </tr>
      </table>
 </td>
    <td rowspan="10" width="14">　</td>
  </tr>
  <tr> 
    <td height="25" colspan="7" valign="bottom">&nbsp;	</td>
  </tr>
  <tr> 
    <td colspan="7" rowspan="8" valign="top"><p><br> </p>
	</td>
  </tr>
</table>
</body>
</html>