          <TD vAlign=top bgColor=#eefafc>
          
          <FORM name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
   <table width="777" border="0" cellspacing="10">

              <tr>

                <td><p> 

				<table width="647" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td width="100">Product Code : </td>

                    <td width="210"><input name="product_cd" type="text" id="product_cd" value="<? echo $product_cd;?>"></td>

                    <td width="34">&nbsp;</td>
                    
                    <td><input name="issearch" type="submit" id="issearch" value="Show Stock"></td>
                    
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

                    <td width="100">Stock (<=): </td>

                    <td width="210"><input name="stock" type="text" id="stock" value="<? echo $stock;?>" size="10"></td>

                    <td>&nbsp;</td>
                    
                    <td><input name="showOutStock" type="submit" id="showOutStock" value="Show Out Stock">
                    <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
                    </td>
                    
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

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                    
                    <td><input name="showAverage" type="submit" id="showAverage" value="Show Average"></td>
                    
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

                    <td>No. of Item :</td>

                    <td width="210"><input name="topCount" type="text" id="topCount" value="<? echo $topCount;?>" size="10"></td>

                    <td>&nbsp;</td>
                    
                    <td><input name="showTopBad" type="submit" id="showTopBad" value="Show Top & Bad"></td>
                    
                    <td>&nbsp;</td>
                    
                  </tr>

                </table>

                <br>

                <br>                

                

                </p>
             
				  <br></td>

              </tr>

            </table>
             </form>
             
             <div align="center">
             
             <?
			 	if (isset($GLOBALS['showAverage'])) {
					get_average_list();
				}
				else if (isset($GLOBALS['showOutStock'])) {
					get_out_stock_list();
				}
				else if (isset($GLOBALS['showTopBad'])) {
					get_top_bad_list();
				}
				else {
					get_product_inventory_list();
				}
			?>
            </div>

            <p>&nbsp;</p>

            </TD>
            
<script type="text/javascript">
	
function createCSV() {
	// Retrieve search key
	var searchKey = '';
	if (document.form1.stock.value != '') { searchKey += 'stock=' + document.form1.stock.value + '&'; }	

	window.open('<?=$page?>/report_inventory_csv.php?genCSV=genCSV&' + searchKey, 'newWin', 'width=800,height=600,menubar=yes,scrollbars=yes')
}

</script>