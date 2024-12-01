function initViewMonitor(){

	initCmb();

	var nTiempoIntervalo = N_TIEMPOACTUALIZACION * 1000;

	grafica();
	alertas();

	setInterval(function(){ grafica(); }, nTiempoIntervalo);
	setInterval(function(){ alertas(); }, 60000);
}

function initCmb(){
	$('#cmbCliente').customLoadStore({
		url				: BASE_PATH + '/misuerte/ajax/clientes/storeClientes.php',
		labelField		: 'sNombreComercial',
		idField			: 'nIdCliente',
		firstItemId		: '0',
		firstItemValue	: 'Seleccione'
	});
} // initCmb

function grafica() {
	var options = {
		chart: {
			renderTo	: 'div-grafica',
			type		: 'column',
		},
		plotOptions	: {
			column	: {
				dataLabels	: {
					align	: 'center',
					format	: '{y}',
					enabled	: true,
					style	: {
						fontWeight: 'bold'
					}
				},
				minPointLength: 2
			},
		},
		title	: {
			text	: 'Operaciones'
		},
		colors	: ["#5cd228", "#e63737"],
		xAxis	: {
			categories	: [],
			labels		: {
				rotation	: -90,
				align		: 'right',
				style		: {
					fontSize	: '10px',
					fontFamily	: 'Verdana, sans-serif'
				}
			}
		},
		yAxis	: {
			min		: 0,
			title	: {
				text	: 'Operaciones'
			}
		},
		legend	: {
			enabled	: false
		},
		tooltip	: {
			formatter	: function() {
				return '<b>Hora ' + this.x + '</b><br/>' +
					'Total de Operaciones: ' + Highcharts.numberFormat(this.y, 0);
			}
		},
		series	: [{
			name	: 'Operaciones',
			data	: [],
			dataLabels	: {
				enabled		: true,
				rotation	: -90,
				color		: '#FFFFFF',
				align		: 'right',
				x			: 4,
				y			: 10,
				style	: {
					fontSize	: '10px',
					fontFamily	: 'Verdana, sans-serif'
				}
			}
		}],
		exporting	: {
			enabled	: true
		},
		credits	: {
			enabled	: false
		}
	};

	var nIdCliente = $('#cmbCliente').val();

	$.ajax({
		url			: '/misuerte/ajax/monitor/monitorCliente.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdCliente : nIdCliente
		}
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}

		options.xAxis.categories	= resp.data.horas;
		options.series[0]			= { 'data' : resp.data.ventas}
		chart = new Highcharts.Chart(options);

		var info	= resp.data.array_horas;

		var suma	= 0;
		var tabla	= '<table id="tbl-resumen-hora" class="display table table-bordered table-striped"><thead><tr><th>Hora</th><th>Venta</th></tr></thead><tbody></tbody></table>';
		var horaM	= resp.data.hora;

		$('#tbl-resumen-hora').replaceWith(tabla).promise().done(function(elem){
			for(var i=0; i<24; i++){
				var hora = (i<10)? "0"+i : i;

				var style = (info[hora] > 0)? 'font-weight:bold;font-size:13px;' : '';

				if(horaM != 0){
					if(hora == horaM){
						style += 'background-color:#cc0000;color:#FFFFFF;';
					}
				}

				$('#tbl-resumen-hora tbody').append('<tr><td align="right" style="'+style+'">'+hora+'</td><td align="right" style="'+style+'">'+info[hora]+'</td></tr>');

				suma += info[hora];
			}
			$('#tbl-resumen-hora tbody').append('<tr><td align="right" colspan="2" style="font-size:13px;font-weight:bold;">'+suma+'</td></tr>');
		});

		armarTablaSemana(resp.data.semana);
	})
	.fail(function(){
		console.log("error");
	})
} // grafica

function armarTablaSemana(data){
	var nombres_dias = new Array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

	var tabla = '<table id="tbl-resumen-semana" class="display table table-bordered table-striped"><thead><tr></tr></thead><tbody><tr></tr></tbody></table>';
	$('#tbl-resumen-semana').replaceWith(tabla).promise().done(function(elem){
		for(var i=0; i<7;i++){
			var element = data[i];
			var nDia	= element.dia;
			var nCuenta	= element.cuenta;

			$('#tbl-resumen-semana thead tr').append('<th align="center">'+ nombres_dias[nDia] +'</th>');
			$('#tbl-resumen-semana tbody tr').append('<td align="center">'+ nCuenta +'</td>');
		}
	});
} // armarTablaSemana

function alertas(){
	var nIdCliente = $('#cmbCliente').val();

	$.ajax({
		url			: BASE_PATH + '/misuerte/ajax/monitor/monitorAlertas.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
			nIdCliente	: nIdCliente
		}
	})
	.done(function(resp){
		if(resp.bExito == false){
			jAlert(resp.sMensaje, 'Mensaje');
		}
	})
	.fail(function() {
		console.log("error");
	});
} // alertas