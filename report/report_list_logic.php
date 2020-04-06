<?
if (isset($_POST['search_sale']))
{
 if ($_POST['sale_ref']!=""){
	$sale_ref=$_POST['sale_ref'];
 }else {
	$sale_ref='';
 } 
 
if ($_POST['prod_name']!=""){
	$prod_name=$_POST['prod_name'];
 }else {
	$prod_name='';
 } 
  
 
}



function getReportTop($date_start,$date_end,$sale_top,$sale_select)
{
	 
	ob_flush();
	flush();
	
	$bal_total = 0;
	$sale_total = 0;
	$return_total = 0;
	$tax_total = 0;
	$ship_total = 0;
	$dis_total = 0;
	$sub_total = 0;
	$sub = 0;
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql = "select sum(sprod_price * sprod_unit + sprod_price*sprod_unit*sale_tax/100 + sale_ship_fee - sale_discount) as price, sale_group, count(sale_ref) as counter from ben_sale, ben_sale_prod where sale_ref=sprod_ref and sale_date between '$date_start' and '$date_end' GROUP by sale_group order by price desc limit 0, $sale_select";
	//echo $sql;
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"left\"><td>Group</td><td>Total Sale</td><td>Order</td></tr>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$sale_group=$row["sale_group"];
		$sale_price=$row["price"];
		$counter=$row["counter"];
		
		echo "<tr valign=\"top\" align=\"left\"> <td>".$sale_group."</td><td>".number_format($sale_price,2,'.','')."</td><td>$counter</td><tr>";
	}
	//end loop
	
	echo "</table>";
	}

function getOrderReport($date_start,$date_end,$sale_or,$sale_as,$mod, $username,$mod2)
{

	 
	ob_flush();
	flush();
	
	$bal_total = 0;
	$sale_total = 0;
	$return_total = 0;
	$tax_total = 0;
	$ship_total = 0;
	$dis_total = 0;
	$sub_total = 0;
	$sub = 0;
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$sum_sql = "SELECT sale_ref, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total,
	sale_discount, sale_ship_fee, sale_tax ,SUM( product_cost_rmb * sprod_unit ) AS pcost ";
	
	$select_sql = "SELECT sprod_name,sale_email, 
	sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total, 
	sale_group, sale_ref, sale_date, sale_dat, sprod_id, sale_tax, sale_discount,sale_ship_fee, sum(sprod_price*sprod_unit) as s_total, product_cost_rmb ";
	
	$from_sql = "FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id 
	where sprod_ref=sale_ref ";
	
	if ($mod == "date") {
		$from_sql .= "and sale_date between '$date_start' and '$date_end' ";
		
		if ($username!='') {
		//20110221
		//add sprod_name,sale_email
			$from_sql .= "and sale_group='$username' ";
			//$qu="SELECT  sprod_name,sale_email, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total, sale_group, sale_ref, sale_date, sale_dat, sprod_id, sale_tax, sale_discount,sale_ship_fee, sum(sprod_price*sprod_unit) as s_total, sum(product_cost_rmb) product_cost_rmb FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sprod_ref=sale_ref and sale_group='$username' and sale_date between '$date_start' and '$date_end' group by sale_ref order by $sale_or $sale_as";
		}
		else {
		//20110221
		//add sprod_name,sale_email 
			//$qu="SELECT  sprod_name,sale_email, sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total, sale_group, sale_ref, sale_date, sale_dat, sprod_id, sale_tax, sale_discount,sale_ship_fee, sum(sprod_price*sprod_unit) as s_total, sum(product_cost_rmb) product_cost_rmb FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sprod_ref=sale_ref and sale_date between '$date_start' and '$date_end' group by sale_ref order by $sale_or $sale_as";
		}

		//$result = mysql_query($qu ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
		
	}
	else
	{
		//20110221
		//add sprod_name,sale_email 
		//$qu="SELECT sprod_name,sale_email,sum(sprod_price*sprod_unit)-sale_discount + sum(sprod_price*sprod_unit)*(sale_tax/100) + sale_ship_fee as p_total, sale_group, sale_ref, sale_date, sale_dat, sprod_id, sale_tax, sale_discount,sale_ship_fee, sum(sprod_price*sprod_unit) as s_total, sum(product_cost_rmb) product_cost_rmb FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sprod_ref=sale_ref and sale_ref like '%$mod%' and sprod_name like '%$mod2%' group by sale_ref order by $sale_or $sale_as" ;
		$from_sql .= "and sale_ref like '%$mod%' and sprod_name like '%$mod2%' ";
		//20110221
		
		//$result = mysql_query($qu ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}

	// Per-calculate total sale
	$sql = $sum_sql.$from_sql."group by sale_ref";
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);
	
	$totalSale = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$totalSale[$row['sale_ref']] = $row['p_total'];
		$totalCost=$totalCost+$row['pcost'];
		$sale_total_total = $sale_total_total+ $row['p_total'];
		$dis_total = $dis_total + $row['sale_discount'];
		$ship_total = $ship_total + $row['sale_ship_fee'];
		$tax_total = $tax_total + $row['sale_tax'];
	}
	
	mysql_free_result($result);

	//echo $qu;
	
	$sql = $select_sql.$from_sql."group by sale_ref, sprod_id order by $sale_or $sale_as, sale_ref ";
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);

	//table echo 
	echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"right\"><td  >Order date</td><td  >Order No.</td><td  >Product ID</td><td>Product name</td><td>Client Email</td><td  >Total Sale</td><td>Cost (RMB)</td><td >Sale</td><td  >Discount</td><td  >Shipping fee</td><td  >Tax</td><td  >Balance</td><td >Return</td><td>Group</td></tr>\n";
	
	
	//loop
	$balData = array();
	$returnData = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$sale_group=$row["sale_group"];
		$sale_ref=$row["sale_ref"];
		$sale_date=$row["sale_date"];
		$sale_dat=$row["sale_dat"];
		$sprod_id=$row["sprod_id"];
		$product_cost_rmb = $row["product_cost_rmb"];
			//20110221
		//add sprod_name,sale_email,sale_dat
		$sprod_name=$row["sprod_name"];
		$sale_email=$row["sale_email"];
		 
		//20110221
		$sale_tax=$row["sale_tax"];
		$sale_discount=$row["sale_discount"];
		$sale_ship_fee=$row["sale_ship_fee"];
		$sale_total = $totalSale[$sale_ref]; //$sale_total = $row["p_total"];
		$sub_total=$row['s_total'];
		
		$sub_total_sale = $sub_total_sale + $sub_total;
		
		//echo $sale_ref." ".$balData[$sale_ref]."<br>";
		if (!array_key_exists($sale_ref, $balData)) {
			// bal
			$bal_row = getbal_data($sale_ref);
			if ($bal_row) {
				$bal_total=$bal_total + $bal_row['bal_pay'];
				$balData[$sale_ref] = $bal_row;
			}
			else {
				$balData[$sale_ref] = null;
			}
			
			$return_row = getreturn_data($sale_ref);
			if ($return_row) {
				$return_pay = $bal_row['return_pay'];
				$return_total = $return_total + $return_pay + $return_row['return_pay'];
				$returnData[$sale_ref] = $return_row;
			}
			else {
				$returnData[$sale_ref] = null;
			}
		}

		// bal
		if ($balData[$sale_ref] != null) {
			$bal_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">". $balData[$sale_ref]['bal_pay'] ."<br> (".$balData[$sale_ref]['bal_dat'].")</a>";
		}
		else {
			$bal_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">Not Pay</a>";
		}
		
		// return
		if ($returnData[$sale_ref] != null) {			
			$return_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">". $returnData[$sale_ref]['return_pay'] ."<br> (".$returnData[$sale_ref]['return_dat'].")</a>";
		}
		else {
			$return_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">No Refund</a>";
		}
		
		//bal
		/* if (getbal_data($sale_ref)){		
			$bal_row = getbal_data($sale_ref);
			$bal_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">". $bal_row['bal_pay'] ."<br> (".$bal_row['bal_dat'].")</a>";
			$bal_total=$bal_total + $bal_row['bal_pay'];
		}
		else
		{$bal_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">Not Pay</a>";
		$bal_return = "0.00";
		}
		
		//return
		if (getreturn_data($sale_ref)){		
			$return_row = getreturn_data($sale_ref);
			$return_pay = $bal_row['return_pay'];
			$return_total = $return_total + $return_pay;
			$return_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">". $return_row['return_pay'] ."<br> (".$return_row['return_dat'].")</a>";
			$return_total=$return_total + $return_row['return_pay'];
		}
		else {
			$return_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">No Refund</a>";
			$return_pay = "0.00";
		} */
		
		echo "<tr valign=\"top\" align=\"right\"> <td>".$sale_date."</td><td>".$sale_ref."<br>(".$sale_dat .")</td><td>".$sprod_id."</td><td>".$sprod_name."</td><td>".$sale_email."</td><td  >".number_format($sale_total)."</td><td>".$product_cost_rmb."&nbsp;</td><td>".number_format($sub_total)."</td><td>".number_format($sale_discount)."</td><td>".number_format($sale_ship_fee)."</td><td>".$sale_tax."</td><td width='120'>".$bal_data."</td><td  >".$return_data."</td><td>$sale_group</td></tr>\n";
	}
	
	
	//end loop
	echo "<tr valign=\"top\" align=\"right\"> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> </tr>\n";
	
	
	echo "<tr valign=\"top\" align=\"right\"> <td >&nbsp;</td> <td >&nbsp;</td> <td >&nbsp;</td> <td  >&nbsp;</td><td>Total: </td><td>".number_format($sale_total_total)."</td><td>".number_format($totalCost)."</td><td>".number_format($sub_total_sale)."</td><td>".number_format($dis_total)."</td><td>".number_format($ship_total)."</td><td>".number_format($tax_total)."</td><td width='120'>".number_format($bal_total)."</td><td >".number_format($return_total)."</td><td >&nbsp;</td></tr>\n";
	echo "</table>";
	
	mysql_free_result($result);
	mysql_close($db);
	
}


?>