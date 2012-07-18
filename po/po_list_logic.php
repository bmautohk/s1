<?php



if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}

if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}



$group2=$_SESSION[group2];

$user_name=$_SESSION[user_name];




if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{
	$po_id=$GLOBALS['po_id'];
	$supp_name=$GLOBALS['supp_name'];
	$supp_email=$GLOBALS['supp_email'];
	$supp_address=$GLOBALS['supp_address'];
	$supp_tel=$GLOBALS['supp_tel'];
	$supp_fax=$GLOBALS['supp_fax'];
	
	$prod_no=$GLOBALS['prod_no'];
	$prod_colour=$GLOBALS['prod_colour'];
	$prod_make=$GLOBALS['prod_make'];
	$prod_model=$GLOBALS['prod_model'];
	$qty=$GLOBALS['qty'];
	
	$min_price=$GLOBALS['min_price'];
	$max_price=$GLOBALS['max_price'];
	$po_date_min=$GLOBALS['po_date_min'];
	$po_date_max=$GLOBALS['po_date_max'];
	$entry_date_min=$GLOBALS['entry_date_min'];
	$entry_date_max=$GLOBALS['entry_date_max'];
}

else {
	$po_id='';
	
	$supp_name='';
	$supp_email='';
	$supp_address='';
	$supp_tel='';
	$supp_fax='';
	
	$prod_no='';
	$prod_colour='';
	$prod_make='';
	$prod_model='';
	$qty='';
	
	$min_price='';
	$max_price='';
	$po_date_min='';
	$po_date_max='';
	$entry_date_min='';
	$entry_date_max='';

}

function getPO_list($csvMode) {
	$po_id=$GLOBALS['po_id'];
	
	$supp_name=$GLOBALS['supp_name'];
	$supp_email=$GLOBALS['supp_email'];
	$supp_address=$GLOBALS['supp_address'];
	$supp_tel=$GLOBALS['supp_tel'];
	$supp_fax=$GLOBALS['supp_fax'];
	
	$prod_no=$GLOBALS['prod_no'];
	$prod_colour=$GLOBALS['prod_colour'];
	$prod_make=$GLOBALS['prod_make'];
	$prod_model=$GLOBALS['prod_model'];
	$qty=$GLOBALS['qty'];
	
	$min_price=$GLOBALS['min_price'];
	$max_price=$GLOBALS['max_price'];
	$po_date_min=$GLOBALS['po_date_min'];
	$po_date_max=$GLOBALS['po_date_max'];
	$entry_date_min=$GLOBALS['entry_date_min'];
	$entry_date_max=$GLOBALS['entry_date_max'];
	
	$searchKey="&issearch=issearch";

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT distinct t1.*, t2.*, t3.prod_on_order, t2.creation_date po_prod_creation_date, t2.created_by po_prod_created_by, t2.id po_prod_id ";
	
	$sql = "FROM po t1 left outer join po_product t2 on (t1.id = t2.po_id) left outer join product t3 on (t2.product_cd = t3.product_id) WHERE t2.sts <> 'X' ";
	if ($po_id != '') { $sql = $sql."AND t1.id = '$po_id' "; $searchKey=$searchKey."&po_id=$po_id";}
	if ($supp_name != '') { $sql = $sql."AND supplier_name like '%$supp_name%' "; $searchKey=$searchKey."&supp_name=$supp_name";}
	if ($supp_email != '') { $sql = $sql."AND supplier_email like '%$supp_email%' "; $searchKey=$searchKey."&supp_email=$supp_email";}
	if ($supp_address != '') { $sql = $sql."AND supplier_address like '%$supp_address%' "; $searchKey=$searchKey."&supp_address=$supp_address";}
	if ($supp_tel != '') { $sql = $sql."AND supplier_tel like '%$supp_tel%' "; $searchKey=$searchKey."&supp_tel=$supp_tel";}
	if ($supp_fax != '') { $sql = $sql."AND supplier_fax like '%$supp_fax%' "; $searchKey=$searchKey."&supp_fax=$supp_fax";}
	
	if ($prod_no != '') { $sql = $sql."AND product_cd like '%$prod_no%' "; $searchKey=$searchKey."&product_cd=$product_cd";}
	if ($prod_colour != '') { $sql = $sql."AND colour like '%$prod_colour%' "; $searchKey=$searchKey."&prod_colour=$prod_colour";}
	if ($prod_make != '') { $sql = $sql."AND make like '%$prod_make%' "; $searchKey=$searchKey."&prod_make=$prod_make";}
	if ($prod_model != '') { $sql = $sql."AND model like '%$prod_model%' "; $searchKey=$searchKey."&prod_model=$prod_model";}
	
	if ($qty != '') { $sql = $sql."AND qty = $qty "; $searchKey=$searchKey."&qty=$qty";}
	if ($min_price != '') { $sql = $sql."AND t2.total >= $min_price "; $searchKey=$searchKey."&min_price=$min_price";}
	if ($max_price != '') { $sql = $sql."AND t2.total <= $max_price "; $searchKey=$searchKey."&max_price=$max_price";}
	
	if ($po_date_min != '') { $sql = $sql."AND po_date >= '$po_date_min' "; $searchKey=$searchKey."&po_date_min=$po_date_min";}
	if ($po_date_max != '') { $sql = $sql."AND po_date < date_add('$po_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&po_date_max=$po_date_max";}
	if ($entry_date_min != '') { $sql = $sql."AND entry_date >= '$entry_date_min' "; $searchKey=$searchKey."&entry_date_min=$entry_date_min";}
	if ($entry_date_max != '') { $sql = $sql."AND entry_date < date_add('$entry_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&entry_date_max=$entry_date_max";}
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($csvMode == 'N') {
		if ($num_rows == '') {
			$query = mysql_query("SELECT count(distinct t2.id) rec_cnt ".$sql,$db);
			$row=mysql_fetch_array($query);
			$num_rows=$row['rec_cnt'];
		}
	
		$searchKey=$searchKey."&num_rows=$num_rows";
		$page_start = paging_table_header("po", "list", $num_rows, $zpage, $per_page, $searchKey);
	}
	
	$sql = $sql."ORDER BY po_date desc ";

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
/*	echo "<tr align=\"right\" valign=\"top\"><td>PO ID</td><td>Invoice ID</td><td>PO Date</td><td>Entry Date</td><td>Staff Name</td><td>Supplier Name</td><td>Supplier Address</td><td>Tel</td><td>Fax</td><td>Email</td><td>Total</td><td>Ship Ref No</td><td>Ship Batch No</td><td>Delivery Date</td><td>Landing Date</td><td>PO Status</td><td>Warehouse</td><td>Factory Staff Name</td><td>Complete Date</td><td>Created By</td><td>Creation Date</td></tr>\n";*/
	
	echo "<tr align=\"right\" valign=\"top\"><td>PO ID</td><td>Factory Staff Name</td><td>Staff Name</td><td>Supplier Name</td><td>Product</td><td>Desc.</td><td>Make</td><td>Model</td><td>Colour</td><td>Col. No.</td><td>Pcs/Set</td><td>Qty.</td><td>Prod Total Price</td><td>Remark</td><td>受注生産</td><td>Ordered?</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$po_id=$row["po_id"];
		$po_prod_id=$row["po_prod_id"];
		
		$invoice_id=$row["invoice_id"];
		if ($invoice_id == 0) {
			$invoice_id = '';
		}
		
		$factory_staff_name=$row["factory_staff_name"];
		$staff_name=$row["staff_name"];
		$supplier_name=$row["supplier_name"];
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$make=$row["make"];
		$model=$row["model"];
		$colour=$row["colour"];
		$colour_no=$row["color_no"];
		$pcs_set=$row["pcs_set"];
		$qty=$row["qty"];
		$total=$row["total"];
		$remark=$row["remark"];
		$prod_on_order=$row["prod_on_order"];
/*		
		$po_date=$row["po_date"];
		$entry_date=$row["entry_date"];

		$supplier_address=$row["supplier_address"];
		$supplier_tel=$row["supplier_tel"];
		$supplier_fax=$row["supplier_fax"];
		$supplier_email=$row["supplier_email"];
		$subtotal=$row["subtotal"];
		$ship_ref_no=$row["ship_ref_no"];
		$ship_batch_no=$row["ship_batch_no"];
		
		$delivery_date=$row["delivery_date"];
		$landing_date=$row["landing_date"];
		$warehouse=$row["warehouse"];
		$close_po_flag=$row["close_po_flag"];
		
		$po_complete_date=$row["po_complete_date"];
		$created_by=$row["po_prod_created_by"];
		$creation_date=$row["po_prod_creation_date"];
		
		$unit_price=$row["unit_price"];
		$currency_cd=$row["currency_cd"];
*/
		

/*		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=po&subpage=edit&po_id=$po_id\">$po_id</td><td>$invoice_id&nbsp;</td><td>$po_date</td><td>$entry_date</td><td>$staff_name&nbsp;</td><td>$supplier_name&nbsp;</td><td>$supplier_address&nbsp;</td><td>$supplier_tel&nbsp;</td><td>$supplier_fax&nbsp;</td><td>$supplier_email&nbsp;</td><td>$subtotal</td><td>$ship_ref_no&nbsp;</td><td>$ship_batch_no&nbsp;</td><td>$delivery_date&nbsp;</td><td>$landing_date&nbsp;</td><td>$close_po_flag&nbsp;</td><td>$warehouse&nbsp;</td><td><a href=\"index.php?page=po&subpage=edit_by_factory&po_id=$po_id\">$factory_staff_name&nbsp;</td><td>$po_complete_date&nbsp;</td><td>$created_by</td><td>$creation_date</td></tr>";*/
		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=po&subpage=edit&po_id=$po_id\">$po_id</td>" .
				"<td><a href=\"index.php?page=po&subpage=edit_by_factory&po_id=$po_id\">$factory_staff_name&nbsp;</td><td>$staff_name&nbsp;</td><td>$supplier_name&nbsp;</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$make&nbsp;</td><td>$model&nbsp;</td><td>$colour&nbsp;</td><td>$colour_no&nbsp;</td><td>$pcs_set&nbsp;</td><td>$qty&nbsp;</td><td>$total&nbsp;</td><td>$remark&nbsp;</td><td>$prod_on_order&nbsp;</td>";
		
		if ($row["ordered"] == 'Y') {
			echo "<td>Y</td>";
		}
		else {
			echo "<td><input type=\"button\" name=\"ordered$i\" id=\"ordered$i\" value=\"Submit\" onclick=\"updPOProdOrder($i, $po_prod_id)\"/></td>";
		}
		echo "</tr>\n";
	}

	echo "</table>";
}

function getCSV($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";	
	echo "<tr align=\"right\" valign=\"top\"><td>PO ID</td><td>Factory Staff Name</td><td>Staff Name</td><td>Supplier Name</td><td>Product</td><td>Desc.</td><td>Make</td><td>Model</td><td>Colour</td><td>Col. No.</td><td>Pcs/Set</td><td>Qty.</td><td>Prod Total Price</td><td>Remark</td><td>受注生産</td><td>Ordered?</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$po_id=$row["po_id"];
		$po_prod_id=$row["po_prod_id"];
		
		$invoice_id=$row["invoice_id"];
		if ($invoice_id == 0) {
			$invoice_id = '';
		}
		
		$factory_staff_name=$row["factory_staff_name"];
		$staff_name=$row["staff_name"];
		$supplier_name=$row["supplier_name"];
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$make=$row["make"];
		$model=$row["model"];
		$colour=$row["colour"];
		$colour_no=$row["color_no"];
		$pcs_set=$row["pcs_set"];
		$qty=$row["qty"];
		$total=$row["total"];
		$remark=$row["remark"];
		$prod_on_order=$row["prod_on_order"];

		echo "<tr align=\"right\" valign=\"top\"><td>$po_id</td><td>$factory_staff_name&nbsp;</td><td>$staff_name&nbsp;</td><td>$supplier_name&nbsp;</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$make&nbsp;</td><td>$model&nbsp;</td><td>$colour&nbsp;</td><td>$colour_no&nbsp;</td><td>$pcs_set&nbsp;</td><td>$qty&nbsp;</td><td>$total&nbsp;</td><td>$remark&nbsp;</td><td>$prod_on_order&nbsp;</td>";
		
		if ($row["ordered"] == 'Y') {
			echo "<td>Y</td>";
		}
		else {
			echo "<td>N</td>";
		}
		echo "</tr>\n";
	}

	echo "</table>";
}

?>