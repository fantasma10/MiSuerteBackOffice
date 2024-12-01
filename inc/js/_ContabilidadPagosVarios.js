
function initComponentsGeneral(){
	$(':input').bind('paste', function(){return false;});

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

	$('#txtRazonSocial, #txtRFC').on('change', validarinfo);

	$("#txtNumFactura").alphanum({
		allowOtherCharSets	: false
	});

	$("#txtDetalle, #txtNombreProveedor, #txtRazonSocial").alphanum({
		allow               : 'ñáéíóúÁÉÍÓÚ',
		allowOtherCharSets  : false
	});

	$("#txtRFC").alphanum({
		allowSpace			: false,
		maxLength			: 13,
		allowOtherCharSets  : false
	});

	$("#txtCLABE").alphanum({
		allowSpace			: false,
		allow				: '1234567890',
		disallow			: 'ñáéíóúÁÉÍÓÚÑabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
		allowOtherCharSets	: false
	});

	$("#txtCorreo").alphanum({
		allowSpace			: false,
		allow				: '_.@',
		disallow			: 'ñáéíóúÁÉÍÓÚÑ',
		allowOtherCharSets	: false
	});

	$("#txtSubtotal, #txtIVA, #txtTotal").alphanum({
		allowSpace			: false,
		allow				: '1234567890.$',
		disallow			: 'ñáéíóúÁÉÍÓÚabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
		allowOtherCharSets	: false
	});

	// LLenar combo de Tipos de Documento
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoDocumento.php', 'txtTipoDcto', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'});
	// Llenar combo de Proveedores
	cargarStoreProveedoresExternos();
	// Llenar combo de Tipo de Moneda
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoMoneda.php', 'txtMoneda', {}, {text : 'descripcionMoneda', value : 'codigoMoneda'});

	$('#txtTipoDcto').val(-1);
	validaTipoDcto();

	if(!ES_ESCRITURA){
		setReadOnly();
	}

	$("#txtCLABE").unbind("paste");
}

function initValidarNumeroFactura(){
	$('#txtNumFactura').on('change', validarinfo);
	$('body').bind('validarNumeroDeFactura', validarNumfactura);
}

function initComponentsVariosEditar(){
	$('body').unbind();
	initComponentsGeneral();
	
	var clics = 0;
	
	$(':input').on('click', function(){
		clics++;
		if(clics == 1){
			initValidarNumeroFactura();
		}
	});
}

function initComponentsVarios(){
	$('body').unbind();
	initComponentsGeneral();
	initValidarNumeroFactura();
}

function validarNumfactura(){

	var idProveedor = $('#ddlProveedor').val();
	idProveedor = (idProveedor <= -1)? 0 : idProveedor;

	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/validarinfoProveedor.php',
		{
			idProveedor	: idProveedor,
			RFC			: $('#txtRFC').val(),
			campo		: 'noFactura',
			valor		: $('#txtNumFactura').val(),
			idFactura	: $('#idFactura').val()
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
					document.getElementById(target.id).focus();
					target.value = '';
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

function setReadOnly(){
	$('#htmlContent :input').prop('disabled', true);
}

function cargarStoreProveedoresExternos(){
	var adicionales = [{value : '-3', label : '- Nuevo / Agregar Proveedor -'}]
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeAcreedores.php', 'ddlProveedor', {tipoProv : 1}, {text : 'nombreProveedor', value : 'idProveedor'}, adicionales, 'provextloaded');
}


function actualizaDatos() {
	/* Funcion que actualiza los datos desde una factura con extensión XML */
	$('#ddlProveedor').val(idProveedor).prop('disabled', true).css('color','');
	$('#txtRFC').val(cfdiEmisorRFC).prop('readonly', true).css('color','gray');
	$('#txtNumCta').val(numCuenta).prop('readonly', true).css('color','gray');
	$('#txtFechaFactura').val(cfdiComprobanteFecha).prop('readonly', true).css('color','gray');
	$('#txtFechaIni').val('').prop('readonly', false).css('color','');
	$('#txtFechaFin').val('').prop('readonly', false).css('color','');
	$('#txtNumFactura').val(noFactura).prop('readonly', true).css('color','gray');
	$('#txtSubtotal').val('$' + formatNumber(cfdiComprobanteSubTotal, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtIVA').val('$' + formatNumber(iva, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtTotal').val('$' + formatNumber(cfdiComprobanteTotal, 0, 2, true)).prop('readonly', true).css('color','gray');
	$('#txtDetalle').val('').prop('readonly', false).css('color','');
	$('#txtFileToUploadTmp').val(fileToUploadTmp).prop('readonly', true).css('color','gray');
	$('#txtNombreProveedor').val(cfdiEmisorNombre).prop('readonly', false).css('color','');
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

	if($('#txtMoneda').val() == '' || $('#txtMoneda').val() == undefined){
		$('#txtMoneda').val('MXN');
		$('#txtTipoCambio').val('$1.00');
	}
	else{
		if($('#txtMoneda').val() != 'MXN' && ($('#txtTipoCambio').val() == '' || $('#txtTipoCambio').val() == undefined)){
			$('#txtTipoCambio').val(cfdiComprobanteTipoCambio).prop('readonly', false);	
		}
	}
}
function limpiaDatos(isReadonly, exceptProveedor) {

	/* de todos les quite que les limpiara el valor .val('') */
	var bgColor;
	if(!isReadonly) {
		isReadonly = false;
		bgColor = "#FFFFFF";
	} else {
		bgColor = "#EEEEEE";
	}
	if(!exceptProveedor)
		$('#ddlProveedor').prop('disabled', isReadonly).css('color','').css('background',bgColor);   
	$('#txtNumCta').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtFechaFactura').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtFechaIni').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtFechaFin').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtNumFactura').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtSubtotal').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtIVA').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtTotal').prop('readonly', isReadonly).css('color','').css('background',bgColor);
	$('#txtDetalle').prop('readonly', isReadonly).css('color','').css('background',bgColor);
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

	$('#txtMoneda').val("MXN");
	$('#txtTipoCambio').val("$1.00");

	// Alta de Proveedor // 
	$('#txtNombreProveedor').prop('readonly', false).css('color','').css('background',"#FFFFFF");
	$('#txtRazonSocial').prop('readonly', false).css('color','').css('background',"#FFFFFF");
	$('#txtRFC').prop('readonly', true).css('color','').css('background',"#EEEEEE");
	$('#txtCLABE').prop('readonly', false).css('color','').css('background',"#FFFFFF");
	$('#txtTelefono').prop('readonly', false).css('color','').css('background',"#FFFFFF");
	$('#txtCorreo').prop('readonly', false).css('color','').css('background',"#FFFFFF");
	muestraAltaProveedor();    
}

function ajaxFileUpload()
{
		var archivoExtension = $('#fileToUpload').val().split('.').pop().toLowerCase();
		if(archivoExtension != "xml") {
			alert("Solo esta permitido archivos con extensi\u00F3n .XML");
			$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) ); 
			limpiaDatos(true);
		}
		else {

			$("#formAlta").submit(function(e){
				var formObj = $(this);
				var formURL = formObj.attr("action");

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
							var data = eval("(" + response + ")");

							if(typeof(data.error) != 'undefined') {
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

									cfdiComprobanteMoneda = RESserv[17];
									cfdiComprobanteTipoCambio = RESserv[18];
									cfdiComprobanteSubTotal = RESserv[19];
									iva = RESserv[20];
									cfdiComprobanteTotal = RESserv[21];
									idProveedor = RESserv[22];
									numCuenta = RESserv[23];
									if(RESserv[0] == 0) {
										if(confirm(RESserv[1] + ' \u00BFDeseas darlo de alta?')) {
											idProveedor = -3;
											actualizaDatos();
											muestraAltaProveedor();
										} else {
											cambioAlta();
										}
									}
									else if(RESserv[0] == 1) {
										// Actualización de Campos //
										actualizaDatos();
									}
									else if(RESserv[0] == 2) { 
										alert("La factura #" + noFactura + " de " + cfdiEmisorNombre
												+ " ya existe en la Base de Datos, " 
												+ "por lo tanto no es posible darla de alta.\n");
										limpiaDatos(true);
										cambioAlta();
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

			/*$("#loading")
			.ajaxStart(function(){
					$(this).show();
			})
			.ajaxComplete(function(){
					$(this).hide();
			});*/

			/*$.ajaxFileUpload
			(
				{
					url:'../../../inc/Ajax/_Contabilidad/CargaFacturaXML.php?idTipoProveedor='+txtValue('txtIdTipoProveedor'),
					secureuri:false,
					fileElementId:'fileToUpload',
					dataType: 'json',
					data:{name:'logan', id:'id'},
					success: function (data, status) {
						if(typeof(data.error) != 'undefined') {
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

								cfdiComprobanteMoneda = RESserv[17];
								cfdiComprobanteTipoCambio = RESserv[18];
								cfdiComprobanteSubTotal = RESserv[19];
								iva = RESserv[20];
								cfdiComprobanteTotal = RESserv[21];
								idProveedor = RESserv[22];
								numCuenta = RESserv[23];
								if(RESserv[0] == 0) {
									if(confirm(RESserv[1] + ' \u00BFDeseas darlo de alta?')) {
										idProveedor = -3;
										actualizaDatos();
										muestraAltaProveedor();
									} else {
										cambioAlta();
									}
								}
								else if(RESserv[0] == 1) {
									// Actualización de Campos //
									actualizaDatos();
								}
								else if(RESserv[0] == 2) { 
									alert("La factura #" + noFactura + " de " + cfdiEmisorNombre
											+ " ya existe en la Base de Datos, " 
											+ "por lo tanto no es posible darla de alta.\n");
									limpiaDatos(true);
									cambioAlta();
								}
							}
						}
					},
					error: function (data, status, e) {
						alert(e);
					}
				}
			)*/
			return false;
		}
}

function validaTipoDcto() {
	
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
	muestraAltaProveedor();
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
		$('#txtFechaFactura').datepicker();
	}
}

function muestraAltaProveedor() {

	if($('#ddlProveedor').val() == -3) {
		if($('#txtTipoDcto').val() == 1 && $('#txtAlta').val() == 1) {
			$('#ddlProveedor').prop('disabled', true).css('color','');   
			$('#txtRazonSocial').prop('readonly', true).css('color','grey').css('background','#EEEEEE').show();        
			$('#txtRFC').prop('readonly', true).css('color','grey').css('background','#EEEEEE').show();             
		} else {
			$('#txtRazonSocial').prop('readonly', false).css('color','').css('background','#FFFFFF').show();        
			$('#txtRFC').prop('readonly', false).css('color','').css('background','#FFFFFF').show();              
		}
		$('#trNombreProveedor').show();        
		$('#trRazonSocial').show();        
		$('#trCLABE').show();        
		$('#trTelefono').show();             
		$('#trCorreo').show();
		$('#trNoCta').hide();             
	} else {
		$('#trNombreProveedor').hide();        
		$('#trRazonSocial').hide();        
		$('#trCLABE').hide();        
		$('#trTelefono').hide();             
		$('#trCorreo').hide(); 
		if($('#txtTipoDcto').val() > 0) {
			$('#trNoCta').show();             
		}        
	}
}

function NewFacturaPagosVarios(i) {
	//alert(Date.parse(txtValue('txtFechaFin')));
	var error = "";
	var tipDcto = "";
	if(txtValue('txtTipoDcto') == 0) 
		error += "- Selecciona un tipo de documento\n";
	if(txtValue('txtTipoDcto') == 1) 
		tipDcto = "Factura";
	else if(txtValue('txtTipoDcto') == 2) 
		tipDcto = "Recibo";
	if(txtValue('ddlProveedor') == -1)
		error += "- Selecciona un proveedor\n"; 
	if(txtValue('ddlProveedor') == -3 && txtValue('txtNombreProveedor').length <= 3)
		error += "- Nombre de Proveedor m\u00EDnimo 3 caracteres\n"; 
	if(txtValue('ddlProveedor') == -3 && txtValue('txtRazonSocial').length <= 5)
		error += "- Raz\u00F3n Social m\u00EDnimo 5 caracteres\n"; 
	if(txtValue('ddlProveedor') == -3 && txtValue('txtNombreProveedor').length <= 3)
		error += "- Proveedor m\u00EDnimo 3 caracteres\n"; 
	if(txtValue('txtRFC').length <= 11)
		error += "- RFC inv\u00E1lido\n"; 
	if(!validaRFC('txtRFC') && !validaRFCPersona('txtRFC'))
		error += "- El RFC es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral\n";
	// Si es diferente a alta de proveedor
	if(txtValue('ddlProveedor') != -3 && txtValue('txtNumCta').length <= 3) 
		error += "- No. Cuenta, m\u00EDnimo 3 caracteres\n"; 
	 if ( !$('#txtTipoCambio').is('[readonly]') ){
    	var tipoC = $('#txtTipoCambio').val();
    	tipoC = tipoC.replace('$', '');
    	if(tipoC.trim() == '' || tipoC == 0){
    		error += "-Capture Tipo de Cambio \n";
    	}
    }
	if(txtValue('ddlProveedor') == -3 && txtValue('txtCLABE').length < 18)
		error += "- La Cuenta CLABE debe ser de 18 d\u00EDgitos\n";
	if(txtValue('ddlProveedor') == -3 && !analizarCLABE(txtValue('txtCLABE')))
		error += "- La Cuenta CLABE es Incorrecta\n";
	if(txtValue('ddlProveedor') == -3 && txtValue('txtTelefono').length < 8)
		error += "- Tel\u00E9fono m\u00EDnimo 8 caracteres\n"; 
	if(txtValue('ddlProveedor') == -3 && validarEmail("txtCorreo") == false)
		error += "- Correo Electr\u00F3nico inv\u00E1lido\n"; 
	if(txtValue('txtFechaFactura').length <= 5)
		error += "- Fecha de " + tipDcto + " inv\u00E1lida\n"; 
	if(txtValue('txtFechaIni').length <= 5)
		error += "- Fecha Inicio no v\u00E1lida\n"; 
	if(txtValue('txtFechaFin').length <= 5)
		error += "- Fecha Fin no v\u00E1lida\n"; 
	if(Date.parse(txtValue('txtFechaIni')) > Date.parse(txtValue('txtFechaFin')))
		error += "- Fecha Fin no puede ser menor a Fecha Inicio\n";
	var valFactura = txtValue('txtNumFactura');
	if(txtValue('txtNumFactura').length < 1 || txtValue('txtNumFactura') == 0 || valFactura.trim() == '')
		error += "- No. Factura, inv\u00E1lido\n"; 
	if(txtValue('txtTipoDcto') == 1) {
		if(txtValue('txtSubtotal') == "$0.00")
			error += "- Subtotal debe ser mayor a $0.00\n";    
		/* Validamos el IVA? */
        /*if(txtValue('txtIVA') == "$0.00")
            error += "- Iva debe ser mayor a $0.00\n";*/
	}
	if(txtValue('txtTotal') == "$0.00")
		error += "- Total debe ser mayor a $0.00\n"; 
	if(txtValue('txtTipoDcto') == 1) {
		numSubtotal = Number(formatNumber(txtValue('txtSubtotal'),0,2,false));
		numIVA = Number(formatNumber(txtValue('txtIVA'),0,2,false));
		sumTotal = formatNumber(numSubtotal + numIVA,0,2,false)
		if(formatNumber(txtValue('txtTotal'),0,2,false) != sumTotal)
			error += "- El total no es igual a la suma de Subtotal + el IVA\n";     
	}
	if(txtValue('txtDetalle').length < 5){
		error += "- Detalle, m\u00EDnimo 5 caracteres\n"; 
	}
	if(error != "") 
	alert('Se encontraron errores en el formulario\n'+error);    
	else {
		/* Alta de nuevo registro */
		$('#ddlProveedor').prop('disabled', false);   
		if(txtValue('ddlProveedor') == -3) {
			MetodoAjax55("../../../inc/Ajax/_Contabilidad/NewProveedor.php",$("form").serialize());    
		} else {
			//MetodoAjax5("../../../inc/Ajax/_Contabilidad/NewFactura.php",$("form").serialize());
			guardarNuevaFactura();
		}
	}
}

function guardarNuevaFactura(){
	$("#formAlta").submit(function(e){

		if(window.FormData !== undefined){
			var items = $('#formAlta :disabled');
			items.prop('disabled', false);
			var formData = new FormData(this);
			$(items).prop('disabled', true);

			$.ajax({
				url			: BASE_PATH + '/inc/Ajax/_Contabilidad/NewFactura.php',
				type		: 'POST',
				data		: formData,
				mimeType	: "multipart/form-data",
				contentType	: false,
				cache		: false,
				processData	: false,

				success		: function(response, textStatus, jqXHR){
					var items = response.split("|");
					alert(items[1]);
					if($("#idFactura").val() == 0){
						if(items[0] == 0){
							$('#formAlta [name="txtTipoDcto"]').val(-1).change();
						}
					}
					else{
						if($("#idFactura").val() > 0){
							BuscarFacturaRecibo();
						}
					}
				},
				error		: function(jqXHR, textStatus, errorThrown){
					$("#multi-msg").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
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
}

function DatosProvPagosVarios(altaFactura) {
	var idProveedor = txtValue('ddlProveedor');
	if(idProveedor > -1){
		$.post('../../../inc/Ajax/_Contabilidad/DatosProveedorExterno.php',
			{
				idProveedor : idProveedor
			},
			function(response){
				delete(response.data.NumCuenta);
				simpleFillFields(response.data, 'txt');
				$('#txtRFC').prop('readonly', true).css('color','').css('background',"#EEEEEE");
				$('#txtRazonSocial').prop('readonly', true).css('color','').css('background',"#EEEEEE");
				$('#txtNumCta').prop('readonly', true).css('color','').css('background',"#EEEEEE");
				muestraAltaProveedor();
				console.log(gIdProveedor, idProveedor);
				if((gIdProveedor != idProveedor) && idProveedor != undefined){
					$('body').trigger('validarNumeroDeFactura');
				}
				if(altaFactura) { // Si viene de la alta de un proveedor
					//MetodoAjax5("../../../inc/Ajax/_Contabilidad/NewFactura.php",$("form").serialize());    
					guardarNuevaFactura();
				}
			}
		, 'json');
	}else if(idProveedor == -2) {
		if(Existe('txtNumCta')) setValue('txtNumCta','');
		validaTipoDcto();
	} else if(idProveedor == -3) {
		limpiaDatos(false,true);
		muestraAltaProveedor();
	}
}

function MetodoAjax55(url,parametros) {  
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	http.onreadystatechange=function() { 
			if (http.readyState==1) {
				Emergente();
			}
			if (http.readyState==4) {
				OcultarEmergente();
				var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
				var RESserv = RespuestaServidor.split("|");
				validaSession(RESserv[0]);
				if(RESserv[0] == 0) {
					alert(RESserv[1]);

					GLOBAL_ENTRADAS = 0;
					$("#ddlProveedor").on('provextloaded', function(){
						$(this).val(RESserv[2]);
						if(GLOBAL_ENTRADAS == 0){
							DatosProvPagosVarios(true);
						}
						GLOBAL_ENTRADAS += 1;
					});
					cargarStoreProveedoresExternos();
				}
				else {
					if(document.getElementById('daniel') != null)
						document.getElementById('daniel').innerHTML = RESserv[1];
					alert("Error: "+RESserv[0]+"  "+RESserv[1]);
				}
			}
	}
	http.send(parametros+"&pemiso="+true);
}

function analizarCLABE() {
	var CLABE = $("#txtCLABE").val();

	if(CLABE.length == 18){
		return validarDigitoVerificador(CLABE);
	}
	else{
		return false;
	}
}

function validarDigitoVerificador( CLABE ) {
	var factoresDePeso = [ 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7 ];
	var productos = new Array();
	var digitoVerificador = 0;
	
	for ( var i = 0; i < factoresDePeso.length; i++ ) {
		productos[i] = CLABE.charAt(i) * factoresDePeso[i];
	}
	
	for ( var i = 0; i < productos.length; i++ ) {
		productos[i] = productos[i] % 10;
	}
	
	for ( var i = 0; i < productos.length; i++ ) {
		digitoVerificador += productos[i];
	}
	
	digitoVerificador = 10 - ( digitoVerificador % 10 );
	
	return CLABE.charAt(17) == digitoVerificador;
	
}