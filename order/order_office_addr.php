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

include('order_office_addr_logic.php');

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
        	<td height="50" width="340"><div align="center"><?=$success_msg?></div></td>
        </tr>
		<tr class="content">
			<td colspan="2">
            	<strong>Office Address</strong>
				<form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
                  <table border="1" cellpadding="0" cellspacing="0">
                    <tr align="center" valign="top">
						<td>Default</td>
						<td width="80"><div align="center">Office Name</div></td>
						<td width="253"><div align="center">Address</div></td>
						<td> <div align="center">Post Acc. No.</div></td>
						<td> <div align="center">Post Acc. Name </div></td>
                    </tr>
                    <? for ($i = 0; $i < sizeof($name); $i++) { ?>
                    <tr>
                    	<td align="center"><input type="radio" readonly="readonly" <? if($office_addr_id == $id[$i]) { ?> checked="checked" <? } ?>/></td>
                    	<td><a href="order_office_addr_maint.php?id=<?=$id[$i] ?>"><?=$name[$i] ?></a></td>
                        <td><?=$address1[$i] ?> <?=$address2[$i] ?> <?=$address3[$i] ?><br>
                        </td>
						
					<td><?=$post_acc_no[$i]?></td>
					<td><?=$post_acc_name[$i]?></td>
                    </tr>
					 <? } ?>

                  </table>
					<input type="button" value="Add" onClick="goAdd()" />
                </form>
			</td>
		</tr>
	</table>
</TD>
</TR>
</TBODY>
</TABLE>

<script type="text/javascript">
	function goAdd() {
		window.location = 'order_office_addr_maint.php';
	}
</script>

</BODY>