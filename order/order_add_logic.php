
<?
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$order_success = '';

//get sale order
if (isset($_GET['sale_ref']))
{$sale_ref = trim($_GET['sale_ref']);}

//get Number of product
if (isset($_GET['prod_n']))
{$prod_n =trim($_GET['prod_n']);} else {$prod_n=1;}

$sale_order_no_message = '';
if (isset($_GET['mod'])) {
	if ($_GET['mod']=='same_ref')
		$sale_order_no_message = "<font color=red>Please, insert different Order No.</font>";
}

// add new order
if (isset($_POST['isorder']) and !isset($_GET['mod'])) {
	if (isset($_POST['prod_n']))
		$prod_n = trim($_POST['prod_n']); 
	//check sale order no, same order no
	
	if (isset($_POST['sale_ref_a'])) {
		if ($_POST['sale_ref_a']=="a") {
			$sale_chk_ref = 0;
			$sale_ref=trim($_POST['sale_ref_aa']);
			if (getsale_data($sale_ref)!='') {
				echo "<html><meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['PHP_SELF']."?page=".$page."&subpage=".$subpage."&mod=same_ref\"></html>";
				exit;
			}
		}
		
		if 	($_POST['sale_ref_a']=="b") {
			$sale_chk_ref = 1;
			$sale_ref=trim($_POST['sale_ref_bb']);
		}
	}
	//insert record
	if ($_POST['sale_ship_fee']!='') {$sale_ship_fee = trim($_POST['sale_ship_fee']);} else {$sale_ship_fee = 0;}
	if ($_POST['sale_discount']!='') {$sale_discount = trim($_POST['sale_discount']);} else {$sale_discount = 0;}
	if ($_POST['sale_tax']!='') {$sale_tax = trim($_POST['sale_tax']);} else {$sale_tax = 0;}
	
	$sql = "INSERT INTO ben_sale SET
		sale_ref = '$sale_ref',
		sale_date = '".trim($_POST['orderdate'])."',
		sale_group = '".trim($_POST['sale_group'])."',
		sale_email = '".trim($_POST['sale_email'])."',
		sale_name = '".trim($_POST['sale_name'])."',
		sale_yahoo_id = '".trim($_POST['sale_yahoo_id'])."',
		sale_dat = curdate(), 
		sale_chk_ref = $sale_chk_ref,
		sale_ship_fee = ".$sale_ship_fee.",
		sale_discount = ".$sale_discount.",
		sale_tax = ".$sale_tax;
	sqlinsert($sql);
	
	//insert product
	for ($k=1;$k<=$prod_n;$k++)
	{
		$sprod_id = "sprod_id_".$k;
		$sprod_name = "sprod_name_".$k;
		$sprod_price = "sprod_price_".$k;
		$sprod_unit = "sprod_unit_".$k;
		$sqla = "INSERT INTO ben_sale_prod SET
			sprod_ref = '$sale_ref',
			sprod_id = '".trim($_POST[$sprod_id])."',
			sprod_name = '".trim($_POST[$sprod_name])."',
			sprod_price = ".trim($_POST[$sprod_price]).", 
			sprod_unit = ".trim($_POST[$sprod_unit]); 
		
		sqlinsert($sqla);
	}
	
	// Insert debt note
	if (!empty($cust_cd)) {
		$query = "SELECT * FROM customer WHERE cust_cd = '$cust_cd' ";
		$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
		
		$customer = mysql_fetch_array($result);
	
		// Free resultset
		mysql_free_result($result);
		
		$sql = "INSERT INTO ben_debt SET
				debt_ref='$sale_ref',
				debt_tel='".$customer['cust_tel']."',
				debt_cust_address1='".$customer['cust_post_address1']."',
				debt_cust_address2='".$customer['cust_post_address2']."',
				debt_post_co='".$customer['cust_post_cd']."' ";
		sqlinsert($sql);
	}
	
	$order_success = 1;
}

// Get customer
$query = "SELECT cust_cd, cust_company_name FROM customer order by cust_company_name ";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$customers = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$customers[] = $row;
}

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);

?>