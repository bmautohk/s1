<?php

//function to get the date
function last_login()
{
	$date = gmdate("Y-m-d"); 
	return $date;
}

//function that sets the session variable
function sess_vars($base_dir, $server, $dbusername, $dbpassword, $db_name, $table_name, $user, $pass)
{

	//make connection to dbase
	$connection = @mysql_connect($server, $dbusername, $dbpassword)
				or die(mysql_error());
				
	$db = @mysql_select_db($db_name,$connection)
				or die(mysql_error());
				
	$sql = "SELECT * FROM $table_name WHERE username = '$user' and password = password('$pass')";

	$result = @mysql_query($sql, $connection) or die(mysql_error());


	//get the number of rows in the result set
	$num = mysql_num_rows($result);

	//set session variables if there is a match
	if ($num != 0) 
	{
		while ($sql = mysql_fetch_object($result)) 
		{
			$_SESSION[first_name] 	= $sql -> firstname;
			$_SESSION[last_name] 	= $sql -> lastname; 
			$_SESSION[user_name] 	= $sql -> username;       
			$_SESSION[password] 	= $sql -> password;
			$_SESSION[group1]	 	= $sql -> group1;
			$_SESSION[group2]	 	= $sql -> group2;
			$_SESSION[group3] 		= $sql -> group3;
			$_SESSION[pchange]		= $sql -> pchange;  
			$_SESSION[email] 		= $sql -> email;
			$_SESSION[redirect]		= $sql -> redirect;
			$_SESSION[verified]		= $sql -> verified;
			$_SESSION[last_login]	= $sql -> last_login;
		}
	}else{
		$_SESSION[redirect] = "$base_dir/errorlogin.html";
	}
}

//functions that will determine if access is allowed
function allow_access($group)
{
	if (@$_SESSION[group1] == "$group" || @$_SESSION[group2] == "$group" || @$_SESSION[group3] == "$group" ||
		@$_SESSION[group1] == "Administrators" || @$_SESSION[group2] == "Administrators" || @$_SESSION[group3] == "Administrators" ||
		@$_SESSION[user_name] == "$group")
		{
			$allowed = "yes";
		}else{
			$allowed = "no";
		}
	return $allowed;
}

//function to check the length of the requested password
function password_check($min_pass, $max_pass, $pass)
{

	$valid = "yes";
	if ($min_pass > strlen($pass) || $max_pass < strlen($pass))
	{
		$valid = "no";
	}

	return $valid;
}

function connectDatabase(){
	
	$db = mysql_connect("localhost", "autoparts","11g09e9");
	
	return $db;	
}

function sqlinsert($sql)
{

	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
$result = mysql_query($sql,$db);
}


function getprod_list($prod_order,$page_start, $per_page)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id order by ". $prod_order." DESC LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$product_id=$row["product_id"];
	$product_name=$row["product_name"];
	$product_photo=$row["product_photo"];
	$product_dit=$row["product_dit"];
	$cat_name=$row["cat_name"];
	$product_price_u=$row["product_price_u"];
	$product_price_s=$row["product_price_s"];
	$product_web=$row["product_web"];
	if ($row["product_dit"]=='')
	{$product_dit_show = "&nbsp;";}
	else
	{$product_dit_show = "<a href =\"dit_file\\$product_dit\" target=\"_blank\">".$product_dit."</a>";}
	
	if ($row["product_photo"]=='')
	{$product_photo_show = "&nbsp;";}
	else
	{$product_photo_show = "<a href =\"pro_image\\$product_photo\" target=\"_blank\"><img src=\"image.php?w=120&h=120&name=$product_photo\" border=\"0\" ></a>";}
	
	echo "<tr align=\"center\" valign=\"top\" height=\"25\">";
	echo "<td>".$product_id."</td><td>".$product_name."&nbsp;</td>";
	echo "<td>$product_photo_show</td>";
	echo "<td>$product_price_u</td>";
	echo "<td>$product_price_s</td>";
	echo "<td>".$cat_name." &nbsp;</td>";
	if ($product_web == 1)
	echo "<td>Yes</td>";
	else
	echo "<td>-</td>";
	
	echo "<td>$product_dit_show</td>";
	echo "<td><a href=\"prod_del.php?product_id=$product_id\" >Delete</a></td></tr>\n";
	}
	
	}
//---------------------------------------------------------------------------------

function getsale_prod($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$sub_total=0;
	$num_results=mysql_num_rows($result);
	echo "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	echo "<tr  align=\"right\"> <td width='92'>".$sprod_id."</td><td>".$sprod_name."</td><td width='120'>".$sprod_unit." &nbsp;</td><td width='120'>&yen;".$sprod_price."</td><td width='120'>&yen;".number_format($sprod_sub,2,'.','')."</td></tr>\n";
	}
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	
	$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	
	echo "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Sub Total :</td><td width='120'>&yen;".$sub_total."</td></tr>\n";
	echo "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Discount :</td><td width='120'>&yen;".$sale_discount."</td></tr>\n";
	echo "<tr> <td colspan=\"5\">&nbsp;</td></tr>\n";
	
	echo "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Tax ($sale_tax %) :</td><td width='120'>&yen;".$total_tax."</td></tr>\n";
	echo "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\" >Shipping fee :</td><td width='120'>&yen;".$sale_ship_fee."</td></tr>\n";
	
		
	echo "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\"><strong>Total :</strong></td><td width='120'>&yen;".$total."</td></tr>\n";
	echo "</table>";}
	
	//----------------------------------------------------------------------------
	
function getsale_ref_next()
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale where sale_chk_ref = 1 order by sale_ref DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	$top = $row['sale_ref'] + 1;
		
	return $top;
	
	}
//Get data from db--------------------------------------------------------------

//------------------------------------------------------------------------------
function getsale_total($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$total=0;
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	$sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	}
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
		
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	/*
	$temp_total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$temp_total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	*/
	return $sub_total;
	}
//	------------------------------------------------------------------------------------
function getsale_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	return $row;
	}
	

//--------------------------------------------------------------------------------------

function getdebt_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_debt where debt_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	$debt_dat = $row['debt_dat'];
	$debt_cust_name = $row['debt_cust_name'];
	/*
	if ($row)   		
	return $debt_cust_name ." (".$debt_dat.")";
		else
	return "<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	*/
	return $row;
	}
	
//	------------------------------------------------------------------------------------
function getbal_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_bal where bal_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	$bal_dat = $row['bal_dat'];
	$bal_cust_name = $row['bal_pay'];
	return $row;

	}
//----------------------------------------------------------------------------------------
function getship_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_check where check_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);

	return $row;
	}
	
//--------------------------------------------------------------------------------------------
function getreturn_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_return where return_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);

	return $row;
	}
	
//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------
function getprod_data($product_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product where product_id = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	return $row;
	}
	
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------

function getorder_list_by_date($date_start,$date_end)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale where sale_date between '$date_start' and '$date_end' order by sale_date DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"850\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td width='80'>Order date</td><td width='170'>Order No.</td><td width='250'>Debt Note</td><td width='150'>Payment</td><td width='150'>Return</td><td width='150'>Shipping</td></tr>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	
	//$debt_data=getdebt_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	// debt 
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent";
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ."</a><br> $debt_email_sent (".$debt_row['debt_dat'].")";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br> (".$bal_row['bal_dat'].")";
	}
	else
	{$bal_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
	
// shipping 
	if (getship_data($sale_ref)){		
	$ship_row = getship_data($sale_ref);
	if ($ship_row['check_print']==1)
	$ship_print = 'Printed';

	if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
	$ship_date = "(".$ship_row['check_date'].")";
	$ship_ship = 'Shipped';
	$ship_bg = "bgcolor=\"#CCCCCC\"";} else { 
	$ship_ship ='';
	$ship_date = '';
	$ship_bg='';
	}
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping'] ."</a><br>$ship_print $ship_ship <br>$ship_date";
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent";
	$return_date = $return_row['return_date'];
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $return_row['return_pay'] ."</a><br>$return_sent (".$return_row['return_date'].")";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
		$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref</a>";
		
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br>(".$sale_dat .")</td><td>".$debt_data."&nbsp;</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------
function getdate_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	$sale_date = $row['sale_date'];
				
	return $sale_date;
	
	}
		
//-------------------------------------------------------------------------------------
function checkdebt_record($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_debt where debt_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$debt_row=mysql_fetch_array($result);
	
	return $debt_row;   		
	
	}	
//-------------------------------------------------------------------------------------------

function getorder_list_by_no($sale_ref,$check)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($check == 'sno'){
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	else
	{
	$result = mysql_query("SELECT * FROM ben_sale, ben_debt where sale_ref = debt_ref and debt_cust_name like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	} 
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"850\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td width='80'>Order date</td><td width='170'>Order No.</td><td width='250'>Debt Note</td><td width='150'>Payment</td><td width='150'>Return</td><td width='150'>Shipping</td></tr>\n";

	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	
	//$debt_data=getdebt_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	// debt 
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
		if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent";
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ."</a><br> $debt_email_sent (".$debt_row['debt_dat'].")";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $bal_row['bal_pay'] ."</a><br>(".$bal_row['bal_dat'].")";
	}
	else
	{$bal_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
	
// shipping 
	if (getship_data($sale_ref)){		
	$ship_row = getship_data($sale_ref);
	if ($ship_row['check_print']==1)
	$ship_print = 'Printed';

	if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
	$ship_date = "(".$ship_row['check_date'].")";
	$ship_ship = 'Shipped';} else { 
	$ship_ship ='';
	$ship_date = '';
	}
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping'] ."</a><br>$ship_print $ship_ship <br>$ship_date";
	}
	else
	{$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}
	
	
	//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != '')
	$return_sent = "Re-Sent";
	$return_date = $return_row['return_date'];
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $return_row['return_pay'] ."</a><br>$return_sent (".$return_row['return_date'].")";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref</a>";
	
	
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br>(".$sale_dat .")</td><td>".$debt_data."&nbsp;</td><td>".$bal_data."</td><td>".$return_data."</td><td>".$ship_data."</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------


function getreport($date_start,$date_end,$sale_or,$sale_as,$mod)
	{
	$bal_total = 0;
	$sale_total = 0;
	$return_total = 0;
	$tax_total = 0;
	$ship_total = 0;
	$dis_total = 0;
	$sub_total = 0;
	$sub = 0;
	
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($mod == "date")
	$result = mysql_query("SELECT * FROM ben_sale where sale_date between '$date_start' and '$date_end' order by $sale_or $sale_as" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else 
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref like '%$mod%' order by $sale_or $sale_as" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"750\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"right\"><td width='80'>Order date</td><td width='120'>Order No.</td><td width='100'>Total Sale</td><td width='100'>Sale</td><td width='100'>Discount</td><td width='100'>Shipping fee</td><td width='100'>Tax</td><td width='100'>Balance</td><td width='100'>Return</td></tr>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	
	
	$sale_tax=$row["sale_tax"];
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	
	/*
	$temp_total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$temp_total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	*/
	$sub_total = getsale_total($sale_ref);
	$temp_total = number_format($sub_total-$sale_discount,2,'.','');
	$sale_tax =$temp_total * $sale_tax / 100; 
	
	$sale_total = $sub_total + $sale_tax - $sale_discount + $sale_ship_fee;
	
	
	$sub_total_sale = $sub_total_sale + $sub_total;
	$tax_total = $tax_total + $sale_tax;
	$ship_total = $ship_total + $sale_ship_fee;
	$dis_total = $dis_total + $sale_discount;
	$sale_total_total = $sale_total_total+$sale_total;
	

	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $bal_row['bal_pay'] ."<br> (".$bal_row['bal_dat'].")</a>";
	$bal_total=$bal_total + $bal_row['bal_pay'];
	}
	else
	{$bal_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">Not Pay</a>";
	$bal_return = "0.00";
	}
	
		//return
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	$return_pay = $bal_row['return_pay'];
	$return_total = $return_total + $return_pay;
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $return_row['return_pay'] ."<br> (".$return_row['return_dat'].")</a>";
	$return_total=$return_total + $return_row['return_pay'];
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Refund</a>";
	$return_pay = "0.00";
	}
	
	
// shipping 
	if (getship_data($sale_ref)){		
	$ship_row = getship_data($sale_ref);
	if ($ship_row['check_print']==1)
	$ship_print = 'Printed';

	if ($ship_row['check_date']!='' and $ship_row['check_date']!='0000-00-00'){
	$ship_date = "(".$ship_row['check_date'].")";
	$ship_ship = 'Shipped';} else { 
	$ship_ship ='';
	$ship_date = '';
	}
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping'] ."</a><br>$ship_print $ship_ship <br>$ship_date";
	}
	else
	{$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
	echo "<tr valign=\"top\" align=\"right\"> <td>".$sale_date."</td><td>".$sale_ref."<br>(".$sale_dat .")</td><td width='120'>".number_format($sale_total,2,'.','')."&nbsp;</td><td>".number_format($sub_total,2,'.','')."&nbsp;</td><td>".$sale_discount."&nbsp;</td><td>".$sale_ship_fee."&nbsp;</td><td>".$sale_tax."&nbsp;</td><td width='120'>".$bal_data."</td><td width='120'>".$return_data."&nbsp;</td></tr>\n";
		
	
	}


	//end loop
	echo "<tr valign=\"top\" align=\"right\"> <td width='92'>&nbsp;</td><td>Total: </td><td>".number_format($sale_total_total,2,'.','')."&nbsp;</td><td>".number_format($sub_total_sale,2,'.','')."</td><td>".number_format($dis_total,2,'.','')."</td><td>".number_format($ship_total,2,'.','')."</td><td>".number_format($tax_total,2,'.','')."</td><td width='120'>".number_format($bal_total,2,'.','')."</td><td width='120'>".number_format($return_total,2,'.','')."&nbsp;</td></tr>\n";
	echo "</table>";
	}
	
	//---------------------------
		//----------------------------------------------------------------------------
	
function getreturn_next()
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_return_photo order by return_photo_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	$top = $row['return_photo_id'] + 1;
		
	return $top;
	
	}
	
//-----------------------------------------------------------------------
function getreturn_list($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_return_photo where return_ref = '$sale_ref' order by return_photo DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	echo "<table>";
	echo "<tr>";
	for ($i=0;$i<$num_results;$i++)
	{

	
	$row=mysql_fetch_array($result);
	$return_photo=$row["return_photo"];
	
	echo "<td>$i<img src=\"return_image.php?w=100&h=100&name=" . $return_photo."\" > <br>
		  <a href=\"return_del.php?sale_ref=$sale_ref&return_photo=$return_photo\">Delete</a></td>\n";
	
	if (($i+1)%5==0 and $i!=0)
	echo "</tr><tr>";
		  
	}
	echo "</tr>";
	echo "</table>";
	}
	
	// ----------------------------------------------------------------------------------	
	function getsale_prod_email($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$sub_total=0;
	$num_results=mysql_num_rows($result);
	$email_text = $email_text . "はじめまして";

	$email_text = $email_text . "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>".$sprod_id."</td><td>".$sprod_name."</td><td width='120'>".$sprod_unit." &nbsp;</td><td width='120'>&yen;".$sprod_price."</td><td width='120'>&yen;".number_format($sprod_sub,2,'.','')."</td></tr>\n";
	}
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	
	$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	
	$email_text = $email_text . "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Sub Total :</td><td width='120'> &yen; ".$sub_total."</td></tr>\n";
	$email_text = $email_text . "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Discount :</td><td width='120'> &yen; ".$sale_discount."</td></tr>\n";
	$email_text = $email_text . "<tr> <td colspan=\"5\">&nbsp;</td></tr>\n";
	
	$email_text = $email_text . "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\">Tax ($sale_tax %) :</td><td width='120'> &yen; ".$total_tax."</td></tr>\n";
	$email_text = $email_text . "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\" >Shipping fee :</td><td width='120'> &yen; ".$sale_ship_fee."</td></tr>\n";
	
		
	$email_text = $email_text . "<tr align=\"right\"> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td  align=\"right\"><strong>Total :</strong></td><td width='120'> &yen; ".$total."</td></tr>\n";
	$email_text = $email_text . "</table>";
	return $email_text;
	}
//----------------------------------------------------------------------------
//search product 
function getprodlike_list($product_id)
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product where product_id like '%$product_id%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	echo "<table width=\"654\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$product_id=$row["product_id"];
	$product_name=$row["product_name"];
	if ($i==0)
	$check_radio = "checked";	
	else
	$check_radio = "";	
	
	echo "<tr align=\"center\" valign=\"middle\">
          
          <td width=\"200\">
              <input name=\"sprod_id_$i\" type=\"text\" value = \"$product_id\" >
</td>
          <td width=\"180\">
            <input name=\"sprod_name_$i\" type=\"text\" value = \"$product_name\" >
         </td>
          <td width=\"80\">
               
                  <input name=\"sprod_unit_$i\" type=\"text\" size=\"3\" maxlength=\"2\">
             </td>
          <td width=\"120\"> &yen;
                      <input name=\"sprod_price_$i\" type=\"text\" size=\"7\" maxlength=\"7\">
          </td>
		  <td >          <input name=\"sprod_opt\" type=\"radio\" value=\"$i\" $check_radio ></td>
 </tr>";
      }
	echo "  <tr align=\"right\">
    <td colspan=\"5\"><input type=\"submit\" name=\"isfindadd\" value=\"Add\"></td>
  </tr></table> ";
	
	}


//display product edit ----------------------------------------------------------------------------

function getedit_list($sale_ref)
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
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
		  <td ><a href=\"order_delete.php?sprod_no=$sprod_no&sale_ref=$sale_ref\">Delete</a></td>
 			</tr>";
      }
	echo "</table>"; 
	//<input type=\"submit\" name=\"isfindadd\" value=\"update\">";
	
	}


//----------------------------------------------------------------------------

function getprod_cat()
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_cat", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	echo "<select name=cat_id>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$cat_id=$row["cat_id"];
	$cat_name=$row["cat_name"];
	
	echo "<option value=\"$cat_id\">$cat_name</option>\n";
	}
	echo "</select>";
} 
//----------------------------------------------------------------------------
//search product 
function getprodlike_sale($product_id)
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id and product_id like '%$product_id%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	echo "<table width=\"738\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">                    <tr align=\"center\" valign=\"top\">
                      <td width=\"75\"><div align=\"center\">Product ID</div></td>
                      <td width=\"117\"><div align=\"center\">Product Name </div></td>
                      <td width=\"115\"><div align=\"center\">Photo</div></td>
                      <td width=\"80\">Price (Users)</td>
                      <td width=\"80\">Price (Supplier) </td>
                      <td width=\"85\">Catogery</td>
                      <td width=\"16\">Web</td>
                      <td width=\"69\"><div align=\"center\">Dit</div></td>
                       </tr>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$product_id=$row["product_id"];
	$product_name=$row["product_name"];
	$product_dit=$row["product_dit"];
	$product_price_u=$row["product_price_u"];
	$product_price_s=$row["product_price_s"];
	$product_web=$row["product_web"];
	$product_photo=$row["product_photo"];
	
	$cat_name=$row["cat_name"];
	
	if ($row["product_photo"]=='')
	{$product_photo_show = "&nbsp;";}
	else
	{$product_photo_show = "<a href =\"pro_image\\$product_photo\" target=\"_blank\"><img src=\"image.php?w=120&h=120&name=$product_photo\" border=\"0\" ></a>";}
	
	echo "

                    <tr valign=\"top\">
                     
                      <td align=\"center\">$product_id &nbsp;</td>
                      <td align=\"center\">$product_name &nbsp;</td>
                     
					  <td align=\"center\">$product_photo_show &nbsp;</td>
                     
					  <td align=\"center\">$product_price_u &nbsp;</td>
                      <td align=\"center\">$product_price_s &nbsp;</td>
                      <td align=\"center\">$cat_name &nbsp;</td>
                      <td align=\"center\">$product_web &nbsp;</td>
					   <td align=\"center\" ><a href='\dit_file\$product_dit'>$product_dit</a>&nbsp;</td> 
                       </tr>";

               
	
     }
echo "</table>";
	
	}
	//..........................................................
//check sold items
	function getsold_list($product_id)
{
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result =  mysql_query("SELECT * FROM ben_sale_prod, ben_sale where sprod_ref=sale_ref and sprod_id = '$product_id'" ,$db);
	$num_results=mysql_num_rows($result);
	echo "<table width=\"738\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">              
	      <tr align=\"center\" valign=\"top\">
		  <td align=\"center\" >Order No.</td>
                      <td align=\"center\" >Product ID</td>
                      <td align=\"center\" >Product Name </td>
                      <td align=\"center\" >Price </td>
                      <td align=\"center\" >Unit </td>
     
                       </tr>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_no=$row["sprod_no"];
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_ref=$row["sprod_ref"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$total_price += $sprod_price;
	$total_unit += $sprod_unit;
	
	 
	
	echo "<tr valign=\"top\">
						<td align=\"center\" ><a href='order_edit.php?sale_ref=$sprod_ref' target='_blank'>$sprod_ref<a/></td>
                      <td align=\"center\">$sprod_id &nbsp;</td>
                      <td align=\"center\">$sprod_name &nbsp;</td>
                    <td align=\"center\">$sprod_price &nbsp;</td>
                      <td align=\"center\">$sprod_unit &nbsp;</td>
                       </tr>";

               
	
     }
echo "</table><br><br>";
	echo "Total Sale:".number_format($total_price,2,'.','')."<br>";
	echo "Total Units:".$total_unit;
	} 
	// mysql_query("SELECT * FROM ben_sale_prod where sprod_id = '$product_id'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	//check sold items date ------------------------------------------------------------
	function getsold_list_date($date_start,$date_end)
{
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result =  mysql_query("SELECT * FROM ben_sale_prod, ben_sale where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end')" ,$db);
	$num_results=mysql_num_rows($result);
	//echo "SELECT * FROM ben_sale_prod, ben_sale where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end')";
	echo "<table width=\"738\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">              
	      <tr align=\"center\" valign=\"top\">
                      <td align=\"center\" >Order No.</td>
                      <td align=\"center\" >Product ID</td>
                      <td align=\"center\" >Product Name </td>
                      <td align=\"center\" >Price </td>
                      <td align=\"center\" >Unit </td>
     
                       </tr>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_no=$row["sprod_no"];
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_ref=$row["sprod_ref"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$total_price += $sprod_price;
	$total_unit += $sprod_unit;
	 
	
	echo "<tr valign=\"top\">
	<td align=\"center\" ><a href='order_edit.php?sale_ref=$sprod_ref' target='_blank'>$sprod_ref<a/></td>
                      <td align=\"center\">$sprod_id &nbsp;</td>
                      <td align=\"center\">$sprod_name &nbsp;</td>
                     <td align=\"center\">$sprod_price &nbsp;</td>
                      <td align=\"center\">$sprod_unit &nbsp;</td>
                       </tr>";

               
	
     }
echo "</table><br><br>";
	echo "Total Sale:".number_format($total_price,2,'.','')."<br>";
	echo "Total Units:".$total_unit;
	} 
	//---------------------------------------------------------------
	//shipping report 
	
	function ship_report()
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_bal where bal_ref not in (select check_ref from ben_check) order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"350\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Payment Date</td>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$bal_ref=$row["bal_ref"];
	$bal_dat=$row["bal_dat"];
	/*
	//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent";
	$return_date = $return_row['return_date'];
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">". $return_row['return_pay'] ."</a><br>$return_sent (".$return_row['return_date'].")";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
		$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref</a>";
*/		
		
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$bal_ref'>".$bal_ref."</a></td><td>".$bal_dat."</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------


?>