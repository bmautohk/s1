
<p><b><font face="Tahoma">User Added:</font></b></p>
<table border="1" id="table1">
	<tr>
		<td width="154"><font face="Tahoma" size="2">First Name:</td>
		<td><?php echo @$_POST[firstname]; ?></font></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">Last Name:</td>
		<td><?php echo @$_POST[lastname]; ?></font></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">Username:</td>
		<td><?php echo @$_POST[username]; ?></font></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">Password:</td>
		<td><?php echo @$_POST[password]; ?></font></td>
	</tr>
	<tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">E-Mail:</td>
		<td><?php echo @$_POST[email]; ?></font></td>
	</tr>
		<td width="154"><font face="Tahoma" size="2">Group Memberships:</td>
		<td><?php echo @$_POST[group1]; ?>&nbsp;</td>
	</tr>
	<tr>
		<td width="154">&nbsp;</td>
		<td><?php echo @$_POST[group2]; ?>&nbsp;</td>
	</tr>
	<tr>
		<td width="154">&nbsp;</td>
		<td><?php echo @$_POST[group3]; ?>&nbsp;</font></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">Redirect to:</font></td>
		<td><?php echo @$_POST[redirect]; ?></font></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">Password Change Req'd:</td>
		<td><?php if(@$_POST[pchange] == "1"){$ans1="Yes";}else{$ans1="No";} echo $ans1; ?></td>
	</tr>
	<tr>
		<td width="154"><font face="Tahoma" size="2">User E-Mailed:</td>
		<td><?php echo @$_POST[email_user]; ?></font></td>
	</tr>
</table>