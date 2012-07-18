          <TD vAlign=top bgColor=#eefafc>
          
          <FORM name="form1" id="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
   <table width="777" border="0" cellspacing="10">
		<input name="page" type="hidden" id="page" value="<?=$page?>">
        <input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">
              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td width="100">PO No: </td>

                    <td width="210"><input name="po_no" type="text" id="po_no" value="<? echo $po_no;?>"></td>

                    <td width="34">&nbsp;</td>
                    
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

                    <td width="100">Shipping Batch:</td>

                    <td width="268"><input name="shipping_batch" type="text" id="shipping_batch" value="<? echo $shipping_batch;?>"></td>

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
                    <td>Delivery Date:<td><input id = "del_date_min" name="del_date_min" type="text" value="<? echo $del_date_min; ?>" />
                    <input name="cal1" type="button" id="cal_id_1" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "del_date_max" name="del_date_max" type="text" value="<? echo $del_date_max; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
			      </tr>
                   
                   <tr>
                    <td>Complete Date:<td><input id = "comp_date_min" name="comp_date_min" type="text" value="<? echo $comp_date_min; ?>" />
                    <input name="cal3" type="button" id="cal_id_3" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "comp_date_max" name="comp_date_max" type="text" value="<? echo $comp_date_max; ?>" />
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
		window.open('<?=$page?>/po_ship_report_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	Calendar.setup(
	{
		inputField  : "del_date_min",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_1"       // ID of the button      
	}
	);
	
	Calendar.setup(
	{
		inputField  : "del_date_max",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_2"       // ID of the button      
	}
	);

	Calendar.setup(
	{
	inputField  : "comp_date_min",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_3"       // ID of the button
	}
	);
	
	Calendar.setup(
	{
	inputField  : "comp_date_max",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_4"       // ID of the button
	}
	);
</script>