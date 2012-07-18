<TD vAlign=top bgColor=#eefafc>
	<br>
	
	<form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" name="form1" id="form1" onSubmit="return CheckText()">
	<?echo $message; ?>
	<table>
		<td valign="top">
			Model<br>
			<select name="model_id" id="model_id">
				<? foreach($models as $model) {?>
				<option value="<?=$model['model_id'] ?>" <? if ($model['model_id'] == $model_id) { ?>selected="selected"<? }?>><?=$model['model_name'] ?></option>
				<? }?>
			</select>
		</td>
		<td valign="top">
			Model No.<br>
			<select name="model_no_id[]" multiple="multiple" size="20">
				<? foreach($modelNos as $modelNo) {?>
				<option value="<?=$modelNo['model_no_id'] ?>" <? if ($modelNo['is_select'] == 1) { ?>selected="selected"<? }?>><?=$modelNo['model_no'] ?></option>
				<? }?>
			</select>
		</td>
		<td valign="top">
			<br>
			<input type="submit" name="save" value="Save" />
		</td>
	</table>
	</form>
</TD>

<script type="text/javascript">
$(function() {
	$('#model_id').change(function() {
		form1.submit();
	});
});
</script>