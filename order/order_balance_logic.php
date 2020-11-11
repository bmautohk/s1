<?
if (isset($_REQUEST['submitted'])) {
	
	@$sale_ref=$_GET['sale_ref'];

	$product_photo=getreturn_next();
	
	$photo_id = getreturn_next() ;	
}
?>



<?

$debt_remark ='';

if (isset($_GET['sale_ref']) and getbal_data($_GET['sale_ref']))
	
{
	
	$sale_ref=$_GET['sale_ref'];
	
	$row = getbal_data($sale_ref);
	
	$bal_pay=$row['bal_pay'];
	
	$bal_pay_type=$row['bal_pay_type'];
	
	$bal_ship_type=$row['bal_ship_type'];
	
	$bal_delivery_date = $row['bal_delivery_date'];
	
	$bal_delivery_time_option_id = $row['bal_delivery_time_option_id'];
	
	if ($bal_delivery_time_option_id == NULL) {
		$bal_delivery_time = $row['bal_delivery_time'];
	} else {
		$bal_delivery_time = '';
	}
	
	$row_debt = getdebt_data($sale_ref);
	
	$debt_remark = $row_debt['debt_remark'];
	
}

else{
	$bal_pay='';
	
	$row_debt = getdebt_data($sale_ref);
	
	$debt_remark = $row_debt['debt_remark'];
}



//----------------------------------

if (isset($_GET['sale_ref']) and getreturn_data($_GET['sale_ref']))
	
{
	
	$sale_ref=$_GET['sale_ref'];
	
	$return_row = getreturn_data($sale_ref);
	
	
	
	$return_pay=$return_row['return_pay'];
	
	$return_remark=$return_row['return_remark'];
	
	$return_track=$return_row['return_track'];
	
	$return_date=$return_row['return_date'];
	
	

} else{
	
	$return_pay='';
	
	$return_remark='';
	
	$return_track='';
	
	$return_date='';
	
}

//========================================



if (isset($_GET['sale_ref']))
	
{$sale_ref=$_GET['sale_ref'];}



if (isset($_POST['isupdate']) and $_POST['bal_pay']!='')
	
{
	
	$sale_ref=$_POST['sale_ref'];
	
	if ($_POST['bal_delivery_date'] == '') {
		$delivery_date = 'NULL';
	} else {
		$delivery_date = "'".$_POST['bal_delivery_date']."'";
	}
	
	if ($_POST['bal_delivery_time_option_id'] == '') {
		$delivery_time_option_id = 'NULL';
		$delivery_time = "'".$_POST['bal_delivery_time']."'";
	} else {
		$delivery_time_option_id = $_POST['bal_delivery_time_option_id'];
		
		$option = getDeliveryTimeOption($delivery_time_option_id);
		$delivery_time = "'".$option['delivery_time']."'";
	}
	
	
	if (!getbal_data($sale_ref)) {
		
		
		
		$sqla = "INSERT INTO ben_bal SET
			
			bal_ref='".$_POST['sale_ref']."',
			
			bal_pay='".$_POST['bal_pay']."',
			
			bal_pay_type='".$_POST['bal_pay_type']."',
			
			bal_ship_type='".$_POST['bal_ship_type']."',
			
			bal_delivery_date=".$delivery_date.",
			
			bal_delivery_time_option_id =".$delivery_time_option_id.",
			
			bal_delivery_time =".$delivery_time.",
			
			bal_dat = curdate()";
		
		
		
		sqlinsert($sqla);
		
		$row = getbal_data($sale_ref);
		
		$bal_pay=$row['bal_pay'];
		
		$bal_pay_type=$row['bal_pay_type'];
		
		$bal_ship_type=$row['bal_ship_type'];
		
		$bal_delivery_date=$row['bal_delivery_date'];
		
		$bal_delivery_time_option_id=$row['bal_delivery_time_option_id'];
		
		if ($bal_delivery_time_option_id == 0) {
			$bal_delivery_time=$row['bal_delivery_time'];
		} else {
			$bal_delivery_time = '';
		}
		
	}
	else 
	{
		
		if ($_POST['return_date']=='') {
			
			//update bal note
			
			$sqla = "Update ben_bal SET
				
				bal_pay='".$_POST['bal_pay']."',
				
				bal_pay_type='".$_POST['bal_pay_type']."',
				
				bal_ship_type='".$_POST['bal_ship_type']."',
				
				bal_delivery_date = ".$delivery_date.",
				
				bal_delivery_time_option_id = ".$delivery_time_option_id.",
				
				bal_delivery_time = ".$delivery_time.",
				
				bal_dat = curdate() where bal_ref= '".$_POST['sale_ref']."'";
			
			sqlinsert($sqla);
			
			$row = getbal_data($sale_ref);
			
			$bal_pay=$row['bal_pay'];
			
			$bal_pay_type=$row['bal_pay_type'];
			
			$bal_ship_type=$row['bal_ship_type'];
			
			$bal_delivery_date=$row['bal_delivery_date'];
			
			$bal_delivery_time_option_id=$row['bal_delivery_time_option_id'];
			
			if ($bal_delivery_time_option_id == 0) {
				$bal_delivery_time=$row['bal_delivery_time'];
			} else {
				$bal_delivery_time = '';
			}
			
			//$bal_return=$row['bal_return'];
			
			$check = "update";
			
		}
		
	}
	
}

// insert return

if (isset($_POST['isupdate']) and (isset($_POST['return_pay']) or isset($_POST['return_remark']) or isset($_POST['return_track'])))
	
{
	
	$sale_ref=$_POST['sale_ref'];
	
	
	
	if (!getreturn_data($sale_ref)) {
		
		if ($_POST['return_date']=='')
			
		{$return_date_t = "NULL";} else {$return_date_t = "'".$_POST['return_date']."'";}
		
		
		
		$sqla = "INSERT INTO ben_return SET
			
			return_ref='".$_POST['sale_ref']."',
			
			return_remark='".$_POST['return_remark']."',
			
			return_track='".$_POST['return_track']."',
			
			return_pay='".$_POST['return_pay']."',
			
			return_date=".$return_date_t.",
			
			return_dat = curdate()";
		
		
		
		sqlinsert($sqla);
		
		$row = getreturn_data($sale_ref);
		
		$return_pay=$row['return_pay'];
		
		$return_remark=$row['return_remark'];
		
		$return_track=$row['return_track'];
		
		$return_date=$row['return_date'];
		
		
		
	}
	
	else 
		
	{
		
		if ($_POST['return_date']=='') {
			$return_date_t = "NULL";
		} else {
			$return_date_t = "'".$_POST['return_date']."'";
		}

		//update debt note
		
		$sqla = "Update ben_return SET
			
			return_remark='".$_POST['return_remark']."',
			
			return_pay='".$_POST['return_pay']."',
			
			return_track='".$_POST['return_track']."',
			
			return_date=".$return_date_t.",
			
			return_dat = curdate() where return_ref= '".$_POST['sale_ref']."'";
		
		
		
		sqlinsert($sqla);
		
		$row = getreturn_data($sale_ref);
		
		$return_pay=$row['return_pay'];
		
		$return_remark=$row['return_remark'];
		
		$return_track=$row['return_track'];
		
		$return_date=$row['return_date'];
		
	}
	
}

?>