<?php
	include_once('../config.php');
	include_once('../functions.php');
	include_once('report_list_logic.php');
	//header("Content-type:application/vnd.ms-excel;charset=euc");
	header("Content-type:application/vnd.ms-excel;charset=utf-8");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=output.xls");
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP"></head><body>
<? 				 $get_username = $_GET['get_username']; 
				 $print_link = "&nbsp;";
				 $today = date("Y-m-d"); 
				 $today_20 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
				 if (isset($_GET['date_start']) and isset($_GET['date_end']) and isset($_GET['sale_top']))
				 {
				 $date_start = $_GET['date_start'];
				 $date_end = $_GET['date_end'];
				 $sale_top = $_GET['sale_top'];
				 $sale_select = $_GET['sale_select'];
				 getReportTop($date_start,$date_end,$sale_top,$sale_select);
				  
				 }
				 
				 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) and !isset($_GET['search_sale']) and !isset($_GET['sale_top']))
				 {
				 getOrderReport($today_20,$today, 'sale_date','desc','date','','');
				 $print_link = "<a href=\"print_report.php?date_start=$today_20&date_end=$today&mod=date&sale_or=sale_date&sale_as=desc\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				  
				 }
				  
				 if (isset($_GET['date_start']) and isset($_GET['date_end']) and !isset($_GET['search_sale']) and !isset($_GET['sale_top']))
				 {
				 $date_start = $_GET['date_start'];
				 $date_end = $_GET['date_end'];
				 $sale_or = $_GET['sale_or'];
				 $sale_as = $_GET['sale_as'];
				 $mod = "date";
				 getOrderReport($date_start,$date_end,$sale_or,$sale_as,$mod,$get_username,'');
				 $print_link = "<a href=\"print_report.php?date_start=$date_start&date_end=$date_end&mod=$mod&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				  
				 }
				 if (isset($_GET['search_sale']))
				 {
				 $mod = $_GET['sale_ref'];
				 $mod2 = $_GET['prod_name'];
				 getOrderReport($date_start,$date_end,$sale_or,$sale_as,$mod,$get_username,$mod2);
				 $print_link = "<a href=\"print_report.php?date_start=&date_end=&mod=$mod&mod2=$mod2&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				 }
				 
				 ?>
</body></html>