          <TD vAlign=top bgColor=#eefafc>
          
	<FORM  name="form1" id="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
	<table width="777" border="0" cellspacing="10">
   		<input name="page" type="hidden" id="page" value="<?=$page?>">
        <input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">

              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">
                
                <tr>

                    <td width="100">Invoice ID: </td>

                    <td width="210"><input name="invoice_id" type="text" id="invoice_id" value="<?=$invoice_id?>"></td>

                    <td>&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

                  <tr>

                    <td width="100">Customer Name: </td>

                    <td width="210"><input name="cust_name" type="text" id="cust_name" value="<? echo $cust_name;?>"></td>

                    <td width="34">&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                  </tr>

                  <tr>

                    <td width="100">Email:</td>

                    <td width="268"><input name="cust_email" type="text" id="cust_email" value="<? echo $cust_email;?>"></td>

                    <td>&nbsp;</td>

                    <td>Address: </td>

                    <td><input name="cust_address" type="text" id="cust_address" value="<? echo $cust_address;?>">                            </td>
                  </tr>

                  <tr>

                    <td>Tel:</td>

                    <td><input name="cust_tel" type="text" id="cust_tel" value="<? echo $cust_tel;?>" ></td>

                    <td>&nbsp;</td>

                    <td>Fax:</td>

                    <td><input name="cust_fax" type="text" id="cust_fax" value="<? echo $cust_fax;?>" ></td>
                  </tr>
                  
                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

                  <tr>

                    <td>Product No</td>

                    <td><input name="prod_no" type="text" id="prod_no" value="<? echo $prod_no;?>" ></td>

                    <td>&nbsp;</td>

                    <td>Colour</td>

                    <td><input name="prod_colour" type="text" id="prod_colour" value="<? echo $prod_colour;?>" ></td>
                  </tr>
                  
                  <tr>

                    <td>Make</td>

                    <td><input name="prod_make" type="text" id="prod_make" value="<? echo $prod_make;?>" ></td>

                    <td>&nbsp;</td>

					<td>Model</td>
                     
                    <td><input name="prod_model" type="text" id="prod_model" value="<? echo $prod_model;?>" ></td>
                  </tr>
                  
                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>

                    <td>Qty</td>

                    <td><input name="qty" type="text" id="qty" value="<? echo $qty;?>" ></td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

                  <tr>

                    <td>Price Total:<br>

                      Min</td>

                    <td><input name="min_price" type="text" id="min_price" value="<? echo $min_price;?>"></td>

                    <td>&nbsp;</td>

                    <td>Price Total:<br> 

                      Max</td>

                    <td><input name="max_price" type="text" id="max_price" value="<? echo $max_price;?>"></td>
                  </tr>
                  
                  <tr>
                    <td>Invoice Date:<td><input id = "invoice_date_min" name="invoice_date_min" type="text" value="<? echo $invoice_date_min; ?>" />
                    <input name="cal1" type="button" id="cal_id_1" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "invoice_date_max" name="invoice_date_max" type="text" value="<? echo $invoice_date_max; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
			      </tr>
                   
                   <tr>
                    <td>Entry Date:<td><input id = "entry_date_min" name="entry_date_min" type="text" value="<? echo $entry_date_min; ?>" />
                    <input name="cal3" type="button" id="cal_id_3" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "entry_date_max" name="entry_date_max" type="text" value="<? echo $entry_date_max; ?>" />
                    <input name="cal4" type="button" id="cal_id_4" value=".."   />
				   </tr>
                </table>

                <br>

                <br>                

                <input name="issearch" type="submit" id="issearch" value="Search">
                <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
                </p>
             
				  <br></td>

              </tr>

            </table>
             </form>
             
             <?
				getInvoice_list('N');
			?>

            <p>&nbsp;</p>

            </TD>

<script type="text/javascript">

	function createCSV() {
		var searchKey = '';
		var elem =document.getElementById("form1");
		for (var i=0;i<elem.length;i++) {
			searchKey = searchKey + elem.elements[i].name + '=' + elem.elements[i].value + '&';
		}
		window.open('<?=$page?>/invoice_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	Calendar.setup(
	{
		inputField  : "invoice_date_min",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_1"       // ID of the button      
	}
	);
	
	Calendar.setup(
	{
		inputField  : "invoice_date_max",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_2"       // ID of the button      
	}
	);

	Calendar.setup(
	{
	inputField  : "entry_date_min",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_3"       // ID of the button
	}
	);
	
	Calendar.setup(
	{
	inputField  : "entry_date_max",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_4"       // ID of the button
	}
	);
</script>