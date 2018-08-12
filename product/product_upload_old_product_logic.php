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
					
			
				
				$prod_id = trim($row[0]);
				//echo "sagawa_tracking_no_cellVal=".$sagawa_tracking_no_cellVal;
				
				
			 
						//update ben_check
						if($prod_id!=""  ){
						 $sql = "update product set searchable = 'I' where product_id='$prod_id'";
						//echo $sql;
						//echo "<p>";
						mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute sql: $sql");
						$num_results=mysql_affected_rows();
						
							if ($num_results==1){
								$prod_id_arr[$i] = $prod_id;
							 
							}
							
				 
						}
					//}
				//}
			}
			$i++;
		}
		$msg = "Upload old product successfully!\\nNo. of inserted record: ".sizeof($prod_id_arr);
	}

	
		
		
			
	 
	
	
}

 
?>