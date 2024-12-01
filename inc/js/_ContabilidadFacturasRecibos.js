/*
**	Facturas y Recibos de Proveedores Internos
*/

function initComponentsFacturasRecibosGeneral(){

	var checkin1 = $('#txtFechaIni').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			var fecha	= ev.date;
			var date	= (fecha.getDate() < 10)? '0'+fecha.getDate() : fecha.getDate();
			var month	= parseInt(fecha.getMonth()) + 1;
			month		= ( month < 10)? '0'+month : month;
			var year	= fecha.getFullYear();

			var fechaInicio = year + '-' + month + '-' + date;
			var fechaFin	= $('#txtFechaFin').val();

			checkin1.hide();

			if(fechaFin != ''){
				if(!validarFechas(fechaInicio, fechaFin)){
					alert("La Fecha de Inicio no puede ser Mayor a la Fecha Final");
					$('#txtFechaIni').val('');
				}
			}
		}
	).data('datepicker');

	var checkin2 = $('#txtFechaFin').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			var fecha	= ev.date;
			var date	= (fecha.getDate() < 10)? '0'+fecha.getDate() : fecha.getDate();
			var month	= parseInt(fecha.getMonth()) + 1;
			month		= ( month < 10)? '0'+month : month;
			var year	= fecha.getFullYear();

			var fechaFin	= year + '-' + month + '-' + date;
			var fechaInicio	= $('#txtFechaIni').val();

			checkin2.hide();

			if(fechaInicio != ''){
				if(!validarFechas(fechaInicio, fechaFin)){
					alert("La Fecha Final no puede ser Menor a la Fecha de Inicio");
					$('#txtFechaFin').val('');
				}
			}
		}
	).data('datepicker');

	var checkin3 = $('#txtFechaFactura').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin3.hide();
		}
	).data('datepicker');

	/*$('#ddlProveedor').on('click', function(){
		console.log(event.target, event.target.value);
		gIdProveedor = $(event.target).val();
	});	*/

	$("#txtSubtotal, #txtIVA, #txtTotal").alphanum({
		allow				: "$.,-",
		allowOtherCharSets	: false
	});

	$("#txtNumFactura").alphanum({
		allowOtherCharSets: false
	});

	$("#txtDetalle").alphanum({
		allow				: 'ñáéíóúÁÉÍÓÚ',
		allowOtherCharSets	: false
	});

	// LLenar combo de Tipos de Documento
	cargarStore('../../inc/Ajax/stores/storeTipoDocumento.php', 'txtTipoDcto', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'});
	// Llenar combo de Proveedores
	cargarStore('../../inc/Ajax/stores/storeProveedores.php', 'ddlProveedor', {}, {text : 'nombreProveedor', value : 'idProveedor'});
	// Llenar combo de Tipo de Moneda
	cargarStore('../../inc/Ajax/stores/storeTipoMoneda.php', 'txtMoneda', {}, {text : 'descripcionMoneda', value : 'codigoMoneda'}, {}, 'monedaloaded');
	$('#txtMoneda').on('monedaloaded', function(){
		$('#txtMoneda').val("MXN");
		$('#txtTipoCambio').val(1);
	});

	$('#txtTipoDcto').val(-1);
	validaTipoDcto();
}

function initValidarNumeroFactura(){
	$('#txtNumFactura').on('change', validarinfo);
	$('body').bind('validarNumeroDeFactura', validarNumfactura);
}

function initComponentsFacturasRecibos(){
	$('body').unbind();
	initComponentsFacturasRecibosGeneral();
	initValidarNumeroFactura();
}

function initComponentsFacturasRecibosEditar(){
	$('body').unbind();
	initComponentsFacturasRecibosGeneral();
	
	var clics = 0;

	$(':input').on('click', function(){
		clics++;
		if(clics == 1){
			initValidarNumeroFactura();
		}
	});
}

function validarNumfactura(){

	var idProveedor = $('#ddlProveedor').val();
	idProveedor = (idProveedor <= -1)? 0 : idProveedor;

	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/validarinfoProveedor.php',
		{
			idProveedor	: idProveedor,
			RFC			: $('#txtRFC').val(),
			campo		: 'noFactura',
			valor		: $('#txtNumFactura').val()
		},
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}
			if(response.success != true){
				document.getElementById('txtNumFactura').focus();
				document.getElementById('txtNumFactura').value = '';
			}
		},
		"json"
	);
}

/*
**	Hace un request para validar la informacion del Proveedor, por el momento solo es razon social , rfc y numero de factura
*/
function validarinfo(){
	var target = event.currentTarget;

	var name = target.name;
	var value = target.value;

	var idProveedor = $('#ddlProveedor').val();
	idProveedor = (idProveedor <= -1)? 0 : idProveedor;
	
	console.log("gIdProveedor: " + gIdProveedor);
	console.log("ddlProveedor: " + $('#ddlProveedor').val());
	
	if((gIdProveedor != $('#ddlProveedor').val()) && $('#ddlProveedor').val() != undefined){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/validarinfoProveedor.php',
			{
				idProveedor	: idProveedor,
				RFC			: $('#txtRFC').val(),
				campo		: name,
				valor		: value
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				if(response.success != true){
					if(document.getElementById(target.id)){
						document.getElementById(target.id).focus();
						target.value = '';
					}
				}
			},
			"json"
		);
	}
}

function validarFechas(fechaInicio, fechaFin){
	if(fechaInicio <= fechaFin){
		return true;
	}
	else{
		return false;
	}
}


function actualizaDatos() {
	/* Funcion que actualiza los datos desde una factura con extensión XML */
	$('#ddlProveedor').val(idProveedor).prop('disabled', true).css('color','gray');
	$('#txtRFC').val(cfdiEmisorRFC).prop('readonly', true).css('color','gray');
	$('#txtNumCta').val(numCuenta).prop('readonly', true).css('color','gray');
	$('#txtFechaFactura').val(cfdiComprobanteFecha).prop('disabled', true).css('color','gray');
	$('#txtFechaIni').val('').prop('readonly', false).css('color','');
	$('#txtFechaFin').val('').prop('readonly', false).css('color','');
	$('#txtNumFactura').val(noFactura).prop('readonly', true).css('color','gray');
	$('#txtSubtotal').val('$' + formatNumber(cfdiComprobanteSubTotal, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtIVA').val('$' + formatNumber(iva, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtTotal').val('$' + formatNumber(cfdiComprobanteTotal, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtDetalle').val('').prop('readonly', false).css('color','');
	$('#txtFileToUploadTmp').val(fileToUploadTmp).prop('readonly', true).css('color','gray');
	$('#txtRazonSocial').val(cfdiEmisorNombre).prop('readonly', true).css('color','gray');
	$('#txtCalle').val(cfdiEmisorDomicilioFiscalCalle).prop('readonly', true).css('color','gray');
	$('#txtNoExterior').val(cfdiEmisorDomicilioFiscalNoExterior).prop('readonly', true).css('color','gray');
	$('#txtNoInterior').val(cfdiEmisorDomicilioFiscalNoInterior).prop('readonly', true).css('color','gray');
	$('#txtColonia').val(cfdiEmisorDomicilioFiscalColonia).prop('readonly', true).css('color','gray');
	$('#txtMunicipio').val(cfdiEmisorDomicilioFiscalMunicipio).prop('readonly', true).css('color','gray');
	$('#txtEstado').val(cfdiEmisorDomicilioFiscalEstado).prop('readonly', true).css('color','gray');
	$('#txtCodigoPostal').val(cfdiEmisorDomicilioFiscalCodigoPostal).prop('readonly', true).css('color','gray');
	$('#txtPais').val(cfdiEmisorDomicilioFiscalPais).prop('readonly', true).css('color','gray');
	$('#txtSerie').val(cfdiComprobanteSerie).prop('readonly', true).css('color','gray');
	$('#txtFolio').val(cfdiComprobanteFolio).prop('readonly', true).css('color','gray');
	$('#txtMoneda').val(cfdiComprobanteMoneda).prop('readonly', true).css('color','gray');
	$('#txtTipoCambio').val(cfdiComprobanteTipoCambio).prop('readonly', true).css('color','gray');

	if($('#txtMoneda').val() == 'MXN' && ($('#txtTipoCambio').val() == '' || $('#txtTipoCambio').val() == undefined)){
		$('#txtTipoCambio').val('$1.00');
	}

	if($('#txtMoneda').val() == '' || $('#txtMoneda').val() == undefined || $('#txtMoneda').val() == 'MXN'){
		$('#txtMoneda').val('MXN');
		$('#txtTipoCambio').val('$1.00');
	}
	else{
		if($('#txtMoneda').val() != 'MXN' && ($('#txtTipoCambio').val() == '' || $('#txtTipoCambio').val() == undefined)){
			$('#txtTipoCambio').val(cfdiComprobanteTipoCambio).prop('readonly', false);	
		}
	}
}

function limpiaDatos(isReadonly) {
	var bgColor;
	if(!isReadonly) {
		isReadonly = false;
		bgColor = "#FFFFFF";
	} else {
		bgColor = "#EEEEEE";
	}
	$('#ddlProveedor').prop('disabled', isReadonly).css('color','').css('background',bgColor);   
	$('#txtRFC').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtNumCta').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtFechaFactura').prop('disabled', isReadonly).css('color','').css('background',bgColor);
	$('#txtFechaIni').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtFechaFin').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtNumFactura').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtSubtotal').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtIVA').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtTotal').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtDetalle').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtRazonSocial').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtFileToUploadTmp').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtCalle').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtNoExterior').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtNoInterior').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtColonia').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtMunicipio').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtEstado').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtCodigoPostal').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtPais').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtSerie').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtFolio').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtMoneda').prop('disabled', isReadonly).css('color','').css('background',bgColor);
	$('#txtTipoCambio').prop('readonly', isReadonly).css('color','').css('background',bgColor);

	/*$('#txtMoneda').on('monedaloaded', function(){*/
		$('#txtMoneda').val("MXN");
		$('#txtTipoCambio').val("$1.00");
	/*});*/
}

function ajaxFileUpload()
{
		var archivoExtension = $('#fileToUpload').val().split('.').pop().toLowerCase();
		if(archivoExtension != "xml") {
			alert("Solo esta permitido archivos con extensión .XML");
			$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) ); 
			limpiaDatos(true);
		}
		else {

			$("#formAlta").submit(function(e){
				if(window.FormData !== undefined){
					var items = $('#formAlta :disabled');
					items.prop('disabled', false);
					var formData = new FormData(this);
					$(items).prop('disabled', true);

					$.ajax({
						url			: BASE_PATH + '/inc/Ajax/_Contabilidad/CargaFacturaXML.php?idTipoProveedor='+txtValue('txtIdTipoProveedor'),
						type		: 'POST',
						data		: formData,
						mimeType	: "multipart/form-data",
						contentType	: false,
						cache		: false,
						processData	: false,

						success		: function(response, textStatus, jqXHR){
							console.log(response);
							var data = eval("(" + response + ")");
							console.log(data);
							console.log(data, data.error);
							if(typeof(data.error) != 'undefined'){
								if(data.error != '')
									alert(data.error);
								else {
									var RESserv = data.msg.split("|");

									noFactura = RESserv[16];
									var regex = new RegExp("^[a-z0-9]+$","i");
									if(!regex.test(noFactura)){
										alert("El N\u00FAmero de Factura es Inv\u00E1lido");
										event.preventDefault();
										return false;
									}

									fileToUploadTmp = RESserv[2];
									cfdiEmisorNombre = RESserv[3];
									cfdiEmisorRFC = RESserv[4];
									cfdiEmisorDomicilioFiscalCalle = RESserv[5];
									cfdiEmisorDomicilioFiscalNoExterior = RESserv[6];
									cfdiEmisorDomicilioFiscalNoInterior = RESserv[7];
									cfdiEmisorDomicilioFiscalColonia = RESserv[8];
									cfdiEmisorDomicilioFiscalMunicipio = RESserv[9];
									cfdiEmisorDomicilioFiscalEstado = RESserv[10];
									cfdiEmisorDomicilioFiscalCodigoPostal = RESserv[11];
									cfdiEmisorDomicilioFiscalPais = RESserv[12];
									if(RESserv[13])
									cfdiComprobanteFecha = RESserv[13].substring(0,10);
									cfdiComprobanteSerie = RESserv[14];
									cfdiComprobanteFolio = RESserv[15];
									noFactura = RESserv[16];
									cfdiComprobanteMoneda = RESserv[17];


									cfdiComprobanteTipoCambio = RESserv[18];
									cfdiComprobanteSubTotal = RESserv[19];
									iva = RESserv[20];
									cfdiComprobanteTotal = RESserv[21];
									idProveedor = RESserv[22];
									numCuenta = RESserv[23];
									if(RESserv[0] == 0) {
											alert(RESserv[1]);
											cambioAlta();
									}
									else if(RESserv[0] == 1) {
										// Actualización de Campos //
										actualizaDatos();
									}
									else if(RESserv[0] == 2) { 
										alert("La factura #" + noFactura + " de " + cfdiEmisorNombre
												+ " ya existe en la Base de Datos, " 
												+ "por lo tanto no es posible darla de alta.\n");      
									}
									else{
										//limpiaDatos(true);
										//cambioAlta();
									}
									/*
										Validar si trae el tipo de moneda, si es diferente de MXN pedir el tipo de Cambio
									*/
									if(cfdiComprobanteMoneda.trim() != '' && cfdiComprobanteMoneda != 'MXN' && (cfdiComprobanteTipoCambio.trim() == '' || cfdiComprobanteTipoCambio == 0)){
										$("#txtTipoCambio").removeAttr('disabled');
										$("#txtTipoCambio").removeAttr('readonly');
										$("#txtTipoCambio").removeAttr('style');
									}
								}
							}

						},
						error		: function(jqXHR, textStatus, errorThrown){
							console.log("asdfjakdjfaksdjfakdsjflakdsjf");
						}
					});
					e.preventDefault();
					$(this).unbind();
				}
				else{
					var iframeId = 'unique' + (new Date().getTime());
					var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');

					iframe.hide();
					formObj.attr('target',iframeId);
					iframe.appendTo('body');

					iframe.load(function(e){
						var doc		= getDoc(iframe[0]);
						var docRoot = doc.body ? doc.body : doc.documentElement;
						var data	= docRoot.innerHTML;
						$("#multi-msg").html('<pre><code>'+data+'</code></pre>');
					});
				}
			});
			$("#formAlta").submit();
			return false;
		}
}

function validaTipoDcto(i) {

	/* i  - 0: nuevo documento
	      - 1: editar documento existente */

	if($('#txtTipoDcto').val() == -1) {
		/* Si el tipo de documento esta en Seleccione */
		// Ocultar todo//     
		$('#formAlta').get(0).reset();
		$('#trIdProveedor').hide();
		$('#trAltaDocumento').hide();
		$('#trFileToUpload').hide();
		$('#trRFC').hide();
		$('#trNoCta').hide();
		$('#trFechaFactura').hide();
		$('#trFechaInicio').hide();
		$('#trFechaFin').hide();
		$('#trNoFactura').hide();
		$('#trSubtotal').hide();
		$('#trIVA').hide();
		$('#trTotal').hide();
		$('#trDetalle').hide();
		$('#btnNuevaFactura').hide();
		$('#trMoneda').hide();
		$('#trTipoCambio').hide();

		$('#trNombreProveedor').hide();
		$('#trRazonSocial').hide();
		$('#trCLABE').hide();
		$('#trTelefono').hide();
		$('#trCorreo').hide();
		
		limpiaDatos(true);
	} else if($('#txtTipoDcto').val() == 1) {
		/* Si el tipo de documento esta en Factura */        
		// Mostrar datos de factura //
		$('#trIdProveedor').show();
		$('#trAltaDocumento').show();
		$('#trFileToUpload').show();
		$('#trRFC').show();
		$('#trNoCta').show();
		$('#trFechaFactura').show();
		$('#trFechaInicio').show();
		$('#trFechaFin').show();
		$('#trNoFactura').show();
		$('#trSubtotal').show();
		$('#trIVA').show();    
		$('#trTotal').show();    
		$('#trDetalle').show();  
		// Textos de Factura//       
		$('#tdFechaFactura').html("Fecha Factura");
		$('#tdNoFactura').html("No Factura");
		$('#btnNuevaFactura').val("Nueva Factura");
		$('#btnNuevaFactura').show();
		
		$('#trNombreProveedor').hide();
		$('#trNombreProveedor :input').val('');
		$('#trRazonSocial').hide();
		$('#trRazonSocial :input').val('');
		$('#trCLABE').hide();
		$('#trCLABE :input').val('');
		$('#trTelefono :input').val('');
		$('#trTelefono').hide();
		$('#trCorreo').hide();
		$('#trCorreo :input').val('');
		$('#trMoneda').show();
		$('#trTipoCambio').show();
		limpiaDatos(true);
		cambioAlta();
	} else if($('#txtTipoDcto').val() == 2){
		// Ocultar datos de Factura //
		$('#trAltaDocumento').hide();
		$('#trFileToUpload').hide();
		$('#trFileToUpload input').val('');
		$('#trSubtotal').hide();
		$('#trSubtotal :input').val('0');

		$('#trIVA').hide();
		$('#trIVA :input').val('0');
		// Mostrar datos de Nota //
		$('#trIdProveedor').show();
		$('#trRFC').show();
		$('#trNoCta').show();
		$('#trFechaFactura').show();
		$('#trFechaInicio').show();
		$('#trFechaFin').show();
		$('#trNoFactura').show();
		$('#trTotal').show();        
		$('#trDetalle').show();      
		
		$('#trNombreProveedor').hide();        
		$('#trRazonSocial').hide();
		$('#trCLABE').hide();        
		$('#trTelefono').hide();             
		$('#trCorreo').hide();         
		// Textos de Nota//       
		$('#tdFechaFactura').html("Fecha Recibo");
		$('#tdNoFactura').html("No Recibo");
		$('#btnNuevaFactura').val("Nuevo Recibo");
		$('#btnNuevaFactura').show();
		$('#trMoneda').show();
		$('#trTipoCambio').show();
		limpiaDatos(false);
		$('#txtFechaFactura').datepicker();     
	}
	// Validar si es Proveedor Nuevo
	//muestraAltaProveedor();
}

function validaTipoDctoAModificar(){
	
	/* i  - 0: nuevo documento
	      - 1: editar documento existente */

	if($('#txtTipoDcto').val() == -1) {
		/* Si el tipo de documento esta en Seleccione */
		// Ocultar todo//     
		$('#formAlta').get(0).reset();
		$('#trIdProveedor').hide();
		$('#trAltaDocumento').hide();
		$('#trFileToUpload').hide();
		$('#trRFC').hide();
		$('#trNoCta').hide();
		$('#trFechaFactura').hide();
		$('#trFechaInicio').hide();
		$('#trFechaFin').hide();
		$('#trNoFactura').hide();
		$('#trSubtotal').hide();
		$('#trIVA').hide();
		$('#trTotal').hide();
		$('#trDetalle').hide();
		$('#btnNuevaFactura').hide();
		$('#trMoneda').hide();
		$('#trTipoCambio').hide();

		$('#trNombreProveedor').hide();
		$('#trRazonSocial').hide();
		$('#trCLABE').hide();
		$('#trTelefono').hide();
		$('#trCorreo').hide();
		
		limpiaDatos(true);
	} else if($('#txtTipoDcto').val() == 1) {
		/* Si el tipo de documento esta en Factura */        
		// Mostrar datos de factura //
		$('#trIdProveedor').show();
		$('#trAltaDocumento').show();
		$('#trFileToUpload').show();
		$('#trRFC').show();
		$('#trNoCta').show();
		$('#trFechaFactura').show();
		$('#trFechaInicio').show();
		$('#trFechaFin').show();
		$('#trNoFactura').show();
		$('#trSubtotal').show();
		$('#trIVA').show();    
		$('#trTotal').show();    
		$('#trDetalle').show();  
		// Textos de Factura//       
		$('#tdFechaFactura').html("Fecha Factura");
		$('#tdNoFactura').html("No Factura");
		$('#btnNuevaFactura').val("Guardar Cambios");
		$('#btnNuevaFactura').show();
		
		$('#trNombreProveedor').hide();
		$('#trNombreProveedor :input').val('');
		$('#trRazonSocial').hide();
		$('#trRazonSocial :input').val('');
		$('#trCLABE').hide();
		$('#trCLABE :input').val('');
		$('#trTelefono :input').val('');
		$('#trTelefono').hide();
		$('#trCorreo').hide();
		$('#trCorreo :input').val('');
		$('#trMoneda').show();
		$('#trTipoCambio').show();
		limpiaDatos(true);
		cambioAlta();
	} else if($('#txtTipoDcto').val() == 2){
		// Ocultar datos de Factura //
		$('#trAltaDocumento').hide();
		$('#trFileToUpload').hide();
		$('#trFileToUpload input').val('');
		$('#trSubtotal').hide();
		$('#trSubtotal :input').val('0');

		$('#trIVA').hide();
		$('#trIVA :input').val('0');
		// Mostrar datos de Nota //
		$('#trIdProveedor').show();
		$('#trRFC').show();
		$('#trNoCta').show();
		$('#trFechaFactura').show();
		$('#trFechaInicio').show();
		$('#trFechaFin').show();
		$('#trNoFactura').show();
		$('#trTotal').show();        
		$('#trDetalle').show();      
		
		$('#trNombreProveedor').hide();        
		$('#trRazonSocial').hide();
		$('#trCLABE').hide();        
		$('#trTelefono').hide();             
		$('#trCorreo').hide();         
		// Textos de Nota//       
		$('#tdFechaFactura').html("Fecha Recibo");
		$('#tdNoFactura').html("No Recibo");
		$('#btnNuevaFactura').val("Guardar Cambios");
		$('#btnNuevaFactura').show();
		$('#trMoneda').show();
		$('#trTipoCambio').show();
		limpiaDatos(false);
		$('#txtFechaFactura').datepicker();     
	}

}

function cambioAlta() {
	if($('#txtAlta').val() == 1) {
		/* Si es por carga de XML */
		limpiaDatos(true);
		$('#trFileToUpload').show();
		$('#txtFechaIni').prop('readonly', false).css('color','').css('background','#FFFFFF');
		$('#txtFechaFin').prop('readonly', false).css('color','').css('background','#FFFFFF');
		$('#txtDetalle').prop('readonly', false).css('color','').css('background','#FFFFFF');
		//$('#txtFechaFactura').datepicker("destroy");
	} else {
		/* Si es por carga Manual */
		limpiaDatos(false);
		$('#trFileToUpload').hide();
		//$('#txtFechaFactura').datepicker();

	}
	
}