<?
if (isset($_POST['date_start'])) {
	$date_start = $_POST['date_start'];
} else {
	$date_start = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
}

if (isset($_POST['date_end'])) {
	$date_end = $_POST['date_end'];
} else {
	$date_end = date("Y-m-d");
}

?>

<TD vAlign=top bgColor=#eefafc>
            ---------------------------------------------------------------------------------------------------------------------------------------------------<br>
              
            <br>
            <table width="180" border="0" cellspacing="10">
              <tr>
                <td><p> <FORM id="form" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
				Order No: 
				<input name="sale_ref" type="text" id="sale_ref" value="<? echo $sale_ref;?>">
				<br>
				Product Name: 
				<input name="prod_name" type="text" id="prod_name" value="<? echo $prod_name;?>">
				<br>
				Product ID:
				<input name="prod_id" type="text" id="prod_id" value="<? echo $prod_id;?>">
				
				 <input name="search_sale" type="submit" id="search_sale" value="search">
				 <br>
				 <br>
				 <input id="sale_or" name="sale_or" type="radio" value="sale_date" checked>
				 Order Date  
				 <input id="sale_or" name="sale_or" type="radio" value="sale_ref">
				 Order No.				 <br>
				 <br>
				 <input name="sale_as" id="sale_as" type="radio" value="desc" checked>
				DESC
				<input name="sale_as" id="sale_as" type="radio" value="asc">
				 ASC				 <br>
				 <br>
				 Top sales group
                 <input name="sale_top" type="checkbox" id="sprod_top" value="1">
Top
<select name="sale_select" id="sale_select">
  <option value="10">10</option>
  <option value="20">20</option>
  <option value="30">30</option>
  <option value="40">40</option>
  <option value="50">50</option>
  <option value="100">100</option>
  <option value="150">150</option>
  <option value="200">200</option>
  <option value="250">250</option>
  <option value="300">300</option>
  <option value="350">350</option>
  <option value="400">400</option>
  <option value="450">450</option>
  <option value="500">500</option>
</select>
<br>
<br>
Group: 
				 <? getgroup($get_username); ?><br>
				 <br>
				<table width="406" border="0">
  <tr>
    <td width="30">From</td>
    <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD', '<?=$date_start ?>')</script>&nbsp;</td>
    <td width="16">To </td>
    <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD', '<?=$date_end ?>')</script>&nbsp;</td>
  </tr>
</table>

                    
  <br>
   
  <input name="Submit" type="submit" value="Check">
  <input type="button" onclick="gen_csv()" value="gen_csv" />
  
             </FORM>   </p>
			   </table>
                 <? 
				 $get_username = $_POST['get_username']; 
				 $print_link = "&nbsp;";
				 //$today = date("Y-m-d"); 
				 //$today_20 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-2,date("Y")));
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) and isset($_POST['sale_top']))
				 {
				 	//echo 'Part 0';
				 //$date_start = $_POST['date_start'];
				 //$date_end = $_POST['date_end'];
				 $sale_top = $_POST['sale_top'];
				 $sale_select = $_POST['sale_select'];
				 getReportTop($date_start,$date_end,$sale_top,$sale_select);
				  
				 }
				 
				 $reportData = NULL;
				 if (!isset($_POST['date_start']) and !isset($_POST['date_end']) and !isset($_POST['search_sale']) and !isset($_POST['sale_top']))
				 {
				 $reportData = getOrderReport($date_start,$date_end, 'sale_date','desc','date','','','');
				 $print_link = "<a href=\"print_report.php?date_start=$date_start&date_end=$date_end&mod=date&sale_or=sale_date&sale_as=desc\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				 }
				  
				 if (isset($_POST['date_start']) and isset($_POST['date_end']) and !isset($_POST['search_sale']) and !isset($_POST['sale_top']))
				 {
				 //$date_start = $_POST['date_start'];
				 //$date_end = $_POST['date_end'];
				 $sale_or = $_POST['sale_or'];
				 $sale_as = $_POST['sale_as'];
				 $mod = "date";
				 $reportData = getOrderReport($date_start,$date_end,$sale_or,$sale_as,$mod,$get_username,'','');
				 $print_link = "<a href=\"print_report.php?date_start=$date_start&date_end=$date_end&mod=$mod&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				 }
				 if (isset($_POST['search_sale']))
				 {
				 $mod = $_POST['sale_ref'];
				 $mod2 = $_POST['prod_name'];
				 $mod3 = $_POST['prod_id'];
				 $reportData = getOrderReport('','',$sale_or,$sale_as,$mod,$get_username,$mod2,$mod3);
				 $print_link = "<a href=\"print_report.php?date_start=&date_end=&mod=$mod&mod2=$mod2&sale_or=$sale_or&sale_as=$sale_as\" onClick=\"NewWindow(this.href,'mywin','800','500','no','center');return false\" onFocus=\"this.blur()\">Preview Report</a>";
				 }
				 
				 ?>
				 
				 <? if ($reportData != NULL) {
				 	include 'report_list_data.php';
				 } ?>
				 
                 <table width="525" border="0">
                        <tr>
                          <td width="175"><? echo $print_link;?></td>

                        </tr>
                      </table>       
					  
					  </td>
              </tr>
          
            </TD>
