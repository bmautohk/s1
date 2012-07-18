<TD vAlign=top bgColor=#eefafc>

<form name="form2" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
	<input name="page" type="hidden" id="page" value="<?=$page?>">
	<input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">
	<input type="hidden" name="event" value="">
    
    <strong>Shipping Item<br /></strong><br>
    <br />
    PO Date:<input id = "po_date_min" name="po_date_min" type="text" value="<? echo $po_date_min; ?>" />
    <input name="cal1" type="button" id="cal_id_1" value=".."   />
    To
    <input id = "po_date_max" name="po_date_max" type="text" value="<? echo $po_date_max; ?>" />
    <input name="cal2" type="button" id="cal_id_2" value=".."   />
    <br />
    <br />
    <input type="submit" name="issearch" value="Search" id="issearch" />
</form>

<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=ship_add" >
	<input type="hidden" name="event" value="">
    <input type="hidden" name="prod_n" value="<?=$prod_n?>">
    
	<table border="1" cellpadding="0" cellspacing="0">
		<div align="center">
                      <tr bgcolor="#CCCCCC">
                        <td width="58">Row Num.</td>
                        <td><div align="center">PO ID</div></td>
                        <td width="100"><div align="center">Product No. </div></td>
                        <td width="206"><div align="center">Products Name</div></td>
                        <td width="76"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="72">PO Qty</td>
                          </tr>
                        </table></td>
                        <td width="98"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="88">Remaining Qty</td>
                          </tr>
                        </table></td>
                        <td><div align="center">Qty</div></td>
                        <td><div align="center">Ship</div></td>
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
                          <input name="goods_name<?=$i?>" type="text" id="goods_name<?=$i?>" value="<?=$goods_name[$i] ?>" size="30" readonly="readonly" />
                        </div></td>
                        <td><div align="center">
                          <input name="po_qty<?=$i?>" type="text" id="po_qty<?=$i?>" value="<?=$po_qty[$i]?>" size="10" readonly="readonly" />
                        </div></td>
                        <td><input name="remain_qty<?=$i?>" type="text" id="remain_qty<?=$i?>" value="<?=$remain_qty[$i]?>" size="10" readonly="readonly" /></td>
                        <td><input name="ship_qty<?=$i?>" type="text" id="ship_qty<?=$i?>" size="10" onkeyup="checkInputQty(<?=$i?>)" onChange="countQty()" /></td>
                        <td><div align="center">
                          <input name="ship_select[]" type="checkbox" value="<?=$i?>" onchange="countQty()" />
                        </div></td>
                      </tr>
                   <? }?>
                   	  <tr>
                      	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><div align="right">Total Qty:</div></td>
                         <td><input name="subTotal" type="text" id="subTotal" value="0" size="10" readonly="readonly" /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input type="button" name="CheckAll" value="Check All" onClick="checkAll()"></td>
                        <td><input type="button" name="UnCheckAll" value="Uncheck All" onClick="uncheckAll()"></td>
                        <!--td colspan="2"><input type="button" name="preview" value="Preview" id="Preview" onclick="goPreview()"/></td-->
                        <td colspan="2"><input type="button" name="create" value="Create" id="create" onclick="goCreate()"/></td>
                      </tr>
				</div>
			</table>
</form>
</TD>
            
<script type="text/javascript">

function goCreate() {
	var elem = document.form1.elements["ship_select[]"];
	var missinginfo = "";
	for (var i = 0; i < elem.length; i++) {
		if (elem[i].checked == true &&
			elem[i].value != "" && 
			!IsInteger(elem[i].value)) {
			missinginfo += "\n     -   " + i + " Ship Qty must be an integer.";
		}
	}
	
	if (missinginfo != "") {
		missinginfo ="_____________________________\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n_____________________________" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);
		return false;
	}

	document.form1.event.value = 'create'
	document.form1.submit();
}
/*
function goPreview() {
	var msg = '';
	var count = 0;
	var elem = document.form1.elements["ship_select[]"];
	for (var i = 0; i < elem.length; i++) {
		if (elem[i].checked) {
			count = count + 1;
			msg = msg + '&po_prod_id' + count + '=' + document.getElementById("po_prod_id" + (i+1)).value;
			msg = msg + '&ship_qty' + count + '=' + document.getElementById("ship_qty" + (i+1)).value;
		}
	}
	NewWindow('po/po_ship_preview.php?event=preview&prod_n=' + count + msg,'mywin','780','350','no','center');
}*/

function checkInputQty(index) {
	var elem = document.form1.elements["ship_select[]"];
	if (document.getElementById("ship_qty" + index).value != 0) {
		elem[index-1].checked = true;
	}
	else {
		elem[index-1].checked = false;
	}
}

function countQty() {
	subTotal = 0;
	var elem = document.form1.elements["ship_select[]"];
	for (var i = 0; i < elem.length; i++) {
		if (elem[i].checked) {
			subTotal = subTotal + (document.getElementById("ship_qty" + (i+1)).value * 1);
		}
	}
	
	document.form1.subTotal.value = subTotal;
}

function checkAll() {
	var elem = document.form1.elements["ship_select[]"];
	for (var i = 0; i < elem.length; i++) {
		elem[i].checked = true ;
	}
	countQty();
}

function uncheckAll() {
	var elem = document.form1.elements["ship_select[]"];
	for (var i = 0; i < elem.length; i++) {
		elem[i].checked = false ;
	}
	
	document.form1.subTotal.value = 0;
}


Calendar.setup(
{
	inputField  : "po_date_min",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_1"       // ID of the button      
}
);

Calendar.setup(
{
	inputField  : "po_date_max",         // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	showsTime      :    true,
	button      : "cal_id_2"       // ID of the button      
}
);
</script>