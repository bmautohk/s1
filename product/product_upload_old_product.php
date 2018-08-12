<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong></strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>		
	</FORM>
	
	<strong>Upload Old Product</strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					Product ID
				</td>
			 
			</tr>
			
			<? for ($i=0;$i<sizeof($prod_id_arr);$i++) {?>
				<tr>
					<td><?=$prod_id_arr[$i]?></td>
					 
				</tr>
			<? }?>
			
		</table>
		
</TD>

<script type="text/javascript">
	<? if (isset($msg)) {?>
		alert('<?=$msg?>');
	<? } ?>
</script>