
<TD vAlign=top bgColor=#eefafc>
	---------------------------------------------------------------------------------------------------------------------------------------------------<br>
	<br>
	<table width="180" border="0" cellspacing="10">
		<tr>
			<td>
				<p>
					<FORM id="form" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
					
						<table width="406" border="0">
							<tr>
								<td width="30">From</td>
								<td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>&nbsp;</td>
								<td width="16">To </td>
								<td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>&nbsp;</td>
							</tr>
						</table>

						<br>
   
						<input name="Submit" type="submit" value="Check">
						<input type="button" onclick="createCSV()" value="Generate CSV" />
						<input name="genPieChart" type="submit" value="Generate Pie Chart" />
					</FORM>
				</p>
		</td>
	</table>
	
	
	<div style="margin-left:20px">
		<? if (!isset($_POST['genPieChart'])) {?>
			<!-- Serach Result -->
			<? if (isset($summary) && sizeof($summary) > 0) {?>
				Exchange Rate: 1 RMB = <?=$jpRate ?> YEN
			<? }?>
		
			<table border="1" cellspacing="0">
				<tr>
					<td>Group</td>
					<td>Top Sale</td>
					<td>Total Sale</td>
					<td>Cost (RMB)</td>
					<td>Sale</td>
					<td>Discount</td>
					<td>Shipping fee</td>
					<td>Tax</td>
					<td>Balance</td>
					<td>Return</td>
					<td>Top Cost</td>
					<td>Cost %</td>
					<td>Top GP</td>
					<td>GP</td>
				</tr>
				
				<? 
				if (isset($summary) && sizeof($summary) > 0) {
					foreach ($summary as $item) {?>
						<tr>
							<td><?=$item['sale_group'] ?></td>
							<td><?=$item['top_sale'] ?></td>
							<td><?=$item['total_sale'] ?></td>
							<td><?=$item['cost_rmb'] ?></td>
							<td><?=$item['sale'] ?></td>
							<td><?=$item['sale_discount'] ?></td>
							<td><?=$item['sale_ship_fee'] ?></td>
							<td><?=$item['sale_tax'] ?></td>
							<td><?=$item['balance'] ?></td>
							<td><?=$item['return'] ?></td>
							<td><?=$item['top_cost'] ?></td>
							<td><?=number_format($item['cost_percentage'], 6) ?></td>
							<td><?=$item['top_gp'] ?></td>
							<td><?=$item['gp'] ?></td>
						</tr>
				<? 	}
				}
				else {
				?>
					<tr>
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
				<? }?>
			</table>
		<? } else {?>
			<!-- Pie Chart  -->
			<? include('report/report_group_chart.php'); ?>
		<? } ?>
	</div>
</TD>

<script type="text/javascript">
	function createCSV() {
		var date_start = document.forms[0].date_start.value;
		var date_end = document.forms[0].date_end.value;
		var searchKey = 'date_start=' + date_start + '&date_end=' + date_end;
		window.open('<?=$page?>/report_group_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}
</script>