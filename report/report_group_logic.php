<?php

if (isset($_POST['Submit'])) {
	$date_start = $_POST['date_start'];
	$date_end = $_POST['date_end'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$jpRate = getExchangeRate($db);
	
	$summary = getSummary($date_start, $date_end, $jpRate, $db);
}
else if (isset($_POST['genPieChart'])) {
	$date_start = $_POST['date_start'];
	$date_end = $_POST['date_end'];
}

function getExchangeRate($db) {
	// Get JP - RMB exchange rate
	$sql = "SELECT jp_rate FROM rmb_jp_rate";
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$row = mysql_fetch_array($result);
	$jpRate = $row['jp_rate'];
	mysql_free_result($result);
	
	return $jpRate;
}

function getSummary($date_start, $date_end, $jpRate, $db) {
	$sql = "
		SELECT username, summary.*
		FROM authorize left outer join 
			(SELECT sale_group, sale_ref, sum(sprod_price*sprod_unit) as sale, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total,
				sale_discount, sale_ship_fee, sale_tax ,SUM( product_cost_rmb * sprod_unit ) AS pcost
			  FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id
				where sprod_ref=sale_ref
			  and sale_date between '$date_start' and '$date_end'
			  group by sale_group, sale_ref)summary
		ON username = sale_group
		ORDER BY username ";
	
	/* $sum_sql = "SELECT sale_group, sale_ref, sum(sprod_price*sprod_unit) as sale, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total,
	sale_discount, sale_ship_fee, sale_tax ,SUM( product_cost_rmb * sprod_unit ) AS pcost ";
	
	$from_sql = "FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id
	where sprod_ref=sale_ref ";
	
	$from_sql .= "and sale_date between '$date_start' and '$date_end' ";
	
	$sql = $sum_sql.$from_sql."group by sale_group, sale_ref"; */
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);
	
	$prevSaleGroup = NULL;
	$summary = array();
	$topSaleRank = array();
	$topCostRank = array();
	$topGPRank = array();
	$item = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$saleGroup = $row['sale_group'] != NULL ? $row['sale_group'] : $row['username'];
		$sale_ref = $row['sale_ref'];
		
		if ($saleGroup != $prevSaleGroup) {
			$prevSaleGroup = $saleGroup;
		
			if (sizeof($item) > 0) {
				$item['gp'] = $item['total_sale'] - $item['cost_rmb'] * $jpRate;
				$item['cost_percentage'] = $item['total_sale'] == 0 ? 0 : $item['cost_rmb'] * 1.0 / $item['total_sale'];
				$summary[$item['sale_group']] = $item;
				$topSaleRank[$item['sale_group']] = $item['total_sale'];
				$topCostRank[$item['sale_group']] = $item['cost_percentage'];
				$topGPRank[$item['sale_group']] = $item['gp'];
			}

			$item = array();
			$item['sale_group'] = $saleGroup;
			$item['balance'] = 0;
			$item['return'] = 0;
			if ($row['sale_group'] == NULL) {
				$item['total_sale'] = 0;
				$item['cost_rmb'] = 0;
				$item['sale'] = 0;
				$item['sale_discount'] = 0;
				$item['sale_ship_fee'] = 0;
				$item['sale_tax'] = 0;
				continue;
			}
		}

		$item['total_sale'] = $item['total_sale'] + $row['p_total'];
		$item['cost_rmb'] = $item['cost_rmb'] + $row['pcost'];
		$item['sale'] = $item['sale'] + $row['sale'];
		$item['sale_discount'] = $item['sale_discount'] + $row['sale_discount'];
		$item['sale_ship_fee'] = $item['sale_ship_fee'] + $row['sale_ship_fee'];
		$item['sale_tax'] = $item['sale_tax'] + $row['sale_tax'];

		if ($sale_ref != NULL) {
			// Balance
			$bal_row = getbal_data($sale_ref);
			if ($bal_row) {
				$item['balance'] = $item['balance'] + $bal_row['bal_pay'];
			}
		
			// Return
			$return_row = getreturn_data($sale_ref);
			if ($return_row) {
				$item['return'] = $item['return'] + $bal_row['return_pay'] + $return_row['return_pay'];
			}
		}
	}
	
	if (sizeof($item) > 0) {
		$item['gp'] = $item['total_sale'] - $item['cost_rmb'] * $jpRate;
		$item['cost_percentage'] = $item['total_sale'] == 0 ? 0 : $item['cost_rmb'] * 1.0 / $item['total_sale'];
		$summary[$item['sale_group']] = $item;
		$topSaleRank[$item['sale_group']] = $item['total_sale'];
		$topCostRank[$item['sale_group']] = $item['cost_percentage'];
		$topGPRank[$item['sale_group']] = $item['gp'];
	}
	
	// Sort the rank
	arsort($topSaleRank, SORT_NUMERIC);
	arsort($topCostRank, SORT_NUMERIC);
	arsort($topGPRank, SORT_NUMERIC);
	
	// Assign rank for top sales
	$currRank = 1;
	$prevVal = -1;
	$idx = 1;
	foreach ($topSaleRank as $saleGroup=>$val) {
		if ($prevVal != $val) {
			$currRank = $idx;
			$prevVal = $val;
		}
		$summary[$saleGroup]['top_sale'] = $currRank;
		$idx++;
	}
	
	// Assign rank for top cost
	$currRank = 1;
	$prevVal = -1;
	$idx = 1;
	foreach ($topCostRank as $saleGroup=>$val) {
		if ($prevVal != $val) {
			$currRank = $idx;
			$prevVal = $val;
		}
		$summary[$saleGroup]['top_cost'] = $currRank;
		$idx++;
	}
	
	// Assign rank for top GP
	$currRank = 1;
	$prevVal = -1;
	$idx = 1;
	foreach ($topGPRank as $saleGroup=>$val) {
		if ($prevVal != $val) {
			$currRank = $idx;
			$prevVal = $val;
		}
		$summary[$saleGroup]['top_gp'] = $currRank;
		$idx++;
	}
	
	mysql_free_result($result);
	
	return $summary;
}
