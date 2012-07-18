<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload JP Tracking No</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		
		<? if (sizeOf($duplicateTrackingNos) > 0) {?>
			<strong>Duplicate Tracking No in Upload File</strong><br>
			<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					JP Tracking No
				</td>
			</tr>
			
			<? foreach ($duplicateTrackingNos as $trackingNo) {?>
				<tr>
					<td><?=$trackingNo?></td>
				</tr>
			<? }?>
			
		</table>
		<br><br>
		<? }?>
		
		
		<strong>Existing Active Tracking No</strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					JP Tracking No
				</td>
			</tr>
			
			<? foreach ($trackingNos as $trackingNo) {?>
				<tr>
					<td><?=$trackingNo['tracking_no']?></td>
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