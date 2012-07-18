          <TD vAlign=top bgColor=#eefafc>
          
          <FORM method="GET" name="form1" id="form1" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
   <table width="777" border="0" cellspacing="10">
		<input name="page" type="hidden" id="page" value="<?=$page?>">
        <input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">

              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">
                	<tr>
                    	<td>Stock ID:</td><td><input id = "stock_id" name="stock_id" type="text" value="<? echo $stock_id; ?>" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>                
                  <tr>
                    <td>Stock Date:</td><td><input id = "stock_date_min" name="stock_date_min" type="text" value="<? echo $stock_date_min; ?>" />
                    <input name="cal1" type="button" id="cal_id_1" value=".."   /></td>
                    <td>To</td>
                    <td>&nbsp;</td>
                    <td><input id = "stock_date_max" name="stock_date_max" type="text" value="<? echo $stock_date_max; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
			      </tr>
                </table>

                <br>

                <br>                

                <input name="issearch" type="submit" id="issearch" value="Search">
                <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">

                </p>
                </td>

              </tr>

            </table>
             </form>
             
             <?
				getStock_list('N');
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
		window.open('<?=$page?>/stock_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	Calendar.setup(
	{
		inputField  : "stock_date_min",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_1"       // ID of the button      
	}
	);
	
	Calendar.setup(
	{
		inputField  : "stock_date_max",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime      :    true,
		button      : "cal_id_2"       // ID of the button      
	}
	);

</script>