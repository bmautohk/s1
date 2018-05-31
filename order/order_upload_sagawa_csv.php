<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload SAGAWA Tracking No</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		 
		
		<strong>SAGAWA Tracking No</strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					Ben Ref No.
				</td>
				<td>
					Sagawa Tracking No
				</td>
				<td>
					Sagawa Delivery Date
				</td>
			</tr>
			
			<? for ($i=0;$i<sizeof($benRefNos);$i++) {?>
				<tr>
					<td><?=$benRefNos[$i]?></td>
					<td><?=$trackingNos[$i]?></td>
					<td><?=$sagawa_del_date[$i]?></td>
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