<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
            	<input type="hidden" name="event" value="">
                <input type="hidden" name="prod_n" value="<?=$prod_n?>">
                
                  <strong>Shipping Item<br /></strong><br>
                    <br />
                    Ship ID: 
					<input name="ship_id" type="text" id="ship_id" value="<?=$ship_id ?>" size="5" readonly="readonly"/>
       				<br />
                    <br />
                    Ship Date :
                    <input id="ship_date" name="ship_date" type="text" value="<?=$ship_date ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".." />   
                    Ship
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<?=$entry_date ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."  />
                    <br />
                    <br />
                    Staff Code: 
                     <input name="staff_cd" type="text"id="staff_cd" value="<?=$staff_cd ?>"/>
                    Staff Name.: 
              <input name="staff_name" type="text" id="staff_name" size="40" value="<?=$staff_name ?>" />
                    <br />
                    <br />
                        Ware House :
                        <input type="radio" name="wareHouseCode" id="wareHouse1" value="J1" <? if ($warehouse == "J1" ){?>checked="checked" <? }?>/>3ÃúÌÜ
                        <input type="radio" name="wareHouseCode" id="wareHouse2" value="J2" <? if ($warehouse == "J2" ){?>checked="checked" <? }?>/>±ºÅÄ
                        <input type="radio" name="wareHouseCode" id="wareHouse3" value="HK" <? if ($warehouse == "HK" ){?>checked="checked" <? }?>/>HK
                        <input type="radio" name="wareHouseCode" id="wareHouse4" value="CN" <? if ($warehouse == "CN" ){?>checked="checked" <? }?>/>China
                      <br />
                      <br />
                      Remarks:
                    <label>
                      <textarea name="remarks" id="remarks" cols="45" rows="3"><?=$remarks?></textarea>
                    </label>
                    </p>
                    <table border="1" cellpadding="0" cellspacing="0">
                    <div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="58">Row Num.</td>
                        <td><div align="center">PO ID</div></td>
                        <td width="100"><div align="center">Product No. </div></td>
                        <td width="206"><div align="center">Products Name</div></td>
                        <td width="117"><div align="center">Ship Qty</div></td>
                        <td><div align="center">Packing No</div></td>
                        <td><div align="center">Delete</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right">
                        	<input type='hidden' name='po_prod_hist_id<?=$i?>' id='po_prod_hist_id<?=$i?>' value="<?=$po_prod_hist_id[$i]?>" />
							<? echo $i?>
                        </td>
                        <td><div align="center">
                          <input name="po_id<?=$i?>" type="text" id="po_id<?=$i?>" value="<?=$po_id[$i]?>" size="5" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="goods_partno<?=$i?>" type="text" id="goods_partno<?=$i?>" value="<?=$goods_partno[$i] ?>" size="10" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" value="<?=$goods_name[$i] ?>" size="30" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="ship_qty<?=$i?>" type="text" id="ship_qty<?=$i?>" value="<?=$ship_qty[$i]?>" size="10" maxlength="10" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="pack_no<?=$i?>" type="text" id="pack_no<?=$i?>" value="<?=$pack_no[$i]?>" size="10" maxlength="10" />
                        </div></td>
                        <td><div align="center"><input name="delete_select<?=$i?>" type="checkbox" id="delete_select<?=$i?>" onchange="countQty()" /></div></td>
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
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><div align="right">Total Ship Qty:</div></td>
                        <td><div align="center">
                        	<input name="subTotal" type="text" id="subTotal" value="<?=$subTotal?>" size="10" maxlength="10" readonly="readonly" />
                        </div></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><div align="center">
                        	<input type="button" name="save" value="save"" id="save"" onclick="goSave()"/>
                         </div></td>
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

submit_success="<? echo $submit_success ?>";
id="<? echo $id?>";
submitResult(submit_success, id);

function goSave() {
	if (checkShipItemFields()) {
		document.form1.event.value = 'save'
		document.form1.submit();
	}
}

function countQty() {
	subTotal = 0;
	<? for($i=1;$i<=$prod_n;$i++){?>
		if (!document.getElementById("delete_select" + "<?=$i?>").checked) {
			subTotal = subTotal + (document.getElementById("ship_qty" + "<?=$i?>").value * 1);
		}
	<? }?>
	
	document.form1.subTotal.value = subTotal;
}

  Calendar.setup(
    {
      inputField  : "ship_date",         // ID of the input field
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