<?
$isJ1Only = false;
if ($companyDomain == DOMAIN_TOPNOV) {
	$isJ1Only = true;
} 
?>

<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" id="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
              
                
                   <div class="heading"><strong>Out Stock</strong></div>
                   
                   <input type="hidden" name="event" value="">
                   
                   <br />
                   Number of Product 

                    <select name="prod_n" onChange=javascript:location.href='index.php?page=stock&subpage=out_add&prod_n='+this.options[this.selectedIndex].value>
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
                    Stock Date :
                    <input id = "stock_date" name="stock_date" type="text" value="<? echo Date("Y-m-d H:i"); ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".."   />   
                    
                    <br />
                    <br />
                    Remarks:
                    <label>
                      <textarea name="remarks" id="remarks" cols="45" rows="3"></textarea>
                    </label>
                    <br />
                    <br />
                    <table width="1200" border="1" cellpadding="0" cellspacing="0">
                    <div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="52">Row Num.</td>
                        <td width="210"><div align="center">Product No. </div></td>
                        <td width="189"><div align="center">Products Name</div></td>
                        <td width="157"><div align="center">
                          <table cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="72">Remark</td>
                            </tr>
                          </table>
                        </div></td>
                        <td width="85"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Colour</div></td>
                          </tr>
                        </table></td>
                        <td width="57">Pcs/Set</td>
                        <td width="57"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72"><div align="center">Qty</div></td>
                          </tr>
                        </table></td>
                        <td width="85"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88"><div align="center">Unit Price</div></td>
                          </tr>
                        </table></td>
                        <td width="101"><div align="center">Total</div></td>
                        <td width="162"><div align="center">Ware House</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right"><img name="productCheckImg<?=$i?>" id="productCheckImg<?=$i?>" width="16" height="16" alt="" /><? echo $i?></td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20" onBlur="findPartNoAjax('goods_partno<?=$i?>', '<?=$i?>')"/>
                          <input name="find_goods_partno_button<?=$i?>" type="button" id="find_goods_partno_button<?=$i?>" value="Find" onclick="window.open('stock/stock_find_product.php?prod_sel=<?=$i?>&prod_n=<?=$prod_n?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_remark<?=$i?>" type="text" id="goods_remark<?=$i?>" size="20" maxlength="30" readonly="readonly" />
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
                        <td>
                        	<? if (!$isJ1Only) {?>
                        		<input type="radio" name="wareHouseCode<?=$i?>" id="wareHouse1_<?=$i?>" value="J1" />J1
	                            <input type="radio" name="wareHouseCode<?=$i?>" id="wareHouse2_<?=$i?>" value="J2" />J2
	                            <input type="radio" name="wareHouseCode<?=$i?>" id="wareHouse3_<?=$i?>" value="HK" />HK
	                            <input type="radio" name="wareHouseCode<?=$i?>" id="wareHouse4_<?=$i?>" value="CN" />China
                        	<? } else {?>
                        		<input type="radio" name="wareHouseCode<?=$i?>" id="wareHouse1_<?=$i?>" value="J1" />J1
                        	<? }?>
                        </td>
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
                        	&yen;<input type="text" name="subTotal" id="subTotal" value="0" size="10" maxlength="10" readonly="readonly" /></div></td>
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
};

  Calendar.setup(
    {
      inputField  : "stock_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_1"       // ID of the button
      
    }
  );

</script>