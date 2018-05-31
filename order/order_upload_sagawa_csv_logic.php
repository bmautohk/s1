<?php
require_once 'Classes/PHPExcel/IOFactory.php';

$action = $_POST['action'];

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$duplicateTrackingNos = array();

if ($action == 'Upload') {
	// Upload JP tracking no
	$uplFile = $_FILES["uplFile"];
	
	if ($uplFile != "") {
		$objReader = PHPExcel_IOFactory::createReader('CSV');
		$objPHPExcel = $objReader->load($uplFile['tmp_name']);
		
		$trackingNos = array();
		$benRefNos = array();
		$sagawa_del_date=array();
		$worksheet = $objPHPExcel->getActiveSheet();
		$i=0;
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if($rowNo>1){
				$sagawa_tracking_no_cell = $worksheet->getCellByColumnAndRow(0, $rowNo);
				$sagawa_tracking_no_cellVal = trim($sagawa_tracking_no_cell->getValue());
				//echo $sagawa_tracking_no_cellVal;
				
				$delivery_date_cell = $worksheet->getCellByColumnAndRow(1, $rowNo);
				$delivery_date_cellVal = trim($delivery_date_cell->getValue());
				//echo $delivery_date_cellVal;
				$dDate=substr($delivery_date_cellVal,0,4)."-".substr($delivery_date_cellVal,4,2)."-".substr($delivery_date_cellVal,6,2);
				//echo $dDate;
				
				
				$benAuctionID_cell = $worksheet->getCellByColumnAndRow(12, $rowNo);
				$benAuctionID_cellVal = trim($benAuctionID_cell->getValue());
				//echo $benAuctionID_cellVal;
				
				//echo "<p>";
				
				//update ben_check
				if($benAuctionID_cellVal!="" &&$dDate!="" && $delivery_date_cellVal!="" ){
				 $sql = "update ben_check set check_dat = '$dDate', check_date ='$dDate', check_shipping_jp='$sagawa_tracking_no_cellVal' where check_ref='$benAuctionID_cellVal'";
				
				mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
				$num_results=mysql_affected_rows();
				
					if ($num_results==1){
						$trackingNos[$i] = $sagawa_tracking_no_cellVal;
						$benRefNos[$i] = $benAuctionID_cellVal;
						$sagawa_del_date[$i] = $dDate;
						$i++;
					}
					
				//update ben_sale sts='A' 20180526
				$sql = "update ben_sale set sts='A' where sale_ref='$benAuctionID_cellVal'";
				mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");				
					
				}
			}
		}
		$msg = "Upload tracking no successfully!\\nNo. of inserted record: ".sizeof($trackingNos);
	}

	
		
		
			
	 
	
	
}

// List out all active tracking no
//$trackingNos = array();
//$result = mysql_query("SELECT * FROM sagawa_tracking_no WHERE sts = 'A'" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
//$num_results=mysql_num_rows($result);
//for ($i=0;$i<$num_results;$i++) {
	//$row = mysql_fetch_array($result);
	
//	$trackingNos[$i]['tracking_no'] = $row['tracking_no'];
//}

?>