// Inicio funciones para Monitor/Personalizado
function BuscarParamsMonitor(i){
	var fechai  = txtValue('txtFechaIni');
	if(fechai != '')
	{
		if(validaFechaRegex("txtFechaIni")){
			var fechaf  = txtValue('txtFechaFin');
			if(fechaf != '')
			{
				if(validaFechaRegex("txtFechaFin")){
					if(fechai <= fechaf){
						if(fechai <= fechaf){
							var cad     = txtValue('ddlCad');
							var subcad  = txtValue('ddlSub');
							var corr    = txtValue('ddlCorresponsal');
							var prov    = txtValue('ddlProveedor');
							if(Existe('ddlProducto'))
								var prod    = txtValue('ddlProducto');
							else
								var prod    = -2
							var fam     = txtValue('ddlFam');
							if(Existe('ddlProducto'))
								var subfam  = txtValue('ddlSubFam');
							else
								var subfam  = -2
							
							var emisor  = txtValue('ddlEmisor');
							var tipo    = 1;
							
							if(Check('Proveedor')){
								tipo    = 2;
							}
							if(Check('Emisor')){
								tipo    = 3;
							}
							var parametros = "cad="+cad+"&subcad="+subcad+"&corr="+corr+"&prov="+prov+"&prod="+prod+"&fam="+fam+"&subfam="+subfam+"&emisor="+emisor+"&tipoBus="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
							
							return parametros;
						}else{
							alert("La fecha inicial debe ser menor a la fecha final")
						}
					}else{
						alert("Favor de seleccionar fechas distintas")
					}
				}else{
					alert("El formato de la fecha final es incorrecto")
				}
			}else{
				alert("Favor de Selecionar una Fecha Final");
			}
			
			
		}else{
			alert("El formato de la fecha inicial es incorrecto")
		}
	}else{
		alert("Favor de Selecionar una Fecha Inicial");
	}
}

function showGraph(){
	var params = BuscarParamsMonitor();
	var tipo    = 1;	
	if(Check('Proveedor')){
		tipo    = 2;
	}
	if(Check('Emisor')){
		tipo    = 3;
	}
	var chartOpts = {
		chart: {
			renderTo: 'grafica',
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
			text: ''// 'Operaciones por '+por   /* Titulo de la tabla*/
		},
		colors: ["#5cd228", "#e63737"],
		xAxis: {
			categories:  [],
			labels: {
				overflow: "justify",
				step: 1,
				rotation: -90,
				align: 'right',
				formatter: function(){
					var text = this.value;
					var formatted = text.length > 20 ? text.substring(0, 20) + '...' : text;
					return '<div class="js-ellipse" style="width:150px; overflow:hidden; word-wrap: break-word;" title="' + text + '">' + formatted + '</div>';
				},
				style: {
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Operaciones'   /*el label (button)  debajo de las barras se puede desabilitar con false abajo en legend*/
			}
		},
		legend: {
			enabled: false /* para mostrar el boton de yAxix ->   text ....   el que esta arriba*/
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.x +'</b><br/>'+
					'Total de Operaciones: '+ Highcharts.numberFormat(this.y, 0);
			}
		},
		series: [{
			name: 'Operaciones',
			data: [],  /*arreglo de valores*/
			dataLabels: {
				enabled: true, /*para mostrar el total por barra*/
				rotation: -90,
				color: '#FFFFFF', /*color de la letra*/
				align: 'right', /*alineacion del texto*/
				x: 4,           /*posicionamiento de texto*/
				y: 10,
				style: {       /*estilo de tamaÃ±o de letra y fuente*/
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}],
		exporting: {  /*esto es para k no se pueda imprimir o expotar*/
			enabled: true
		},
		credits: {      /* esto es para ocultar los creditos*/
			enabled: false
		}
	}

	var myArray = params.split('&');

	var paramsObj = {}
	for(i=0; i < myArray.length; i++){
		var item = myArray[i];
		var param = item.split("=");
		paramsObj[param[0]] = param[1];
	}

	Emergente();
	$.post("../../../../inc/Ajax/_Operaciones/Monitor/MonitorPersonalizado.php", paramsObj,
		function(json){
			var json = eval(json);
			chartOpts.xAxis.categories = json[0]['data'];
			chartOpts.series[0] = json[1];
			chart = new Highcharts.Chart(chartOpts);
			
			var titulo = "";
			switch (tipo) {
				case 1:
					titulo = "D&Iacute;A";
				break;
				case 2:
					titulo = "PRODUCTO";
				break;
				case 3:
					titulo = "EMISOR";
				break;
			}
			
			var str = "<table class='tablesorter2' border='0' cellpadding='0' cellspacing='1'><thead><th>" + titulo + "</th><th>N.-OP</th></thead>";
			
			for(var i = 0; i < json[1]["data"].length; i++){
				var hora = json[0]['data'][i];
				var op = json[1]['data'][i];
				str += "<tr>";
				str += "<td class = 'Cuerpo' style='padding:3px;'>"+ hora +"</td>";
				str += "<td class = 'Cuerpo' style='padding:3px;'>"+ op +"</td>";
				str += "</tr>";
			}
			str += "<tr>";
			str += "<td class='Cuerpo' style='font-weight:bold;padding:3px;'>TOTAL</td>";
			str += "<td class='Cuerpo' style='padding:3px;'>";
			str += json[1]['total'];
			str += "</td>";
			str += "</tr>";
			str += "</table>";
			$("#tabla").empty();
			$("#tabla").html(str);
			$("#T").css("display", "block");
			OcultarEmergente();
			$("#divRES").css("display", "block");
			$("#graphContainer").css("display", "block");
	}, "json");
}

function CheckBoxAction(a){
	if(a){
		document.getElementById('tabla').style.display='block';
	}else{
		document.getElementById('tabla').style.display='none';
	}
}
// Fin funciones para Monitor/Personalizado