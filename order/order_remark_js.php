<script language="javascript" type="text/javascript">
function checkFields() {
missinginfo = "";

 
 
if($('#remark').val().length>16){
		missinginfo+='\n        -   remark length is more than 16';
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