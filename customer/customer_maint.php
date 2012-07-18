<?
$isNew = true;
if (isset($cust_id)) { 
	$isNew = false;
}
?>

<TD vAlign=top bgColor=#eefafc>
	<br>
	<form action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" method="POST" name="form1" id="form1" style="margin-left:20px" onSubmit="return checkText()">
		<? echo $message;?><br>
		<? if ($isNew) {?>
			<strong>Add New Customer</strong><br>
		<? } else {?>
			<strong>Edit Customer</strong><br>
			<input type="hidden" name="cust_id" value="<?=$cust_id?>" />
		<? }?>
		
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100">Customer Code:</td><td width="104"><input type="text" name="cust_cd" value="<?=$cust_cd ?>" /></td>
			</tr>
			<tr>
				<td>Company Name:</td><td><input type="text" name="cust_company_name" size="50" value="<?=$cust_company_name ?>" /></td>
			</tr>
			<tr>
				<td>Contact Name:</td><td><input type="text" name="cust_contact_name" value="<?=$cust_contact_name ?>" /></td>
			</tr>
			<tr>
				<td>Tel:</td><td><input type="text" name="cust_tel" value="<?=$cust_tel ?>" /></td>
			</tr>
			<tr>
				<td>Post Code:</td><td><input type="text" name="cust_post_cd" value="<?=$cust_post_cd ?>" /></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="cust_post_address1" size="100" value="<?=$cust_post_address1 ?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="text" name="cust_post_address2" size="100" value="<?=$cust_post_address2 ?>" /></td>
			</tr>
			<tr>
				<td>Website:</td><td><input type="text" name="website" size="50" value="<?=$website ?>" /></td>
			</tr>
			<tr>
				<td>Password:</td><td><input type="text" name=pw size="50" value="<?=$pw ?>" /></td>
			</tr>
		</table>
		<br>
		
		<? if ($isNew) {?>
			<input name="isadd" type="submit" value="Add"> <br>
		<? } else {?>
			<input name="isedit" type="submit" value="Save"> <br>
		<? }?>
	</form>
</TD>

<script type="text/javascript">
function checkText() {
	var isValid = true;
	var alertMsg = "Please complete the following fields:\n";

	if ($.trim(document.forms[0].cust_cd.value) == '') {
		alertMsg += " - Customer Code\n";
		isValid = false;
	}

	if ($.trim(document.forms[0].cust_company_name.value) == '') {
		alertMsg += " - Company Name\n";
		isValid = false;
	}
	
	if (isValid) {
		return true;
	}
	else {
		alert(alertMsg);
		return false;
	}
}
</script>