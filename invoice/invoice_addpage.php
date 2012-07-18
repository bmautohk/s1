<TD vAlign=top bgColor=#eefafc>
           <? //echo $sql;
		?>
		   <? if ($order_success==''){
           ?>
		    <form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?sale_ref=<?= $sale_ref;?>" onSubmit="return checkFields();">
              <table width="680" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td>
                      <br>
                      Number of Product 

                      <select name="prod_n" onChange=javascript:location.href='order_add.php?prod_n='+this.options[this.selectedIndex].value>
                        <? 
 for ($i=1;$i<=10;$i++)
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
          <td width="140"><input name="sale_ref_a" type="radio" value="a" checked>
          Order No. (Yahoo) </td>
          <td width="159"><input name="sale_ref_aa" type="text"></td>
          <td width="153"><input name="sale_ref_a" type="radio" value="b">		    
            <input name="sale_ref_bb" type="hidden" value="<? echo getsale_ref_next();?>">
              Order No. (Auto)</td><td width="106"><? echo getsale_ref_next(); ?>&nbsp;</td>
        </tr>
      </table>
      <br>
      <table width="609" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>Client Email:
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

            
      <table width="584" border="1" cellpadding="0" cellspacing="0">
        <tr bgcolor="#CCCCCC">
          <td width="213"><div align="center">Product No. </div></td>
          <td width="162"><div align="center">Products Name</div></td>
          <td width="82"><div align="center">Qty Unit</div></td>
          <td width="117"><div align="center">Unit Price </div></td>
          </tr>
        <? for ($j=1;$j<=$prod_n;$j++) {?>
          
		<tr>
          <td><div align="center">
		      <input name="sprod_id_<? echo $j?>" type="text" id="sprod_id_<? echo $j?>">
              <input name="isfind" type="button" id="isfind" value="Find" onClick="window.open('order_find_product.php?prod_sel=<? echo $j?>','popuppage','width=500,height=400,top=100,left=100 scrollbars=1');">
</div></td>
          <td><div align="center">
            <input name="sprod_name_<? echo $j?>" type="text" id="sprod_name_<? echo $j?>">
          </div></td>
          <td>
                    <div align="center">
                      <input name="sprod_unit_<? echo $j?>" type="text" id="sprod_unit_<? echo $j?>" size="3" maxlength="2">
                    </div></td>
          <td> <div align="center">&yen;
                      <input name="sprod_price_<? echo $j?>" type="text" id="sprod_price_<? echo $j?>" size="10" maxlength="10">
          </div></td>
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
                    <input type="submit" name="isorder" value="New Order">
</p>
            </form> 
            <table width="964" border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td width="20">&nbsp; </td>
                <td width="882"><? }else {
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