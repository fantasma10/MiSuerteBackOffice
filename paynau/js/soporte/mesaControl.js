function initViewMesaControl(){
		var Layout = {
				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
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
									"bSort" :false
									};
				
				$("#data tbody").empty();
				var datos = $("#data").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				
				
				$.post(BASE_URL +"/paynau/ajax/soporte/getSolicitudNivel.php",
				{
					nIdProveedor : 0,
					itipo : 1
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					  jQuery.each(obj, function(index,value) {
					 
					 $('#data tbody').append('<tr>'+
							'<td >'+obj[index]['nIdProveedor']+'</td>'+
							'<td >'+obj[index]['sRFC']+'</td>'+
							'<td > '+obj[index]['sRazonSocial']+'</td>'+
							'<td >'+obj[index]['sNombre']+'</td>'+
							'<td >'+obj[index]['sCorreo']+'</td>'+
							'<td > '+obj[index]['sTelefono']+'</td>'+
							'<td > '+obj[index]['sCLABE']+'</td>'+
							'<td > <button id="verDetalle" data-proveedor='+obj[index]['nIdProveedor']+' data-nombreProveedor ="'+obj[index]['sNombre']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</tr>');
					  });
					  datos.DataTable(settings);
				})
				.fail(function(resp){
						alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				});
		},



		initBotones : function(){

			$(document).on('click','#verDetalle',function(e){
				
				proveedor = this.attributes['data-proveedor'].value;
				nombreProveedor = this.attributes['data-nombreProveedor'].value;
				 
				initSolicitudProveedor(proveedor);
			});

			$(document).on('click','#verDocumento',function(e){
				
				
			});

			$(document).on('click','#listaProveedores',function(e){
				Layout._llenarTabla();
			});
		}
	}

	
	Layout.initBotones();
	
	Layout._llenarTabla();

} // initViewComision


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
									"bSort" :false
									};

function initSolicitudProveedor(nIdProveedor){
var proveedor = null;
proveedor = {
		init : function(){
			// proveedor.initInputs();
			proveedor.initBotones();
			proveedor.cargaInformacion();
			
		},

		initInputs : function(){

			$('#txtSRFC, #txtSRFC').alphanum({
				allowSpace			: false,
				allowOtherCharSets	: false,
				maxLength			: 13
			});

			$('#txtSRFC, #txtSRFC').css('text-transform', 'uppercase');

			
			//$('#txtSTelefono1, #txtSTelefono, #txtSCelular, #txtSCelular1').unmask().mask('00 0000 0000');

			$('#txtSTelefono, #txtSCelular, #txtSTelefono1, #txtSCelular1').alphanum({
				allow				: '()-',
				disallow			: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
				allowNumeric		: true,
				allowLatin			: true,
				allowOtherCharSets	: false,
				maxLength			: 13
			});

			$('#txtSNombreComercial').alphanum({
				allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00FC\u00F1\u00D1\u00C1\u00C9\u00CD\u00D3\u00DA\u00DC',
				allowOtherCharSets	: false,
				maxLength			: 100
			});

			$('#txtSTarjeta').numeric({
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				allowLeadingSpaces	: false,
				maxDigits			: 16,
				maxDecimalPlaces	: 0
			});

			$('#txtSCLABE').numeric({
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				allowLeadingSpaces	: false,
				maxDigits			: 18,
				maxDecimalPlaces	: 0
			});

			$('#txtSCalle').alphanum({
				allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00FC\u00F1\u00D1\u00C1\u00C9\u00CD\u00D3\u00DA\u00DC.',
				allowOtherCharSets	: false,
				allowNumeric		: false,
				maxLength			: 30
			});

			$('#txtSNumeroExterior').numeric({
				allowPlus			: false,
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				maxDigits			: 10,
				maxDecimalPlaces	: 0
			});

			$('#txtSNumeroInterior').alphanum({
				allowOtherCharSets	: false,
				allowNumeric		: true,
				maxLength			: 10
			});

			$('#txtSCodigoPostal').numeric({
				allowPlus			: false,
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				maxDigits			: 5,
				maxDecimalPlaces	: 0
			});

			$('#txtSCodigoPostal').on('keyup', function(e){
				var sCodigoPostal = e.currentTarget.value;

				if(sCodigoPostal.length == 5){
					proveedor.cargaInformacionCP(sCodigoPostal);
				}
				else{
					$('#cmbColonia, #cmbEstado, #cmbCiudad').val(0);
				}
			});
		},

		initBotones : function(){
			$('#validadSolicitar').on('click', function(e){
				jConfirm('\u00BFSeguro que desea autorizar el cambio de nivel?', 'Confirmaci\u00F3n', function(e){
					if(e == true){
						$.ajax({
							url: BASE_URL +"/paynau/ajax/soporte/getSolicitudNivel.php",
							type: 'POST',
							dataType:  'json',
							data: { nIdProveedor : nIdProveedor,
									nNivel : $('#nivelSolicitado').val(),
									sMotivoRechazo : 'Cambio de nivel Aprovado',
									itipo : 2
								  },
						})
						.done(function(resp) {
							datos = resp.data;
							if (datos[0].nCodigo!=0) {

								jAlert("La solicitud no ha sido aprovada." + datos[0].sMensaje);
								
							}else{
								jAlert("Solicitud fue aprovada de forma exitosa",ejecutarClick())
								function ejecutarClick(){
									$('#listaProveedores').click();
								}
								
							}
						})
						.fail(function() {
							jAlert('Error al cargar los datos, recargue la pagina y vuelva a intentarlo');
						})
						.always(function() {
							hideSpinner();
						});
						
					}
				});
			});

			$('#rechazarSolicitar').on('click', function(e){
				$('#modalRespuesta').modal({backdrop: 'static', keyboard: false});
			});

			$('#btnEnviar').on('click', function(e){
				$('#rechazo').on('focus',function(){$('#rechazo').val('')});

				sMotivoRechazo = $('#rechazo').val();

				jConfirm('\u00BFSeguro que desea autorizar el cambio de nivel?', 'Confirmaci\u00F3n', function(e){
					if(e == true){
						$.ajax({
							url: BASE_URL +"/paynau/ajax/soporte/getSolicitudNivel.php",
							type: 'POST',
							dataType:  'json',
							data: { nIdProveedor : nIdProveedor,
									sMotivoRechazo : sMotivoRechazo,
									nNivel: $('#nivelActual').val(),
									itipo : 2
								  },
						})
						.done(function(resp) {
							datos = resp.data;
							if (datos[0].nCodigo!=0) {

								jAlert("La solicitud no ha sido rechazada." + datos[0].sMensaje);
								
							}else{
								jAlert("Solicitud fue rechazada de forma exitosa",ejecutarClick())
								function ejecutarClick(){
									$('#modalRespuesta').modal('hide');
									$('#listaProveedores').click();
								}
								
							}
						})
						.fail(function() {
							jAlert('Error al cargar los datos, recargue la pagina y vuelva a intentarlo');
						})
						.always(function() {
							hideSpinner();
						});
						
					}
				});

			});

			$('#datosProveedor').on('click', function(){
				if(nIdProveedor <= 0){
					jAlert('Selecciones un usuario para sus consultar las solicitudes');
				}else{
				}
			});
		},

		cargaInformacion : function(){
			showSpinner();
			var nivelActual;
			var nivelSolicitado;
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
									"bSort" :false
									};
				
				$("#dataDocumentos tbody").empty();
				var datos = $("#dataDocumentos").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				
				$.post(BASE_URL +"/paynau/ajax/soporte/getSolicitudNivel.php",
				{
					nIdProveedor : nIdProveedor,
					itipo : 1
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					console.log(obj.length);
					if (obj!=0) {
						var aux = 0;
						jQuery.each(obj, function(index,value) {
						 $('#dataDocumentos tbody').append('<tr>'+
								'<td >'+obj[index]['nIdSolicitud']+'</td>'+
								'<td >'+obj[index]['sRFC']+'</td>'+
								'<td > '+obj[index]['sRazonSocial']+'</td>'+
								'<td >'+obj[index]['nNivelActual']+'</td>'+
								'<td >'+obj[index]['nNivel']+'</td>'+
								'<td >'+obj[index]['dFechaInicial']+'</td>'+
								'<td >'+obj[index]['sDocumento']+'</td>'+
								'<td ><a href="'+obj[index]['sRutaDocumento']+'">Ver documento</a>'+
								'</tr>');
						 	nivelActual = obj[index]['nNivelActual'];
						 	nivelSolicitado = obj[index]['nNivel'];
						 	
						 	if (obj[index]['nNivel'] > aux) {
						 		aux = obj[index]['nNivel'];
						 	}
						  });
					   	datos.DataTable(settings);
					   	nivelSolicitado = aux;
						$('#datosProveedor').click();
						$('#nivelActual').val(nivelActual);
						$('#nivelSolicitado').val(nivelSolicitado);
						console.log(nivelActual);
						console.log(nivelSolicitado);
					}else{
						jAlert("No se encontraron registros para este usuario");
					}
					  
				})
				.fail(function(resp){
						alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				}).always(function(){
					hideSpinner();
				});
		},


		cargaInformacionCP : function(sCodigoPostal){
			
		}
	}
	proveedor.init();
}


