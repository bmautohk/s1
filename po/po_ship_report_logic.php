<?php

if ($_GET['uname']!='') {$_SESSION[user_name]=$_GET['uname'];}

if ($_GET['g2']!='') {$_SESSION[group2]=$_GET['g2'];}

$group2=$_SESSION[group2];

$user_name=$_SESSION[user_name];

if (isset($GLOBALS['issearch']) || isset($GLOBALS['genCSV']))
{ 
	$po_no=$GLOBALS['po_no'];
	$shipping_batch=$GLOBALS['shipping_batch'];
	$del_date_min=$GLOBALS['del_date_min'];
	$del_date_max=$GLOBALS['del_date_max'];
	$comp_date_min=$GLOBALS['comp_date_min'];
	$comp_date_max=$GLOBALS['comp_date_max'];
}

else {
	$po_no='';
	$shipping_batch='';
	$del_date_min='';
	$del_date_max='';
	$comp_date_min='';
	$comp_date_max='';
}

function getPO_list($csvMode) {
	$po_no=$GLOBALS['po_no'];
	$shipping_batch=$GLOBALS['shipping_batch'];
	$del_date_min=$GLOBALS['del_date_min'];
	$del_date_max=$GLOBALS['del_date_max'];
	$comp_date_min=$GLOBALS['comp_date_min'];
	$comp_date_max=$GLOBALS['comp_date_max'];

	$searchKey="&issearch=issearch";

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_select = "SELECT * ";
	
	$sql = "FROM po t1 WHERE 1 = 1 ";
	if ($po_no != '') { $sql = $sql."AND id = '$po_no' "; $searchKey=$searchKey."&po_no=$po_no";}
	
	if ($shipping_batch != '') { $sql = $sql."AND ship_batch_no like '%$shipping_batch%' "; $searchKey=$searchKey."&shipping_batch=$shipping_batch";}
	
	if ($del_date_min != '') { $sql = $sql."AND delivery_date >= '$del_date_min' "; $searchKey=$searchKey."&del_date_min=$del_date_min";}
	if ($del_date_max != '') { $sql = $sql."AND delivery_date < date_add('$del_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&del_date_max=$del_date_max";}
	if ($comp_date_min != '') { $sql = $sql."AND po_complete_date >= '$comp_date_min' "; $searchKey=$searchKey."&comp_date_min=$comp_date_min";}
	if ($comp_date_max != '') { $sql = $sql."AND po_complete_date < date_add('$comp_date_max', INTERVAL  1 day) "; $searchKey=$searchKey."&comp_date_max=$comp_date_max";}
	
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
		$page_start = paging_table_header("po", "ship_report", $num_rows, $zpage, $per_page, $searchKey);
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
	echo "<tr align=\"right\" valign=\"top\"><td>PO ID</td><td>PO Date</td><td>Shipping Ref No</td><td>Shipping Batch No</td><td>Delivery Date</td><td>Target Landing Date</td><td>Ware House</td><td>Completion date</td><td>Close PO Flag</td><td>Staff Code</td><td>Staff Name</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$po_id=$row["id"];
		
		$po_date=$row["po_date"];
		$ship_ref_no=$row["ship_ref_no"];
		$ship_batch_no=$row["ship_batch_no"];
		$delivery_date=$row["delivery_date"];
		$landing_date=$row["landing_date"];
		$warehouse=$row["warehouse"];
		$po_complete_date=$row["po_complete_date"];
		$close_po_flag=$row["close_po_flag"];
		$factory_staff_name=$row["factory_staff_name"];
		$factory_staff_cd=$row["factory_staff_cd"];

		echo "<tr align=\"right\" valign=\"top\"><td><a href=\"index.php?page=po&subpage=edit_by_factory&po_id=$po_id\">$po_id</td><td>$po_date&nbsp;</td><td>$ship_ref_no&nbsp;</td><td>$ship_batch_no&nbsp;</td><td>$delivery_date&nbsp;</td><td>$landing_date&nbsp;</td><td>$warehouse&nbsp;</td><td>$po_complete_date&nbsp;</td><td>$close_po_flag&nbsp;</td><td>$factory_staff_name&nbsp;</td><td>$factory_staff_cd&nbsp;</td></tr>\n";
	}

	echo "</table>";
}

function getCSV($result, $num_results) {
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td>PO ID</td><td>PO Date</td><td>Shipping Ref No</td><td>Shipping Batch No</td><td>Delivery Date</td><td>Target Landing Date</td><td>Ware House</td><td>Completion date</td><td>Close PO Flag</td><td>Staff Code</td><td>Staff Name</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$po_id=$row["id"];
		
		$po_date=$row["po_date"];
		$ship_ref_no=$row["ship_ref_no"];
		$ship_batch_no=$row["ship_batch_no"];
		$delivery_date=$row["delivery_date"];
		$landing_date=$row["landing_date"];
		$warehouse=$row["warehouse"];
		$po_complete_date=$row["po_complete_date"];
		$close_po_flag=$row["close_po_flag"];
		$factory_staff_name=$row["factory_staff_name"];
		$factory_staff_cd=$row["factory_staff_cd"];

		echo "<tr align=\"right\" valign=\"top\"><td>$po_id</td><td>$po_date&nbsp;</td><td>$ship_ref_no&nbsp;</td><td>$ship_batch_no&nbsp;</td><td>$delivery_date&nbsp;</td><td>$landing_date&nbsp;</td><td>$warehouse&nbsp;</td><td>$po_complete_date&nbsp;</td><td>$close_po_flag&nbsp;</td><td>$factory_staff_name&nbsp;</td><td>$factory_staff_cd&nbsp;</td></tr>\n";
	}

	echo "</table>";
}

?>