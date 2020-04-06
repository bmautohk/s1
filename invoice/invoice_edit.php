<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" id="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
                <input id = "po_id" name="po_id" type="hidden" value="<? echo $po_id; ?>" />
                <input id = "auto_po" name="auto_po" type="hidden" value="<? echo $auto_po_flag; ?>" />
                <input type="hidden" name="event" value="">
              
                
                   <div class="heading"><strong>Whole Sale Invoice</strong></div>
                   <br />
                   Number of Product 

                    <select name="prod_n" onChange=javascript:location.href='index.php?page=<?=$page?>&subpage=<?=$subpage?>&invoice_id=<?=$invoice_id?>&prod_n='+this.options[this.selectedIndex].value>
                    <? 
						for ($i=1;$i<=80;$i++)
						{
							if ($prod_n==$i)
								echo "<option value='$i' selected>$i</option>";
							else
								echo "<option value='$i'>$i</option>";
						}
					?>
					</select>
                    
                   	<br>
                    <br />
                   	Invoice ID: <input id = "invoice_id" name="invoice_id" type="input" value="<? echo $invoice_id; ?>" size="10" readonly="readonly"/>
                    <br>
                    <br />
                    Invoice Date :
                    <input id = "invoice_date" name="invoice_date" type="text" value="<? echo $invoice_date; ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".."   />
                    
                    Invoice
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<? echo $entry_date; ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
                    <br />
                    <br />
                    Sales Code: 
                    <input name="sales_cd" type="text" value="<? echo $sales_cd; ?>" id="sales_cd" />
                    Sales Name.: 
                    <input name="sales_name" type="text" id="sales_name" value="<? echo $sales_name; ?>" size="40" />
                    <br />
                    <br />
      Cust. Code: 
       <input name="cust_cd" type="text" value="<? echo $cust_cd; ?>" id="cust_cd" onchange="findCustomer()" />
       Customer Name.: 
       <input name="cust_name" type="text" id="cust_name" value="<? echo $cust_name; ?>" size="40" />
<br>
<br>
                    Address : 
                    <input name="cust_address" type="text" id="cust_address" value="<? echo $cust_address; ?>" size="100" />
                  </p>
                    <p>Tel : 
                      <input name="cust_tel" type="text" id="cust_tel" value="<? echo $cust_tel; ?>" size="20" />
  
                      Fax: 
                      <input name="cust_fax" type="text" value="<? echo $cust_fax; ?>" id="cust_fax" />
 
                      Email: 
                      <input name="cust_email" type="text" value="<? echo $cust_email; ?>" id="cust_email" />
                      
                      Post Code : 
                      <input name="post_code" type="text" id="post_code" value="<? echo $post_code; ?>"/>
                      <br />
                      <br />
                      Remarks:
                    <label>
                      <textarea name="remarks" id="remarks" cols="45" rows="3" ><? echo $remarks; ?></textarea>
                    </label>
                    <br />
                    <br />
                      Complete?
                      <input name="complete_flag" id="complete_flag" type="checkbox" value="complete" <? if ($invoice_status == "C") {?> checked="checked" <? }?>/>
                      <font color="red"><strong>Auto PO?</strong></font>
                      <input name="auto_po_flag" id="auto_po_flag" type="checkbox" disabled="disabled" <? if ($auto_po_flag == "Y") {?> checked="checked" <? }?>/>
                      Payment?
                      <input name="payment_flag" id="payment_flag" type="checkbox" value="Y" <? if ($payment_flag == "Y") {?> checked="checked" <? }?> />
                    </p>
                    <table border="1" cellpadding="0" cellspacing="0">
                    <div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="58">Row Num.</td>
                        <td width="220"><div align="center">Product No. </div></td>
                        <td width="206"><div align="center">Products Name</div></td>
                        <td width="172"><div align="center">
                          <table cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="72">Remark</td>
                            </tr>
                          </table>
                        </div></td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Colour</div></td>
                          </tr>
                        </table></td>
                        <td width="76">Pcs/Set</td>
                        <td width="76"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72"><div align="center">Qty</div></td>
                          </tr>
                        </table></td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Unit Price</div></td>
                          </tr>
                        </table></td>
                        <td width="117"><div align="center">Total</div></td>
                        <td><div align="center">Real Stock</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right">
                        	<img name="productCheckImg<?=$i?>" id="productCheckImg<?=$i?>" width="16" height="16" alt="" />
                        	<input name="inv_prod_id<?=$i?>" type="hidden" id="inv_prod_id<?=$i?>" value="<?=$inv_prod_id[$i]?>" />
                            <? echo $i?>
                        </td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20" value="<?=$goods_partno[$i]?>" onchange="findPartNoAjax('<?=$i?>')" />
                          <input name="find_goods_partno_button<?=$i?>" type="button" id="find_goods_partno_button<?=$i?>" value="Find" onclick="window.open('invoice/invoice_find_product.php?prod_sel=<?=$i?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
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
                          <input name="pcs<?=$i?>" type="text" id="pcs<?=$i?>" size="5" maxlength="30" value="<?=$pcs[$i] ?>" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="qty<?=$i?>" type="text" id="qty<?=$i?>" size="5" maxlength="30" value="<?=$qty[$i]?>" onblur="calProdTotal(<?=$i?>)"/>
                        </div></td>
                        <td><input name="unit_price<?=$i?>" type="text" id="unit_price<?=$i?>" value="<?=$unit_price[$i]?>" size="10" maxlength="30" onblur="calProdTotal(<?=$i?>)" /></td>
                        <td><div align="center">&yen;
                          <input name="total<?=$i?>" type="text" id="total<?=$i?>" value="<?=$total[$i]?>" size="10" maxlength="10" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                          <input name="real_stock<?=$i?>" type="text" id="real_stock<?=$i?>" value='N/A' size="10" maxlength="10" readonly="readonly" />
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<div align="left">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>SubTotal :</td>
                        <td><div align="center">
                        	&yen;<input type="text" name="subTotal" id="subTotal" value="<?=$subTotal ?>" size="10" maxlength="10" /></div></td>
                         </div>
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
                        <td><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88">Desposit</td>
                          </tr>
                        </table></td>
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
                        <td><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88">Balance</td>
                          </tr>
                        </table></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
<!--                      <tr>
                      	<div align="left">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><br /></td>
                        <td>
                        <input type="radio" name="auto_po_flag" id="auto_po_flag" value="auto_po_flag" />
                          Auto
                        PO<br />
                        <input type="radio" name="auto_po_flag" id="deduct_stock" value="deduct_stock" checked="checked"/>
                        Deduct Stock
                        </td>
                        </div>
                      </tr> -->
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="button" name="calculate" value="Cal Sub Total" id="calculate" onclick="calSubTotal()"/></td>
                        <td><input type="button" name="save" value="save" id="save" onclick="goSave()"/></td>
                        <td>&nbsp;</td>
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
      inputField  : "invoice_date",         // ID of the input field
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
