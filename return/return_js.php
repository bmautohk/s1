<style type="text/css">
@import url(js/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="js/cal/calendar.js"></script>
<script type="text/javascript" src="js/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/cal/calendar-setup.js"></script>
<script language="javascript" type="text/javascript">

var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}

function init() {
	<? for($i=1;$i<=30;$i++){ ?>
		document.form1.productCheckImg<?=$i?>.style.display = 'none';
	<? }?>
	
	submit_success="<? echo $submit_success ?>";
	id="<? echo $id?>";
	
	submitResult(submit_success, id);
}

function IsInteger(varString) 
{ 
	//return /^[0-9]+$/i.test(varString);
	return varString == parseFloat(varString);
}

function checkFields() {
	missinginfo = "";
	
	if (document.form1.sales_name.value == "" ) {
		missinginfo += "\n     -  Sales Name";
	}
	
	<? for ($m=1;$m<=30;$m++) {?>
	
	if (document.form1.goods_partno<?=$m?>.value != "") {
		if (document.form1.productCheckImg<?=$m?>.style.display != "none") {
			// Product not exists
			missinginfo += "\n     -  <?=$m?> Product no not exists.";
		}
		else {
			// Check QTY
			if (document.form1.qty<?=$m?>.value == "") {
				missinginfo += "\n     -  <?=$m?> Qty ";
			} else {
				varString = document.form1.qty<?=$m?>.value;
				intVal = parseFloat(varString);
				if (varString != intVal) {
					missinginfo += "\n     -  <?=$m?> Product Qty. Please fill in a integer.";
				}
				else if (intVal <= 0) {
					missinginfo += "\n     -  <?=$m?> Product Qty must be greater than 0.";
				}
			}
		
			// Check cost
			if (document.form1.unit_price<?=$m?>.value == "") {
				missinginfo += "\n     -  <?=$m?> Product Cost ";
			}
			else {
				varString = document.form1.unit_price<?=$m?>.value;
				intVal = parseFloat(varString);
				if (varString != intVal) {
					missinginfo += "\n     -  <?=$m?> Product Cost. Please fill in a integer.";
				}
			}
		}
	}
	
	<? }?>

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

function calProdTotal(prod_sel) {
	qty = document.getElementById("qty" + prod_sel).value;
	unit_price = document.getElementById("unit_price" + prod_sel).value;
	document.getElementById("total" + prod_sel).value = qty * unit_price;
	
	calSubTotal();
}

function calSubTotal() {
	total = 0;
	<? for ($m=1;$m<=30;$m++) {?>
		if (document.form1.goods_partno<?=$m?>.value != "") {
			total = total + (document.form1.total<?=$m?>.value * 1);
		}
	<? }?>
	document.form1.subTotal.value = total;
}

function findPartNoAjax(goods_partno, goods_row) {
	index = goods_row;
	product_id = document.getElementById("goods_partno" + index).value;
	
	if (product_id == '') {
		document.getElementById("productCheckImg" + index).style.display = 'none';
		clearProductField(index);
		calSubTotal();
	}
	else {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}

		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","productxml.php?product_id=" + product_id,true);
		xmlhttp.send(null);
	}
}

function stateChanged() {
	if (xmlhttp.readyState==4) {
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("product_id")[0];
		imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			imgElem.src = "./images/wrong.png";
			imgElem.style.display = 'inline';
			return;
		}
		else {
			imgElem.style.display = 'none';
		}

		document.getElementById("goods_partno" + index).value = xmlDoc.getElementsByTagName("product_id")[0].childNodes[0].nodeValue;
		
		node = xmlDoc.getElementsByTagName("product_name")[0].childNodes[0]
		if (node != null) document.getElementById("goods_name" + index).value = node.nodeValue;
		
		node = xmlDoc.getElementsByTagName("product_colour")[0].childNodes[0]
		if (node != null)	document.getElementById("product_colour" + index).value = node.nodeValue;
		
		node = xmlDoc.getElementsByTagName("product_price_s")[0].childNodes[0]
		if (node != null)	document.getElementById("unit_price" + index).value = node.nodeValue;

		node = xmlDoc.getElementsByTagName("product_remark")[0].childNodes[0]
		if (node != null)	document.getElementById("goods_remark" + index).value = node.nodeValue;

		document.getElementById("qty" + index).value = "";
	}
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

function submitResult(submit_success, id) {
	if (submit_success == "1") {
		alert("Submit Successfully! ID: " + id);
	} else if (submit_success == "0") {
		alert("Submit Failed!");
	}
}
function clearProductField(row) {
	document.getElementById("goods_name" + row).value = "";
	document.getElementById("goods_remark" + row).value = "";
	document.getElementById("product_colour" + row).value = "";
	document.getElementById("unit_price" + row).value = "";
	document.getElementById("qty" + row).value = "";
	document.getElementById("total" + row).value = "0";
}

//  End -->
</script>
