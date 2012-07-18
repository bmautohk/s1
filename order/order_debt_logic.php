<?

$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-1)\">";

 

if (isset($_GET['sale_ref']) and getdebt_data($_GET['sale_ref']))

{

$sale_ref=$_GET['sale_ref'];

$row = getdebt_data($sale_ref);

$debt_pay_name=$row['debt_pay_name'];

$debt_tel=$row['debt_tel'];

$debt_mobile=$row['debt_mobile'];

//$debt_email=$row['debt_email'];

$debt_cust_address1=$row['debt_cust_address1'];

$debt_cust_address2=$row['debt_cust_address2'];

$debt_cust_address3=$row['debt_cust_address3'];

$debt_post_co=$row['debt_post_co'];

$debt_bank=$row['debt_bank'];

$debt_pay_method=$row['debt_pay_method'];

$debt_shipping_method=$row['debt_shipping_method'];

$debt_remark=$row['debt_remark'];



}

else{

$debt_pay_name="";

$debt_tel="";

$debt_mobile="";

$debt_email="";

$debt_cust_address1="";

$debt_cust_address2="";

$debt_cust_address3="";

$debt_post_co="";

$debt_bank="";

$debt_pay_method="";

$debt_shipping_method="";

$debt_remark="";



}



if (isset($_GET['sale_ref']))

{$sale_ref=$_GET['sale_ref'];}



if (isset($_POST['isupdate'])) {

	$sale_ref=$_POST['sale_ref'];

	if (!getdebt_data($sale_ref)) {

		$sqla = "INSERT INTO ben_debt SET
		
		debt_ref='".$_POST['sale_ref']."',
		
		debt_tel='".$_POST['debt_tel']."',
		
		debt_pay_name='".$_POST['debt_pay_name']."',
		
		debt_mobile='".$_POST['debt_mobile']."',
		
		debt_cust_address1='".$_POST['debt_cust_address1']."',
		
		debt_cust_address2='".$_POST['debt_cust_address2']."',
		
		debt_cust_address3='".$_POST['debt_cust_address3']."',
		
		debt_post_co='".$_POST['debt_post_co']."',
		
		debt_bank='".$_POST['debt_bank']."',
		
		debt_pay_method='".$_POST['debt_pay_method']."',
		
		debt_remark='".$_POST['debt_remark']."',
		
		debt_shipping_method='".$_POST['debt_shipping_method']."'";
		
		$sqlb = "Update ben_sale SET
		
		sale_name ='".$_POST['sale_name']."',
		
		sale_email2 ='".$_POST['sale_email2']."',
		
		sale_email ='".$_POST['sale_email']."' where sale_ref= '".$_POST['sale_ref']."'";
		
		sqlinsert($sqla);
		
		sqlinsert($sqlb);

		// Retrieve
		$row = getdebt_data($sale_ref);
		
		$debt_tel=$row['debt_tel'];
		
		$debt_pay_name=$row['debt_pay_name'];
		
		$debt_mobile=$row['debt_mobile'];
		
		$debt_cust_address1=$row['debt_cust_address1'];
		
		$debt_cust_address2=$row['debt_cust_address2'];
		
		$debt_cust_address3=$row['debt_cust_address3'];
		
		$debt_post_co=$row['debt_post_co'];
		
		$debt_bank=$row['debt_bank'];
		
		$debt_pay_method=$row['debt_pay_method'];
		
		$debt_shipping_method=$row['debt_shipping_method'];
		
		$debt_remark=$row['debt_remark'];
		
		
		
		$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-2)\">";
		
		//$debt_email=$row['debt_email'];
		
		//$debt_cust_name=$row['debt_cust_name'];
	}
	else {
		//update debt note
		
		$sqla = "Update ben_debt SET
		
		debt_tel='".$_POST['debt_tel']."',
		
		debt_mobile='".$_POST['debt_mobile']."',
		
		debt_pay_name='".$_POST['debt_pay_name']."',
		
		debt_cust_address1='".$_POST['debt_cust_address1']."',
		
		debt_cust_address2='".$_POST['debt_cust_address2']."',
		
		debt_cust_address3='".$_POST['debt_cust_address3']."',
		
		debt_post_co='".$_POST['debt_post_co']."',
		
		debt_bank='".$_POST['debt_bank']."',
		
		debt_pay_method='".$_POST['debt_pay_method']."',
		
		debt_remark='".$_POST['debt_remark']."',
		
		debt_shipping_method='".$_POST['debt_shipping_method']."' where debt_ref= '".$_POST['sale_ref']."'";
		
		$sqlb = "Update ben_sale SET
		
		sale_name ='".$_POST['sale_name']."',
		
		sale_email2 ='".$_POST['sale_email2']."',
		
		sale_email ='".$_POST['sale_email']."' where sale_ref= '".$_POST['sale_ref']."'";
		
		sqlinsert($sqla);
		
		sqlinsert($sqlb);
	
		// Retrieve
		$row =getdebt_data($sale_ref);
		
		$debt_pay_name=$row['debt_pay_name'];
		
		$debt_tel=$row['debt_tel'];
		
		$debt_mobile=$row['debt_mobile'];
		
		//$debt_email=$row['debt_email'];
		
		$debt_cust_address1=$row['debt_cust_address1'];
		
		$debt_cust_address2=$row['debt_cust_address2'];
		
		$debt_cust_address3=$row['debt_cust_address3'];
		
		$debt_post_co=$row['debt_post_co'];
		
		$debt_bank=$row['debt_bank'];
		
		$debt_pay_method=$row['debt_pay_method'];
		
		$debt_remark=$row['debt_remark'];
		
		$debt_shipping_method=$row['debt_shipping_method'];
		
		$check = "update";
		
		$back_button =  "<INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\" ONCLICK=\"history.go(-2)\">";
		
	}

}

?>