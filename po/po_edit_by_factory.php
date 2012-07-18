<style type="text/css">
<!--
.red {
	color: #000;
}
-->
</style>
<TD vAlign=top>
        
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
            	<input type="hidden" name="event" value="">
				<input id = "invoice_id" name="invoice_id" type="hidden" value="<? echo $invoice_id; ?>" />
                    
                  <p><strong>Purchase Order<br /></strong><br>
	              <br />
                  <legend>Input For China Factory</legend>
                  <br />
                  <br />
                  PO ID:<input id = "po_id" name="po_id" type="input" value="<? echo $po_id; ?>" size="10" readonly="readonly"/>
                  <br />
                  <br />
                  Shipping Ref No.: 
                    <input name="ship_ref_no" type="text" id="ship_ref_no" value="<? echo $ship_ref_no ?>" size="20" /> 
                    Shipping batch no :
                    <input name="ship_batch_no" type="text" id="ship_batch_no" value="<? echo $ship_batch_no ?>" size="20" />
                    <br />
                     <br />
                    Delivery Date :
                    <input name="delivery_date" type="text" id="delivery_date" value="<? echo $delivery_date ?>" size="15" />
                    <input name="cal" type="button" id="cal_id_1" value=".." onclick="calendar" /> 
                    Target Landing Date :
<input name="landing_date" type="text" id="landing_date" value="<? echo $landing_date ?>" size="15" />
										<input name="cal2" type="button" id="cal_id_2" value=".." onclick="calendar" />
                    <br />
                    <br />
                    Delivery To Ware House :
                    <input type="radio" name="wareHouseCode" id="wareHouse1" value="J1" <? if ($warehouse == "J1" ){?>checked="checked" <? }?>/>J1
					<input type="radio" name="wareHouseCode" id="wareHouse2" value="J2" <? if ($warehouse == "J2" ){?>checked="checked" <? }?>/>J2
					<input type="radio" name="wareHouseCode" id="wareHouse3" value="HK" <? if ($warehouse == "HK" ){?>checked="checked" <? }?>/>HK
                    <input type="radio" name="wareHouseCode" id="wareHouse4" value="CN" <? if ($warehouse == "CN" ){?>checked="checked" <? }?>/>China
                    <br />
					<br />
					PO Completion date 
                    <input name="po_completion_date" type="text" id="po_completion_date" value="<? echo $po_complete_date ?>" size="15" />
                    <input name="cal3" type="button" id="cal_id_3" value=".." onclick="calendar" />
                     &lt; instock date&gt;<br />
                    <br />
                    Close PO Flag: 
                    <input type="radio" name="po_status" id="po_status1" value="PARK" <? if ($close_po_flag == "PARK" ){?>checked="checked" <? }?> />
                    Park
                    <input type="radio" name="po_status" id="po_status2" value="POST" <? if ($close_po_flag == "POST" ){?>checked="checked" <? }?>/>
                    Post   &lt;instock when post checked&gt;<br />
                    <br />
                    Staff Code :
                    <input name="factory_staff_cd" type="text" value="<? echo $factory_staff_cd ?>" id="staff_cd" />
                    <!--input name="calButton8" type="button" id="calButton8" value="SearchID" onclick="window.open('order_find_product.php?prod_sel=<? echo $j?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');" /-->

Staff Name :
<input name="factory_staff_name" type="text" id="factory_staff_name" value="<? echo $factory_staff_name ?>" size="40" />
<br />
              <? if (!isset($_GET['readonly'])) { ?>
	              <input type="button" name="update" value="update" id="update" onclick="goSave()"/>
              <? } ?>
              </p>
              <p>&nbsp;</p>
                  <p><legend>Read Only Below for China Factory</legend>
                  </span><br />
                    PO Date :
                    <input name="po_date" type="text" value="<? echo $po_date; ?>" readonly="readonly"/>
                       
                    PO
                    Entry Date :
                    <input name="entry_date" type="text" value="<? echo $entry_date ?>" readonly="readonly"/>
                    <br />
                    <br />
                    Staff Code: 
                    <input name="staff_cd" type="text" value="<? echo $staff_cd ?>" id="staff_cd" readonly="readonly"/>
                     
                    Staff Name.: 
                    <input name="staff_name" type="text" id="staff_name" value="<? echo $staff_name ?>" size="40" readonly="readonly"/>
                    <br />
                    <br />
                    Supplier Code: 
                    <input name="supplier_cd" type="text" id="supplier_cd" value="<? echo $supplier_cd ?>" readonly="readonly"/>
                    
                    Supplier Name.: 
                    <input name="supplier_name" type="text" id="supplier_name" value="<? echo $supplier_name ?>" size="40" readonly="readonly"/>
  <br>
  <br>
                    Supplier Address : 
                    <input name="supplier_address" type="text" id="supplier_address" value="<? echo $supplier_address ?>" size="100" readonly="readonly"/>
              </p>
              </p>
              <p>Supplier Tel : 
                      <input name="supplier_tel" type="text" id="supplier_tel" value="<? echo $supplier_tel ?>" size="20" readonly="readonly"/>
  
                      Supplier Fax: 
                      <input name="supplier_fax" type="text" id="supplier_fax" value="<? echo $supplier_fax ?>" readonly="readonly"/>
 
                      Supplier Email: 
                      <input name="supplier_email" type="text" id="$supplier_email" value="<? echo $supplier_email ?>" readonly="readonly"/>
                      <br />
                      <br />
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
                        <td width="76">Pcs/Set</strong></td>
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
                      <? for($i=1;$i<=$num_prod;$i++){ ?>
                      
                      <tr>
                        <td><? echo $i?></td>
                        <td><div align="center"><? echo $goods_partno[$i]?></div></td>
                        <td><div align="center"><? echo $goods_name[$i]?></div></td>
                        <td><div align="center"><? echo $sprod_remark[$i]?></div></td>
                        <td><div align="center"><? echo $product_colour[$i]?></div></td>
                        <td><div align="center"><? echo $pcs[$i]?></div></td>
                        <td><div align="center"><? echo $qty[$i]?></div></td>
                        <td><div align="center"><? echo $unit_price[$i]?></div></td>
                        <td><div align="center"><? echo $total[$i]?></div></td>
                      <? } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>SubTotal :<br /></td>
                        <td><div align="center"><? echo $subtotal?></div></td>
                      </tr>
               </div>                   
              </table>

<!--                    <table width="1094" border="1" cellpadding="0" cellspacing="0">
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
                        <td width="76">Pcs/Set</strong></td>
                        <td width="76"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72">Qty</td>
                          </tr>
                        </table></td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88">Cost Defautl</td>
                          </tr>
                        </table></td>
                        <td width="117"><div align="center">Total</div></td>
                      </tr>
                      <? for($i=1;$i<=$num_prod;$i++){ ?>
                      
                      <tr>
                        <td><? echo $i?></td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" size="20" value="<? echo $goods_partno[$i]?>"/>
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" value="<? echo $goods_name[$i]?>" />
                        </div></td>
                        <td><div align="center">
                          <input name="sprod_remark<? echo $j?>" type="text" id="sprod_remark<? echo $j?>" value="<? echo $sprod_remark[$i]?>" size="20" maxlength="30" />
                        </div></td>
                        <td><input name="product_colour<?=$i?>" type="text" id="product_colour<?=$i?>" value="<? echo $product_colour[$i]; ?>" size="10" maxlength="30" /></td>
                        <td><div align="center">
                        	<input name="pcs<?=$i?>" type="text" id="qty<?=$i?>" size="5" maxlength="30" value="<? echo $pcs[$i]?>" />
                         </div></td>
                            
                        <td><div align="center">
                          <input name="qty<?=$i?>" type="text" id="qty<?=$i?>" size="5" maxlength="30" value="<? echo $qty[$i]?>" />
                        </div></td>
                        <td><div align="center">
                        	<input name="unit_price<?=$i?>" type="text" id="unit_price<?=$i?>" size="10" maxlength="30" value="<? echo $unit_price[$i]?>" />
                            </div></td>
                        <td><div align="center">&yen;
                          <input name="total[]" type="text" id="total<?=$i?>" size="10" maxlength="10" value="<? echo $total[$i]?>" />
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
                        <td>SubTotal :<br /></td>
                        <td><div align="center">&yen;<input name="total<?=$i+1?>" type="text" id="total<?=$i+1?>" value="<? echo $subtotal?>" size="10" maxlength="10" /></div></td>
                      </tr>
               </div>                   
              </table> -->
	  	  <br>

             
             
              <br>
            <br><br>
            <p>&nbsp;</p>
            </form>
  <p>&nbsp;</p>
            </TD>
            
<script type="text/javascript">
						
submitResult('<? echo $submit_success ?>', '<?=$id?>');

function goSave() {
	if (editByFactoryCheckFields()) {
		document.form1.event.value = 'save'
		document.form1.submit();
	}
}


  Calendar.setup(
    {
      inputField  : "delivery_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_1"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "landing_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_2"       // ID of the button
      
    }
  );
      Calendar.setup(
    {
      inputField  : "po_completion_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "cal_id_3"       // ID of the button
      
    }
  );
</script>