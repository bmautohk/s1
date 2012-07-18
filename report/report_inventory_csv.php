<?php
	include_once('../functions.php');
	include_once('report_inventory_logic.php');
	header("Content-type:application/vnd.ms-excel;charset=euc");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=out_stock_item.xls");
	get_out_stock_list();
?>