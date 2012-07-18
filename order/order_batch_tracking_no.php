<TD vAlign=top bgColor=#eefafc>
	<div style="margin-left:20px">
		<? if (isset($_POST['isSubmit'])) {
				if (sizeOf($successList)) {
		?>
				<br>
				The "Shipping Date" of the following orders are updated:
				<table border="1" cellspacing="0" cellpadding="0">
					<tr>
						<td>Auction ID</td><td>Tracking No.</td>
						<? foreach ($successList as $order) {?>
							<tr>
								<td><?=$order['check_ref'] ?></td><td><?=$order['check_shipping'] ?></td>
							</tr>
					<? }?>
					</tr>
				</table><br>
				<? } ?>
				<br>
			
			<? if (sizeOf($failList)) {?>
				Fail to process the following tracking no.:
				<table border="1" cellspacing="0" cellpadding="0">
					<tr>
						<td>Tracking No.</td><td>Reason</td>
					</tr>
					<? foreach ($failList as $order) {?>
						<tr>
							<td><?=$order['check_shipping'] ?></td><td><?=$order['reason'] ?></td>
						</tr>
					<? }?>
				</table><br>
			<? } ?>
		<? } ?>
	
		<FORM name="form1" id="form1" method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" >
			<strong>Please fill in shipped tracking no.:</strong><br>
			<textarea name="tracking_no" cols="30" rows="10"></textarea>
			<br>
			<input type="submit" name="isSubmit" value="Submit" />
			
			<br><br>
			<b>Remarks:</b>
			<ol>
				<li>
					The input format is:<br>
					tracking no 1&lt;enter&gt;<br>
					tracking no 2&lt;enter&gt;<br>
					...<br>
				</li>
			</ol>
		</FORM>
	</div>
</TD>

<script type="text/javascript">
	
</script>