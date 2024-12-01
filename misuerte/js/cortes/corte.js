$(document).ready(function() {

	var corte =  "";
	var fechaCorte = "";
	var cliente = "";
	var estatus = "";
	var clase ="";
	var proveedor ="";
	var cortePronosticos = "";
	var totalPago = "";

	var settings = {"iDisplayLength": 5, // configuracion del lenguaje del plugin de la tabla
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
    table = $("#tblGridBox").DataTable(settings);
    table2 = $("#tblGridBox2").DataTable(settings);
    

    $('#buscarCorte').click(function(){
		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha1").val();

		getCortes(fecha1,fecha2);
	});

//Extraccion del corte
    function getCortes(fecha1,fecha2){
    	
    	document.getElementById("crea_corte").style.display="none";
    	document.getElementById("panelCorte").style.display="none";
    	document.getElementById("conciliacion").style.display="none";

    	table.fnClearTable();
		table.fnDestroy();
		table2.fnClearTable();
		table2.fnDestroy();
    	tipo = 1;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);

					
					validador = obj[0]['proveedor'];

					

					if(validador != null){
						
						jQuery.each(obj, function(index,value) {

							$("#corte").val(obj[index]['corte']);
							$("#montoCorte").val(obj[index]['monto']);
							$("#montoArchivo").val(obj[index]['archivo']);

							estatus =+ obj[index]['estatus'];

							if(estatus == 1){

								document.getElementById("carga").style.display="inline-block";
								

							}else{

								if(estatus == 2){

									alert("Corte conciliado con pronosticos");	
									document.getElementById("carga").style.display="inline-block";
								}
								else{
									
									alert("Este corte ya ha sido conciliado");
									document.getElementById("carga").style.display="none";
								
								}								
							}

							$('#tblGridBox tbody').append('<tr><td class="thFecha">'+obj[index]['proveedor']+'</td><td class="thFecha">'+obj[index]['operaciones']+'</td>'+
														   '<td class="thMonto">$ '+obj[index]['monto']+'</td><td class="thMonto">$ '+obj[index]['archivo']+' </td>'+
														   '<td class="thMonto">$ '+obj[index]['premios']+'</td><td class="thMonto">$ '+obj[index]['comision']+' </td></tr>');
						});
					
						getCorteInfo(fecha1,fecha2);
					}else{
						document.getElementById("corteDetalles").style.display="none";
					}

					table = $("#tblGridBox").DataTable(settings);	
					table2 = $("#tblGridBox2").DataTable(settings);   		
		});
	}




     //Se traen los detalles del corte y se muestran
     function getCorteInfo(fecha1,fecha2){

    	tipo = 2;
    	$("#metodosPago").empty();
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			fecha1 : fecha1,
			fecha2 : fecha2,
			tipo: tipo
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
			document.getElementById("corteDetalles").style.display="inline-block";
					
					jQuery.each(obj, function(index,value) {

						var monto =+ obj[index]['monto'];

						if(monto < 0){
							monto =+ (monto*-1);
						}

						if(estatus == 1 || estatus == 2){
							var input = '<input data-monto="'+monto+'" type="checkbox" id="check" name="'+obj[index]['metodo']+'" class="form-control">'+'';
						}else{
							var input = ''+'';
						}

						$('#metodosPago').append('<div class="form-group col-xs-12"><div class="form-group col-xs-4" style="text-align:left">'+
											'<label class="control-label">'+obj[index]['nombre']+'</label>'+
										'</div>'+
										'<div class="form-group col-xs-2">'+
											'<input type="text" id="operaciones" class="form-control detalles" name="operaciones" value="'+obj[index]['operaciones']+'" disabled>'+
										'</div>'+
										'<div class="form-group col-xs-2" style="margin-right:30px;">'+
											'<input type="text" id="montos" class="form-control detalles" name="montos" value="$ '+monto.toLocaleString("en-US")+'" style="margin-left:30px;" disabled>'+
										'</div>'+
										'<div class="form-group col-xs-1">'+input+
											//'<input data-monto="'+monto+'" type="checkbox"  id="check" name="'+obj[index]['metodo']+'">'+
											//'<input data-monto="'+monto+'" type="checkbox" id="check" name="'+obj[index]['metodo']+'" class="form-control">'+
										'</div></div>');
					});					
		});
	}


$(document).on('click', '#check',function () {
	
	var montoMovimiento =+ ($(this).data("monto"));
	$("#montoCheck").val(montoMovimiento);
	var parent = $(this).parent().attr('id');
	$('input[type=checkbox]').removeAttr('checked');
	$(this).prop('checked', true);

});




$(document).on('change', '#fileToUpload',function (e) {
 
	 var checks = 0;
	$('input[type=checkbox]:checked').each(function() {

		checks = 1;

	});

if(checks == 1){


	var archivoExtension = $('#fileToUpload').val().split('.').pop().toLowerCase();

		fecha1 = $("#fecha1").val();
		fecha2 = $("#fecha1").val();
		tipo = 8;

		var inputFile = document.getElementById("fileToUpload");
		var file = inputFile.files[0];
		var data = new FormData();
		data.append('fileToUpload',file);
		data.append('fecha1',fecha1);
		data.append('fecha2',fecha2);
		data.append('tipo',tipo)
		if(data !== undefined){
			$.ajax({
				url			: BASE_PATH + '/misuerte/ajax/pagosProveedor.php',
				type		: 'POST',
				data		: data,
				mimeType	:"	multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,
				dataType	: 'json',
				success		: function(response, textStatus, jqXHR){

					if(response.nCodigo == 1){
						alert(response.sMensaje+" "+response.monto);
					}

					valorCorte  =+ $("#montoCheck").val();
					valor =+ response.monto;
					$("#montoSr").val(valor);

					if(valorCorte == valor){

						document.getElementById("conciliacion").style.display="inline-block";
						
						alert("Los montos totales son iguales");

					}else{
						document.getElementById("conciliacion").style.display="inline-block";
						alert("Existe diferencia en los montos");
					}
					$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) );

				},
				error		: function(jqXHR, textStatus, errorThrown){
					console.log(jqXHR, textStatus, errorThrown);
				}
			});
			e.preventDefault();
			$(this).unbind();
		
		}else{

			$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) );
			alert("Ha Ocurrido un error intente mas tarde");

		}
	}else{
		$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) );
		alert("Seleccione una opcion para continuar");		
	}
});



 $(document).on('click', '#conciliacion',function (e) {

 	montoCorte 	  =+  $("#montoCorte").val();
 	montoArchivo  =+  $("#montoArchivo").val();
 	$("#pagoTotal").val(montoCorte);

 	$("#montoDiferencia").empty();
 	$("#txtDetalle").val("");

 	diferencia =+ montoCorte -montoArchivo;

 	$("#saldoDiferencia").val(diferencia);

 	$("#montoDiferencia").append("Diferencia de Cortes : $"+diferencia.toLocaleString("en-US"));

 	if(montoCorte != montoArchivo){
 		
 		alert("Existe una diferencia entre Pronosticos y nosotros.");
 		document.getElementById("diferencia").style.display="inline-block";
 		$('#confirmaPago').modal('show');
 	}else{

 		alert("El monto de nuestro corte es: "+montoCorte+" el monto del corte de pronosticos es: "+montoArchivo);
 		document.getElementById("diferencia").style.display="none";
 		$('#confirmaPago').modal('show');
 	}

 })


 	$("#corteMonto").click(function () {	 
		$( "#cortePronosticos" ).prop( "checked", false );	
		$("#pagoTotal").val($("#montoArchivo").val());
		$("#entidad").val(1);
	});


	$("#cortePronosticos").click(function () {	 
		$( "#corteMonto" ).prop( "checked", false );
		$("#pagoTotal").val($("#montoCorte").val());	
		$("#entidad").val(2);
	});


 $(document).on('click', '#liberaCorte',function (e) {
 		
 		var $this = $(this);
		$this.button('loading');
 		
 		corteId =  $("#corte").val();
 		diferencia =  $("#saldoDiferencia").val();
 		srPago  =  $("#montoSr").val();
 		detalleLiberacion = $("#txtDetalle").val();
 		pagoTotal = $("#pagoTotal").val();
 		entidad = $("#entidad").val();

 		tipo = 9;
 		
 		var lack = "";
		var error = "";

		if(detalleLiberacion == undefined || detalleLiberacion.trim() == '' || detalleLiberacion <= 0){
			lack +='Detalle\n';
		}
		if(lack != "" || error != ""){
			var black = (lack != "")? "El siguiente campo es obligatorio : " : "";
			$("#liberaCorte").button('reset');
			jAlert(black + '\n' + lack+'\n' );
			event.preventDefault();
		}else{

 	$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			corte : corteId,
			pago : srPago,
			comentario : detalleLiberacion,
			diferencia : diferencia,
			pagoTotal : pagoTotal,
			entidad :entidad
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
			$("#liberaCorte").button('reset');
			$('#confirmaPago').modal('hide'); 	
			
			document.getElementById("conciliacion").style.display="none";
			alert(obj.msg);

		});
	  }
    });




 $(document).on('click', '#buscarCreacion',function (e) {

 		fecha1 = $("#txtFechaIni").val();
		fecha2 = $("#fecha2").val();

		getCorteGeneral(fecha1,fecha2);

 });



function getCorteGeneral(fecha1,fecha2){
    	
    	table2.fnClearTable();
		table2.fnDestroy();
    	tipo = 1;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);

					
					validador = obj[0]['proveedor'];
					estatus = obj[0]['estatus'];

					if(estatus == 0){
						document.getElementById("crea_corte").style.display="inline-block";
					}else{
						alert("Este periodo contiene cortes no conciliados");
						document.getElementById("conciliacion").style.display="none";
					}

					if(validador != null){
						
						jQuery.each(obj, function(index,value) {

							$("#corte").val(obj[index]['corte']);
							$("#cliente").val(obj[index]['cliente']);

							

							$('#tblGridBox2 tbody').append('<tr><td class="thFecha">'+obj[index]['proveedor']+'</td><td class="thFecha">'+obj[index]['operaciones']+'</td>'+
														   '<td class="thMonto">$ '+obj[index]['monto']+'</td><td class="thMonto">$ '+obj[index]['archivo']+' </td>'+
														   '<td class="thMonto">$ '+obj[index]['premios']+'</td><td class="thMonto">$ '+obj[index]['comision']+' </td></tr>');
						});
					
						
					}else{
						document.getElementById("corteDetalles").style.display="none";
					}

					table2 = $("#tblGridBox2").DataTable(settings);	   		
		});
	}



});


 $(document).on('click', '#corte_crea',function (e) {

 	document.getElementById("corteDetalles").style.display="none";
	document.getElementById("panelCorte").style.display="inline-block";

 });



 $(document).on('click', '#crea_corte',function (e) {

 	fecha1  = $("#txtFechaIni").val();
	fecha2  = $("#fecha2").val();
	cliente = $("#cliente") .val();

 	crearCorte(fecha1,fecha2,cliente);
 });


function crearCorte(fecha1,fecha2,cliente){
    	
    	
    	tipo = 10;
		$.post(BASE_PATH+"/misuerte/ajax/pagosProveedor.php",{
			tipo: tipo,
			fecha1 : fecha1,
			fecha2 : fecha2,
			cliente :cliente
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
			alert(obj.msg);	

		});
	}