<?php
include('../functions.php');

$item = array(0 => $_GET['item1'],
			1 => $_GET['item2'],
			2 => $_GET['item3'],
			3 => $_GET['item4'],
			4 => $_GET['item5']);

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$item_cnt = 0;
for ($i = 0; $i < 5; $i++) {
	if ($item[$i] != '' ) {
		// Product ID
		$product[$item_cnt]['product_id'] = $item[$i];
		
		// Get product name
		$prod_result = mysql_query("select product_name from product where product_id = '$item[$i]'",$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results=mysql_num_rows($prod_result);
		if ($num_results != 0) {
			$prod_row = mysql_fetch_array($prod_result);
			$num_results=mysql_num_rows($prod_result);
			$product[$item_cnt]['product_name'] = $prod_row['product_name'];
			
			// Get Stock
			$stock_rslt = getProductRealStockByProdId($db, "$item[$i]");
			$stock_row = mysql_fetch_array($stock_rslt);
			$product[$item_cnt]['real_stock'] = $stock_row['real_stock'];
		}
		else {
			// Product not exist
			$product[$item_cnt]['product_name'] = "Product Not Exist";
			$product[$item_cnt]['real_stock'] = 0;
		}
		
		$item_cnt++;
	}
}
mysql_close($db);

?>
Product Stock:<br>
<table border=1>
	<tr>
		<td>Product ID</td><td>Product Name</td><td>Remain?</td>
	</tr>
	<? for ($i = 0; $i < $item_cnt; $i++) { ?>
	<tr>
		<td><?=$product[$i]['product_id']?></td>
		<td><?=$product[$i]['product_name']?></td>
		<td><? if ($product[$i]['real_stock'] > 0) { echo 'Yes'; } else { echo 'No'; } ?></td>
	</tr>
	<? }?>
</table>