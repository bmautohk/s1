<?
include_once('../config.php');
include_once('../functions.php');
require_once("../phpmailer/class.phpmailer.php");



$today= date('Y-m-d');
$yestarday  =date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
$lastmonth = date('Y-m-d',mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
$last3month  = date('Y-m-d',mktime(0, 0, 0, date("m")-3,   date("d"),   date("Y")));

$current_month_start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
$current_month_end_date = $today;

$last_month_start_date = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, 1, date("Y")));
if (date('m', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))) == date("m")) {
	// Avoid the cases e.g. "31-Apr-2013"
	$last_month_end_date = date('Y-m-t', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))); // Last date of the month
}
else {
	$last_month_end_date = date('Y-m-d', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
}


echo "today=".$today;
echo "yestarday=".$yestarday;
echo "lastmonth=".$lastmonth;
echo "last3mont=".$last3month;
echo "Current Month=".$current_month_start_date." - ".$current_month_end_date;
echo "Last Month=".$last_month_start_date." - ".$last_month_end_date;
$mailcontent="";

$connection = @mysql_connect($server, $dbusername, $dbpassword)
                                or die(mysql_error());

        $db = @mysql_select_db($db_name,$connection)
                                or die(mysql_error());

// Sales Amount Today
        /* $sql = "SELECT sum(sale_ship_fee+(sprod_price*sprod_unit)-sale_discount) as b FROM
 `ben_sale` a , `ben_sale_prod` b 
 WHERE sale_date='".$today."' 
 and a.sale_ref=b.sprod_ref order by sale_ref
 "; 
        
        $result = @mysql_query($sql, $connection) or die(mysql_error());


        //get the number of rows in the result set
        $num = mysql_num_rows($result);
        //set session variables if there is a match
        if ($num != 0)
        {
                while ($sql = mysql_fetch_object($result)){
			$mailcontent= "\r\nSales Amount Today : ".$sql->b;
		}
	} */
	
	$todaySaleAmount = getSaleAmount($connection, $today, $today);
	$mailcontent = "\r\nSales Amount Today (non-tax) : ".$todaySaleAmount;

// Sales Amount Yesterday
/* $sql = "SELECT sum(sale_ship_fee+(sprod_price*sprod_unit)-sale_discount) as b FROM
 `ben_sale` a , `ben_sale_prod` b
 WHERE sale_date='".$yestarday."'
 and a.sale_ref=b.sprod_ref order by sale_ref
 ";

        $result = @mysql_query($sql, $connection) or die(mysql_error());


        //get the number of rows in the result set
        $num = mysql_num_rows($result);
        //set session variables if there is a match
        if ($num != 0)
        {
                while ($sql = mysql_fetch_object($result)){
                        $mailcontent.= "\r\nSales Amount Yesterday : ".$sql->b."\r\n";
                }
        } */
		$yesterdaySaleAmount = getSaleAmount($connection, $yestarday, $yestarday);
		$mailcontent .= "\r\nSales Amount Yesterday (non-tax) : ".$yesterdaySaleAmount."\r\n";

// Total Sale Current Month
		$currentMonthTotalSale = getSaleAmount($connection, $current_month_start_date, $current_month_end_date);
		$mailcontent .= "\r\nTotal Sale Current Month (non-tax) : ".$currentMonthTotalSale."\r\n";
		
// Total Sale Last Month
		$lastMonthTotalSale = getSaleAmount($connection, $last_month_start_date, $last_month_end_date);
		$mailcontent .= "Total Sale Last Month (".$last_month_start_date." - ".$last_month_end_date.") (non-tax) : ".$lastMonthTotalSale."\r\n";

// Compare with last month
		if ($lastMonthTotalSale != 0) {
			$diff = ($currentMonthTotalSale - $lastMonthTotalSale) / ( $lastMonthTotalSale * 1.0) * 100;
		}
		else {
			$diff = 0;
		}
		
		$mailcontent .= "Compare with last month : ".number_format($diff, 2)."%\r\n";

// Total Cost Current Month
		$currentMonthTotalCost = getTotalCost($connection, $current_month_start_date, $current_month_end_date);
		$mailcontent.= "\r\nTotal Cost Current Month : ".$currentMonthTotalCost."\r\n";
		
// Total Cost Last Month
		$lastMonthTotalCost = getTotalCost($connection, $last_month_start_date, $last_month_end_date);
		$mailcontent.= "Total Cost Last Month (".$last_month_start_date." - ".$last_month_end_date.") : ".$lastMonthTotalCost."\r\n";

// Compare with last month
		

		if ($lastMonthTotalCost != 0) {
			$diff = ($currentMonthTotalCost - $lastMonthTotalCost) / ( $lastMonthTotalCost * 1.0) * 100;
		}
		else {
			$diff = 0;
		}

		$mailcontent.= "Compare with last month : ".number_format($diff, 2)."%\r\n";

// Total Profit(GP) Current Month
		// Get JP - RMB exchange rate
		$sql = "SELECT jp_rate FROM rmb_jp_rate";
		$result = @mysql_query($sql, $connection) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$jpRate = $row['jp_rate'];
		mysql_free_result($result);
		
		$currentMonthGP = $currentMonthTotalSale - $currentMonthTotalCost * $jpRate;
		
		$mailcontent.= "\r\nTotal Profit(GP) Current Month : ".number_format($currentMonthGP, 2)."\r\n";

// Total Profit(GP) Last Month
		$lastMonthGP = $lastMonthTotalSale - $lastMonthTotalCost * $jpRate;
		$mailcontent.= "Total Profit(GP) Last Month (".$last_month_start_date." - ".$last_month_end_date.") : ".number_format($lastMonthGP, 2)."\r\n";
		
// Compare with last month :+/- xx %
		if ($lastMonthGP != 0) {
			$diff = ($currentMonthGP - $lastMonthGP) / ($lastMonthGP * 1.0) * 100;
		}
		else {
			$diff = 0;
		}
		
		$mailcontent.= "Compare with last month : ".number_format($diff, 2)."%\r\n";

// Last Month <-> Today Top Item
$sql = " SELECT sum(sprod_unit) a ,sprod_id b FROM
 `ben_sale` a , `ben_sale_prod` b 
 WHERE sale_date>='".$lastmonth."' and sale_date<='".$today."' 
 and a.sale_ref=b.sprod_ref 
 group by sprod_id order by 1 desc
 limit 0,1
 ";

        $result = @mysql_query($sql, $connection) or die(mysql_error());


        //get the number of rows in the result set
        $num = mysql_num_rows($result);
        //set session variables if there is a match
        if ($num != 0)
        {
                while ($sql = mysql_fetch_object($result)){
                        $mailcontent.= "\r\nLast Month <-> Today Top Item : ".$sql->b."(".$sql->a.")pcs\r\n";
                }
        }

// Last 3 Month <-> Today Top Item
$sql = " SELECT sum(sprod_unit) a ,sprod_id b FROM
 `ben_sale` a , `ben_sale_prod` b
 WHERE sale_date>='".$last3month."' and sale_date<='".$today."'
 and a.sale_ref=b.sprod_ref
 group by sprod_id order by 1 desc
 limit 0,1
 ";

        $result = @mysql_query($sql, $connection) or die(mysql_error());


        //get the number of rows in the result set
        $num = mysql_num_rows($result);
        //set session variables if there is a match
        if ($num != 0)
        {
                while ($sql = mysql_fetch_object($result)){
                        $mailcontent.= "Last 3 Month <-> Today Top Item : ".$sql->b."(".$sql->a.")pcs\r\n";
                }
        }
        
// Top Sale ID Current Month: Name
        $sql = "select sale_group, sum(total_sale) total_sale
        from (
        SELECT a.sale_group, a.sale_ref, sum(sprod_price*sprod_unit) - sale_discount + sale_ship_fee total_sale
        FROM ben_sale a , ben_sale_prod b
        WHERE sale_date between '".$current_month_start_date."' and '".$current_month_end_date."'
        and a.sale_ref=b.sprod_ref
        group by a.sale_group, a.sale_ref) tmp
        group by sale_group
        order by total_sale desc
        ";
        
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        $row = mysql_fetch_object($result);
        $num = mysql_num_rows($result);
        if ($num != 0) {
        	$topSale = $row->sale_group;
        	$topSaleAmount = $row->total_sale;
        }
        else {
        	$topSale = "";
        	$topSaleAmount = "";
        }
        
        mysql_free_result($result);
        
        $mailcontent.= "\r\nTop Sale ID Current Month : ".$topSale."\r\n";

// Top Sale ID Amount Current Month
        $mailcontent.= "Top Sale ID Amount Current Month : ".$topSaleAmount."\r\n";
 
//echo "<br>Content: ".str_replace("\r\n", "<br>", $mailcontent); // For development
 
$mail = new PHPMailer();
$mail->IsSMTP();                                   // send via SMTP
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->SMTPSecure="ssl";
$mail->Host     = "smtp.gmail.com"; // SMTP servers
$mail->Port     ="465";
$mail->Username = "statisticreport@bmautohk.com";  // SMTP username
$mail->Password = "invoice2010"; // SMTP password
$mail->CharSet ="shift_jis";
$mail->From = "statisticreport@bmautohk.com";
$mail->FromName = "report";
$mail->AddAddress("rickykei@gmail.com");
$mail->AddAddress("bmbensze@163.com");
$mail->AddAddress("bm.ben.sze@gmail.com");
//$mail->AddAddress("fannyyu338@yahoo.co.jp");
$mail->AddAddress("catalog2000@goo.jp");
$mail->AddAddress("s1118s@yahoo.co.jp");
$mail->AddAddress("summary1@163.com");
$mail->AddBCC ("statisticreport@bmautohk.com");
$mail->AddBCC ("kellysmwong@gmail.com");
$mail->AddReplyTo("statisticreport@bmautohk.com");
$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(false);                               // send as HTML
$mail->Subject="daily report kaito";
$mail->Body=$mailcontent;
$mail->Send();
echo "end\n\r";

function getSaleAmount($connection, $startDate, $endDate) {
	$sql = "select sum(total_sale) total_sale
	from (
	SELECT sum(sprod_price*sprod_unit) - sale_discount + sale_ship_fee total_sale
	FROM ben_sale a , ben_sale_prod b
	WHERE sale_date between '".$startDate."' and '".$endDate."'
	and a.sale_ref=b.sprod_ref
	group by a.sale_ref) tmp
	";
	
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	$row = mysql_fetch_object($result);
	$amount = $row->total_sale;
	mysql_free_result($result);
	
	return $amount;
}

function getTotalCost($connection, $startDate, $endDate) {
	$sql = "SELECT sum(product_cost_rmb * sprod_unit) as product_cost_rmb
	FROM ben_sale a, ben_sale_prod b left outer join product c on b.sprod_id = c.product_id
	WHERE sale_date between '".$startDate."' and '".$endDate."'
	and a.sale_ref=b.sprod_ref
	";
	
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	$row = mysql_fetch_object($result);
	$amount = $row->product_cost_rmb;
	mysql_free_result($result);
	
	return $amount;
}
?>

