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

            
<form name="form1" method="POST" action="<?= $_SERVER['PHP_SELF']."?page=$page&subpage=$subpage&sale_ref=$sale_ref" ?>" <?php if ($getsale_row['address_restriction']!='Y'){ echo 'onSubmit="return checkFields();"';}?>>
              <table width="587" height="236" border="0" cellspacing="10">
                <tr>
                  <td width="600" height="216" valign="top"><table width="600" height="82" border="0" cellpadding="0" cellspacing="0">
                      <tr valign="top">
                        <td width="121" height="64">Remark</td>
                        <td width="467"><textarea name="remark" cols="50" rows="5" id="remark"><? echo $remark;?></textarea>
				      </tr>
                      <tr valign="top">
                        <td height="18">&nbsp;</td>
						<td>
						<input name="isupdate" type="submit" value="Update">
						
						&nbsp; </td>
                      </tr>
                    </table>
                      <br>
                      <br>
                      <br>                      
                      </td>
                </tr>
              </table>
            </form>
            
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