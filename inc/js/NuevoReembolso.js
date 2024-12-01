var existeCLABE;
var global_idCliente;
var global_idCadena;
var global_idSubcadena;
var global_idCorresponsal;

function initComponents() {
	$("#beneficiario").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
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
			$("#idCliente").val(-1);
		}
		if(myTrim(valorCorresponsal) == ""){
			$("#idCadena").val(-1);
			$("#idSubcadena").val(-1);
			$("#idCorresponsal").val(-1);
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
}

function buscar() {
	var idCliente = $("#idCliente").val();
	var idCadena = $("#idCadena").val();
	var idSubcadena = $("#idSubcadena").val();
	var idCorresponsal = $("#idCorresponsal").val();
	$.post( BASE_PATH + "/inc/Ajax/_Clientes/buscarInfoCuenta.php",
	{
		idCliente: idCliente,
		idCadena: idCadena,
		idSubcadena: idSubcadena,
		idCorresponsal: idCorresponsal
	}, function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#nombre").html("Nombre: " + respuesta.nombreCliente);
			$("#cuenta").html("Cuenta: " + respuesta.numeroCuenta);
			$("#forelo").html("FORELO: " + respuesta.nombreForelo);
			if ( respuesta.RFC != null || respuesta.RFC == "" ) {
				$("#txtRFC").val(respuesta.RFC);
				$("#txtRFC").prop('disabled', true);
			} else {
				$("#txtRFC").val("");
				$("#txtRFC").prop('disabled', false);				
			}
			if ( respuesta.destino == null || respuesta.destino == "" || respuesta.destino == 0 ) {
				$("#destinoLiquidacion").val(0);
			} else if ( respuesta.destino > 0 ) {
				$("#destinoLiquidacion").val(1);
			}			
			if ( respuesta.Correo != "" ) {
				$("#txtCorreo").val(respuesta.Correo);
			} else {
				$("#txtCorreo").val("");
			}
			if ( respuesta.existeCLABE == 1 ) {
				$("#txtCLABE").val(respuesta.CLABE);
				$("#txtCLABE").prop('disabled', true);
				if ( respuesta.beneficiario ) {
					$("#beneficiario").val(respuesta.beneficiario);
				}
			} else {
				$("#txtCLABE").val("");
				$("#txtCLABE").prop('disabled', false);
				$("#beneficiario").val("");
			}
			existeCLABE = respuesta.existeCLABE;
			global_idCliente = respuesta.idCliente;
			global_idCadena = respuesta.idCadena;
			global_idSubcadena = respuesta.idSubcadena;
			global_idCorresponsal = respuesta.idCorresponsal;
			$("#numeroCuenta").val(respuesta.numeroCuenta);
			$("#tablaResultado").removeClass("resultadoBusqueda");
			$("#filtrosResultado").css("display", "inline-block");
			$("#guardar").removeClass("botonGuardar");
		} else {
			$("#tablaResultado").addClass("resultadoBusqueda");
			$("#filtrosResultado").css("display", "none");
			$("#guardar").addClass("botonGuardar");
			alert(respuesta.mensaje);
		}
	}, "json");
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

function crearConfiguracion() {
	var destinoLiquidacion = $("#destinoLiquidacion").val();
	var CLABE = $("#txtCLABE").val();
	var beneficiario = $("#beneficiario").val();
	var RFC = $("#txtRFC").val();
	var correo = $("#txtCorreo").val();
	var numeroCuenta = $("#numeroCuenta").val();
	var RFC = $("#txtRFC").val();
	var correo = $("#txtCorreo").val();
	
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
	
	if ( correo != "" ) {
		if ( !validarEmail("txtCorreo") ){
			alert("El formato del Correo es incorrecto. Favor de verificarlo.");
			return false;
		}
	}
	
	if ( !validaRFC("txtRFC") ) {
		alert("El formato del RFC es incorrecto. Favor de verificarlo.");
		return false;
	}
	
	$.post( BASE_PATH + "/inc/Ajax/_Clientes/guardarConfiguracionCuenta.php",
		{
			destinoLiquidacion: destinoLiquidacion,
			CLABE: CLABE,
			beneficiario: beneficiario,
			existeCLABE: existeCLABE,
			RFC: RFC,
			correo: correo,
			numeroCuenta: numeroCuenta,
			RFC: RFC,
			correo: correo,
			idCliente: global_idCliente,
			idCadena: global_idCadena,
			idSubcadena: global_idSubcadena,
			idCorresponsal: global_idCorresponsal
		},
		function( respuesta ) {
			if ( respuesta.codigo == 0 ) {
				alert(respuesta.mensaje);
				$("#tablaResultado").addClass("resultadoBusqueda");
				$("#filtrosResultado").css("display", "none");
				$("#tablaResultado").addClass("resultadoBusqueda");
				$("#filtrosResultado").css("display", "none");
				$("#txtRFC").val("");
				$("#txtRFC").prop("disabled", false);
				$("#txtCLABE").val("");
				$("#txtCLABE").prop("disabled", false);
				$("#beneficiario").val("");
				$("#txtCorreo").val("");
				$("#destinoLiquidacion").val(0);
				$("#guardar").addClass("botonGuardar");
			} else {
				alert(respuesta.mensaje);
			}
		}
	, "json");
}