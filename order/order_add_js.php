<script language="javascript" type="text/javascript">
<!--
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
// -->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin




function IsInteger(varString) 
{ 
	return /^[0-9]+$/i.test(varString);	
}
function checkFields() {
missinginfo = "";
//if (document.form1.sale_name.value == "") {
//missinginfo += "\n     -  Name";
//}


if ((document.form1.sale_ref_a[0].checked) && (document.form1.sale_ref_aa.value == "" )) {
missinginfo += "\n     -  Order Number";
}
<? for ($m=1;$m<=$prod_n;$m++) {?>



if (document.form1.sprod_id_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product id ";}
if (document.form1.sprod_name_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Name ";}
if (document.form1.sprod_unit_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Unit ";}
else {
if (!IsInteger(document.form1.sprod_unit_<?=$m?>.value)) {
missinginfo += "\n     -  <?=$m?> Product Unit. Please fill in a integer.";}
}
if (document.form1.sprod_price_<?=$m?>.value == "") {
missinginfo += "\n     -  <?=$m?> Product Price ";}

else {

if (/\./.test(document.form1.sprod_price_<?=$m?>.value) || IsInteger(document.form1.sprod_price_<?=$m?>.value))
{missinginfo += "";} else
{missinginfo += "\n     -  <?=$m?> Product Price. Please fill in a number.";}


}

<? }?>

//if ((document.form1.sale_email.indexOf('@') == -1) || (document.form1.sale_email.indexOf('.') == -1)) 
//{missinginfo += "\n     -  Email address";}


if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}
else return true;
}
//  End -->
</script>