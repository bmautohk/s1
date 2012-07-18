<?php
if (isset($_POST['Submit'])) {

	$product_id=$_POST['product_id'];
	$prod_n = $_POST['per_page'];
	$db=connectDatabase();
	mysql_select_db(MAIN_DB,$db);
	
	for ($i=0; $i<$prod_n; $i++) {	
		$add = "add_".$i;
		$Id = "Id_".$i;
		$add_jp = "add_jp_".$i;
		
		$prod_id = $_POST[$Id];
		
		if (isset($_POST[$add]) or isset($_POST[$add_jp])) {
			$temp = $_POST[$add] - $_POST[$add_jp];
			
			$db=connectDatabase();
			mysql_select_db(DB_NAME,$db);
			$result = mysql_query("SELECT product_jp_no, product_us_no FROM product WHERE product_id = '$prod_id'",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
			$row=mysql_fetch_array($result);
			$product_jp_no = $row['product_jp_no'];
			$product_us_no = $row['product_us_no'];
			
			$sql = "update product set product_pcs = product_pcs + ".$temp.", product_stock_jp = product_stock_jp + ".$_POST[$add_jp]." where product_id = '$prod_id'";
			sqlinsert($sql);
			if ($product_jp_no != '') {
				$sql = "update product set product_pcs = product_pcs + ".$temp.", product_stock_jp = product_stock_jp + ".$_POST[$add_jp]." where product_id = '$product_jp_no'";
				sqlinsert($sql);
			}
			
			if ($product_us_no != '') {
				$sql = "update product set product_pcs = product_pcs + ".$temp.", product_stock_jp = product_stock_jp + ".$_POST[$add_jp]." where product_id = '$product_us_no'";
				sqlinsert($sql);
			}
		}
	}
}

function getprodList($prod_order,$page_start, $per_page) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM product as p WHERE alias <> 'Y' order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$product_id=$row["product_id"];
		$product_name=$row["product_name"];
		$product_photo=$row["product_photo"];
		$product_dit=$row["product_dit"];
		$cat_name=$row["product_cat"];
		
		$product_price_u=$row["product_price_u"];
		$product_price_s=$row["product_price_s"];
		$product_cost_rmb=$row["product_cost_rmb"];
		$product_pcs=$row["product_pcs"];
		$product_stock_level=$row['product_stock_level'];
		$product_stock_jp=$row['product_stock_jp'];
		
		$product_location=$row['product_location'];
		
		$product_colour=$row["product_colour"];
		$product_web=$row["product_web"];
	
		$real_stock = $product_pcs - getprod_shipped($product_id);
		$order_stock = $product_pcs - getprod_order($product_id);
	
	
	
		if ($row["product_dit"]=='')
		{$product_dit_show = "&nbsp;";}
		else
		{$product_dit_show = "<a href =\"dit_file\\$product_dit\" target=\"_blank\">".$product_dit."</a>";}
		
		if ($row["product_photo"]=='')
		{$product_photo_show = "&nbsp;";}
		else
		{$product_photo_show = "<a href =\"pro_image\\$product_photo\" target=\"_blank\"><img src=\"image.php?w=120&h=120&name=$product_photo\" border=\"0\" ></a>";}
		
		echo "<tr align=\"center\" valign=\"top\" height=\"25\">";
		echo "<td><a href =\"index.php?page=product&subpage=edit&product_id=$product_id\" >".$product_id."</a></td><td>".$product_name."&nbsp;</td>";
		echo "<td>$product_photo_show</td>";
		echo "<td><input name=\"add_$i\" type=\"text\" size=\"3\" maxlength=\"7\" value=\"0\" >
		 <input type=\"hidden\" name=\"Id_$i\" value=\"$product_id\">
		</td>";
		echo "<td><input name=\"add_jp_$i\" type=\"text\" size=\"3\" maxlength=\"7\" value=\"0\"></td>";
			
		echo "<td>$real_stock &nbsp;</td>";
		echo "<td>$product_stock_jp &nbsp;</td>";
		echo "<td>$order_stock &nbsp;</td>";
		echo "<td>$product_colour &nbsp;</td>";
		
		echo "<td>$product_price_u &nbsp;</td>";
		echo "<td>$product_price_s &nbsp;</td>";
		echo "<td>$product_cost_rmb &nbsp;</td>";
		echo "<td>".$cat_name." &nbsp;</td>";
		if ($product_web == 1)
		echo "<td>Yes</td>";
		else
		echo "<td>-</td>";
		
		echo "<td>$product_dit_show &nbsp;</td>";
		echo "<td>$product_location &nbsp;</td>";
		
		echo "<td><a href=\"index.php?page=product&subpage=del&product_id=$product_id\" onclick=\"return cDelete()\" >Delete</a></td></tr>\n";
	}
	
}

?>
