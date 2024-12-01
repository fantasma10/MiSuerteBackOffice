function initComponents() {
	var chart;
	var opts1 = {
	chart: {
		renderTo: 'grafica1',
		type	: 'column',
		margin	: [ 50, 50, 150, 80]
	},
	title: {
		text: 'Operaciones del día de Hoy por    [ HORA ]'
	},
	colors: ["#5cd228", "#e63737"],
	lang: {
		noData: "No hay datos que mostrar"
	},
	xAxis: {
		categories	: [],
		labels		: {
			rotation: -90,
			align	: 'right',
			style	: {
				fontSize: '10px',
				fontFamily: 'Verdana, sans-serif'
			}
		}
	},
	yAxis:{
		min		: 0,
		title	: {
			text: 'Operaciones'
		}
	},
	legend:{
		enabled: false
	},
	plotOptions : {
		column : {
			dataLabels : {
				align:'center',
				format : '{y}',
				enabled : true,
				style: {
					fontWeight:'bold'
				}
			},
			minPointLength : 2
		},

	},
	tooltip:{
		formatter: function() {
			return '<b> HORA : '+ this.x +'</b><br/>'+
			'Total de Operaciones: '+ Highcharts.numberFormat(this.y, 0);
		}
	},
	series: [{
		name		: 'Operaciones',
		data		: [],
		dataLabels	: {
			enabled	: true,
			rotation: -90,
			color	: '#FFFFFF',
			align	: 'right',
			x		: 4,
			y		: 10,
			style	: {
				fontSize	: '10px',
				fontFamily	: 'Verdana, sans-serif'
			}
		}
	}],
	exporting: {
		enabled: true
	},
	credits: {
		enabled: false
	}
	};
	$.getJSON(BASE_PATH + "/inc/Ajax/_Operaciones/Monitor/MonitorHora.php",
	function(json){
		var json = eval(json);
		opts1.xAxis.categories = json[0]['data'];
		opts1.series[0] = json[1];
		chart = new Highcharts.Chart(opts1);

		var str = "<table class='tablesorter2' border='0'  cellpadding='0' cellspacing='1'><thead><th>HORA</th><th>N.-OP</th></thead>";

		for(var i = 0; i < 23; i++){
			var dia = json[0]['data'][i];
			var op = json[1]['data'][i];
			str += "<tr>";
			str += "<td class = 'Cuerpo'>"+ dia +"</td>";
			str += "<td class = 'Cuerpo'>"+ op +"</td>";
			str += "</tr>";
		}
		str += "<tr>";
		str += "<td style='font-weight:bold;'>TOTAL</td>";
		str += "<td>";
		str += json[1]['total'];
		str += "</td>";
		str += "</tr>";
		str += "</table>";
		$("#tabla").empty();
		$("#tabla").html(str);
	});

	/*  esta es la dos*/
	var options = {
	chart: {
		renderTo: 'grafica2',
		type: 'column',
		margin: [ 50, 50, 150, 80]
	},
	plotOptions : {
		column : {
			dataLabels : {
				align:'center',
				format : '{y}',
				enabled : true,
				style: {
					fontWeight:'bold'
				}
			},
			minPointLength : 2
		},

	},
	title: {
		text: 'Operaciones de los Ultimos 7 días'
	},
	colors: ["#5cd228", "#e63737"],
	xAxis: {
		categories:  [],
		labels: {
			rotation: -90,
			align: 'right',
			style: {
				fontSize: '10px',
				fontFamily: 'Verdana, sans-serif'
			}
		}
	},
	yAxis: {
	min: 0,
	title: {
	text: 'Operaciones'
	}
	},
	legend: {
	enabled: false
	},
	tooltip: {
	formatter: function() {
	return '<b>'+ this.x +'</b><br/>'+
	'Total de Operaciones: '+ Highcharts.numberFormat(this.y, 0);
	}
	},
	series: [{
		name: 'Operaciones',
		data: [],
		dataLabels: {
			enabled	: true,
			rotation: -90,
			color	: '#FFFFFF',
			align	: 'right',
			x		: 4,
			y		: 10,
			style	: {
				fontSize	: '10px',
				fontFamily	: 'Verdana, sans-serif'
			}
		}
	}],
	exporting: {
		enabled: true
	},
	credits: {
		enabled: false
	}
	};

	$.getJSON(BASE_PATH + "/inc/Ajax/_Operaciones/Monitor/Monitor7Dias.php", function(json){
		var json = eval(json);
		console.log(json[0]['data']);
		console.log(json[1]);
		options.xAxis.categories = json[0]['data'];
		options.series[0] = json[1];
		chart = new Highcharts.Chart(options);

		var str = "<table class='tablesorter2' border='0'  cellpadding='0' cellspacing='1'><thead><th>DÍA</th><th>N.-OP</th></thead>";

		for(var i = 0; i < 7; i++){
			var dia = json[0]['data'][i];
			var op = json[1]['data'][i];
			str += "<tr>";
			str += "<td class = 'Cuerpo'>"+ dia +"</td>";
			str += "<td class = 'Cuerpo'>"+ op +"</td>";
			str += "</tr>";
		}
		str += "<tr>";
		str += "<td style='font-weight:bold;'>TOTAL</td>";
		str += "<td>";
		str += json[1]['total'];
		str += "</td>";
		str += "</tr>";
		str += "</table>";
		$("#tabla2").empty();
		$("#tabla2").html(str);
	});
}

function CheckBoxAction(a) {
	if(a){
		document.getElementById('tabla').style.display='block';
	}else{
		document.getElementById('tabla').style.display='none';
	}
}
function CheckBoxAction2(a) {
	if(a){
		document.getElementById('tabla2').style.display='block';
	}else{
		document.getElementById('tabla2').style.display='none';
	}
}