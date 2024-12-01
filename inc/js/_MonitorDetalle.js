// Inicio funciones para Monitor/Detalle
var paramFechaInicial = "";
var paramFechaFinal = "";
var paramIdCadena = "";

function setParams(){
	paramFechaInicial = $("#txtFechaIni").val();
	paramFechaFinal = $("#txtFechaFin").val();
	paramIdCadena = $("#ddlCad").val();
	showGraph();
}

function showGraph(){
	 $(function () {
		var chart;
		$(document).ready(function() {
			chartOpts = {
				chart: {
					renderTo: 'grafica',
					type: 'column',
					margin: [ 50, 100, 80, 70],
					options3d: {
						enabled: true,
						alpha: 0,
						beta: 0/*,
						alpha: 0,
						beta: 30,
						depth: 25,
						viewDistance: 0*/
					}
				},
				plotOptions : {
					column : {
						pointPadding: .1,
						borderWidth: 0,
						depth: 20,
						dataLabels : {
							align:'center',
							format : '{y}',
							enabled : true,
							color : '#000000',
							style: {
								fontWeight:'bold'
							}
						},
						minPointLength : 2
					}
				},
				title: {
					text: 'Operaciones'
				},
				colors: [ 'rgba(92, 210, 40, 1)', 'rgba(230, 55, 55, 1)' ],
				/*colors: ["#5cd228", "#e63737"],*/
				subtitle: {
					text: 'Exitosas y No Exitosas'
				},
				xAxis: {
					categories:  [],
					gridLineWidth: 1
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Operaciones'
					},
					gridLineWidth: 1
				},
				tooltip: {
					formatter: function() {
						return '<b> HORA : '+ this.x +'</b><br/>'+
							'Total de Operaciones: '+ Highcharts.numberFormat(this.y, 0);
					}
				},
				series: [{
				name: 'Exitosas',
				data: [],
				dataLabels: {
					enabled: true, /*para mostrar el total por barra*/
					rotation: -90,
					color: '#FFFFFF', /*color de la letra*/
					align: 'right', /*alineacion del texto*/
					x: 4,           /*posicionamiento de texto*/
					y: 10,
					style: {       /*estilo de tamaño de letra y fuente*/
						fontSize: '10px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
				}, {
					name: 'Errores',
					data: [],
					dataLabels: {
						enabled: true, /*para mostrar el total por barra*/
						rotation: -90,
						color: '#FFFFFF', /*color de la letra*/
						align: 'right', /*alineacion del texto*/
						x: 4,           /*posicionamiento de texto*/
						y: 10,
						style: {       /*estilo de tamaño de letra y fuente*/
							fontSize: '10px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}],
				credits: {      /* esto es para ocultar los creditos*/
					enabled: false
				}
			};
		});

		$.post("../../../../inc/Ajax/_Operaciones/Monitor/MonitorDetalle.php",{fechaInicial : paramFechaInicial, fechaFinal : paramFechaFinal, idCadena : paramIdCadena},
			function(json){
				var json = eval(json);
				chartOpts.xAxis.categories = json[0]['data'];
				chartOpts.series[0] = json[1];
				chartOpts.series[1] = json[2];
				chart = new Highcharts.Chart(chartOpts);

				var str = "<table class='tablesorter2' border='0'  cellpadding='0' cellspacing='1'><thead><th>HORA</th><th>N.-OP</th></thead>";
				
				for(var i = 0; i < 24; i++){
					var hora = json[0]['data'][i];
					var op = json[1]['data'][i];
					str += "<tr>";
					str += "<td class = 'Cuerpo' style = 'text-align: center;'>";
					str += hora;
					str += "</td>";
					str += "<td class = 'Cuerpo' style='text-align: center;'>";
					if(op > 0){
						str += "<a href='#Cuenta' style='color: #5cd228; font-weight:bold;' data-toggle='modal' onclick='EmergenteOpExitosas("+hora+");'>";
						str += op;
						str += "</a>";
					}else{
						str += op;
					}
					str += "</td>";
					str += "</tr>";
				}
				str += "<tr>";
				str += "<td class='Cuerpo' style='font-weight:bold;'>TOTAL</td>";
				if(json[1]['total'] > 0){
					str += "<td class='Cuerpo' style='color: #5cd228; font-weight: bold; text-align: center;'>";
				}else{
					str += "<td class='Cuerpo'>";
				}
				str += json[1]['total'];
				str += "</td>";
				str += "</tr>";
				str += "<tr>";
				str += "<td>&nbsp;</td>";
				str += "</tr>";
				str += "<tr>";
				str += "<td colspan=\"2\">";
				str += "<form id=\"excel\" method=\"post\" action=\"../../../inc/Ajax/_Operaciones/ExcelMonitorOperacionesTotal.php\" >";
				str += "<input type=\"hidden\" name=\"idCadena\" id=\"idCadenaExcel2\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"fechaInicial\" id=\"fechaInicialExcel2\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"fechaFinal\" id=\"fechaFinalExcel2\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"estatus\" id=\"estatusExcel2\" value=\"\" />";
				str += "<button class=\"btn btn-xs btn-info pull-left excel\" style=\"width:75px;\" onclick=\"exportarOPExitosas()\">";
				str += "<i class=\"fa fa-file-excel-o\"></i> Excel";
				str += "</button>";
				str += "</form>";
				str += "</td>";
				str += "</tr>";
				str += "</table>";
				$("#tabla").empty();
				$("#tabla").html(str);

				var str = "<table class='tablesorter2' border='0'  cellpadding='0' cellspacing='1'><thead><th>HORA</th><th>N.-OP</th></thead>";
				
				for(var i = 0; i < 24; i++){
					var hora = json[0]['data'][i];
					var op = json[2]['data'][i];
					str += "<tr>";
					str += "<td class = 'Cuerpo' style = 'text-align: center;'>";
					str += hora;
					str += "</td>";
					str += "<td class = 'Cuerpo' style = 'text-align: center;'>";
					if(op > 0){
						str += "<a href='#Cuenta' style='color: #e63737; font-weight:bold;' data-toggle='modal' onclick='EmergenteOpFallidas("+hora+");'>";
						str += op;
						str += "</a>";
					}else{
						str += op;
					}
					str += "</td>";
					str += "</tr>";
				}
				str += "<tr>";
				str += "<td class='Cuerpo' style='font-weight:bold;'>TOTAL</td>";
				if(json[2]['total'] > 0){
					str += "<td class='Cuerpo' style='color: #e63737; font-weight: bold; text-align: center;'>";
				}else{
					str += "<td class='Cuerpo'>";
				}
				str += json[2]['total'];
				str += "</td>";
				str += "</tr>";
				str += "<tr>";
				str += "<td>&nbsp;</td>";
				str += "</tr>";
				str += "<tr>";
				str += "<td colspan=\"2\">";
				str += "<form id=\"excel\" method=\"post\" action=\"../../../inc/Ajax/_Operaciones/ExcelMonitorOperacionesTotal.php\" >";
				str += "<input type=\"hidden\" name=\"idCadena\" id=\"idCadenaExcel3\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"fechaInicial\" id=\"fechaInicialExcel3\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"fechaFinal\" id=\"fechaFinalExcel3\" value=\"\" />";
				str += "<input type=\"hidden\" name=\"estatus\" id=\"estatusExcel3\" value=\"\" />";
				str += "<button class=\"btn btn-xs btn-info pull-left excel\" style=\"width:75px;\" onclick=\"exportarOPFallidas()\">";
				str += "<i class=\"fa fa-file-excel-o\"></i> Excel";
				str += "</button>";
				str += "</form>";
				str += "</td>";				
				str += "</tr>";
				str += "</table>";
				$("#tabla2").empty();
				$("#tabla2").html(str);
				OcultarEmergente();
		}, "json");
	});
}

function CheckBoxAction(a){
	if(a){
		document.getElementById('tabla').style.display='block';
	}else{
		document.getElementById('tabla').style.display='none';
	}
}

function CheckBoxAction2(a){
	if(a){
		document.getElementById('tabla2').style.display='block';
	}else{
		document.getElementById('tabla2').style.display='none';
	}
}

function CheckBoxAction3(a){
	if(a){
		showGraph();
		Start();
	}else{
		Stop();
	}
}

function EmergenteOpFallidas(hra){
	var cadena = txtValue("ddlCad");
	var fechaInicial = txtValue("txtFechaIni");
	var fechaFinal = txtValue("txtFechaFin");
	var parametros = "hra="+hra+"&cadena="+cadena+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal+"&estatus=1";
	$("#idCadenaExcel").val(cadena);
	$("#fechaInicialExcel").val(fechaInicial);
	$("#fechaFinalExcel").val(fechaFinal);
	$("#horaExcel").val(hra);
	$("#estatusExcel").val(1);
	MetodoAjaxDiv("../../../inc/Ajax/_Operaciones/BuscaOperaciones.php",parametros);
}

function EmergenteOpExitosas(hra){
	var cadena = txtValue("ddlCad");
	var fechaInicial = txtValue("txtFechaIni");
	var fechaFinal = txtValue("txtFechaFin");
	var parametros = "hra="+hra+"&cadena="+cadena+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal+"&estatus=0";
	$("#idCadenaExcel").val(cadena);
	$("#fechaInicialExcel").val(fechaInicial);
	$("#fechaFinalExcel").val(fechaFinal);
	$("#horaExcel").val(hra);
	$("#estatusExcel").val(0);
	MetodoAjaxDiv("../../../inc/Ajax/_Operaciones/BuscaOperaciones.php",parametros);
}

var intervalo = 10000;
var int=self.setInterval(function(){
	ActualizarMonitor();
},intervalo);

function ActualizarMonitor(){
	Emergente();
	showGraph();
}

function Stop(){
	int=window.clearInterval(int);
}

function Start(){
	int=self.setInterval(function(){
		ActualizarMonitor();
	},intervalo);
}

function exportarOPExitosas(){
	var cadena = txtValue("ddlCad");
	var fechaInicial = txtValue("txtFechaIni");
	var fechaFinal = txtValue("txtFechaFin");
	$("#idCadenaExcel2").val(cadena);
	$("#fechaInicialExcel2").val(fechaInicial);
	$("#fechaFinalExcel2").val(fechaFinal);
	$("#estatusExcel2").val(0);
}

function exportarOPFallidas(){
	var cadena = txtValue("ddlCad");
	var fechaInicial = txtValue("txtFechaIni");
	var fechaFinal = txtValue("txtFechaFin");
	$("#idCadenaExcel3").val(cadena);
	$("#fechaInicialExcel3").val(fechaInicial);
	$("#fechaFinalExcel3").val(fechaFinal);
	$("#estatusExcel3").val(1);	
}
// Fin funciones para Monitor/Detalle