<?


if (isset($_POST['isupdate']))
{ 
	$sale_ref = trim($_POST['sale_ref']);
	$sql = "update ben_sale SET 
		sale_group = '".trim($_POST['sale_group'])."',
		sale_email = '".trim($_POST['sale_email'])."',
		sale_name = '".trim($_POST['sale_name'])."',
		sale_yahoo_id = '".trim($_POST['sale_yahoo_id'])."',
		sale_ship_fee = ".trim($_POST['sale_ship_fee']).",
		sale_discount = ".trim($_POST['sale_discount']).",
		sale_tax = ".trim($_POST['sale_tax']).",
		sale_date = '".trim($_POST['orderdate'])."',
		sale_dat = curdate() where sale_ref = '$sale_ref'";
	
	sqlinsert($sql);
	$sale_row = getsale_data($sale_ref);
	$sale_group = $sale_row['sale_group'];
	$sale_email = $sale_row['sale_email'];
	$sale_name = $sale_row['sale_name'];
	$sale_yahoo_id = $sale_row['sale_yahoo_id'];
	$sale_ship_fee = $sale_row['sale_ship_fee'];
	$sale_discount = $sale_row['sale_discount'];
	$sale_tax = $sale_row['sale_tax'];
	$sale_date = $sale_row['sale_date'];
}

if (isset($_GET['sale_ref']) or isset($_POST['isfind'])) 
{
	if (isset($_GET['sale_ref'])) {$sale_ref = trim($_GET['sale_ref']);}
	//if (isset($_POST['isfind'])) {$sale_ref = $_POST['sale_ref'];}
	$sale_row = getsale_data($sale_ref);
	$sale_group = $sale_row['sale_group'];
	$sale_email = $sale_row['sale_email'];
	$sale_name = $sale_row['sale_name'];
	$sale_yahoo_id = $sale_row['sale_yahoo_id'];
	
	$sale_ship_fee = $sale_row['sale_ship_fee'];
	$sale_discount = $sale_row['sale_discount'];
	$sale_tax = $sale_row['sale_tax'];
	$sale_date = $sale_row['sale_date'];
	
}
if (isset($_POST['isadd'])){
	$sqla = "INSERT INTO ben_sale_prod SET
		sprod_ref = '$sale_ref',
		sprod_id = '".trim($_POST['sprod_id_1'])."',
		sprod_name = '".trim($_POST['sprod_name_1'])."',
		sprod_price = '".trim($_POST['sprod_price_1'])."', 
		sprod_unit = '".trim($_POST['sprod_unit_1'])."'"; 
	
	sqlinsert($sqla);
}

if (isset($_POST['isfindadd']))
{
	$sprod_opt = $_POST['sprod_opt'];
	$sprod_id_t = "sprod_id_".$sprod_opt;
	$sprod_name_t = "sprod_name_".$sprod_opt;
	$sprod_price_t = "sprod_price_".$sprod_opt;
	$sprod_unit_t = "sprod_unit_".$sprod_opt;
	
	$sqla = "INSERT INTO ben_sale_prod SET
		sprod_ref = '$sale_ref',
		sprod_id = '".trim($_POST[$sprod_id_t])."',
		sprod_name = '".trim($_POST[$sprod_name_t])."',
		sprod_price = ".trim($_POST[$sprod_price_t]).", 
		sprod_unit = ".trim($_POST[$sprod_unit_t]); 
	
	sqlinsert($sqla);
}

function get_edit_list($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '$sale_ref'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	echo "<table width=\"654\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
	$num_results=mysql_num_rows($result);
	echo "<tr align=\"center\" valign=\"middle\">
	<td width=\"200\">Product ID</td>
	<td width=\"180\">Product Name</td>
	<td width=\"80\">Unit</td>
	<td width=\"120\">Price</td>
	<td >Delete Record</td>
	</tr>";
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$sprod_id=$row["sprod_id"];
		$sprod_name=$row["sprod_name"];
		$sprod_price=$row["sprod_price"];
		$sprod_unit=$row["sprod_unit"];
		$sprod_no=$row["sprod_no"];
		
		echo "<tr align=\"center\" valign=\"middle\">
		
		<td width=\"200\">$sprod_id</td>
		<td width=\"180\">$sprod_name</td>
		<td width=\"80\">$sprod_unit</td>
		<td width=\"120\"> &yen;$sprod_price</td>
		<td ><a href=\"index.php?page=order&subpage=delete&sprod_no=$sprod_no&sale_ref=$sale_ref\">Delete</a></td>
		</tr>";
	}
	echo "</table>"; 
	//<input type=\"submit\" name=\"isfindadd\" value=\"update\">";
	
}
?>