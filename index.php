<?php include_once('security_check.php');?>
<? 
	if ($page!="" && $subpage!=""){
		include_once($page.'/'.$page.'_'.$subpage.'_logic.php');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Administrative tools</TITLE>
<? require ('header_script.php');?>
<? if ($page!="") { include_once($page.'/'.$page.'_js.php'); } ?>
<script type="text/javascript" src="calendarDateInput.js"></script>
<SCRIPT type="text/javascript" src="js/common.js"></script>
<SCRIPT type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<LINK href="style1.css" type=text/css rel=STYLESHEET>
</HEAD>
<BODY bgColor=#eeeeee leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <? include_once('page_header.php'); ?>
  <TR>
    <TD vAlign=top bgColor=#eefafc colSpan=11 height="100%"><TABLE cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD bgColor=#beddeb><? echo $tool_bar_array[$page]; ?></TD>
        </TR>
        <TR>
        <? 
		if ($page!=""){
			if ($subpage!=""){
				include_once($page.'/'.$page.'_'.$subpage.'.php'); 
			}
		}
		?>
          </TR>
          </TBODY>
        </TABLE>
       </TD>
     </TR>
   </TBODY>
</TABLE>
</BODY></HTML>
