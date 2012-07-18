<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
            	<input type="hidden" name="event" value="">
              
                
                  <strong>Purchase Order<br /></strong><br>
					<br />
                    Number of Product 
                    <select name="prod_n" onChange=javascript:location.href="index.php?page=<?=$page?>&subpage=<?=$subpage?>&prod_n="+this.options[this.selectedIndex].value >
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
                    Invoice ID:
                    <input name="invoice_id" type="text" id="invoice_id" size="10" onchange="findInvoiceAjax('invoice_id')"/>
                    <span id="txtInvCheck"></span>
                    <br />
                    <br />
                    PO Date :
                    <input id="po_date" name="po_date" type="text" value="<? echo Date("Y-m-d H:i "); ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".." />   
                    PO
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<? echo Date("Y-m-d H:i "); ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."  />
                    <br />
                    <br />
                    Staff Code: 
                     <input name="staff_cd" type="text"id="staff_cd" />
                    <!--input name="calButton4" type="button" id="calButton4" value="SearchID" onclick="window.open('order_find_product.php?prod_sel=<? echo $j?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" /--> 
                    Staff Name.: 
              <input name="staff_name" type="text" id="staff_name" size="40" />
                    <br />
                    <br />
      Supplier Code: 
       <input name="supp_cd" type="text" id="supp_cd" />
       <!--input name="calButton3" type="button" id="calButton3" value="SearchID" onclick="window.open('order_find_product.php?prod_sel=<? echo $j?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" /-->
       Supplier Name.: 
       <input name="supp_name" type="text" id="supp_name" size="40" />
<br>
<br>
                    Supplier Address : 
                    <input name="supp_address" type="text" id="supp_address" size="100" />
                  </p>
                    <p>Supplier Tel : 
                      <input name="supp_tel" type="text" id="supp_tel" size="20" />
  
                      Supplier Fax:
                      <input name="supp_fax" type="text" id="supp_fax" />
 
                      Supplier Email: 
                      <input name="supp_email" type="text" id="supp_email" />
                      <br />
                      <br />
                      Remarks:
                    <label>
                      <textarea name="remarks" id="remarks" cols="45" rows="3"></textarea>
                    </label>
                    </p>
                    <table width="1094" border="1" cellpadding="0" cellspacing="0">
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
                            <td width="88">Colour</td>
                          </tr>
                        </table></td>
                        <td width="76">Pcs/Set</td>
                        <td width="76"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72">Qty</td>
                          </tr>
                        </table></td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88">Cost Default</td>
                          </tr>
                        </table></td>
                        <td width="117"><div align="center">Total</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right"><img name="productCheckImg<?=$i?>" id="productCheckImg<?=$i?>" width="16" height="16" alt="" /><? echo $i?></td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20" onBlur="findPartNoAjax('goods_partno<?=$i?>', '<?=$i?>')"/>
                          <input name="find_goods_partno_button<?=$i?>" type="button" id="find_goods_partno_button<?=$i?>" value="Find" onclick="window.open('<?=$page?>/po_find_product.php?prod_sel=<?=$i?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_remark<?=$i?>" type="text" id="goods_remark<?=$i?>" size="20" maxlength="30" />
                        </div></td>
                        <td><input name="product_colour<?=$i?>" type="text" id="product_colour<?=$i?>" size="10" maxlength="30" readonly="readonly"/></td>
                        <td><input name="pcs<?=$i?>" type="text" id="pcs<?=$i?>" value="0" size="5" maxlength="30" /></td>
                        <td><div align="center">
                          <input name="qty<?=$i?>" type="text" id="qty<?=$i?>" value="0" size="5" maxlength="30"  onblur="calProdTotal(<?=$i?>)" />
                        </div></td>
                        <td><input name="unit_price<?=$i?>" type="text" id="unit_price<?=$i?>" value="0" size="10" maxlength="30"  onblur="calProdTotal(<?=$i?>)" /></td>
                        <td><div align="center">&yen;
                          <input name="total<?=$i?>" type="text" id="total<?=$i?>" value="0" size="10" maxlength="10" readonly="readonly" />
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
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>SubTotal :<br /></td>
                        <td>&yen;<input name="subTotal" type="text" id="subTotal" value="0" size="10" maxlength="10" readonly="readonly" /></td>
                      </tr>
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
      inputField  : "po_date",         // ID of the input field
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