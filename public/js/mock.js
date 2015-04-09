/*********************************************
This script should only be used for UI/UX
testing.
*********************************************/

function buildChart(x) {
	$('#graph'+x).highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		credits: {
      		enabled: false
  		},
		title: {
			text: 'Browser market shares at a specific website, 2014'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: true
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: [
				['Firefox',   45.0],
				['IE',       26.8],
				{
					name: 'Chrome',
					y: 12.8,
					sliced: true,
					selected: true
				},
				['Safari',    8.5],
				['Opera',     6.2],
				['Others',   0.7]
			]
		}]
	});
}

$(document).ready(function() {
	buildChart(1);
	buildChart(2);
	buildChart(3);
	buildChart(4);
});
