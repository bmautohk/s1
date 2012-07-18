<? $print_method = $_GET['print_method']; ?>
<? $sale_ref = $_GET['sale_ref']; ?>
<? $addr_id = $_GET['addr_id']; ?>
<!-- THREE STEPS TO INSTALL FRAME PRINT:

  1.  Set up your frames (example below)
  2.  Copy the coding into the HEAD of your HTML document for one frame
  3.  Add the last code into the BODY of your HTML document for the same frame  -->

<!-- STEP ONE: Set up your frames -->

<frameset cols="*" rows="*,81">
<frame src="print_ship_bottom_<?=$print_method?>.php?sale_ref=<?=$sale_ref?>&addr_id=<?=$addr_id?>" name="frame1">
<frame src="print_ship_top.php?sale_ref=<?=$sale_ref?>&addr_id=<?=$addr_id?>" name="frame2">
</frameset>
<noframes></noframes>
