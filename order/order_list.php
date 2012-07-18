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

                    <td> <select name="sts" id="sts">
		<option value=""> </option>
		 <option value="A" >Active</option>
		<option value="C" >Cancel</option>
		<option value="B" >Back</option>
		</select>
</td>

                    <td>&nbsp;</td>

                    <td></td>

                    <td></td>

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

    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>&nbsp;</td>

    <td width="16">To </td>

    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>&nbsp;</td>

  </tr>

</table>

                <br>

                <br>

   

  <input name="Submit" type="submit" value="Check / Edit Record">
  <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
  <input name="genBackOrderCSV" type="button" id="genBackOrderCSV" value="Generate CSV (Status = B)" onclick="createBackOrderCSV()">			

             </FORM>   </p>

                 <? 

				 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) ) {
					$today = date("Y-m-d"); 
					$today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
					
					if (!isset($_SESSION['date_start'])) {
						getOrderListByDate($today_10,$today,$group2, $user_name);
					}
					else{
						getOrderListByDate($_SESSION['date_start'],$_SESSION['date_end'],$group2, $user_name);
					}
				}				   
				
				if (isset($_GET['date_start']) and isset($_GET['date_end']) and !isset($_GET['issearch'])) {
					$_SESSION['date_start'] = $_GET['date_start'];
					$_SESSION['date_end'] = $_GET['date_end'];
					getOrderListByDate($_SESSION['date_start'],$_SESSION['date_end'],$group2, $user_name);
				 }
				 
				 if (isset($_GET['issearch'])) {
				 	$today = date("Y-m-d"); 
					$today_60 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-150,date("Y")));
					
					getOrderListByFilter($sale_ref, $sale_name,$sale_email,$sale_yahoo_id,$today_60,$today,$min_m,$max_m,$debt_cust_address1,$debt_cust_address2,$debt_post_co,$total_m, $total_price,$group2, $user_name,$prod_cd,$client_tel,$sts);
				 }

				 ?>

                 

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