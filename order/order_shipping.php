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

?>
	</font>
	<?
$debt_row=getdebt_data($sale_ref);
//echo "Customer Name:". $debt_row['debt_cust_name']."<br>";
echo "Tel.:". $debt_row['debt_tel']."<br>";
echo "Mobile:". $debt_row['debt_mobile']."<br>";
echo "Address1:". $debt_row['debt_cust_address1']."<br>";
echo "Address2:". $debt_row['debt_cust_address2']."<br>";
echo "Address3:". $debt_row['debt_cust_address3']."<br>";
echo "Post Code:". $debt_row['debt_post_co']."<br>";


echo getdate_data($sale_ref);
echo "<br><br>";
getsale_prod($sale_ref); 
?>
	
	</td>
  </tr>
</table>

<form name="form1" method="POST" action="<?=$_SERVER['PHP_SELF']."?page=$page&subpage=$subpage&sale_ref=$sale_ref"?>">
              <table width="809" height="236" border="0" cellspacing="10">
                <tr>
                  <td width="800" height="216" valign="top"><table width="600" height="228" border="0" cellpadding="0" cellspacing="0">
                      <tr valign="top">
                        <td width="121" height="64">Tracking No. :</td>
                        <td width="467"><input name="check_shipping" type="text" class="standard" id="check_shipping" value="<? echo $check_shipping;?>">
                          <? if ($check_shipping==''){
	                          echo "<input name=\"isupdate\" type=\"submit\" value=\"Update\"></td>";}
                          ?>
				      </tr>
                      <tr valign="top">
                        <td height="64">Japan Tracking No. :</td>
                        <td><!-- <input name="check_shipping_jp" type="text" class="standard" id="check_shipping" value="<? echo $check_shipping_jp;?>">-->
                        	<select name="check_shipping_jp">
                        		<option value="<?=$check_shipping_jp ?>"><?=$check_shipping_jp ?></option>
                        		<? foreach ($jpTrackingNoList as $jpTrackingNo) {?>
                        			<option value="<?=$jpTrackingNo ?>"><?=$jpTrackingNo ?></option>
                        		<? }?>
                        	</select>
                            <? if ($check_shipping_jp==''){
	                            echo "<input name=\"isupdate\" type=\"submit\" value=\"Update\"></td>";}
                            ?>
                          </tr>
                      <tr valign="top">
                        <td height="64">Shipping Date: </td>
                        <td>&nbsp; <input name="check_date" type="text" value="<? if ($check_date=='0000-00-00') {$check_date=date("Y-m-d");}
                        echo $check_date; ?>" size=20>
                          <small><a href="javascript:showCal('Calendar1')">Select Date</a></small></td>
                      </tr>
                      <tr valign="top">
                        <td height="18">Remark</td>
                        <td>
						<?
$row_debt = getdebt_data($sale_ref);
echo $row_debt['debt_remark']; 
?>
						
						&nbsp;</td>
                      </tr>
                      <tr valign="top">
                        <td height="18">&nbsp;</td>
						<td>
						<? /*if ($check_date!='' and $check_date!='0000-00-00'){
						
						echo "<script>DateInput('check_date', true, 'YYYY-MM-DD','$check_date')</script><br><br>";
						echo "<input name=\"isupdate\" type=\"submit\" id=\"isupship\" value=\"Update\">";
						}else{
						if ($check_shipping!=''){
						echo "<script>DateInput('check_date', true, 'YYYY-MM-DD')</script><br><br>";
						echo "";
						}
						}*/
?>
						<input name="isupdate" type="submit" value="Shipped">
						<input name="isupdate2" type="submit" value="Shipped & Go to Order">
						&nbsp; </td>
                      </tr>
                    </table>
                      <br>
                      <br>
                      <br>                      
                      <table width="800" border="0">
                        <tr><!--
                          <td width="195"><a href="javascript:void(0)" onClick="NewWindow('print_mail.php?sale_ref=<? echo $sale_ref;?>','mywin','800','500','no','center');return false" onFocus="this.blur()">Preview Form by Air Mail </a></td>
                          <td width="195"><a href="javascript:void(0)" onClick="NewWindow('print_ems.php?sale_ref=<? echo $sale_ref;?>','mywin','780','350','no','center');return false" onFocus="this.blur()">Preview Form by EMS</a></td>
                          <td width="210"><a href="javascript:void(0)" onClick="NewWindow('print_parcel.php?sale_ref=<? echo $sale_ref;?>','mywin','780','350','no','center');return false" onFocus="this.blur()">Preview Form by Air Parcel</a></td>
                          <td width="170">&nbsp; </td>
                        </tr>
                        <tr>
                          <td><a href="javascript:void(0)" onClick="NewWindow('print_jp.php?sale_ref=<? echo $sale_ref;?>','mywin','780','350','no','center');return false" onFocus="this.blur()">Preview Form by JP </a></td>
                          <td><a href="javascript:void(0)" onClick="NewWindow('print_jp2.php?sale_ref=<? echo $sale_ref;?>','mywin','780','350','no','center');return false" onFocus="this.blur()">Preview Form by JP with cash </a></td>
                          <td><a href="javascript:void(0)" onClick="NewWindow('print_1.php?sale_ref=<? echo $sale_ref;?>','mywin','780','350','no','center');return false" onFocus="this.blur()">Preview Form by 1 </a></td> -->
                          <td><? if ($check_shipping!=''){ ?>
                            <a href="ship_email.php?sale_ref=<?=$sale_ref; ?>" target="_blank">Preview Tracking Email</a>
                            <? }?></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>                       
                      <br>
                      <br>
                      <table width="448" height="24" border="0" cellpadding="10"><tr><td width="354">&nbsp;</td>
                          </tr>
                      </table>
                      Form:
                      	<select class='preview' id='opt_method'>
                        	<option value=''></option>
                            <option value='mail'>Air Mail</option>
                            <option value='ems'>EMS</option>
                            <option value='parcel'>Air Parcel</option>
                            <option value='jp'>JP</option>
                            <option value='jp2'>JP with cash</option>
				<option value='jp_post_cod'>JP Post COD</option>
				<option value='jp_post_cod2016'>JP Post COD 2016</option>
				<option value='jp_post_paid'>JP Post Paid</option>
				<option value='jp_sagawa_cod'>JP sagawa COD</option>
				<option value='jp_sagawa'>JP sagawa</option>
                            <option value='1'>1</option>
                        </select>
                        
                        Address:
                        <select class='preview' id='opt_addr'>
                        	<option value=''></option>
                        	<? foreach ($address_list as $addr): ?>
                            <option value='<?=$addr['id']?>' <? if ($addr['id'] == $userAddrId) { ?> selected="selected" <? }?>><?=$addr['name']?></option>
                            <? endforeach; ?>
                        </select>
                        <input type="button" id="btn_form_preview" value="Preview" />
                        <a href="#" onClick="open_window('order/order_office_addr.php','500','400')" onFocus="this.blur()">Add/Edit Address</a>
                        
                    	<br /><br />
                        Preview
                        <hr />
                        <!--div id='form_preview'>
                        </div-->
                        <iframe id='form_preview' src ="" width="100%" height="10">
	                        <p>Your browser does not support iframes.</p>
                        </iframe>
                        <hr />
					</td>
                </tr>
              </table>
            </form>
<?
$sale_row = getsale_data($sale_ref);
$sale_email = $sale_row['sale_email'];
if ($sale_email!='') {
	$group_row=getgroup_sale_data($sale_ref);
	$group3=$group_row["group3"];
?>
<br>
<table width="448" height="24" border="0" cellpadding="10">
  <tr>
    <td width="354"> 
	<form name="form2" method="get" target="_blank" action="ship_sent_email.php">
	After Shipped <br>
        <br>
        <!--<input type="submit" name="Submit" value="Sent Email to client">-->
        <input name="Submit" type="Submit" id="preview" value="Preview">
        <input name="outlook" type="Submit" id="outlook" value="Preview Outlook">
        <input name="sale_ref" type="hidden" id="sale_ref" value="<? echo $sale_ref;?>">
        <input name="group3" type="hidden" id="group3" value="<? echo $group3;?>">
    </form>
    </td>
</tr>
</table>
<? } ?>

<script language="javascript" src="cal2.js"></script>
<script language="javascript" src="cal_conf2.js"></script>

<script type="text/javascript" src="calendarDateInput.js">
</script>
<SCRIPT>
	//$('#btn_form_preview').attr('disabled', 'disabled');
	$(document).ready(function(){
		$('.preview').change(function(){
			var method = $('#opt_method').val();
			var addr_id = $('#opt_addr').val();
			if (method != '' && addr_id != '') {
				$('#form_preview').attr('height', '300');
				$('#form_preview').attr('src', 'print_ship_bottom_' + method + '.php?sale_ref=<?=$sale_ref?>&addr_id=' + addr_id);
				//$('#btn_form_preview').attr('disabled', 'disabled');
			}
			else {
				$('#form_preview').empty();
				//$('#btn_form_preview').attr('disabled', 'disabled');
			}
		});
		
		$('#btn_form_preview').click(function() {
			var method = $('#opt_method').val();
			var addr_id = $('#opt_addr').val();
			NewWindow('print_common.php?sale_ref=<?=$sale_ref;?>&addr_id=' + addr_id + '&print_method=' + method,'mywin','780','350','no','center');
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
<script language="javascript" type="text/javascript">
<!--
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>
