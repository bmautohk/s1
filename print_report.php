<?  
$date_start = $_GET['date_start'];
$date_end = $_GET['date_end'];
$sale_or = $_GET['sale_or'];
$sale_as = $_GET['sale_as'];
$mod = $_GET['mod'];
$mod2 = $_GET['mod2'];
$prod_id = $_GET['prod_id'];
$username = $_GET['username'];

$print_link ="date_start=$date_start&date_end=$date_end&mod=$mod&mod2=$mod2&sale_or=$sale_or&sale_as=$sale_as&username=$username&prod_id=$prod_id";
				  
				?>
<!-- THREE STEPS TO INSTALL FRAME PRINT:

  1.  Set up your frames (example below)
  2.  Copy the coding into the HEAD of your HTML document for one frame
  3.  Add the last code into the BODY of your HTML document for the same frame  -->

<!-- STEP ONE: Set up your frames -->

<frameset cols="*" rows="*,81">
<frame src="print_report_bottom.php?<? echo $print_link;?>" name="frame1">
<frame src="print_report_top.php?<? echo $print_link;?>" name="frame2">
</frameset>
<noframes></noframes>
