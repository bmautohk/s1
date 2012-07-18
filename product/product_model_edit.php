<table width="568"  border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
		<td height="18" bgcolor="#666666"><div align="left" class="whead"></div>
	</tr>
    
    <tr>
	  <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"><br>
        
        <table width="537" border="0" cellspacing="0" cellpadding="0">
            
            <tr class="content">
                <td width="150"><div align="center"></div></td>
                <td colspan="2">
                  <form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" name="form1" id="form1" onSubmit="return CheckText()">
                  		<input type="hidden" name="model_id" value="<?=$model['model_id']?>" />
                        <table width="350" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="120">Make</td>
                                <td width="104">
                                
                                <? getmake_selection($model['make_id']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Model</td>
                                <td><input name="model_name" type="text" id="model_name" value="<?=$model['model_name'] ?>"></td>
                            </tr>
                        </table> 
                        <br>
                      <input name="isedit" type="submit" id="isedit" value="Save">
                      <br>
                        <br><br>
                    <? echo $added_message;?>
                  </form>
               </td>
            </tr>
        </table>
	</td>
	</tr>
</table>

<script>

function CheckText(){
	if ($.trim($('select[name="make_id"]').val()) == '') {
		alert('Make cannot be blank!');
		$('select[name="make_id"]').focus();
		return false;
	}
	if ($.trim($('#model_name').val()) == '') {
		alert('Model Name cannot be blank!');
		$('#model_name').focus();
		return false;
	}
	return true;
}
</script>