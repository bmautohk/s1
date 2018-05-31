
<?
if (isset($_GET['search_sale']))

{ $sale_ref=$_GET['sale_ref'];}

else {$sale_ref='';

}



if (isset($_GET['search_name']))

{ $sale_name=$_GET['sale_name'];}

else {$sale_name='';

}

/* function getShipReport($access,$user_name,$group3)
{
	ob_flush();
	flush();
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	if ($access==Admin_name)
		$result = mysql_query("SELECT * FROM ben_bal, ben_sale, authorize where sale_group=username and group3='$group3' and bal_ref not in (select check_ref from ben_check) and sale_ref=bal_ref order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
		$result = mysql_query("SELECT * FROM ben_bal, ben_sale, authorize where sale_group=username and group3='$group3' and sale_group='$user_name' and bal_ref not in (select check_ref from ben_check) and sale_ref=bal_ref order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Prod ID</td><td >Sale Group</td><td >Client name</td><td >Shipping Type</td><td >Payment Date</td><td >Auction ID</td><td> Remark</td>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$bal_ref=$row["bal_ref"];
		$bal_dat=$row["bal_dat"];
		$sale_group=$row["sale_group"];
		$sale_name=$row["sale_name"];
		$bal_ship_type=$row["bal_ship_type"];
		$row_prod = getsale_prod_data($bal_ref);
		$sprod_id = $row_prod["sprod_id"];
		$row_debt = getdebt_data($bal_ref);
		$debt_remark = '';
		if ($row_debt["debt_remark"]!=""){
			$debt_remark = $row_debt["debt_remark"];
		}

		echo "<tr align=\"right\" valign=\"top\"> <td><a href='index.php?page=order&subpage=edit&sale_ref=$bal_ref'>".$sprod_id."</a></td><td>".$sale_group."&nbsp;</td><td>".$sale_name."&nbsp;</td><td>".$bal_ship_type."&nbsp;</td><td>".$bal_dat."</td><td><a href='index.php?page=order&subpage=shipping&sale_ref=$bal_ref'>".$bal_ref."</a></td><td>$debt_remark &nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
} */

function getShipReportData($access,$user_name,$group3) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	if ($access==Admin_name) {
		$query =
		"SELECT * 
		FROM ben_sale
		join authorize on sale_group=username
		join ben_bal on sale_ref=bal_ref
		left outer join ben_sale_prod on sprod_ref = sale_ref 
		left outer join ben_debt on debt_ref = sale_ref 
		where group3='$group3' 
		and bal_ref not in (select check_ref from ben_check)
		order by bal_dat asc";
	}else {
		$query = 
		"SELECT * 
		FROM ben_sale
		join authorize on sale_group=username
		join ben_bal on sale_ref=bal_ref
		left outer join ben_sale_prod on sprod_ref = sale_ref 
		left outer join ben_debt on debt_ref = sale_ref
		where group3='$group3' 
		and sale_group='$user_name' 
		and bal_ref not in (select check_ref from ben_check) 
		order by bal_dat asc";
	}
	
	$result = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	$data_list = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$data = array();
		
		$data['sprod_no'] = $row['sprod_no'];
		$data['bal_ref'] = $row["bal_ref"];
		$data['sale_group'] = $row["sale_group"];
		$data['sale_name'] = $row["sale_name"];
		$data['bal_ship_type'] = $row["bal_ship_type"];
		$data['sprod_id'] = $row["sprod_id"];
		$data['debt_remark'] = $row["debt_remark"];
		$data['debt_post_co'] = $row["debt_post_co"];
		
		
		$data_list[] = $data;
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);
	
	return $data_list;
}

function getShipReport2($date_start,$date_end,$access,$user_name)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_bal,ben_sale ,ben_check where check_ref=sale_ref and bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by created_date Desc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else 
	$result = mysql_query("SELECT * FROM ben_bal,ben_sale  ,ben_check where check_ref=sale_ref and sale_group='$user_name' and bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by created_date Desc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td><input type=\"checkbox\" name=\"cb_select_all\" /></td><td >Prod ID.</td><td >Group</td><td >post code</td><td >Client Name</td><td >Payment Date</td><td >Auction ID</td><td >Out Of Stock</td><td>Remark</td><td>Print Date</td>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$bal_ref=$row["bal_ref"];
	$bal_dat=$row["bal_dat"];
	$sale_group=$row["sale_group"];
	$sale_name=$row["sale_name"];
	$row_prod = getsale_prod_data($bal_ref);
	$sprod_id = $row_prod["sprod_id"];
	$created_date=$row["created_date"];
	$row_debt = getdebt_data($bal_ref);
	$debt_remark = '';
	if ($row_debt["debt_remark"]!=""){
		$debt_remark = ' - '.$row_debt["debt_remark"];
	}
	
	$debt_post_co = $row_debt["debt_post_co"];
		
				echo "<tr align=\"right\" valign=\"top\">	<td>";
              			 if (!empty($row_prod['sprod_no'])) { 
              			echo "<input type=\"checkbox\" name=\"cb_sprod_no[]\" value=\"".$row_prod['sprod_no']."\" />";
              			 } 
              		echo "</td><td><a href='index.php?page=order&subpage=edit&sale_ref=$bal_ref'>".$sprod_id."</a>$debt_remark</td><td>&nbsp;".$sale_group."</td><td>&nbsp;".$debt_post_co."</td><td>&nbsp;".$sale_name."</td><td>".$bal_dat."</td><td><a href='index.php?page=order&subpage=shipping&sale_ref=$bal_ref'>".$bal_ref."</a></td><td >Y</td><td >$debt_remark  &nbsp;</td><td>$created_date</td></tr>\n";
	}
	//end loop
	echo "</table>";
}
?>