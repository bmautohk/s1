<TD vAlign=top bgColor=#eefafc>
	<br>
	
	<? echo $message; ?>
	<form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" name="form1" id="form1">
		<input type="hidden" name="action" id="action" />
		
		<span style="float:left; margin-left:20px; margin-bottom:30px">
			<span style="height:100px">
				<table>
					<tr>
						<td>
							Make Name
						</td>
						<td>
							<input name="make_name" id="make_name" type="text" size="40" />
						</td>
						<td>
							<input type="button" id="add_make_btn" value="Add Make" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</span>
			<br>

			Make<br>
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>Make</td>
					<td>Delete?</td>
				</tr>
				<? foreach ($makes as $make) {?>
				<tr>
					<td><a href="index.php?page=product&subpage=make_edit&make_id=<?=$make['make_id'] ?>"><?=$make['make_name'] ?></a></td>
					<td><a href="javascript:goDeleteMake(<?=$make['make_id'] ?>)">Delete</a></td>
				</tr>
				<? } ?>
			</table>
		</span>
	
		<span style="float:left; margin-left:20px; margin-bottom:30px">
			<span style="height:100px">
				<table>
					<tr>
						<td>
							Make
						</td>
						<td>
							<? getmake_selection('') ?>
						</td>
					</tr>
					<tr>
						<td>
							Model
						</td>
						<td>
							<input name="model_name" id="model_name" type="text" size="40" />
						</td>
						<td>
							<input type="button" id="add_model_btn" value="Add Model" />
						</td>
					</tr>
				</table>
			</span>
			<br>

			Model<br>
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>Model</td>
					<td>Make</td>
					<td>Delete?</td>
				</tr>
				<? foreach ($models as $model) {?>
				<tr>
					<td><a href="index.php?page=product&subpage=model_edit&model_id=<?=$model['model_id'] ?>"><?=$model['model_name'] ?></a></td>
					<td><?=$model['make_name'] ?>&nbsp;</td>
					<td><a href="#" onclick="goDelete(<?=$model['model_id'] ?>)">Delete</a></td>
				</tr>
				<? } ?>
			</table>
		</span>
		
		<span style="float:left; margin-left:30px"">
			<span style="height:100px">
				<table>
					<tr>
						<td>
							Model No.
						</td>
						<td>
							<input name="model_no" type="text" id="model_no" size="40" />
						</td>
						<td>
							<input type="button" id="add_model_no_btn" value="Add Model No" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</span>
			<br>
			
			Model No.<br>
			<table border="1" cellpadding="0" cellspacing="0">
				<tr>
					<td>Model No</td>
					<td>Model</td>
					<td>Delete?</td>
				</tr>
				<? foreach ($modelNos as $modelNo) {?>
				<tr>
					<td><a href="index.php?page=product&subpage=model_no_edit&model_no_id=<?=$modelNo['model_no_id'] ?>"><?=$modelNo['model_no'] ?></a></td>
					<td><?=$modelNo['model_name'] ?>&nbsp;</td>
					<td><a href="#" onclick="goDeleteModelNo(<?=$modelNo['model_no_id'] ?>)">Delete</a></td>
				</tr>
				<? } ?>
			</table>
		</span>
	</form>
</TD>

<script type="text/javascript">
$(function() {
		// Remove unused change event
		$('select[name="make_id"]').removeAttr('onchange');

		$('#add_make_btn').click(function() {
			if ($.trim($('#make_name').val()) == '') {
				alert('Make Name cannot be blank!');
				$('#make_name').focus();
				return;
			}
			$('#action').val('addMake');
			$('#form1').submit();
		});
	
		$('#add_model_btn').click(function() {
			if ($.trim($('select[name="make_id"]').val()) == '') {
				alert('Make cannot be blank!');
				$('select[name="make_id"]').focus();
				return;
			}
			if ($.trim($('#model_name').val()) == '') {
				alert('Model Name cannot be blank!');
				$('#model_name').focus();
				return;
			}
			$('#action').val('addModel');
			$('#form1').submit();
		});

		$('#add_model_no_btn').click(function() {
			if ($.trim($('#model_no').val()) == '') {
				alert('Model No. cannot be blank!');
				$('#model_no').focus();
				return;
			}
			$('#action').val('addModelNo');
			$('#form1').submit();
		});
});

function goDeleteMake(id) {
	if (confirm("Are you sure to delete?")) {
		window.location = "index.php?page=product&subpage=make_del&make_id=" + id;
	}
}

function goDelete(id) {
	if (confirm("Are you sure to delete?")) {
		window.location = "index.php?page=product&subpage=model_del&model_id=" + id;
	}
}

function goDeleteModelNo(id) {
	if (confirm("Are you sure to delete?")) {
		window.location = "index.php?page=product&subpage=model_no_del&model_no_id=" + id;
	}
}
</script>