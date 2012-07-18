<?php

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}

if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}

$group2=$_SESSION[group2];

$user_name=$_SESSION[user_name];

if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{
	$invoice_id=$GLOBALS['invoice_id'];
	
	$cust_name=$GLOBALS['cust_name'];
	
	$cust_email=$GLOBALS['cust_email'];
	
	$cust_address=$GLOBALS['cust_address'];
	
	$cust_tel=$GLOBALS['cust_tel'];
	
	$cust_fax=$GLOBALS['cust_fax'];
	
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
	$invoice_id='';

	$cust_name='';
	
	$cust_email='';
	
	$cust_address='';
	
	$cust_tel='';
	
	$cust_fax='';
	
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

function getInvoice_list($csvMode) {
	$invoice_id=$GLOBALS['invoice_id'];
	$cust_name=$GLOBALS['cust_name'];
	$cust_email=$GLOBALS['cust_email'];
	$cust_address=$GLOBALS['cust_address'];
	$cust_tel=$GLOBALS['cust_tel'];
	$cust_fax=$GLOBALS['cust_fax'];
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
	
	$paging = true;
	$searchKey="&issearch=issearch";
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT * ";
	
	$sql = "FROM invoice t1 left outer join invoice_product t2 on (t1.id = t2.invoice_id) WHERE (t2.sts is null or t2.sts <> 'X') ";
	if ($invoice_id != '') { $sql = $sql."AND t1.id = '$invoice_id' "; $searchKey=$searchKey."&invoice_id=$invoice_id";}
	if ($cust_name != '') { $sql = $sql."AND cust_name like '%$cust_name%' "; $searchKey=$searchKey."&cust_name=$name_name";}
	if ($cust_email != '') { $sql = $sql."AND cust_email like '%$cust_email%' "; $searchKey=$searchKey."&cust_email=$cust_email";}
	if ($cust_address != '') { $sql = $sql."AND cust_address like '%$cust_address%' "; $searchKey=$searchKey."&cust_address=$cust_address";}
	if ($cust_tel != '') { $sql = $sql."AND cust_tel like '%$cust_tel%' "; $searchKey=$searchKey."&cust_tel=$cust_tel";}
	if ($cust_fax != '') { $sql = $sql."AND cust_fax like '%$cust_fax%' "; $searchKey=$searchKey."&cust_fax=$cust_fax";}
	
	if ($prod_no != '') { $sql = $sql."AND product_cd like '%$prod_no%' "; $searchKey=$searchKey."&product_cd=$product_cd";}
	if ($prod_colour != '') { $sql = $sql."AND colour like '%$prod_colour%' "; $searchKey=$searchKey."&prod_colour=$prod_colour";}
	if ($prod_make != '') { $sql = $sql."AND make like '%$prod_make%' "; $searchKey=$searchKey."&prod_make=$prod_make";}
	if ($prod_model != '') { $sql = $sql."AND model like '%$prod_model%' "; $searchKey=$searchKey."&prod_model=$prod_model";}
	
	if ($min_price != '') { $sql = $sql."AND subtotal >= $min_price "; $searchKey=$searchKey."&min_price=$min_price";}
	if ($max_price != '') { $sql = $sql."AND subtotal <= $max_price "; $searchKey=$searchKey."&max_price=$max_price";}
	
	if ($qty != '') { $sql = $sql."AND qty = $qty "; $searchKey=$searchKey."&qty=$qty";}
	if ($invoice_date_min != '') { $sql = $sql."AND invoice_date >= '$invoice_date_min' "; $searchKey=$searchKey."&invoice_date_min=$invoice_date_min"; $paging=false;}
	if ($invoice_date_max != '') { $sql = $sql."AND invoice_date < date_add('$invoice_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&invoice_date_max=$invoice_date_max"; $paging=false;}
	if ($entry_date_min != '') { $sql = $sql."AND entry_date >= '$entry_date_min' "; $searchKey=$searchKey."&entry_date_min=$entry_date_min"; $paging=false;}
	if ($entry_date_max != '') { $sql = $sql."AND entry_date < date_add('$entry_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&entry_date_max=$entry_date_max"; $paging=false;}
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	
	if ($csvMode == 'N' && $paging) {
		if ($num_rows == '') {
			$query = mysql_query("SELECT count(t2.id) rec_cnt ".$sql,$db);
			$row=mysql_fetch_array($query);
			$num_rows=$row['rec_cnt'];
		}
		$searchKey=$searchKey."&num_rows=$num_rows";
		$page_start = paging_table_header("invoice", "list", $num_rows, $zpage, $per_page, $searchKey);	
	}

// -------------- Paging ------------------------------------------------------------------
/*	$page="invoice";
	$subpage="list";
	$zpage=$GLOBALS['zpage'];
	$per_page = 5; 
	
	if (!$zpage) { 
		$zpage = 1; 
	} 
	$prev_page = $zpage - 1; 
	$next_page = $zpage + 1; 

	$query = mysql_query($sql,$db);
	// Set up specified page 
	$page_start = ($per_page * $zpage) - $per_page; 
	$num_rows = mysql_num_rows($query); 
	if ($num_rows <= $per_page) { 
		$num_pages = 1; 
	} else if (($num_rows % $per_page) == 0) { 
		$num_pages = ($num_rows / $per_page); 
	} else { 
		$num_pages = ($num_rows / $per_page) + 1; 
	} 
	$num_pages = (int) $num_pages; 
	if (($zpage > $num_pages) || ($zpage < 0)) { 
		error("You have specified an invalid page number");
	}
	
	echo "<div align=\"center\">Page";
	// 
    // Now the pages are set right, we can 
    // perform the actual displaying... 
    if ($prev_page) {
    	echo "<a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$prev_page".$searchKey."\">Prev</a>";
    }
    // Page # direct links 
    // If you don't want direct links to eac
    //     h page, you should be able to
    // safely remove this chunk.
    for ($i = 1; $i <= $num_pages; $i++) { 
		if ($i != $zpage) {
			echo " <a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$i".$searchKey."\">$i</a> "; 
		} else { 
			echo " $i "; 
		}
    }
    // Next 
    if ($zpage != $num_pages) { 
    	echo "<a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$next_page".$searchKey."\">Next</a> ";
    }
	echo "</div>";*/
// -------------------------------------------------------------------------------------
	
	$sql = $sql."ORDER BY t1.invoice_date desc ";

	if ($csvMode == 'N' && $paging) {
		$sql = $sql."LIMIT $page_start, $per_page";
	}
	
	$sql = $sql_select.$sql;
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\">
		<td>Invoice ID</td>
		<td>Auto PO ID</td>
		<td>Invoice Date</td>
		<td>Entry Date</td>
		<td>Sales Name</td>
		<td>Cust Name</td>
		<td>Product ID</td>
		<td>Product Name</td>
		<td>Prod Total</td>
		<td>Inv Remark</td>
		<td>Invoice Status</td>
		<td>Payment?</td>
		<td>Created By</td><td>Creation Date</td></tr>\n";
//	echo "<tr align=\"right\" valign=\"top\"><td >Invoice ID</td><td>Auto PO ID</td><td>Invoice Date</td><td>Entry Date</td><td>Sales Name</td><td>Cust Name</td><td>Cust Address</td><td>Tel</td><td>Fax</td><td>Email</td><td>Invoice Status</td><td>Auto PO?</td><td>Total</td></tr>\n";
	
	if ($csvMode == 'N') {
		getList($result, $num_results);
	}
	else {
		getCSV($result, $num_results);
	}
	echo "</table>";
}

function getList($result, $num_results) {
	//loop
	$sum = 0;
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$invoice_id=$row["invoice_id"];
		
		$invoice_date=$row["invoice_date"];
		$entry_date=$row["entry_date"];
		$sales_name=$row["sales_name"];
		$cust_name=$row["cust_name"];
		$invoice_status=$row["invoice_status"];
		$paymet=$row["payment"];
		$inv_remarks=$row["remarks"];
		
		$po_id = $row["po_id"]; if ($po_id == 0) $po_id = '';
		
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$total=$row["total"];
		
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$sum += $total;
		
/*		$cust_address=$row["cust_address"];
		$cust_tel=$row["cust_tel"];
		$cust_fax=$row["cust_fax"];
		$cust_email=$row["cust_email"];
		$subtotal=$row["subtotal"];
		$auto_po_flag=$row["auto_po_flag"];
		
		$currency_cd=$row["currency_cd"];
		$remark=$row["remark"];
		$colour=$row["colour"];
		$pcs_set=$row["pcs_set"];
		$make=$row["make"];
		$model=$row["model"];
		$colour_no=$row["color_no"];
		$qty=$row["qty"];
		$unit_price=$row["unit_price"];*/
		
		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=invoice&subpage=edit&invoice_id=$invoice_id\">$invoice_id</td><td>$po_id&nbsp;</td><td>$invoice_date</td><td>$entry_date</td><td>$sales_name</td><td>$cust_name</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$total</td><td>$inv_remarks&nbsp;</td><td>$invoice_status</td><td>$paymet&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>\n";
//		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=invoice&subpage=edit&invoice_id=$invoice_id\">$invoice_id</td><td>$po_id&nbsp;</td><td>$invoice_date</td><td>$entry_date</td><td>$sales_name</td><td>$cust_name</td><td>$cust_address&nbsp;</td><td>$cust_tel&nbsp;</td><td>$cust_fax&nbsp;</td><td>$cust_email&nbsp;</td><td>$invoice_status</td><td>$auto_po_flag</td><td>$subtotal</td></tr>";
	}
	echo "<tr><td align=right colspan=8>Total:</td><td align=right>$sum</td>\n";
}

function getCSV($result, $num_results) {
	
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$invoice_id=$row["invoice_id"];
		
		$invoice_date=$row["invoice_date"];
		$entry_date=$row["entry_date"];
		$sales_name=$row["sales_name"];
		$cust_name=$row["cust_name"];
		$invoice_status=$row["invoice_status"];
		$paymet=$row["payment"];
		$inv_remarks=$row["remarks"];
		
		$po_id = $row["po_id"]; if ($po_id == 0) $po_id = '';
		
		$product_cd=$row["product_cd"];
		$product_name=$row["product_name"];
		$total=$row["total"];
		
		$created_by=$row["created_by"];
		$creation_date=$row["creation_date"];
		
		$sum += $total;
		
		//echo "<tr align=\"right\" valign=\"top\"><td>$invoice_id</td><td>$invoice_date</td><td>$entry_date</td><td>$sales_name</td><td>$cust_name</td><td>$cust_address&nbsp;</td><td>$cust_tel&nbsp;</td><td>$cust_fax&nbsp;</td><td>$cust_email&nbsp;</td><td>$invoice_status</td><td>$auto_po_flag</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$remark&nbsp;</td><td>$qty&nbsp;</td><td>$unit_price&nbsp;</td><td>$total</td><td>$colour&nbsp;</td><td>$pcs_set&nbsp;</td><td>$make&nbsp;</td><td>$model&nbsp;</td><td>$colour_no&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>\n";
		echo "<tr align=\"right\" valign=\"top\"><td>$invoice_id</td><td>$po_id&nbsp;</td><td>$invoice_date</td><td>$entry_date</td><td>$sales_name</td><td>$cust_name</td><td>$product_cd&nbsp;</td><td>$product_name&nbsp;</td><td>$total</td><td>$inv_remarks&nbsp;</td><td>$invoice_status</td><td>$paymet&nbsp;</td><td>$created_by&nbsp;</td><td>$creation_date&nbsp;</td></tr>\n";
	}
}
?>