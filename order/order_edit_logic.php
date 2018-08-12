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
		sts = '".trim($_POST['sts'])."',
		address_restriction = '".trim($_POST['address_restriction'])."',  
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
	$sts=$sale_row['sts'];
}

if (isset($_GET['sale_ref']) or isset($_POST['isfind'])) 
{
	if (isset($_GET['sale_ref'])) {
		$sale_ref = trim($_GET['sale_ref']);
	}
	
	//if (isset($_POST['isfind'])) {$sale_ref = $_POST['sale_ref'];}
	$sale_row = getsale_data($sale_ref);
	$address_restriction = $sale_row['address_restriction'];
	$sale_group = $sale_row['sale_group'];
	$sale_email = $sale_row['sale_email'];
	$sale_name = $sale_row['sale_name'];
	$sale_yahoo_id = $sale_row['sale_yahoo_id'];
	
	$sale_ship_fee = $sale_row['sale_ship_fee'];
	$sale_discount = $sale_row['sale_discount'];
	$sale_tax = $sale_row['sale_tax'];
	$sale_date = $sale_row['sale_date'];
	$sts=$sale_row['sts'];
	
}
if (isset($_POST['isadd'])) {
	
	$sprod_material = '';
	if (isset($_POST['sprod_material_option_1'])) {
		foreach ($_POST['sprod_material_option_1'] as $material) {
			if ($sprod_material == '') {
				$sprod_material = $material;
			} else {
				$sprod_material .= ', '.$material;
			}
		}
	}
	
	$other = trim($_POST['sprod_material_1']);
	if (!empty($other)) {
		if ($sprod_material == '') {
			$sprod_material = $other;
		} else {
			$sprod_material .= ', '.$other	;
		}
	}
	
	if (empty($_POST['sprod_colour_option_1'])) {	
		// Other
		$sprod_color = trim($_POST['sprod_colour_1']);
	} else {
		// Dropdown
		$sprod_color = $_POST['sprod_colour_option_1'];
	}
	
	$sqla = "INSERT INTO ben_sale_prod SET
		sprod_ref = '$sale_ref',
		sprod_id = '".trim($_POST['sprod_id_1'])."',
		sprod_name = '".trim($_POST['sprod_name_1'])."',
		sprod_material = '".$sprod_material."',
		sprod_colour = '".$sprod_color."',
		sprod_price = '".trim($_POST['sprod_price_1'])."', 
		sprod_unit = '".trim($_POST['sprod_unit_1'])."'"; 
	
	sqlinsert($sqla);
}

if (isset($_POST['isfindadd']))
{
	$sprod_opt = $_POST['sprod_opt'];
	$sprod_id_t = "sprod_id_".$sprod_opt;
	$sprod_name_t = "sprod_name_".$sprod_opt;
	$sprod_material_t = "sprod_material_".$sprod_opt;
	$sprod_colour_t = "sprod_colour_".$sprod_opt;
	$sprod_price_t = "sprod_price_".$sprod_opt;
	$sprod_unit_t = "sprod_unit_".$sprod_opt;
	
	$sqla = "INSERT INTO ben_sale_prod SET
		sprod_ref = '$sale_ref',
		sprod_id = upper('".trim($_POST[$sprod_id_t])."'),
		sprod_name = '".trim($_POST[$sprod_name_t])."',
		sprod_material = '".trim($_POST[$sprod_material_t])."',
		sprod_colour = '".trim($_POST[$sprod_colour_t])."',
		sprod_price = ".trim($_POST[$sprod_price_t]).", 
		sprod_unit = ".trim($_POST[$sprod_unit_t]); 
	
	sqlinsert($sqla);
}

// Get customer
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$query = "SELECT cust_cd, cust_company_name FROM customer order by cust_company_name ";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$customers = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$customers[] = $row;
}

mysql_free_result($result);
mysql_close($db);


function get_edit_list($sale_ref) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Check whether paymnet eixst
	$query = "SELECT * FROM ben_bal where bal_ref = '$sale_ref'";
	$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);

	$isPaymentExist = $num_results > 0 ? true : false;

	mysql_free_result($result);
	
	// Get product lines
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '$sale_ref'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	echo "<table width=\"904\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
	$num_results=mysql_num_rows($result);
	echo "<tr align=\"center\" valign=\"middle\">
	<td width=\"200\">Product ID</td>
	<td width=\"180\">Product Name</td>
	<td>&#x6750;&#x8CEA;</td>
    <td>&#x984F;&#x8272;</td>
	<td width=\"80\">Unit</td>
	<td width=\"120\">Price</td>
	<td >Delete Record</td>
	</tr>";
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$sprod_id=$row["sprod_id"];
		$sprod_name=$row["sprod_name"];
		$sprod_material=$row["sprod_material"];
		$sprod_colour=$row["sprod_colour"];
		$sprod_price=$row["sprod_price"];
		$sprod_unit=$row["sprod_unit"];
		$sprod_no=$row["sprod_no"];
		
		echo "<tr align=\"center\" valign=\"middle\">
		
		<td width=\"200\">$sprod_id</td>
		<td width=\"180\">$sprod_name</td>
		<td>$sprod_material</td>
		<td>$sprod_colour</td>
		<td width=\"80\">$sprod_unit</td>
		<td width=\"120\"> &yen;$sprod_price</td>";

		if (!$isPaymentExist) {
			echo "<td ><a href=\"index.php?page=order&subpage=delete&sprod_no=$sprod_no&sale_ref=$sale_ref\">Delete</a></td>";
		} else {
			echo "<td >Delete</td>";
		}

		echo "</tr>";
	}
	echo "</table>"; 
	//<input type=\"submit\" name=\"isfindadd\" value=\"update\">";
	
}
?>