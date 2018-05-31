<? $sale_ref = $_GET['sale_ref']; ?>
<!-- THREE STEPS TO INSTALL FRAME PRINT:

  1.  Set up your frames (example below)
  2.  Copy the coding into the HEAD of your HTML document for one frame
  3.  Add the last code into the BODY of your HTML document for the same frame  -->

<!-- STEP ONE: Set up your frames -->

<frameset cols="*" rows="*,81">
<frame src="print_ship_bottom_jp2.php?sale_ref=<? echo $sale_ref;?>" name="frame1">
<frame src="print_ship_top2.php?sale_ref=<? echo $sale_ref;?>" name="frame2">
</frameset>
<noframes></noframes>
