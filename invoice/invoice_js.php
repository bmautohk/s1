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
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
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
	
	if (document.form1.sales_name.value == "" ) {
		missinginfo += "\n     -  Sales Name";
	}
	
	if (document.form1.cust_name.value == "" ) {
		missinginfo += "\n     -  Customer Name";
	}
	
	varString = document.form1.subTotal.value;
	if (varString != "") {
		intVal = parseFloat(varString);
		if (varString != intVal) {
			missinginfo += "\n     -  SubTotal. Please fill in a integer.";
		}
	}
	
	<? for ($m=1;$m<=$prod_n;$m++) {?>
	
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
/*				else if (intVal <= 0) {
					missinginfo += "\n     -  <?=$m?> Product Qty must be greater than 0.";
				}*/
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
	
	//calSubTotal();
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

function findPartNoAjax(goods_row, stockFlag) {
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
		
		document.getElementById("real_stock" + index).value = 'Retrieving ...';

		/*xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","productxml.php?product_id=" + product_id,true);
		xmlhttp.send(null);*/

		$.getJSON('productCustXml.php', {product_id: product_id, cust_cd: $('#cust_cd').val()}, function(data) {

			imgElem = $('#productCheckImg' + index);
			if (data == '') {
				imgElem.attr('src', "./images/wrong.png");
				imgElem.css('display', 'inline');
				$("#real_stock" + index).val(0);
				return;
			}

			imgElem.css('display', 'none');

			$('#goods_name' + index).val(data.product_name);
			$('#product_colour' + index).val(data.product_colour);
			$('#unit_price' + index).val(data.product_price_s);
			$('#pcs' + index).val(data.product_pcs);
			$('#goods_remark' + index).val(data.product_remark);
			$('#qty' + index).val('');

			xmlhttp2=GetXmlHttpObject();
			xmlhttp2.onreadystatechange=stateChangedStock;
			xmlhttp2.open("GET","productStockXml.php?product_id=" + product_id,true);
			xmlhttp2.send(null);
		});

	}
}

/*function stateChanged() {
	if (xmlhttp.readyState==4) {
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("product_id")[0];
		imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			imgElem.src = "./images/wrong.png";
			imgElem.style.display = 'inline';
			document.getElementById("real_stock" + index).value = '0';
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
}*/

function stateChangedStock() {
	if (xmlhttp2.readyState==4) {
		xmlDoc=xmlhttp2.responseXML;
		
		node = xmlDoc.getElementsByTagName("real_stock")[0].childNodes[0]
		if (node != null)	document.getElementById("real_stock" + index).value = node.nodeValue;
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
	document.getElementById("pcs" + row).value = "";
	document.getElementById("unit_price" + row).value = "";
	document.getElementById("qty" + row).value = "";
	document.getElementById("total" + row).value = "0";
	
	elem = document.getElementById("real_stock" + row);
	if (elem != null) {
		elem = elem.value = "N/A";
	}
}

function findCustomer() {
	$.getJSON('customerXml.php', {cust_cd: $('#cust_cd').val()}, function(data) {
		if (data == '') {
			$('#cust_name').val('');
			$('#cust_tel').val('');
			$('#cust_address').val('');
		}
		else {
			$('#cust_name').val(data.cust_company_name);
			$('#cust_tel').val(data.cust_tel);
	
			var address = '';
			if (data.cust_post_address1 != 'undefined') {
				address += data.cust_post_address1;
			}
			if (data.cust_post_address2 != 'undefined') {
				if (address != '') {
					address += ' ';
				}
				address += data.cust_post_address2;
			}
			$('#cust_address').val(address);
		}
		
	});

}

//  End -->
</script>
