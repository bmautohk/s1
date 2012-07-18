<?php
 

function gmail_summary_page($user, $password)
{
?>
<html>
<head><title>Gmail summary for <?=$user?></title>
<style type="text/css">body { font-family: arial, sans-serif; margin: 40px;}</style>
<meta
http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
    
    $imapaddress = "{imap.gmail.com:993/imap/ssl/novalidate-cert}";
    $imapmainbox = "INBOX";
    $maxmessagecount = 10;

    display_mail_summary($imapaddress, $imapmainbox, $user, $password, $maxmessagecount);
?>
</body>
</html>
<?php
}

function display_mail_summary($imapaddress, $imapmainbox, $imapuser, $imappassword, $maxmessagecount)
{
    $imapaddressandbox = $imapaddress . $imapmainbox;

    $connection = imap_open ($imapaddressandbox, $imapuser, $imappassword)
        or die("Can't connect to '" . $imapaddress . 
        "' as user '" . $imapuser . 
        "' with password '" . $imappassword .
        "': " . imap_last_error());

    echo "<u><h1>Gmail information for " . $imapuser ."</h1></u>";

    echo "<h2>Mailboxes</h2>\n";
    $folders = imap_listmailbox($connection, $imapaddress, "*")
        or die("Can't list mailboxes: " . imap_last_error());

    foreach ($folders as $val)
        echo $val . "<br />\n";

    echo "<h2>Inbox headers</h2>\n";
    $headers = imap_headers($connection)
        or die("can't get headers: " . imap_last_error());

    $totalmessagecount = sizeof($headers);

    echo $totalmessagecount . " messages<br/><br/>";

    if ($totalmessagecount<$maxmessagecount)
        $displaycount = $totalmessagecount;
    else
        $displaycount = $maxmessagecount;

    for ($count=1; $count<=$displaycount; $count+=1)
    {
        $headerinfo = imap_headerinfo($connection, $count)
            or die("Couldn't get header for message " . $count . " : " . imap_last_error());
        $from = $headerinfo->fromaddress;
        $subject = $headerinfo->subject;
        $date = $headerinfo->date;
        echo "<em><u>".$from."</em></u>: ".$subject." - <i>".$date."</i><br />\n";
    }

    echo "<h2>Message bodies</h2>\n";
$emails = imap_search($connection,'ALL');
  foreach($emails as $email_number) {
  
	 $overview = imap_fetch_overview($connection,$email_number,0);
		$structure = imap_fetchstructure($connection, $email_number);
        $Body = imap_fetchbody($connection, $email_number,2)
            or die("Can't fetch body for message " . $email_number . " : " . imap_last_error());
       // echo "<pre>". htmlspecialchars($body) . "</pre><hr/>";
	  
	  // $body = iconv("ISO-2022-JP", "UTF-8", $body);
	   // $Body = imap_base64($Body);
	      $Body = base64_decode($Body);
		// $Body = mb_convert_encoding($Body, "utf-8");
		// $Body = htmlspecialchars($Body);
		 // $Body = preg_replace('/¡/',"@",$Body);
		 
	 echo "<pre>".  var_dump($overview)  . "</pre><hr/>";
	  echo "<pre>".  var_dump($structure)  . "</pre><hr/>";
		echo "<pre>". htmlspecialchars($Body) . "</pre><hr/>";
    }

    imap_close($connection);
}

$user = "rickykei@bmautohk.com";
$password = "invoice2010";
gmail_summary_page($user, $password);

?>
