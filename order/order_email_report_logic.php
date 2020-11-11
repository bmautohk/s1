<?
function getEmailReport($date_start,$date_end,$access,$user_name)
{
	ob_flush();
	flush();
	
	$db=connectDatabase();
	mysql_select_db("autopart_db",$db);
	if ($access==Admin_name)
		$result = mysql_query("SELECT * FROM ben_email,ben_sale where email_ref=sale_ref and DATE(email_datetime) between '$date_start' and '$date_end' order by email_datetime desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
		$result = mysql_query("SELECT * FROM ben_email,ben_sale where sale_group='$user_name' and email_ref=sale_ref and DATE(email_datetime) between '$date_start' and '$date_end' order by email_datetime desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"350\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group</td><td >Email Date</td><td >Detail</td>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$email_ref=$row["email_ref"];
		$email_dat=$row["email_datetime"];
		$email_text=$row["email_text"];
		$email_no=$row["email_no"];
		$sale_group=$row["sale_group"];
		
		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$email_ref'>".$email_ref."</a></td><td>".$sale_group."</td><td>".$email_dat."</td><td ><a target='_blank' href='email_detail.php?email_no=$email_no'>Click</a></td></tr>\n";
	}
	//end loop
	echo "</table>";
}
?>