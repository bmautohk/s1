
          <TD vAlign=top bgColor=#eefafc>
            <p>              
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?>
            </p>
            <table width="677" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="568"  border="0" align="center" cellpadding="2" cellspacing="0">
                    
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table width="573" border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td width="150"><div align="center">
 
                              </div></td>
                              <td colspan="2">
                                <form action="<?= $_SERVER['PHP_SELF']."?page=report&subpage=fix_inventory&product_id=".$product_id; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return formCheck(this);">
                                  <div align="left">
<? 
	echo "<input type='hidden' name='ID' value='".@$ID."'>"; 
	if (isset($_GET['mod']))
		echo "<font color=red>Please, use different Product ID</font>";
	
	echo "<font color=red>$error_msg</font>";
					
	$getprod_row = getProductData($product_id);
	$product_id = $getprod_row['product_id'];
	
  
?>
                    <br>
                    <table width="450" border="0" cellpadding="0" cellspacing="0">
					<tr>
                    	<td width="120">Product ID</td>
                    	<td width="327"><? echo $product_id;?>
                    	  <input name="product_id" type="hidden" value="<?=$product_id ?>" /></td>
					</tr>
				 
					   
                       
                      
					  <tr>
                      	<td>Fix Inventory Stock Bal</td>
                      	<td><input type=text name='fix_inventory_qty' value='<?=$getprod_row['fix_inventory_qty']?>' /></td>
                      </tr> 
                      
                    </table> 
                                   
                 <?php if ($product_id!="") {?>
                  <input name="submit" type="submit" class="content" value="Submit">
				  <input name="submitted" type="hidden" value="edit"/>
				 <?php }?>
                                  </div>
                                </form>
                              
                               </td>
                            </tr>
                          </table>
                          <br></td>
                    </tr>
                  </table></td>
                </tr>
         
            </table>
            <p><br>
            </p></TD>

 