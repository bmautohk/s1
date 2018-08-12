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
		 
		
		$file = fopen($uplFile['tmp_name'],"r");
		
		$trackingNos = array();
		$benRefNos = array();
		$sagawa_del_date=array();
	
		$i=0;
		while(! feof($file)){
			$row = fgetcsv($file, 1024);
		
			if($i>0){
					
			
				
				$sagawa_tracking_no_cellVal = trim($row[0]);
				//echo "sagawa_tracking_no_cellVal=".$sagawa_tracking_no_cellVal;
				
				
				$delivery_date_cellVal = trim($row[1]);
				//echo $delivery_date_cellVal;
				$dDate=substr($delivery_date_cellVal,0,4)."-".substr($delivery_date_cellVal,4,2)."-".substr($delivery_date_cellVal,6,2);
			//	echo $dDate;
				
				
				
				$benAuctionID_cellVal = trim($row[12]);
				//echo $benAuctionID_cellVal;				
				//echo "<p>";
				
				
				
				//re-upload checking 20180618
				//
				//if($sagawa_tracking_no_cellVal!='' && $dDate!='' && $benAuctionID_cellVal!=''){
				//$sql="select check_shipping_jp from ben_check where check_ref='$benAuctionID_cellVal' ";
				//$result=mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
				//$num_results=mysql_affected_rows();
				//$row=mysql_fetch_array($result);
				
				
					//if ($num_results==0 || $row['check_shipping_jp']<$sagawa_tracking_no_cellVal){
						
						//update ben_check
						if($benAuctionID_cellVal!="" &&$dDate!="" && $delivery_date_cellVal!="" ){
						 $sql = "update ben_check set check_dat = '$dDate', check_date ='$dDate', check_shipping_jp='$sagawa_tracking_no_cellVal' where check_ref='$benAuctionID_cellVal'";
						//echo $sql;
						//echo "<p>";
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
					//}
				//}
			}
			$i++;
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