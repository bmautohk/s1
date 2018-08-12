<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload SAGAWA Special product</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		 
		
		<strong></strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					ItemNo. Uploaded Successfully
				</td>
			 
			</tr>
			
			<? for ($i=0;$i<sizeof($trackingNos);$i++) {?>
				<tr>
					<td><?=$trackingNos[$i]?></td>
				 
				</tr>
			<? }?>
			 
		</table>
		<hr>
			<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					ItemNo. Uploaded Unsuccessfully
				</td>
			 
			</tr>
			
		 
			<? for ($i=0;$i<sizeof($notOK);$i++) {?>
				<tr>
					<td><?=$notOK[$i]?></td>
				 
				</tr>
			<? }?>
		</table>
		<hr>
			<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					ItemNo. Not Existing in the Ben S1
				</td>
			 
			</tr>
			
		 
			<? for ($i=0;$i<sizeof($notExist);$i++) {?>
				<tr>
					<td><?=$notExist[$i]?></td>
				 
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