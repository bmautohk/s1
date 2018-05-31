<TR>
    <TD background="admin_head_bg.gif" colSpan=7 
    height=34>&nbsp;&nbsp;<A class=big 
      href="http://www.apmzone.com/shop/admin.php"><B>Administrative 
      tools</B></A> (<A 
      href="logout.php">Logout</A>)</TD>
    <TD vAlign=top align=right 
    background="admin_head_bg.gif" 
      height=34>&nbsp;<A href="http://www.apmzone.com/shop/index.php">Main page</A></TD>
  </TR>
  <TR>
  
   <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1<? if ($page=="invoice"){ echo "_h";}?>.gif" 
            width=5 height="39"></TD>
          <TD background="admin_menu_3<? if ($page=="invoice"){ echo "_h";}?>.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="invoice_main.php?page=invoice&subpage=list">Invoice</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2<? if ($page=="invoice"){ echo "_h";}?>.gif" width="6" height="39"></TD>
        </TR></TBODY></TABLE></TD>
        
         <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1<? if ($page=="order"){ echo "_h";}?>.gif" 
            width=5 height="39"></TD>
          <TD background="admin_menu_3<? if ($page=="order"){ echo "_h";}?>.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="order_main.php">Order</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2<? if ($page=="order"){ echo "_h";}?>.gif" width="6" height="39"></TD>
        </TR></TBODY></TABLE></TD>
        
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1<? if ($page=="product"){ echo "_h";}?>.gif" 
            width=5></TD>
          <TD background="admin_menu_3<? if ($page=="product"){ echo "_h";}?>.gif">
            <TABLE width="85" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="prod_list.php">Product List</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2<? if ($page=="product"){ echo "_h";}?>.gif"></TD></TR></TBODY></TABLE></TD>
        
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1<? if ($page=="user"){ echo "_h";}?>.gif" 
            width=5></TD>
          <TD background="admin_menu_3<? if ($page=="user"){ echo "_h";}?>.gif">
            <TABLE width="78" cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="./admin/adminpage.php">User Page</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD width="26"><IMG 
        src="admin_menu_2<? if ($page=="user"){ echo "_h";}?>.gif"></TD></TR></TBODY></TABLE></TD>
        
    <TD align=middle width="1%" bgColor=#3faacf height=39>
      <TABLE height=39 cellSpacing=0 cellPadding=0 border=0>
        <TBODY>
        <TR>
          <TD width=5><IMG src="admin_menu_1<? if ($page=="report"){ echo "_h";}?>.gif" 
            width=5></TD>
          <TD background="admin_menu_3<? if ($page=="report"){ echo "_h";}?>.gif">
            <TABLE cellPadding=4>
              <TBODY>
              <TR>
                <TD align=middle><A 
                  href="report.php">Report</A></TD>
              </TR></TBODY></TABLE></TD>
          <TD><IMG 
        src="admin_menu_2<? if ($page=="report"){ echo "_h";}?>.gif"></TD></TR></TBODY></TABLE></TD>
    <TD align=middle width="1%" bgColor=#E1F0F6>&nbsp;      </TD>
    
    
    <TD width="99%" background="admin_menu_bg.gif" 
    height=39>&nbsp;&nbsp;<span class=big>&nbsp;&nbsp;Username: <? echo $_SESSION[user_name];?>&nbsp; </span> </TD></TR>