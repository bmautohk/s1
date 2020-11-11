<TD vAlign=top bgColor=#eefafc>
          
	<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
		<strong>Upload Click Post Excel</strong><br>
		File Name: <input name="uplFile" type="file" class="content">
		<input type="submit" name="action" value="Upload" /><br><br>
		 
		
		<strong>clickpost Tracking No</strong><br>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					Ben Ref No.
				</td>
				<td>
					Click Post Tracking No
				</td>
				<td>
					Click Post  Delivery Date
				</td>
			</tr>
			
			<? for ($i=0;$i<sizeof($benRefNos);$i++) {?>
				<tr>
					<td><?=$benRefNos[$i]?></td>
					<td><?=$trackingNos[$i]?></td>
					<td><?=$clickpost_del_date[$i]?></td>
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