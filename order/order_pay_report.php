
          <TD vAlign=top bgColor=#eefafc>
              
      
            <table width="180" border="0" cellspacing="10">
              <tr>
                <td><p> <FORM method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
				  <br>
				 <br>
				<br>
				<table width="406" border="0">
  <tr>
    <td width="30">From</td>
    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>&nbsp;</td>
    <td width="16">To </td>
    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>&nbsp;</td>
  </tr>
</table>

                    
  <br>
   
  <input name="Submit" type="submit" value="Check Record">
  <input name="genCSV" type="button" id="genCSV" value="Generate CSV" onclick="createCSV()">
             </FORM>   </p>
                 <? 
				 if (!isset($_POST['date_start']) and !isset($_POST['date_end']))
				 {
				  $today = date("Y-m-d"); 
				  $today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-3,date("Y")));
				  echo $today_10;
 				getPayReport($today_10,$today,$group2, $user_name);
				}
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) )
				 {
				 getPayReport($_POST['date_start'],$_POST['date_end'],$group2, $user_name);
				 }
				 
				
				 ?>
                 
				  <br></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            </TD>
<script type="text/javascript">
	function createCSV() {
		var date_start = document.forms[0].date_start.value;
		var date_end = document.forms[0].date_end.value;
		var searchKey = 'date_start=' + date_start + '&date_end=' + date_end;
		window.open('<?=$page?>/order_pay_report_csv.php?' + searchKey, 'newWin', 'width=1000,height=600,menubar=yes,scrollbars=yes');
	}
</script>