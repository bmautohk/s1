<script >
function gen_csv(){
	if ($('#prod_id')!= undefined)
		prod_id=$('#prod_id').val();
	if ($('#prod_name')!= undefined)
		prod_name=$('#prod_name').val();
	if ($('#search_sale')!= undefined)
		search_sale=$('#search_sale').val();
	if ($('#search_date')!= undefined)
		search_date=$('#search_date').val();
	if ($('#sale_or')!= undefined)
		sale_or=$('#sale_or').val();
	if ($('#sale_as')!= undefined)	
		sale_as=$('#sale_as').val();
	//if ($('#sprod_top')!= undefined)
	if ($('#sprod_top').attr('checked') == true) {	
		sprod_top=$('#sprod_top').val();
	}
	else {
		sprod_top = '';
	}
	if ($('#date_start')!=undefined)
		date_start=$('#date_start').val();
	if ($('#date_end')!=undefined)
		date_end=$('#date_end').val();
	if ($('#get_username')!=undefined)
		get_username=$('#get_username').val();
	if ($('#sprod_select')!=undefined)
		sprod_select=$('#sprod_select').val();
			
  window.open('report/report_prod_csv.php?prod_id='+prod_id+'&prod_name='+prod_name+'&search_sale='+search_sale+'&search_date='+search_date+'&sale_or='+sale_or+'&sale_as='+sale_as+'&sprod_top='+sprod_top+'&date_start='+date_start+'&date_end='+date_end+'&get_username='+get_username+'&sprod_select='+sprod_select,'mywindow','')
}</script>
