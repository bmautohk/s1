<?php

if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{
	$stock_id=$GLOBALS['stock_id'];
	$stock_date_min=$GLOBALS['stock_date_min'];
	$stock_date_max=$GLOBALS['stock_date_max'];
}
else {
	$stock_id='';
	$stock_date_min='';
	$stock_date_max='';	
}

function getStock_list($csvMode) {
	$stock_id=$GLOBALS['stock_id'];
	$stock_date_min=$GLOBALS['stock_date_min'];
	$stock_date_max=$GLOBALS['stock_date_max'];
	
	$genCSV=$GLOBALS['genCSV'];
	
	$searchKey="&issearch=issearch";
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT * ";
	
	$sql = "from (
			(select 'in' type, t1.stock_date, t1.id stock_id, t2.product_cd, t2.qty, t2.unit_price, t2.total, t2.warehouse, t2.created_by, t2.creation_date, '' bgcolor
			FROM temp_instock t1 left outer join temp_instock_product t2 on (t1.id = t2.instock_id and t2.sts <> 'X')
			) 
			union all
			(select 'out' type, t3.stock_date, t3.id stock_id, t4.product_cd, t4.qty, t4.unit_price, t4.total, t4.warehouse, t4.created_by, t4.creation_date, '#A9A9A9' bgcolor
			FROM temp_outstock t3 left outer join temp_outstock_product t4 on (t3.id = t4.outstock_id and t4.sts <> 'X')
			)) t5
			left outer join product on (product_id = product_cd)
			WHERE 1 = 1 ";
	
	if ($stock_id != '') { $sql = $sql."AND stock_id = '$stock_id' "; $searchKey=$searchKey."&stock_id=$stock_id";}
	if ($stock_date_min != '') { $sql = $sql."AND stock_date >= '$stock_date_min' "; $searchKey=$searchKey."&stock_date_min=$stock_date_min";}
	if ($stock_date_max != '') { $sql = $sql."AND stock_date < date_add('$stock_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&stock_date_max=$stock_date_max";}
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($genCSV == '') {
		if ($num_rows == '') {
			$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
			$row=mysql_fetch_array($query);
			$num_rows=$row['rec_cnt'];
		}

		$searchKey=$searchKey."&num_rows=$num_rows";
		
		$page_start = paging_table_header("stock", "list", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY stock_date desc, stock_id desc ";
	
	if ($genCSV == '') {
		$sql = $sql."LIMIT $page_start, $per_page";
	}
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	if ($csvMode == 'N') {
		getList($result, $num_results);
	}
	else {
		getCSV($result, $num_results);
	}
}

function getList($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td>Stock ID</td><td>Stock Date</td><td>Product Code</td><td>Product Name</td><td>Qty</td><td>Unit Price</td><td>Total</td><td>Ware House</td><td>Created By</td><td>Creation Date</td><td>Type</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$stock_id=$row["stock_id"];

		$type=$row["type"];
		$stock_date=$row["stock_date"];
		$product_cd=$row["product_cd"];
		$qty=$row["qty"];
		$unit_price=$row["unit_price"];
		$total=$row["total"];
		$warehouse=$row["warehouse"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$product_name=$row["product_name"];
		
		$bgcolor=$row["bgcolor"];
		
		echo "<tr align=\"right\" valign=\"top\" bgcolor=\"$bgcolor\"><td><a href=\"index.php?page=stock&subpage=${type}_edit&stock_id=$stock_id\">$stock_id</td><td>$stock_date</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$qty&nbsp;</td><td>$unit_price&nbsp;</td><td>$total&nbsp;</td><td>$warehouse&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td><td>$type</td></tr>\n";
	}

	echo "</table>";
}

function getCSV($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td>Stock ID</td><td>Stock Date</td><td>Product Code</td><td>Product Name</td><td>Qty</td><td>Unit Price</td><td>Total</td><td>Ware House</td><td>Created By</td><td>Creation Date</td><td>Type</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$stock_id=$row["stock_id"];

		$type=$row["type"];
		$stock_date=$row["stock_date"];
		$product_cd=$row["product_cd"];
		$qty=$row["qty"];
		$unit_price=$row["unit_price"];
		$total=$row["total"];
		$warehouse=$row["warehouse"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$product_name=$row["product_name"];
		
		$bgcolor=$row["bgcolor"];

		echo "<tr align=\"right\" valign=\"top\" bgcolor=\"$bgcolor\"><td>$stock_id</td><td>$stock_date</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$qty&nbsp;</td><td>$unit_price&nbsp;</td><td>$total&nbsp;</td><td>$warehouse&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td><td>$type</td></tr>\n";
	}

	echo "</table>";
}

?>