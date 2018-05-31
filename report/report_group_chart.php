	<link rel="stylesheet" href="js/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxchart.js"></script>
    
    <script type="text/javascript">
		var source =
		{
		    datatype: "json",
		    datafields: [
		        { name: 'group' },
		        { name: 'totalSale' }
		    ],
		    url: 'report/report_group_chart_logic.php?chartDS=&date_start=<?=$date_start ?>&date_end=<?=$date_end ?>'
		};
	
		var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true });

		// prepare jqxChart settings
		var settings = {
		    title: "Total Sale During <?=$date_start ?> to <?=$date_end ?>",
		    //description: "(source: wikipedia.org)",
		    source: dataAdapter,
		    colorScheme: 'scheme01',
		    seriesGroups:
		        [
		            {
		                type: 'pie',
		                showLabels: true,
		                series:
		                    [
		                        {
		                            dataField: 'totalSale',
		                            displayText: 'group',
		                            labelRadius: 100,
		                            initialAngle: 15,
		                            radius: 130,
		                            formatSettings: { prefix: String.fromCharCode(165), decimalPlaces: 0, thousandsSeparator: ',' }
		                        }
		                    ]
		            }
		        ]
		};

		$(function() {
			// setup the chart
			$('#jqxChart').jqxChart(settings);
		});
	</script>
	
	<div id='jqxChart' style="width: 600px; height: 400px;"></div>