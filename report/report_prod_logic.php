<?

if ((isset($_POST['prod_id']) || isset($_POST['prod_name'])) and ($_POST['prod_id']!='' or $_POST['prod_name']!='') and isset($_POST['search_sale'])){
	$prod_id = $_POST['prod_id'];
	$prod_name = $_POST['prod_name'];
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db(DB_NAME,$db);
	$result =  mysql_query("SELECT * FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sprod_ref=sale_ref and sprod_id like '$prod_id%' and sprod_name like '%$prod_name%'" ,$db);

	$num_results=mysql_num_rows($result);
	$prod_n = $num_results;
	
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$sprod_no[$i]=$row["sprod_no"];
		$sprod_id[$i]=$row["sprod_id"];
		$sprod_name[$i]=$row["sprod_name"];
		$sprod_ref[$i]=$row["sprod_ref"];
		$sprod_price[$i]=$row["sprod_price"];
		$sprod_unit[$i]=$row["sprod_unit"];
		$sprod_cost_rmb[$i]=$row["product_cost_rmb"];
		
		$sale_email[$i]=$row["sale_email"];
		$sale_date[$i]=$row["sale_date"];
		$sale_dat[$i]=$row["sale_dat"];
		  
		 
		
		$total_price += $sprod_price[$i];
		$total_unit += $sprod_unit[$i];
	}
}
else if (isset($_POST['date_start']) and isset($_POST['search_date'])) {
	$date_start = $_POST['date_start'];
	$date_end = $_POST['date_end'];
	$sprod_top = $_POST['sprod_top'];
	$sprod_select = $_POST['sprod_select'];

	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
 
	mysql_select_db(DB_NAME,$db);
	if ($sprod_top == "1") {
		$result =  mysql_query("SELECT *, sum(sprod_unit) as counter FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end') group by sprod_id order by counter desc limit 0, $sprod_select  " ,$db);
	}
	else {
		$result =  mysql_query("SELECT *, sprod_unit as counter FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end')" ,$db);
	}
	$num_results=mysql_num_rows($result);
	
	
	$prod_n = $num_results;
	
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$sprod_no[$i]=$row["sprod_no"];
		$sprod_id[$i]=$row["sprod_id"];
		$sprod_name[$i]=$row["sprod_name"];
		$sprod_ref[$i]=$row["sprod_ref"];
		$sprod_price[$i]=$row["sprod_price"];
		$sprod_unit[$i]=$row["counter"];
		$sale_email[$i]=$row["sale_email"];
		$sale_date[$i]=$row["sale_date"];
		$sale_dat[$i]=$row["sale_dat"];
		$sprod_cost_rmb[$i]=$row["product_cost_rmb"];
		  
		$total_price += $sprod_price[$i];
		$total_unit += $sprod_unit[$i];
	}
}

?>