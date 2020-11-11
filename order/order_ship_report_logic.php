
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

function getShipReportData($access,$user_name,$group3,$prod_id) {
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
		and sale_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)
		and bal_pay is not null
		 ";
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
		and sale_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)
		and bal_pay is not null
		 ";
	}
	
	//20180819
	if ($prod_id!="")
	$query =$query. "  and ben_sale_prod.sprod_id in ('$prod_id') ";
	$query =$query. " order by bal_dat asc ";
	
	//echo $query;
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
		$prod_no=$data['sprod_id'];
		$data['debt_remark'] = $row["debt_remark"];
		$data['debt_post_co'] = $row["debt_post_co"];
		
		
		//get RealStock 20180729
		$realStock=getRealStockByItemArray($row["sprod_id"]);
		$data['realstock']=$realStock;
		
		
		$query = "SELECT sagawa_label,sagawa_label2,person_in_charge FROM product where product_id='$prod_no'";
		$result2 = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
		$row2=mysql_fetch_array($result2);
		$data['sagawa_label']= $row2["sagawa_label"];
		$data['sagawa_label2']= $row2["sagawa_label2"];
		$data['person_in_charge'] = $row2["person_in_charge"];
		$data_list[] = $data;
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);
	
	return $data_list;
}

function getShipReport2($date_start,$date_end,$access,$user_name,$prod_id)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	if ($access==Admin_name)
	{
		$sql="SELECT * 
		FROM ben_sale
		join ben_bal on sale_ref=bal_ref 
		 
		left outer join ben_check on check_ref=sale_ref 
		left outer join ben_sale_prod on sprod_ref = sale_ref 
		where    sale_date >= '$date_start' 
		and sale_date <= '$date_end' 
		and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') 
		and sale_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)
		and bal_pay is not null
		 ";
		
		if($prod_id!="")
		$sql =$sql. "  and ben_sale_prod.sprod_id in ('$prod_id') ";
		$sql=$sql."  group by bal_ref order by created_date Desc";
	//echo $sql;	 
	//$sql="SELECT * FROM ben_bal,ben_sale ,ben_check where check_ref=sale_ref and bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by created_date Desc";
//	echo $sql;
		
		
	}
	else {
		$sql="SELECT * 
		FROM ben_sale
		join ben_bal on sale_ref=bal_ref 
		join authorize on sale_group=username
		left outer join ben_check on check_ref=sale_ref 
		left outer join ben_sale_prod on sprod_ref = sale_ref 
		
		where    sale_group='$user_name' 
		and sale_date >= '$date_start' 
		and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00')
		and bal_pay is not null
			";
		
		 if($prod_id!="")
		$sql =$sql. "  and ben_sale_prod.sprod_id='$prod_id' ";
		$sql=$sql." group by bal_ref  order by created_date Desc";
	
	//	$sql = "SELECT * FROM ben_bal,ben_sale  ,ben_check where check_ref=sale_ref and sale_group='$user_name' and bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by created_date Desc";
	
	// echo $sql;
	}
	$result = mysql_query( $sql,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td><input type=\"checkbox\" name=\"cb_select_all\" /></td><td >Prod ID.</td><td>B+C</td><td>Remark</td><td>RealStock</td><td >Group</td><td >post code</td><td >Client Name</td><td >Payment Date</td><td >Auction ID</td><td >Out Of Stock</td><td>Print Date</td>\n";
	
	
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
	

			//get RealStock 20180729
		$realStock=getRealStockByItemArray($sprod_id);
		
			//get person_in_charge 20180805
			
		$query = "SELECT sagawa_label,person_in_charge FROM product where product_id='$sprod_id'";
		$result2 = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
		$row2=mysql_fetch_array($result2);
	 
				echo "<tr align=\"right\" valign=\"top\">	<td>";
              			 if (!empty($row_prod['sprod_no'])) { 
              			echo "<input type=\"checkbox\" name=\"cb_sprod_no[]\" value=\"".$row_prod['sprod_no']."\" />";
              			 } 
              		echo "</td><td><a href='index.php?page=order&subpage=edit&sale_ref=$bal_ref'>".$sprod_id."</a></td><td>".$row2["person_in_charge"]."</td><td >$debt_remark  &nbsp;</td><td>".$realStock."</td><td>&nbsp;".$sale_group."</td><td>&nbsp;".$debt_post_co."</td><td>&nbsp;".$sale_name."</td><td>".$bal_dat."</td><td><a href='index.php?page=order&subpage=shipping&sale_ref=$bal_ref'>".$bal_ref."</a></td><td >Y</td><td>$created_date</td></tr>\n";
	}
	//end loop
	echo "</table>";
}





function getRealStockByItemArray($prodid){
	
 
	ob_flush();
	flush();
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
		
	$sql2="SELECT check_date,sprod_id,product_name,product_cus_des,product_made,product_model,product_model_no,product.product_remark as product_remark,product_name,
	product_pcs,product.product_cus_price as product_cus_price,product_cost_rmb,product_year,product_material,product_colour_no,
	product.product_colour as product_colour,sum(sprod_unit) as totalqty ,
	fix_inventory_qty 
	FROM ben_sale, ben_check, ben_sale_prod
	left outer join product on ben_sale_prod.sprod_id = product.product_id 
	where sprod_ref=sale_ref 
	and sprod_ref=check_ref and check_date != '0000-00-00' ";
	$sql2=$sql2." and check_date>='2018-07-13' ";
	$sql2=$sql2." and sprod_id ='".$prodid."' ";
	
	
	
	//echo $sql2;
	
	$result2 = mysql_query($sql2, $db);
	
	$row=mysql_fetch_array($result2);
	
		//find stock bal
		$sql3="select sum(qty) as qty from container where product_id='".$prodid."'";
		$result3 =  mysql_query($sql3,$db);
		$row3=mysql_fetch_array($result3);
		
		$realStock=$row3["qty"]-$row['totalqty']+$row['fix_inventory_qty'];
		//echo $prodid."+".$row3["qty"]."+".$row['totalqty']."+".$row['fix_inventory_qty'];
		
	return $realStock;
	 
}




?>