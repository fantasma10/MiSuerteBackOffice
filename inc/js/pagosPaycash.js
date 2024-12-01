$(document).ready(function() {
	var host ="";
	var user ="";
	var pass ="";
	var localFolder ="";
	var remoteFolder ="";
	var corte =  "";
	var fechaCorte = "";
	var proveedor = "";
	var estatus1 = "";
	var clase ="";
	var cortePaycash = "";
	var montoCorte = "";
	var conteoDetalles = 0;

	var pagina = $("#pagina").val()

if(pagina == 1){
	var corte = $("#corte").val()
		getMovimientos(corte);
	}
	getCortes();
	getBancos();

	var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
	"oLanguage": {
		"sZeroRecords": "No se encontraron registros",
		"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sSearch": "Buscar:"  ,
		"sInfoFiltered": " - filtrado de _MAX_ registros",
		"oPaginate": {
			"sNext": "Siguiente",
			"sPrevious": " Anterior"
		}
	},
	"bSort": false, 
	};
    var table = "";
    var detalleCorte = $("detalleOperaciones").DataTable(settings);
    var table2 = $('#tblGridBox2').DataTable(settings);
    var movimientosBanco = $("#movimientosBanco").DataTable(settings);

//Extraccion del corte
    function getCortes(){
    	tipo = 1;
		$.post(BASE_PATH +"/inc/ajax/pagosPayCash.php",{
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);

					jQuery.each(obj, function(index,value) {
					var estatus = "";
					estatus =+ obj[index]['estatus'];
					switch(estatus){
						case 0 :
							color = '#00b300';
						break;

						case 1 :
							color = '#5bc0de';
						break;

						case 2:
							color = '#f89406'; 
						break;

					}
					
					monto =+ obj[index]['monto'];
						$('#tblGridBox tbody').append('<tr><td style="display:none">'+obj[index]['corte']+'</td><td class="thFecha">'+obj[index]['fecha']+'</td>'+
							'<td class="thFecha">'+obj[index]['operaciones']+'</td>'+
							'<td class="thMonto">$ '+monto.toLocaleString("en-US")+
							'</td><td class="td1"><span class="badge" style="background-color:'+color+'">&nbsp</span></td>'+
							'<td style="display:none">'+estatus+'</td>'+
							'<td style="display:none">'+obj[index]['detalle']+'</td>+'+
							'<td style="display:none">'+obj[index]['movimiento']+'</td></tr>');
					});
					table = $("#tblGridBox").DataTable(settings);		
		});
	}

//Movimientos no conicliados
	function getMovimientos(corte){
    	tipo = 5;
		$.post(BASE_PATH +"/inc/ajax/pagosPayCash.php",{
			corte : corte,
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);
					var juego = "";
					jQuery.each(obj, function(index,value) {
						montoM =+ obj[index]['monto'];
						$('#noConciliadas tbody').append('<tr><td class="thFecha">'+obj[index]['folio']+'</td><td class="thMonto">$ '+montoM.toLocaleString("en-US")+'</td><td class="thFecha">'+obj[index]['referencia']+'</td><td class="thFecha">'+obj[index]['fecha']+'</td><td class="thFecha">'+obj[index]['hora']+'</td></tr>');
					});
					table = $("#noConciliadas").DataTable(settings);		
		});
	}


     //Se traen los detalles del corte y se muestran
     function getCorteInfo(corte,monto,operaciones){
  						
		document.getElementById("conciliacion").style.display="inline-block";
		document.getElementById("liberaPago").style.display="inline-block";
		document.getElementById("divDetalle").style.display="none";
		document.getElementById("divCorte").style.display="none";
		$("#operaciones").val(operaciones);
		$("#totalPago").val(monto.toLocaleString("es-MX"));
	}


	//Se traen los datos de conexion hacia el ftp
	function getCorteDetalle(fecha){
		if(conteoDetalles > 0){
			detalleCorte.fnClearTable();
			detalleCorte.fnDestroy();
		}

    	tipo = 4;
		$.post(BASE_PATH +"/inc/ajax/pagosPayCash.php",{
			fecha : fecha,
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					jQuery.each(obj, function(index,value) {
						montoC =+ obj[index]['monto'];
						montoInicial =+ obj[index]['inicial'];
						montoFinal =+ obj[index]['final'];
						$('#detalleOperaciones tbody').append('<tr><td class="thFecha">'+obj[index]['folio']+'</td><td class="thFecha">'+obj[index]['movimiento']+'</td>'+
							'<td class="thFecha">'+obj[index]['cuenta']+'</td><td class="thFecha">'+obj[index]['cadena']+'</td>'+
							'<td class="thFecha">'+obj[index]['subcadena']+'</td><td class="thFecha">$ '+montoC.toLocaleString("en-US")+'</td>'+
							'<td class="thFecha">$ '+montoInicial.toLocaleString("en-US")+'</td><td class="thFecha">$ '+montoFinal.toLocaleString("en-US")+'</td></tr>');
					});
					detalleCorte = $("#detalleOperaciones").DataTable(settings);
					document.getElementById("detalleOperacion").style.display="inline-block";
					conteoDetalles = conteoDetalles +1;
		});
	}

	function liberarPago(corteId,fecha,detalleLiberacion,pago){

		var lack = "";
		var error = "";

		if(detalleLiberacion == undefined || detalleLiberacion.trim() == '' || detalleLiberacion <= 0){
			lack +='Detalle\n';
		}
		if(lack != "" || error != ""){
			var black = (lack != "")? "El siguiente campo es obligatorio : " : "";
			$("#generaOrden").button('reset');
			jAlert(black + '\n' + lack+'\n' );
			event.preventDefault();
		}else{
    		tipo = 6;
			$.post(BASE_PATH+"/inc/ajax/pagosPayCash.php",{
				corte : corteId,
				fecha : fecha,
				detalle : detalleLiberacion,
				pago : pago,
				tipo: tipo
			},
			function(response){		
				var obj = jQuery.parseJSON(response);
					if(obj['showMessage'] == 1){
						jAlert(obj["msg"],'Mensaje');
					}else{
						jAlert(obj["msg"],'Mensaje');
						setTimeout("location.reload()", 4000);
					}
			});
		}
	}


	function getMovimientosBanco(paramFechaInicial,paramFechaFinal,idBanco,numCuenta){
	movimientosBanco.fnClearTable(); //limpieza de tabla 
	movimientosBanco.fnDestroy();
	$.post(BASE_PATH+"/inc/ajax/pagosPayCash.php",{
		inicial : paramFechaInicial,
		final: paramFechaFinal,
		id : idBanco,
		cuenta : numCuenta, 
		tipo : 8

	},
	function(response){		
		var obj = jQuery.parseJSON(response);
		jQuery.each(obj, function(index,value) {
			importe =+ obj[index]['importe'];
			$('#movimientosBanco tbody').append('<tr><td class="thFecha">'+obj[index]['id']+'</td><td class="thFecha">'+obj[index]['fecha']+'</td>'+
				'<td class="thFecha">'+obj[index]['referencia']+'</td><td class="thMonto">'+importe.toLocaleString("en-US")+'</td>'+
				'<td id="checks"><input id="checkBanco" data-id="'+obj[index]['id']+'" data-monto="'+obj[index]['importe']+'"  type="checkbox"></td></tr>');
		});
		var movimientosBanco = $("#movimientosBanco").DataTable(settings);		
	})
	.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	})
}

function getBancos(){
$.post(BASE_PATH+"/inc/ajax/pagosPayCash.php",{
		tipo:9
	},
		function(response){		
			var obj = jQuery.parseJSON(response);
			if(obj != null){
				jQuery.each(obj, function(index,value) {
					$('#banco').append('<option data-id="'+obj[index]['bancoId']+'" data-cuenta="'+obj[index]['cuenta']+'" >'+obj[index]['nombre']+' '+obj[index]['cuenta']+'</option>');
				});	
			}
		}
	)
}

function conciliarMovimiento(movimientoId,corte){
		$.post(BASE_PATH+"/inc/ajax/pagosPayCash.php",{
		corte : corte,
		movimiento : movimientoId, 
		tipo : 3

	},
	function(response){		
		jAlert("Actualizacion exitosa");
		setTimeout("location.reload()", 2000);
	})
	.fail(function(response){
	alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	})

	}



//Detecta corte clickeado y trae informacion de detalle del corte
    $('#tblGridBox').on('click', 'tr', function(e) {
    	movimientosBanco.fnClearTable(); //limpieza de tabla 
    	$("#cuenta").val("");
    	$("icon").removeClass(clase);
    	$('#corteEstatus').empty();
    	$('#detalleCorte').empty();
		$('#corteEstatus').empty();

		$("#operacionesConciliacion").val("");
		$("#operacionesOk").val("");
		$("#operacionesBad").val("");
		$("#totalPayCash").val("");

		
		$("#detallesConciliacion").attr("disabled" ,true);
		$("#liberaPago").attr("disabled" ,true);


		$("tr").removeClass("active");
		$(this).toggleClass("active");
    	var data = table.fnGetData(this);
	   	if(data == null){
	   		$("#operaciones").val("");
			$("#totalPago").val("");
			document.getElementById("corteDetalles").style.display="none";
			document.getElementById("detalleOperacion").style.display="none";
			document.getElementById("conciliacionManual").style.display="none";	
	   	}else{

	   		corte = data[0];
	   		monto = data[3];
	   		monto = toFloat(monto);
	   		operaciones = data[2];
	   		estatus = data[5]
	   		fechaCorte = data[1];
	   		detalle = data[6];
	   		numeroMovimiento = data[7];
	   		getCorteDetalle(data[1]);
	   		getCorteInfo(corte,monto,operaciones);
	   		
	   		if(estatus == 1 || estatus == 0){
	   			
	   			if(estatus == 0){
	   				document.getElementById("conciliacion").style.display="none";
					document.getElementById("divDetalle").style.display="block";
					document.getElementById("liberaPago").style.display="none";
					$('#detalleCorte').val(numeroMovimiento);
	   			}

	   			panel = "#corteDetalles";
	   			document.getElementById("corteDetalles").style.display="inline-block";
	   			document.getElementById("conciliacionManual").style.display="none";
	   		}else{
	   			if(estatus == 2){
	   				panel = "#conciliacionManual";
	   				document.getElementById("corteDetalles").style.display="none";
	   				document.getElementById("conciliacionManual").style.display="inline-block";
	   			}
	   		}

	   		$('html,body').animate({
    			scrollTop: $(panel).offset().top
			}, 2000);
	   	}
	});

    //Carga la informacion del archivo desde el ftp y trae el detalle de la conciliacion
	$("#ftp").click(function () {
		var $this = $(this);
		$this.button('loading');
		montoCorte = toFloat($("#totalPago").val());
		jAlert('La busqueda puede tardar dependiendo la cantidad de archivos');
			$.post(BASE_PATH +"/inc/ajax/pagosPayCash.php",{
				tipo:2,
				monto : montoCorte,
				corte : corte,
				fecha : fechaCorte
			},
			function(response){
				$this.button('reset');
				var obj = jQuery.parseJSON(response);
				if(obj['error'] == 1){
					jAlert('No se encontraron los archivos para la conciliacion');
				}else{
					if(obj['conciliacion'] == 0){
						$.alerts._hide();
						jAlert("Conciliado Automaticamente");
						$("#operacionesConciliacion").val(obj['operaciones']);
						$("#totalPayCash").val("$ "+obj['monto']);
						$("#operacionesOk").val(obj['operaciones']);
						$("#operacionesBad").val(0);
						setTimeout("location.reload()", 3000);
					}else{

						if(obj['noconciliados'] > 0){
							$("#detallesConciliacion").removeAttr("disabled");	
							$("#liberaPago").removeAttr("disabled");
						}

						$("#operacionesOk").val(obj['conciliados']);
							$("#operacionesBad").val(obj['noConciliados']);
						$("#operacionesConciliacion").val(obj['operaciones']);
						$("#totalPayCash").val("$ "+obj['monto']);
						$.alerts._hide();
						jAlert("Numero de operaciones del archivo :"+obj['operaciones'],'Mensaje');
					}
					$("#detallesConciliacion").removeAttr("disabled");	
							$("#liberaPago").removeAttr("disabled");
				}
			})
			.fail(function(response){
					$this.button('reset');
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
			})

	});

	
	//Se abren los detalles de las operaciones no conciliadas
	$(document).on('click', '#detallesConciliacion',function (e) {
	  var form = $('<form action="'+BASE_PATH+'/_Contabilidad/Pagos/PayCash/noConciliadas.php" method="post" target="blank";>'+
                   '<input type="hidden" name="corte" value="'+corte+'"/>'+
                   '<input type="hidden" name="fecha" value="'+fechaCorte+'"/>'+
                   '</form>');
             $('body').append(form);
             $(form).submit();
    });



	//Se extraen los montos de los cortes para decidir con que monto se liberara el pago del corte
    $(document).on('click', '#liberaPago',function (e) {
    	$("#montoCorte").empty();
    	$("#montoPaycash").empty();

    	PaycashCorte = toFloat($("#totalPayCash").val());
    	var corteMonto = toFloat($("#totalPago").val());
    	corteMonto =+ corteMonto;
    	$("#corteMonto").val(corteMonto);
    	$("#cortePaycash").val(PaycashCorte);
    	$("#pagoTotal").val(corteMonto);

    	$("#montoCorte").append('Monto Corte $ '+corteMonto);
    	$("#montoPaycash").append('Monto PayCash $ '+ PaycashCorte);

    });


    //Se selecciona la opcion de liberar pago con el monto del corte 
    $("#corteMonto").click(function () {	 
		$( "#cortePaycash" ).prop( "checked", false );	
		$("#pagoTotal").val($("#corteMonto").val());
	});

    //Se selecciona la opcion de liberar el pago con el monto del los archivos de pronosticos
	$("#cortePaycash").click(function () {	 
		$( "#corteMonto" ).prop( "checked", false );
		$("#pagoTotal").val($("#cortePaycash").val());	
	});

	//Se libera el pago y se marca con estatus de autorizado para posteriormente se cree la orden de pago
	$(document).on('click', '#generaOrden',function (e) {
    	var $this = $(this);
		$this.button('loading');
	  	corteId = corte;
	  	fecha = fechaCorte;
	  	detalleLiberacion = $("#txtDetalle").val();
	  	var pago = $("#pagoTotal").val();
	  	liberarPago(corteId,fecha,detalleLiberacion,pago);
    });


   

	$("#buscar").click(function () {
	paramFechaInicial = $("#txtFechaIni").val();
	paramFechaFinal = $("#txtFechaFin").val();
	$("#montoSeleccionado").val("");
	$("#saldoCuenta").val("");
	//numCuenta = $("#cuenta").val();
	
	banco = $("#banco option:selected").val();
	if(banco !=0 ){
		var idBanco =  $("#banco option:selected").data("id");
		var numCuenta =$("#banco option:selected").data("cuenta");
		//$("#cuenta").val(numCuenta);
		getMovimientosBanco(paramFechaInicial,paramFechaFinal,idBanco,numCuenta)
	}else{
		jAlert("Seleccione una cuenta de la lista");
	}	
});



$(document).on('click', '#checkBanco',function () {

	var montoMovimiento =+ ($(this).data("monto"));
	var movimientoId =+ ($(this).data("id"));
	$("#numMovimiento").val(movimientoId);
	var parent = $(this).parent().attr('id');
	$('#'+parent+' input[type=checkbox]').removeAttr('checked');
	$(this).prop('checked', true);

	if(montoMovimiento == monto){
		$("#conciliar").removeAttr("disabled");
		jAlert("Los montos coinciden es posible conciliar");
	}else{
		$("#conciliar").attr("disabled" ,true);
		jAlert("Los montos son diferentes no procede conciliacion");
	}

});

	$(document).on('click', '#conciliar',function () {
		$("#movimiento").empty();
		movimientoId = $("#numMovimiento").val();
		$("#movimiento").append("Se va a conciliar el corte con el movimiento : "+movimientoId);

	});

	$(document).on('click', '#generaConciliacion',function () {
		movimientoId = $("#numMovimiento").val();
		conciliarMovimiento(movimientoId,corte);		
	});


});
