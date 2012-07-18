<!-- THREE STEPS TO INSTALL FRAME PRINT:

  1.  Set up your frames (example below)
  2.  Copy the coding into the HEAD of your HTML document for one frame
  3.  Add the last code into the BODY of your HTML document for the same frame  -->

<!-- STEP ONE: Set up your frames -->
<?
$queryStr = $_SERVER['QUERY_STRING'];
?>
<frameset cols="*" rows="*,81">
<frame src="po_print_ship_top.php?<?=$queryStr?>" name="frame1">
<frame src="po_print_ship_bottom.php" name="frame2">
</frameset>
<noframes></noframes>