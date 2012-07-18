<?php

//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();

require('../config.php');  //this should the the absolute path to the config.php file 
//(ie /home/website/yourdomain/login/config.php or 
//the location in relationship to the page being protected - ie ../login/config.php )
require('../functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above


if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
	include ('../no_access.html'); //this should the the absolute path to the no_access.html file - see above
	exit;
}

include('order_office_addr_maint_logic.php');

?>

<LINK href="../style1.css" type=text/css rel=STYLESHEET>
<? require('../header_script.php'); ?>
<META content="MSHTML 6.00.2900.2722" name=GENERATOR><meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR>
<TD width="104%" height="100%" vAlign=top bgColor=#eefafc>
	
    
    <table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<TD vAlign=top bgColor=#eefafc>
			<p></p>
            
			<table width="500" border="0" cellspacing="0" cellpadding="0" height="24">
				<tr valign="middle">
                <td height="24">
                <br>                  
                  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
                  	<tr>
                    	<td>
                        	<font color='red'><?=$error_msg?></font><?=$success_msg?>
                        </td>
                    </tr>
                    <tr>
                      <td height="18" style="border: 1px solid #4B2C01">
                      	<? if ($doWhat == 'add') { ?>
                      	<div align="left" class="whead">&nbsp;<span class="style1">Create Office Address</span></div>
                        <? } else { ?>
                        <div align="left" class="whead">&nbsp;<span class="style1">Edit Office Address</span></div>
                        <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td>


                    
<form action="order_office_addr_maint.php" method="POST" enctype="multipart/form-data" name="form1" id="form1">
					<input type="hidden" name='doWhat' value="<?=$doWhat?>" />
                    <input type="hidden" name='id' value="<?=$id?>" />
                    <input type="hidden" name='user_office_addr_id' value="<?=$user_office_addr_id?>" />
                    <table width="435" border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                            <td width="75">Name</td>
                            <td width="360"><input type='text' name='name' value='<?=$name?>' /></td>
                      </tr>
                      <tr>
                      	<td colspan="2"><b>Address</b></td>
                      </tr>
                      <tr>
                      	<td>Line 1</td>
                        <td><input type='text' name='address1' size="50" value='<?=$address1?>' /></td>
                      </tr>
                      <tr>
                      	<td>Line 2</td>
                        <td><input type='text' name='address2' size="50" value='<?=$address2?>' /></td>
                      </tr>
                      <tr>
                      	<td>LIne 3</td>
                        <td><input type='text' name='address3' size="50" value='<?=$address3?>' /></td>
                      </tr>
					  
					  <tr>
						<td>Post Acc No.</td>
						<td><input type='text' name='post_acc_no' size="50" value='<?=$post_acc_no?>'/></td>
					  </tr>
					  
					  <tr>
						<td>Post Acc Name</td>
						<td><input type='text' name='post_acc_name' size="50" value='<?=$post_acc_name?>'/></td>
					  </tr>
                      <tr>
                      	<td>
							Default:
                        </td>
                        <td>
                        	<input type="checkbox" name="isDefault" <? if ($isDefault) { ?> checked="checked" <? } ?> />
                        </td>
                      </tr>
                    </table>

                    <div style="text-align: left; width: 50%; float: left;">
                    	<input type="button" value="Submit" onClick="goSave()" />
                        <? if ($doWhat == 'edit') { ?>
                        <input type="button" value="Delete" onClick="goDelete()" />
                        <? } ?>
                    </div>
					<div style="text-align: right; width: 50%; float: left;"><input type="button" value="Back" onClick="goBack()" /></div>
</form>

                               
                               </td>
                            </tr>
                          </table>
                      
                      <br></td>
                    </tr>
                  </table>
                  
              	</td>
				</tr>
            </table>
		</TD>
        </tr>
      </table>


</TD>
</TR>
</TBODY>
</TABLE>

<script type="text/javascript">
	function goSave() {
		if (document.forms[0].name.value == '') {
			alert('Name must be fielded in!');
		}
		else {
			document.forms[0].submit();
		}
	}
	
	function goBack() {
		window.location = 'order_office_addr.php';
	}
	
	function goDelete() {
		if (confirm("Are you sure to delete the record?")) {
			document.forms[0].doWhat.value = 'delete';
			document.forms[0].submit();
		}
	}
</script>

</BODY>
