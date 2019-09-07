<TD vAlign=top bgColor=#eefafc>
	
---------------------------------------------------------------------------------------------------------------------------------------------------<br>

<table width="180" border="0" cellspacing="10"> <tr><td>

	<FORM method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">

		Products ID: 

		<input name="prod_id" type="text" id="prod_id" value="<?=$prod_id?>">
	<br> 
		RealStock:
		 <input name="real_stock" type="text" id="real_stock" value="<?=$real_stock?>">
		<br>

		<table width="406" border="0">

		<tr>

			<td width="30">From</td>

			<td width="100">

			<? if (isset($_POST['date_start'])) {
	 
				$date_start = $_POST['date_start'];
	 
				echo "<script>DateInput('date_start', true, 'YYYY-MM-DD', '$date_start')</script>";
	 
			}else {
	 
				echo "<script>DateInput('date_start', true, 'YYYY-MM-DD','2018-01-01')</script>";
	 
			}					  
 
			?>

			&nbsp;</td>

			<td width="16">To </td>

			<td width="84">					

			<? if (isset($_POST['date_end'])) {
	  
				$date_end = $_POST['date_end'];
	  
				echo "<script>DateInput('date_end', true, 'YYYY-MM-DD', '$date_end')</script>";
	  
			}else {
	  
				echo "<script>DateInput('date_end', true, 'YYYY-MM-DD')</script>";
	  
			}					  

			?>

			&nbsp;</td>

		</tr>

		</table>

		<br> 
		<input name="action" type="hidden" id="action" value="A">	
		 <input name="search_date" type="submit" id="search_date" value="Search by Date">
		 
	</FORM>   </p>
    
    <table id="example" class="table table-striped table-bordered" >              
	<thead>
	<tr  valign="top">
		<th ></th>
        <th  >Product ID</th>
		<th >pcs</th>
		<th  >Shipped after 12/7</th>
        <th  >Stock from upload container</th>
         <th  >Fix Stock Bal</th>
        
		 <th  >RealStock</th>

        <th  >Product Name </th>
		<th  >Product Cust Desc </th>
		<th  >Product Make </th>
		<th  >Product Model </th>
		<th  >Product Model No</th>
		
		<th  >Remark</th>
		
		<th  >cus_price rmb</th>
		<th  >year</th>
		<th  >material</th>
		<th  >colour</th>
		<th  >colour_no</th>
		 <th  >Fix Inventory Stock Bal</th> 
		
    </tr></thead>
	  <tbody>
		<?

		$j=0;
		for ($i = 0; $i < $prod_n; $i++) {

		$realStock=$sprod_stockbal[$i]-$sprod_shipAfter14[$i]+$sprod_fix_inventory_qty[$i];
		if($realStock==$real_stock || $real_stock==''){
		?>
        <tr valign="top">
			<td ><?=$j+1?></td>
            <td ><?=$sprod_id[$i]?></td>
			<td ><?=$sprod_product_pcs[$i]?></td>
			   
			<td ><?=$sprod_shipAfter14[$i]?></td>
			<td ><?=$sprod_stockbal[$i]?></td>
			<td ><?=$sprod_fix_inventory_qty[$i]?></td>
			
			<td ><?=$realStock?></td>


			<td ><?=$sprod_name[$i]?></td>
			<td ><?=$sprod_product_cus_des[$i]?></td>
			<td ><?=$sprod_make[$i]?></td>
			<td ><?=$sprod_model[$i]?></td>
			<td ><?=$sprod_product_model_no[$i]?></td>
		    
			 <td ><?=$sprod_product_remark[$i]?></td>
			  
			   <td ><?=$sprod_product_cost_rmb[$i]?></td>
			    <td ><?=$sprod_product_year[$i]?></td>
				 <td ><?=$sprod_product_material[$i]?></td>
				 <td ><?=$sprod_product_colour[$i]?></td>
				  <td ><?=$sprod_product_colour_no[$i]?></td>
				  <td ><a href="/index.php?page=report&subpage=fix_inventory&product_id=<?=$sprod_id[$i]?>">EDIT</a></td>
				  
				 
		
        </tr>
        <?$j++;
		}
		
		}?>
		</tbody>
    </table>
	
 
	<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        buttons: [ 'copy', 'excel'],
		dom: "<'row'<'col-sm-2'lB><'col-sm-4'f>><'row'<'col-sm-16'tr>><'row'<'col-sm-2'i><'col-sm-4'p>>",
		aoColumns: [
                  			{ "sType": 'numbercase' },
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null,
                  			null
		                 ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );</script>
	  
 
	 
	
</td></tr></table>
</td>