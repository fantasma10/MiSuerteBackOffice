

function corteDetalles(){

periodo = $('#periodo').val();

	if(periodo == -1){

		fecha1 = $('#fecha1').val();
		fecha2 = $('#fecha2').val();		
		validacion = validarFechas(fecha1,fecha2);

	}else{
		
	var res = periodo.split("-");
	 mes = res[0];
	 anio =+ res[1];

	mesFecha= mes-1;
	var date = new Date(anio,mesFecha);
	
	var fecha1 = anio+"-"+mes+"-01";
	
	var fecha2 = new Date(date.getFullYear(),date.getMonth()+1, 0);
	diaUltimo = fecha2.getDate();
	fecha2 = anio+"-"+mes+"-"+diaUltimo;

	validacion = validarFechas(fecha1,fecha2); 

	}






		if(validacion){
    	tipo = 1;
    	$("#metodosPago").empty();
		$.post(BASE_PATH+"/misuerte/ajax/cortes/corteDetalle.php",{
			fecha1 : fecha1,
			fecha2 : fecha2,
			tipo : tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);

			obj1 = obj[0];
			obj2 = obj[1];
			obj3 = obj[2];
				var total = 0;
				var totOperaciones = 0;


				if(obj1.data.length > 0){

				$('#metodosPago').append('<div class="form-group col-xs-12">'+
													
												'<div class="form-group col-xs-7" style="text-align:left">'+
											
												'</div>'+
												'<div class="form-group col-xs-4">'+
													'<label class="control-label" style="margin-left:15px;">Operaciones</label>'+
												'</div>'+
												'<div class="form-group col-xs-4">'+
													'<label class="control-label" style="margin-left: 60px">Monto</label>'+
												'</div>'+
											'</div>');
					
					for (i = 0; i < obj1.data.length; i++) { 
						
						var  operaciones =+ obj3['data'][i];
						var  monto  =+ obj2['data'][i];
						var  entryMode  = obj1['data'][i];

						 total =+ total+monto;
						 totOperaciones = totOperaciones +operaciones;


						$("#totalOperaciones").val("$ "+total.toLocaleString("en-US"));
						$("#totalOpsOperaciones").val(totOperaciones.toLocaleString("en-US"));
						$('#metodosPago').append('<div class="form-group col-xs-7" style="text-align:left">'+
											'<label class="control-label">'+entryMode+'</label>'+
										'</div>'+
										'<div class="form-group col-xs-4">'+
											'<input type="text" id="operaciones" class="form-control detalles" name="operaciones" value="'+operaciones+'" disabled>'+
										'</div>'+
										'<div class="form-group col-xs-4">'+
											'<input type="text" id="operaciones" class="form-control detalles" name="operaciones" value="$ '+monto.toLocaleString("en-US")+'" style="margin-left:30px;" disabled>'+
										'</div>');
					};

					corteJuegos(fecha1,fecha2);
					document.getElementById("contenedor2").style.display="block";
					document.getElementById("detalles").style.display="inline-block";	
					var chart;	
	var opts1 = {
		chart: {
			renderTo: 'grafica2',
			type	: 'column',
			margin	: [ 50, 50, 150, 80]
		},
		title: {
			text: 'Operaciones por Metodo de Pago'
		},
		colors: ["#5cd228", "#e63737"],
		lang: {
			noData: "No hay datos que mostrar"
		},
		xAxis: {
			categories	: [],
			title	: {
				text: 'Metodos de Pago'
			},
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
				return '<b> Metodo de Pago : '+ this.x +'</b><br/>'+
				'Total de operaciones:'+ Highcharts.numberFormat(this.y, 0);
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
	
			var json = eval(response);
			opts1.xAxis.categories = json[0]['data'];
			opts1.series[0] = json[2];
			if(json[0]['data'].length>0){
				chart = new Highcharts.Chart(opts1);
			}else{
				document.getElementById("contenedor").style.display="none";	
			}

				}else{
					document.getElementById("detalles").style.display="none";	
					jAlert("No se encontro informacion");
				}

					
		})	


		.fail(function(response){
				
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
	}else{
		alert("La fecha final es menor a la inicial")
	}

	}




function corteJuegos(fecha1,fecha2){
    	tipo = 2;
    	$("#juegos").empty();
    	$("#opDetalles tbody tr").remove();
		$.post(BASE_PATH+"/misuerte/ajax/cortes/corteDetalle.php",{
			fecha1 : fecha1,
			fecha2 : fecha2,
			tipo : 2
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
			obj1 = obj[0];// extraccion de objetos de json para llenado de tabla
			obj2 = obj[1];
			obj3 = obj[2];
					//console.log(obj);
				var total = 0;
				var id = "";
				var totalOperacionesJuegos = 0 ;


					$('#juegos').append('<div class="form-group col-xs-12">'+
													
												'<div class="form-group col-xs-5" style="text-align:left">'+
											
												'</div>'+
												'<div class="form-group col-xs-4">'+
													'<label class="control-label" style="margin-left:60px;">Operaciones</label>'+
												'</div>'+
												'<div class="form-group col-xs-4">'+
													'<label class="control-label" style="margin-left: 96px">Monto</label>'+
												'</div>'+
											'</div>');
					for (i = 0; i < obj1.data.length; i++) { 

						
						
						var  nombre = obj1['data'][i];
						var  monto  =+ obj2['data'][i];
						var  operaciones  =+ obj3['data'][i];
						
						 totalOperacionesJuegos = totalOperacionesJuegos + operaciones;
						 total =+ total+monto;


						 document.getElementById("corteDetalles").style.display="inline-block";


						$("#totalJuegos").val("$ "+total.toLocaleString("en-US"));
						$("#totalOpsJuegos").val(totalOperacionesJuegos.toLocaleString("en-US"));
						$('#juegos').append('<div class="form-group col-xs-5" style="text-align:left">'+
											'<label class="control-label">'+nombre+'</label>'+											
										'</div>'+
										'<div class="form-group col-xs-4">'+
											'<input type="text" id="operaciones" class="form-control" style="margin-left:50px;" name="operaciones" value="'+operaciones+'" disabled>'+
										'</div>'+
										'<div class="form-group col-xs-4">'+
											'<input type="text" id="operaciones" class="form-control" style="margin-left:75px;" name="operaciones" value="$ '+monto.toLocaleString("en-US")+'" disabled>'+
										'</div>');
						

					}

					$('#opDetalles tbody').append('<tr><td class="thFecha">'+fecha1+'</td><td class="thFecha">'+fecha2+'</td><td class="thFecha">'+totalOperacionesJuegos+'</td><td class="thMonto">$ '+total.toLocaleString("en-US")+'</td></tr>');



	document.getElementById("contenedor").style.display="block"; //desplegado de area donde se encontrar la grafica
	
	var chart;	
	var opts1 = {
		chart: {
			renderTo: 'grafica1',
			type	: 'column',
			margin	: [ 50, 50, 150, 80]
		},
		title: {
			text: 'Operaciones por Juego'
		},
		colors: ["#5cd228", "#e63737"],
		lang: {
			noData: "No hay datos que mostrar"
		},
		xAxis: {
			categories	: [],
			title	: {
				text: 'Juegos'
			},
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
				return '<b> Juego : '+ this.x +'</b><br/>'+
				'Total de operaciones:'+ Highcharts.numberFormat(this.y, 0);
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
	
			var json = eval(response);
			opts1.xAxis.categories = json[0]['data'];
			opts1.series[0] = json[2];
			if(json[0]['data'].length>0){
				chart = new Highcharts.Chart(opts1);
			}else{
				document.getElementById("contenedor").style.display="none";	
			}

			

		})		
		.fail(function(response){
				
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})

	}




$(document).on('click', '#modal',function (e) {

	id = Number($(this).data("id"));

	alert("EL id del proveedor es el numero: " + id);

});
