
          <TD vAlign=top bgColor=#eefafc>
           <table border="0" cellspacing="10" cellpadding="0">
               <tr>
                 <td><form name="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
                 
					<input name="page" type="hidden" id="page" value="<?=$page?>">
					<input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">
             
             <br>
             <table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="200">Product No. </td>
                    <td><input name="sprod_id" id="sprod_id" type="text" /></td>
                    <td>&nbsp;</td>
                    <td width="200">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Product JP No (Alias)</td>
                    <td><input name="product_jp_no" id="product_jp_no" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>Product US No (Alias)</td>
                    <td><input name="product_us_no" id="product_us_no" type="text" /></td>
                  </tr>
                  
                  <tr>
                    <td>Make </td>
                    <td>
                    	<select name="make_id" onchange="makeChange(this)">
                    		<option value=""></option>
                    		<? foreach ($makes as $make) {?>
                    			<option value="<?=$make['make_id'] ?>"><?=$make['make_name'] ?></option>
                    		<? }?>
                    	</select>
                    </td>
                    <td>&nbsp;</td>
                    <td>Model</td>
                    <td>
                    	<select name="product_model" id="product_model">
                    	</select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>Model No.</td>
                    <td><input name="product_model_no" id="product_model_no" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Year 前期/後期</td>
                    <td><input name="product_year" id="product_year" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Item Group</td>
                    <td><? getprod_cat("");	?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>
                    <td>PCS</td>
                    <td><input name="product_pcs_min" id="product_pcs_min" type="text" size="5"/> To <input name="product_pcs_max" id="product_pcs_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>PCS (JP)</td>
                    <td><input name="product_stock_jp_min" id="product_stock_jp_min" type="text" size="5"/> To <input name="product_stock_jp_max" id="product_stock_jp_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Item Description</td>
                    <td><input name="product_name" id="product_name" type="text" size="45" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Colour</td>
                    <td><input name="product_colour" id="product_colour" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Colour No</td>
                    <td><input name="product_colour_no" id="product_colour_no" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>
                    <td>Original Color</td>
                    <td><input name="product_original_color" id="product_original_color" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>
                    <td>Remark</td>
                    <td><input name="product_remark" id="product_remark" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>
                    <td>Custom Descrption</td>
                    <td><input name="product_cus_des" id="product_cus_des" type="text" size="45" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Stock Level</td>
                    <td><input name="product_stock_level" id="product_stock_level" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Location</td>
                    <td><input name="product_location" id="product_location" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>Supplier</td>
                    <td><input name="product_sup" id="product_sup" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>User Price</td>
                    <td><input name="product_price_u_min" id="product_price_u_min" type="text" size="5"/> To <input name="product_price_u_max" id="product_price_u_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Custom Price</td>
                    <td><input name="product_cus_price_min" id="product_cus_price_min" type="text" size="5"/> To <input name="product_cus_price_max" id="product_cus_price_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Auction Price</td>
                    <td><input name="product_auction_p_min" id="product_auction_p_min" type="text" size="5"/> To <input name="product_auction_p_max" id="product_auction_p_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Selling Price</td>
                    <td><input name="product_price_s_min" id="product_price_s_min" type="text" size="5"/> To <input name="product_price_s_max" id="product_price_s_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Cost (RMB)</td>
                    <td><input name="product_cost_rmb_min" id="product_cost_rmb_min" type="text" size="5"/> To <input name="product_cost_rmb_max" id="product_cost_rmb_max" type="text" size="5"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Magazine</td>
                    <td><input name="maz" id="maz" type="text" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                   <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>Display on Web</td>
                    <td>
                    	<select name="product_web" id="product_web">
                    		<option value="">All</option>
                    		<option value="Y">Yes</option>
                    		<option value="N">No</option>
                    	</select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>QC</td>
                    <td>
                    	<select name="product_qc" id="product_qc">
                    		<option value="">All</option>
                    		<option value="Y">Yes</option>
                    		<option value="N">No</option>
                    	</select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>受注生産</td>
                    <td>
                    	<select name="prod_on_order" id="prod_on_order">
                    		<option value="">All</option>
                    		<option value="Y">Yes</option>
                    		<option value="N">No</option>
                    	</select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  
				  <tr>
				  <td>Special Product</td>
				  <td><select name="sagawa_label" id="sagawa_label">
                    		 <option value="">All</option>
                    		<option value="Y">Yes</option>
                    		<option value="N">No</option>
                    	</select> </td>
				  </tr>
            </table>
            <input name="isfind" type="submit" id="isfind" value="Find" />
            
			</form>     </td>
               </tr>
             </table>   
            <br>
        <? 
	 //if ($sprod_id!='' and isset($_POST['isfind']))
	 if (isset($isfind)) {
	 ?>
	 	<? paging_table_header("product", "search", $num_rows, $zpage, $per_page, $searchKey); ?>
	 	<table align="center" border="1" cellpadding="0" cellspacing="0">
		<tr align="center" valign="top">
			<td width="61" height="30"><div align="center">Product ID</div></td>
			<td width="87"><div align="center">Product Name</div></td>
			<td width="67">Real Stock PCS</td>
			<td width="54">JP</td>
			<td width="78">PCS-ORDER</td>
			<td width="47">Color</td>
			<td width="62">Price (Users)</td>
			<td width="68">Price (Supplier)</td>
			<td width="68">Cost (RMB)</td>
			<td width="69">Catogery</td>
			<td width="22">Web</td>
			<td width="47"><div align="center">Dit</div></td>
			<td width="57">Loc.</td>
			<td width="57">searchable</td>
		</tr>
		<? foreach($products as $product) {?>
			<tr align="center" valign="top" height="25">
				<td><a href="index.php?page=product&subpage=edit&product_id=<?=urlencode($product["product_id"])?>"><?=$product["product_id"]?></a></td>
				<td><?=$product["product_name"] ?>&nbsp;</td>
				<td><?=$product["product_pcs"] -  getprod_shipped($product["product_id"]) ?>&nbsp;</td>
				<td><?=$product["product_stock_jp"] ?>&nbsp;</td>
				<td><?=$product["product_pcs"] -  getprod_order($product["product_id"]) ?>&nbsp;</td>
				<td><?=$product["product_colour"] ?>&nbsp;</td>
				<td><?=$product["product_price_u"] ?>&nbsp;</td>
				<td><?=$product["product_price_s"] ?>&nbsp;</td>
				<td><?=$product["product_cost_rmb"] ?>&nbsp;</td>
				<td><?=$product["product_cat"] ?>&nbsp;</td>
				<td><?=$product["product_web"] == 1 ? "Yes" : "-" ?></td>
				<td><?=$row["product_dit"]=='' ? "&nbsp;" : "<a href =\"dit_file\\$product_dit\" target=\"_blank\">".$product_dit."</a>" ?>&nbsp;</td>
				<td><?=$product["product_location"] ?>&nbsp;</td>
				<td><?=$product["searchable"] ?>&nbsp;</td>
			</tr>
		<? } ?>
		</table>
		<p></p>
		<?
	 } 
	 ?></TD>

<script type="text/javascript">
	function makeChange(elem) {
		$.getJSON('product/searchModel.php', {make_id: elem.value}, function(data) {
 			var items = [];

 			items.push('<option value=""></option>');
			$.each(data, function(i, item) {
				items.push('<option value="' + item.model_name + '">' + item.model_name + '</opton>');
			});

			$('#product_model').html(items.join(''));
		});
	}
</script>
