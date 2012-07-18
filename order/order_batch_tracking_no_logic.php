<?

if (isset($_POST['isSubmit'])) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$trackingList = $_POST['tracking_no'];
	
	$trackingNos = preg_split('/\r\n/', $trackingList); // Split by carrier return
	
	$successList = array();
	$failList = array();
	foreach ($trackingNos as $trackingNo) {
		$trackingNo = trim($trackingNo);
		
		if ($trackingNo == '') {
			// Skip
			continue;
		}
		
		$sql = "SELECT sale_date, check_ref, check_date FROM ben_sale join ben_check on sale_ref = check_ref WHERE check_shipping = '$trackingNo' order by sale_date desc ";
		$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results = mysql_num_rows($result);
		
		if ($num_results > 0) {
			$row = mysql_fetch_array($result);
			
			$checkDate = $row['check_date'];
			if ($checkDate == '' || $checkDate == '0000-00-00') {
				$order['check_ref'] = $row['check_ref'];
				$order['check_shipping'] = $trackingNo;
				$successList[] = $order;
					
				$sqla = "Update ben_check SET
				check_date= curdate(),
				check_dat = curdate() where check_ref= '".$order['check_ref']."'";
					
				sqlinsert($sqla);
			}
			else {
				// Order has already been shipped
				$order['check_shipping'] = $trackingNo;
				$order['reason'] = 'Order ['.$row['check_ref'].'] has already been shipped';
				$failList[] = $order;
			}
		}
		else {
			$order['check_shipping'] = $trackingNo;
			$order['reason'] = 'Missing Order';
			$failList[] = $order;
		}
		mysql_free_result($result);
	}
	
	mysql_close($db);
}

?>