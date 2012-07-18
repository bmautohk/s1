<?php

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}

if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}

$group2=$_SESSION[group2];

$user_name=$_SESSION[user_name];

if (isset($GLOBALS['issearch']) or isset($GLOBALS['showAverage']) or isset($GLOBALS['showOutStock']) or isset($GLOBALS['showTopBad']) or isset($GLOBALS['genCSV'])) { 
	$product_cd=$GLOBALS['product_cd'];
	$stock=$GLOBALS['stock']; if (!$stock) { $stock = 3; }
	$topCount=$GLOBALS['topCount']; if (!$topCount) { $topCount = 20; }
}
else {
	$product_cd='';
	$stock='3';
	$topCount='20';
}
 
function get_product_inventory_list() {
	
	$product_cd=$GLOBALS['product_cd'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$searchKey="&issearch=issearch";
	$whereClause = '';
	if ($product_cd != '') { $whereClause = $whereClause."AND product_id like '%$product_cd%' "; $searchKey=$searchKey."&product_cd=$product_cd";}

	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(product_id) rec_cnt from product WHERE 1 = 1 ".$whereClause,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}
	
	$searchKey=$searchKey."&num_rows=$num_rows";
	
	$page_start = paging_table_header("report_inventory", "list", $num_rows, $zpage, $per_page, $searchKey);

	$result = getProductRealStockByWhereClause($db, "1 = 1 ".$whereClause, "ORDER BY product_id LIMIT $page_start, $per_page");
	
	$num_results=mysql_num_rows($result);

	echo "<table width=900 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Product Qty</td>
	<td>In Stock Qty Total</td>
	<td>In Stock Qty J1</td>
	<td>In Stock Qty J2</td>
	<td>In Stock Qty CN</td>
	<td>In Stock Qty HK</td>
	<td>Out Stock Qty Total</td>
	<td>Out Stock J1 Qty</td>
	<td>Out Stock J2 Qty</td>
	<td>Out Stock CN Qty</td>
	<td>Out Stock HK Qty</td>
	<td>PO Qty</td><td>Invoice Qty</td><td>Order Qty</td><td>Ship Item Qty</td><td>Real Stock</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		$prod_qty = $row["prod_qty"];
		$out_qty=$row["out_qty"];
		$out_qty_j1=$row["out_qty_j1"];
		$out_qty_j2=$row["out_qty_j2"];
		$out_qty_cn=$row["out_qty_cn"];
		$out_qty_hk=$row["out_qty_hk"];
		$in_qty=$row["in_qty"];
		$in_qty_j1=$row["in_qty_j1"];
		$in_qty_j2=$row["in_qty_j2"];
		$in_qty_cn=$row["in_qty_cn"];
		$in_qty_hk=$row["in_qty_hk"];
		$po_qty=$row["po_qty"];
		$inv_qty=$row["inv_qty"];
		$order_qty=$row["order_qty"];
		$po_hist_qty=$row["po_hist_qty"];
		$real_stock=$row["real_stock"];
		
		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$prod_qty</td>
		<td>$in_qty</td>
		<td>$in_qty_j1</td>
		<td>$in_qty_j2</td>
		<td>$in_qty_cn</td>
		<td>$in_qty_hk</td>
		<td>$out_qty</td>
		<td>$out_qty_j1</td>
		<td>$out_qty_j2</td>
		<td>$out_qty_cn</td>
		<td>$out_qty_hk</td>
		<td>$po_qty</td><td>$inv_qty</td><td>$order_qty</td><td>$po_hist_qty</td><td>$real_stock</td></tr>\n";
	}

	echo "</table>";
	mysql_close($db);
}

function get_out_stock_list() {
	$stock=$GLOBALS['stock'];
	if ($stock == '') {
		$stock = 3;
	}
	
	$genCSV=$GLOBALS['genCSV'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$searchKey="&showOutStock=showOutStock&stock=$stock";
	$whereClause = "real_stock <= $stock";
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($genCSV == '') {
		if ($num_rows == '') {
			$num_rows=getProductRealStockCount($db, $whereClause);
		}
	
		$searchKey=$searchKey."&num_rows=$num_rows";
	
		$page_start = paging_table_header("report_inventory", "list", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY product_id ";
	
	if ($genCSV == '') {
		$order = "ORDER BY product_id LIMIT $page_start, $per_page";
	}
	else {
		$order = "ORDER BY product_id ";
	}

	
	$result = getProductRealStockByWhereClause($db, $whereClause, $order);
	$num_results=mysql_num_rows($result);

	echo "<table width=900 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Product Name</td><td>Product Qty</td><td>In Stock Qty</td><td>Out Stock Qty</td><td>PO Qty</td><td>Invoice Qty</td><td>Order Qty</td><td>Ship Item Qty</td><td>Real Stock</td><td>Cost (RMB)</td><td>Cost (JPY)</td><td>Cost (HKD)</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$prod_qty = $row["prod_qty"];
		$out_qty=$row["out_qty"];
		$in_qty=$row["in_qty"];
		$po_qty=$row["po_qty"];
		$inv_qty=$row["inv_qty"];
		$order_qty=$row["order_qty"];
		$po_hist_qty=$row["po_hist_qty"];
		$real_stock=$row["real_stock"];
		$product_cost_rmb=$row["product_cost_rmb"];
		$product_cost_hk=$row["product_cost_hk"];
		$product_cost_yan=number_format ($row["product_cost_yan"], 0, '.', '');
		$product_name=$row["product_name"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$product_name&nbsp;</td><td>$prod_qty</td><td>$in_qty</td><td>$out_qty</td><td>$po_qty</td><td>$inv_qty</td><td>$order_qty</td><td>$po_hist_qty</td><td>$real_stock</td><td>$product_cost_rmb</td><td>$product_cost_yan</td><td>$product_cost_hk</td></tr>\n";
	}

	echo "</table>";
	mysql_close($db);
}


function get_average_list() {
	$qty=$GLOBALS['stock'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "select t1.product_id, ifnull(t2.avg_price, t1.product_cus_price) avg_price, ifnull(t3.avg_cost, t1.product_cus_price) avg_cost ";
	$sql = "from product t1
			left outer join (select product_cd, sum(unit_price) / count(1) avg_price
			from temp_outstock_product
			where sts <> 'X'
			group by product_cd) t2
			on (t1.product_id = t2.product_cd)
			left outer join
			(select product_cd, sum(unit_price) / count(1) avg_cost
			from temp_instock_product
			where sts <> 'X'
			group by product_cd) t3
			on (t1.product_id = t3.product_cd) ";
			
	$searchKey="&showAverage=showAverage";
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}

	$searchKey=$searchKey."&num_rows=$num_rows";

	$page_start = paging_table_header("report_inventory", "list", $num_rows, $zpage, $per_page, $searchKey);

	$sql = $sql."ORDER BY t1.product_id LIMIT $page_start, $per_page";
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table width=500 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Average Price</td><td>Average Cost (Yen)</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$avg_price=$row["avg_price"];
		$avg_cost=$row["avg_cost"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$avg_price</td><td>$avg_cost</td></tr>\n";
	}

	echo "</table>";
	mysql_close($db);
}

function get_top_bad_list() {
	$topCount=$GLOBALS['topCount'];
	if ($topCount == '') {
		$topCount = 20;
	}
	
	// Top
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql = "select t1.product_id, ifnull(sum(t2.qty), 0) qty
		from product t1 left outer join temp_outstock_product t2 on (t1.product_id = t2.product_cd and t2.sts <> 'X')
		group by product_id
		order by qty desc LIMIT 0, $topCount ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table><tr><td>";
	echo "<strong>Top $topCount Product (Out Stock QTY)</strong>";
	echo "<table width=200 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Qty</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$qty=$row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$qty</td></tr>\n";
	}

	echo "</table></td>";
	
	// Bad
	$sql = "select t1.product_id, ifnull(sum(t2.qty), 0) qty
		from product t1 left outer join temp_outstock_product t2 on (t1.product_id = t2.product_cd and t2.sts <> 'X')
		group by product_id
		order by qty asc LIMIT 0, $topCount ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<td><strong>Bad $topCount Product (Out Stock QTY)</strong>";
	echo "<table width=200 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Qty</td></tr>\n";

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$qty=$row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$qty</td></tr>\n";
	}

	echo "</table></tr></td></table>";
	mysql_close($db);
}

/*
function get_product_inventory_list() {
	
	$product_cd=$GLOBALS['product_cd'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "select t4.*, po_compl_qty - inv_incompl_qty real_stock ";
	$sql = "from (
	select t1.product_id,
	ifnull(sum(t3.po_qty), 0) po_compl_qty,
	ifnull(sum(t2.qty), 0) inv_incompl_qty,
	ifnull(sum(t3.j1_qty), 0) j1_qty,
	ifnull(sum(t3.j2_qty), 0) j2_qty,
	ifnull(sum(t3.hk_qty), 0) hk_qty,
	ifnull(sum(t3.cn_qty), 0) cn_qty
from ben_product_tt t1 left outer join invoice_product t2
	on (t1.product_id = t2.product_cd and t2.sts not in ('C', 'X'))
left outer join
	(select product_cd,
		qty po_qty,
		if (warehouse = 'J1', qty, 0) j1_qty,
		if (warehouse = 'J2', qty, 0) j2_qty,
		if (warehouse = 'HK', qty, 0) hk_qty,
		if (warehouse = 'CN', qty, 0) cn_qty
	from po p1, po_product p2
	where p1.id = p2.po_id
	and p2.sts = 'C') t3 
	on (t1.product_id = t3.product_cd )
	group by t1.product_id
	) t4
	WHERE 1 = 1 ";
	
	$searchKey="&issearch=issearch";
	
	if ($product_cd != '') { $sql = $sql."AND product_id like '%$product_cd%' "; $searchKey=$searchKey."&product_cd=$product_cd";}
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}
	
	$searchKey=$searchKey."&num_rows=$num_rows";
	
	$page_start = paging_table_header("report", "inventory", $num_rows, $zpage, $per_page, $searchKey);
	
	$sql = $sql."ORDER BY t4.product_id LIMIT $page_start, $per_page";
	
	$sql = $sql_select.$sql;
	
	echo $sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"center\"><td>&nbsp;</td><td colspan=\"3\">Stock</td><td colspan=\"4\">Ware House</td></tr>\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Completed PO Qty</td><td>Pending Invoice Qty</td><td>Real Stock</td><td>Japan 1</td><td>Japan 2</td><td>Hong Kong</td><td>China</td></tr>\n";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$po_compl_qty=$row["po_compl_qty"];
		$inv_incompl_qty=$row["inv_incompl_qty"];
		$real_stock=$row["real_stock"];
		$j1_qty=$row["j1_qty"];
		$j2_qty=$row["j2_qty"];
		$hk_qty=$row["hk_qty"];
		$cn_qty=$row["cn_qty"];
		
		
		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$po_compl_qty</td><td>$inv_incompl_qty</td><td>$real_stock</td><td>$j1_qty</td><td>$j2_qty</td><td>$hk_qty</td><td>$cn_qty</td></tr>\n";
	}

	echo "</table>";
}

 
function get_out_stock_list() {
	$stock=$GLOBALS['stock'];
	if ($stock == '') {
		$stock = 3;
	}
	
	$genCSV=$GLOBALS['genCSV'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "select t4.*, po_compl_qty - inv_incompl_qty real_stock ";
	$sql = "from (
	select t1.product_id, t1.product_cost_rmb, t1.product_cost_hk, t1.product_cost_yan,
	ifnull(sum(t3.po_qty), 0) po_compl_qty,
	ifnull(sum(t2.qty), 0) inv_incompl_qty
from ben_product_tt t1 left outer join invoice_product t2
	on (t1.product_id = t2.product_cd and t2.sts not in ('C', 'X'))
left outer join
	(select product_cd,
		qty po_qty
	from po p1, po_product p2
	where p1.id = p2.po_id
	and p2.sts = 'C') t3 
	on (t1.product_id = t3.product_cd )
	group by t1.product_id
	) t4
	WHERE po_compl_qty - inv_incompl_qty <= $stock ";
	
	$searchKey="&showOutStock=showOutStock&stock=$stock";
	
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
	
		$page_start = paging_table_header("report", "inventory", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY t4.product_id ";
	
	if ($genCSV == '') {
		$sql = $sql."LIMIT $page_start, $per_page";
	}
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Completed PO Qty</td><td>Pending Invoice Qty</td><td>Real Stock</td><td>Cost (RMB)</td><td>Cost (JPY)</td><td>Cost (HKD)</td></tr>\n";
	
	//$sql = $sql." LIMIT $page_start, $per_page";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$po_compl_qty=$row["po_compl_qty"];
		$inv_incompl_qty=$row["inv_incompl_qty"];
		$real_stock=$row["real_stock"];
		$product_cost_rmb=$row["product_cost_rmb"];
		$product_cost_hk=$row["product_cost_hk"];
		$product_cost_yan=$row["product_cost_yan"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$po_compl_qty</td><td>$inv_incompl_qty</td><td>$real_stock</td><td>$product_cost_rmb</td><td>$product_cost_hk</td><td>$product_cost_yan</td></tr>\n";
	}

	echo "</table>";
}


function get_average_list() {
	$qty=$GLOBALS['stock'];
	if ($stock == '') {
		$stock = 3;
	}
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "select t1.product_id, ifnull(t2.avg_price, t1.product_cus_price) avg_price, ifnull(t3.avg_cost, t1.product_cost_yan) avg_cost ";
	$sql = "from ben_product_tt t1
			left outer join (select product_cd, sum(unit_price) / count(1) avg_price
			from invoice_product
			group by product_cd) t2
			on (t1.product_id = t2.product_cd)
			left outer join
			(select product_cd, sum(unit_price) / count(1) avg_cost
			from po_product
			group by product_cd) t3
			on (t1.product_id = t3.product_cd) ";
			
	$searchKey="&showAverage=showAverage";
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}

	$searchKey=$searchKey."&num_rows=$num_rows";

	$page_start = paging_table_header("report", "inventory", $num_rows, $zpage, $per_page, $searchKey);

	$sql = $sql."ORDER BY t1.product_id LIMIT $page_start, $per_page";
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table width=500 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Average Price</td><td>Average Cost (Yen)</td></tr>\n";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$avg_price=$row["avg_price"];
		$avg_cost=$row["avg_cost"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$avg_price</td><td>$avg_cost</td></tr>\n";
	}

	echo "</table>";
}

function get_top_bad_list() {
	$topCount=$GLOBALS['topCount'];
	if ($topCount == '') {
		$topCount = 20;
	}
	
	// Top
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql = "select t1.product_id, ifnull(sum(t2.qty), 0) qty
		from ben_product_tt t1 left outer join invoice_product t2 on (t1.product_id = t2.product_cd)
		group by product_id
		order by qty desc LIMIT 0, $topCount ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<table><tr><td>";
	echo "<strong>Top $topCount Product (Invoice QTY)</strong>";
	echo "<table width=200 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Qty</td></tr>\n";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$qty=$row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$qty</td></tr>\n";
	}

	echo "</table></td>";
	
	// Bad
	$sql = "select t1.product_id, ifnull(sum(t2.qty), 0) qty
		from ben_product_tt t1 left outer join invoice_product t2 on (t1.product_id = t2.product_cd)
		group by product_id
		order by qty asc LIMIT 0, $topCount ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	echo "<td><strong>Bad $topCount Product (Invoice QTY)</strong>";
	echo "<table width=200 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr align=\"right\" valign=\"top\"><td >Product</td><td>Qty</td></tr>\n";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$product_id=$row["product_id"];
		
		$qty=$row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td>$product_id</td><td>$qty</td></tr>\n";
	}

	echo "</table></tr></td></table>";
}
*/

?>