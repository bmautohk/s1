<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>&sale_ref=<?= $sale_ref;?>" onSubmit="return checkFields();">

	<input type="hidden" name="event"  />




  <table width="680" border="0" cellspacing="0" cellpadding="10">
    <tr>
      <td valign="top">
        <br>

        <?
        if (isset($_GET['is_delete'])) {
          if ($_GET['is_delete'] == 'Y') { ?><font size=3 color=red >Delete Product Success !</font>
        <? } else { ?>
          <span style="color:red">Delete Product Fail !<?=$_GET['error_message'] ?></span>
        <? }
        } ?>

        <table width="380" height="224" border="1" cellpadding="0" cellspacing="0">
		<tr align="right">
          <td width="140" align="left">&#21046;&#38480;&#35299;&#38500;: </td>
          <td colspan="2">
		  <?php if ($address_restriction=="Y"){?>
		  <input type="checkbox" name="address_restriction" id="address_restriction" value="Y" checked> 
		  <?php }else{ ?>
		  <input type="checkbox" name="address_restriction" id="address_restriction" value="Y"> 
		  <?php } ?>
		  </td>
        </tr>
		
        <tr align="right">
          <td width="140" align="left">Sales Date: </td>
          <td colspan="2"><script>DateInput('orderdate', true, 'YYYY-MM-DD', '<? echo $sale_date;?>')</script></td>
        </tr>
        <tr align="right">
          <td align="left">Order No. </td>
          <td colspan="2"><? echo $sale_ref?></td>
        </tr>
        <tr align="right">
          <td align="left">Customer Code<br>(Optional) </td>
          <td colspan="2">
          	<select id="cust_cd">
          		<option></option>
      			<? foreach ($customers as $customer) {?>
      				<option value="<?=$customer['cust_cd'] ?>" <? if ($customer['cust_company_name'] == $sale_name) { echo "selected='selected'"; }?>><?=$customer['cust_cd'].' - ' .$customer['cust_company_name'] ?></option>
      			<? }?>
      		</select>
          </td>
        </tr>
        <tr align="right">
          <td align="left">Client Name </td>
          <td colspan="2"><input name="sale_name" type="text" value="<? echo $sale_name;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Client Email</td>
          <td colspan="2"><input name="sale_email" type="text" value="<? echo $sale_email;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Client Yahoo ID </td>
          <td colspan="2"><input name="sale_yahoo_id" type="text" value="<? echo $sale_yahoo_id;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Sales Group</td>
          <td colspan="2"><input name="sale_group" type="text" value="<? echo $sale_group;?>"></td>
        </tr>
        <tr align="right">
          <td align="left">Shipping fee :</td>
          <td width="96">&yen;            </td>
          <td width="94"><div align="left">
            <input name="sale_ship_fee" type="text" id="sale_ship_fee" value="<? echo $sale_ship_fee;?>" size="10" maxlength="10">
          </div></td>
        </tr>
        <tr align="right">
          <td align="left">Discount:</td>
          <td>&yen;</td>
          <td><div align="left">      <input name="sale_discount" type="text" value="<? echo $sale_discount;?>" size="10" maxlength="10">
          </div></td>
        </tr>
        <tr align="right">
          <td align="left">Tax :</td>
          <td>&nbsp;            </td>
          <td><div align="left">
          <input name="sale_tax" type="text" id="sale_tax" value="<? echo $sale_tax;?>" size="10" maxlength="10">
          %</div></td>
        </tr>
		<tr align="right">
		  <td align="left"> Order status: <? echo $sts;?></td>
		  <td>&nbsp; </td>
		  <td><div align="left">
		  <select name="sts" id="sts">
		 <option value="A" <? if ($sts=="A") { echo "selected=\"selected\"";}?>>Active</option>
			<option value="C" <? if ($sts=="C") { echo "selected=\"selected\"";}?>>Cancel</option>
			<option value="B" <? if ($sts=="B") { echo "selected=\"selected\"";}?>>Back</option>
			<option value="O" <? if ($sts=="O") { echo "selected=\"selected\"";}?>>Out Of Stock</option>
</select>
		  </div></td>
		 <tr>
		
      </table>
      <br>

      <table width="305" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="right"><br>
              <input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
              <input name="isupdate" type="submit" id="isdis" value="Update">
            
          </td>
        </tr>
      </table>
      <br>

            <? 
	 if ($sale_ref!='')
	 get_edit_list($sale_ref); 
	 ?>
            <br>
            <br>



      <br>
      <table width="654" border="1" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC" style="text-align:center">
          <td width="213">Product No.</td>
          <td width="162"><div align="center">Products Name</div></td>
          <td>&#x6750;&#x8CEA;</td> <!-- ?è³ª -->
          <td>&#x984F;&#x8272;</td> <!-- ?»è‰² -->
          <td width="82"><div align="center">Qty Unit</div></td>
          <td width="117"><div align="center">Unit Price </div></td>
          <td width="68"><div align="center">&nbsp; </div></td>
        </tr>
        <tr>
          <td>
          	<div align="center">
              <input name="sprod_id_1" type="text" id="sprod_id_1" onchange="findPMProduct('<?=PM_URL ?>', 1);">
              <input name="isfind" type="button" id="isfind" value="Find" onClick="openProdWin(1)">
			</div>
		</td>
          <td><div align="center">
            <input name="sprod_name_1" type="text" id="sprod_name_1">
          </div></td>
          
          <td>
          	<select name="sprod_material_option_1[]" id="sprod_material_option_1" multiple>
				<option value="&#12503;&#12521;&#12473;&#12481;&#12483;&#12463;&#35069;&#21697;">&#12503;&#12521;&#12473;&#12481;&#12483;&#12463;&#35069;&#21697;</option>
				<option value="&#12473;&#12486;&#12531;&#12524;&#12473;&#35069;&#21697;">&#12473;&#12486;&#12531;&#12524;&#12473;&#35069;&#21697;</option>
				<option value="&#36554;&#29992;&#12501;&#12525;&#12450;&#12510;&#12483;&#12488;">&#36554;&#29992;&#12501;&#12525;&#12450;&#12510;&#12483;&#12488;</option>
				<option value="&#36554;&#29992;LED">&#36554;&#29992;LED</option>
				<option value="&#12473;&#12486;&#12450;&#12522;&#12531;&#12464;&#65288;&#12456;&#12450;&#12496;&#12483;&#12463;&#28961;&#12375;&#65289;">&#12473;&#12486;&#12450;&#12522;&#12531;&#12464;&#65288;&#12456;&#12450;&#12496;&#12483;&#12463;&#28961;&#12375;&#65289;</option>
				<option value="&#12459;&#12540;&#12486;&#12531;">&#12459;&#12540;&#12486;&#12531;</option>
				<option value="PVC&#35069;&#21697;">PVC&#35069;&#21697;</option>
				<option value="&#12521;&#12496;&#12540;&#35069;&#21697;">&#12521;&#12496;&#12540;&#35069;&#21697;</option>
				<option value="&#12513;&#12483;&#12461;&#35069;&#21697;">&#12513;&#12483;&#12461;&#35069;&#21697;</option>
				<option value="&#38788;">&#38788;</option>
				<option value="&#36001;&#24067;">&#36001;&#24067;</option>
				<option value="&#34915;&#39006;">&#34915;&#39006;</option>
				<option value="&#24067;">&#24067;</option>
				<option value="&#12496;&#12483;&#12486;&#12522;&#12540;&#28961;&#12375;">&#12496;&#12483;&#12486;&#12522;&#12540;&#28961;&#12375;</option>
				<option value="&#38598;&#25104;&#26448;">&#38598;&#25104;&#26448;</option>
			</select>
          	&#12381;&#12398;&#20182;
          	<input name="sprod_material_1" type="text" id="sprod_material_1">
          </td>
          	
          <td>
          	<select name="sprod_colour_option_1" id="sprod_colour_option_1">
          		<option value="">&#12381;&#12398;&#20182;</option>
	          	<option value="&#40658;">&#40658;</option>
				<option value="&#33590;">&#33590;</option>
				<option value="&#32058;">&#32058;</option>
				<option value="&#12467;&#12540;&#12498;&#12540;">&#12467;&#12540;&#12498;&#12540;</option>
				<option value="&#12464;&#12524;&#12540;">&#12464;&#12524;&#12540;</option>
				<option value="&#12458;&#12524;&#12531;&#12472;">&#12458;&#12524;&#12531;&#12472;</option>
				<option value="&#30333;">&#30333;</option>
				<option value="&#12502;&#12521;&#12454;&#12531;">&#12502;&#12521;&#12454;&#12531;</option>
				<option value="&#12459;&#12540;&#12461;">&#12459;&#12540;&#12461;</option>
				<option value="&#12505;&#12540;&#12472;&#12517;">&#12505;&#12540;&#12472;&#12517;</option>
				<option value="&#27700;&#33394;">&#27700;&#33394;</option>
				<option value="&#12500;&#12531;&#12463;">&#12500;&#12531;&#12463;</option>
				<option value="&#32209;">&#32209;</option>
				<option value="&#36196;">&#36196;</option>
				<option value="&#12502;&#12523;&#12540;">&#12502;&#12523;&#12540;</option>
				<option value="&#40644;">&#40644;</option>
          	</select>
          
          	<input name="sprod_colour_1" type="text" id="sprod_colour_1">
          </td>
          	
          <td>
                <div align="center">
                  <input name="sprod_unit_1" type="text" id="sprod_unit_1" size="8" maxlength="8">
              </div></td>
          <td> <div align="center">&yen;
                      <input name="sprod_price_1" type="text" id="sprod_price_1" size="7" maxlength="7">
          </div></td>
          <td>
                <div align="center">
                  <input type="submit" name="isadd" value="Add" onclick="addClickAction()">
              </div></td></tr>
      </table>
      <br>
      <br>
     
	 <? 
	 if ($sprod_id!='' and isset($_POST['isfind']))
	 getprodlike_list($sprod_id); 
	 ?>
</td>
                </tr>
              </table>
      
            <br>
            <br><br>
              <p>&nbsp;              </p>
            </form>


<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function addClickAction() {
	document.form1.event.value = 'add';
}

function checkFields() {
missinginfo = "";

if (document.form1.event.value != 'add') {
	if (document.form1.sale_name.value == "") {
	missinginfo += "\n     -  Name";
	}
}
/*Else {
	//Validate product no.
	var isValid = true;
	var query = '';
	var invalidProductInfo = 'The following product no. does not exist\n';

	$('input:text[name^="sprod_id_"]').each(function(index, value) {
		query = query + 'product_id[]=' + $(value).val() + '&';
	});

	$.ajax({
			url: 'checkProductNotExist.php?' + query, 
			dataType: 'json',
			async: false,
			success: function(data) {
				if (data != '') {
					isValid = false;
					$(data).each(function(index, value) {
						invalidProductInfo = invalidProductInfo + value + '\n';
					});
				}
			}
	});

	if (!isValid) {
		alert(invalidProductInfo);
		return false;
	}
}*/

if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}
else return true;
}
//  End -->
</script>

<script type="text/javascript" src="calendarDateInput.js">
</script>
<SCRIPT>
	$(function() {
		$('#cust_cd').change(function() {
			var selectOpt = $('option:selected', this);
			document.forms[0].sale_name.value = selectOpt.text().substring(selectOpt.val().length + 3);
		});
	});
	
	function confirmDelete(id, ask, url) //confirm order delete
	{
		temp = window.confirm(ask);
		if (temp) //delete
		{
			window.location=url+id;
		}
	}
	function open_window(link,w,h)
	{
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	}
	
</SCRIPT>
