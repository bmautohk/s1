<?
//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require_once('config.php');  
require_once('functions.php');

if (allow_access(@Administrators) != "yes"){ 
	include_once('no_access.html'); 
exit;
}

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}
if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}
$group2=$_SESSION[group2];
$user_name=$_SESSION[user_name];

?>