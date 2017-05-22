<table border="1" cellspacing="0" cellpadding="0">
	<tr valign="top" align="right">
		<td>Order date</td>
		<td>Order No.</td>
		<td>Product ID</td>
		<td><?=mb_convert_encoding('半年銷售量', 'euc-jp', 'utf-8')?></td>
		<td><?=mb_convert_encoding('最近一個月銷售量', 'euc-jp', 'utf-8')?></td>
		<td><?=mb_convert_encoding('總銷售量', 'euc-jp', 'utf-8')?></td>
		<td>Product name</td>
		<td>Client Email</td>
		<td>Total Sale</td>
		<td>Cost (RMB)</td>
		<td >Sale</td>
		<td>Discount</td>
		<td>Shipping fee</td>
		<td>Tax</td>
		<td>Balance</td>
		<td>Return</td>
		<td>Group</td>
		<td>Remark</td>
	</tr>
	
	<? foreach ($reportData['row'] as $data) { ?>
		<tr valign="top" align="right"> <td><?=$data['sale_date'] ?></td>
			<td><?=$data['sale_ref'] ?></td>
			<td><?=$data['sprod_id'] ?></td>
			<td><?=number_format($data['product_sales_6_month']) ?></td>
			<td><?=number_format($data['product_sales_1_month']) ?></td>
			<td><?=number_format($data['product_sales_total']) ?></td>
			<td><?=$data['sprod_name'] ?></td>
			<td><?=$data['sale_email'] ?></td>
			<td><?=number_format($data['sale_total']) ?></td>
			<td><?=$data['product_cost_rmb'] ?></td>
			<td><?=number_format($data['sub_total']) ?></td>
			<td><?=number_format($data['sale_discount']) ?></td>
			<td><?=number_format($data['sale_ship_fee']) ?></td>
			<td><?=$data['sale_tax'] ?></td>
			<td width='120'>
				<? if ($data['bal_pay'] !== NULL) { ?>
					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$data['sale_ref'] ?>"><?=$data['bal_pay']?><br>(<?=$data['bal_dat']?>)</a>
				<? } else { ?>
					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$data['sale_ref'] ?>">Not Pay</a>
				<? } ?>
			</td>
			<td>
				<? if ($data['return_pay'] !== NULL) { ?>
					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$data['sale_ref'] ?>"><?=$data['return_pay']?><br>(<?=$data['return_dat']?>)</a>
				<? } else { ?>
					<a href="index.php?page=order&subpage=balance&sale_ref=<?=$data['sale_ref'] ?>">No Refund</a>
				<? } ?>
			</td>
			<td><?=$data['sale_group'] ?></td>
			<td><?=$data['remark']?></td>
		</tr>
	<? } ?>
	
	<tr valign="top" align="right"> <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	
	<tr valign="top" align="right"> <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Total: </td>
		<td><?=number_format($reportData['sale_total_total'])?></td>
		<td><?=number_format($reportData['totalCost'])?></td>
		<td><?=number_format($reportData['sub_total_sale'])?></td>
		<td><?=number_format($reportData['dis_total'])?></td>
		<td><?=number_format($reportData['ship_total'])?></td>
		<td><?=number_format($reportData['tax_total'])?></td>
		<td width='120'><?=number_format($reportData['bal_total'])?></td>
		<td><?=number_format($reportData['return_total'])?></td>
			<td>&nbsp;</td>
	</tr>
</table>
