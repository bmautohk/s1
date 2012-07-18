<table width="568"  border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
		<td height="18" bgcolor="#666666"><div align="left" class="whead"></div>
	</tr>
    
    <tr>
	  <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"><br>
        
        <table width="537" border="0" cellspacing="0" cellpadding="0">
            <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"></td>
            <tr class="content">
                <td width="150"><div align="center"></div></td>
                <td colspan="2">
                  <form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" name="form1" id="form1" onSubmit="return CheckText()">
                        <table width="350" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="120">Make</td>
                                <td width="104">
                                
                                <? 
                                    if (isset($_GET['make_id']))
                                        {getmake_selection($_GET['make_id']);}
                                    else
                                        {getmake_selection('');}
                                ?>                                </td>
                            </tr>
                            <tr>
                                <td>Model</td>
                                <td><input name="model_name" type="text" id="model_name"></td>
                            </tr>
                        </table> 
                        <br>
                      <? if (isset($_GET['make_id']))
                            {
                                if ($_GET['make_id']!=''){
                        ?>
                      <input name="isadd" type="submit" id="isadd" value="Add">
                      <? }}?>
                      <br>
                        <br><br>
                    <? echo $added_message;?>
                  </form>
                    <hr align="left">
                    <div align="left"></div>                    </td>
            </tr>
        </table>
	</td>
	</tr>
</table>

<script>

function CheckText(){
	var name = form1.model_name;

	if(name.value == null || name.value == ""){
		alert("New model No cannot be empty!");
		name.focus();
		return false;
	}
}
</script>