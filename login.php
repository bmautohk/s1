<?
//prevents caching
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();

session_start();

//clear session variables
session_unset();

?>
<HTML>
<HEAD>
<TITLE>Login</TITLE>
</HEAD>
<BODY>
<H1><font face="Verdana" size="4" color="#2852A8">Login to Secure Area</font></H1>
<FORM METHOD="POST" ACTION="redirect.php">
<P><font face="Verdana" size="2" color="#2852A8"><STRONG>Username:</STRONG><BR>
</font><font color="#2852A8" face="Verdana">
<INPUT TYPE="text" NAME="username" SIZE=25 MAXLENGTH=25></font></p>
<P><font face="Verdana" size="2" color="#2852A8"><STRONG>Password:</STRONG><BR>
</font><font color="#2852A8" face="Verdana">
<INPUT TYPE="password" NAME="password" SIZE=25 MAXLENGTH=25></font></p>
<P><font face="Verdana"><font color="#2852A8">
<!--<input type="checkbox" name="remember" value="Yes"></font><font size="2" color="#2852A8">Remember 
me from this computer</font>--></font></p>
<P><font color="#2852A8">
<INPUT TYPE="submit" NAME="submit" VALUE="Login" style="font-family: Verdana"></font></P>
</FORM>
<p><font color="#2852A8" face="Verdana" size="2"><a href="emailpass.html">
<font color="#2852A8">Click here if would like your username and password to be 
e-mailed to the address we have on file.</font></a></font></p>
</BODY>
</HTML>