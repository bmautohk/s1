<?php
	include_once('../config.php');
	include_once('../functions.php');
	include_once('report_inventory_list_logic.php');
	header("Content-type:application/vnd.ms-excel;charset=euc");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=out_stock_item.xls");
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP"></head><body>
<?
	get_out_stock_list();
?>
</body></html>