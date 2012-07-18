<?

$submit_success = '';
$id = '';

$subTotal = 0;

if (isset($GLOBALS['issearch']) || isset($GLOBALS['add'])) {
	$po_date_min=$GLOBALS['po_date_min'];
	$po_date_max=$GLOBALS['po_date_max'];
}
else {
	$po_date_min='';
	$po_date_max='';
}

if (isset($GLOBALS['add'])) {
	$product_cd = $GLOBALS['product_cd'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$sql = "select * FROM po_product WHERE sts <> 'X' and qty - ship_qty <> 0 and product_cd = '$product_cd' order by po_id";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	$prod_n = $num_results;
	
	for ($i=1;$i<=$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$po_id[$i] = $row['po_id'];
		$po_prod_id[$i] = $row['id'];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row['product_name'];
		$total_qty[$i] = $row['qty'];
		$remain_qty[$i] = $total_qty[$i] - $row['ship_qty'];
		$ship_select[$i] = '';
	}
}
else {
	$po_date_min=$GLOBALS['po_date_min'];
	$po_date_max=$GLOBALS['po_date_max'];

	$searchKey="&issearch=issearch";

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT * ";
	
	$sql = "FROM po t1, po_product t2
		WHERE t1.id = t2.po_id
		AND t2.sts <> 'X' 
		AND t2.qty <> t2.ship_qty ";
	
	if ($po_date_min != '') { $sql = $sql."AND po_date >= '$po_date_min' "; $searchKey=$searchKey."&po_date_min=$po_date_min";}
	if ($po_date_max != '') { $sql = $sql."AND po_date < date_add('$po_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&po_date_max=$po_date_max";}
	
	$sql = $sql."ORDER BY product_cd ";
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	$prod_n = $num_results;
	
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$po_id[$i] = $row['po_id'];
		$po_prod_id[$i] = $row['id'];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$goods_remark[$i] = $row["remark"];
		$product_colour[$i] = $row["colour"];
		$pcs[$i] = $row["pcs_set"];
		$po_qty[$i] = $row["qty"];
		$ship_qty = $row['ship_qty'];
		$remain_qty[$i] = $po_qty[$i] - $ship_qty;
		
/*		$po_id = $row['po_id'];
		$po_prod_id = $row['id'];
		$product_cd = $row['product_cd'];
		$product_name = $row['product_name'];
		$po_qty = $row['qty'];
		$ship_qty = $row['ship_qty'];
		$remain_qty = $po_qty - $ship_qty;

		echo "<tr align=\"right\" valign=\"top\">
			<td><input align='right' type='text' name='po_id$i' id='po_id$i' value='$po_id' readonly='readonly' \></td>
			<td><input type='text' name='goods_partno$i' id='goods_partno$i' value='$product_cd' readonly='readonly' \></td>
			<td><input type='text' name='goods_name$i' id='goods_name$i' value='$product_name' readonly='readonly' \></td>
			<td><input type='text' name='po_qty$i' id='po_qty$i' value='$po_qty' readonly='readonly' \></td>
			<td><input type='text' name='ship_qty$i' id='ship_qty$i' value='$ship_qty' readonly='readonly' \></td>
			<td><input type='text' name='remain_qty$i' id='remain_qty$i' value='$remain_qty' readonly='readonly' \></td>
			<td><input name=\"ship_select$i\" type=\"checkbox\" id=\"ship_select$i\" value=\"1\" /></td>
			<input type='text' name='po_prod_id$i' id='po_prod_id$i' value='$po_prod_id' /></tr>\n";*/
	}
}

?>