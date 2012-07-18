<?php

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}

if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}

$group2=$_SESSION[group2];

$user_name=$_SESSION[user_name];

if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{
	$return_id=$GLOBALS['return_id'];
	
	$prod_no=$GLOBALS['prod_no'];
	
	$prod_colour=$GLOBALS['prod_colour'];
	
	$prod_make=$GLOBALS['prod_make'];
	
	$prod_model=$GLOBALS['prod_model'];
	
	$qty=$GLOBALS['qty'];
	
	$min_price=$GLOBALS['min_price'];
	
	$max_price=$GLOBALS['max_price'];
	
	$invoice_date_min=$GLOBALS['invoice_date_min'];
	
	$invoice_date_max=$GLOBALS['invoice_date_max'];
	
	$entry_date_min=$GLOBALS['entry_date_min'];
	
	$entry_date_max=$GLOBALS['entry_date_max'];
	
}
else {
	$return_id='';
	
	$prod_no='';
	
	$prod_colour='';
	
	$prod_make='';
	
	$prod_model='';
	
	$qty='';
	
	$min_price='';
	
	$max_price='';
	
	$invoice_date_min='';
	
	$invoice_date_max='';
	
	$entry_date_min='';
	
	$entry_date_max='';
}

function get_return_list($csvMode) {
	$return_id=$GLOBALS['return_id'];
	$prod_no=$GLOBALS['prod_no'];
	$prod_colour=$GLOBALS['prod_colour'];
	$prod_make=$GLOBALS['prod_make'];
	$prod_model=$GLOBALS['prod_model'];
	$qty=$GLOBALS['qty'];
	$min_price=$GLOBALS['min_price'];
	$max_price=$GLOBALS['max_price'];
	$return_date_min=$GLOBALS['return_date_min'];
	$return_date_max=$GLOBALS['return_date_max'];
	$entry_date_min=$GLOBALS['entry_date_min'];
	$entry_date_max=$GLOBALS['entry_date_max'];
	
	$searchKey="&issearch=issearch";
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT t1.id inv_id, t1.*, t2.* ";
	
	$sql = "FROM `return` t1 left outer join return_product t2 on (t1.id = t2.return_id) WHERE (t2.sts is null or t2.sts <> 'X') ";
	if ($return_id != '') { $sql = $sql."AND t1.id = '$return_id' "; $searchKey=$searchKey."&return_id=$return_id";}
	if ($prod_no != '') { $sql = $sql."AND product_cd like '%$prod_no%' "; $searchKey=$searchKey."&prod_no=$prod_no";}
	if ($prod_colour != '') { $sql = $sql."AND colour like '%$prod_colour%' "; $searchKey=$searchKey."&prod_colour=$prod_colour";}
	if ($prod_make != '') { $sql = $sql."AND make like '%$prod_make%' "; $searchKey=$searchKey."&prod_make=$prod_make";}
	if ($prod_model != '') { $sql = $sql."AND model like '%$prod_model%' "; $searchKey=$searchKey."&prod_model=$prod_model";}
	
	if ($min_price != '') { $sql = $sql."AND subtotal >= $min_price "; $searchKey=$searchKey."&min_price=$min_price";}
	if ($max_price != '') { $sql = $sql."AND subtotal <= $max_price "; $searchKey=$searchKey."&max_price=$max_price";}
	
	if ($qty != '') { $sql = $sql."AND qty = $qty "; $searchKey=$searchKey."&qty=$qty";}
	if ($return_date_min != '') { $sql = $sql."AND return_date >= '$return_date_min' "; $searchKey=$searchKey."&return_date_min=$return_date_min";}
	if ($return_date_max != '') { $sql = $sql."AND return_date < date_add('$return_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&return_date_max=$return_date_max";}
	if ($entry_date_min != '') { $sql = $sql."AND entry_date >= '$entry_date_min' "; $searchKey=$searchKey."&entry_date_min=$entry_date_min";}
	if ($entry_date_max != '') { $sql = $sql."AND entry_date < date_add('$entry_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&entry_date_max=$entry_date_max";}
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($csvMode == 'N') {
		if ($num_rows == '') {
			$query = mysql_query("SELECT count(*) rec_cnt ".$sql,$db);
			$row=mysql_fetch_array($query);
			$num_rows=$row['rec_cnt'];
		}
		$searchKey=$searchKey."&num_rows=$num_rows";
		
		$page_start = paging_table_header("return", "list", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY t1.return_date desc ";
	
	if ($csvMode == 'N') {
		$sql = $sql."LIMIT $page_start, $per_page";
	}
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	if ($csvMode == 'N') {
		getList($result, $num_results);
	}
	else {
		getCSV($result, $num_results);
	}
	
}

function getList($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Return ID</td><td>Return Date</td><td>Entry Date</td><td>Return Status</td><td>Total</td><td>Product Code</td><td>Product Name</td><td >Remark</td><td>Qty</td><td>Unit Price</td><td>Prod Total</td><td>Currency Code</td><td>Colour</td><td>PCS</td><td>Make</td><td >Model</td><td>Colour No</td><td>Created By</td><td>Creation Date</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$return_id=$row["return_id"];
		
		$return_date=$row["return_date"];
		$entry_date=$row["entry_date"];
		$sales_name=$row["sales_name"];
		$return_status=$row["return_status"];
		$subtotal=$row["subtotal"];
		
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$remark=$row["remark"];
		$qty=$row["qty"];
		$unit_price=$row["unit_price"];
		$total=$row["total"];
		$currency_cd=$row["currency_cd"];
		$colour=$row["colour"];
		$pcs_set=$row["pcs_set"];
		$make=$row["make"];
		$model=$row["model"];
		$colour_no=$row["color_no"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=return&subpage=edit&return_id=$return_id\">$return_id</td><td>$return_date</td><td>$entry_date</td><td>$return_status</td><td>$subtotal</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$remark&nbsp;</td><td>$qty&nbsp;</td><td>$unit_price&nbsp;</td><td>$total&nbsp;</td><td>$currency_cd&nbsp;</td><td>$colour&nbsp;</td><td>$pcs_set&nbsp;</td><td>$make&nbsp;</td><td>$model&nbsp;</td><td>$colour_no&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>";
	}

	echo "</table>";
}

function getCSV($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Return ID</td><td>Return Date</td><td>Entry Date</td><td>Return Status</td><td>Total</td><td>Product Code</td><td>Product Name</td><td >Remark</td><td>Qty</td><td>Unit Price</td><td>Prod Total</td><td>Currency Code</td><td>Colour</td><td>PCS</td><td>Make</td><td >Model</td><td>Colour No</td><td>Created By</td><td>Creation Date</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$return_id=$row["return_id"];
		
		$return_date=$row["return_date"];
		$entry_date=$row["entry_date"];
		$sales_name=$row["sales_name"];
		$return_status=$row["return_status"];
		$subtotal=$row["subtotal"];
		
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$remark=$row["remark"];
		$qty=$row["qty"];
		$unit_price=$row["unit_price"];
		$total=$row["total"];
		$currency_cd=$row["currency_cd"];
		$colour=$row["colour"];
		$pcs_set=$row["pcs_set"];
		$make=$row["make"];
		$model=$row["model"];
		$colour_no=$row["color_no"];
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		echo "<tr align=\"right\" valign=\"top\"><td>$return_id</td><td>$return_date</td><td>$entry_date</td><td>$return_status</td><td>$subtotal</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$remark&nbsp;</td><td>$qty&nbsp;</td><td>$unit_price&nbsp;</td><td>$total&nbsp;</td><td>$currency_cd&nbsp;</td><td>$colour&nbsp;</td><td>$pcs_set&nbsp;</td><td>$make&nbsp;</td><td>$model&nbsp;</td><td>$colour_no&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>";
	}

	echo "</table>";
}

?>
