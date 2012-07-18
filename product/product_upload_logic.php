<?php
//include_once 'Classes/PHPExcel.php';

$lang_type="EUC-JP";
//$lang_type="Shift-JIS";

require_once 'Classes/PHPExcel/IOFactory.php';

$action = $_POST['action'];

if ($action == 'Upload') {
	// Upload JP tracking no
	$uplFile = $_FILES["uplFile"];
	
	if ($uplFile !=	"") {
		$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',');
		$objReader->setInputEncoding($lang_type);
		$objPHPExcel = $objReader->load($uplFile['tmp_name']);
	

		$products = array();
		$worksheet = $objPHPExcel->getActiveSheet();
		foreach ($worksheet->getRowIterator() as $row) {
			$rowNo = $row->getRowIndex();
			if ($rowNo == 1) {
				// Skip 1st row (i.e. header)
				continue;
			}
			$cell = $worksheet->getCellByColumnAndRow(0, $rowNo);
			
			$cellVal = $cell->getValue();
			if ($cellVal != "") {
				$product['product_id'] = $worksheet->getCellByColumnAndRow(0, $rowNo)->getValue();
				$product['product_jp_no'] = $worksheet->getCellByColumnAndRow(1, $rowNo)->getValue();
				$product['product_us_no'] = $worksheet->getCellByColumnAndRow(2, $rowNo)->getValue();
				$product['product_sup_no'] = $worksheet->getCellByColumnAndRow(3, $rowNo)->getValue();
				$product['make_id'] = $worksheet->getCellByColumnAndRow(4, $rowNo)->getValue();
				$product['product_made'] = conv2($worksheet->getCellByColumnAndRow(5, $rowNo)->getValue());
				$product['product_model'] = conv2($worksheet->getCellByColumnAndRow(6, $rowNo)->getValue());
				$product['product_remark'] = conv2($worksheet->getCellByColumnAndRow(7, $rowNo)->getValue());
				$product['product_name'] = conv2($worksheet->getCellByColumnAndRow(8, $rowNo)->getValue());
				$product['product_pcs'] = $worksheet->getCellByColumnAndRow(9, $rowNo)->getValue();
				$product['product_photo'] = $worksheet->getCellByColumnAndRow(10, $rowNo)->getValue();
				$product['product_dit'] = $worksheet->getCellByColumnAndRow(11, $rowNo)->getValue();
				$product['product_price_s'] = $worksheet->getCellByColumnAndRow(12, $rowNo)->getValue();
				$product['product_price_s1'] = $worksheet->getCellByColumnAndRow(13, $rowNo)->getValue();
				$product['product_price_s2'] = $worksheet->getCellByColumnAndRow(14, $rowNo)->getValue();
				$product['product_cus_price'] = $worksheet->getCellByColumnAndRow(15, $rowNo)->getValue();
				$product['product_cost_rmb'] = $worksheet->getCellByColumnAndRow(16, $rowNo)->getValue();
				$product['product_cost_hk'] = $worksheet->getCellByColumnAndRow(17, $rowNo)->getValue();
				$product['product_cost_us'] = $worksheet->getCellByColumnAndRow(18, $rowNo)->getValue();
				$product['product_cost_yan'] = $worksheet->getCellByColumnAndRow(19, $rowNo)->getValue();
				$product['product_sup'] = $worksheet->getCellByColumnAndRow(20, $rowNo)->getValue();
				$product['product_web'] = $worksheet->getCellByColumnAndRow(21, $rowNo)->getValue();
				$product['product_colour'] = conv2($worksheet->getCellByColumnAndRow(22, $rowNo)->getValue());
				$product['product_price_u'] = $worksheet->getCellByColumnAndRow(23, $rowNo)->getValue();
				$product['product_index'] = $worksheet->getCellByColumnAndRow(24, $rowNo)->getValue();
				$product['product_location'] = $worksheet->getCellByColumnAndRow(25, $rowNo)->getValue();
				
				// AA
				$product['product_stock_level'] = $worksheet->getCellByColumnAndRow(26, $rowNo)->getValue();
				$product['product_stock_jp'] = $worksheet->getCellByColumnAndRow(27, $rowNo)->getValue();
				$product['product_model_no'] = conv2($worksheet->getCellByColumnAndRow(28, $rowNo)->getValue());
				$product['product_year'] = conv2($worksheet->getCellByColumnAndRow(29, $rowNo)->getValue());
				$product['cat_id'] = $worksheet->getCellByColumnAndRow(30, $rowNo)->getValue();
				$product['product_cat'] = $worksheet->getCellByColumnAndRow(31, $rowNo)->getValue();
				$product['product_desc'] = conv2($worksheet->getCellByColumnAndRow(32, $rowNo)->getValue());
				$product['product_70_17'] = $worksheet->getCellByColumnAndRow(33, $rowNo)->getValue();
				$product['product_rmb'] = $worksheet->getCellByColumnAndRow(34, $rowNo)->getValue();
				$product['product_stock_us'] = $worksheet->getCellByColumnAndRow(35, $rowNo)->getValue();
				$product['product_stock_cn'] = $worksheet->getCellByColumnAndRow(36, $rowNo)->getValue();
				$product['product_stock_hk'] = $worksheet->getCellByColumnAndRow(37, $rowNo)->getValue();
				$product['product_cus_des'] = $worksheet->getCellByColumnAndRow(38, $rowNo)->getValue();
				$product['product_group'] = conv2($worksheet->getCellByColumnAndRow(39, $rowNo)->getValue());
				$product['product_material'] = $worksheet->getCellByColumnAndRow(40, $rowNo)->getValue();
				$product['product_colour_no'] = $worksheet->getCellByColumnAndRow(41, $rowNo)->getValue();
				$product['product_original_color'] = $worksheet->getCellByColumnAndRow(42, $rowNo)->getValue();
				$product['product_auction_p'] = $worksheet->getCellByColumnAndRow(43, $rowNo)->getValue();
				$product['product_qc'] = $worksheet->getCellByColumnAndRow(44, $rowNo)->getValue();
				$product['maz'] = $worksheet->getCellByColumnAndRow(45, $rowNo)->getValue();
				$product['prod_on_order'] = $worksheet->getCellByColumnAndRow(46, $rowNo)->getValue();
				$product['alias'] = $worksheet->getCellByColumnAndRow(47, $rowNo)->getValue();
				
				$products[] = $product;
			}
		}
	}

	foreach ($products as $product) {
		$sql = "insert into product values ('".
				$product['product_id']."', '".$product['product_jp_no']."','".$product['product_us_no']."','".$product['product_sup_no']."','".$product['make_id']."','".
						$product['product_made']."', '".$product['product_model']."','".$product['product_remark']."','".$product['product_name']."','".$product['product_pcs']."','".
						$product['product_photo']."', '".$product['product_dit']."','".$product['product_price_s']."','".$product['product_price_s1']."','".$product['product_price_s2']."','".
						$product['product_cus_price']."', '".$product['product_cost_rmb']."','".$product['product_cost_hk']."','".$product['product_cost_us']."','".$product['product_cost_yan']."','".
						$product['product_sup']."', '".$product['product_web']."','".$product['product_colour']."','".$product['product_price_u']."','".$product['product_index']."','".
						$product['product_location']."', '".
						$product['product_stock_level']."', '".$product['product_stock_jp']."','".$product['product_model_no']."','".$product['product_year']."','".$product['cat_id']."','".
						$product['product_cat']."', '".$product['product_desc']."','".$product['product_70_17']."','".$product['product_rmb']."','".$product['product_stock_us']."','".
						$product['product_stock_cn']."', '".$product['product_stock_hk']."','".$product['product_cus_des']."','".$product['product_group']."','".$product['product_material']."','".
						$product['product_colour_no']."', '".$product['product_original_color']."','".$product['product_auction_p']."','".$product['product_qc']."','".$product['maz']."','".
						$product['prod_on_order']."', '".$product['alias']."', now(), now()) ";
		sqlinsert($sql);
	 
	}
	
	$msg = "Upload container successfully! No. of inserted record: ".sizeof($products);;
}

function conv2($str) {
	return mb_convert_encoding($str,"EUC-JP","UTF-8");
}

?>