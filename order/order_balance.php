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

	echo "Client Yahoo ID: ";

	echo $getsale_row['sale_yahoo_id']."<br>";

	

	echo "<br><br>";

	getsale_prod($sale_ref); 

?>
</font>
	</td>

  </tr>

</table>
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']."?page=$page&subpage=$subpage&sale_ref=".$sale_ref; ?>">

              <table width="806" height="269" border="0" cellspacing="10">

                <tr>

                  <td width="650" valign="top"><table width="775" height="154" border="0" cellpadding="0" cellspacing="0">

                      <tr>

                        <td width="131" valign="top">Payment :</td>

                        <td>&yen;

                          <input name="bal_pay" type="text" class="standard" id="bal_pay" value="<? echo $bal_pay;?>"></td>

                        <td width="87" style="vertical-align:top"><div align="left">Payment Type:</div></td>

                        <td width="282">
                        	<div align="left">JNB

                              <input name="bal_pay_type" type="radio" value="JNB" <? if ($bal_pay_type=='JNB') {echo "checked";} ?>>

                            Bank

                            <input name="bal_pay_type" type="radio" value="Bank" <? if ($bal_pay_type=='Bank') {echo "checked";} ?>>

                            Yahoo

                            <input name="bal_pay_type" type="radio" value="Yahoo" <? if ($bal_pay_type=='Yahoo') {echo "checked";} ?>>

                            Post Office
                            <input name="bal_pay_type" type="radio" value="Post Office" <? if ($bal_pay_type=='Post Office') {echo "checked";} ?>>
                            <br />
                            
                            <? echo mb_convert_encoding('コンビニ決済', "EUC-JP","UTF-8"); ?>
                            <input name="bal_pay_type" type="radio" value="Store" <? if ($bal_pay_type=='Store') {echo "checked";} ?>>
                            
                            <? echo mb_convert_encoding('クレカ決済', "EUC-JP","UTF-8"); ?>
                            <input name="bal_pay_type" type="radio" value="Credit Card" <? if ($bal_pay_type=='Credit Card') {echo "checked";} ?>>
                            
							<? echo mb_convert_encoding('カード決済', "EUC-JP","UTF-8"); ?>
                            <input name="bal_pay_type" type="radio" value="Card" <? if ($bal_pay_type=='Card') {echo "checked";} ?>>
                            
                            <br />
                            
							<? echo mb_convert_encoding('楽天Edy決済', "EUC-JP","UTF-8"); ?>
                            <input name="bal_pay_type" type="radio" value="Rakuten" <? if ($bal_pay_type=='Rakuten') {echo "checked";} ?>>

                        	</div>
                        </td>

                      </tr>

                      <tr>

                        <td valign="top">Rest Payment :</td>

                        <td width="158">

						&yen;

						<? 

						

						$sale_row = getsale_data($sale_ref);

						

						$sale_tax = $sale_row['sale_tax'];

						$sale_discount = $sale_row['sale_discount'];

						$sale_ship_fee = $sale_row['sale_ship_fee'];

						

						$sub_total = getsale_total($sale_ref);

						

						$total = number_format($sub_total-$sale_discount,2,'.','');

	$total_tax =$total * $sale_tax / 100; 

	$total_tax = number_format(round($total_tax, 0),2,'.','');

	$total = number_format($total + $sale_ship_fee + $total_tax,2,'.','');

	

						

						$balance = number_format($total - $bal_pay,2,'.','');

						echo $balance;

												 ?>

						

						</td>

                        <td>Shipping Tpye:</td>

                        <td>COD

                          <input name="bal_ship_type" type="radio" value="COD" <? if ($bal_ship_type=='COD') {echo "checked";} ?>>

                          Charge Buyer 

                          <input name="bal_ship_type" type="radio" value="CB" <? if ($bal_ship_type=='CB') {echo "checked";} ?>>

                          None

                          <input name="bal_ship_type" type="radio" value="" <? if ($bal_ship_type=='') {echo "checked";} ?> >

						</td>

                      </tr>
                      
                       <tr>

                        <td valign="top">&nbsp;</td>

                        <td colspan="3">&nbsp;</td>

                      </tr>
                      
                      <tr>
                        <td valign="top">&#37197;&#36948;&#26085; : </td> <!-- 配達日 -->

                        <td colspan="3">
                        	<input name="bal_delivery_date" type="text" value="<? echo $bal_delivery_date; ?>" size=20 />
                        	<small><a href="javascript:showCal('Calendar2')">Select Date</a></small>
                        </td>
                      </tr>
                      
                      <tr>
                        <td valign="top">&#37197;&#36948;&#26178;&#38291; : </td> <!-- 配達時間 -->

                        <td colspan="3">
                        	<select name="bal_delivery_time_option_id" id="bal_delivery_time_option_id">
                        		<option value="">&#12381;&#12398;&#20182;</option>
                        		<? echo getdelivery_time($bal_delivery_time_option_id); ?>
                        	</select>
                        	<input name="bal_delivery_time" id="bal_delivery_time" type="text" value="<? echo $bal_delivery_time; ?>" <?=$bal_delivery_time_option_id == '' ? '' : 'disabled' ?> />
                        </td>
                      </tr>

                      <tr>

                        <td valign="top">&nbsp;</td>

                        <td colspan="3">&nbsp;</td>

                      </tr>

                      <tr>

                        <td valign="top">Re- send Tracking : </td>

                        <td colspan="3">

                          <p>

                                <input name="return_track" type="text" class="standard" id="return_track" value="<? echo $return_track;?>">

                                <br>

                                <br>

                          </p>

                      </td></tr>

                      <tr>

                        <td valign="top">Re - send Date : </td>

                        <td colspan="3"> 

						 <input name="return_date" type="text" value="<? echo $return_date; ?>" size=20>

                          <small><a href="javascript:showCal('Calendar')">Select Date</a></small>

                          <? 

						//if ($return_date!='')

						/*echo "<script>DateInput('return_date', true, 'YYYY-MM-DD','$return_date')</script>";

						else 

                        echo "<script>DateInput('return_date', true, 'YYYY-MM-DD')</script>";

						*/

						?>

                          <br>

                          <br></td>

                      </tr>

                      <tr>

                        <td valign="top">Remark : </td>

                        <td colspan="3"> <? echo $debt_remark;?>                         <br>

                          <br></td>

                      </tr>

                      <tr>

                        <td valign="top">Return</td>

                        <td colspan="3">&yen;

                          <input name="return_pay" type="text" class="standard" value="<? echo $return_pay;?>">
                          
                        </td>

                      </tr>
                      
                    </table>

                      <br>

                      <input name="isupdate" type="submit" id="isupdate" value="Update">

                      <input name="sale_ref" type="hidden" value="<? echo $sale_ref;?>">

                      <br></td>

                </tr>

              </table>

            </form>
            
<script type="text/javascript">
$(function() {
	
	$('#bal_delivery_time_option_id').change(function() {
		var select_id = $('option:selected', this).val();
		
		if (select_id == '') {
			$('#bal_delivery_time').removeAttr('disabled');
		} else {
			$('#bal_delivery_time').attr('disabled', true);
		}
	});
});
</script>
            
<script language="javascript" src="cal2.js"></script>

<script language="javascript" src="cal_conf2.js"></script>



<script type="text/javascript" src="calendarDateInput.js">

</script>

<SCRIPT>

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