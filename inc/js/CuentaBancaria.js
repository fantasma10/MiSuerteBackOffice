var configuracionCuenta;
var configuracionCuentaBanco;

function initComponents() {	
	$("#txtRFC").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	
	$("#txtCorreo").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 120
	});
	
	$("#txtCuenta").numeric({
		allowMinus   : false,
		allowThouSep : false
	});	
	
	$("#txtRFC").attr('style', 'text-transform: uppercase;');
	
	$("#buscar").on('click', function(){
		buscar();
	});
	$("#guardar").on('click', function(){
		crearConfiguracion();
	});
	
	$("#txtCliente, #txtCorresponsal").on('keyup', function(event){
		var id = event.target.id;
		var value = event.target.value;
	
		var cfg = {
			txtCliente	: 'txtRFCCliente'
		}
	
		var txt = eval("cfg."+id);
	
		if(value == "" || value == undefined){
			$("#"+txt).prop('disabled', false);
		}else{
			$("#"+txt).prop('disabled', true);
		}
	
		var valorCliente = $("#txtCliente").val();
		var valorCorresponsal = $("#txtCorresponsal").val();
		
		if(myTrim(valorCliente) == ""){
			$("#idCliente").val("");
		}
		if(myTrim(valorCorresponsal) == ""){
			$("#idCadena").val("");
			$("#idSubcadena").val("");
			$("#idCorresponsal").val("");
		}		
	});

	$("#txtCliente").autocomplete({
		source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Clientes/getClientes.php", { "text": request.term },
				function( response ) {
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$(this).val(ui.item.nombre);
				return false;				
			},
			select: function( event, ui ) {
				$("#idCliente").val(ui.item.idCliente);
				$("#nombreCliente").val(ui.item.nombre);
				$("#cuentasPantalla1").attr("action", "2.php");
				$("#tipoBusquedaP2").val(1);
				cambiarPantalla(2);
				return false;				
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>" + "ID: " + item.idCliente + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.appendTo( ul );
		};
	
	if($("#txtCorresponsal").length){
		$("#txtCorresponsal").autocomplete({
			source: function( request, respond ) {
				var idCliente = $("#idCliente").val();
				$.post( BASE_PATH + "/inc/Ajax/_Clientes/getListaCategoria.php",
					{
						idCadena	: "",
						idSubCadena	: idCliente,
						categoria	: 3,
						text		: request.term
					},
					function( response ) {
						respond(response);
					}, "json" );
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#txtCorresponsal").val(ui.item.nombreCorresponsal);
				return false;
			},
			select: function( event, ui ) {
				$("#idCadena").val(ui.item.idCadena);
				$("#idSubcadena").val(ui.item.idSubCadena);
				$("#idCorresponsal").val(ui.item.idCorresponsal);
				$("#cuentasPantalla1").attr("action", "2.php");
				$("#tipoBusquedaP2").val(2);
				cambiarPantalla(2);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
			.appendTo( ul );
		}
	}
	if ( error == "1" ) {
		mostrarError();
	}
}

function initComponentsPantalla2() {
	$("#nuevaBusqueda").on('click', function(){
		nuevaBusqueda();
	});
	$(".configurar").on('click', function(){
		var idBoton = (this.id).split("-");
		var idConfiguracion = idBoton[1];
		configurar(idConfiguracion);
	});
}

function initComponentsPantalla3() {
	$("#txtBeneficiario_1").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 35
	});

	$("#txtBeneficiario_2").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1.',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 35
	});

	$("#txtRFC_1").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	
	$("#txtCorreo_1").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 120
	});
	
	$("#txtReferencia_1").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});	
	
	$("#txtCLABE_1").numeric({
		allowMinus   : false,
		allowThouSep : false
	});
	
	$("#beneficiario_2").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
	$("#txtRFC_2").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	
	$("#txtCorreo_2").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 120
	});

	$("#txtReferencia_2").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	$("#txtCLABE_2").numeric({
		allowMinus   : false,
		allowThouSep : false
	});	
	
	$("#guardar").on("click", function() {
		guardar();
	});
	
	$(".eliminar").on("click", function(){
		var idBoton = (this.id).split("-");
		var idConfiguracion = idBoton[1];
		eliminarConfiguracion( idConfiguracion );
	});
	
	$(".editar").on("click", function(){
		var idBoton = (this.id).split("-");
		var idConfiguracion = idBoton[1];
		desplegarInfoConfiguracion( idConfiguracion );
	});
	
	$("#guardarEdicion").on("click", function(){
		editarConfiguracion();
	});
	
	$("#editarCuentaCliente").on("click", function(){
		desplegarInfoCuentaCliente();
	});
	
	$("#guardarLiquidacionComision").on("click", function(){
		editarLiquidacionComision();
	});
	
	$("#guardarLiquidacionReembolso").on("click", function(){
		editarLiquidacionReembolso();
	});
	
	$("#btnNuevaCuentaBancaria").on("click", function(){
		prepararNuevaCuentaBancaria();
	});
	
	$("#nuevaBusqueda").on('click', function(){
		nuevaBusqueda();
	});	
}

function cambiarPantalla( numeroPantalla ) {
	switch ( numeroPantalla ) {
		case 2:
			$("#cuentasPantalla1").submit();
		break;
	}
}

function nuevaBusqueda() {
	window.location = BASE_PATH + "/_Clientes/Cuentas/1.php";
}

function configurar(idConfiguracion) {
	var numeroCuenta = $("#numeroCuenta-"+idConfiguracion).html();
	var idPropietario = $("#idPropietario-"+idConfiguracion).html();
	var nombrePropietario = $("#nombrePropietario-"+idConfiguracion).val();
	var referenciaBancaria = $("#referenciaBancaria-"+idConfiguracion).html();
	var nombre = $("#nombre").html();
	
	$("#numeroCuentaP2").val(numeroCuenta);
	$("#idPropietarioP2").val(idPropietario);
	$("#nombrePropietarioP2").val(nombrePropietario);
	$("#referenciaBancariaP2").val(referenciaBancaria);
	$("#nombreP2").val(nombre);
	
	$("#cuentasPantalla2").submit();
}

function buscar() {
	var numeroCuenta = $("#txtCuenta").val();
	if ( numeroCuenta == "" ) {
		alert("Es necesario introducir un N\u00FAmero de Cuenta.");
		return false;
	}
	$("#tipoBusquedaP2").val(3); //La busqueda es por Numero de Cuenta
	$("#cuentasPantalla1").attr("action", "3.php");
	$("#cuentasPantalla1").submit();
}

function mostrarError() {
	alert("No se encontraron resultados para el N\u00FAmero de Cuenta.");
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
	
	if ( digitoVerificador == 10 ) {
		digitoVerificador = 0;
	}
	
	return CLABE.charAt(17) == digitoVerificador;
	
}

function guardar() {
	var tipoMovimiento = $("#tipoMovimiento_1").val();
	var tipoInstruccion = $("#tipoInstruccion_1").val();
	var referencia = $("#txtReferencia_1").val();
	var CLABE = $("#txtCLABE_1").val();
	var beneficiario = $("#txtBeneficiario_1").val();
	var RFC = $("#txtRFC_1").val();
	var correo = $("#txtCorreo_1").val();
	
	if ( CLABE == "" ) {
		alert("Es necesario introducir una CLABE.");
		return false;
	} else {
		if ( CLABE.length == 18 ) {
			var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
			if ( !CLABE_EsCorrecta ) {
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
				return false;
			}
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			return false;
		}
	}

	if ( beneficiario == "" ) {
		alert("Es necesario introducir un Beneficiario.");
		return false;
	}	

	if ( correo == "" ) {
		alert("Es necesario introducir un Correo.");
		return false;
	}

	if ( correo != "" ) {
		if ( !validarEmail("txtCorreo_1") ){
			alert("El formato del Correo es incorrecto. Favor de verificarlo.");
			return false;
		}
	}
	
	if ( !validaRFC("txtRFC_1") ) {
		alert("El formato del RFC es incorrecto. Favor de verificarlo.");
		return false;
	}
	
	if ( referencia != "" && referencia.length < 5 ) {
		alert("La Referencia debe tener al menos 5 caracteres.");
		return false;
	}

	$.post( BASE_PATH + "/inc/Ajax/_Clientes/crearAltaCuentaBanco.php",
	{
		numeroCuenta: numeroCuenta,
		tipoMovimiento: tipoMovimiento,
		tipoInstruccion: tipoInstruccion,
		referencia: referencia,
		CLABE: CLABE,
		beneficiario: beneficiario,
		RFC: RFC,
		correo: correo
	},
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#nueva").modal("hide");
			$("#datosPantalla3").submit();
		} else {
			alert(respuesta.mensaje);
		}
	}, "json");
}

function eliminarConfiguracion( indice ) {
	var eliminar = confirm("\u00BFEst\u00E1 que desea eliminar?");
	if ( eliminar ) {
		var idConfiguracion = $("#idConfCuenta-"+indice).val();
		$.post( BASE_PATH + "/inc/Ajax/_Clientes/eliminarCuentaBanco.php",
		{
			idConfiguracion: idConfiguracion
		},
		function( respuesta ) {
			if ( respuesta.codigo == 0 ) {
				$("#datosPantalla3").submit();
			} else {
				alert(respuesta.mensaje);
			}
		}, "json");
	}
}

function desplegarInfoConfiguracion( indice ) {
	var idTipoInstruccion = $("#idTipoInstruccion-"+indice).val();
	var CLABE = $("#CLABE-"+indice).html();
	var beneficiario = $("#beneficiario-"+indice).html();
	var RFC = $("#RFC-"+indice).html();
	var correo = $("#correo-"+indice).html();
	var idConfCuenta = $("#idConfCuenta-"+indice).val();
	var idConfCuentaBanco = $("#idConfCuentaBanco-"+indice).val();
	var referencia = $("#referencia-"+indice).val();

	$("#tipoInstruccion_2").val(idTipoInstruccion);

	$("#txtCLABE_2").val(CLABE);
	$("#txtBeneficiario_2").val(beneficiario);
	$("#txtRFC_2").val(RFC);
	$("#txtCorreo_2").val(correo);
	$("#txtReferencia_2").val(referencia);
	configuracionCuenta = idConfCuenta;
	configuracionCuentaBanco = idConfCuentaBanco;
	
	
}

function editarConfiguracion() {
	var tipoMovimiento = $("#tipoMovimiento_2").val();
	var tipoInstruccion = $("#tipoInstruccion_2").val();
	var CLABE = $("#txtCLABE_2").val();
	var beneficiario = $("#txtBeneficiario_2").val();
	var RFC = $("#txtRFC_2").val();
	var correo = $("#txtCorreo_2").val();
	var referencia = $("#txtReferencia_2").val();

	
	if ( CLABE == "" ) {
		alert("Es necesario introducir una CLABE.");
		return false;
	} else {
		if ( CLABE.length == 18 ) {
			var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
			if ( !CLABE_EsCorrecta ) {
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
				return false;
			}
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			return false;
		}
	}
	
	if ( beneficiario == "" ) {
		alert("Es necesario introducir un Beneficiario.");
		return false;
	}
	
	if ( correo == "" ) {
		alert("Es necesario introducir un Correo.");
		return false;
	}
	
	if ( correo != "" ) {
		if ( !validarEmail("txtCorreo_2") ){
			alert("El formato del Correo es incorrecto. Favor de verificarlo.");
			return false;
		}
	}
	
	if ( !validaRFC("txtRFC_2") ) {
		alert("El formato del RFC es incorrecto. Favor de verificarlo.");
		return false;
	}
	
	if ( referencia != "" && referencia.length < 5 ) {
		alert("La Referencia debe tener al menos 5 caracteres.");
		return false;
	}
	
	$.post( BASE_PATH + "/inc/Ajax/_Clientes/editarCuentaBanco.php",
	{
		tipoInstruccion: tipoInstruccion,
		tipoMovimiento: tipoMovimiento,
		numeroCuenta: numeroCuenta,
		CLABE: CLABE,
		beneficiario: beneficiario,
		RFC: RFC,
		referencia: referencia,
		correo: correo,
		idConfCuenta: configuracionCuenta,
		idConfCuentaBanco: configuracionCuentaBanco
	},
	function( respuesta ) {
		if( respuesta.codigo == 0 ) {
			$("#edicion").modal("hide");
			$("#datosPantalla3").submit();			
		} else {
			alert(respuesta.mensaje);
		}
	}, "json");
}

function desplegarInfoCuentaCliente() {
	$("#destinoLiquidacionComision").val(idTipoLiqComision);
	$("#destinoLiquidacionReembolso").val(idTipoLiqReembolso);
	$("#mensajeExito").css("display", "none");
	if ( idIVA == 1 ) {
		$("#conIVA").prop('checked', true);
	} else if ( idIVA == 2 ) {
		$("#sinIVA").prop('checked', true);
	}
}

function editarLiquidacionComision() {
	var destinoLiquidacionComision = $("#destinoLiquidacionComision").val();
	var IVA = $('input[name="iva"]:checked').val();
	var numeroCuenta = $("#numCuentaLabel").html();
	$("#mensajeExito").css("display", "none");
	
	if (!IVA) {
		alert("Es necesario seleccionar un IVA.");
		return false;
	}	
	
	$.post( BASE_PATH + "/inc/Ajax/_Clientes/editarCuentaCliente.php",
	{
		destino: destinoLiquidacionComision,
		IVA: IVA,
		tipoActualizacion: 1, //Comision
		numeroCuenta: numeroCuenta,
		idPropietario: idPropietario,
		tipoCuenta: tipoCuenta
	},
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#mensajeExito").css("display", "block");
			$("#datosPantalla3").submit();	
		} else {
			$("#mensajeExito").css("display", "none");
			alert(respuesta.mensaje);
		}
	}, "json");	
}

function editarLiquidacionReembolso() {
	var destinoLiquidacionReembolso = $("#destinoLiquidacionReembolso").val();
	var numeroCuenta = $("#numCuentaLabel").html();
	$("#mensajeExito").css("display", "none");

	$.post( BASE_PATH + "/inc/Ajax/_Clientes/editarCuentaCliente.php",
	{
		destino: destinoLiquidacionReembolso,
		tipoActualizacion: 2, //Reembolso
		numeroCuenta: numeroCuenta
	},
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#mensajeExito").css("display", "block");
			$("#datosPantalla3").submit();	
		} else {
			$("#mensajeExito").css("display", "none");
			alert(respuesta.mensaje);
		}
	}, "json");		
}

function prepararNuevaCuentaBancaria() {
	$("#tipoMovimiento_1").val(0);
	$("#tipoInstruccion_1").val(-1);
	$("#txtCLABE_1").val("");
	$("#txtBeneficiario_1").val("");
	$("#txtRFC_1").val("");
	$("#txtCorreo_1").val("");
}