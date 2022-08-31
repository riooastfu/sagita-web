  var base_url = $("#base_url").val();
  $.get(base_url + '/admin/dashboardchart', function (result) {
  	Highcharts.chart('container', {
  		chart: {
  			type: 'line'
  		},
  		title: {
  			text: ''
  		},
  		subtitle: {
  			text: ''
  		},
  		xAxis: {
  			categories: result.bulan
  		},
  		yAxis: {
  			title: {
  				text: 'Income'
  			}
  		},
  		plotOptions: {
  			line: {
  				dataLabels: {
  					enabled: true
  				},
  				enableMouseTracking: false
  			}
  		},
  		series: [{
  			name: 'Total',
  			data: result.total
  		}]
  	})
  }, 'json');
