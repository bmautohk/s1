<?
function getPayReport($date_start,$date_end,$access,$user_name)
{
	ob_flush();
	flush();
	
	$xi=0;
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	
	
	if ($access==Admin_name){
	
		$result = mysql_query("SELECT * FROM ben_sale, ben_bal, ben_sale_prod where sale_ref=sprod_ref and  bal_ref=sprod_ref and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc, bal_ref"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	else{
		$result = mysql_query("SELECT * FROM ben_sale, ben_bal, ben_sale_prod where sale_ref=sprod_ref and  bal_ref=sprod_ref and  sale_group='$user_name' and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc, bal_ref"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group </td><td >Payment Date</td>
	<td >Product ID</td><td>Price</td><td>Shipping</td><td>total</td><td >Payment Amount</td>
	<td >Detail</td>\n";
	
	//loop
	$bal_pay_total=0;
	$prev_bal_ref = '';
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$bal_ref=$row["bal_ref"];
		$bal_dat=$row["bal_dat"];
		$sale_group=$row["sale_group"];
		$sprod_id=$row["sprod_id"];
		$sale_ref=$row["sale_ref"];

		if ($prev_bal_ref != $bal_ref) {
			$prev_bal_ref = $bal_ref;

			$bal_pay=$row["bal_pay"];
			$cost_prod=getprod_cost($sale_ref);
			$sale_ship_fee=$row["sale_ship_fee"];
			$sale_tax=$row["sale_tax"];

			if ($sale_tax!='0.00') {
				$cost_prod=$cost_prod*$sale_tax/100;
				$cost_prod = number_format(round($cost_prod, 0),2,'.','');
			}
			$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');

			$bal_pay_total+=$bal_pay;
		} else {

			$cost_prod = 0;
			$sale_ship_fee = 0;
			$cost_total = 0;
			$bal_pay = 0;
		}
			
		$xi=$xi+1;
		
		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$bal_ref'>".$bal_ref."</a></td><td>".$sale_group."</td><td>".$bal_dat."</td><td>".$sprod_id."</td><td>".$cost_prod."</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_pay."</td>
		
		<td ><a target='_blank' href='index.php?page=order&subpage=balance&sale_ref=$bal_ref'>Click</a></td>
		
		</tr>\n";
	}
	//end loop
	echo "<tr><td>".$xi."</td><td></td><td></td><td>Total</td><td>".$bal_pay_total."</td></tr>";
	echo "</table>";
	
}


function genCSVByDate($date_start,$date_end,$access,$user_name)
{

	$xi=0;
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	
 
	if ($access==Admin_name){
 		$result = mysql_query("SELECT * FROM ben_sale, ben_bal, ben_sale_prod where sale_ref=sprod_ref and  bal_ref=sprod_ref and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc, bal_ref"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
		}
	else{
		$result = mysql_query("SELECT * FROM ben_sale, ben_bal, ben_sale_prod where sale_ref=sprod_ref and  bal_ref=sprod_ref and  sale_group='$user_name' and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc, bal_ref"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	$num_results=mysql_num_rows($result);
	//table echo 
	 
	
	//loop
	$bal_pay_total=0;
	$prev_bal_ref = '';
	for ($i=0;$i<$num_results;$i++)
	{
		
		$row=mysql_fetch_array($result);
		$bal_ref=$row["bal_ref"];
		$bal_dat=$row["bal_dat"];
		$sale_group=$row["sale_group"];
		
		$sprod_id=$row["sprod_id"];
		$sale_ref=$row["sale_ref"];

		if ($prev_bal_ref != $bal_ref) {
			$prev_bal_ref = $bal_ref;

			$bal_pay=$row["bal_pay"];
			$sale_ship_fee=$row["sale_ship_fee"];
			$sale_tax=$row["sale_tax"];

			$cost_prod=getprod_cost($sale_ref);

			if ($sale_tax!='0.00') {
				$cost_prod=$cost_prod*$sale_tax/100;
				$cost_prod = number_format(round($cost_prod, 0),2,'.','');
			}
			$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');
			
			$bal_pay_total+=$bal_pay;

		} else {
			$bal_pay = 0;
			$sale_ship_fee = 0;
			$cost_prod = 0;
			$cost_total = 0;
		}
		
		$xi=$xi+1;
		
		$orders[$i]['sale_ref']=$sale_ref;
		$orders[$i]['sale_group']=$sale_group;
		$orders[$i]['bal_dat']=$bal_dat;
		$orders[$i]['sprod_id']=$sprod_id;
		$orders[$i]['cost_prod']=$cost_prod;
		$orders[$i]['sale_ship_fee']=$sale_ship_fee;
		$orders[$i]['cost_total']=$cost_total;
		$orders[$i]['bal_pay']=$bal_pay;
	}
	//end loop
	
	 
	// Free resultset
	mysql_free_result($result);

	// Closing connection
	mysql_close($db);
	
	return $orders;
}
?>