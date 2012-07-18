<?
include('config.php');

$product_id=$_GET['product_id'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM product where product_id = '$product_id'",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	$product_us_no = $row['product_us_no'];
	$product_name=$row["product_name"];
	$product_photo=$row["product_photo"];
	$product_dit=$row["product_dit"];
	$pro_image = "pro_image/".$product_photo;
	$pro_dit = "dit_file/".$product_dit;
	
	if ($product_photo!=''){unlink($pro_image);}
	
	if ($product_dit!=''){unlink($pro_dit);}
	

$sql = "delete from product where product_id = '$product_id'";
sqlinsert($sql);

// Delete Alias Product
if ($product_us_no != '') {
	$sql = "delete from product where product_id = '$product_us_no' and alias = 'Y' ";
	sqlinsert($sql);
}

// Delete customer selling price
$sql = "delete from cust_prod_price where product_id = '$product_id' ";
sqlinsert($sql);

//echo $sql;

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=$page&subpage=list'></html>";
	exit; 

?>