
          <TD vAlign=top bgColor=#eefafc>


            <table width="777" border="0" cellspacing="10">

              <tr>

                <td><p>

                    <FORM method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">


                    <input type="hidden" name="page" value="<?=$page?>" />
                    <input type="hidden" name="subpage" value="<?=$subpage?>" />

                      <table width="406" border="0">
						<tr>
						<td colspan="4">
						Products ID:

		<input name="prod_id" type="text" id="prod_id" value="<?=$prod_id?>">
	<br>
						</td>
						</tr>
                  <!----//      <tr>

                          <td width="30">From</td>

                          <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>

              &nbsp;</td>

                          <td width="16">To </td>

                          <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>

              &nbsp;</td>

                        </tr>//---->

                      </table>

                      <br>

                      <input name="Submit" type="submit" value="Check Record">

                    </FORM>

                    <p></p>

                </td>

              </tr>

            </table>

            <br>

            <br>


            <table width="600" border="0">

          <tr valign="top">

            <td width="600">
            	<form id="frm_jp" method="POST" action="<?=$page ?>/order_ship_report_csv.php">
            	No tracking no. JP
            	<input name="genCSV" type="submit" value="Generate Post Office CSV" />
				<input name="genSagawaCSV" type="button" value="Generate SAGAWA CSV" onclick="submitToSagawa('JP');"/>
				<input name="genClickPostCSV" type="button" value="Generate ClickPost CSV" onclick="submitToClickPost('JP');"/>
            	<input type="hidden" name="gen_type" value="JP" />
            	<br>

              <? 
			  $prod_id_arr=explode(',',$prod_id);
			  $prod_id = join("','",$prod_id_arr);   
			  
			  $rows = getShipReportData($group2, $user_name,'JP',$prod_id); ?>

              <table width="600" border="1" cellspacing="0" cellpadding="0">
              	<tr align="right" valign="top">
              		<td><input type="checkbox" name="cb_select_all" /></td>
	              	<td width="">Prod ID</td>
					<td width="">B+C</td>
					<td>Remark</td>
					<td>realStock</td>
	              	<td >Sale Group</td>
					<td >Post Code</td>
	              	<td >Client name</td>
	              	<td >Shipping Type</td>
	              	<td>Payment Date</td>
	              	<td>Auction ID</td>

              	</tr>

              <? foreach ($rows as $row) { ?>
              	<tr align="right" valign="top">
              		<td>
              			<? if (!empty($row['sprod_no'])) { ?>
              				<input type="checkbox" name="cb_sprod_no[]" value="<?=$row['sprod_no'] ?>" />
              			<? } ?>
              		</td>

              		<td width="100"><? if ($row['sagawa_label']=='Y') { ?>(&#10045;&#10045;)<? } ?><? if ($row['sagawa_label2']=='Y') { ?>(&#10045;3&#10045;)<? } ?>
					<a href='index.php?page=order&subpage=edit&sale_ref=<?=$row['bal_ref'] ?>'><?=$row['sprod_id'] ?></a>
					</td>
					<td><?=$row['person_in_charge'] ?>&nbsp;</td>
					<td><?=$row['debt_remark'] ?>&nbsp;</td>
				 	<td><?=$row['realstock']?> &nbsp;</td>
              		<td><?=$row['sale_group'] ?>&nbsp;</td>
					<td><?=$row['debt_post_co'] ?>&nbsp;</td>
              		<td><?=$row['sale_name'] ?>&nbsp;</td>
              		<td><?=$row['bal_ship_type'] ?>&nbsp;</td>
              		<td><?=$row['bal_dat'] ?></td>
              		<td><a href='index.php?page=order&subpage=shipping&sale_ref=<?=$row['bal_ref'] ?>'><?=$row['bal_ref'] ?></a></td>

              	</tr>
              <? } ?>
              </table>

              </form>
            </td>

            <td width="600">
            	<form id="frm_hk" method="POST" action="<?=$page ?>/order_ship_report_csv.php">
            	No tracking no. HK
            	<input name="genCSV" type="submit" value="Generate Post Office CSV" />
				<input name="genSagawaCSV" type="button" value="Generate SAGAWA CSV" onclick="submitToSagawa('HK');"/>
				<input name="genClickPostCSV" type="button" value="Generate ClickPost CSV" onclick="submitToClickPost('HK');"/>
            	<input type="hidden" name="gen_type" value="HK" />
            	<br>

              <? //getShipReport($group2, $user_name,'HK'); ?>

              <? $rows = getShipReportData($group2, $user_name,'HK',$prod_id); ?>

              <table width="600" border="1" cellspacing="0" cellpadding="0">
              	<tr align="right" valign="top">
              		<td><input type="checkbox" name="cb_select_all" /></td>
	              	<td>Prod ID</td>
					<td>Remark</td>
	              	<td >Sale Group</td>
					<td >Post Code</td>
	              	<td >Client name</td>
	              	<td >Shipping Type</td>
	              	<td>Payment Date</td>
	              	<td>Auction ID</td>

              	</tr>

              <? foreach ($rows as $row) { ?>
              	<tr align="right" valign="top">
              		<td>
              			<? if (!empty($row['sprod_no'])) { ?>
              				<input type="checkbox" name="cb_sprod_no[]" value="<?=$row['sprod_no'] ?>" />
              			<? } ?>
              		</td>

              		<td><a href='index.php?page=order&subpage=edit&sale_ref=<?=$row['bal_ref'] ?>'><?=$row['sprod_id'] ?></a></td>
					<td><?=$row['debt_remark'] ?>&nbsp;</td>
              		<td><?=$row['sale_group'] ?>&nbsp;</td>
					<td><?=$row['debt_post_co'] ?>&nbsp;</td>
              		<td><?=$row['sale_name'] ?>&nbsp;</td>
              		<td><?=$row['bal_ship_type'] ?>&nbsp;</td>
              		<td><?=$row['bal_dat'] ?></td>
              		<td><a href='index.php?page=order&subpage=shipping&sale_ref=<?=$row['bal_ref'] ?>'><?=$row['bal_ref'] ?></a></td>

              	</tr>
              <? } ?>
              </table>
              </form>
           	</td>

            <td width="608">


				<form id="frm_jp_trackno" method="POST" action="<?=$page ?>/order_ship_report_sagawa_csv.php">
            	 With tracking no.
            	<input name="genSagawaCSV" type="submit" value="Generate SAGAWA CSV" />
				<input name="genClickPostCSV" type="button" value="Generate ClickPost CSV" onclick="submitToClickPost('frm_jp_trackno');"/>
            	<input type="hidden" name="gen_type" value="%" />
				<input type="hidden" name="exportCSVonly" value="true" /><br>

 <?

 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) )

{

$today = date("Y-m-d");

$today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-60,date("Y")));

getShipReport2($today_10,$today,$group2, $user_name,$prod_id);

}

else

{getShipReport2($_GET['date_start'],$_GET['date_end'],$group2, $user_name,$prod_id);

} ?></td>

          </tr>

        </table>
		</form>
</TD>

        </TR></TBODY></TABLE>

      <br>

      <br>

      <br></TD>

<script type="text/javascript">
	$(function() {
		// Select all checkbox
		$('input[type="checkbox"][name="cb_select_all"]').click(function() {

 
			var isSelect = $(this).attr('checked');
			var f = $(this).closest('form');
			 
			//$('input[type="checkbox"][name^="cb_sprod_no"]', f).attr('checked', isSelect);
			$('input[type="checkbox"][name^="cb_sprod_no"]', f).not(this).prop('checked', this.checked);
			 
		});

		$('input[type="checkbox"][name^="cb_sprod_no"]').click(function() {
			var f = $(this).closest('form');
			if ($('input[type="checkbox"][name^="cb_sprod_no"]', f).not(':checked').length > 0) {
				//$('input[type="checkbox"][name="cb_select_all"]', f).attr('checked', false);
				$('input[type="checkbox"][name="cb_select_all"]', f).prop('checked', false);
			} else {
				//$('input[type="checkbox"][name="cb_select_all"]', f).attr('checked', true);
				$('input[type="checkbox"][name="cb_select_all"]', f).prop('checked', true);
			}
		});
	});

</script>
