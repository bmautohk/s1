<?
if (isset($_GET['sale_ref']) and getship_data($_GET['sale_ref']))
{
	$sale_ref=$_GET['sale_ref'];
	$row = getship_data($sale_ref);
	$check_shipping=$row['check_shipping'];
	$check_shipping_jp=$row['check_shipping_jp'];
	$check_print=$row['check_print'];
	$check_date=$row['check_date'];
}

else{
	$check_shipping='';
	$check_shipping_jp='';
	$check_print='';
	$check_date='';
}

$address_list = getAddress();
$userAddrId = getUserDefaultAddrId();

if (isset($_GET['sale_ref']))
{$sale_ref=$_GET['sale_ref'];}

if (isset($_POST['isupdate']) || isset($_POST['isupdate2']))
{
	if (!getship_data($sale_ref)) {
	
		$sqla = "INSERT INTO ben_check SET
		check_ref='".$sale_ref."',
		check_shipping='".$_POST['check_shipping']."',
		check_shipping_jp='".$_POST['check_shipping_jp']."',
		check_print='".$_POST['check_print']."',
		check_dat = curdate()";
				 
		sqlinsert($sqla);
		$row = getship_data($sale_ref);
		$check_shipping=$row['check_shipping'];
		$check_shipping_jp=$row['check_shipping_jp'];
		$check_print=$row['check_print'];
		$check_date=$row['check_date'];
	}
	else 
	{
		//update debt note
		
		$sqla = "Update ben_check SET
		check_shipping='".$_POST['check_shipping']."',
		check_shipping_jp='".$_POST['check_shipping_jp']."',
		check_print='".$_POST['check_print']."',
		check_date='".$_POST['check_date']."',
		check_dat = curdate() where check_ref= '".$sale_ref."'";
		
		sqlinsert($sqla);
		$row = getship_data($sale_ref);
		$check_shipping=$row['check_shipping'];
		$check_shipping_jp=$row['check_shipping_jp'];
		$check_print=$row['check_print'];
		$check_date=$row['check_date'];
		
		
		$check = "update";
	}
	
	if ($check_shipping!=''){
			//update ben_sale sts='A' 20180526
				$sql = "update ben_sale set sts='A' where sale_ref='$sale_ref'";
				sqlinsert($sql) ;				
					
	}
	
	
	if ($check_shipping_jp != '') {
		// Disactive the jp tracking no
		$sql = "update jp_tracking_no set sts = 'I' where tracking_no = '$check_shipping_jp' ";
		sqlinsert($sql);
	}
	
	// Redirect to order page
	if (isset($_POST['isupdate2'])) {
		//header("Location: index.php?page=order&subpage=list");
		header("Location: index.php?page=order&subpage=list&issearch=Search&date_start=&date_end=&hide_sale_ref=".$sale_ref);
		exit();
	}
}

// Get active JP tracking no. for selection
$jpTrackingNoList = getJPTrackingNoList();

function getAddress() {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM office_address", $db) or die (mysql_error()."<br />Couldn't execute query: $query");

	while ($row = mysql_fetch_array($result)) {
		$list[] = $row;
	}
	
	mysql_close($db);
	
	return $list;
}

function getUserDefaultAddrId() {
	$username = $_SESSION[user_name];
	
	$sql = "SELECT office_addr_id FROM authorize WHERE username = '".$username."'";
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$row=mysql_fetch_array($result);
	$office_addr_id = $row['office_addr_id'];
	
	mysql_close($db);
	
	return $office_addr_id;
}

function getJPTrackingNoList() {
	$sql = "SELECT * FROM jp_tracking_no WHERE sts = 'A'";
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$trackingNos = array();
	while ($row = mysql_fetch_array($result)) {
		$trackingNos[] = $row['tracking_no'];
	}
	
	return $trackingNos;
}

?>