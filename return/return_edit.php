<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
              		<input type="hidden" name="event" value="">
                
                   <div class="heading"><strong>Whole Sale Invoice</strong></div>
                  
                    <br>
                    Return ID: <input id = "return_id" name="return_id" type="input" value="<? echo $return_id; ?>" size="10" readonly="readonly" />
                    <br />
                    <br />
                    Return Date :
                    <input id = "return_date" name="return_date" type="text" value="<? echo $return_date; ?>" />
        <input name="cal" type="button" id="cal_id_1" value=".."   />
                    
                    Invoice
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<? echo $entry_date; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
                    <br />
                    <br />
                    Sales Code: 
                    <input name="sales_cd" type="text" value="<? echo $sales_cd; ?>" id="sales_cd" />
                    <input name="find_sales_id" type="button" id="find_sales_id" value="SearchID" onclick="window.open('invoice_find_product.php','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
                    Sales Name.: 
                    <input name="sales_name" type="text" id="sales_name"  size="40" value="<? echo $sales_name; ?>" />
                    <br />
                    <br />
                    <p>Remarks:
                      <label>
                        <textarea name="remarks" id="remarks" cols="45" rows="3" ><? echo $remarks; ?></textarea>
                      </label>
                      <br />
                    </p>
                    <table width="1040" border="1" cellpadding="0" cellspacing="0">
                    <div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="48">Row Num.</td>
                        <td width="195"><div align="center">Product No. </div></td>
                        <td width="194"><div align="center">Products Name</div></td>
                        <td width="162"><div align="center">
                          <table cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="72">Remark</td>
                            </tr>
                          </table>
                        </div></td>
                        <td width="89"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Colour</div></td>
                          </tr>
                        </table></td>
                        <td width="63"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72"><div align="center">Qty</div></td>
                          </tr>
                        </table></td>
                        <td width="92"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Unit Price</div></td>
                          </tr>
                        </table></td>
                        <td width="142"><div align="center">Total</div></td>
                      </tr>
                      <? for($i=1;$i<=30;$i++){ ?>
                      
                      <tr>
                        <td align="right">
                       		<img name="productCheckImg<?=$i?>" id="productCheckImg<?=$i?>" width="16" height="16" alt="" />
                        	<input name="return_prod_id<?=$i?>" type="hidden" id="return_prod_id<?=$i?>" value="<?=$return_prod_id[$i]?>" />
                            <? echo $i?>
                        </td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20" value="<?=$goods_partno[$i]?>" onchange="findPartNoAjax('goods_partno<?=$i?>', '<?=$i?>')" />
                          <input name="find_goods_partno_button<?=$i?>" type="button" id="find_goods_partno_button<?=$i?>" value="Find" onclick="window.open('return/return_find_product.php?prod_sel=<?=$i?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" value="<?=$goods_name[$i]?>" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_remark<?=$i?>" type="text" id="goods_remark<?=$i?>" size="20" maxlength="30" value="<?=$goods_remark[$i]?>"/>
                        </div></td>
                        <td><div align="center">
                          <input name="product_colour<?=$i?>" type="text" id="product_colour<?=$i?>" size="10" maxlength="30" value="<?=$product_colour[$i]?>" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="qty<?=$i?>" type="text" id="qty<?=$i?>" size="5" maxlength="30" value="<?=$qty[$i]?>" onblur="calProdTotal(<?=$i?>)"/>
                        </div></td>
                        <td><input name="unit_price<?=$i?>" type="text" id="unit_price<?=$i?>" value="<?=$unit_price[$i]?>" size="10" maxlength="30" onblur="calProdTotal(<?=$i?>)" /></td>
                        <td><div align="center">&yen;
                          <input name="total<?=$i?>" type="text" id="total<?=$i?>" value="<?=$total[$i]?>" size="10" maxlength="10" readonly="readonly" />
                        </div></td>
                      </tr>
                      <? } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>SubTotal :</td>
                        <td><div align="center">
                        	&yen;<input type="text" name="subTotal" id="subTotal" value="<?=$subTotal?>" size="10" maxlength="10" readonly="readonly" /></div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="button" name="calculate" value="Cal Sub Total" id="calculate" onclick="calSubTotal()"/></td>
                        <td><input type="button" name="save" value="save" id="save" onclick="goSave()"/></td>
                      </tr> 
              </div>   
              </table>
	  	  <br>

             
             
              <br>
            <br><br>
            <p>&nbsp;</p>
            </form>
  <p>&nbsp;</p>
            </TD>
            
<script type="text/javascript">

init();

function goSave() {
	if (checkFields()) {
		document.form1.event.value = 'save'
		document.form1.submit();
	}
}

  Calendar.setup(
    {
      inputField  : "return_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_1"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "entry_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_2"       // ID of the button
      
    }
  );
</script>