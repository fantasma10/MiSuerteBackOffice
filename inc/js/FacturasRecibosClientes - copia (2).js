
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
**	Alta y Actualizacion de Facturas
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
// inicia componentes de la pantalla de facturas y recibos del cliente
function initComponentsFacturasClientes(){
	$('#radioConsulta, #radioCrear').on('click', seleccionarPantalla);
}

// según la opcion seleccionada se carga la pantalla para crear o para consultar y editar
function seleccionarPantalla(event){
	gRFC = 0;
	gNumF = 0;
	var valorSeleccioando = event.currentTarget.value; // 1 Consulta	2 Crear

	if(valorSeleccioando == 1){// Cargar la pantalla de Consulta
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaConsultaClientes.php', 'htmlContent', 'initConsultaClientes()');
	}
	if(valorSeleccioando == 2){
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaCrearClientes.php', 'htmlContent', 'initFacturasClientes()');
	}
}

/*
**	Iniciar componentes generales
*/
function initComponents(){

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

	$(':input').bind('paste', function(){return false});

	$('#txtTipoCambio, #txtSubtotal, #txtIVA, #txtTotal').on('click', function(){
		this.focus();this.select();
	});

	$('#txtTipoCambio, #txtSubtotal, #txtIVA, #txtTotal').alphanum({
		allowNumeric		: true,
		allow				: '$,.',
		disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ',
		allowOtherCharSets	: false
	});

	$('#txtTipoCambio, #txtSubtotal, #txtIVA, #txtTotal').on('blur', function(){
		this.value = '$' + formatNumber(this.value, 0, 2, true);
	});

	$('#txtNumCta').prop('readonly', true);

	$('#txtNumFactura').on('change', validarinfo);

	$("#txtNumFactura").alphanum({
		allowOtherCharSets: false
	});

	$("#txtDetalle").alphanum({
		allow				: 'ñáéíóúÁÉÍÓÚ.,',
		allowOtherCharSets	: false,
		maxDigits			: 255
	});

	$('#ddlCad').on('change', loadStoreSubCadena);
	$('#ddlSubCad').on('change', loadStoreCorresponsal);

	// LLenar combo de Tipos de Documento
	cargarStore('../../inc/Ajax/stores/storeTipoDocumento.php', 'txtTipoDcto', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'});
	// LLenar combo de Cadena
	cargarStore("../../../inc/Ajax/stores/storeCadenas.php", "ddlCad", {}, {text : 'nombreCadena', value : 'idCadena'}, {}, 'cadenaloaded');
	// Llenar combo de Tipo de Moneda
	cargarStore('../../inc/Ajax/stores/storeTipoMoneda.php', 'txtMoneda', {}, {text : 'descripcionMoneda', value : 'codigoMoneda'}, {}, 'monedaloaded');
	$('#txtMoneda').on('monedaloaded', function(){
		$('#txtMoneda').val("MXN");
		$('#txtTipoCambio').val("$1.00");
	});


	$('#txtTipoDcto').val(-1);
	validaTipoDcto();
}

function initValidarInfo(){
	$('#ddlCad, #ddlSubCad, #ddlCorresponsal').on('change', getDatos);
	$('#txtRFC').on('valuechanged', validarinfo);
}

function initFacturasClientes(){
	initComponents();
	initValidarInfo();
}

function initFacturasClientesEditar(){
	initComponents();

	var clics = 0;
	$('#formAlta :input').on('click', function(){
		clics++;
		if(clics == 1){
			initValidarInfo();
		}
	});
}

/*
**	obtener datos de direccion y numero de cuenta de la cadena, subcadena o corresponsal
*/
function getDatos(){
	var elementos = $('#formAlta :disabled');
	$(elementos).prop('disabled', false);

	var params = getParams($('#formAlta').serialize());
	$(elementos).prop('disabled', true);

	if(params.idCadena > -1 || params.idSubCadena > -1 && params.idCorresponsal > -1){
		if(params.idCorresponsal == -1){
			categoria = 2;
		}
		if(params.idSubCadena == -1){
			categoria = 1;
		}
	}
	params.categoria = categoria;

	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/getDatos.php',
		params,
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}

			if(response.success == true){
				simpleFillForm(response.data, 'formAlta', 'eventodeprueba');
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
	var idProveedor = $('#txtRFC').val();
	var RFC = $('#txtRFC').val();
	idProveedor = (idProveedor <= -1)? 0 : idProveedor;

	if((gRFC != RFC) || gNumF != $('#txtNumFactura').val()){
		var params = {
			idProveedor	: idProveedor, // debe ir para poder reutilizar el codigo del archivo validarinfoProveedor
			RFC			: RFC,
			campo		: (name != undefined)? name : 'noFactura', // en este caso el campo que siempre se va a validar es el numero de factura
			valor		: $('#txtNumFactura').val() // valor del numero de factura
		}

		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/validarinfoProveedor.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				if(response.success != true){
					//si se está validando desde el campo de numero de factura
					if($("#"+target.id).length){
						document.getElementById(target.id).focus();
						target.value = '';
					}// si se esta validando al seleccionar subcadena o corresponsal
					else{
						$('#txtRFC').val('');
						$('#txtNumCta').val('');
						if(categoria == 3){
							$('#ddlCorresponsal').val(-1);
						}
						if(categoria == 2){
							$('#ddlCorresponsal').val(-1);
							$('#ddlSubCad').val(-1);
						}
					}
				}
			},
			"json"
		);
	}
}


function loadStoreSubCadena(){
	console.log('cargando store subcadena');
	var params = {
		idCadena : $('#ddlCad').val()
	}

	cargarStore("../../../inc/Ajax/stores/storeSubCadenas.php", "ddlSubCad", params, {text : 'nombreSubCadena', value : 'idSubCadena'}, {}, 'subcadenaloaded');
	limpiaStore("ddlCorresponsal");
}

function loadStoreCorresponsal(){
	console.log('cargando store corresponsal');
	var params = {
		idCadena	: $('#ddlCad').val(),
		idSubCadena	: $('#ddlSubCad').val()
	}

	cargarStore("../../../inc/Ajax/stores/storeCorresponsales.php", "ddlCorresponsal", params, {text : 'nombreCorresponsal', value : 'idCorresponsal'}, {}, 'corresponsalloaded');
}

function validaTipoDcto(){
	if($('#txtTipoDcto').val() == -1){
		/* Si el tipo de documento esta en Seleccione */
		// Ocultar todo//
		$('#formAlta').get(0).reset();
		$('#trRFC, #trCliente, #trAltaDocumento, #trFileToUpload, #trNoCta, #trFechaFactura, #trFechaInicio, #trFechaFin, #trNoFactura, #trSubtotal, #trIVA, #trTotal, #trDetalle, #btnNuevaFactura, #trMoneda, #trTipoCambio').hide();
		
		limpiaDatos(true);
	}
	else if($('#txtTipoDcto').val() == 1) {
		/* Si el tipo de documento esta en Factura */        
		// Mostrar datos de factura //
		$('#trCliente').show();
		$('#trRFC, #trAltaDocumento, #trFileToUpload, #trNoCta, #trFechaFactura, #trFechaInicio, #trFechaFin, #trNoFactura, #trSubtotal, #trIVA, #trTotal, #trDetalle, #trMoneda, #trTipoCambio').show();
		// Textos de Factura//       
		$('#tdFechaFactura').html("Fecha Factura");
		$('#tdNoFactura').html("No Factura");
		$('#btnNuevaFactura').val("Nueva Factura");
		$('#btnNuevaFactura').show();

		limpiaDatos(true);
		cambioAlta();
	}
	else if($('#txtTipoDcto').val() == 2){

		$('#trCliente :input').prop('disabled', false);
		$('#trAltaDocumento, #trFileToUpload, #trSubtotal, #trIVA').hide();
		$('#trFileToUpload input').val('');
		$('#trSubtotal :input').val('0');

		$('#trIVA :input').val('0');

		$('#trCliente, #trRFC, #trNoCta, #trFechaFactura, #trFechaInicio, #trFechaFin, #trNoFactura, #trTotal, #trDetalle').show();     
		
		$('#trNombreProveedor, #trRazonSocial').hide();        
        
		// Textos de Nota//       
		$('#tdFechaFactura').html("Fecha Recibo");
		$('#tdNoFactura').html("No Recibo");
		$('#btnNuevaFactura').val("Nuevo Recibo");
		$('#btnNuevaFactura').show();
		$('#trMoneda, #trTipoCambio').show();
		limpiaDatos(false);
		$('#txtFechaFactura').datepicker();     
	}
}

function cambioAlta() {
	$('#ddlSubCad').unbind('storeSubCadenaLoaded');
	$('#ddlCorresponsal').unbind('storeCorLoaded');

	if($('#txtAlta').val() == 1) {
		/* Si es por carga de XML */
		limpiaDatos(true);
		$('#trFileToUpload').show();
		$('#txtFechaIni').prop('readonly', false).css('color','').css('background','#FFFFFF');
		$('#txtFechaFin').prop('readonly', false).css('color','').css('background','#FFFFFF');
		$('#txtDetalle').prop('readonly', false).css('color','').css('background','#FFFFFF');
		$('#trCliente :input').prop('disabled', true);
		//$('#txtFechaFactura').datepicker("destroy");
	}
	else{
		/* Si es por carga Manual */
		limpiaDatos(false);
		$('#trFileToUpload').hide();
		$('#trCliente :input').prop('disabled', false);
		//$('#txtFechaFactura').datepicker();

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
	$('#trCliente :input').prop('readonly', isReadonly).css('color','').css('background',bgColor);

	$('#txtMoneda').val("MXN");
	$('#txtTipoCambio').val("$1.00");
}

// mostrar la informacion del xml en el formulario
function actualizaDatos(data){
	if(data.txtMoneda == undefined || data.txtMoneda == ''){
		$("#txtMoneda").val("MXN");
		data.txtMoneda = 'MXN';
		data.txtTipoCambio = '$1.00';
	}
	// validaciones y acciones adicionales para la carga del documento en pantalla
	$('body').on('simpleloaded', function(){
		//asignar valor al combo de la subcadena
		$('#ddlSubCad').on('storeSubCadenaLoaded', function(){
			$('#ddlSubCad').val(data.idSubCadena);
		});
		//cargar el store de la subcadena
		cargarStore(BASE_PATH + '/inc/Ajax/stores/storeSubCadenas.php', 'ddlSubCad', {idCadena : data.idCadena}, {value : 'idSubCadena', text : 'nombreSubCadena'}, {}, 'storeSubCadenaLoaded');
		//asignar valor al combo del corresponsal
		$('#ddlCorresponsal').on('storeCorLoaded', function(){
			$('#ddlCorresponsal').val(data.idCorresponsal);
		});
		//cargar store del corresponsal
		cargarStore(BASE_PATH + '/inc/Ajax/stores/storeCorresponsales.php', 'ddlCorresponsal', {idCadena : data.idCadena, idSubCadena : data.idSubCadena}, {value : 'idCorresponsal', text : 'nombreCorresponsal'}, {}, 'storeCorLoaded');
		//validaciones para la moneda y el tipo de cambio
		if(data.txtTipoCambio == undefined || (data.txtMoneda != 'MXN' && (data.txtTipoCambio == ''))){
			$('#txtTipoCambio').val(data.txtTipoCambio).prop('readonly', false).attr('style', 'background-color:white;');	
		}
		if(data.txtTipoDcto == undefined || data.txtMoneda == 'MXN' && (data.txtTipoCambio == '')){
			$('#txtTipoCambio').val("$1.00").prop('readonly', true);
		}
	});
	
	$.each(data, function(item){
		$("#formAlta [name='"+item+"']").css('color', 'gray');
	});

	simpleFillForm(data, 'formAlta', 'simpleloaded');
}

// cargar la información del xml
function ajaxFileUpload(){
		var archivoExtension = $('#fileToUpload').val().split('.').pop().toLowerCase();
		if(archivoExtension != "xml") {
			alert("Solo esta permitido archivos con extensión .XML");
			$('#fileToUpload').replaceWith($('#fileToUpload').clone( true ) ); 
			limpiaDatos(true);
		}
		else {
			
			$("#loading")
			.ajaxStart(function(){
					$(this).show();
			})
			.ajaxComplete(function(){
					$(this).hide();
			});

			$.ajaxFileUpload(
				{
					url				: BASE_PATH + '/inc/Ajax/_Contabilidad/CargaFacturaClientesXML.php',
					secureuri		: false,
					fileElementId	: 'fileToUpload',
					dataType		: 'json',
					data			: {
						name:'logan', id:'id'
					},
					success			: function(response, status){
						if(showMsg(response)){
							alert(response.msg);
						}

						if(response.success == true){
							var RES = response.data;

							noFactura = RES['txtNumFactura'];

							var regex = new RegExp("^[a-z0-9]+$","i");
							if(!regex.test(noFactura)){
								alert("El N\u00FAmero de Factura es Inv\u00E1lido");
								event.preventDefault();
								return false;
							}

							if(RES['txtFechaFactura']){
								RES['txtFechaFactura'] = RES['txtFechaFactura'].substring(0, 10);
							}

							cambioAlta();
							actualizaDatos(response.data);
						}
						else{
							limpiaDatos(true);
							cambioAlta();
						}
					},
					error: function (data, status, e) {
						alert(e);
					}
				}
			)
			return false;
		}
}

// validaciones para guardar la factura
function GuardarFactura(e){
	$("#formAlta").submit(function(e){

			if(window.FormData !== undefined){
				var formData = new FormData(this);
				$.ajax({
					url			: BASE_PATH + '/inc/Ajax/_Contabilidad/NewFactura.php',
					type		: 'POST',
					data		:  formData,
					mimeType	:"multipart/form-data",
					contentType	: false,
					cache		: false,
					processData	:false,
					success		: function(data, textStatus, jqXHR)
					{
							$("#multi-msg").html('<pre><code>'+data+'</code></pre>');
					},
					error		: function(jqXHR, textStatus, errorThrown) 
					{
						$("#multi-msg").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
					} 	        
				});
				e.preventDefault();
				$(this).unbind();
			}
			else{
				//generate a random id
				var  iframeId = 'unique' + (new Date().getTime());

				//create an empty iframe
				var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');

				//hide it
				iframe.hide();

				//set form target to iframe
				formObj.attr('target',iframeId);

				//Add iframe to body
				iframe.appendTo('body');
				iframe.load(function(e)
				{
					var doc = getDoc(iframe[0]);
					var docRoot = doc.body ? doc.body : doc.documentElement;
					var data = docRoot.innerHTML;
					$("#multi-msg").html('<pre><code>'+data+'</code></pre>');
				});
			}

			});
	$("#formAlta").submit();
/*
	var items = $('#formAlta :disabled');
	items.prop('disabled', false);

	parametros = $("#formAlta").serialize();
	var params = getParams($('#formAlta').serialize());

	$(items).prop('disabled', true);

	var lack = "";
	var error = "";
	if(params.txtTipoDcto == -1){
		lack += "- Tipo de Documento\n";
	}
	if(params.idCadena == -1 && (params.idSubCadena == -1 || params.idSubCadena == undefined) && (params.idCorresponsal == -1 && params.idCorresponsal == undefined)){
		lack += "- Cadena, SubCadena, Corresponsal\n";
	}
	else{
		if(params.idCadena == -1){
			lack += "- Cadena\n";
		}
		if(params.idSubCadena == -1){
			lack+= "- SubCadena\n";
		}
	}
	if(params.txtRFC.trim() == "" || params.txtRFC.trim() == undefined){lack += "- RFC\n";}
	if(params.txtNumCta.trim() == "" || params.txtNumCta.trim() == undefined){lack += "- N\u00FAmero de Cuenta\n";}
	if(params.txtMoneda == -1 || params.txtMoneda == undefined){lack+= "- Moneda\n"; $("#txtMoneda").prop('disabled', false);}
	if(params.txtTipoCambio == "" || params.txtTipoCambio == undefined){lack+= "- Tipo de Cambio\n";}
	else{
		if(params.txtTipoCambio == "$0.00"){
			error += "- El tipo de Cambio no puede ser $0.00\n";
			$("#txtTipoCambio").prop('readonly', false);
		}
	}
	if(params.txtFechaFactura.trim() == "" || params.txtFechaFactura.trim() == undefined){lack+= "- Fecha de Factura\n";}
	if(params.txtFechaIni.trim() == "" || params.txtFechaIni.trim() == undefined){lack+= "- Fecha de Inicio\n";}
	if(params.txtFechaFin.trim() == "" || params.txtFechaFin.trim() == undefined){lack+= "- Fecha Final\n";}
	if(params.txtNumFactura.trim() == "" || params.txtNumFactura.trim() == undefined){lack+= "- N\u00FAmero de Factura\n";}
	
	if(params.txtTipoDcto == 1){
		if(params.txtSubtotal.trim() == "" || params.txtSubtotal.trim() == undefined){lack+= "- SubTotal\n";}
		else{
			if(toFloat(params.txtSubtotal) == 0){
				error += "- SubTotal no puede ser $0.00\n";
			}
		}
		if(params.txtIVA.trim() == "" || params.txtIVA.trim() == undefined){lack+= "- IVA\n";}
		else{
			if(toFloat(params.txtIVA) == 0){
				error += "- IVA no puede ser $0.00\n";
			}
		}
	}

	if(params.txtTotal.trim() == "" || params.txtTotal.trim() == undefined){lack+= "- IVA\n";}
	else{
		if(toFloat(params.txtTotal) == 0){
			error += "- Total no puede ser $0.00\n";
		}
	}
	if(params.txtTipoDcto == 1){
		if(parseFloat(toFloat(params.txtSubtotal) + toFloat(params.txtIVA)).toFixed(2) != toFloat(params.txtTotal)){
			error +="- La Suma del Subtotal y el IVA no concuerdan con el Total\n";
		}
	}

	if(params.txtDetalle.trim() == "" || params.txtDetalle.trim() == undefined){
		lack += "- Detalle\n"
	}
	else{
		var dtl = params.txtDetalle.trim();
		if(dtl.length < 10){
			lack += "- Detalle debe ser de m\u00EDnimo 10 caracteres\n";
		}
	}

	if(lack != ""){
		lack = "Los Siguientes datos son Obligatorios : \n" + lack;
	}
	if(error != ""){
		error += "\n ";
		error = "\nLos siguientes datos son inv\u00E1lidos \n" + error;
	}

	if(lack != "" || error != ""){
		alert(lack + error);
	}
	else{
		params.pemiso = true;
		/*http.open("POST", BASE_PATH + '/inc/Ajax/_Contabilidad/NewFactura.php', true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		http.onreadystatechange=function(){
			if (http.readyState==1) {
				Emergente();
			}
			if (http.readyState==4) {
				OcultarEmergente();
					var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
					console.log(RespuestaServidor);
					var RESserv = RespuestaServidor.split("|");
					validaSession(RESserv[0]);
					if(RESserv[0] == 0) {
						alert(RESserv[1]);
						validaTipoDcto();
					}
					else {
					if(document.getElementById('daniel') != null)
						document.getElementById('daniel').innerHTML = RESserv[1];
					alert("Error: "+RESserv[0]+"  "+RESserv[1]);
				}
			}
		}
		//parametros = $('#formAlta').serialize();
		http.send(parametros+"&pemiso="+true);*/
		/*$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/NewFactura.php',
			params,
			function(response){
				var items = response.split("|");
				// mostrar el mensaje al usuario
				alert(items[1]);
				// si el codigo de respuesta fue 0 quiere decir que la operacion fue exitosa, entonces se resetea el formulario
				if(params.idFactura == 0){
					if(items[0] == 0){
						$('#formAlta [name="txtTipoDcto"]').val(-1).change();
					}
				}
				else{
					if(params.idFactura > 0){
						BuscarFacturas();
					}
				}
			}
		);
		enviarF(event);
	}*/
}





function getDoc(frame) {
     var doc = null;
 
     // IE8 cascading access check
     try {
         if (frame.contentWindow) {
             doc = frame.contentWindow.document;
         }
     } catch(err) {
     }
 
     if (doc) { // successful getting content
         return doc;
     }
 
     try { // simply checking may throw in ie8 under ssl or mismatched protocol
         doc = frame.contentDocument ? frame.contentDocument : frame.document;
     } catch(err) {
         // last attempt
         doc = frame.document;
     }
     return doc;
 }

//$("#multiform").submit();




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
**
**	Consulta de Facturas
**
** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function initConsultaClientes(){

	

	var urlCat = BASE_PATH + '/inc/Ajax/_Clientes/getListaCategoria.php';
	//AutoCompletar CAdena
	if($('#idCadena').length && $('#cmbCadena').length){
		autoCompletaGeneral('cmbCadena', 'idCadena', urlCat, 'nombreCadena', 'idCadena', {categoria : 1}, renderItemCadena);
	}

	//AutoCompletar SubCadena
	if($('#idSubCadena').length && $('#cmbSubCadena').length){
		
		$("#cmbSubCadena").keyup(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('cmbSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
		$("#cmbSubCadena").keypress(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('cmbSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
	}
	//AutoCompletar Corresponsal
	if($("#cmbCorresponsal").length){
		$("#cmbCorresponsal").keypress(function(){
			var cadena		= $("#idCadena").val();
			var subcadena	= $("#idSubCadena").val();
			var parametros	= {categoria : 3, idCadena : cadena, idSubCadena : subcadena}

			autoCompletaGeneral('cmbCorresponsal', 'idCorresponsal', urlCat, 'nombreCorresponsal', 'idCorresponsal', parametros, renderItemCorresponsal);
		});
	}

	$("#cmbCadena, #cmbSubCadena, #cmbCorresponsal").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'cmb' : 'id'};

		if(valor == ""){
			$("#" +arr[tip] + last).val(-1);
		}
	});

	$('#txtNumCuenta').prop('maxlength', 10);
	$('#txtNumCuenta').numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits           : 11,
	});
	var checkin1 = $('#txtFechaInicio').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin1.hide();
		}
	).data('datepicker');

	var checkin2 = $('#txtFechaFinal').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin2.hide();
		}
	).data('datepicker');

	var checkin3 = $('#txtFechaFact').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin3.hide();
		}
	).data('datepicker');

	$("#noFactura").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	try{
		$("#txtNumFactura").alphanum({
			allowOtherCharSets: false
		});		
	}
	catch(e){
		console.log(e);
	}

	$("#fRFC").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	// LLenar combo de Tipos de Documento
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoDocumento.php', 'tipoDocumento', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'});

	// Llenar combo de Estatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'idEstatus', {}, {text : 'descEstatus', value : 'idEstatus'});

	$(':input').bind('paste', function(){return false;});
}

function _denegar(e){
	e.preventDefault();
	return false;
}

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}

function renderItemSubCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "<br>" + item.nombreCadena +"</a>" )
	.appendTo( ul );
}

function renderItemCorresponsal( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label +"</a>" )
	.appendTo( ul );
}

function BuscarFacturas(){
	var params = getParams($('#formBusqueda').serialize());

	var extraHeaders	= "";
	var extraCells		= "";

	if(ES_ESCRITURA){
		//coordinador de contabilidad y admin
		if(ID_PERFIL == 3 || ID_PERFIL == 1){
			extraHeaders = "<th>Editar</th><th>Eliminar</th>";
			extraCells = "<td></td><td></td>";
		}//contabilidad base
		else if(ID_PERFIL == 9){
			extraHeaders = "<th>Editar</th>";
			extraCells = "<td></td>";
		}
	}

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Tipo Dcto</th><th>No.<br/>Factura/Recibo</th><th>Razón Social</th><th>No. Cuenta</th><th>Fecha<br/>Factura/Recibo</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Total</th><th>Estatus</th><th>Detalle</th><th></th><th>Corte</th>'+extraHeaders+'</tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>'+extraCells+'</tr></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	llenaDataTable("tblGridBox", params, BASE_PATH + "/inc/Ajax/_Contabilidad/BuscaFacturasClientes.php");
}

function editar(id){
	cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaCrearClientes.php', 'divTbl', 'initFacturasClientesEditar();loadDocumento(' + id + ')');
}

/*
**	Consultar la factura al hacer clic en el link de Ver
*/
function AbrirDetalleFactura(tipoDocumento, numeroCuenta, noFactura){
	var idFactura = $(event.target).attr('idFactura');

	$("#modalMainTitle").html("Factura/Recibo Cliente");
	$("#modalCorner").html("Consulta");
	var url = BASE_PATH + "/_Contabilidad/FacturasRecibos/ConsultaCliente.php?idFactura="+idFactura;
	cargarContenidoHtml(url, 'divTbl', "loadDocumento("+ idFactura +")");
}

function loadDocumento(idDoc){
	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/loadFacturaCliente.php',
		{
			idDocumento : idDoc
		},
		function(response){
			gRFC = response.data.txtRFC;
			gNumF = response.data.txtNumFactura;
			
			$('#ddlCad').on('cadenaloaded', function(){
				$('#ddlCad').val(response.data.ddlCad).change();
				$('#ddlCad').unbind('cadenaloaded');
			});

			fillFieldsChange(response.data, '');

			var params = {idCadena	: response.data.ddlCad}

			$('#ddlCorresponsal').on('corresponsalloaded2', function(){
				$('#ddlCorresponsal').val(response.data.ddlCorresponsal);
				$('#ddlCorresponsal').unbind('corresponsalloaded2');
			});

			$('#ddlSubCad').on('subcadenaloaded2', function(){
				$('#ddlSubCad').val(response.data.ddlSubCad).change();
				$('#ddlSubCad').unbind('subcadenaloaded2');
				params.idSubCadena = response.data.ddlSubCad;

				cargarStore("../../../inc/Ajax/stores/storeCorresponsales.php", "ddlCorresponsal", params, {text : 'nombreCorresponsal', value : 'idCorresponsal'}, {}, 'corresponsalloaded2');
			});


			cargarStore("../../../inc/Ajax/stores/storeSubCadenas.php", "ddlSubCad", params, {text : 'nombreSubCadena', value : 'idSubCadena'}, {}, 'subcadenaloaded2');


			if($('#btnNuevaFactura').length){
				document.getElementById('btnNuevaFactura').value = "Guardar Cambios";
			}
		},
		'json'
	);
}

function cerrarModal(){
	$("#divTbl").empty();
}

/*
** Eliminar la factura
*/
function eliminar(idDoc){
	if(confirm("\u00BFDesea Eliminar el Elemento Seleccionado?")){
		$.post(BASE_PATH + "/inc/Ajax/_Contabilidad/eliminarDocumento.php",
			{
				idFactura : idDoc
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				//else{
					BuscarFacturas();
				//}
			},
			'json'
		);
	}
}


function showExcel(todo){

	var parametros	= getParams($("form").serialize());
	var oBusqueda	= dataTableObj._fnDataToSearch();
	var strToFind	= oBusqueda.oPreviousSearch.sSearch;

	var paging			= dataTableObj.fnPagingInfo();
	parametros.start	= (todo == 1)? 0 : paging.iStart;
	parametros.end		= (todo == 1)? paging.iTotal : paging.iEnd;
	parametros.strToFind= (todo == 1)? '' : strToFind;

	parametros.iSortCol_0	= dataTableObj.fnSettings().aaSorting[0][0];
	parametros.sSortDir_0	= dataTableObj.fnSettings().aaSorting[0][1];

	var params = "";
	$.each(parametros, function(index, val){
		params += index + "=" + val + "&";
	});

	$.fileDownload(BASE_PATH + "/inc/Ajax/_Contabilidad/ListaExcelFacturasClientes.php?" + params, {
		successCallback: function(url) {
			//OcultarEmergente();
		},
		failCallback: function(responseHtml, url){
			//OcultarEmergente();
			alert("Ha ocurrido un error");
		}
	});
	return false;
}