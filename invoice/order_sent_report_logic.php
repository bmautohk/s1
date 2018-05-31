<?
function getSentReport($date_start,$date_end,$access,$user_name)
{
	ob_flush();
	flush();
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	//echo $username;
	if ($access==Admin_name)
		$result = mysql_query("SELECT * FROM ben_check, ben_sale where check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
		$result = mysql_query("SELECT * FROM ben_check, ben_sale where sale_group = '$user_name' and check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group</td><td >Shipping Date</td><td >Tracking No.</td><td >Detail</td><td >Tracking email</td><td >Status</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$check_ref=$row["check_ref"];
		$check_date=$row["check_date"];
		$check_shipping=$row["check_shipping"];
		$check_print=$row["check_print"];
		$sale_group=$row["sale_group"];
		$shipped_status=getemail_shipped_check($check_ref);

		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$check_ref'>".$check_ref."</a></td><td>".$sale_group."</td><td>".$check_date."</td><td>".$check_shipping."</td><td ><a target='_blank' href='index.php?page=order&subpage=shipping&sale_ref=$check_ref'>Click</a></td><td><a href='ship_email.php?sale_ref=$check_ref' target='_blank'>Preview</td><td>".$shipped_status."&nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
}
?>