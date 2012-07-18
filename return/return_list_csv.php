<?php
	include_once('../config.php');
	include_once('../functions.php');
	include_once('return_list_logic.php');
	header("Content-type:application/vnd.ms-excel;charset=euc");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=return.xls");
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP"></head><body>
<?
	get_return_list('Y');
?>
</body></html>