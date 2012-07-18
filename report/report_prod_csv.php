<?php
	include_once('../config.php');
	include_once('../functions.php');
	//header("Content-type:application/vnd.ms-excel;charset=euc");
	header("Content-type:application/vnd.ms-excel;charset=utf-8");
//	header("Content-type:text/html;charset=euc-jp");
	header("Content-Disposition:filename=output.xls");
?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=EUC-JP"></head><body>
<?php
if ((isset($_GET['prod_id']) || isset($_GET['prod_name'])) and ($_GET['prod_id']!='' or $_GET['prod_name']!='') and isset($_GET['search_sale'])){
	$prod_id = $_GET['prod_id'];
	$prod_name = $_GET['prod_name'];
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db(DB_NAME,$db);
	$result =  mysql_query("SELECT * FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sprod_ref=sale_ref and sprod_id like '$prod_id%' and sprod_name like '%$prod_name%'" ,$db);

	$num_results=mysql_num_rows($result);
	$prod_n = $num_results;
	
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$sprod_no[$i]=$row["sprod_no"];
		$sprod_id[$i]=$row["sprod_id"];
		$sprod_name[$i]=$row["sprod_name"];
		$sprod_ref[$i]=$row["sprod_ref"];
		$sprod_price[$i]=$row["sprod_price"];
		$sprod_unit[$i]=$row["sprod_unit"];
		
		$sale_email[$i]=$row["sale_email"];
		$sale_date[$i]=$row["sale_date"];
		$sale_dat[$i]=$row["sale_dat"];
		  
		 
		
		$total_price += $sprod_price[$i];
		$total_unit += $sprod_unit[$i];
	}
}
else if (isset($_GET['date_start']) and isset($_GET['search_date'])) {
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	$sprod_top = $_GET['sprod_top'];
	$sprod_select = $_GET['sprod_select'];

	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
 	mysql_select_db(DB_NAME,$db);
	if ($sprod_top == "1") {
		$result =  mysql_query("SELECT *, sum(sprod_unit) as counter FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end') group by sprod_id order by counter desc limit 0, $sprod_select  " ,$db);
	}
	else {
		$result =  mysql_query("SELECT *, sprod_unit as counter FROM ben_sale, ben_sale_prod left outer join product on ben_sale_prod.sprod_id = product.product_id where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end')" ,$db);
	}
	$num_results=mysql_num_rows($result);
	
	
	$prod_n = $num_results;
	
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$sprod_no[$i]=$row["sprod_no"];
		$sprod_id[$i]=$row["sprod_id"];
		$sprod_name[$i]=$row["sprod_name"];
		$sprod_ref[$i]=$row["sprod_ref"];
		$sprod_price[$i]=$row["sprod_price"];
		$sprod_unit[$i]=$row["counter"];
		$sprod_cost_rmb[$i]=$row["product_cost_rmb"];
		$sale_email[$i]=$row["sale_email"];
		$sale_date[$i]=$row["sale_date"];
		$sale_dat[$i]=$row["sale_dat"];
		  
		$total_price += $sprod_price[$i];
		$total_unit += $sprod_unit[$i];
	}
}

?>
  <table   border="1" cellpadding="0" cellspacing="0">              
	<tr align="center" valign="top">
        <td align="center" >Order No.</td>
		<td > Order date</td>
        <td align="center" >Product ID</td>
        <td align="center" >Product Name </td>
		<td > client email</td>
		<td align="center" >Cost (RMB)</td>
        <td align="center" >Price </td>
        <td align="center" >Unit </td>
    </tr>
		<? for ($i = 0; $i < $prod_n; $i++) { ?>
        <tr valign="top">
            <td align="center" ><a href="index.php?page=order&subpage=edit&sale_ref=<?=$sprod_ref[$i]?>" target='_blank'><?=$sprod_ref[$i]?></a></td>
 
			<td align="center"><?=$sale_dat[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_id[$i]?> &nbsp;</td>
		
            <td align="center"><?=$sprod_name[$i]?> &nbsp;</td>
			<td align="center"><?=$sale_email[$i]?> &nbsp;</td>
			<td align="center"><?=$sprod_cost_rmb[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_price[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_unit[$i]?> &nbsp;</td>
        </tr>
        <? }?>
    </table>