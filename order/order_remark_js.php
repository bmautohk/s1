<script language="javascript" type="text/javascript">
function checkFields() {
	 
missinginfo = "";

 var letters = /^[0-9a-zA-Z]+$/;
if(letters.test($('#remark').val()))
{
 
	if($('#remark').val().length>16){
			//missinginfo+='\n        -   remark length is more than 32';
	}
}else{
	if($('#remark').val().length>16){
			//missinginfo+='\n        -   remark length is more than 16 eucjp';
	}	
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