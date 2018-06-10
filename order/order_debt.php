<table width="600" border="0" cellspacing="0" cellpadding="10">

  <tr>

    <td>
<font color="red">

<? 

	echo "Order No. :".$sale_ref."<br>";
	
	$getsale_row=getsale_data($sale_ref);
	
	echo "Sale Date: ";
	
	echo $getsale_row['sale_date']."<br>";
	
	echo "Client Name: ";
	
	echo $getsale_row['sale_name']."<br>";
	
	echo "Client Email: ";
	
	echo $getsale_row['sale_email']."<br>";
	
	echo "<br><br>";
	
	getsale_prod($sale_ref); 
	
?>
</font>

	</td>

  </tr>

</table>

<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>&sale_ref=<?=$sale_ref?>" <?php if ($getsale_row['address_restriction']!='Y'){ echo 'onSubmit="return checkFields();"';}?>>

              <table width="587" height="381" border="0" cellspacing="10">

                <tr>

                  <td width="600"><table width="600" height="343" border="0" cellpadding="0" cellspacing="0">

                      <tr>

                        <td>Client Name</td>

                        <td><input name="sale_name" type="text" class="standard" id="sale_name" value="<? echo $getsale_row['sale_name'];?>"></td>

                        <td>&nbsp;</td>

                        <td>&nbsp;</td>

                      </tr>

                      <tr>

                        <td>Client Email </td>

                        <td><input name="sale_email" type="text" class="standard" id="sale_email" value="<? echo $getsale_row['sale_email'];?>"></td>

                        <td>Client Email </td>

                        <td><input name="sale_email2" type="text" class="standard" id="sale_email2" value="<? echo $getsale_row['sale_email2'];?>"></td>

                      </tr>

                      <tr>

                        <td width="79">Tel.</td>

                        <td width="176"><input name="debt_tel" type="text" class="standard" id="debt_tel" value="<? echo $debt_tel;?>"></td>

                        <td width="94">Mobile</td>

                        <td width="239"><input name="debt_mobile" type="text" class="standard" id="debt_mobile" value="<? echo $debt_mobile;?>"></td>

                      </tr>

<tr>

<td height="5">&nbsp;</td>

<td height="5" colspan="3">&nbsp;</td>

</tr>

<tr>

<td>Client Address</td>

<td colspan="3"><input name="debt_cust_address1" type="text" class="standard" id="debt_cust_address1" value="<? echo $debt_cust_address1;?>" size="50"></td>

</tr>

<tr>

<td>&nbsp;</td>

<td colspan="3"><input name="debt_cust_address2" type="text" class="standard" id="debt_cust_address2" value="<? echo $debt_cust_address2;?>" size="50"></td>

</tr>

<tr>

<td>&nbsp;</td>

<td colspan="3"><input name="debt_cust_address3" type="text" class="standard" id="debt_cust_address3" value="<? echo $debt_cust_address3;?>" size="50"></td>

</tr>

<tr>

<td>Post code</td>

<td colspan="3"><input name="debt_post_co" type="text" class="standard" id="debt_post_co" value="<? echo $debt_post_co;?>" size="10" maxlength="50"></td>

</tr>

<tr>

<td>&nbsp;</td>

<td colspan="3">&nbsp;</td>

</tr>

<tr>

<td>Remark</td>

<td colspan="3">                          <input name="debt_remark" type="text" class="standard" id="debt_remark" value="<? echo $debt_remark;?>" size="70"></td>

</tr>

<tr>

<td>&nbsp;</td>

<td colspan="3">&nbsp;</td>

</tr>

<tr>

<td>Client's Payment Name </td>

<td colspan="3"><input name="debt_pay_name" type="text" class="standard" id="debt_pay_name" value="<? echo $debt_pay_name;?>" size="50">                          </td>

</tr>

<tr>

<td>Bank </td>

<td colspan="3"><input name="debt_bank" type="text" class="standard" id="debt_bank" value="<? echo $debt_bank;?>" size="50"></td>

</tr>

<tr>

<td>Pay method</td>

<td colspan="3"><select name="debt_pay_method" class="standard" id="debt_pay_method">

<option value="Bank in" <? if ($debt_pay_method=="Bank in"){echo "selected";}?>>Bank in</option>

<option value="Cash" <? if ($debt_pay_method=="Cash"){echo "selected";}?>>Cash</option>

<option value="Cheque" <? if ($debt_pay_method=="Cheque"){echo "selected";}?>>Cheque</option>

</select></td>

</tr>

<tr>

<td>Shipping Method</td>

<td colspan="3"><select name="debt_shipping_method" class="standard" id="debt_shipping_method">

<option value="Air Mail" <? if ($debt_shipping_method=="Air Mail"){echo "selected";}?> >Air Mail</option>

<option value="EMS" <? if ($debt_shipping_method=="EMS"){echo "selected";}?> >EMS</option>

<option value="Air Parcel" <? if ($debt_shipping_method=="Air Parcel"){echo "selected";}?> >Air Parcel</option>

</select></td>

</tr>

</table>

<br>

<input name="isupdate" type="submit" id="isupdate" value="Update">

<input name="sale_ref" type="hidden" value="<? echo $sale_ref;?>">

<br></td>

</tr>

</table>

</form>

<?

$sale_row = getsale_data($sale_ref);

$sale_email = $sale_row['sale_email'];

if ($sale_email!='') {

?>

<br>

<table width="448" height="24" border="0" cellpadding="10">

<tr>

<td width="354">

	<form name="form1" method="get" target="_blank" action="debt_email_t.php">
	
		<? getgroup_select($_SESSION[user_name]); ?>
		
		<a href="email_list.php?sale_group=ben" onClick="NewWindow(this.href,'mywin','400','420','no','center');return false" onFocus="this.blur()">Edit Email List</a>
		
		<br>
		
		<br>
		
		<!--<input type="submit" name="Submit" value="Sent Email to client">-->
		
		<input name="Submit" type="Submit" id="preview" value="Preview">  
		
		<input name="outlook" type="Submit" id="outlook" value="Preview Outlook">  
		
		<input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
	
	</form>
</td>
</tr>
</table>

<? } ?>

