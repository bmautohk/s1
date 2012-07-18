<style type="text/css">
@import url(js/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="js/cal/calendar.js"></script>
<script type="text/javascript" src="js/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/cal/calendar-setup.js"></script>
<script language="javascript" type="text/javascript">

var index;
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=yes,resizable=no';
win=window.open(mypage,myname,settings);}

function init() {
	<? for($i=1;$i<=$prod_n;$i++){ ?>
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
	
	if (document.form1.invoice_id.value != "" && !IsInteger(document.form1.invoice_id.value)) {
		missinginfo += "\n     -  Invoice ID. Please fill in a integer.";
	}
	
	// Check Invoice ID
	if (document.form1.staff_name.value == "" ) {
		missinginfo += "\n     -  Staff Name";
	}
	
	if (document.form1.supp_name.value == "" ) {
		missinginfo += "\n     -  Supplier Name";
	}
	
	<? for ($m=1;$m<=$prod_n;$m++) {?>
	
	if (document.form1.goods_partno<?=$m?>.value != "") {
		
		if (document.form1.productCheckImg<?=$m?>.style.display != "none") {
			// Product not exists
			missinginfo += "\n     -  <?=$m?> Product no not exists.";
		}
		else {
			// Check PCS
			if (document.form1.pcs<?=$m?>.value == "") {
				missinginfo += "\n     -  <?=$m?> Qty ";
			} else {
				varString = document.form1.pcs<?=$m?>.value;
				intVal = parseFloat(varString);
				if (varString != intVal) {
					missinginfo += "\n     -  <?=$m?> Product Pcs. Please fill in a integer.";
				}
				else if (intVal < 0) {
					missinginfo += "\n     -  <?=$m?> Product Pcs must be postive.";
				}
			}
			
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
		
			// Check unit price
			if (document.form1.unit_price<?=$m?>.value == "") {
				missinginfo += "\n     -  <?=$m?> Product Price ";
			}
			else {
				varString = document.form1.unit_price<?=$m?>.value;
				intVal = parseFloat(varString);
				if (varString != intVal) {				missinginfo += "\n     -  <?=$m?> Product Price. Please fill in a integer.";
				}
				else if (intVal <= 0) {
					missinginfo += "\n     -  <?=$m?> Product Price must be greater than 0.";
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

function editByFactoryCheckFields() {
	missinginfo = "";
	
	var obj = document.getElementsByName("wareHouseCode");
	var len = obj.length;
	if (len > 0) {
		var checked = false;
		for (i = 0; i < len; i++) {
			if (obj[i].checked == true) {
				checked = true;
				break;
			}
		}
		if (checked == false) {
			missinginfo += "\n     -  Ware House";
		}
	}
	
	obj = document.getElementsByName("po_status");
	len = obj.length;
	if (len > 0) {
		var checked = false;
		for (i = 0; i < len; i++) {
			if (obj[i].checked == true) {
				checked = true;
				break;
			}
		}
		if (checked == false) {
			missinginfo += "\n     -  Close PO Flag";
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
	else return true;
}

function checkShipItemFields() {
	missinginfo = "";

	if (document.form1.staff_name.value == "" ) {
		missinginfo += "\n     -  Staff Name";
	}
	
	// Check wareHouse
	var isChecked = false;
	for (var i = 0; i < 4; i++) {
		if (document.form1.wareHouseCode[i].checked) {
			isChecked = true;
			break;
		}
	}
		
	if (!isChecked) {
		missinginfo += "\n     -  Ware House";
	}
	
	prod_n = '<?=$prod_n?>';
	for (var i = 0; i < prod_n; i++) {
		if (document.form1.elements["ship_qty" + (i+1)].value != "" && !IsInteger(document.form1.elements["ship_qty" + (i+1)].value)) {
			missinginfo += "\n     -   " + (i + 1) + " Ship Qty must be an integer.";
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
	<? for ($m=1;$m<=$prod_n;$m++) {?>
		if (document.form1.goods_partno<?=$m?>.value != "") {
			total = total + (document.form1.total<?=$m?>.value * 1);
		}
	<? }?>
	document.form1.subTotal.value = total;
}

// ---------------------------------------------------------------------------------------------

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

		node = xmlDoc.getElementsByTagName("product_pcs")[0].childNodes[0]
		if (node != null)	document.getElementById("pcs" + index).value = node.nodeValue;

		node = xmlDoc.getElementsByTagName("product_remark")[0].childNodes[0]
		if (node != null)	document.getElementById("goods_remark" + index).value = node.nodeValue;

		document.getElementById("qty" + index).value = "";
	}
}

// ---------------------------------------------------------------------------------------------

function findInvoiceAjax(element_id) {
	invoice_id = document.getElementById(element_id).value;
	
	if (invoice_id != '') {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}

		xmlhttp.onreadystatechange=stateChanged2;
		xmlhttp.open("GET","po/poxml.php?invoice_id=" + invoice_id,true);
		xmlhttp.send(null);
	}
}

function stateChanged2() {
	if (xmlhttp.readyState==4) {
		xmlDoc=xmlhttp.responseXML;
		document.getElementById("txtInvCheck").innerHTML = xmlhttp.responseText;
	}
}

// ---------------------------------------------------------------------------------------------
function updPOProdOrder(row_no, po_prod_id) {
	index = row_no;
	if (po_prod_id != '') {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}

		xmlhttp.onreadystatechange=stateChanged3;
		xmlhttp.open("GET","po/updPOProdOrderXml.php?po_prod_id=" + po_prod_id,true);
		xmlhttp.send(null);
	}
}

function stateChanged3() {
	if (xmlhttp.readyState==4) {
		document.getElementById("ordered" + index).value = 'Ordered';
		document.getElementById("ordered" + index).disabled = true;
	}
}

// ---------------------------------------------------------------------------------------------

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
	document.getElementById("pcs" + row).value = "";
	document.getElementById("unit_price" + row).value = "";
	document.getElementById("qty" + row).value = "";
	document.getElementById("total" + row).value = "0";
}

//  End -->
</script>
