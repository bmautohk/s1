<?php

if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{
	$ship_id=$GLOBALS['ship_id'];
	$product_cd=$GLOBALS['product_cd'];
	$min_qty=$GLOBALS['min_qty'];
	$max_qty=$GLOBALS['max_qty'];
	$ship_date_min=$GLOBALS['ship_date_min'];
	$ship_date_max=$GLOBALS['ship_date_max'];
	
	$warehouse = $GLOBALS['wareHouseCode'];
	if (isset($warehouse)) {
		foreach( $warehouse as $cd => $val) {
			$wareHouseCode[$val] = $val;
		}
	}
}
else {
	$ship_id='';
	$entry_date_min='';
	$entry_date_max='';
}

function get_list($csvMode) {
	$ship_id=trim($GLOBALS['ship_id']);
	$product_cd=trim($GLOBALS['product_cd']);
	$warehouse = $GLOBALS['wareHouseCode'];
	$min_qty=trim($GLOBALS['min_qty']);
	$max_qty=trim($GLOBALS['max_qty']);
	$ship_date_min=$GLOBALS['ship_date_min'];
	$ship_date_max=$GLOBALS['ship_date_max'];
	
	$genCSV=$GLOBALS['genCSV'];
	
	$searchKey="&issearch=issearch";
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT t1.*, t2.*, case t2.warehouse when 'J1' then '3ÃúÌÜ'
			when 'J2' then '±ºÅÄ'
			when 'HK' then 'HK'
			when 'CN' then 'China'
			else 'Other' end warehouse_name ";
	
	$sql = "from po_ship_header t1 left outer join po_product_hist t2 on (t1.id = t2.po_ship_id)
			WHERE t2.sts <> 'X' ";
	
	if ($ship_id != '') { $sql = $sql."AND po_ship_id = '$ship_id' "; $searchKey=$searchKey."&ship_id=$ship_id";}
	if ($product_cd != '') { $sql = $sql."AND product_cd = '$product_cd' "; $searchKey=$searchKey."&product_cd=$product_cd";}
	if ($min_qty != '') { $sql = $sql."AND qty >= '$min_qty' "; $searchKey=$searchKey."&min_qty=$min_qty";}
	if ($max_qty != '') { $sql = $sql."AND qty <= '$max_qty "; $searchKey=$searchKey."&max_qty=$max_qty";}
	if ($ship_date_min != '') { $sql = $sql."AND ship_date >= '$ship_date_min' "; $searchKey=$searchKey."&ship_date_min=$ship_date_min";}
	if ($ship_date_max != '') { $sql = $sql."AND ship_date < date_add('$ship_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&ship_date_max=$ship_date_max";}
	
	$warehouseList = '';
	for ($i = 0; $i < count($warehouse); $i++) {
		if ($warehouse[$i] != '') {
			if ($warehouseList == '') {
				$warehouseList = $warehouseList."'$warehouse[$i]'";
			}
			else {
				$warehouseList = $warehouseList.",'$warehouse[$i]'";
			}
		
			$searchKey=$searchKey."&wareHouseCode[]=$warehouse[$i]";
		}
	}
	if ($warehouseList != '') {
		$sql = $sql."AND t2.warehouse in ($warehouseList) ";
	}

	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($csvMode == 'N') {
		if ($num_rows == '') {
			$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
			$row=mysql_fetch_array($query);
			$num_rows=$row['rec_cnt'];
		}

		$searchKey=$searchKey."&num_rows=$num_rows";
		$page_start = paging_table_header("po", "ship_list", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY ship_date desc, t1.id desc ";

	if ($csvMode == 'N') {
		$sql = $sql."LIMIT $page_start, $per_page";
	}
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td>Ship ID</td><td>Ship Date</td><td>Entry Date</td><td>Product ID</td><td>Warehouse</td><td>Ship Qty</td><td>staff_name</td><td>Created By</td><td>Creation Date</td></tr>\n";
	
	if ($csvMode == 'N') {
		getList($result, $num_results);
	}
	else {
		getCSV($result, $num_results);
	}
	
	echo "</table>";
}

function getList($result, $num_results) {
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$ship_id=$row["po_ship_id"];

		$ship_date=$row["ship_date"];
		$product_cd=$row["product_cd"];
		$entry_date=$row["entry_date"];
		//$total_qty=$row["subtotal"];
		$warehouseName=$row["warehouse_name"];
		$staff_name=$row["staff_name"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$qty = $row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=po&subpage=ship_edit&ship_id=$ship_id\">$ship_id</td><td>$ship_date</td><td>$entry_date</td><td>$product_cd</td><td>$warehouseName&nbsp;</td><td>$qty&nbsp;</td><td>$staff_name&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>\n";
	}
}

function getCSV($result, $num_results) {
	
	
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$ship_id=$row["po_ship_id"];

		$ship_date=$row["ship_date"];
		$product_cd=$row["product_cd"];
		$entry_date=$row["entry_date"];
		//$total_qty=$row["subtotal"];
		$warehouseName=$row["warehouse_name"];
		$staff_name=$row["staff_name"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$qty = $row["qty"];

		echo "<tr align=\"right\" valign=\"top\"><td>$ship_id</td><td>$ship_date</td><td>$entry_date</td><td>$product_cd</td><td>$warehouseName&nbsp;</td><td>$qty&nbsp;</td><td>$staff_name&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>\n";
	}
}

?>