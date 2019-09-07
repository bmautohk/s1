<script language="javascript" type="text/javascript">
function checkFields() {
missinginfo = "";

 var letters = /^[0-9a-zA-Z]+$/;
 
	if($('#debt_remark').val().length>16){
			//missinginfo+='\n        -   remark length is more than 16 eucjp';
	}	
 


if($('#debt_cust_address1').val().length>16){
		missinginfo+='\n        -   Address1 length is more than 16';
}
if($('#debt_cust_address2').val().length>16){
		missinginfo+='\n        -   Address2 length is more than 16';
}
if($('#debt_cust_address3').val().length>16){
		missinginfo+='\n        -   Address3 length is more than 16';
}
if($('#debt_remark').val().length>16){
	//	missinginfo+='\n        -   debt_remark length is more than 16';
}
if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}


return true;
}
</script>