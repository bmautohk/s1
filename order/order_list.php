<?

$start_date = date("Y-m-d");
$end_date = date("Y-m-d");

$isGetOrderByDate = true;
if (!isset($_GET['date_start']) and !isset($_GET['date_end']) ) {

    if (!isset($_SESSION['date_start'])) {
        $start_date = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
        $end_date = date("Y-m-d");
    }
    else{
        $start_date = $_SESSION['date_start'];
        $end_date = $_SESSION['date_end'];
    }
}

if (isset($_GET['date_start']) and isset($_GET['date_end']) and !isset($_GET['issearch'])) {
    $_SESSION['date_start'] = $_GET['date_start'];
    $_SESSION['date_end'] = $_GET['date_end'];
    
    $start_date = $_SESSION['date_start'];
    $end_date = $_SESSION['date_end'];
}

if (isset($_GET['issearch'])) {
    $isGetOrderByDate = false;
    $start_date = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-150,date("Y")));
    $end_date = date("Y-m-d"); 
}

?>

<style type='text/css'>   
 .backgroundRed { color: red; 
 font-weight: bold;}
 </style>
<script>
  setInterval(function(){
       //$("#divtoBlink").toggleClass("backgroundRed");
		 $("[id=divtoBlink]").toggleClass("backgroundRed");
     },1000)
</script>

 <TD vAlign=top bgColor=#eefafc>

     

            <table width="777" border="0" cellspacing="10">

              <tr>

                <td><p> <FORM method="GET" action="<?= $_SERVER['PHP_SELF']; ?>	">
                <input type="hidden" name="page" id="page" value="<?=$page?>" />
                <input type="hidden" name="subpage" id="subpage" value="<?=$subpage?>" />

				<table width="647" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td width="100">Auction ID : </td>

                    <td width="210"><input name="sale_ref" type="text" id="sale_ref" value="<? echo $sale_ref;?>"></td>

                    <td width="34">&nbsp;</td>

                    <td width="100">Email:</td>

                    <td width="268"><input name="sale_email" type="text" id="sale_email" value="<? echo $sale_email;?>">

                        </td>

                  </tr>

                  <tr>

                    <td>Client Name : </td>

                    <td><input name="sale_name" type="text" id="sale_name" value="<? echo $sale_name;?>">

                      </td>

                    <td>&nbsp;</td>

                    <td>Client Yahoo ID : </td>

                    <td><input name="sale_yahoo_id" type="text" id="sale_yahoo_id" value="<? echo $sale_yahoo_id;?>">

                            </td>

                  </tr>
					
						<tr>
                     <td>Product No. : </td>
					  <td><input name="prod_cd" type="text" id="prod_cd" value="<? echo $prod_cd;?>">

                      </td><td></td>
					  <td> Client Tel : </td>
					<td> <input name="client_tel" type="text" id="client_tel" value="<? echo $client_tel;?>"> </td>
					  </tr>
                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td>Address 1:</td>

                    <td><input name="debt_cust_address1" type="text" value="<? echo $debt_cust_address1;?>" ></td>

                    <td>&nbsp;</td>

                    <td>Address 2:</td>

                    <td><input name="debt_cust_address2" type="text" value="<? echo $debt_cust_address2;?>" ></td>

                  </tr>

                  <tr>

                    <td>Post code </td>

                    <td><input name="debt_post_co" type="text" value="<? echo $debt_post_co;?>" ></td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td>Price Total:<br>

                      Min</td>

                    <td><input name="min_m" type="text" value="<? echo $min_m;?>"></td>

                    <td>&nbsp;</td>

                    <td>Price Total:<br> 

                      Max</td>

                    <td><input name="max_m" type="text" value="<? echo $max_m;?>"></td>

                  </tr>

                  <tr>

                    <td>Product Total:</td>

                    <td><input name="total_m" type="text" value="<? echo $total_m;?>"></td>

                    <td>&nbsp;</td>

                    <td>Price Total : </td>

                    <td><input name="total_price" type="text" value="<? echo $total_price;?>"></td>

                  </tr>

		<tr>

        <td>Order status:</td>
		<td>
			 <select name="sts" id="sts">
			<option value=""> </option>
			 <option value="A" >Active</option>
			<option value="C" >Cancel</option>
			<option value="B" >Back</option>
			<option value="O" >Out of Stock</option>
			</select>
		</td>
		<td></td>
        <td>Payment:</td>
		<td><select name="nopayment" id="nopayment">
		<option value=""> </option>
		<option value="nopayment" >No Payment</option>
	 
		</select>
		</td>
		</tr>
		
		<tr>

        <td></td>
		<td></td>
		<td></td>
        <td>Shipping No.:</td>
		<td><input type="text" name="check_shipping_jp" value=""></td>
		</tr>
                </table>

                <br>

                <br>                

                <input name="issearch" type="submit" id="issearch" value="Search" />

                <br>

				<br>

				<table width="406" border="0">

  <tr>

    <td width="30">From</td>

    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD', '<?=$start_date ?>')</script>&nbsp;</td>

    <td width="16">To </td>

    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD', '<?=$end_date ?>')</script>&nbsp;</td>

  </tr>

</table>

                <br>

                <br>

   

  <input name="Submit" type="submit" value="Check / Edit Record">
  <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
  <input name="genBackOrderCSV" type="button" id="genBackOrderCSV" value="Generate CSV (Status = B)" onclick="createBackOrderCSV()">
			

             </FORM>   </p>

                 <? 

				 if (!$isGetOrderByDate) {
					$input_sale_ref = $sale_ref;
					if (isset($hide_sale_ref)) {
						$input_sale_ref = $hide_sale_ref;
					}
					
					getOrderListByFilter($input_sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$start_date,$end_date,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m, $total_price,$group2, $user_name,$prod_cd,$client_tel,$sts,$nopayment,$check_shipping_jp);

				}
                else if ($isGetOrderByDate) {
                    $orders = getOrderListByDate($start_date,$end_date,$group2, $user_name);
                ?>
                 	<table width="1400" border="1" cellspacing="0" cellpadding="0">
                 		<tr align="right" valign="top">
                 			<td>Order date</td>
                 			<td>Auction ID</td>
                 			<td>Client Yahoo Id.</td>
                 			<td> Group</td>
                 			<td width='120'>Client email</td>
                 			<td width='100'>Client Name</td>
                 			<td width='150'> Note</td>
                 			<td width='120'> Client's Payment Name</td>
                 			<td>Product No.</td>
                 			<td width='60'>Price</td>
                            <td width='60'>&#x20;&#x984F;&#x8272;</td>
							<td width='60'>Qty</td>
                 			<td width='60'>Shipping </td>
                 			<td width='60'>Total</td>
                 			<td >Payment</td>
                 			<td width='80'>Return</td>
                 			<td width='80'>Shipping</td>
                 			<td width='100'>Remark</td>
                 			<td>Order Status</td>
                 		</tr>
                 		<? foreach ($orders as $order) {?>
                 			<tr align="right" valign="top">
                 				<td><?=$order['sale_date'] ?></td>
                 				<td><a href="index.php?page=order&subpage=edit&sale_ref=<?=$order['sale_ref'] ?>"><?=$order['sale_ref'] ?> </a><br><?=$order['sale_yahoo_id'] ?>(<?=$order['sale_dat'] ?>)</td>
                 				<td><?=$order['sale_yahoo_id'] ?>&nbsp;</td>
                 				<td><?=$order['sale_group'] ?>&nbsp;</td>
                 				<td width="100" style="word-wrap:break-word;"><?=$order['sale_email'] ?>&nbsp;</td>
                 				<td><?=$order['sale_name'] ?>&nbsp;</td>
                 				<td>
                 					<? if ($order['debt_data'] != NULL) { ?>
                 						<a href="index.php?page=order&subpage=debt&sale_ref=<?=$order['sale_ref'] ?>"><?=$order['debt_data']['debt_name_t'].$order['debt_data']['debt_pos_co'] ?></a><br><?=$order['debt_data']['debt_email_sent'] ?> 
                 					<? } else {?>
                 						<a href="index.php?page=order&subpage=debt&sale_ref=<?=$order['sale_ref'] ?>">Fill in</a>
                 					<? }?>
                 				</td>
                 				<td><?=$order['debt_pay_name'] ?>&nbsp;</td>
                 				<td><?=$order['sale_prod_id'] ?></td>
                 				<td><?=$order['product_price'] ?></td>
                                <td><?=$order['sprod_colour'] ?></td>
								<td><?=$order['sprod_unit']?></td>
                 				<td><?=$order['sale_ship_fee'] ?></td>
                 				<td><?=$order['cost_total'] ?></td>
                 				<td>
	                 				<?
 
									if (is_null($order['bal_data']['bal_pay'])==false) {?>
	                 					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$order['sale_ref'] ?>">&yen;<?=$order['bal_data']['bal_pay'] ?></a><br>
	                 					<? 	switch($order['bal_data']['bal_pay_type']) {
	                 							case "Store":
	                 								echo mb_convert_encoding('コンビニ決済', "EUC-JP","UTF-8");
	                 								break;
                 								case "Credit Card":
                 									echo mb_convert_encoding('クレカ決済', "EUC-JP","UTF-8");
                 									break;
                 								case "Card":
                 									echo mb_convert_encoding('カード決済', "EUC-JP","UTF-8");
                 									break;
                 								case "Rakuten":
                 									echo mb_convert_encoding('楽天Edy決済', "EUC-JP","UTF-8");
                 									break;
                 								default:
                 									echo $order['bal_data']['bal_pay_type'];
	                 						} 
	                 					?> (<?=$order['bal_data']['bal_dat'] ?>)
	                 				<? } else {?>
	                 					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$order['sale_ref'] ?>">Fill in</a>
	                 				<? }?>
                 				</td>
                 				<td>
                 					<? if ($order['return_data'] != NULL) {?>
                 						<a href="index.php?page=order&subpage=balance&sale_ref=<?=$order['sale_ref'] ?>">&yen;<?=$order['return_data']['return_pay'] ?></a><br><?=$order['return_data']['return_sent'] ?>
                 					<? } else { ?>
                 						<a href="index.php?page=order&subpage=balance&sale_ref=<?=$order['sale_ref'] ?>">No Return</a>
                 					<? }?>
                 				</td>
                 				<? if ($order['ship_data'] != NULL) {?>
                 					<td bgcolor="#CCCCCC">
                 						<a href="index.php?page=order&subpage=shipping&sale_ref=<?=$order['sale_ref'] ?>"><?=$order['ship_data']['check_shipping'].' '.$order['ship_data']['check_shipping_jp'] ?></a><br>
                 						<?=$order['ship_print'] ?> Shipped<br>(<?=$order['ship_data']['check_date'] ?>)
                 					</td>
                 				<? } else {?>
                 					<td>
                 						<a href="index.php?page=order&subpage=shipping&sale_ref=<?=$order['sale_ref'] ?>">Fill in</a><br><?=$order['ship_print'] ?>
                 					</td>
                 				<? }?>
                 				<td>
                 					<? if ($order['remark'] != NULL) {?>
                 						<a href="index.php?page=order&subpage=remark&sale_ref=<?=$order['sale_ref'] ?>"><?=$order['remark'] ?></a>
                 					<? } else { ?>
                 						<a href="index.php?page=order&subpage=remark&sale_ref=<?=$order['sale_ref'] ?>">Fill in</a>
                 					<? }?>
                 				</td>
                 				<td ><font <?php if ($order['sale_sts']=="O") {echo "id='divtoBlink'";$order['sale_sts']="OUT";}?>><?=$order['sale_sts'] ?></font> </td>
                 			</tr>
                 		<? }?>
                 	</table>
                 <? }?>

				  <br></td>

              </tr>

            </table>

            <p>&nbsp;</p>

            </TD>
            
<script type="text/javascript">
	function createCSV() {
		var date_start = document.forms[0].date_start.value;
		var date_end = document.forms[0].date_end.value;
		var searchKey = 'date_start=' + date_start + '&date_end=' + date_end;
		window.open('<?=$page?>/order_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	function createBackOrderCSV() {
		var date_start = document.forms[0].date_start.value;
		var date_end = document.forms[0].date_end.value;
		var searchKey = 'date_start=' + date_start + '&date_end=' + date_end + '&status=B';
		window.open('<?=$page?>/order_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}
</script>
