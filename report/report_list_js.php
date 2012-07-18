<script >
function gen_csv(){
	if ($('#sale_ref')!= undefined)
		sale_ref=$('#sale_ref').val();
	if ($('#prod_name')!= undefined)
		prod_name=$('#prod_name').val();
	/*if ($('#search_sale')!= undefined)
		search_sale=$('#search_sale').val();*/
	if ($('#sale_or')!= undefined)
		sale_or=$('#sale_or').val();
	if ($('#sale_as')!= undefined)	
		sale_as=$('#sale_as').val();
	if ($('#sprod_top')!= undefined)	
		sprod_top=$('#sprod_top').val();
	if ($('#date_start')!=undefined)
		date_start=$('#date_start').val();
	if ($('#date_end')!=undefined)
		date_end=$('#date_end').val();
	if ($('#get_username')!=undefined)
		get_username=$('#get_username').val();
	if ($('#sale_select')!=undefined)
		sale_select=$('#sale_select').val();
			
  //window.open('/report/report_list_csv.php?sale_ref='+sale_ref+'&prod_name='+prod_name+'&search_sale='+search_sale+'&sale_or='+sale_or+'&sale_as='+sale_as+'&sprod_top='+sprod_top+'&date_start='+date_start+'&date_end='+date_end+'&get_username='+get_username+'&sale_select='+sale_select,'mywindow','')
	  window.open('report/report_list_csv.php?sale_ref='+sale_ref+'&prod_name='+prod_name+'&sale_or='+sale_or+'&sale_as='+sale_as+'&sprod_top='+sprod_top+'&date_start='+date_start+'&date_end='+date_end+'&get_username='+get_username+'&sale_select='+sale_select,'mywindow','')
}</script>
<SCRIPT>
	function confirmDelete(id, ask, url) //confirm order delete
	{
		temp = window.confirm(ask);
		if (temp) //delete
		{
			window.location=url+id;
		}
	}
	function open_window(link,w,h)
	{
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	}
</SCRIPT>
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