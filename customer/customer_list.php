<TD vAlign=top bgColor=#eefafc>
	<br>
	<FORM  name="form1" id="form1" method="GET" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>" style="margin-left:20px">
		<input name="page" type="hidden" id="page" value="<?=$page?>">
		<input name="subpage" type="hidden" id="subpage" value="<?=$subpage?>">
					
		<table width="647" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100">Company Name:</td>
				<td width="210"><input name="cust_company_name" type="text" value="<?=$cust_company_name?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td width="100">Contact Name:</td>
				<td width="210"><input name="cust_contact_name" type="text" value="<?=$cust_contact_name?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td width="100">Tel:</td>
				<td width="210"><input name="cust_tel" type="text" value="<?=$cust_tel?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td width="100">Address 1:</td>
				<td width="210"><input name="cust_post_address1" type="text" value="<?=$cust_post_address1?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td width="100">Address 2:</td>
				<td width="210"><input name="cust_post_address2" type="text" value="<?=$cust_post_address2?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		
		<input name="issearch" type="submit" id="issearch" value="Search">
		
			<? paging_table_header("customer", "list", $num_rows, $zpage, $per_page, $searchKey); ?>
			<table width="1300" align="center" border="1" cellpadding="0" cellspacing="0">
				<tr align="center" valign="top">
					<td>Customer Code</td>
					<td>Company Name</td>
					<td>Contact Name</td>
					<td>Tel</td>
					<td>Post Code</td>
					<td>Address 1</td>
					<td>Address 2</td>
					<td>Website</td>
					<td>Password</td>
					<td>Delete?</td>
				</tr>
				<? foreach ($customers as $customer) {?>
				<tr>
					<td align="center"><a href="index.php?page=customer&subpage=maint&cust_id=<?=$customer['id'] ?>"><?=$customer['cust_cd'] ?></a></td>
					<td><?=$customer['cust_company_name'] ?></td>
					<td><?=$customer['cust_contact_name'] ?>&nbsp;</td>
					<td><?=$customer['cust_tel'] ?>&nbsp;</td>
					<td><?=$customer['cust_post_cd'] ?>&nbsp;</td>
					<td><?=$customer['cust_post_address1'] ?>&nbsp;</td>
					<td><?=$customer['cust_post_address2'] ?>&nbsp;</td>
					<td><?=$customer['website'] ?>&nbsp;</td>
					<td><?=$customer['password'] ?>&nbsp;</td>
					<td><a href="javascript:goDelete(<?=$customer['id'] ?>)">Delete</a></td>
				</tr>
				<? }?>
			</table>
		
	</FORM>
</TD>

<script type="text/javascript">
	function goDelete(id) {
		if (confirm("Are you sure to delete?")) {
			window.location = "index.php?page=customer&subpage=del&cust_id=" + id;
		}
	}
</script>