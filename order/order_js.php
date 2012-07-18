<script language="javascript" type="text/javascript">
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}

function IsInteger(varString) 
{ 
	return /^[0-9]+$/i.test(varString);	
}
function checkFields() {
missinginfo = "";

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


if (missinginfo != "") {
missinginfo ="_____________________________\n" +
"You failed to correctly fill in your:\n" +
missinginfo + "\n_____________________________" +
"\nPlease re-enter and submit again!";
alert(missinginfo);
return false;
}

// Validate product no.
/*var isValid = true;
var query = '';
var invalidProductInfo = 'The following product no. does not exist\n';

$('input:text[name^="sprod_id_"]').each(function(index, value) {
	query = query + 'product_id[]=' + $(value).val() + '&';
});

$.ajax({
		url: 'checkProductNotExist.php?' + query, 
		dataType: 'json',
		async: false,
		success: function(data) {
			if (data != '') {
				isValid = false;
				$(data).each(function(index, value) {
					invalidProductInfo = invalidProductInfo + value + '\n';
				});
			}
		}
});

if (!isValid) {
	alert(invalidProductInfo);
	return false;
}*/

return true;
}

function openProdWin(idx) {
	var custCd = document.forms[0].cust_cd.value;
	window.open('order_find_product.php?prod_sel=' + idx + '&cust_cd=' + custCd,'popuppage','width=500,height=400,top=100,left=100 scrollbars=1');
}

function findProduct(idx) {
	var product_id = $('#sprod_id_' + idx).val();

	if (product_id == '') {
		return;
	}
	
	$.getJSON('productCustXml.php', {product_id: product_id, cust_cd: $('#cust_cd').val()}, function(data) {
		if (data != '') {
			$('#sprod_name_' + idx).val(data.product_name);
			$('#sprod_price_' + idx).val(data.product_price_s);

			// Calculate the product's stock (for Order Add only)
			getProductStock(idx, product_id);
		}
		else {
			$('#sprod_name_' + idx).val('');
			$('#sprod_price_' + idx).val('');

			// Clear stock
			if ($('#stock_' + idx).length != 0) {
				// Textbox "Stock" exists
				$('#stock_' + idx).val('');
			}
		}

		$('#sprod_unit_' + idx).val('');
	});
}

function getProductStock(idx, product_id) {
	var elem = $('#stock_' + idx);

	if ($(elem).length == 0) {
		// Textbox "stock" not exist
		return;
	}

	$(elem).val('Retrieving ...');
	$.ajax({
			url: 'productStockXml.php', 
			data: {product_id: product_id},
			dataType: 'xml',
			success: function(data) {
				$(data).find('product').each(function() {
					var stock = $(this).find('real_stock').text();
					$(elem).val(stock);
				});
			}
	});
}
//  End -->
</script>
