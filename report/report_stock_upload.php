<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Stock Upload </strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		 
		
		<strong>Stock Upload </strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				 
				<td>
					ProductID
				</td>
				<td>
				   Stock
				</td>
			</tr>
			
			<? for ($i=0;$i<sizeof($product_id_arr);$i++) {?>
				<tr>
					<td><?=$product_id_arr[$i]?></td>
					<td><?=$qty_arr[$i]?></td>
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