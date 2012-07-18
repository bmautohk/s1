          <TD vAlign=top bgColor=#eefafc>
          
	<FORM method="GET" name="form1" id="form1" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
	<table width="777" border="0" cellspacing="10">
    	<input name="page" type="hidden" id="page" value="<?=$page?>">
        <input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">

              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100">Ship ID: </td>
                        <td width="210"><input name="ship_id" type="text" id="ship_id" value="<?=$ship_id?>"></td>
                    </tr>
                    <tr>
                        <td>Product ID</td>                    
                        <td><input name="product_cd" type="text" id="product_cd" value="<?=$product_cd?>"></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Warehouse</td>                    
                        <td>
                        <input name="wareHouseCode[]" type="checkbox" value="J1" <? if (isset($wareHouseCode['J1'])) {?>  checked="checked" <? }?>/>3ÃúÌÜ
                        <input name="wareHouseCode[]" type="checkbox" value="J2" <? if (isset($wareHouseCode['J2'])) {?>  checked="checked" <? }?>/>±ºÅÄ
                        <input name="wareHouseCode[]" type="checkbox" value="HK" <? if (isset($wareHouseCode['HK'])) {?>  checked="checked" <? }?>/>HK
                        <input name="wareHouseCode[]" type="checkbox" value="CN" <? if (isset($wareHouseCode['CN'])) {?>  checked="checked" <? }?>/>China</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Min Qty</td>                    
                        <td><input name="min_qty" type="text" id="min_qty" value="<?=$min_qty?>"></td>
                        <td>&nbsp;</td>
                        <td>Max Qty</td>
                        <td><input name="max_qty" type="text" id="max_qty" value="<?=$max_qty?>"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>                    
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                  <tr>
                    <td>Ship Date:<td><input id = "ship_date_min" name="ship_date_min" type="text" value="<? echo $ship_date_min; ?>" />
                    <input name="cal1" type="button" id="cal_id_1" value=".."   />
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "ship_date_max" name="ship_date_max" type="text" value="<? echo $ship_date_max; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
			      </tr>
                </table>

                <br>

                <br>                

                <input name="issearch" type="submit" id="issearch" value="Search">
                <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
                </p></td>

              </tr>

            </table>
             </form>
             
             <?
				get_list('N');
			?>

            <p>&nbsp;</p>

            </TD>

<script type="text/javascript">

	function createCSV() {
		var searchKey = '';
		var elem =document.getElementById("form1");
		for (var i=0;i<elem.length;i++) {
			if (elem.elements[i].name != 'wareHouseCode[]') {
				searchKey = searchKey + elem.elements[i].name + '=' + elem.elements[i].value + '&';
			}
		}
		
		// Warehouse
		
		elem =document.form1.elements["wareHouseCode[]"];
		for (var i=0;i<elem.length;i++) {
			if (elem[i].checked) {
				searchKey = searchKey + 'wareHouseCode[]' + '=' + elem[i].value + '&';
			}
		}
		
		window.open('<?=$page?>/po_ship_list_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	Calendar.setup(
	{
		inputField  : "ship_date_min",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_1"       // ID of the button      
	}
	);
	
	Calendar.setup(
	{
		inputField  : "ship_date_max",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_2"       // ID of the button      
	}
	);

</script>