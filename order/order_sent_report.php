
          <TD vAlign=top bgColor=#eefafc>

            <table width="180" border="0" cellspacing="10">
              <tr>
                <td><p> <FORM id="criteriaForm" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
				  <br>
				 <br>
				<br>
				<table border="0">				
  <tr>
    <td width="65">From</td>
    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>&nbsp;</td>
    <td width="16">To </td>
    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>&nbsp;</td>
  </tr> 
  <tr>
  	<td>Client Name</td>
  	<td><input type="text" name="sale_name" /></td>
  </tr>
  <tr>
  	<td>Sales Group</td>
  	<td><? getgroup_select($_SESSION[user_name]);?></td>
  </tr>
</table>

  <br>

<div style="position: relative;text-align: left;width:700px;">  
	<input name="Submit" type="submit" value="Check Record">
	<input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
	<span style="position: absolute;right: 0;">Delivery Cost: <input name="delivery_cost" id="delivery_cost" size="10" /><input type="button" name="isGenPDF" value="Generate Invoice" onclick="createPDF()"/></span>
</div>
             </FORM>   </p>
                 <? 
				 if (!isset($_POST['date_start']) and !isset($_POST['date_end']))
				 {
				  $today = date("Y-m-d"); 
				  $today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
				  //echo $today_10;
 				getSentReport($today_10,$today,null, null, $group2, $user_name);
				}
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) )
				 {
				 getSentReport($_POST['date_start'], $_POST['date_end'], $_POST['sale_name'], $_POST['sale_group'], $group2, $user_name);
				 }
				 
				
				 ?>
                 
				  <br></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            </TD>


<script type="text/javascript">
	$(function() {
		// sale_group
		$('#sale_group').prepend('<option value="" selected="selected"></option>');
	});

	function createSearchKey() {
		var date_start = document.forms[0].date_start.value;
		var date_end = document.forms[0].date_end.value;
		var sale_name = document.forms[0].sale_name.value;
		var sale_group = document.forms[0].sale_group.value;
		var searchKey = 'date_start=' + date_start + '&date_end=' + date_end + '&sale_name=' + sale_name + '&sale_group=' + sale_group;
		return searchKey;
	}
	
	function createCSV() {
		var searchKey = createSearchKey();
		window.open('<?=$page?>/order_sent_report_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}

	function createPDF() {
		if ($('#delivery_cost').val() != '' && $('#delivery_cost').val().search(/^-?[0-9]+$/) != 0) {
			alert('Delivery cost should be integer!');
			return;
		}
		var searchKey = createSearchKey();
		window.open('<?=$page?>/order_sent_report_pdf.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}
	</script>