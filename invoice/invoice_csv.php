<?php
	include_once('../config.php');
	include_once('../functions.php');
	include_once('invoice_list_logic.php');
	//header("Content-type:application/vnd.ms-excel;charset=euc");
	header("Content-type:application/vnd.ms-excel;charset=utf-8");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=invoice.xls");
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP"></head><body>
<?	
	getInvoice_list('Y');
?>
</body></html>