<?php

$self_link_photo = 'http://superior-autoparts.com/pro_image/' ;

define("Self_link_photo", "http://superior-autoparts.com/pro_image/");
define("Admin_name", "Administrators");

$tool_bar="<TABLE width=\"800\" cellPadding=10>
            <TBODY>
              <TR>
                <TD width=\"156\"><span class=\"cat cat\"><a href=\"order_add.php\" class=\"big\">Add New<br> 
                  sales</a> </span></TD>
                <TD width=\"167\"><span class=\"cat cat\"><a href=\"ship_report.php\" class=\"big\">Shipping<br> 
                  Report</a></span></TD>
                <TD width=\"144\"><span class=\"cat cat\"><a href=\"email_report.php\" class=\"big\">Email<br> 
                  Report</a></span></TD>
                <TD width=\"168\"><span class=\"cat cat\"><a href=\"pay_report.php\" class=\"big\">Payment<br> 
                  Report</a></span></TD>
                <TD width=\"273\"><span class=\"cat cat\"><a href=\"sent_report.php\" class=\"big\">Sent<br> 
                  Report</a></span></TD>
                <TD width=\"273\"><span class=\"cat cat\"><a href=\"main.php\" class=\"big\">Main <br>
                  Page</a></span></TD>
              </TR>
            </TBODY>
          </TABLE>";
		  



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
	//$db = mysql_connect("localhost", "autoparts","11g09e9");
	
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
	//$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$result = mysql_query("SELECT * FROM ben_product_t as p order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
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
	echo "<td><a href =\"prod_mod.php?product_id=$product_id\" >".$product_id."</a></td><td>".$product_name."&nbsp;</td>";
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
	echo "<td>".$cat_name." &nbsp;</td>";
	if ($product_web == 1)
	echo "<td>Yes</td>";
	else
	echo "<td>-</td>";
	
	echo "<td>$product_dit_show &nbsp;</td>";
	echo "<td>$product_location &nbsp;</td>";
	
	echo "<td><a href=\"prod_del.php?product_id=$product_id\" onclick=\"return cDelete()\" >Delete</a></td></tr>\n";
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
	echo "<table width=\"650\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"right\"> <td width='92'>Product ID</td><td width='250'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
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
	return $_cust_name ." (".$_dat.")";
		else
	return "<a href=\".php?sale_ref=".$sale_ref." \">Fill in</a>";
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
//----------------------------------------------------------------------------------------
function getsprod_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	return $row;
	}
	

//--------------------------------------------------------------------------------------

function getprod_cost($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$sql= "select *, sum(sprod_unit*sprod_price) - sale_discount as sprod_total from ben_sale, ben_sale_prod where sprod_ref=sale_ref and sale_ref = '".$sale_ref."' group by sale_ref ";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	
	/*
	if ($row)   		
	return $_cust_name ." (".$_dat.")";
		else
	return "<a href=\".php?sale_ref=".$sale_ref." \">Fill in</a>";
	*/
	//return $sql;
	return $row['sprod_total'];
	}
	
//	------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------

function getorder_list_by_date($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_sale where sale_date between '$date_start' and '$date_end' order by sale_date desc, sale_index DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_sale where sale_group='$user_name' and sale_date between '$date_start' and '$date_end' order by sale_date desc, sale_index DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order date</td><td >Order No.</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td width='60'>Price</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	//payment of product
	$cost_prod=getprod_cost($sale_ref);
	
	if ($sale_tax!='0.00') 
	{$cost_prod=$cost_prod*$sale_tax/100;
	$cost_prod = number_format(round($cost_prod, 0),2,'.','');
	}
	$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
	

	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	$debt_pay_name="";
	$debt_remark="";
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	$debt_remark=$debt_row['debt_remark'];
	
	$debt_pay_name=$debt_row['debt_pay_name'];
	
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
	if ($debt_row['debt_post_co']!='')
	$debt_pos_co = ", ".$debt_row['debt_post_co']; 
	else
	$debt_pos_co = ''; 
	

	
	
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	
	}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	
	$bal_pay_type = $bal_row['bal_pay_type'];
	
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
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
	$ship_bg = "bgcolor=\"#CCCCCC\"";
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";
	
	} else { 
	$ship_ship ='1';
	$ship_date = '';
	$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
	}
	
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
//remark
	
		if ($debt_remark)	
	{$remark = $debt_remark;
	$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">$remark</a>";
	}	
	else

	{$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">Fill in</a>";}
		
		
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td >$cost_prod</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td></tr>\n";
}
	//end loop
	echo "</table>";
	
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
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
function check_record($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_ where _ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$_row=mysql_fetch_array($result);
	
	return $_row;   		
	
	}	
//-------------------------------------------------------------------------------------------

function getorder_list_by_no($sale_ref,$check)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($check == 'sno'){
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	
	if ($check == 'sname'){
	$result = mysql_query("SELECT * FROM ben_sale where sale_name like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	} 
	
	if ($check == 'semail'){
	$result = mysql_query("SELECT * FROM ben_sale where sale_email like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	} 
	
	if ($check == 'syahoo'){
	$result = mysql_query("SELECT * FROM ben_sale where sale_yahoo_id like '%$sale_ref%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	}
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"850\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td width='80'>Order date</td><td width='170'>Order No.</td><td width='200'> Group</td><td width='250'> Note</td><td width='150'>Payment</td><td width='150'>Return</td><td width='150'>Shipping</td></tr>\n";

	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	
	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
		if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
		if ($debt_row['debt_post_co'] != '')
	$debt_pos_co = ", ". $debt_row['debt_post_co']; 
	else
	$debt_pos_co = '';
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ."$debt_pos_co </a><br> $debt_email_sent ";
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
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";
}
	else
	{$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}
	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
	
	
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_group."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$bal_data."</td><td>".$return_data."</td><td>".$ship_data."</td></tr>\n";
	}
	//end loop
	echo "</table>";
		// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
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
	echo "<table width=\"800\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"right\"><td width='80'>Order date</td><td width='120'>Order No.</td><td width='100'>Total Sale</td><td width='100'>Sale</td><td width='100'>Discount</td><td width='100'>Shipping fee</td><td width='100'>Tax</td><td width='100'>Balance</td><td width='100'>Return</td><td>Group</td></tr>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_group=$row["sale_group"];
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
	
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";
}
	else
	{$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
	echo "<tr valign=\"top\" align=\"right\"> <td>".$sale_date."</td><td>".$sale_ref."<br>(".$sale_dat .")</td><td width='120'>".number_format($sale_total)."&nbsp;</td><td>".number_format($sub_total)."&nbsp;</td><td>".number_format($sale_discount)."&nbsp;</td><td>".number_format($sale_ship_fee)."&nbsp;</td><td>".$sale_tax."&nbsp;</td><td width='120'>".$bal_data."</td><td width='120'>".$return_data."&nbsp;</td><td>$sale_group</td></tr>\n";
		
	
	}


	//end loop
	echo "<tr valign=\"top\" align=\"right\"> <td width='92'>&nbsp;</td><td>Total: </td><td>".number_format($sale_total_total)."&nbsp;</td><td>".number_format($sub_total_sale)."</td><td>".number_format($dis_total)."</td><td>".number_format($ship_total)."</td><td>".number_format($tax_total)."</td><td width='120'>".number_format($bal_total)."</td><td width='120'>".number_format($return_total)."&nbsp;</td></tr>\n";
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
	$email_text = $email_text . "はじめまして 高元 と申します<br>このたびは当方の商品を落札いただきありがとうございます。つきましては下<br>
記口座へお振り込みいただきましたら、確認次第発送手配させていただきます。 <br>なお、商品に関する内容はオークション記載の通りです。<br>十分ご納得の上でのお取引をお願いします。<br><br>";

	//$email_text = $email_text . "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	//$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,0,'.','');	
	$email_text = $email_text . "落札商品：".$sprod_name." ".$sprod_id."<br>";
	}
	
	$email_text = $email_text . "ヤフーID：　http://page8.auctions.yahoo.co.jp/jp/auction/".$sale_ref."<br>";
	$email_text = $email_text . "落札金額：".number_format($sprod_sub,0,'.','')."円+";
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	
	$total = number_format($sub_total-$sale_discount,0,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),0,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,0,'.','');
	$total_temp_ship_sub = $sprod_sub + $sale_ship_fee;
	$email_text = $email_text . "送料 ".number_format($sale_ship_fee,0,'.','')."円";
	
	$email_text = $email_text . "= ".number_format($total_temp_ship_sub,0,'.','')."円<br><br>";
	$email_text = $email_text . "早速ですが 振込み確認後発送いたします<br>";
	$email_text = $email_text . "振込み先： ジャパンネット銀行<br>";
	$email_text = $email_text . "支 店 名： 本店営業部<br>";
    $email_text = $email_text . "種    別： 普通<br>";
	$email_text = $email_text . "口座番号： 2505567<br>";
	$email_text = $email_text . "口座名義： 高元　紗知子（たかもと さちこ）<br><br>";
	$email_text = $email_text . "発送準備を円滑に行うため、お手数ですがメール確認後に、商品送付先（郵便番号・住所・名前,�筺砲髻畔嵜�”にて折り返しご連絡ください。<br>";
	$email_text = $email_text . "出来ましたら　振込みされた後　メールにてお知らせしていただけないでしょうか<br><br>";
	$email_text = $email_text . "どうぞ、よろしくおねがいします<br><br>";
	$email_text = $email_text . "高元 紗知子<br>";
    $email_text = $email_text . "newup5918@ybb.ne.jp<br>";  
	  
	return $email_text;
	}
//----------------------------------------------------------------------------
//search product 
function getFind_prod($prod_id)
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product where product_id like '%$prod_id%'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	echo "Select a Product<br><table width=\"450\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
	echo "<tr bgcolor=\"#CCCCCC\"><td width=\"200\">Product ID</td><td width=\"250\">Product Name</td></tr>";
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$product_id=$row["product_id"];
	$product_name=$row["product_name"];
		//align=\"center\" valign=\"middle\"
	echo "<tr >
          
          <td >
              <div align=\"left\"><a href=\"javascript:updateARPORT('$product_id', '$product_name')\">$product_id </a></div>
</td>
          <td ><div align=\"left\">
            $product_name &nbsp;</div>
         </td>
		 </tr>";
      }
	echo "</table> ";
	
	}
	
	//------------------------------------------------------------------
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

function getprod_cat($sel_cat)
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
	if ($sel_cat==$cat_id)
	echo "<option selected value=\"$cat_id\">$cat_name</option>\n";
	else
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
	function getsold_list_date($date_start,$date_end,$sprod_top,$sprod_select)
{
	$total_unit = 0;
	$total_price = 0;
	$db=connectDatabase();
	
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($sprod_top == 1)
	{
	$result =  mysql_query("SELECT *, sum(sprod_unit) as counter FROM ben_sale_prod, ben_sale where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end') group by sprod_id order by counter desc limit 0, $sprod_select  " ,$db);
	}
	else
	{
	$result =  mysql_query("SELECT *, sprod_unit as counter FROM ben_sale_prod, ben_sale where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end')" ,$db);
	
	}
	$num_results=mysql_num_rows($result);
	//echo "SELECT *, sum(sprod_unit) as counter FROM ben_sale_prod, ben_sale where sale_ref=sprod_ref and (sale_date between '$date_start' and '$date_end') group by sprod_id order by counter desc limit 0, $sprod_select  ";
	
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
	$sprod_unit=$row["counter"];
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
	
	function ship_report($access,$user_name,$group3)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_bal, ben_sale, authorize where sale_group=username and group3='$group3' and bal_ref not in (select check_ref from ben_check) and sale_ref=bal_ref order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_bal, ben_sale, authorize where sale_group=username and group3='$group3' and sale_group='$user_name' and bal_ref not in (select check_ref from ben_check) and sale_ref=bal_ref order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Prod ID</td><td >Sale Group</td><td >Client name</td><td >Shipping Type</td><td >Payment Date</td><td >Add Shipping No.</td><td> Remark</td>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$bal_ref=$row["bal_ref"];
	$bal_dat=$row["bal_dat"];
	$sale_group=$row["sale_group"];
	$sale_name=$row["sale_name"];
	$bal_ship_type=$row["bal_ship_type"];
	$row_prod = getsale_prod_data($bal_ref);
	$sprod_id = $row_prod["sprod_id"];
	$row_debt = getdebt_data($bal_ref);
	$debt_remark = '';
	if ($row_debt["debt_remark"]!=""){
	$debt_remark = $row_debt["debt_remark"];}
	
	
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
		
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$bal_ref'>".$sprod_id."</a></td><td>".$sale_group."&nbsp;</td><td>".$sale_name."&nbsp;</td><td>".$bal_ship_type."&nbsp;</td><td>".$bal_dat."</td><td><a href='shipping.php?sale_ref=$bal_ref'>".$bal_ref."</a></td><td>$debt_remark &nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------
//---------------------------------------------------------------
	//shipping report_2 
	
	function ship_report_2($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_bal,ben_sale where bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else 
	$result = mysql_query("SELECT * FROM ben_bal,ben_sale where sale_group='$user_name' and bal_ref = sale_ref and sale_date >= '$date_start' and sale_date <= '$date_end' and bal_ref in (select check_ref from ben_check where check_date = '0000-00-00') order by bal_dat asc" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Prod ID.</td><td >Group</td><td >Client Name</td><td >Payment Date</td><td >Add Shipping No.</td><td >Out Of Stock</td><td>Remark</td>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$bal_ref=$row["bal_ref"];
	$bal_dat=$row["bal_dat"];
	$sale_group=$row["sale_group"];
	$sale_name=$row["sale_name"];
	$row_prod = getsale_prod_data($bal_ref);
	$sprod_id = $row_prod["sprod_id"];
	
	$row_debt = getdebt_data($bal_ref);
	$debt_remark = '';
	if ($row_debt["debt_remark"]!=""){
	$debt_remark = $row_debt["debt_remark"]!="";}
		
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$bal_ref'>".$sprod_id."</a>$debt_remark</td><td>&nbsp;".$sale_group."</td><td>&nbsp;".$sale_name."</td><td>".$bal_dat."</td><td><a href='shipping.php?sale_ref=$bal_ref'>".$bal_ref."</a></td><td >Y</td><td >$debt_remark  &nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------
// ----------------------------------------------------------------------------------	
	function getsale_prod_email_1($sale_ref,$email_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_id DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$sub_total=0;
	$num_results=mysql_num_rows($result);
	$email_text = $email_text . "はじめまして". $email_name ."します<br>このたびは当方の商品を落札いただきありがとうございます。つきましては下<br>
記口座へお振り込みいただきましたら、確認次第発送手配させていただきます。 <br>なお、商品に関する内容はオークション記載の通りです。<br>十分ご納得の上でのお取引をお願いします。<br><br>";

	//$email_text = $email_text . "<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	//$email_text = $email_text . "<tr  align=\"right\"> <td width='92'>Product ID</td><td width='200'>Product name</td><td width='120'>Qty Unti</td><td width='120'>Unit Price</td><td width='120'>Sub </td></tr>\n";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sprod_id=$row["sprod_id"];
	$sprod_name=$row["sprod_name"];
	$sprod_price=$row["sprod_price"];
	$sprod_unit=$row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,0,'.','');	
	$email_text = $email_text . "落札商品：".$sprod_name." ".$sprod_id."<br>";
	}
	
	$email_text = $email_text . "ヤフーID：　http://page8.auctions.yahoo.co.jp/jp/auction/".$sale_ref."<br>";
	$email_text = $email_text . "落札金額：".number_format($sprod_sub,0,'.','')."円+";
	
	$result = mysql_query("SELECT * FROM ben_sale where sale_ref = '".$sale_ref."'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$row=mysql_fetch_array($result);
	$sale_discount=$row["sale_discount"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	
	$total = number_format($sub_total-$sale_discount,0,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),0,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,0,'.','');
	$total_temp_ship_sub = $sprod_sub + $sale_ship_fee;
	$email_text = $email_text . "送料 ".number_format($sale_ship_fee,0,'.','')."円";
	
	$email_text = $email_text . "= ".number_format($total_temp_ship_sub,0,'.','')."円<br><br>";
	$email_text = $email_text . "早速ですが 振込み確認後発送いたします<br>";
	$email_text = $email_text . "振込み先： ジャパンネット銀行<br>";
	$email_text = $email_text . "支 店 名： 本店営業部<br>";
    $email_text = $email_text . "種    別： 普通<br>";
	$email_text = $email_text . "口座番号： 2505567<br>";
	$email_text = $email_text . "口座名義：". $email_name ."（たかもと さちこ）<br><br>";
	$email_text = $email_text . "発送準備を円滑に行うため、お手数ですがメール確認後に、商品送付先（郵便番号・住所・名前,�筺砲髻畔嵜�”にて折り返しご連絡ください。<br>";
	$email_text = $email_text . "出来ましたら　振込みされた後　メールにてお知らせしていただけないでしょうか<br><br>";
	$email_text = $email_text . "どうぞ、よろしくおねがいします<br><br>";
	$email_text = $email_text . $email_name ."<br>";
    $email_text = $email_text . "newup5918@ybb.ne.jp<br>";  
	  
	return $email_text;
	}
//----------------------------------------------------------------------------
function getdebtemail_data($email_Id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_email_list where email_Id = '".$email_Id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	return $row;
	}
	
//-------------------------------------------------------------------------------	
	//email report 
	
	function email_report($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_email,ben_sale where email_ref=sale_ref and DATE(email_datetime) between '$date_start' and '$date_end' order by email_datetime desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_email,ben_sale where sale_group='$user_name' and email_ref=sale_ref and DATE(email_datetime) between '$date_start' and '$date_end' order by email_datetime desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"350\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group</td><td >Email Date</td><td >Detail</td>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$email_ref=$row["email_ref"];
	$email_dat=$row["email_datetime"];
	$email_text=$row["email_text"];
	$email_no=$row["email_no"];
	$sale_group=$row["sale_group"];
	
	
		
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$email_ref'>".$email_ref."</a></td><td>".$sale_group."</td><td>".$email_dat."</td><td ><a target='_blank' href='email_detail.php?email_no=$email_no'>Click</a></td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------
function getemail_detail($email_no)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_email where email_no = '".$email_no."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	return $row;
	}
//-------------------------------------------------------------------------------	
	//pay report 
	
	function pay_report($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_bal, ben_sale where sale_ref=bal_ref and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_bal, ben_sale where sale_group='$user_name' and sale_ref=bal_ref and DATE(bal_dat) between '$date_start' and '$date_end' order by bal_dat desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"350\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group </td><td >Payment Date</td><td >Detail</td>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$bal_ref=$row["bal_ref"];
	$bal_dat=$row["bal_dat"];
	$sale_group=$row["sale_group"];
	
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$bal_ref'>".$bal_ref."</a></td><td>".$sale_group."</td><td>".$bal_dat."</td><td ><a target='_blank' href='balance.php?sale_ref=$bal_ref'>Click</a></td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------	
	//sent report 
	
	function sent_report($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	//echo $username;
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_check, ben_sale where check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_check, ben_sale where sale_group = '$user_name' and check_ref=sale_ref and DATE(check_date) between '$date_start' and '$date_end' order by check_date desc"  ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");

	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order No.</td><td >Sale Group</td><td >Shipping Date</td><td >Tracking No.</td><td >Detail</td><td >Tracking email</td><td >Status</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$check_ref=$row["check_ref"];
	$check_date=$row["check_date"];
	$check_shipping=$row["check_shipping"];
	$check_print=$row["check_print"];
	$sale_group=$row["sale_group"];
	$shipped_status=getemail_shipped_check($check_ref);
	
	
	echo "<tr align=\"right\" valign=\"top\"> <td><a href='order_edit.php?sale_ref=$check_ref'>".$check_ref."</a></td><td>".$sale_group."</td><td>".$check_date."</td><td>".$check_shipping."</td><td ><a target='_blank' href='shipping.php?sale_ref=$check_ref'>Click</a></td><td><a href='ship_email.php?sale_ref=$check_ref' target='_blank'>Preview</td><td>".$shipped_status."&nbsp;</td></tr>\n";
	}
	//end loop
	echo "</table>";
	}
//--------------------------------------------------------------------------	
//=============================================================================
function getmake_selection($temp_make_id)
		{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_make order by make_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table

	echo "<select name='make_id' ONCHANGE=\"goToURL(this.options[this.selectedIndex].value)\">";
	echo "<option value=\"\"></option>";

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$make_id=$row["make_id"];
	$make_name=$row["make_name"];
	
	
	if ($make_id==$temp_make_id)
	{echo "<option value=\"$make_id\" selected>$make_name</option>";}
	else
	{echo "<option value=\"$make_id\">$make_name</option>";}
	

}
	//end loop
	
	echo "</select>";
	}
	
	//==============================================================
	//=============================================================================
function getmodel_selection($make_id)
		{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	
	$result = mysql_query("SELECT * FROM ben_model where make_id = $make_id order by model_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table

	//echo "<select name='model_id' ONCHANGE=\"goToURL(this.options[this.selectedIndex].value)\">";
	echo "<select name='model_id' >";
	
	echo "<option value=\"\"></option>";

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$model_id=$row["model_id"];
	$model_name=$row["model_name"];
	
	
	//if ($model_id==$temp_model_id)
	//{echo "<option value=\"$model_id\" selected>$model_name</option>";}
	//else
	//{
	echo "<option value=\"$model_id\">$model_name</option>";
//}
	

}
	//end loop
	
	echo "</select>";
	}
	
	//==============================================================
function produc_list_web($cat_id,$start,$amount,$model_id,$make_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);

$amount = 6;
$start_with = $start * $amount-6; 
$sql = "SELECT * FROM ben_product as p,ben_make as m1, ben_model as m2 where p.model_id=$model_id and p.make_id=$make_id and p.model_id = m2.model_id and p.make_id = m1.make_id and cat_id='$cat_id' and product_web = '1' order by product_index desc limit $start_with,$amount"; 
$sql2 = "SELECT * FROM ben_product as p,ben_make as m1, ben_model as m2 where p.model_id=$model_id and p.make_id=$make_id and p.model_id = m2.model_id and p.make_id = m1.make_id and cat_id='$cat_id' and product_web = '1' order by product_index"; 

//echo $sql;

	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$result2 = mysql_query($sql2,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	

$per_page = 6;
$page=$start;



 if (!$page) {$page = 1; } 
    $prev_page = $page - 1; 
    $next_page = $page + 1; 
	
	  $page_start = ($per_page * $page) - $per_page; 
    $num_rows = mysql_num_rows($result2);
    if ($num_rows <= $per_page) { 
    $num_pages = 1; 
    } else if (($num_rows % $per_page) == 0) { 
    $num_pages = ($num_rows / $per_page); 
    } else { 
    $num_pages = ($num_rows / $per_page) + 1; 
    } 
    $num_pages = (int) $num_pages; 
   // if (($page > $num_pages) || ($page < 0)) { 
    //error("You have specified an invalid page number"); 
    //} 
    // 
    // Now the pages are set right, we can 
    // perform the actual displaying... 
    if ($prev_page) {
    echo "<a href=\"$PHP_SELF?make_id=$make_id&model_id=$model_id&cat_id=$cat_id&start=$prev_page\"><span class=\"whitefont\">Prev</span></a>";
    }
    // Page # direct links 
    // If you don't want direct links to eac
    //     h page, you should be able to
    // safely remove this chunk.
    for ($i = 1; $i <= $num_pages; $i++) { 
    if ($i != $page) { 
    echo " <a href=\"$PHP_SELF?make_id=$make_id&model_id=$model_id&cat_id=$cat_id&start=$i\"><span class=\"whitefont\">$i</span></a> "; 
    } else { 
    echo " <span class=\"whitefont\">$i</span> "; 
    } 
    } 
    // Next 
    if ($page != $num_pages) { 
    echo "<a href=\"$PHP_SELF?make_id=$make_id&model_id=$model_id&cat_id=$cat_id&start=$next_page\"><span class=\"whitefont\">Next</span></a> ";
    }
	
	echo "<br>";














	//table echo 

echo "<table width=\"404\" border=\"0\">";
	
	//loop
for ($i=0;$i<$num_results;$i++)
{
//	data
$row=mysql_fetch_array($result);
	$model_id=$row["model_id"];
	$model_name=$row["model_name"];
	$make_name==$row["make_name"];
	$product_id=$row["product_id"];
	$product_photo=$row["product_photo"];
	if ($product_photo !='')
	{
	$self_link_photo = 'http://www.superior-autoparts.com/pro_image/' ;
	$product_photo = "<img src=\"".$self_link_photo.$product_photo."\" width=\"200\" border=\"0\">"; }
	
	$product_pcs=$row["product_pcs"];
	$product_colour=$row["product_colour"];
	$product_remark=$row["product_remark"];

//~~

if ($i%2==0)
{echo "<tr>";}

       echo "<td valign=\"top\">
	
	<table width=\"200\" border=\"1\">
            <tr>
              <td colspan=\"2\" valign=\"top\"><span class=\"whitefont\">$mode_name $product_id </span></td>
            </tr>
            <tr>
              <td colspan=\"2\" valign=\"top\"><span class=\"whitefont\">$product_photo</span></td>
            </tr>
            <tr>
              <td valign=\"top\"><span class=\"whitefont\">PCS: $product_pcs</span></td>
              <td valign=\"top\"><span class=\"whitefont\">Color: $product_colour</span></td>
            </tr>
			<tr>
    		<td colspan=\"2\" valign=\"top\"><span class=\"whitefont\">Remark: $product_remark &nbsp;$num_results2</span></td>
  		   </tr>
        </table>
	</td>";

if ($i%2!=0)
{echo "</tr><tr";}
        
}	
      
	//end loop
	echo "</tr></table>";
	}
//--------------------------------------------------------------------------	



function getprod_order($prod_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("select * from ben_sale_prod where sprod_id= '".$prod_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	//$row=mysql_fetch_array($result);

	return $num_results;
	}
	
//----------------------------------------------------------------------------------------
function getprod_shipped($prod_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("select * from ben_sale_prod, ben_check where sprod_ref=check_ref and check_date <> 0000-00-00 and sprod_id= '".$prod_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	//$row=mysql_fetch_array($result);

	return $num_results;
	}
	
//----------------------------------------------------------------------------------------

function getprod_list_out_stock($prod_order,$page_start, $per_page)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
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
	$product_pcs=$row["product_pcs"];
	$product_stock_level=$row['product_stock_level'];
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
	
	
	
	if ($real_stock <= $product_stock_level){
	echo "<tr align=\"center\" valign=\"top\" height=\"25\">";
	echo "<td><a href =\"prod_mod.php?product_id=$product_id\" >".$product_id."</a></td><td>".$product_name."&nbsp;</td>";
	echo "<td>$product_photo_show</td>";
	echo "<td>$real_stock &nbsp;</td>";
	echo "<td>$order_stock &nbsp;</td>";
	echo "<td>$product_colour &nbsp;</td>";
	
	echo "<td>$product_price_u &nbsp;</td>";
	echo "<td>$product_price_s &nbsp;</td>";
	echo "<td>".$cat_name." &nbsp;</td>";
	if ($product_web == 1)
	echo "<td>Yes</td>";
	else
	echo "<td>-</td>";
	
	echo "<td>$product_dit_show</td>";
	echo "<td><a href=\"prod_del.php?product_id=$product_id\" onclick=\"return cDelete()\" >Delete</a></td></tr>\n";
	}
	
	
	}
	
	}
//---------------------------------------------------------------------------------
function getmodel_data($model_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_model where model_id = '".$model_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	echo $row['model_name'];
	}
	
//-------------------------------------------------------------------------------	
//-------------------------------------------------------------------------------------------

function getorder_list_by_filter($sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$date_start,$date_end,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m,$total_price,$access,$user_name)

	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name) {
	$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1 where s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='')
	{$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1, ben_debt as d where d.debt_ref= s.sale_ref and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	}}
	else {
	$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1 where s.sale_group='$user_name' and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='')
	{$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1, ben_debt as d where s.sale_group='$user_name' and d.debt_ref= s.sale_ref and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	}}
	
	if ($debt_cust_address1 != ''){$sql = $sql."and debt_cust_address1 like '%$debt_cust_address1%' ";}	
	if ($debt_cust_address2 != ''){$sql = $sql."and debt_cust_address2 like '%$debt_cust_address2%' ";}	
	if ($debt_post_co != ''){$sql = $sql."and debt_post_co like '%$debt_post_co%' ";}	
	
	
	if ($sale_ref != ''){$sql = $sql."and sale_ref like '%$sale_ref%' ";}	
	if ($sale_name != ''){$sql = $sql."and sale_name like '%$sale_name%' ";}
	if ($sale_email != ''){$sql = $sql."and sale_email like '%$sale_email%' ";}
	if ($sale_yahoo_id != ''){$sql = $sql."and sale_yahoo_id like '%$sale_yahoo_id%' ";}
	
	$sql = $sql."group by sale_ref ";
	if ($min_m != '' and $max_m!='' ){$sql = $sql."having sprod_total >='$min_m' and sprod_total <='$max_m' ";}
	else {
	if ($total_m!='' and $total_price==''){$sql = $sql."having sprod_total = '$total_m'"; } 
	if ($total_price!='' and $total_m==''){$sql = $sql."having price_total = '$total_price'"; } 
	
	}
	$sql = $sql."order by sale_date desc ";
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	//echo $sql;
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order date</td><td >Order No.</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td width='60'>Price</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	//payment of product
	$cost_prod=getprod_cost($sale_ref);
	
	if ($sale_tax!='0.00') 
	{$cost_prod=$cost_prod*$sale_tax/100;
	$cost_prod = number_format(round($cost_prod, 0),2,'.','');
	}
	$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
	

	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	$debt_pay_name="";
	$debt_remark="";
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	$debt_remark=$debt_row['debt_remark'];
	
	$debt_pay_name=$debt_row['debt_pay_name'];
	
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
	if ($debt_row['debt_post_co']!='')
	$debt_pos_co = ", ".$debt_row['debt_post_co']; 
	else
	$debt_pos_co = ''; 
	

	
	
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	
	}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	
	$bal_pay_type = $bal_row['bal_pay_type'];
	
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
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
	$ship_bg = "bgcolor=\"#CCCCCC\"";
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";

	} else { 
	$ship_ship ='1';
	$ship_date = '';
	$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
	}
	
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
//remark
	if ($debt_remark)	
	{$remark = $debt_remark;
	$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">$remark</a>";
	}	
	else

	{$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
		
		
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td >$cost_prod</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td></tr>\n";
}
	//end loop
	echo "</table>";
	
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
	}
	

//--------------------------------------------------------------------------

	function getgroup_select($sel_group)
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM authorize order by username", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	echo "<select name=sale_group>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	//$group_id=$row["group_id"];
	$username=$row["username"];
	if ($sel_group==$username)
	echo "<option selected value=\"$username\">$username</option>\n";
	else
	echo "<option value=\"$username\">$username</option>\n";
	
	}
	echo "</select>";
} 
//----------------------------------------------------------------------------
function getremark_data($remark_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_remark where remark_ref = '".$remark_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	return $row['remark'];
	}
	
//-------------------------------------------------------------------------------	

//--------------------------------------------------------------------------------------------

function getorder_list_by_test($date_start,$date_end)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale where sale_date between '$date_start' and '$date_end' order by sale_date DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=1300 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Order date</td><td >Order No.</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td width='60'>Price</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	//payment of product
	$cost_prod=0;
	$cost_total=0;
	$cost_prod=getprod_cost($sale_ref);
	
	
	if ($sale_tax!='0.00') 
	{$cost_prod=$cost_prod*$sale_tax/100;
	$cost_prod = number_format(round($cost_prod, 0),2,'.','');
	}
	$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
	

	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	$debt_pay_name="";
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	$debt_remark=$debt_row['debt_remark'];
	
	$debt_pay_name=$debt_row['debt_pay_name'];
	
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
	if ($debt_row['debt_post_co']!='')
	$debt_pos_co = ", ".$debt_row['debt_post_co']; 
	else
	$debt_pos_co = ''; 
	

	
	
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	
	}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	
	$bal_pay_type = $bal_row['bal_pay_type'];
	
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
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
	$ship_bg = "bgcolor=\"#CCCCCC\"";
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";

	} else { 
	$ship_ship ='1';
	$ship_date = '';
	$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
	}
	
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
//remark
		if ($debt_remark)	
	{$remark = $debt_remark;
	$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">$remark</a>";
	}	
	else

	{$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
		
		
	echo "<tr align=\"right\" valign=\"top\"> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td >$cost_prod</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td></tr>\n";
}
	//end loop
	echo "</table>";
	
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
	}
	
	
//--------------------------------------------------------------------------
function getsprod_ship_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	echo $row["sprod_id"]."<br>";
	}
}
//==============================================================
function getsprod_ship_prod($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	echo $row["sprod_name"]."<br>";
	}
}
//==============================================================

function getuserlist()
{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM authorize order by username", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	echo "<select name=sale_group>";
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	//$group_id=$row["group_id"];
	$username=$row["username"];
	if ($sel_group==$username)
	echo "<option selected value=\"$username\">$username</option>\n";
	else
	echo "<option value=\"$username\">$username</option>\n";
	
	}
	echo "</select>";
} 
//----------------------------------------------------------------------------

function getemail_txt_data($username)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM authorize where username = '".$username."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	return $row["email_txt"];
	}
}
//=============================================================================
function getmake_web($cat_id,$temp_make_id)
		{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$sql = "SELECT * FROM ben_product as p, ben_make as m where p.make_id=m.make_id and cat_id = '$cat_id' group by m.make_id";
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table

	echo "<select name='make_id' ONCHANGE=\"location=this.options[this.selectedIndex].value\">";
	echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id\">All</option>";

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$make_id=$row["make_id"];
	$make_name=$row["make_name"];
	
	
	if ($make_id==$temp_make_id)
	{echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id&make_id=$make_id\" selected>$make_name</option>";}
	else
	{echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id&make_id=$make_id\">$make_name</option>";}
	

}
	//end loop
	
	echo "</select>";
	}
	
	//==============================================================
//=============================================================================
function getmodel_web($cat_id,$make_id,$temp_model_id)
		{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$sql = "SELECT * FROM ben_make as m, ben_model as m1 where m.make_id=m1.make_id and m.make_id = '$make_id' group by m1.model_id";
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table

	echo "<select name='model_id' ONCHANGE=\"location=this.options[this.selectedIndex].value\">";
	echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id&make_id=$make_id\">All</option>";

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$model_id=$row["model_id"];
	$model_name=$row["model_name"];
	
	
	if ($model_id==$temp_model_id)
	{echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id&make_id=$make_id&model_id=$model_id\" selected>$model_name</option>";}
	else
	{echo "<option value=\"".$_SERVER['PHP_SELF']."?cat_id=$cat_id&make_id=$make_id&model_id=$model_id\">$model_name</option>";}
	

}
	//end loop
	
	echo "</select>";
	}
	
	//==============================================================

function getemail_shipped_check($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_email_shipped where email_ref = '$sale_ref'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$temp ="Sent";
	}
	return $temp;
}
//=============================================================================
function getprod_list_web($prod_order,$page_start, $per_page,$cat_id,$make_id)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($make_id==''){
	$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id and c.cat_id='$cat_id' order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	} else {
	$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id and c.cat_id='$cat_id' and make_id='$make_id' order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	}
	
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
	{$product_photo_show = "<img src=\"image.php?w=200&h=120&name=pro_default_logo.jpg\" border=\"0\" >&nbsp;";}
	else
	{$product_photo_show = "<a href =\"pro_image\\$product_photo\" target=\"_blank\"><img src=\"image.php?w=200&h=120&name=$product_photo\" border=\"0\" ></a>";}
	
	echo "<table width=\"400\" border=1 bordercolor=#cccccf>
  <tr>
    <td bgcolor=\"#570605\" width=\"200\">&nbsp;</td>
    <td bgcolor=\"#570605\" width=\"184\">&nbsp;</td>
  </tr>
  <tr>
    <td align=\"center\" valign=\"top\"><font color='#FFFFFF'>$product_photo_show &nbsp;</font></td>
    <td valign=\"top\"><font color='#FFFFFF'>$product_id<br>$product_name<br>
$product_colour
&nbsp;</font></td>
  </tr>
</table>";
}
	
	}
//---------------------------------------------------------------------------------
function getsale_prod_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$row=mysql_fetch_array($result);
	return $row;
	}
	

//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------

function getorder_list_by_date_delete($date_start,$date_end,$access,$user_name)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name)
	$result = mysql_query("SELECT * FROM ben_sale where sale_date between '$date_start' and '$date_end' order by sale_date desc, sale_index DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	else
	$result = mysql_query("SELECT * FROM ben_sale where sale_group='$user_name' and sale_date between '$date_start' and '$date_end' order by sale_date desc, sale_index DESC" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Delete</td><td >Order date</td><td >Order No.</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td width='60'>Price</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	//payment of product
	$cost_prod=getprod_cost($sale_ref);
	
	if ($sale_tax!='0.00') 
	{$cost_prod=$cost_prod*$sale_tax/100;
	$cost_prod = number_format(round($cost_prod, 0),2,'.','');
	}
	$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
	

	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	$debt_pay_name="";
	$debt_remark="";
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	$debt_remark=$debt_row['debt_remark'];
	
	$debt_pay_name=$debt_row['debt_pay_name'];
	
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
	if ($debt_row['debt_post_co']!='')
	$debt_pos_co = ", ".$debt_row['debt_post_co']; 
	else
	$debt_pos_co = ''; 
	

	
	
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	
	}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	
	$bal_pay_type = $bal_row['bal_pay_type'];
	
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
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
	$ship_bg = "bgcolor=\"#CCCCCC\"";
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";

	} else { 
	$ship_ship ='1';
	$ship_date = '';
	$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
	}
	
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
//remark
	if ($debt_remark)	
	{$remark = $debt_remark;
	$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">$remark</a>";
	}	
	else

	{$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
		
    $delete = "<a href=\"order_main_delete_ref.php?sale_ref=".$sale_ref." \" target=_blank>Delete</a>";	
	
	echo "<tr align=\"right\" valign=\"top\"><td> $delete </td> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td >$cost_prod</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td></tr>\n";
}
	//end loop
	echo "</table>";
	
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
	}
	
	
//-------------------------------------------------------------------------
function getorder_list_by_filter_delete($sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$date_start,$date_end,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m,$total_price,$access,$user_name)

	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	if ($access==Admin_name) {
	$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1 where s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='')
	{$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1, ben_debt as d where d.debt_ref= s.sale_ref and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	}}
	else {
	$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1 where s.sale_group='$user_name' and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	if ($debt_cust_address1!='' or $debt_cust_address2!='' or $debt_post_co!='')
	{$sql = "select *, (sum(sprod_unit*sprod_price) ) as sprod_total, (sum(sprod_unit*sprod_price) + sale_ship_fee ) as price_total from ben_sale as s, ben_sale_prod as s1, ben_debt as d where s.sale_group='$user_name' and d.debt_ref= s.sale_ref and s.sale_ref = s1.sprod_ref and sale_date between '$date_start' and '$date_end' ";
	}}
	
	if ($debt_cust_address1 != ''){$sql = $sql."and debt_cust_address1 like '%$debt_cust_address1%' ";}	
	if ($debt_cust_address2 != ''){$sql = $sql."and debt_cust_address2 like '%$debt_cust_address2%' ";}	
	if ($debt_post_co != ''){$sql = $sql."and debt_post_co like '%$debt_post_co%' ";}	
	
	
	if ($sale_ref != ''){$sql = $sql."and sale_ref like '%$sale_ref%' ";}	
	if ($sale_name != ''){$sql = $sql."and sale_name like '%$sale_name%' ";}
	if ($sale_email != ''){$sql = $sql."and sale_email like '%$sale_email%' ";}
	if ($sale_yahoo_id != ''){$sql = $sql."and sale_yahoo_id like '%$sale_yahoo_id%' ";}
	
	$sql = $sql."group by sale_ref ";
	if ($min_m != '' and $max_m!='' ){$sql = $sql."having sprod_total >='$min_m' and sprod_total <='$max_m' ";}
	else {
	if ($total_m!='' and $total_price==''){$sql = $sql."having sprod_total = '$total_m'"; } 
	if ($total_price!='' and $total_m==''){$sql = $sql."having price_total = '$total_price'"; } 
	
	}
	$sql = $sql."order by sale_date desc ";
	
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	//echo $sql;
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=1400 border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr align=\"right\" valign=\"top\"><td >Delete</td><td >Order date</td><td >Order No.</td><td >Client Yahoo Id.</td><td > Group</td><td width=\'120\'>Client email</td><td width='100'>Client Name</td><td width='150'> Note</td><td width='120'> Client's Payment Name</td><td width='60'>Price</td><td width='60'>Shipping </td><td width='60'>Total</td><td >Payment</td><td width='80'>Return</td><td width='80'>Shipping</td><td width='100'>Remark</td></tr>\n";
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_ref=$row["sale_ref"];
	$sale_date=$row["sale_date"];
	$sale_dat=$row["sale_dat"];
	$sale_name=$row["sale_name"];
	$sale_email=$row["sale_email"];
	$sale_group=$row["sale_group"];
	$sale_yahoo_id=$row["sale_yahoo_id"];
	$sale_ship_fee=$row["sale_ship_fee"];
	$sale_tax=$row["sale_tax"];
	//payment of product
	$cost_prod=getprod_cost($sale_ref);
	
	if ($sale_tax!='0.00') 
	{$cost_prod=$cost_prod*$sale_tax/100;
	$cost_prod = number_format(round($cost_prod, 0),2,'.','');
	}
	$cost_total=number_format($cost_prod+$sale_ship_fee,2,'.','');	
	

	//$_data=get_data($sale_ref);
	//$bal_data=getbal_data($sale_ref);
	//$ship_data=getship_data($sale_ref);
	//  
	$debt_pay_name="";
	$debt_remark="";
	if (getdebt_data($sale_ref)){		
	$debt_row = getdebt_data($sale_ref);
	$debt_remark=$debt_row['debt_remark'];
	
	$debt_pay_name=$debt_row['debt_pay_name'];
	
	if ($debt_row['debt_email_sent'] == '1')
	$debt_email_sent = "Email Sent (" .$debt_row['debt_dat'].")";
	if ($debt_row['debt_post_co']!='')
	$debt_pos_co = ", ".$debt_row['debt_post_co']; 
	else
	$debt_pos_co = ''; 
	

	
	
	
	//change sale_name 
	if ($sale_name=='')
	{$debt_name_t='No Name';}else {$debt_name_t=$sale_name;}
	$debt_data = "<a href=\"debt.php?sale_ref=".$sale_ref." \">". $debt_name_t ." $debt_pos_co </a><br> $debt_email_sent ";
	}
	else
	{$debt_data ="<a href=\"debt.php?sale_ref=".$sale_ref." \">Fill in</a>";
	
	}
	//bal
	if (getbal_data($sale_ref)){		
	$bal_row = getbal_data($sale_ref);
	
	$bal_pay_type = $bal_row['bal_pay_type'];
	
	$bal_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $bal_row['bal_pay'] ."</a><br>$bal_pay_type (".$bal_row['bal_dat'].") ";
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
	$ship_bg = "bgcolor=\"#CCCCCC\"";
	$ship_data = "<a href=\"shipping.php?sale_ref=".$sale_ref." \">".$ship_row['check_shipping']." ".$ship_row['check_shipping_jp']."</a><br>$ship_print $ship_ship <br>$ship_date";

	} else { 
	$ship_ship ='1';
	$ship_date = '';
	$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";
	}
	
	}
	else
	{$ship_bg='';
	$ship_data ="<a href=\"shipping.php?sale_ref=".$sale_ref." \">Fill in</a><br>$ship_print";}

	
	
//return 
	if (getreturn_data($sale_ref)){		
	$return_row = getreturn_data($sale_ref);
	if ($return_row['return_date'] != NULL  or $return_row['return_pay'] != 0){
	if ($return_row['return_date'] != NULL){
	$return_sent = "Re-Sent (". $return_row['return_date'] .")";}
	else {$return_sent = "";}
	$return_data = "<a href=\"balance.php?sale_ref=".$sale_ref." \">&yen;". $return_row['return_pay'] ."</a><br>$return_sent";
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	}
	else
	{$return_data ="<a href=\"balance.php?sale_ref=".$sale_ref." \">No Return</a>";}
	
	//----------------
	$sale_edit = "<a href=\"order_edit.php?sale_ref=".$sale_ref." \">$sale_ref </a>";
//remark
		if ($debt_remark)	
	{$remark = $debt_remark;
	$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">$remark</a>";
	}	
	else

	{$remark ="<a href=\"remark.php?sale_ref=".$sale_ref." \">Fill in</a>";}
	
		
	$delete = "<a href=\"order_main_delete_ref.php?sale_ref=".$sale_ref." \" target=_blank>Delete</a>";	
	echo "<tr align=\"right\" valign=\"top\"><td> $delete </td> <td>".$sale_date."</td><td>".$sale_edit."<br> $sale_yahoo_id (".$sale_dat .")</td><td >".$sale_yahoo_id."&nbsp;</td><td >".$sale_group."&nbsp;</td><td width=\"100\" style=\"word-wrap:break-word;\">".$sale_email."&nbsp;</td><td >".$sale_name."&nbsp;</td><td>".$debt_data."&nbsp;</td><td>".$debt_pay_name."&nbsp;</td><td >$cost_prod</td><td >$sale_ship_fee</td><td >$cost_total</td><td>".$bal_data."</td><td>".$return_data."</td><td $ship_bg >".$ship_data."</td><td >".$remark."&nbsp;</td></tr>\n";
}
	//end loop
	echo "</table>";
	
// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);
	}
	

//--------------------------------------------------------------------------
function getreport_top($date_start,$date_end,$sale_top,$sale_select)
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
	$sql = "select sum(sprod_price * sprod_unit + sprod_price*sprod_unit*sale_tax/100 + sale_ship_fee - sale_discount) as price, sale_group, count(sale_ref) as counter from ben_sale, ben_sale_prod where sale_ref=sprod_ref and sale_date between '$date_start' and '$date_end' GROUP by sale_group order by price desc limit 0, $sale_select";
	//echo $sql;
	$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
	
	$num_results=mysql_num_rows($result);
	//table echo 
	echo "<table width=\"500\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<tr valign=\"top\" align=\"left\"><td>Group</td><td>Total Sale</td><td>Order</td></tr>\n";
	
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	$sale_group=$row["sale_group"];
	$sale_price=$row["price"];
	$counter=$row["counter"];
		
	
	
	echo "<tr valign=\"top\" align=\"left\"> <td>".$sale_group."</td><td>".number_format($sale_price,2,'.','')."</td><td>$counter</td><tr>";
			
	
	}


	//end loop

	echo "</table>";
	}
	
	//---------------------------
	function getgroup_sale_data($sale_ref)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	$result = mysql_query("select * from authorize, ben_sale where username=sale_group and sale_ref='".$sale_ref."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	
	for ($i=0;$i<$num_results;$i++)
	{
	$row=mysql_fetch_array($result);
	return $row;
	}
}
/*
function getprod_list_t($prod_order,$page_start, $per_page)
	{
	$db=connectDatabase();
	mysql_select_db("SUPERIOR_AUTOPARTS",$db);
	//$result = mysql_query("SELECT * FROM ben_product as p, ben_cat as c where p.cat_id = c.cat_id order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$result = mysql_query("SELECT * FROM ben_product_t as p order by ". $prod_order." asc LIMIT $page_start, $per_page",$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	
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
	$product_pcs=$row["product_pcs"];
	$product_stock_level=$row['product_stock_level'];
	$product_stock_jp=$row['product_stock_jp'];
	
	$product_location=$row['product_location'];
	
	$product_colour=$row["product_colour"];
	$product_web=$row["product_web"];
	
	product_made=$row["product_made"];
	$product_model=$row["product_model"];
	$product_model_no=$row["product_model_no"];
	$product_cat=$row["product_cat"];
	$product_cat=$row["product_yahoo_last_price"];
	$product_cat=$row["product_cost"];
	
	
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
	echo "<td><a href =\"prod_mod.php?product_id=$product_id\" >".$product_id."</a></td><td>".$product_name."&nbsp;</td>";
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
	echo "<td>".$cat_name." &nbsp;</td>";
	if ($product_web == 1)
	echo "<td>Yes</td>";
	else
	echo "<td>-</td>";
	
	echo "<td>$product_dit_show &nbsp;</td>";
	echo "<td>$product_location &nbsp;</td>";
	
	echo "<td><a href=\"prod_del.php?product_id=$product_id\" onclick=\"return cDelete()\" >Delete</a></td></tr>\n";
	}
	
	}
*/

?>

