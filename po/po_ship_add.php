<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" id="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
            	<input type="hidden" name="event" value="">
                <input type="hidden" name="prod_n" value="<?=$prod_n?>">
                
                  <strong>Purchase Order<br /></strong><br>
                    <br />
                    Ship Date :
                    <input id="ship_date" name="ship_date" type="text" value="<? echo Date("Y-m-d H:i "); ?>" />
                    <input name="cal" type="button" id="cal_id_1" value=".." />   
                    Ship
                    Entry Date :
                    <input id="entry_date" name="entry_date" type="text" value="<? echo Date("Y-m-d H:i "); ?>" />
                    <input name="cal2" type="button" id="cal_id_2" value=".."  />
                    <br />
                    <br />
                    Staff Code : 
                     <input name="staff_cd" type="text"id="staff_cd" />
                    Staff Name : 
              <input name="staff_name" type="text" id="staff_name" size="40" />
                      <br />
                      <br />
                        Ware House :
                        <input type="radio" name="wareHouseCode" id="wareHouse1" value="J1" />3ÃúÌÜ
                        <input type="radio" name="wareHouseCode" id="wareHouse2" value="J2" />±ºÅÄ
                        <input type="radio" name="wareHouseCode" id="wareHouse3" value="HK" />HK
                        <input type="radio" name="wareHouseCode" id="wareHouse4" value="CN" />China
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
                        <td><div align="center">PO ID</div></td>
                        <td width="100"><div align="center">Product No. </div></td>
                        <td width="206"><div align="center">Products Name</div></td>
                        <td align="center" width="172">Remark</td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" width="88">Colour</td>
                          </tr>
                        </table></td>
                        <td align="center" width="76">Pcs/Set</td>
                        <td align="center" width="76">PO Qty</td>
                        <td align="center" width="98">Remaining Qty</td>
                        <td width="117"><div align="center">Ship Qty</div></td>
                      </tr>
                      <? for($i=1;$i<=$prod_n;$i++){ ?>
                      
                      <tr>
                        <td align="right">
                        	<input type='hidden' name='po_prod_id<?=$i?>' id='po_prod_id<?=$i?>' value="<?=$po_prod_id[$i]?>" />
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
                          <input name="goods_remark<?=$i?>" type="text" id="goods_remark<?=$i?>" value="<?=$goods_remark[$i] ?>" size="30" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                        	<input name="product_colour<?=$i?>" type="text" id="product_colour<?=$i?>" value="<?=$product_colour[$i] ?>" size="10" maxlength="30" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                        	<input name="pcs<?=$i?>" type="text" id="pcs<?=$i?>" value="<?=$pcs[$i] ?>" size="5" maxlength="30" readonly="readonly"/>
                        </div></td>
                        <td><div align="center">
                          <input name="po_qty<?=$i?>" type="text" id="po_qty<?=$i?>" value="<?=$po_qty[$i]?>" size="5" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                        	<input name="remain_qty<?=$i?>" type="text" id="remain_qty<?=$i?>" value="<?=$remain_qty[$i]?>" size="10" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                          <input name="ship_qty<?=$i?>" type="text" id="ship_qty<?=$i?>" value="<?=$ship_qty[$i]?>" size="10" maxlength="10" onchange="countQty()"/>
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Total Ship Qty:<br /></td>
                        <td><div align="center">
                        	<input name="subTotal" type="text" id="subTotal" value="<?=$subTotal?>" size="10" maxlength="10" readonly="readonly" />
                        </div></td>
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
                        <td><input type="button" name="preview" value="Preview" id="Preview" onclick="goPreview()"/></td>
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

submit_success="<? echo $submit_success ?>";
id="<? echo $id?>";
submitResult(submit_success, id);

function goPreview() {
	var msg = '&';
	var elem = document.getElementById("form1");
	for (var i=0;i<elem.length;i++) {
		if (elem.elements[i].name != 'wareHouseCode' && elem.elements[i].name != 'remarks')
			msg = msg + elem.elements[i].name + '=' + elem.elements[i].value + '&';
	}

	msg = msg +'remarks=' +  document.form1.remarks.value.replace(/\n\r?/g, '<br />') + '&';

	elem = document.form1.elements['wareHouseCode'];
	for (var i = 0; i < elem.length; i++) {
		if (elem[i].checked) {
			msg = msg + elem[i].name + '=' + elem[i].value;
			break;
		}
	}
	
	NewWindow('po/po_ship_preview.php?event=preview&prod_n=' + <?=$prod_n?> + msg,'mywin','780','350','no','center');
}

function goSave() {
	if (checkShipItemFields()) {
		document.form1.event.value = 'save'
		document.form1.submit();
	}
}

function countQty() {
	subTotal = 0;
	for(var i=0; i < <?=$prod_n?>; i++) {
		subTotal = subTotal + (document.getElementById("ship_qty" + (i+1)).value * 1);
	}
	
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