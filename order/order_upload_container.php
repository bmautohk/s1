<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload Container</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		
		
		<strong>Container List</strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>Packing No</td>
				<td>Product ID</td>
				<td>Color</td>
				<td>Piece</td>
				<td>Qty</td>
				<td>custom</td>
				<td>&nbsp;</td>
			</tr>
			
			<? foreach ($containers as $container) {?>
				<tr>
					<td><?=$container['packing_no']?>&nbsp;</td>
					<td><?=$container['product_id']?>&nbsp;</td>
					<td><?=$container['color']?>&nbsp;</td>
					<td><?=$container['piece']?>&nbsp;</td>
					<td><?=$container['qty']?>&nbsp;</td>
					<td><?=$container['custom']?>&nbsp;</td>
					<td><a href="index.php?page=order&subpage=continer_edit&id=<?=$container['id'] ?>">Edit</a></td>
				</tr>
			<? }?>
			
		</table>
		
	</FORM>
</TD>

<script type="text/javascript">
	<? if (isset($msg)) {?>
		alert('<?=$msg?>');
	<? } ?>
</script>