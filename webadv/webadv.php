<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Web Advertisement</TITLE>
</HEAD>
<BODY bgColor=#eefafc leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">

<TD vAlign=top bgColor=#eefafc>
        
		    <form name="form1" method="POST" action="webadv_result.php" onSubmit="return checkFields();">
            	<input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR']?>" />
                <input type="hidden" name="referrer" value="<?=$_SERVER['HTTP_REFERER']?>" />

              <table cellpadding=50>
              <tr><td>
                  <div class="heading"><strong>WEB ADV</strong></div>
                  <table border="1">
                    <tr>
                      <td width="140" align="right">Email @: </td>
                      <td><input name="email" type="text" id="email" /></td>
                    </tr>
                    <tr>
                      <td align="right">ITEM Code :</td>
                      <td width="341"><input name="item[]" type="text" /></td>
                    </tr>
                    <tr>
                      <td height="20"  align="right">ITEM Code :</td>
                      <td><input name="item[]" type="text" /></td>
                    </tr>
                    <tr>
                      <td height="20" align="right">ITEM Code :</td>
                      <td><input name="item[]" type="text" /></td>
                    </tr>
                    <tr>
                      <td height="20" align="right">ITEM Code :</td>
                      <td><input name="item[]" type="text" /></td>
                    </tr>
                    <tr>
                      <td height="20" align="right">ITEM Code :</td>
                      <td><input name="item[]" type="text" /></td>
                    </tr>
                    <tr>
                      <td height="31" align="right">Contact Phone No<br /></td>
                      <td><input name="contactNo" type="text" id="contactNo" size="40" /></td>
                    </tr>
                    <tr>
                      <td height="25">&nbsp;</td>
                      <td><input type="submit" name="save" id="save" value="Submit" /></td>
                    </tr>
                    </table>
                </td></tr>                
                </table>
              <p><br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br>
              </p>
<p>&nbsp;</p>
            </form>
  <p>&nbsp;</p>
            </TD>
           
<script type="text/javascript">
function checkFields() {
	missinginfo = "";
	
	if (document.form1.email.value == "" ) {
		missinginfo += "\n     -  E-mail";
	}
	
	if (document.form1.contactNo.value == "" ) {
		missinginfo += "\n     -  Contact Phone No";
	}
	
	// Check Item Code
	var elem = document.form1.elements["item[]"];
	var isItemExist = false;
	for (var i=0;i<elem.length;i++) {
		if (elem[i].value.replace(/^\s+|\s+$/g, '').length != 0) {
			isItemExist = true;
			break;
		}
	}
	if (!isItemExist) {
		missinginfo += "\n     -  At least 1 item must be filled!";
	}
	
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
</script>
</BODY>
</HTML>
