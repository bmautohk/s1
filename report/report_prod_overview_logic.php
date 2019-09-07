<?

 	$prod_id = $_REQUEST['action'];
	$prod_id = $_REQUEST['prod_id'];
	
if ($action!=""){
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db(DB_NAME,$db);
	
	$sql="Select * from product where 1=1 and searchable='A' ";
	
	
	$sql2="SELECT check_date,sprod_id,product_name,product_cus_des,product_made,product_model,product_model_no,product.product_remark as product_remark,product_name,
	product_pcs,product.product_cus_price as product_cus_price,product_cost_rmb,product_year,product_material,product_colour_no,
	product.product_colour as product_colour,sum(sprod_unit) as totalqty ,
	fix_inventory_qty
	FROM ben_sale, ben_check, ben_sale_prod
left outer join product on ben_sale_prod.sprod_id = product.product_id 
where sprod_ref=sale_ref 
 
and sprod_ref=check_ref and check_date != '0000-00-00' ";

if($prod_id!=''){
$sql=$sql." and product_id = '$prod_id' ";
}

//echo $sql;	
//echo $sql2;

	$result =  mysql_query($sql,$db);

	
	$num_results=mysql_num_rows($result);
	
	
	$prod_n = $num_results;
	

	 
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
 
		$sprod_id[$i]=$row["product_id"];
		$sprod_name[$i]=$row["product_name"];
		$sprod_product_cus_des[$i]=$row["product_cus_des"];
		$sprod_make[$i]=$row["product_made"];
		$sprod_model[$i]=$row["product_model"];
		$sprod_product_model_no[$i]=$row["product_model_no"];
		$sprod_product_remark[$i]=$row["product_remark"];
		$sprod_product_pcs[$i]=$row["product_pcs"];
		$sprod_product_cus_price[$i]=$row["product_cus_price"];
		$sprod_product_cost_rmb[$i]=$row["product_cost_rmb"];
		
		$sprod_product_year[$i]=$row["product_year"];
		$sprod_product_material[$i]=$row["product_material"];
		$sprod_product_colour_no[$i]=$row["product_colour_no"];
		$sprod_product_colour[$i]=$row["product_colour"];
		
		
		//search stock bal from container table
		$sql3="select sum(qty) as qty from container where product_id='".$sprod_id[$i]."'";
		$result3 =  mysql_query($sql3,$db);
		$row3=mysql_fetch_array($result3);
		
		$sprod_stockbal[$i]=$row3["qty"];
		$sprod_unit[$i]=$row["totalqty"];
		
		 if($row["fix_inventory_qty"]=="")
			 $sprod_fix_inventory_qty[$i]=0;
		 else
			$sprod_fix_inventory_qty[$i]=$row["fix_inventory_qty"];
		
			
 
	}
	
	
	
	if($prod_id!=''){
		$sql2=$sql2." and sprod_id = '$prod_id' ";
	}else{
		$kk=implode("','", $sprod_id);
		$sql2=$sql2." and sprod_id in ('$kk') ";
	}

	if (isset($_POST['date_start']) and isset($_POST['search_date'])) {
		$sql2=$sql2." and check_date between '2018-07-13' and '$date_end'";
	}else{
		$sql2=$sql2." and check_date>='2018-07-13' ";
  
	}
 $sql2=$sql2." and check_date>='2018-07-13' ";
		$sql2=$sql2." group by sprod_id" ;

	$result2 =  mysql_query($sql2,$db);
	$prod_n2 = $num_results2;
 	$num_results2=mysql_num_rows($result2);
	for ($i=0;$i<$num_results2;$i++) {
		$row2=mysql_fetch_array($result2);
		$shipAfter14[$row2['sprod_id']]=$row2['totalqty'];
	}
	
//echo $sql2;
	
for ($i=0;$i<count($sprod_id);$i++){	
	$sprod_shipAfter14[$i]=$shipAfter14[$sprod_id[$i]];
}
}
?>