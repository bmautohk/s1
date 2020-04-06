<?
include_once('../config.php');
include_once('../functions.php');
require_once("../phpmailer/class.phpmailer.php");



$today= date('Y-m-d');
$yestarday  =date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
$lastmonth = date('Y-m-d',mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
$last3month  = date('Y-m-d',mktime(0, 0, 0, date("m")-3,   date("d"),   date("Y")));

echo "today=".$today;
echo "yestarday=".$yestarday;
echo "lastmonth=".$lastmonth;
echo "last3mont=".$last3month;
$mailcontent="";

$connection = @mysql_connect($server, $dbusername, $dbpassword)
                                or die(mysql_error());

        $db = @mysql_select_db($db_name,$connection)
                                or die(mysql_error());

        $sql = "SELECT sum(sale_ship_fee+(sprod_price*sprod_unit)-sale_discount) as b FROM
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
	}



$sql = "SELECT sum(sale_ship_fee+(sprod_price*sprod_unit)-sale_discount) as b FROM
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
                        $mailcontent.= "\r\nSales Amount Yestarday : ".$sql->b."\r\n";
                }
        }

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
                        $mailcontent.= "Last Month <-> Today Top Item : ".$sql->b."(".$sql->a.")pcs\r\n";
                }
        }

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
// TODO
/* 
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
$mail->AddAddress("fannyyu338@yahoo.co.jp");
$mail->AddAddress("s1118s@yahoo.co.jp");
$mail->AddBCC ("statisticreport@bmautohk.com");
$mail->AddReplyTo("statisticreport@bmautohk.com");
$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(false);                               // send as HTML
$mail->Subject="daily report kaito";
$mail->Body=$mailcontent;
$mail->Send();
echo "end\n\r";*/
?>

