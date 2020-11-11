<?
function getSentReport($date_start,$date_end,$sale_name,$sale_group,$access,$user_name)
{
	ob_flush();
	flush();
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	//echo $username;
	
	$sql = "SELECT * FROM ben_check, ben_sale ,ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sale_ref = sprod_ref and check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' ";
	
	if (isset($sale_name) && $sale_name != '') {
		$sale_name = trim($sale_name);
		$sql = $sql."and sale_name like '%$sale_name%' ";
	}
	
	if ($access==Admin_name) {
		if (isset($sale_group) && $sale_group != '') {
			$sale_group = trim($sale_group);
			$sql = $sql."and sale_group like '%$sale_group%' ";
		}
	}
	else {
		$sql = $sql."and sale_group = '$user_name' ";
	}
	
	$sql = $sql."order by check_date desc, check_ref";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	/* if ($access==Admin_name)
		$result = mysql_query("SELECT * FROM ben_check, ben_sale ,ben_sale_prod where sale_ref = sprod_ref and check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
		$result = mysql_query("SELECT * FROM ben_check, ben_sale ,ben_sale_prod where sale_ref = sprod_ref and sale_group = '$user_name' and check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	 */
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"700\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td>Customer Name</td><td> Prod ID</td><td >Sale Group</td><td>Cost (RMB)</td><td >Shipping Date</td><td >Tracking No.</td><td >Detail</td><td >Tracking email</td><td >Status</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$prod_id = $row["sprod_id"];
		$sale_name = $row["sale_name"];
		$product_cost_rmb = $row["product_cost_rmb"];
		$check_ref=$row["check_ref"];
		$check_date=$row["check_date"];
		$check_shipping=$row["check_shipping"];
		if ($check_shipping=="")
		$check_shipping=$row["check_shipping_jp"];	
		$check_print=$row["check_print"];
		$sale_group=$row["sale_group"];
		$shipped_status=getemail_shipped_check($check_ref);

		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$check_ref'>".$check_ref."</a></td><td>".$sale_name."</td><td>".$prod_id."</td><td>".$sale_group."</td><td>".$product_cost_rmb."&nbsp;</td><td>".$check_date."</td><td>".$check_shipping."</td><td ><a target='_blank' href='index.php?page=order&subpage=shipping&sale_ref=$check_ref'>Click</a></td><td><a href='ship_email.php?sale_ref=$check_ref' target='_blank'>Preview</td><td>".$shipped_status."&nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
}

function genCSVByDate($date_start,$date_end,$sale_name,$sale_group,$access,$user_name)
{

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	//echo $username;
	
	
	// for cal sum of total price and total cost per order 2012 02 09
	$sumSQL="SELECT ben_sale_prod.*,ben_check.*, ben_sale.*, sum(sprod_price*sprod_unit) order_product_price_total, sum(product_cost_rmb*sprod_unit) order_product_cost_total 
	FROM ben_check, ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id 
	where check_ref=sale_ref and sale_ref=sprod_ref and DATE(check_date) between '$date_start' and '$date_end' ";
	
	if (isset($sale_name) && $sale_name != '') {
		$sale_name = trim($sale_name);
		$sumSQL = $sumSQL."and sale_name like '%$sale_name%' ";
	}
	
	if ($access==Admin_name) {
		if (isset($sale_group) && $sale_group != '') {
			$sale_group = trim($sale_group);
			$sumSQL = $sumSQL."and sale_group like '%$sale_group%' ";
		}
	}
	else {
		$sumSQL = $sumSQL."and sale_group = '$user_name' ";
	}
	
	$sumSQL = $sumSQL."group by check_ref order by check_date desc, check_ref";
	
	$sumSQLresult = mysql_query($sumSQL, $db) or die (mysql_error()."<br />Couldn't execute query: $sumSQL");
	$sumSQLresult_results=mysql_num_rows($sumSQLresult);
	 
	for ($i=0;$i<$sumSQLresult_results;$i++)
	{
		$row=mysql_fetch_array($sumSQLresult);
		
		$order_product_price_total[$row["check_ref"]]=$row["order_product_price_total"];
		$order_product_cost_total[$row["check_ref"]]=$row["order_product_cost_total"];
		 
		
	}
	// for cal sum of total price and total cost per order 2012 02 09
	
	$sql = "SELECT ben_sale_prod.*,ben_check.*, ben_sale.* ,sprod_price as product_price, (sprod_price*sprod_unit) as product_price_total, product_cost_rmb as product_cost , (product_cost_rmb*sprod_unit) as product_cost_total
	FROM ben_check, ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id 
	where check_ref=sale_ref and sale_ref=sprod_ref and DATE(check_date) between '$date_start' and '$date_end' ";
	
	if (isset($sale_name) && $sale_name != '') {
		$sale_name = trim($sale_name);
		$sql = $sql."and sale_name like '%$sale_name%' ";
	}
	
	if ($access==Admin_name) {
		if (isset($sale_group) && $sale_group != '') {
			$sale_group = trim($sale_group);
			$sql = $sql."and sale_group like '%$sale_group%' ";
		}
	}
	else {
		$sql = $sql."and sale_group = '$user_name' ";
	}
	
	//$sql = $sql."group by check_ref order by check_date desc, check_ref";
	$sql = $sql."order by check_date desc, check_ref";
	
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	//loop
	$records = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$check_ref=$row["check_ref"];
		$check_date=$row["check_date"];
		$check_shipping=$row["check_shipping"];
		$sale_group=$row["sale_group"];
		$shipped_status=getemail_shipped_check($check_ref);
		
		
		
		//fill order total 2012 02 09
		$prod_id=$row["sprod_id"];
		$ord_prod_price_total=$order_product_price_total[$check_ref];
		$ord_prod_cost_total=$order_product_cost_total[$check_ref];
		$records[$i]['ord_prod_price_total']=$ord_prod_price_total;
		$records[$i]['ord_prod_cost_total']=$ord_prod_cost_total;
		
	 
		 
		
		$records[$i]['sprod_id'] = $prod_id;
		//fill order total 2012 02 09
		$records[$i]['check_ref'] = $check_ref;
		$records[$i]['sale_group'] = $sale_group;
		$records[$i]['product_price'] = $row['product_price'];
		$records[$i]['product_cost'] = $row['product_cost'];
		$records[$i]['product_price_total'] = $row['product_price_total'];
		$records[$i]['product_cost_total'] = $row['product_cost_total'];
		$records[$i]['qty'] = $row['sprod_unit'];
		$records[$i]['sale_ship_fee'] = $row['sale_ship_fee'];
		$records[$i]['total'] = $ord_prod_price_total  + $row['sale_ship_fee'];
	 
		
		$records[$i]['check_date'] = $check_date;
		$records[$i]['check_shipping'] = $check_shipping;
		$records[$i]['shipped_status'] = $shipped_status;
	}
	//end loop
	
	return $records;
}
?>
