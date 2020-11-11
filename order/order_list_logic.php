<?



if (isset($GLOBALS['issearch']))
	
{

$check_shipping_jp=$GLOBALS['check_shipping_jp'];

$sale_ref=$GLOBALS['sale_ref'];

$sale_name=$GLOBALS['sale_name'];

$sale_email=$GLOBALS['sale_email'];

$sale_yhoo_id=$GLOBALS['sale_yahoo_id'];

$sale_name=$GLOBALS['sale_name'];

$debt_cust_address1=$GLOBALS['debt_cust_address1'];

$debt_cust_address2=$GLOBALS['debt_cust_address2'];

$debt_post_co=$GLOBALS['debt_post_co'];

$min_m=$GLOBALS['min_m'];

$max_m=$GLOBALS['max_m'];

$total_m=$GLOBALS['total_m'];

$total_price=$GLOBALS['total_price'];

$sts=$GLOBALS['sts'];
$nopayment=$GLOBALS['nopayment'];
}

else {
	$check_shipping_jp='';
	$sale_ref='';
	
	$sale_name='';
	
	$sale_email='';
	
	$sale_yhoo_id='';
	
	$sale_name='';
	
	$debt_cust_address1='';
	
	$debt_cust_address2='';
	
	$debt_post_co='';
	
	$min_m=0;
	
	$max_m='';
	
	$total_m='';
	
	
	$sts='';
}

function getOrderListByDate($date_start,$date_end,$access,$user_name) 
{

	ob_flush();
	flush();
//echo "getOrderListByDate";
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$searchKey = "&date_start=".$date_start."&date_end=".$date_end;

	
	if ($access==Admin_name)
		$sql = "from ben_sale as s, ben_sale_prod as s1 where s.sale_ref = s1.sprod_ref and s.sale_date between '$date_start' and '$date_end' ";
	else
		$sql = "from ben_sale as s, ben_sale_prod as s1 where s.sale_ref = s1.sprod_ref and s.sale_group='$user_name' and s.sale_date between '$date_start' and '$date_end' ";
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(sale_index) rec_cnt ".$sql, $db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}
	$searchKey=$searchKey."&num_rows=$num_rows";
	$page_start = paging_table_header("order", "list", $num_rows, $zpage, $per_page, $searchKey);
	
	$orders = array();
	if ($num_rows != 0) {
		$sql = "SELECT * ".$sql."order by sale_date desc, sale_index DESC LIMIT $page_start, $per_page";

		$result = mysql_query($sql, $db);
		
		$num_results=mysql_num_rows($result);
//		echo "heoo".$sql;
		//loop
		$prevSaleRef = "";
		$hasReturn = false;
		for ($i=0;$i<$num_results;$i++) {
			$row=mysql_fetch_array($result);
			$sale_ref = $row["sale_ref"];
			$sale_name=$row["sale_name"];
			$sale_ship_fee=$row["sale_ship_fee"];
			$sale_tax=$row["sale_tax"];
			
			$order = array();
			$order['sale_ref'] = $sale_ref;
			$order['sale_date'] = $row["sale_date"];
			$order['sale_dat'] = $row["sale_dat"];
			$order['sale_name'] = $sale_name;
			$order['sale_email'] = $row["sale_email"];
			$order['sale_group'] = $row["sale_group"];
			$order['sale_yahoo_id'] = $row["sale_yahoo_id"];
			$order['sale_ship_fee'] = $sale_ship_fee;
			$order['sale_tax'] = $sale_tax;
			$order['sale_sts'] = $row["sts"];
			$order['sale_prod_id'] = $row["sprod_id"];
			$order['sprod_unit']=$row["sprod_unit"];
			$order['sprod_colour']=$row["sprod_colour"];
			
			// Price
			$order['product_price'] = $row['sprod_price'] * $row['sprod_unit'];
			
			//payment of product
			$cost_prod=getprod_cost($sale_ref);
			
			if ($sale_tax!='0.00') {
				$cost_prod=$cost_prod*(1+$sale_tax/100);
				$cost_prod = number_format(round($cost_prod, 0),2,'.','');
			}
			$order['cost_total'] = number_format($cost_prod+$sale_ship_fee,2,'.','');	
			
			// Note
			$debt_pay_name="";
			$debt_remark="";
			$order['debt_pay_name'] = "";
			$debt_row = getdebt_data($sale_ref);
			if ($debt_row){
				$order['remark']=$debt_row['debt_remark'];
				$order['debt_pay_name'] = $debt_row['debt_pay_name'];
				
				if ($debt_row['debt_email_sent'] == '1')
					$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
				
				if ($debt_row['debt_post_co']!='')
					$debt_pos_co = ", ".$debt_row['debt_post_co']; 
				else
					$debt_pos_co = ''; 
				
				//change sale_name 
				if ($sale_name=='') {
					$debt_name_t='No Name';
				} else {
					$debt_name_t=$sale_name;
				}
				
				$order['debt_data']['debt_name_t'] = $debt_name_t;
				$order['debt_data']['debt_pos_co'] = $debt_pos_co;
				$order['debt_data']['debt_email_sent'] = $debt_email_sent;
			}
			else {
				$order['remark'] = NULL;
				$order['debt_data'] = NULL;
			}
			
			if ($prevSaleRef != $sale_ref) {
				$prevSaleRef = $sale_ref;
				
				// Payment
				$bal_row = getbal_data($sale_ref);
				if ($bal_row){
					$order['bal_data']['bal_pay'] = $bal_row['bal_pay'];
					$order['bal_data']['bal_pay_type'] = $bal_row['bal_pay_type'];
					$order['bal_data']['bal_dat'] = $bal_row['bal_dat'];
				}
				else {
					$order['bal_data'] = NULL;
				}
				
				if ($sale_ref=='bl0907-00084829')
				 
				//return
				$hasReturn = false;
				$order['return_data'] = NULL;
				$return_row = getreturn_data($sale_ref);
				if ($return_row){
					if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
						if ($return_row['return_date'] != NULL){
							$order['return_data']['return_sent'] = "Re-Sent (". $return_row['return_date'] .")";
						}
						else {
							$order['return_data']['return_sent'] = "";
						}
						
						$hasReturn = true;
						$order['return_data']['return_pay'] = $return_row['return_pay'];
					}
				}
			}
			else {
				
				 
				// Order same as previous record => don't display "Shipping", "Total", "Payment" and "Return"
				$order['sale_ship_fee'] = 0;
				$order['cost_total'] = 0;
				
				if ($bal_row){
					 
					$order['bal_data']['bal_pay'] = 0;
					$order['bal_data']['bal_pay_type'] = $bal_row['bal_pay_type'];
					$order['bal_data']['bal_dat'] = $bal_row['bal_dat'];
				}
				else {
					$order['bal_data'] = NULL;
				}
				
				if ($hasReturn){
					// This order has return
					$order['return_data']['return_pay'] = 0;
				}
				else {
					$order['return_data'] = NULL;
				}
			}
			
			// shipping
			$order['ship_print'] = '';
			$order['ship_data'] = NULL;
			$ship_row = getship_data($sale_ref);
			if ($ship_row){
				if ($ship_row['check_print']==1) {
					$ship_print = 'Printed';
					$order['ship_print'] = 'Printed';
				}
				
				if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
					$order['ship_data']['check_shipping'] = $ship_row['check_shipping'];
					$order['ship_data']['check_shipping_jp'] = $ship_row['check_shipping_jp'];
					$order['ship_data']['check_date'] = $ship_row['check_date'];
				}	
			}
			
			//----------------

			$orders[] = $order;
		}
		//end loop
		
		// Free resultset
		mysql_free_result($result);
	}

	// Closing connection
	mysql_close($db);
	
	return $orders;
}

function genCSVByDate($date_start,$date_end,$status,$access,$user_name,$isRetrieveProductId)
{
//	ob_flush();
//	flush();

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$searchKey = "&date_start=".$date_start."&date_end=".$date_end;

	if (!$isRetrieveProductId) {
		if ($access==Admin_name) {
			$sql = "FROM ben_sale left outer join ben_sale_prod on sale_ref = sprod_ref where sale_date between '$date_start' and '$date_end' ";
		}
		else {
			$sql = "FROM ben_sale left outer join ben_sale_prod on sale_ref = sprod_ref where sale_group='$user_name' and sale_date between '$date_start' and '$date_end' ";
		}
	}
	else {
		// For Topnov only
		// Back order -> Retrieve Product ID
		if ($access==Admin_name) {
			$sql = "FROM ben_sale left outer join ben_sale_prod on sale_ref = sprod_ref where sale_date between '$date_start' and '$date_end' ";
		}
		else {
			$sql = "FROM ben_sale left outer join ben_sale_prod on sale_ref = sprod_ref where sale_group='$user_name' and sale_date between '$date_start' and '$date_end' ";
		}
	}
	
	
	if (isset($status)) {
		$sql = $sql." and sts = '$status' ";
	}

	if (!$isRetrieveProductId) {
		$sql = "SELECT * ".$sql."order by sale_date desc, sale_index DESC";
	}
	else {
		// Back order -> Order by Product ID
		$sql = "SELECT * ".$sql."order by sprod_id, sale_date desc, sale_index DESC";
	}

	$result = mysql_query($sql, $db);

	$num_results=mysql_num_rows($result);

	//loop
	$orders = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$sale_ref=$row["sale_ref"];
		$sale_date=$row["sale_date"];
		$sale_dat=$row["sale_dat"];
		$sale_name=$row["sale_name"];
		$sale_email=$row["sale_email"];
		$sale_group=$row["sale_group"];
		$sale_yahoo_id=$row["sale_yahoo_id"];
		$sale_ship_fee=$row["sale_ship_fee"];
		$sale_tax=$row["sale_tax"];
		
		$order['sale_ref']=$sale_ref;
		$order['sale_date']=$sale_date;
		$order['sale_dat']=$sale_dat;
		$order['sale_name']=$sale_name;
		$order['sale_email']=$sale_email;
		$order['sale_group']=$sale_group;
		$order['sale_yahoo_id']=$sale_yahoo_id;
		$order['sale_ship_fee']=$sale_ship_fee;
		$order['sale_tax']=$sale_tax;
		$order['sprod_id'] = $row['sprod_id']; 
		$order['sprod_unit'] = $row['sprod_unit'];
		$order['sprod_colour'] = $row['sprod_colour'];
		
		//payment of product
		$cost_prod=getprod_cost($sale_ref);
			
		if ($sale_tax!='0.00') {
			$cost_prod=$cost_prod*(1+$sale_tax/100);
			$cost_prod = number_format(round($cost_prod, 0),2,'.','');
		}
		$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');
		$order['cost_prod'] = $cost_prod;
		$order['cost_total'] = $cost_total;
			
		//
		$debt_pay_name="";
		$debt_remark="";
		if (getdebt_data($sale_ref)){
			$debt_row = getdebt_data($sale_ref);
			$debt_remark=$debt_row['debt_remark'];
				
			$debt_pay_name=$debt_row['debt_pay_name'];
				
			if ($debt_row['debt_email_sent'] == '1')
			$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
				
			if ($debt_row['debt_post_co']!='')
					$debt_pos_co = ", ".$debt_row['debt_post_co']; 
				else
			$debt_pos_co = '';

			//change sale_name
			if ($sale_name=='') {
				$debt_name_t='No Name';
			} else {
				$debt_name_t=$sale_name;
			}
			$order['debt_data'] =  $debt_name_t.' '.$debt_pos_co.chr(13).chr(10).$debt_email_sent;
		}
		$order['debt_pay_name'] = $debt_pay_name;
		
		//bal
		$bal_row = getbal_data($sale_ref);
		 
			if ($bal_row['bal_pay']!=NULL){
			

			$bal_pay_type = $bal_row['bal_pay_type'];
			$order['bal_data'] = $bal_row['bal_pay'].chr(13).chr(10).$bal_pay_type."(".$bal_row['bal_dat'].") ";
		}
			
			
		// shipping 
		if (getship_data($sale_ref)){
			$ship_row = getship_data($sale_ref);
			if ($ship_row['check_print']==1) {
				$ship_print = 'Printed';
			}

			if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
				$ship_date = "(".$ship_row['check_date'].")";
				$ship_ship = 'Shipped';
				$ship_bg = "bgcolor=\"#CCCCCC\"";
				$check_shipping = trim($ship_row['check_shipping'].' '.$ship_row['check_shipping_jp']);
				$order['ship_data'] = $check_shipping.chr(13).chr(10).$ship_print.' '.$ship_ship.chr(13).chr(10).$ship_date;
			} else {
					$ship_ship ='1';
					$ship_date = '';
					$ship_bg='';
					$order['ship_data'] = $ship_print;
			}

		}
		else {
			$ship_bg='';
			$order['ship_data'] = $ship_print;
		}
				
		//return
		if (getreturn_data($sale_ref)){		
			$return_row = getreturn_data($sale_ref);
			if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
				if ($return_row['return_date'] != NULL){
					$return_sent = "Re-Sent (". $return_row['return_date'] .")";
				}
				else {
					$return_sent = "";
				}
				$order['return_data'] = $return_row['return_pay'].chr(13).chr(10).$return_sent;
			}
			else
			{
				$order['return_data'] = 'No Return';
			}
		}
		else {
			$order['return_data'] = 'No Return';
		}
		
		//----------------
		$order['sale_edit'] = $sale_ref;
		//remark
		
		if ($debt_remark) {
			$remark = $debt_remark;
			$order['remark'] = $remark;
		}
		
		$orders[] = $order;
	}
	//end loop

	// Free resultset
	mysql_free_result($result);

	// Closing connection
	mysql_close($db);
	
	return $orders;
}

function getOrderListByFilter($sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$date_start,$date_end,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m,$total_price,$access,$user_name,$prod_cd,$client_tel,$sts,$nopayment,$check_shipping_jp)
{
	 //echo "getOrderListByFilterFunc";
	 
	 
	$db=connectDatabase();
//echo "min_m".$min_m;

	$searchKey = "&check_shipping_jp=$check_shipping_jp&sale_ref=$sale_ref&sale_name=".urlencode($sale_name)."&sale_email=$sale_email&sale_yahoo_id=$sale_yahoo_id" .
		"&date_start=$date_start&date_end=$date_end&min_m=$min_m&max_m=$max_m" .
		"&debt_cust_address1=$debt_cust_address1&debt_cust_address2=$debt_cust_address2" .
		"&debt_post_co=$debt_post_co&total_m=$total_m&total_price=$total_price&issearch=Search&sts=$sts&prod_cd=$prod_cd&nopayment=$nopayment";

	ob_flush();
	flush();
	
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("set names latin1",$db);
	
	$sql_select = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total ";
	
	
//	echo "access=".$access;
//	echo "<br>";
//	echo "username=".$user_name;
//	echo "<br>";
	if ($access==Admin_name) {
//	echo "access name=admin";
		if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='' or $client_tel!='') {
			$sql = "from ben_sale as s,  ben_debt as d ,ben_sale_prod as s1 
			LEFT JOIN ben_bal ON sprod_ref = bal_ref
			LEFT JOIN ben_check on sprod_ref=check_ref
			where d.debt_ref= s.sale_ref and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
		}
		else {
			$sql = "from ben_sale as s, ben_sale_prod as s1 
			LEFT JOIN ben_bal ON sprod_ref = bal_ref 
			LEFT JOIN ben_check on sprod_ref=check_ref
			where s.sale_ref = s1.sprod_ref and
			sale_date between '$date_start' and '$date_end' ";
		}
	}
	else {
	//echo "access name=user";
		if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='' or $client_tel!='') {
			$sql = "from ben_sale as s, ben_debt as d, ben_sale_prod as s1 
			LEFT JOIN ben_bal ON sprod_ref = bal_ref 
			where s.sale_group='$user_name' and
			d.debt_ref= s.sale_ref and
			s.sale_ref = s1.sprod_ref and
			sale_date between '$date_start' and
			'$date_end' ";
		}
		else {
			$sql = "from ben_sale as s, ben_sale_prod as s1 
			LEFT JOIN ben_bal ON sprod_ref = bal_ref 
			LEFT JOIN ben_check on sprod_ref=check_ref
			where s.sale_group='$user_name' and
			s.sale_ref = s1.sprod_ref and
			sale_date between '$date_start' and '$date_end' ";
		}
	}
	
	//20110721
	if ($sts !=''){ $sql=$sql." and sts='".$sts."'"; }
	
	
	if ($debt_cust_address1 != ''){$sql = $sql."and debt_cust_address1 like '%$debt_cust_address1%' ";}	
	if ($debt_cust_address2 != ''){$sql = $sql."and debt_cust_address2 like '%$debt_cust_address2%' ";}	
	if ($debt_post_co != ''){$sql = $sql."and debt_post_co like '%$debt_post_co%' ";}	
	
	if ($prod_cd!=''){$sql=$sql."and s1.sprod_id like'%$prod_cd%' ";}
	if ($client_tel!=''){$sql=$sql."and debt_tel like'%$client_tel%' ";}
	
	
	if ($sale_ref != ''){$sql = $sql."and sale_ref like '%$sale_ref%' ";}	
	if ($sale_name != ''){$sql = $sql."and sale_name like '%$sale_name%' ";}
	if ($sale_email != ''){$sql = $sql."and sale_email like '%$sale_email%' ";}
	if ($sale_yahoo_id != ''){$sql = $sql."and sale_yahoo_id like '%$sale_yahoo_id%' ";}
	
	if ($check_shipping_jp != ''){$sql = $sql."and check_shipping_jp like '%$check_shipping_jp%' ";}
	
	
	//20180906
	if ($nopayment != ''){$sql = $sql." and ben_bal.bal_pay is null ";}
	
	$sql = $sql."group by sale_ref ";
	if ($min_m  != '' and $max_m!='' ){
		$sql = $sql."having sprod_total >='$min_m' and sprod_total <='$max_m' ";
	}
	else {
		if ($total_m!='' and $total_price==''){$sql = $sql."having sprod_total = '$total_m'"; } 
		if ($total_price!='' and $total_m==''){$sql = $sql."having price_total = '$total_price'"; } 
	}
	
	
   // echo $sql;
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];

	if ($num_rows == '') {
		$query = mysql_query("SELECT sale_ref, sum(sprod_unit*sprod_price) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total ".$sql,$db);
		$num_rows=mysql_num_rows($query);
	}
	$searchKey=$searchKey."&num_rows=$num_rows";
	$page_start = paging_table_header("order", "list", $num_rows, $zpage, $per_page, $searchKey);	

	//table echo
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order date</td><td >Auction ID</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td>product No.</td><td width='60'>Price</td><td width='60'>&#x20;&#x984F;&#x8272;</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td><td>Order status</td></tr>\n";
	
	if ($num_rows > 0) {
		$sql = $sql_select.$sql."order by sale_date desc LIMIT $page_start, $per_page ";
 //echo "getOrderListByFilter".$sql;
		$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results=mysql_num_rows($result);
//	echo "getOrderListByFilter".$num_results;
		//loop
		for ($i=0;$i<$num_results;$i++)
		{
			$row=mysql_fetch_array($result);
			$sale_ref=$row["sale_ref"];
			$sale_date=$row["sale_date"];
			$sale_dat=$row["sale_dat"];
			$sale_name=$row["sale_name"];
			$sale_email=$row["sale_email"];
			$sale_group=$row["sale_group"];
			$sale_yahoo_id=$row["sale_yahoo_id"];
			$sale_ship_fee=$row["sale_ship_fee"];
			$sale_tax=$row["sale_tax"];
			$sts=$row["sts"];
			$sale_prod_id=$row["sprod_id"];
			$sprod_colour = $row['sprod_colour'];
			
			//payment of product
			$cost_prod=getprod_cost($sale_ref);
			
			if ($sale_tax!='0.00') {
				$cost_prod=$cost_prod*$sale_tax/100;
				$cost_prod = number_format(round($cost_prod, 0),2,'.','');
			}
			$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
			

			$debt_pay_name="";
			$debt_remark="";
			if (getdebt_data($sale_ref)){		
				$debt_row = getdebt_data($sale_ref);
				$debt_remark=$debt_row['debt_remark'];
				
				$debt_pay_name=$debt_row['debt_pay_name'];
				
				if ($debt_row['debt_email_sent'] == '1')
					$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";

				if ($debt_row['debt_post_co']!='')
					$debt_pos_co = ", ".$debt_row['debt_post_co']; 
				else
					$debt_pos_co = ''; 
	
				//change sale_name 
				if ($sale_name=='') {
					$debt_name_t='No Name';
				}
				else {
					$debt_name_t=$sale_name;
				}
				$debt_data = "<a href=\"index.php?page=order&subpage=debt&sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
			}
			else {
				$debt_data ="<a href=\"index.php?page=order&subpage=debt&sale_ref=".$sale_ref." \">Fill in</a>";
			}
			//bal
			$bal_row = getbal_data($sale_ref);
			if (is_null($bal_row['bal_pay'])==false){		
			
				
				$bal_pay_type = $bal_row['bal_pay_type'];
				
				$bal_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
			}
			else
			{$bal_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">Fill in</a>";}
			
			
			// shipping 
			
			if (getship_data($sale_ref)){		
				$ship_row = getship_data($sale_ref);
				if ($ship_row['check_print']==1)
					$ship_print = 'Printed';
				
				if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
					$ship_date = "(".$ship_row['check_date'].")";
					$ship_ship = 'Shipped';
					$ship_bg = "bgcolor=\"#CCCCCC\"";
					$ship_data = "<a href=\"index.php?page=order&subpage=shipping&sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";
					
				} else { 
					$ship_ship ='1';
					$ship_date = '';
					$ship_bg='';
					$ship_data ="<a href=\"index.php?page=order&subpage=shipping&sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
				}
				
			}
			else
			{$ship_bg='';
			$ship_data ="<a href=\"index.php?page=order&subpage=shipping&sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}
			
			
			
			//return 
			if (getreturn_data($sale_ref)){		
				$return_row = getreturn_data($sale_ref);
				if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
					if ($return_row['return_date'] != NULL){
						$return_sent = "Re-Sent (". $return_row['return_date'] .")";
					}
					else {
						$return_sent = "";
					}
					$return_data = "<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
				}
				else {
					$return_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">No Return</a>";
				}
				
			}
			else {
				$return_data ="<a href=\"index.php?page=order&subpage=balance&sale_ref=".$sale_ref." \">No Return</a>";
			}
			
			//----------------
			$sale_edit = "<a href=\"index.php?page=order&subpage=edit&sale_ref=".$sale_ref." \">$sale_ref </a>";
			//remark
			if ($debt_remark) {
				$remark = $debt_remark;
				$remark ="<a href=\"index.php?page=order&subpage=remark&sale_ref=".$sale_ref." \">$remark</a>";
			}	
			else {
				$remark ="<a href=\"index.php?page=order&subpage=remark&sale_ref=".$sale_ref." \">Fill in</a>";
			}

			if ($sts=="O") {
				$stsBlink="id='divtoBlink'";
				$sts="OUT";
			} else {
				$stsBlink="";
			}

			echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td>$sale_prod_id</td><td >$cost_prod</td><td>$sprod_colour</td><td>$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td><td><font ".$stsBlink.">".$sts."</font>&nbsp;</td></tr>\n";
		}
		//end loop
		
		// Free resultset
		mysql_free_result($result);
	}
	echo "</table>";
		
	// Closing connection
	mysql_close($db);
}

?>
