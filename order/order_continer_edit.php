<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Edit Container</strong><br>
		<input type="hidden" name="id" value="<?=$container['id'] ?>" />
		<input type="hidden" name="action" value="save" />
		
		<table>
			<tr>
				<td>Packing No:</td>
				<td><input type="text" name="packing_no" value="<?=$container['packing_no']?>" /></td>
			</tr>
		 	<tr>
		 		<td>Product ID:</td>
		 		<td><input type="text" name="product_id" value="<?=$container['product_id']?>" /></td>
		 	</tr>
		 	<tr>
		 		<td>Color:</td>
		 		<td><input type="text" name="color" value="<?=$container['color']?>" /></td>
		 	</tr>
		 	<tr>
		 		<td>Piece:</td>
		 		<td><input type="text" name="piece" value="<?=$container['piece']?>" /></td>
		 	</tr>
		 	<tr>
		 		<td>Qty:</td>
		 		<td><input type="text" name="qty" value="<?=$container['qty']?>" /></td>
		 	</tr>
		 	<tr>
		 		<td>Custom:</td>
		 		<td><input type="text" name="custom" value="<?=$container['custom']?>" /></td>
		 	</tr>
		</table>
		
		<input type="button" name="save" value="Save" onclick="goSave()"/>
		<input type="button" name="save" value="Back" onclick="goBack()"/>
		
		
	</FORM>
</TD>

<script type="text/javascript">
	<? if (isset($msg)) {?>
		alert('<?=$msg?>');
	<? } ?>

	function goSave() {
		document.form1.submit();
	}

	function goBack() {
		window.location = 'index.php?page=order&subpage=upload_container';
	}
</script>