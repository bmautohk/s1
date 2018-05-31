<?php
include_once('../security_check.php');
include_once('../config.php');
include_once('../functions.php');
include_once('report_group_logic.php');

if (isset($_GET['chartDS'])) {
	// Generate data source of chart
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	$sql = "select sale_group, sum(p_total) as p_total
			from (
			SELECT sale_group, sale_ref, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total
					FROM ben_sale, ben_sale_prod
					where sprod_ref=sale_ref
					and sale_date between '$date_start' and '$date_end'
					group by sale_group, sale_ref
			) summary
			group by sale_group";
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);

	$summary = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$summary[] = array(
				'group' => $row['sale_group'],
				'totalSale' => $row['p_total']
		);
	}
	
	if ($num_results == 0) {
		$summary[] = array(
				'group' => 'No Sale',
				'totalSale' => 0
		);
	}
	
	mysql_free_result($result);
	
	echo json_encode($summary);
}
