<?php

function isOrderExist($db, $sale_ref) {

	$result = mysql_query("SELECT sale_ref FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results = mysql_num_rows($result);
	mysql_free_result($result);
	
	return $num_results == 0 ? false : true;
}

function insertSale($sale_ref, $order_date, $sale_group, $sale_email, $sale_name,
		$sale_yahoo_id, $sale_chk_ref, $sale_ship_fee, $sale_discount, $sale_tax) {
	$sql = "INSERT INTO ben_sale SET
			sale_ref = '$sale_ref',
			sale_date = '".$order_date."',
			sale_group = '".trim($sale_group)."',
			sale_email = '".trim($sale_email)."',
			sale_name = '".trim($sale_name)."',
			sale_yahoo_id = '".trim($sale_yahoo_id)."',
			sale_dat = curdate(),
			sale_chk_ref = $sale_chk_ref,
			sale_ship_fee = ".$sale_ship_fee.",
			sale_discount = ".$sale_discount.",
			sale_tax = ".$sale_tax.",
			sts = 'A'";
		sqlinsert($sql);
}

function insertSaleProduct($sale_ref, $sprod_id, $sprod_name, $sprod_price, $sprod_unit,
		$sprod_material = NULL, $sprod_colour = NULL) {
	$sql = "INSERT INTO ben_sale_prod SET
			sprod_ref = '$sale_ref',
			sprod_id = upper('".trim($sprod_id)."'),
			sprod_name = '".trim($sprod_name)."',
			sprod_price = ".trim($sprod_price).",
			sprod_unit = ".trim($sprod_unit).",
			sprod_material = '".trim($sprod_material)."',
			sprod_colour = '".trim($sprod_colour)."'";
	
	sqlinsert($sql);
}

function insertDebt($sale_ref, $debt_pay_name, $debt_cust_address1, $debt_cust_address2, 
		$debt_cust_address3, $debt_email, $debt_post_co, $debt_tel, $debt_mobile, 
		$debt_bank, $debt_pay_method, $debt_shipping_method, 
		$debt_email_sent, $debt_remark) {
	
	$sql = "INSERT INTO ben_debt SET
			
			debt_ref='".$sale_ref."',
			
			debt_tel='".$debt_tel."',
			
			debt_pay_name='".$debt_pay_name."',
			
			debt_mobile='".$debt_mobile."',
			
			debt_cust_address1='".$debt_cust_address1."',
			
			debt_cust_address2='".$debt_cust_address2."',
			
			debt_cust_address3='".$debt_cust_address3."',
			
			debt_email='".$debt_email."',
			
			debt_post_co='".$debt_post_co."',
			
			debt_bank='".$debt_bank."',
			
			debt_pay_method='".$debt_pay_method."',
			
			debt_remark='".$debt_remark."',
			
			debt_shipping_method='".$debt_shipping_method."',
			
			debt_email_sent='".$debt_email_sent."',
			
			debt_dat = curdate()";
	
	sqlinsert($sql);
}

function insertBalance($sale_ref, $bal_pay, $bal_pay_type, $bal_ship_type, $bal_delivery_date = NULL, 
		$bal_delivery_time_option_id = NULL, $bal_delivery_time = NULL) {
 
	$sql = "INSERT INTO ben_bal SET
		
			bal_ref='".$sale_ref."',
				
			bal_pay=".(is_null($bal_pay ) ? 'NULL' : "'".$bal_pay."'").",
				
			bal_pay_type='".$bal_pay_type."',
				
			bal_ship_type='".$bal_ship_type."',
			
			bal_delivery_date= ".($bal_delivery_date == NULL ? 'NULL' : "'".$bal_delivery_date."'").",
			
			bal_delivery_time_option_id = ".($bal_delivery_time_option_id == NULL ? 'NULL' : $bal_delivery_time_option_id).",
			
			bal_delivery_time='".$bal_delivery_time."',
				
			bal_dat = curdate()";
 
	sqlinsert($sql);
}
