<?
function getPayReport($date_start,$date_end,$access,$user_name)
{
	ob_flush();
	flush();
	
	$xi=0;
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	if ($access==Admin_name)
		$result = mysql_query("SELECT * FROM ben_bal, ben_sale_prod where bal_ref=sprod_ref and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
		$result = mysql_query("SELECT * FROM ben_bal, ben_sale_prod where bal_ref=sprod_ref and  sale_group='$user_name' and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"350\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group </td><td >Payment Date</td>
	<td >Product ID</td><td >Payment Amount</td>
	<td >Detail</td>\n";
	
	//loop
	$bal_pay_total=0;
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$bal_ref=$row["bal_ref"];
		$bal_dat=$row["bal_dat"];
		$sale_group=$row["sale_group"];
		$bal_pay=$row["bal_pay"];
		$sprod_id=$row["sprod_id"];
		$xi=$xi+1;
		$bal_pay_total+=$bal_pay;
		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$bal_ref'>".$bal_ref."</a></td><td>".$sale_group."</td><td>".$bal_dat."</td><td>".$sprod_id."</td><td>".$bal_pay."</td>
		
		<td ><a target='_blank' href='index.php?page=order&subpage=balance&sale_ref=$bal_ref'>Click</a></td>
		
		</tr>\n";
	}
	//end loop
	echo "<tr><td>".$xi."</td><td></td><td></td><td>Total</td><td>".$bal_pay_total."</td></tr>";
	echo "</table>";
	
}
?>