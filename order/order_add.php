  
  
  
          <TD vAlign=top bgColor=#eefafc>
          
<? if ($import) {
	if ($import_success) { ?>
		<br><font size=3 color=red >Import Order Success !</font>
	<? } else { ?>
		<br><span style="color:red">Import Order Fail !<?=$error_message ?></span>
<? 	}
} ?>
           
<? if ($order_success=='') { ?>

           	 <form name="form2" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>&sale_ref=<?= $sale_ref;?>" enctype="multipart/form-data">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
              	<tr>
              		<td>
              			<input type="file" name="updOrderFile" id="updOrderFile">
						<input name="importYahoo" type="submit" value="Import Yahoo" />
						<input name="importYahooShopping" type="submit" value="Import Yahoo Shipping" />
						<input name="importRakuten" type="submit" value="Import &#27005;&#22825;" />
              		</td>
              	</tr>
            	</table>
            </form>
           
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>&sale_ref=<?= $sale_ref;?>" onSubmit="return checkFields();">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td>
					 <input type="checkbox" name="address_restriction" id="address_restriction" value="Y"> &#21046;&#38480;&#35299;&#38500;
				     <br>
                      Number of Product 

                      <select name="prod_n" onChange="javascript:location.href='index.php?page=<?=$page?>&subpage=<?=$subpage?>&prod_n='+this.options[this.selectedIndex].value">
                        <? 
						 for ($i=1;$i<=20;$i++)
						  {
						  if ($prod_n==$i)
						  echo "<option value='$i' selected>$i</option>";
						  else
						  echo "<option value='$i'>$i</option>";
						  
						 }
						 ?>
                      </select>
                      <br>
                      <br>
      Sales Date: 
      <script>DateInput('orderdate', true, 'YYYY-MM-DD')</script>
      <br>
     
      <? echo $sale_order_no_message; ?><br>
      <table width="586" border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td width="140"><input name="sale_ref_a" id="sale_ref_a" type="radio" value="a" checked>
          Order No. (Yahoo) </td>
          <td width="159"><input id="sale_ref_aa" name="sale_ref_aa" type="text"></td>
          <td width="153"><input name="sale_ref_a" type="radio" value="b">		    
            <input name="sale_ref_bb" type="hidden" value="<? echo getsale_ref_next();?>">
              Order No. (Auto)</td><td width="106"><? echo getsale_ref_next(); ?>&nbsp;</td>
        </tr>
      </table>
      <br>
      <table width="609" border="0" cellspacing="0" cellpadding="0">
      	<tr>
      		<td height="43">
      			Customer Code (Optional):
      			<select name="cust_cd" id="cust_cd">
      					<option></option>
      				<? foreach ($customers as $customer) {?>
      					<option value="<?=$customer['cust_cd'] ?>"><?=$customer['cust_cd'].' - ' .$customer['cust_company_name'] ?></option>
      				<? }?>
      			</select>
      		</td>
      	</tr>
        <tr>
          <td height="43">Client Email:
            <input name="sale_email" type="text" id="sale_email"></td>
          <td>Client Name:
            <input name="sale_name" type="text" id="sale_name"></td>
        </tr>
        <tr>
          <td width="324" height="43"><br>
            Sales Group
  <? getgroup_select($_SESSION[user_name]);?>
			   <!--  <a href="group_list.php" onClick="NewWindow(this.href,'mywin','250','400','no','center');return false" onFocus="this.blur()">Edit Group List</a> -->              </td>
          <td width="285"><br>Client Yahoo ID:
            <input name="sale_yahoo_id" type="text" id="sale_yahoo_id"></td>
        </tr>
      </table>
      <br> <br>
            <br>

            
      <table width="1100" border="1" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC" style="text-align:center">
          <td width="213">Product No.</td>
          <td width="162">Products Name</td>
          <td>&#x6750;&#x8CEA;</td> <!-- 材質 -->
          <td>&#x984F;&#x8272;</td> <!-- 頻色 -->
          <td>Qty Unit</td>
          <td width="117">Unit Price</td>
          <td width="82">Stock</td>
          </tr>
        <? for ($j=1;$j<=$prod_n;$j++) {?>
          
		<tr>
			<td><div align="center">
				<input name="sprod_id_<? echo $j?>" type="text" id="sprod_id_<? echo $j?>" onchange="findPMProduct('<?=PM_URL ?>', <?=$j ?>);">
				<input name="isfind" type="button" id="isfind" value="Find" onClick="openProdWinByCustCd(<?=$j ?>, document.forms[1].cust_cd.value)">
			</div></td>
			<td><div align="center">
				<input name="sprod_name_<? echo $j?>" type="text" id="sprod_name_<? echo $j?>">
			</div></td>
			<td>
				<select name="sprod_material_option_<? echo $j?>[]" id="sprod_material_option_<? echo $j?>" multiple>
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
	          	<br />
	          	&#12381;&#12398;&#20182;
				<input name="sprod_material_<? echo $j?>" type="text" id="sprod_material_<? echo $j?>">
			</td>
			<td>
				<select name="sprod_colour_option_<? echo $j?>" id="sprod_colour_option_<? echo $j?>">
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
				<input name="sprod_colour_<? echo $j?>" type="text" id="sprod_colour_<? echo $j?>">
			</td>
			<td>
				<div align="center">
					<input name="sprod_unit_<? echo $j?>" type="text" id="sprod_unit_<? echo $j?>" size="4" maxlength="4">
				</div>
			</td>
			<td>
				<div align="center">&yen;
					<input name="sprod_price_<? echo $j?>" type="text" id="sprod_price_<? echo $j?>" size="10" maxlength="10">
				</div>
			</td>
			<td>
				<div align="center">
					<input name="stock_<? echo $j?>" type="text" id="stock_<? echo $j?>" size="8" disabled="disabled">
				</div>
			</td>
          </tr> <? }?>
      </table>
	  	  <br>
</td>
                </tr>
              </table>
                            <br>
            <br><br>
              <table width="246" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="120"><div align="right">Shipping fee :</div></td>
                  <td width="25"> <div align="right">&yen;
                  </div></td>
                  <td width="101"><input name="sale_ship_fee" type="text" id="sale_ship_fee" value="<? echo $sale_ship_fee;?>" size="10" maxlength="10"></td>
                </tr>
                <tr>
                  <td><div align="right">Discount :</div></td>
                  <td><div align="right">&yen;
                  </div></td>
                  <td><input name="sale_discount" type="text" value="<? echo $sale_discount;?>" size="10" maxlength="10"></td>
                </tr>
                <tr>
                  <td><div align="right">Tax :</div></td>
                  <td>
                        <div align="right">                        </div></td>
                  <td><input name="sale_tax" type="text" id="sale_tax" value="<? echo $sale_tax;?>" size="10" maxlength="10">
%</td>
                </tr>
                <tr>
                  <td colspan="3" align="right"><br>
					<input name="ref_sale_h" type="hidden" value="<? echo $sale_ref;?>">
					</td>
                  </tr>
              </table>
                  <p>
                    <input type="submit" name="isorder" value="New Order" >
</p>
            </form> 
            <table width="964" border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td width="20">&nbsp; </td>
                <td width="882">
                
<? } else {
	// Order add success
	echo "Order No. :".$sale_ref."<br>";
	$getsale_row=getsale_data($sale_ref);
	echo "Sale Date: ";
	echo $getsale_row['sale_date']."<br>";
	echo "Client Name: ";
	echo $getsale_row['sale_name']."<br>";
	echo "Client Email: ";
	echo $getsale_row['sale_email']."<br>";
	echo "Client Yahoo ID: ";
	echo $getsale_row['sale_yahoo_id']."<br>";
	
	echo "<br><br>";
	getsale_prod($sale_ref); 
	echo "<br><font size=3 color=red >Order Success ! Click&quot; Add New Order&quot; for New Order.</font>" ;
	
}
?></td>
              </tr>
            </table>
            
	        <p>&nbsp;</p>
            </TD>

<script type="text/javascript">
$(function() {
	$('#cust_cd').change(function() {
		var selectOpt = $('option:selected', this);
		$('#sale_name').val(selectOpt.text().substring(selectOpt.val().length + 3));
	});

	
	 
	<? if ($error_msg != '') {?>
		alert('<?=$error_msg ?>');
	<? }?>
});
</script>
