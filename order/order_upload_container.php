 
<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload Container</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		
		
		<strong>Container List</strong>
		 
		<table id="example" class="table table-striped table-bordered" style="width:50%">
		<thead>
			 <tr>
				<th>Packing No</th>
				<th>Product ID</th>
				<th>Qty</th>
				<th>Remark</th>
				<th>&nbsp;</th>
				<th>Upload Date</th>
				</tr>
			 </thead>
			
			<tbody>
			<? foreach ($containers as $container) {?>
				<tr>
					<td><?=$container['packing_no']?>&nbsp;</td>
					<td><?=$container['product_id']?>&nbsp;</td>
					 
					<td><?=$container['qty']?>&nbsp;</td>
					<td><?=$container['custom']?>&nbsp;</td>
					<td><a href="index.php?page=order&subpage=continer_edit&id=<?=$container['id'] ?>">Edit</a></td>
					<td><?=$container['creation_date']?>&nbsp;</td>
				</tr>
			<? }?>
			</tbody>
		</table>
		 
	</FORM>
</TD>
	<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
		 "order": [[ 5, "desc" ]],
        dom: "<'row'<'col-sm-2'l><'col-sm-2'f>><'row'<'col-sm-4'tr>><'row'<'col-sm-2'i><'col-sm-2'p>>"
         
    } );
 
    
} );</script>
	  
<script type="text/javascript">
	<? if (isset($msg)) {?>
		alert('<?=$msg?>');
	<? } ?>
</script>