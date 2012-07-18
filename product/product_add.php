
          <TD vAlign=top bgColor=#eefafc>
            <p>              
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?>
            </p>
            <table width="677" border="0" cellspacing="0" cellpadding="0" height="24">
              <tr valign="middle">
                <td width="677" height="24"><br>                  
                  <table width="606"  border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td width="602" height="18" bgcolor="#666666"><div align="left" class="whead">&nbsp;<span class="style1">Upload your own picture</span></div></td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #4B2C01;border-right: 1px solid #4B2C01;border-left: 1px solid #4B2C01"> <br>
                          <table width="590" border="0" cellspacing="0" cellpadding="0">
                            <tr class="content">
                              <td width="150"><div align="center">

<?php
	echo $add_message;
	echo $disply_photo;
#--------------------------------#
# HTML FORM
#--------------------------------#
?>
                              </div></td>
                              <td width="440" colspan="2">
                                <form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return formCheck(this);">
                                  <div align="left">
                    <? 
			
			 echo "<input type='hidden' name='ID' value='".@$ID."'>"; 
			 ?>
                    <? 
					echo "<font color=red>$error_msg</font>";
					/*if (isset($_GET['mod'])) {
						$mod = $_GET['mod'];
						if ($mod == 'same_id') {
							//echo "<font color=red>Please, use different Product ID</font>";
							echo "<font color=red>$error_msg</font>";
						}
						else if ($mod == 'same_alias') {
							echo "<font color=red>Please, use different Alias Code</font>";
						}
					}*/
					
					?>
                    <br>
                    <table width="435" border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                            <td width="120">Product ID</td>
                            <td width="315"><input type='text' name='product_id' value='<?=$product_id?>' /></td>
                      </tr>
                      <tr>
                      	<td>Product JP No (Alias)</td>
                        <td><input type='text' name='product_jp_no' value='<?=$product_jp_no?>' /></td>
                      </tr>
                      <tr>
                      	<td>Product US No (Alias)</td>
                        <td><input type='text' name='product_us_no' value='<?=$product_us_no?>' /></td>
                      </tr>
                      <tr>
                        <td>Make</td>
                        <td><? 
						if (isset($_GET['make_id']))
						{getmake_selection($_GET['make_id']);}
						else if ($make_id != '') {
							getmake_selection($make_id);
						}
						else
						{getmake_selection('');}
						
						?></td>
                      </tr>
                      <tr>
                        <td>Model</td>
                        <td>
                        <div id="model_div">
                        <? 
						/*if (isset($_GET['make_id']))
						if ($_GET['make_id']!=''){
						{getmodelName_selection($_GET['make_id']);
						$php_self=$_SERVER['PHP_SELF'];
						echo "<a href=\"$php_self?page=$page&subpage=add_model&make_id=".$_GET['make_id']."\" target=\"_blank\">add model</a>";
						}}*/
                        
                        if (isset($_POST['make_id'])) {
                        	$make_id = $_POST['make_id'];
                        }
                        else {
                        	$make_id = 0;
                        }
                        getmodelName_selection($make_id, $product_model);
						if (isset($_POST['make_id']) && $_POST['make_id']!='') {
							$php_self=$_SERVER['PHP_SELF'];
							echo "<a href=\"$php_self?page=$page&subpage=add_model&make_id=".$_POST['make_id']."\" target=\"_blank\">add model</a>";
						}
						?>
						</div>
						</td>
                      </tr>
                      <tr>
                      	<td>Model No</td>
                      	<td>
                      		<div id="model_no_div">
                      		<?
                      		if (isset($_POST['product_model'])) {
                      			$product_model = $_POST['product_model'];
                      		}
                      		else {
                      			$product_model = '';
                      		}
                      		getmodelNo_selection($product_model, $product_model_no);
                      		?>
							</div>
                      	</td>
                      </tr>
                      
                      <tr>
                      	<td>Year 前期/後期</td>
                      	<td><input type=text name='product_year' value='<?=$product_year?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>Item Group</td>
                        <td>
							<? getprod_cat("$cat_id");	?>
                            <a href="product/product_add_category.php" onClick="NewWindow(this.href,'mywin','400','200','no','center');return false" onFocus="this.blur()">add item group</a>
                        </td>
                      </tr>
                       <tr>
                      	<td>Material</td>
                      	<td><input type=text name='product_material' value='<?=$product_material?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>PCS</td>
                        <td><input type=text name='product_pcs' value='<?=$product_pcs ?>' /></td>
                      </tr>
                      <tr>
                        <td>PCS (JP)</td>
                        <td><input type=text name='product_stock_jp' value='<?=$product_stock_jp?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>Item Description</td>
                      <td><input type=text size="45" name='product_name' value='<?=$product_name?>' /></td>
                      </tr>
                      
                     <tr>
                        <td>Colour</td>
                        <td><input type=text name='product_colour' value='<?=$product_colour?>' /></td>
                      </tr>
                      <tr>
                        <td>Colour No</td>
                        <td><input type=text name='product_colour_no' value='<?=$product_colour_no?>' /></td>
                      </tr>
                      <tr>
                        <td>Original Color</td>
                        <td><input type=text name='product_original_color' value='<?=$product_original_color?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>Remark</td>
                        <td><input type=text name='product_remark' value='<?=$product_remark ?>' /></td>
                      </tr>
                      
                      <tr>
                        <td>Custom Descrption</td>
                        <td><input type=text size="45" name='product_cus_des' value='<?=$product_cus_des?>' /></td>
                      </tr>
 
                      <tr>
                        <td>Stock Level </td>
                        <td><input type=text name='product_stock_level' value='<?=$product_stock_level ?>' /></td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td><input type=text name='product_location' value='<?=$product_location ?>' /></td>
                      </tr>
                      <tr>
                      	<td>Supplier</td>
                      	<td><input type=text name='product_sup' value='<?=$product_sup?>' /></td>
                      </tr>
					<tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>User Price </td>
                        <td>&yen;<input type=text name='product_price_u' value='<?=$product_price_u?>' /></td>
                      </tr>
                      <tr>
                        <td>Custom Price</td>
                        <td>&yen;<input type=text name='product_cus_price' value='<?=$product_cus_price?>' /></td>
                      </tr>
                      <tr>
                        <td>Auction Price</td>
                        <td>&yen;<input type=text name='product_auction_p' value='<?=$product_auction_p?>' /></td>
                      </tr>
                      <tr>
                        <td valign="top">Selling Price</td>
                        <td>
                        	<table id="sellingPriceTable" border="1" cellspacing="0">
                        		<tr bgcolor="#CCCCCC"><td>Customer</td><td>Price</td><td>Delete?</td></tr>
                        		<tr><td>Default</td><td>&yen;<input type=text name='product_price_s' value='<?=$product_price_s?>' /></td><td>&nbsp;</td></tr>
                        		<? 
                        		if (isset($custIds)) {
                        			foreach($custIds as $key => $custId) {?>
                        				<tr><td><select name="custIds[<?=$key ?>]"><option></option><?=str_replace("<option value='".$custId."'>", "<option value='".$custId."' selected='selected'>", $customerOptions) ?></select></td><td>&yen;<input type="text" name="custSellingPrices[<?=$key ?>]" value="<?=$custSellingPrices[$key] ?>" /></td><td><a href="javascript:void(0)" onclick="deleteSellingPrice(this)">Delete</a></td></tr>
                        		<? }
                        		}
                        		 ?>
                        	</table>
                        	<br>
                        	<input type="button" value="Add" onclick="addSellingPrice()" />
                        	<div style="display:none">
                        		<select id="custList">
                        			<option></option>
                        			<?=$customerOptions ?>
                        		</select>
                        	</div>
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Cost (RMB)</td>
                        <td>&yen;<input type=text name='product_cost_rmb' value='<?=$product_cost_rmb?>' /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<td>Magazine</td>
                      	<td><input type=text name='maz' value='<?=$maz?>' /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Display on Web </td>
                        <td><input name="product_web" type="checkbox" id="product_web" value="1" <? if ($product_web == '1') {?>checked="checked"<? }?>/></td>
                      </tr>
                      <tr>
                        <td>QC</td>
                        <td><input name="product_qc" type="checkbox" id="product_qc" value="Y" <? if ($product_qc == 'Y') {?>checked="checked"<? }?>></td>
                      </tr>
                      <tr>
                        <td>受注生産</td>
                        <td><input name="prod_on_order" type="checkbox" id="prod_on_order" value="Y" <? if ($prod_on_order == 'Y') {?>checked="checked"<? }?>></td>
                      </tr>
                    </table> 
                                    <br>
                    <input type="hidden" name="submitted" value="true">
                  Upload photo:<br>
                  <input name="<?= $upload_file_name; ?>" type="file" class="content">
                  <br>
                  Upload Dit file:<br>
                  <input name="dit_file" type="file" class="content">
                  <br>
                  <br>
                  <br>
                  <input name="submit" type="submit" class="content" value="Submit">
                                  </div>
                                </form>
                                <hr align="left">
                                <div align="left">
                                <?php
	
	
	if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
		echo "The best upload image size is 1024 * 768 px.<br> Image size is limited at 1MB.<br>Image only support jpeg.<br><br> ";
	}
	
echo $upload_message;

?></div></td>
                            </tr>
                          </table>
                      <br></td>
                    </tr>
                  </table></td>
                </tr>
              
            </table>
            <p><br>
            </p></TD>

<script type="text/javascript">
	$(function() {
		$('select[name="make_id"]').change(function() {
			makeChange(this);
		});

		$('select[name="product_model"]').change(function() {
			productModelChange(this);
		});
	});
	
	function makeChange(elem) {
		// Remove model no. option
		$('#model_no_div select').html('');

		$.getJSON('product/searchModel.php', {make_id: elem.value}, function(data) {
 			var items = [];

 			items.push('<option value=""></option>');
			$.each(data, function(i, item) {
				items.push('<option value="' + item.model_name + '">' + item.model_name + '</opton>');
			});

			<? $link = $_SERVER['PHP_SELF']."?page=$page&subpage=add_model"; ?>
			$('#model_div').html('<select name="product_model"></select><a href="<?=$link?>&make_id=' + elem.value + '" target="_blank">add model</a>');

			// Bind change event
			$('select[name="product_model"]').change(function() {
				productModelChange(this);
			});

			$('select[name="product_model"]').html(items.join(''));
		});
	}

	function productModelChange(elem) {
		$.getJSON('product/searchModelNo.php', {model_name: elem.value}, function(data) {
 			var items = [];

 			items.push('<option value=""></option>');
			$.each(data, function(i, item) {
				items.push('<option value="' + item.model_no + '">' + item.model_no + '</opton>');
			});

			$('#model_no_div').html('<select name="product_model_no"></select>');
			
			$('select[name="product_model_no"]').html(items.join(''));
		});
	}

	function addSellingPrice() {
		index = $('#sellingPriceTable tr').length - 2;
		$('#sellingPriceTable tr:last').after('<tr><td><select name="custIds[' + index + ']">' + $('#custList').html() + '</select></td><td>&yen;<input type="text" name="custSellingPrices[' + index + ']" /></td><td><a href="javascript:void(0)" onclick="deleteSellingPrice(this)">Delete</a></td></tr>');
	}

	function deleteSellingPrice(elem) {
		$(elem).parent().parent().remove();
	}
</script>