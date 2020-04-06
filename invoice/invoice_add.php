<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
            	<input type="hidden" name="event" value="">
              
                
                   <div class="heading"><strong>Whole Sale Invoice</strong></div>
                   <br />
                   Number of Product 

                    <select name="prod_n" onChange=javascript:location.href='index.php?page=<?=$page?>&subpage=<?=$subpage?>&prod_n='+this.options[this.selectedIndex].value>
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
                   
                    <br />
                    <br />
                    Invoice Date :
                    <input id = "invoice_date" name="invoice_date" type="text" value="<? echo Date("Y-m-d H:i"); ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".."   />   
                    
                    Invoice
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<? echo Date("Y-m-d H:i"); ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."   />
                    <br />
                    <br />
                    Sales Code : 
                    <input name="sales_cd" type="text" id="sales_cd" value="<?=$sales_cd ?>" />
                    <!--input name="find_sales_id" type="button" id="find_sales_id" value="SearchID" onclick="window.open('invoice_find_product.php','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" /-->
                    Sales Name : 
                    <input name="sales_name" type="text" id="sales_name" size="40" value="<?=$sales_name ?>" />
                    <br />
                    <br />
      Cust. Code : 
       <input name="cust_cd" type="text" id="cust_cd" onchange="findCustomer()"/>
       <!--input name="calButton3" type="button" id="calButton3" value="SearchID" onclick="window.open('invoice_find_product.php','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" /-->
       Customer Name : 
       <input name="cust_name" type="text" id="cust_name" size="40" />
<br>
<br>
                    Address : 
                    <input name="cust_address" type="text" id="cust_address" size="100" />
                  </p>
                    <p>Tel : 
                      <input name="cust_tel" type="text" id="cust_tel" size="20" />
  
                      Fax : 
                      <input name="cust_fax" type="text" id="cust_fax" />
 
                      Email : 
                      <input name="cust_email" type="text" id="cust_email" />
                      
                      Post Code : 
                      <input name="post_code" type="text" id="post_code" />
                      <br />
                      <br />
                      Remarks:
                    <label>
                      <textarea name="remarks" id="remarks" cols="45" rows="3"></textarea>
                    </label>
                    <br />
                    <br />
                      Complete?
                      <input name="complete_flag" id="complete_flag" type="checkbox" value="complete"/>
                      <font color="red"><strong>Auto PO?</strong></font>
                      <input name="auto_po_flag" id="auto_po_flag" type="checkbox" value="auto_po" />
                      Payment?
                      <input name="payment_flag" id="payment_flag" type="checkbox" value="Y" />
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
                        <td align="right"><img name="productCheckImg<?=$i?>" id="productCheckImg<?=$i?>" width="16" height="16" alt="" /><? echo $i?></td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20"  onchange="findPartNoAjax('<?=$i?>')"/>
                          <input name="find_goods_partno_button<?=$i?>" type="button" id="find_goods_partno_button<?=$i?>" value="Find" onclick="window.open('invoice/invoice_find_product.php?prod_sel=<?=$i?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_remark<?=$i?>" type="text" id="goods_remark<?=$i?>" size="20" maxlength="30" />
                        </div></td>
                        <td><div align="center">
                          <input name="product_colour<?=$i?>" type="text" id="product_colour<?=$i?>" size="10" maxlength="30" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="pcs<?=$i?>" type="text" id="pcs<?=$i?>" size="5" maxlength="30" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="qty<?=$i?>" type="text" id="qty<?=$i?>" value="0" size="5" maxlength="30" onblur="calProdTotal(<?=$i?>)"/>
                        </div></td>
                        <td><input name="unit_price<?=$i?>" type="text" id="unit_price<?=$i?>" value="0" size="10" maxlength="30" onblur="calProdTotal(<?=$i?>)" /></td>
                        <td><div align="center">&yen;
                          <input name="total<?=$i?>" type="text" id="total<?=$i?>" value="0" size="10" maxlength="10" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                          <input name="real_stock<?=$i?>" type="text" id="real_stock<?=$i?>" value="0" size="10" maxlength="10" readonly="readonly" />
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
                        	&yen;<input type="text" name="subTotal" id="subTotal" value="0" size="10" maxlength="10" /></div></td>
                         <td>&nbsp;</td>
                         </div>
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