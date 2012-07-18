          <TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
	<table width="777" border="0" cellspacing="10">
   		<input name="page" type="hidden" id="page" value="<?=$page?>">
        <input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">

              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">
                <tr>

                    <td width="100">PO ID: </td>

                    <td width="210"><input name="po_id" type="text" id="po_id" value="<?=$po_id?>"></td>

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

                    <td width="100">Supplier Name: </td>

                    <td width="210"><input name="supp_name" type="text" id="supp_name" value="<? echo $supp_name;?>"></td>

                    <td width="34">&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                    <td>&nbsp;</td>
                    
                  </tr>

                  <tr>

                    <td width="100">Email:</td>

                    <td width="268"><input name="supp_email" type="text" id="supp_email" value="<? echo $supp_email;?>">                        </td>

                    <td>&nbsp;</td>

                    <td>Address: </td>

                    <td><input name="supp_address" type="text" id="supp_address" value="<? echo $supp_address;?>">                            </td>
                  </tr>

                  <tr>

                    <td>Tel:</td>

                    <td><input name="supp_tel" type="text" id="supp_tel" value="<? echo $supp_tel;?>" ></td>

                    <td>&nbsp;</td>

                    <td>Fax:</td>

                    <td><input name="supp_fax" type="text" id="supp_fax" value="<? echo $supp_fax;?>" ></td>
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
                    <td>PO Date:<td><input id = "po_date_min" name="po_date_min" type="text" value="<? echo $po_date_min; ?>" />
                    <input name="cal1" type="button" id="cal_id_1" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "po_date_max" name="po_date_max" type="text" value="<? echo $po_date_max; ?>" />
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
                
				  <br></td>

              </tr>

            </table>
             </form>
             <?
				getPO_list('N');
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
		window.open('<?=$page?>/po_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	Calendar.setup(
	{
		inputField  : "po_date_min",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_1"       // ID of the button      
	}
	);
	
	Calendar.setup(
	{
		inputField  : "po_date_max",         // ID of the input field
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