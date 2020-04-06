<TD vAlign=top bgColor=#eefafc>
	
---------------------------------------------------------------------------------------------------------------------------------------------------<br>

<table width="180" border="0" cellspacing="10"> <tr><td>

	<FORM method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">

		Products ID: 

		<input name="prod_id" type="text" id="prod_id" value="<?=$prod_id?>">
	<br>
				Product Name: 
				<input name="prod_name" type="text" id="prod_name" value="<? echo $prod_name;?>">
		<input name="search_sale" type="submit" id="search_sale" value="Search">

		<br>

		<br>

		Top Product

		<input name="sprod_top" type="checkbox" id="sprod_top" value="1">

		Top

		<select name="sprod_select" id="sprod_select">

			<option value="10">10</option>
			
			<option value="20">20</option>
			
			<option value="30">30</option>
			
			<option value="40">40</option>
			
			<option value="50">50</option>

		</select>

		<br>

		<br>

		<table width="406" border="0">

		<tr>

			<td width="30">From</td>

			<td width="100">

			<? if (isset($_POST['date_start'])) {
	 
				$date_start = $_POST['date_start'];
	 
				echo "<script>DateInput('date_start', true, 'YYYY-MM-DD', '$date_start')</script>";
	 
			}else {
	 
				echo "<script>DateInput('date_start', true, 'YYYY-MM-DD')</script>";
	 
			}					  
 
			?>

			&nbsp;</td>

			<td width="16">To </td>

			<td width="84">					

			<? if (isset($_POST['date_end'])) {
	  
				$date_end = $_POST['date_end'];
	  
				echo "<script>DateInput('date_end', true, 'YYYY-MM-DD', '$date_end')</script>";
	  
			}else {
	  
				echo "<script>DateInput('date_end', true, 'YYYY-MM-DD')</script>";
	  
			}					  

			?>

			&nbsp;</td>

		</tr>

		</table>

		<br> 

		<input name="search_date" type="submit" id="search_date" value="Search by Date">
		  <input type="button" onclick="gen_csv()" value="gen_csv" />
	</FORM>   </p>
    
    <table width="738" border="1" cellpadding="0" cellspacing="0">              
	<tr align="center" valign="top">
        <td align="center" >Order No.</td>
		<td > Order date</td>
        <td align="center" >Product ID</td>
        <td align="center" >Product Name </td>
		<td > client email</td>
		<td align="center" >Cost (RMB)</td>
        <td align="center" >Price </td>
        <td align="center" >Unit </td>
    </tr>
		<? for ($i = 0; $i < $prod_n; $i++) { ?>
        <tr valign="top">
            <td align="center" ><a href="index.php?page=order&subpage=edit&sale_ref=<?=$sprod_ref[$i]?>" target='_blank'><?=$sprod_ref[$i]?></a></td>
 
			<td align="center"><?=$sale_dat[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_id[$i]?> &nbsp;</td>
		
            <td align="center"><?=$sprod_name[$i]?> &nbsp;</td>
			<td align="center"><?=$sale_email[$i]?> &nbsp;</td>
			<td align="center"><?=$sprod_cost_rmb[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_price[$i]?> &nbsp;</td>
            <td align="center"><?=$sprod_unit[$i]?> &nbsp;</td>
        </tr>
        <? }?>
    </table>
    <br />
    Total Sale: <?=number_format($total_price,2,'.','')?> <br />
    Total Units: <?=$total_unit?> <br />
	
</td></tr></table>
</td>