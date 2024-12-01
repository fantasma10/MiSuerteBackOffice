$(document).ready(function(){
    initInputFiles();
     $('#closepdf').click(function(){$('#pdfvisor').css('display','none')});
//dejen de joder
});

var rfccte = "";

function initConsultaCliente(){
	loadCliente(ID_CLIENTE);
	$(":input").bind('paste', function(){return false;});

	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	// inicializacion de campos para los contactos
	$("#HidContacto").val(-2);
	//$("#txtTelContac").prop('maxlength', 20);
	$("#txtContacNom, #txtContacAP, #txtContacAM").alphanum({
		allow					: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets		: false
	});

	$("#txtContacNom").prop('maxlength', 100);
	$("#txtContacAP").prop('maxlength', 50);
	$("#txtMailContac").alphanum({
		allow				: '@-_.',
		allowNumeric		: true,
		maxLength			: 100,
		allowOtherCharSets	: false
	});
	$("[name='dirfNumeroexterior']").prop('maxlength', 50);
	$("[name='maternoRepLegal']").prop('maxlength', 50);
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeTipoContacto.php", 'ddlTipoContac', {}, {text : 'descTipoContacto', value : 'idTipoContacto'}, {});
}

function loadCliente(idCliente){
	$("[name^='familia']").addClass('deny');
	$.post(BASE_PATH + '/inc/Ajax/_Clientes/ConsultaCliente/loadCliente.php',
		{
			idCliente : idCliente
		},
		function(response){
        
       // console.log(response);
        
       rfccte = response.data.rfcCliente;
        console.log(rfccte);
			if(response.success == true){
				GLOBAL_DATA = response.data;
				cargarInfoCliente(response.data);
				if ( response.data.familias != null ) {
					var familias = response.data.familias;
					var fams = familias.split(",");
					var rem = false;
					var ban1 = false;
					$.each(fams, function(index, item, obj){
						$("[name='familia"+item+"']").removeClass('deny');
						if(item == 3){
							ban1 = true;
						}
						if((item == 5 || item == 7)){
							rem = true;
						}
					});
					
					if (ban1){
						$("#txtEjecutivoAfAv").prop('disabled', false);
					}else{
						$("#txtEjecutivoAfAv").prop('disabled', true);
					}
					if (rem){
						$("#txtEjecutivoAfIn").prop('disabled', false);
					}else{
						$("#txtEjecutivoAfIn").prop('disabled', true);	
					}
						
				}

				if(response.data.idRegimen == 1){
					$('.personamoral').prop('readonly', true);
					$('.personafisica').prop('readonly', false);
				}
				if(response.data.idRegimen == 2){
					$('.personamoral').prop('readonly', false);
					$('.personafisica').prop('readonly', true);
				}
				if(response.data.idRegimen == 3){
					$('.personamoral').prop('readonly', false);
					$('.personafisica').prop('readonly', false);
				}

				$('body').trigger('clienteloaded');
			}
		},
		"json"
	);
}

function cargarInfoCliente(data){
	if ( data.correo == "" || data.correo == null ) {
		data.correo = "No tiene";
	}
	if ( data.numCuenta == "" || data.numCuenta == null ) {
		data.numCuenta = "No tiene";
	}
	$("#formDireccion [name='idDireccion']").val(data.idDireccion);
	$("#formDireccion [name='idRepresentanteLegal']").val(data.idRepresentanteLegal);
	simpleFillHtmlByName(data, '');
	
}

function cargarDatosGenerales(){
	$('body').on('datosGeneralesIniciados', function(){
		if ( GLOBAL_DATA.correo == "No tiene" ) {
			GLOBAL_DATA.correo = "";
		}
		simpleFillForm(GLOBAL_DATA, 'formGenerales');
		$("#cmbGrupo").on('gruposloaded', function(){
			$(this).val(GLOBAL_DATA.idGrupo);
		});
		$("#cmbRegimen").on('regimenloaded', function(){
			$(this).val(GLOBAL_DATA.idRegimen);
		});
		$("#cmbGiro").on('giroloaded', function(){
			$(this).val(GLOBAL_DATA.idGiro);
		});
		$("#cmbReferencia").on('referencialoaded', function(){
			$(this).val(GLOBAL_DATA.idReferencia);
		});
	});
}

GLOBAL_DATOSGENERALES_INICIADOS = false;
function initDatosGenerales(event){
	// cargar store de grupos
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeGrupos.php", "cmbGrupo", {}, {text : 'nombreGrupo', value : "idGrupo"}, {}, 'gruposloaded');
	// cargar store de regimen fiscal
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeRegimen.php", "cmbRegimen", {}, {text : 'nombre', value : "idTipoRegimen"}, {}, 'regimenloaded');
	// cargar store giro
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeGiros.php", "cmbGiro", {}, {text : 'nombreGiro', value : "idGiro"}, {}, 'giroloaded');
	// cargar store de referencias
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeReferencias.php", "cmbReferencia", {}, {text : 'nombreReferencia', value : "idReferencia"}, {}, 'referencialoaded');
	// iniciar los datos generales
	if(GLOBAL_DATOSGENERALES_INICIADOS == true){
		$('body').trigger('datosGeneralesIniciados');
		event.preventDefault();
		return false;
	}

	$(":input").bind('paste', function(){return false;});

	$("#txtRFC").prop('maxlength', 13);
	$("#txtRFC").attr('style', 'text-transform: uppercase;');

	$("#txtRFC").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	$("[name='razonSocial']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ.-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 200
	});

	$("[name='nombreCliente']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$("[name='paternoCliente'], [name='maternoCliente']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$('#txttelefono').prop('maxlength', 20);
	/*$('#txttelefono').alphanum({
		allowOtherCharSets : false
	});*/

	$("[name='correo']").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 150
	});

	$('#cmbRegimen').on('change', function(event){
		var value = event.target.value;

		if(value == 1){
			$('.personafisica').prop('readonly', false);
			$('.personamoral').prop('readonly', true);
			$('.personamoral').val('');
			$('#txtRFC').prop('maxLength', 13);
		}
		if(value == 2){
			$('.personamoral').prop('readonly', false);
			$('.personafisica').prop('readonly', true);
			$('.personafisica').val('');
			$('#txtRFC').prop('maxLength', 12);
		}
		if(value == 3){
			$('.personamoral, .personafisica').val('');
			$('.personamoral').prop('readonly', false);
			$('.personafisica').prop('readonly', false);
			$('#txtRFC').prop('maxLength', 12);
		}
		if(value == -1){
			$('.personafisica, .personamoral').prop('readonly', true);
			$('.personamoral, .personafisica').val('');
		}
	});


	tipoRFC = 0;
	$("[name='razonSocial']").on('keyup', function(event){
		var valor = event.target.value;

		if(valor.trim() != ""){
			tipoRFC = 2;
			$("[name='nombreCliente'], [name='paternoCliente'], [name='maternoCliente']").val('');
			$("[name='nombreCliente'], [name='paternoCliente'], [name='maternoCliente']").prop('readonly', true);

			$('#txtRFC').prop('maxLength', 12);
		}
		else{
			tipoRFC = 0;
			$("[name='nombreCliente'], [name='paternoCliente'], [name='maternoCliente']").prop('readonly', false);
		}
	});


	$("[name='nombreCliente'], [name='paternoCliente'], [name='maternoCliente']").on('keyup', function(event){
		var valor = event.target.value;

		var valor1 = $("[name='nombreCliente']").val();
		var valor2 = $("[name='paternoCliente']").val();
		var valor3 = $("[name='maternoCliente']").val();

		if(valor1.trim() != "" || valor2.trim() || valor3.trim()){
			tipoRFC = 1;
			$("[name='razonSocial']").val('');
			$("[name='razonSocial']").prop('readonly', true);

			$('#txtRFC').prop('maxLength', 13);
		}
		else{
			tipoRFC = 0;
			$("[name='razonSocial']").prop('readonly', false);
		}
	});

	$("#txtEjecutivoCuenta, #txtEjecutivoVenta, #txtEjecutivoAfIn, #txtEjecutivoAfAv").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets	: false
	});

	if($("#txtEjecutivoCuenta").length){
		autoCompletaEjecutivos("txtEjecutivoCuenta", 5, "idEjecutivoCuenta");

		var txtejecutivo = $("#txtEjecutivoCuenta");

		$(txtejecutivo).keypress(function(event) {
			return validaCadenaConAcentos(event);
		});

		$(txtejecutivo).bind("paste", function(){return false;})
	}

	if($("#txtEjecutivoVenta").length){
		autoCompletaEjecutivos("txtEjecutivoVenta", 2, "idEjecutivoVenta");
	}
	// Remesas y Sorteos
	if($("#txtEjecutivoAfIn").length){
		autoCompletaEjecutivos("txtEjecutivoAfIn", 9, "idEjecutivoAfiliacionInter");
	}
	// Bancarios
	if($("#txtEjecutivoAfAv").length){
		autoCompletaEjecutivos("txtEjecutivoAfAv", 10, "idEjecutivoAfiliacionAvanz");
	}
	$("#txtEjecutivoVenta").on('keyup', function(event){
		var valor = event.target.value;
		if(valor.trim() == ""){
			$("#idEjecutivoVenta").val("");
		}
	});
	$("#txtEjecutivoCuenta").on('keyup', function(event){
		var valor = event.target.value;
		if(valor.trim() == ""){
			$("#idEjecutivoCuenta").val("");
		}
	});	
	$("#txtEjecutivoAfIn").on('keyup', function(event){
		var valor = event.target.value;
		if(valor.trim() == ""){
			$("#idEjecutivoAfiliacionInter").val("");
			var idEjecutivoCuenta = $("#idEjecutivoAfiliacionInter").val();
		}
	});
	$("#txtEjecutivoAfAv").on('keyup', function(event){
		var valor = event.target.value;
		if(valor.trim() == ""){
			$("#idEjecutivoAfiliacionAvanz").val("");
			var idEjecutivoVenta = $("#idEjecutivoAfiliacionAvanz").val();
		}
	});
	$('body').trigger('datosGeneralesIniciados');
	GLOBAL_DATOSGENERALES_INICIADOS = true;
	
}

function guardarDatosGenerales(event){
	var deshabilitados = $(":disabled");
	$(deshabilitados).prop("disabled", false);
	
	var params = getParams($("#formGenerales").serialize());
	deshabilitados.prop("disabled", true);

	var lack = "";
	var error = "";

	// validaciones de datos generales
	if(params.idGrupo <= -1 || myTrim(params.idGrupo) == ""){
		lack += "- Grupo\n";
	}
	if(params.idReferencia <= 0 || myTrim(params.idReferencia) == ""){
		lack += "- Referencia\n";
	}
	//alert("TEST A");
	if(params.idRegimen == null){
		alert("TEST X")
		lack += "- R\u00E9gimen Fiscal \n";
	}
	//alert("TEST B");
	if(params.idRegimen == null){
		if(params.idRegimen <= 0 || myTrim(params.idRegimen) == ""){
			lack += "- R\u00E9gimen Fiscal \n";
		}
		else{
			switch(params.idRegimen){
				case '1':
					if(myTrim(params.nombreCliente) == ""){
						lack += "- Nombre\n";
					}
					if(myTrim(params.paternoCliente) == ""){
						lack += "- Apellido Paterno\n";
					}
					if(myTrim(params.maternoCliente) == ""){
						lack += "- Apellido Materno\n";
					}
				break;
	
				case '2':
					if(myTrim(params.razonSocial) == ""){
						lack += "- Raz\u00F3n Social\n";
					}
				break;
			}
		}
	}
	//alert("TEST C");
	if(myTrim(params.rfcCliente) == ""){
		lack += "- RFC \n";
	}
	else{
		var r = myTrim(params.rfcCliente);

		if(params.idRegimen != -1){
			switch(params.idRegimen){
				case '1':
					if(r.length < 13 || r.length > 13){
						error += "- El RFC debe ser de 13 caracteres\n";
					}
				break;

				case '2':
					if(r.length < 12 || r.length > 12){
						error += "- El RFC debe ser de 12 caracteres\n";
					}
				break;

				case '3':
					if(tipoRFC == 1){
						if(r.length < 13 || r.length > 13){
							error += "- El RFC debe ser de 13 caracteres\n";
						}
					}
					else if(tipoRFC == 2){
						if(r.length < 12 || r.length > 12){
							error += "- El RFC debe ser de 12 caracteres\n";
						}
					}
				break;
			}

			if(!validaRFC('txtRFC')){
				error += "- El RFC es Incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral\n";
			}
		}
	}
	//alert("TEST D");
	if(params.idGiro <= -1 || myTrim(params.idGiro) == ""){
		lack += "- Giro\n";
	}
	if(myTrim(params.telefono) == ""){
		lack += "- Tel\u00E9fono\n";
	}
	else{
		if(!validaTelefono("txttelefono")){
			error += "- Introduzca un Tel\u00E9fono v\u00E1lido \n";
		}
	}
	if(myTrim(params.correo) == ""){
		lack += "- Correo\n";
	}
	else{
		if(!validarEmail('txtemail')){
			error += "- El formato de Correo es Incorrecto\n";
		}
	}


	// validaciones de ejecutivos
	/*if(params.idEjecutivoVenta == undefined || params.idEjecutivoVenta < 0){
		lack += "- Ejecutivo de Venta \n";
	}*/
	if(params.idEjecutivoCuenta == undefined || params.idEjecutivoCuenta < 0 || params.idEjecutivoCuenta == ""){
		lack += "- Ejecutivo de cuenta \n";
	}
	/*if(params.idEjecutivoAfiliacionInter == undefined || params.idEjecutivoAfiliacionInter < 0){
		lack += "- Ejecutivo de Remesas y Sorteos \n";
	}
	if(params.idEjecutivoAfiliacionAvanz == undefined || params.idEjecutivoAfiliacionAvanz < 0){
		lack += "- Ejecutivo Bancario \n";
	}*/
	// form invalido
	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		var berror = (error != "")? "Los siguientes datos son Incorrectos : " : "";
		alert(black + "\n " + lack + "\n" + "\n" + berror + " \n " + error);
		event.preventDefault();
	}
	else{
		params.idCliente = ID_CLIENTE;
		$.post(BASE_PATH + '/inc/Ajax/_Clientes/ConsultaCliente/guardarDatosGenerales.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				$("#datos").modal('hide');
				loadCliente(ID_CLIENTE);
				$("body").on('clienteloaded', function(){
					$("#txtEjecutivoVenta").autocomplete("search", "");
					$("#txtEjecutivoCuenta").autocomplete("search", "");
					$("#txtEjecutivoAfIn").autocomplete("search", "");
					$("#txtEjecutivoAfAv").autocomplete("search", "");
				});
				//$("#txtEjecutivoAfIn").autocomplete("search", "");
			},
			"json"
		);
	}
}


function cargarDireccion(){
	$('body').on('direccioniniciada', function(){
		console.log('cargandodireccion');
		console.log(GLOBAL_DATA);
		console.log($("#formDireccion"));
		simpleFillForm(GLOBAL_DATA, 'formDireccion');

		$("#cmbEstado").on('estadosloaded', function(){
			//alert("dirfIdEstado: " + dirfIdEstado);
			$(this).val(GLOBAL_DATA.dirfIdEstado);
		});

		$("#cmbMunicipio").on('municipiosloaded', function(){
			//alert("dirfIdMunicipio: " + dirfIdMunicipio);
			$(this).val(GLOBAL_DATA.dirfIdMunicipio);
		});		

		cargarEstados(GLOBAL_DATA.dirfIdPais);
		cargarMunicipios(GLOBAL_DATA.dirfIdPais, GLOBAL_DATA.dirfIdEstado);

		$.post(BASE_PATH + '/inc/Ajax/_Clientes/buscarColonia.php',
			{
				codigoPostal : GLOBAL_DATA.dirfCodigo_postal
			},
			function(response){
				if(response.codigoDeRespuesta == 0){
					$("#cmbColonia").on('coloniascargadas', function(){
						$(this).val(GLOBAL_DATA.dirfIdColonia);
					});
					appendList("cmbColonia", response.listaColonias, {text :'nombreColonia', value : 'idColonia'}, 'coloniascargadas');
				}
				else{
					limpiaStore("cmbEstado");
					limpiaStore("cmbMunicipio");
					limpiaStore("cmbColonia");
				}
			},
			"json"
		);
	});
}

GLOBAL_DIRECCION_INICIADA = false;
function initDireccion(){
	if(GLOBAL_DIRECCION_INICIADA == true){
		$('body').trigger('direccioniniciada');
	}

	$('#cmbEstado, #cmbMunicipio').prop('disabled', true);

	$("[name='dirfCalle']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='dirfNumerointerior']").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='dirfNumeroexterior']").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#txtPais").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets	: false,
		allowNumeric		: false
	});

	$("#txtCalle").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets	: false,
		allowNumeric		: true
	});

	$("#txtCP").prop('maxlength', 5);
	$("#txtCP").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#txtCP").on('keyup', function(event){
		var value = event.target.value;
		value = value.trim();
		if(value.length == 5){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/buscarColonia.php',
				{
					codigoPostal : value
				},
				function(response){
					if(response.codigoDeRespuesta == 0){
						$('#cmbEstado').on('estadosloaded', function(){
							$("#cmbEstado").val(response.idEntidad);
						});

						$('#cmbMunicipio').on('municipiosloaded', function(){									   
							$("#cmbMunicipio").val(response.idCiudad);
						});
						console.log($("#idPais").val());
						cargarEstados($("#idPais").val());
						cargarMunicipios($("#idPais").val(), response.idEntidad);
						//cargarColonias($('#idPais').val(), response.idEntidad, response.idCiudad);
						appendList("cmbColonia", response.listaColonias, {text :'nombreColonia', value : 'idColonia'});
					}
					else{
						limpiaStore("cmbEstado");
						limpiaStore("cmbMunicipio");
						limpiaStore("cmbColonia");

						alert(response.mensajeDeRespuesta);
					}
				},
				"json"
			);
		}
		else if(value.length == 0){
			$("#cmbEstado, #cmbMunicipio, #cmbColonia").val(-1);
			limpiaStore("cmbEstado");
			limpiaStore("cmbMunicipio");
			limpiaStore("cmbColonia");
		}
	});

	$("#txtCalle").on('keyup', function(event){
		var valor = event.target.value;

		if(valor.trim() == ""){
			//$("#formDireccion").get(0).reset();
			$("#idDireccion").val(0);
		}
	});

	$("#txtPais").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'txt' : 'id'};

		if(valor == ""){
			$("#" +arr[tip] + last).val(-1);
		}
	});

	autoCompletaGeneral('txtPais', 'idPais', BASE_PATH + '/inc/Ajax/_Clientes/getPaises.php', 'label', 'idPais', {}, null);
	autoCompletarCalle();

	$("#formDireccion :input").on('change', function(){
		var idDireccion = $("#formDireccion [name='idDireccion']").val();
		if ( idDireccion == "" ) {
			$("#formDireccion [name='idDireccion']").val(0);
		}
		$("#formDireccion [name='idDireccion']").val(0);
	});

	$('body').trigger('direccioniniciada');
	GLOBAL_DIRECCION_INICIADA = true;
}

function guardarDireccion(event){
	var deshabilitados = $(":disabled");
	$(deshabilitados).prop("disabled", false);
	
	var params = getParams($("#formDireccion").serialize());
	params.dirfCalle			= $("#txtCalle").val();
	params.dirfNumeroexterior	= $("[name='dirfNumeroexterior']").val();
	params.dirfCodigo_postal	= $("[name='dirfCodigo_postal']").val();
	
	deshabilitados.prop("disabled", true);
	

	var lack	= "";
	var error	= "";

	if(params.dirfIdPais <= 0 || myTrim(params.dirfIdPais) == ""){
		lack += "- Pa\u00EDs\n";
	}
	if(myTrim(params.dirfCalle) == ""){
		lack += "- Calle\n";
	}
	/*if(myTrim(params.numeroIntDireccion) == ""){
		lack += "- N\u00FAmero Interior\n";
	}*/
	if(myTrim(params.dirfNumeroexterior) == ""){
		lack += "- N\u00FAmero Exterior\n";
	}
	/*if(myTrim(params.numeroExtDireccion) == ""){
		lack += "- N\u00FAmero Exterior\n";
	}*/
	if(myTrim(params.dirfCodigo_postal) == ""){
		lack += "- C\u00F3digo Postal\n";
	}
	if(params.dirfIdColonia <= 0 || myTrim(params.dirfIdColonia) == "" || params.dirfIdColonia == undefined){
		lack += "- Colonia\n";
	}
	if(params.dirfIdEstado <= 0 || myTrim(params.dirfIdEstado) == "" || params.dirfIdEstado == undefined){
		lack += "- Estado\n";
	}
	if(params.dirfIdMunicipio <= 0 || myTrim(params.dirfIdMunicipio) == "" || params.dirfIdMunicipio == undefined){
		lack += "- Ciudad\n";
	}

	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		var berror = (error != "")? "Los siguientes datos son Incorrectos : " : "";
		alert(black + "\n " + lack + "\n" + "\n" + berror + " \n " + error);
		event.preventDefault();
	}
	else{
		params.idCliente = ID_CLIENTE;
		$.post(BASE_PATH + "/inc/Ajax/_Clientes/ConsultaCliente/guardarDireccion.php",
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					$("#formDireccion [name='idDireccion']").val(response.idDireccion);
					$("#direccion").modal('hide');
					loadCliente(params.idCliente);
					$("body").on("clienteloaded", function(){
						$("#txtCalle").autocomplete("search","");
					});
				}
			},
			"json"
		);
	}
}

function cargarEstados(idPais){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeEstados.php", "cmbEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
}

function cargarMunicipios(idPais, idEstado){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeMunicipios.php", "cmbMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
}

function autoCompletaEjecutivos(txtField, idTipoEjecutivo, idField){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post( "../../inc/Ajax/BuscaEjecutivos.php",
			{
				idTipoEjecutivo	: idTipoEjecutivo,
				texto			: request.term
			},
			function( response ) {
				//console.log(response);
				//console.log(respond(response));
				respond(response);
			}, "json" );					
		},
		minLength: 1,
		focus: function( event, ui ) {
			$("#"+txtField).val(ui.item.nombreCompleto);
			return false;
		},
		select: function( event, ui ) {
			$("#"+ idField).val(ui.item.idUsuario);
			return false;
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		return $( '<li>' )
		.append( "<a>" + item.nombreCompleto + "</a>" )
		.appendTo( ul );
	};
}

function autoCompletarCalle(){
	$("#txtCalle").autocomplete({
		source: function( request, respond ) {
			$.post(BASE_PATH + '/inc/Ajax/_Afiliaciones/getDireccion.php',
				{term : request.term}
			,
			function( response ) {
				if(!response.data){
					respond(response);
				}
				else{
					respond(response.data);
				}
			}, "json" );				
		},
		minLength: 1,
		focus: function( event, ui ) {
			var select = ui.item.calleDireccion;
			$("#txtCalle").val(select);
			$("#idDireccion").val("");
			return false;
		},
		select: function( event, ui ) {
			var id = ui.item.idDireccion;
			$("#formDireccion [name='idDireccion']").val(id);

			simpleFillForm(ui.item, "formDireccion", "");

			var estado = new Array();
			estado.push({idEstado : ui.item.idEntidad, nombreEstado : ui.item.nombreEntidad});
			$("#cmbEstado").on('estado', function(){
				$(this).val(ui.item.idEntidad);
			});
			appendList("cmbEstado", estado, {text : 'nombreEstado', value : 'idEstado'}, 'estado');

			var municipio = new Array();
			municipio.push({idMunicipio : ui.item.idcMunicipio, nombreMunicipio : ui.item.nombreMunicipio});
			$("#cmbMunicipio").on('municipio', function(){
				$(this).val(ui.item.idcMunicipio);
			});
			appendList("cmbMunicipio", municipio, {text : 'nombreMunicipio', value : 'idMunicipio'}, 'municipio');

			var colonia = new Array();
			colonia.push({idColonia : ui.item.idcColonia, nombreColonia : ui.item.nombreColonia});
			$("#cmbColonia").on('colonia', function(){
				$(this).val(ui.item.idcColonia);
			});
			appendList("cmbColonia", colonia, {text : 'nombreColonia', value : 'idColonia'}, 'colonia');
			
			$("#txtCP").val(ui.item.cpDireccion);
			
			$("#formDireccion [name='dirfNumeroexterior']").val(ui.item.numeroExtDireccion);
			$("#formDireccion [name='dirfNumerointerior']").val(ui.item.numeroIntDireccion);
			
			return false;
		},
		close: function(event, ui){
			var valorId = $("#formDireccion [name='idDireccion']").val();
			if(valorId == "" || valorId == undefined){
				$("#txtCalle").val("");
			}
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + item.calleDireccion + "</a>" )
		.appendTo( ul );
	};
}


function cargarRepresentanteLegal(){
	$('body').on('representanteiniciado', function(){										   
		simpleFillForm(GLOBAL_DATA, 'formRepresentante');

		$("#cmbIdent").on('tipoidentloaded', function(){
			$(this).val(GLOBAL_DATA.idTipoIdent);
		});

		if(GLOBAL_DATA.figPolitica == 1){
			$("#formRepresentante [name='figPolitica']").prop('checked', true);
		}
		else{
			$("#formRepresentante [name='figPolitica']").prop('checked', false);
		}
		if(GLOBAL_DATA.famPolitica == 1){
			$("#formRepresentante [name='famPolitica']").prop('checked', true);
		}
		else{
			$("#formRepresentante [name='famPolitica']").prop('checked', false);
		}
	});
}

GLOBAL_REPRESENTANTE_INICIADO = false;
function initRepresentanteLegal(){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeTipoIdentificacion.php", "cmbIdent", {}, {text : 'descTipoIdentificacion', value : 'idTipoIdentificacion'}, {}, 'tipoidentloaded');

	if(GLOBAL_REPRESENTANTE_INICIADO == true){
		$('body').trigger('representanteiniciado');
	}

	$('[name="nombreRepLegal"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('[name="paternoRepLegal"], [name="maternoRegpLegal"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='rfcRepresentantelegal']").prop('maxlength', 13);
	$("[name='rfcRepresentantelegal']").attr('style', 'text-transform: uppercase;');
	$("[name='rfcRepresentantelegal']").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	$("[name='numIdentificacion']").prop('maxlength', 20);
	$("[name='numIdentificacion']").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#formRepresentante :input").on('change', function(){
		var idRepresentanteLegal = $("#formRepresentante [name='idRepresentantelegal']").val();
		if ( idRepresentanteLegal == "" ) {
			$("#formRepresentante [name='idRepresentantelegal']").val(0);
		}
		//$("#formRepresentante [name='idRepresentantelegal']").val(0);
	});

	$("#txtRFCRep").on('keyup', function(event){
		var valor = event.target.value;

		if(valor.length == 13){
			$.post(BASE_PATH + '/inc/Ajax/_Afiliaciones/validarRFCRepresentanteLegal.php',
				{
					RFC : valor
				},
				function(response){
					if(response.success == true){
						if ( response.data.apMRepreLegal != null ) {
							$("#formRepresentante [name='maternoRepLegal']").val(response.data.apMRepreLegal);
						}
						if ( response.data.apPRepreLegal != null ) {
							$("#formRepresentante [name='paternoRepLegal']").val(response.data.apPRepreLegal);
						}
						$("#formRepresentante [name='idRepresentantelegal']").val(response.data.idRepLegal);
						$("#formRepresentante [name='idTipoIdent']").val(response.data.idTipoIdent);
						if ( response.data.nombreRepLegal != null ) {
							$("#formRepresentante [name='nombreRepLegal']").val(response.data.nombreRepLegal);
						}
						$("#formRepresentante [name='numeroIdentificacion']").val(response.data.numIdentificacion);
						//simpleFillForm(response.data, 'formRepresentante', '');

						$("[name='figPolitica']").prop('checked', false);
						if(response.data.figPolitica == 1){
							$("[name='figPolitica']").prop('checked', true);
						}

						$("[name='famPolitica']").prop('checked', false);
						if(response.data.famPolitica == 1){
							$("[name='famPolitica']").prop('checked', true);
						}
					}else{
						/*$('#formRepresentante').get(0).reset();
						$('#txtRFCRep').val(valor);
						$('#formRepresentante [name="idRepresentantelegal"]').val(0);*/
					}
				},
				"json"
			);
		}
		else{
			//$('#formRepresentante').get(0).reset();
			$('#txtRFCRep').val(valor);
			$('#idRepLegal').val(0);
		}
	});


	$('body').trigger('representanteiniciado');
	GLOBAL_REPRESENTANTE_INICIADO = true;

}

function guardarRepresentanteLegal(event){
	var params = getParams($("#formRepresentante").serialize());
	params.nombreRepLegal 			= $("#formRepresentante [name='nombreRepLegal']").val();
	params.paternoRepLegal			= $("#formRepresentante [name='paternoRepLegal']").val();
	params.maternoRepLegal			= $("#formRepresentante [name='maternoRepLegal']").val();
	params.rfcRepresentantelegal	= $("#formRepresentante [name='rfcRepresentantelegal']").val();
	params.numeroIdentificacion		= $("#formRepresentante [name='numeroIdentificacion']").val();

	var lack = "";
	var error = "";

	if(myTrim(params.nombreRepLegal) == ""){
		lack += "- Nombre de Representante Legal\n";
	}
	if(myTrim(params.paternoRepLegal) == ""){
		lack += "- Apellido Paterno de Representante Legal\n";
	}
	if(myTrim(params.maternoRepLegal) == ""){
		lack += "- Apellido Materno de Representante Legal\n";
	}
	if(myTrim(params.rfcRepresentantelegal) == ""){
		lack += "- RFC de Representate Legal\n";
	}
	else{
		if(params.rfcRepresentantelegal.length != 13){
			error += "- RFC de Representante Legal debe ser de 13 caracteres\n";
		}
		if(!validaRFC('txtRFCRep')){
			error += "- El RFC del Representante Legal es Incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX\n";
		}
	}
	if(params.idTipoIdent == -1){
		lack += "- Tipo de Identificaci\u00F3n\n";
	}
	if(myTrim(params.numeroIdentificacion) == ""){
		lack += "- N\u00FAmero de Identificaci\u00F3n\n";
	}


	// form invalido
	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		var berror = (error != "")? "Los siguientes datos son Incorrectos : " : "";
		alert(black + "\n " + lack + "\n" + "\n" + berror + " \n " + error);
		event.preventDefault();
	}
	else{
		params.idCliente = ID_CLIENTE;
		$.post(BASE_PATH + "/inc/Ajax/_Clientes/ConsultaCliente/guardarRepresentanteLegal.php",
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					$("#formRepresentante [name='idRepresentantelegal']").val(response.idRepresentantelegal);
					$("[name='nombreRepresentantelegal']").html(response.nombreCompleto);
					$("[name='rfcRepresentantelegal']").html(response.rfc);
					$("[name='nombreTipoIdentificacion']").html(response.nombreIdentificacion);
					$("[name='numeroIdentificacion']").html(response.numeroIdentificacion);
					$("[name='labelFigPoliticaDesc']").html(response.figPoliticaDesc);
					$("[name='labelFamPoliticaDesc']").html(response.famPoliticaDesc);
					GLOBAL_DATA.nombreRepLegal = response.nombre;
					GLOBAL_DATA. nombreRepresentantelegal = response.nombreCompleto;
					GLOBAL_DATA.paternoRepLegal = response.paterno;
					GLOBAL_DATA.maternoRepLegal = response.materno;
					GLOBAL_DATA.idTipoIdent = response.tipoIdentificacion;
					GLOBAL_DATA.nombreTipoIdentificacion = response.nombreIdentificacion;
					GLOBAL_DATA.numeroIdentificacion = response.numeroIdentificacion;
					GLOBAL_DATA.famPolitica = response.famPolitica;
					GLOBAL_DATA.figPolitica = response.figPolitica;
					GLOBAL_DATA.labelFamPolitica = response.famPoliticaDesc;
					GLOBAL_DATA.labelFigPolitica = response.figPoliticaDesc;
					GLOBAL_DATA.rfcRepresentantelegal = response.rfc;
					$("#representante").modal("hide");
					loadCliente(params.idCliente);
				}
			},
			"json"
		);
	}
}

function downloadExcelListaCorresponsales(idCadena, idSubCadena, nombre, cantidad){
	Emergente();

	$.fileDownload(BASE_PATH+"/inc/Ajax/_Clientes/VerCorresponsales.php?idCadena="+idCadena+"&idSubcadena="+idSubCadena+"&nombreSub="+nombre+"&cantidad="+cantidad+"&downloadExcel=true", {
		successCallback: function(url) {
			OcultarEmergente();
		},
		failCallback: function(responseHtml, url){
			OcultarEmergente();
			alert("Ha ocurrido un error");
		}
	});
	return false;
}

function GoCorresponsal(idCorr){
	if(idCorr > -1 ){
		setValue('hidCorresponsalX',idCorr);		
		irAForm('formPase','../Corresponsal/Listado.php','../Cadena/Listado.php');
		
	}else{
		alert("Favor de escribir un ID de Corresponsal valido");
	}
}

function EditarContactos(id,nom,apP,apM,idTipo,tel,correo, ext, e){
	e.preventDefault();

	setValue("txtContacNom",nom);
	setValue("txtContacAP",apP);
	setValue("txtContacAM",apM);

	$("#ddlTipoContac option[value="+ idTipo +"]").attr("selected",true);
	setValue("txtTelContac",tel);
	setValue("txtMailContac",correo);
	setValue("txtExtTelContac",ext);
	
	setValue("HidContacto",id);
	
	Persiana(false);
}

function Persiana(bandPersiana){
	if(bandPersiana)
		$("#contactos").slideUp("normal");
	else
		$("#contactos").slideDown("normal");
}


function actualizaContacto(idCadSubCor,idTipoCliente, event){
	var lack = "";
	var error = "";

	var NomC = txtValue("txtContacNom");
	if(NomC.trim() == ""){
		lack += "- Nombre\n";
	}
	var apPC = txtValue("txtContacAP");
	if(apPC.trim() == ""){
		lack += "- Apellido Paterno \n";
	}

	var apMC = txtValue("txtContacAM");
	if(apMC.trim() == ""){
		lack += "- Apellido Materno\n";
	}

	var telC = txtValue("txtTelContac");
	if(telC.trim() == "" /*&& validaTelefono("txtTelContac")*/){
		lack += "- Tel\u00E9fono\n";
	}
	else{
		if(!validaTelefonoAnterior3("txtTelContac")){
			error += "- Tel\u00E9fono Inv\u00E1lido\n ";
		}
	}
					
	var mailC = txtValue("txtMailContac");
	if(mailC.trim() == ""){
		lack += "- Correo Electr\u00F3nico\n";
	}
	else{
		if(!validarEmail("txtMailContac")){
			error += "- Correo Electr\u00F3nico\n";
		}
	}

	var tipoC = txtValue("ddlTipoContac");
	if(tipoC <= 0){
		lack += "- Tipo de Contacto \n";
	}

	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		var berror = (error != "")? "Los siguientes datos son Incorrectos : " : "";
		alert(black + "\n " + lack + "\n" + "\n" + berror + " \n " + error);
		event.preventDefault();
	}
	else{
		var idContac = txtValue("HidContacto");
		var extension = txtValue("txtExtTelContac");
		var parametros = "id="+idCadSubCor+"&idContacto="+idContac+"&NomC="+NomC+"&apPC="+apPC+"&apMC="+apMC+"&telC="+telC+"&mailC="+mailC+"&tipoC="+tipoC+"&idTipoCliente="+idTipoCliente+"&extension="+extension;
		
		var params = getParams(parametros);
		$.post(BASE_PATH+"/inc/Ajax/_Clientes/UpdateContactosClientes.php",
			params,
			function(response){
				var RESserv = response.split("|");

				validaSession(RESserv[0]);
				
				if(RESserv[0] != 0){
					alert(RESserv[1]);
				}
				else{
					$('#contactos').modal('toggle');
					//event.preventDefault();
					cargarListaContactos();
				}
			}
		);
	}					
}

function eliminarContacto(idCliente,idContacto,tipoCliente, event){
	if(confirm('\u00BFDesea Eliminar el Contacto?')){
		var parametros = "tipoCliente="+tipoCliente+"&id="+idCliente+"&idContacto="+idContacto;
		var params = getParams(parametros);
		$.post(BASE_PATH+"/inc/Ajax/_Clientes/DeleteContacto.php",
			params,
			function(response){
				var RESserv = response.split("|");
				validaSession(RESserv[0]);
				
				if(RESserv[0] == 0){
					//event.preventDefault();
					cargarListaContactos();
				}
				else{
					alert(RESserv[1]);
				}
			}
		);
	}
}

function resetContactos(){
	$("#formContactos").get(0).reset();
	$("#HidContacto").val(-2);
}

function cargarListaContactos(event){
	//event.preventDefault();
	$.post(BASE_PATH + '/inc/Ajax/_Clientes/ConsultaCliente/ListaContactos.php',
		{
			idCliente : ID_CLIENTE
		},
		function(response2){
			//event.preventDefault();
			$("#divContactos").empty().html(response2);
		}
	);
}

function eliminarConfiguracionCuenta(idConfiguracion){
	var g = confirm("\u00BFSeguro que desea Eliminar?");
	if(g){
		$.post(BASE_PATH + "/inc/Ajax/_Clientes/DestroyConfigCuenta.php",
		{
			idConfiguracion	: idConfiguracion
		},
		function(resp){
			if(resp.showMessage == 1){
				alert(resp.msg);
			}
			else{
				cargarConfiguracionCuenta();
			}
		}, "json");
	}
}

function cargarConfiguracionCuenta(){
	$.post(BASE_PATH + "/inc/Ajax/_Clientes/ConsultaCliente/ListaConfiguracionCuenta.php",
		{
			idCadena 	: GLOBAL_DATA.idCadena,
			idCliente	: ID_CLIENTE
		},
		function(response){
			$("#tblConfiguracionCuenta tbody").empty().html(response);
		}
	);
}

GLOBAL_CONFIGURACIONCUENTA_INICIADA = false;
function initConfiguracionCuenta(event){

	if(GLOBAL_CONFIGURACIONCUENTA_INICIADA == true){
		event.preventDefault();
		return false;
	}

	console.log("---------- --------------- ---------- --------------- ---------- --------------- ----------");
	/*$("#ddlTipoMovimiento").change(function(){*/
		cargarTiposInstruccion();
	/*});*/
	$("#ddlDestino").change(function(){
		HideShowDiv();
		changeCuenta();
	});

	$("#txtCLABE").attr('maxlength','18');
	$("#txtCLABE").unbind("paste");
	$("#txtNumCuenta").attr('maxlength','10');
	$("#txtBeneficiario").attr('maxlength','35');
	$("#txtRFCBen").attr('maxlength','13');
	$("#txtMailContac").attr('maxlength','100');
	$("#txtCorreo").attr('maxlength','100');
	$("#txtNumCuenta").attr("readonly", true);
	$("#txtCuenta").attr("readonly", true);
	$("#txtBanco").attr("readonly", true);

	$("#txtCorreo").alphanum({
		allow				: '@_-.',
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$("#txtCLABE").keyup(function(event) {
		var texto = $("#txtCLABE").val();
		var ncar = texto.length;

		if(ncar < 3){
			$("#txtBanco").val("");
		}
	});

	$("#txtCLABE").keyup(function(event) {
		var clabe = $("#txtCLABE").val();
		buscaBancoClabe(clabe);
		analizarCLABEConsulta();
	});

	$("#txtCLABE").keypress(function(event) {
		var clabe = $("#txtCLABE").val();
		buscaBancoClabe(clabe);
		analizarCLABEConsulta();
	});

	$("#txtNumCuenta, #txtCLABE").bind('keypress', function(e){  
		if(e.keyCode == '9' || e.keyCode == '16'){  
			return;  
		}  
		var code;  
		if (e.keyCode) code = e.keyCode;  
		else if (e.which) code = e.which;   
		if(e.which == 46)  
			return false;  
		if (code == 8 || code == 46)  
			return true;  
		if (code < 48 || code > 57)  
			return false;  
		}  
	);

	$("#txtCLABE").bind('keypress', function(e){
		if(e.keyCode == '9' || e.keyCode == '16'){  
			return;  
		}  
		var code;  
		if (e.keyCode) code = e.keyCode;  
		else if (e.which) code = e.which;   
		if(e.which == 46)  
			return false;  
		if (code == 8 || code == 46)  
			return true;  
		if (code < 48 || code > 57)  
			return false;  
	});

	$("#txtBeneficiario").alpha();
	$("#txtRFCBen").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	$("#txtCLABE").numeric();

	$("#txtNumCuenta, #txtBeneficiario, #txtCorreo, #txtRFCBen").bind("paste", function(){
		return false;
	});

	$("#txtRFCBen").blur(function(e){
		var rfc = $("#txtRFCBen").val();

		if(rfc != "" && rfc != undefined && rfc != null){
			if(!validaRFC("txtRFCBen")){
				alert("El RFC no tiene un formato válido");
				return false;
			}
		}
	});

	$("#txtCorreo").blur(function(e){
		var correo = $("#txtCorreo").val();

		if(correo != "" && correo != undefined && correo != null){
			if(!validar_email(correo)){
				alert("El Correo no tiene un formato válido");
				return false;
			}
		}
	});

	$("#txtCLABE").blur(function(e){
		var clabe = $("#txtCLABE").val();

		buscaBancoClabe(clabe);
	});

	GLOBAL_CONFIGURACIONCUENTA_INICIADA = true;
}

function changeCuenta(){
	var destino = $("#ddlDestino").val();

	if(destino != 2){
		var valor = $("#txtNumCuentaForelo").val();
		$("#txtNumCuenta").val(valor);

		$("#txtCLABE").val("");
		$("#txtBeneficiario").val("");
		$("#txtRFCBen").val("");
		$("#txtCorreo").val("");
		$("#txtBanco").val("");
	}
}

function HideShowDiv(){
	//setSomeConfs();

	var destino = $("#ddlDestino").val();

	if(destino == 2){
		showFieldsBanco();
	}
	else{
		hideFieldsBanco();
	}
}

function showFieldsBanco(){
	$("#fieldsBanco").show();
}

function hideFieldsBanco(){
	$("#fieldsBanco").hide();
}

function resetConfs(){
	$('#txtCLABE').unbind();
	$('#txtNumCuenta').unbind();
	$('#txtBeneficiario').unbind();
	$('#txtRFCBen').unbind();
	$('#txtCorreo').unbind();
}

permitirGuardarCta = true;
function setSomeConfs(){
	resetConfs();
	
}

function buscaBancoClabe(CLABE){
	$.post(BASE_PATH + "/inc/Ajax/_Clientes/BuscaBanco.php",
	{
		CLABE : CLABE,
	},
	function(resp){
		if(resp.showMessage == 1){
			alert(resp.msg);
		}
		else{
			$("#txtBanco").val(resp.data.nombreBanco);
		}
	}, "json");
}

function analizarCLABEConsulta(){
	var CLABE = $("#txtCLABE").val();
	existenCambios = true;
	if ( CLABE.length == 18 ) {
		var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
		if ( CLABE_EsCorrecta ) {
			$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
			function ( data ) {
				var banco = jQuery.parseJSON( data );
				$("#ddlBanco").val(banco.bancoID);
				console.log(CLABE.substring(6, 17));
				$("#txtNumCuenta").val(CLABE.substring(6, 17));
				permitirGuardarCta = true;
			}
			);
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			permitirGuardarCta = false;
			if ( document.getElementById("guardarCambios") ) {
				$("#guardarCambios").prop("disabled", false);
				permitirGuardarCta = false;
			}			
		}
	} else {
		$("#ddlBanco").val(-1);	
		$("#txtCuenta").val("");
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
		}	
	}
}

function cargarTiposInstruccion(){
	var idTipoMovimiento = $("#ddlTipoMovimiento").val();
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeTiposInstruccion.php", 'ddlInstruccion', {idTipoMovimiento : idTipoMovimiento}, {text : 'descripcion', value : 'idTipoInstruccion'}, {});
}

function crearConfiguracion(){
	var tipoMovimiento	= $("#ddlTipoMovimiento").val();
	var destino			= $("#ddlDestino").val();
	var instruccion		= $("#ddlInstruccion").val();

	if(tipoMovimiento == "" || tipoMovimiento == -1){
		alert("Seleccione Tipo de Movimiento");
		return false;
	}
	//console.log('instruccion', instruccion);
	if(instruccion == "" || instruccion < -1){
		alert("Seleccione Tipo de Instrucción");
		return false;
	}

	if(destino == "" || destino == -1){
		alert("Seleccione Destino");
		return false;
	}

	var clabe			= "";
	//var numCuenta		= $("#txtNumCuenta").val();
	var numCuenta		= $("#txtNumCuentaForelo").val();
	var beneficiario	= "";
	var rfc				= "";
	var correo			= "";

	/* si seleccionó banco */
	if(destino == 2){
		clabe			= $("#txtCLABE").val();
		//numCuenta		= $("#txtNumCuenta").val();
		numCuenta		= $("#txtNumCuentaForelo").val();
		beneficiario	= $("#txtBeneficiario").val();
		rfc				= $("#txtRFCBen").val();
		correo			= $("#txtCorreo").val();

		if(clabe.trim() == ""){
			alert("Inserte CLABE");
			return false;
		}
		if(numCuenta.trim() == ""){
			alert("Inserte Cuenta");
			return false;
		}
		if(beneficiario.trim() == ""){
			alert("Inserte Beneficiario");
			return false;
		}
		//console.log('rfc', rfc);
		if(rfc.trim() == ""){
			alert("Inserte RFC");
			return false;
		}
		/*if(correo == ""){
			alert("Inserte Correo Electrónico");
			return false;
		}*/
		if(!validaRFC("txtRFCBen")){
			alert("El RFC no tiene un formato válido");
			return false;
		}
		if(correo != ""){
			if(!validar_email(correo)){
				alert("El Correo no tiene un formato válido");
				return false;
			}
		}
	}

	$.post(BASE_PATH + "/inc/Ajax/_Clientes/CrearConfigCuenta.php",
	{
		tipoMovimiento	: tipoMovimiento,
		destino			: destino,
		instruccion		: instruccion,
		clabe			: clabe,
		numCuenta		: numCuenta,
		beneficiario	: beneficiario,
		rfc				: rfc,
		correo			: correo
	},
	function(resp){
		if(resp.showMessage == 1){
			alert(resp.msg);
		}
		else{
			cargarConfiguracionCuenta();
			$("#liquidacion").modal("hide");
		}
	}, "json");

}

GLOBAL_EXPEDIENTE_INICIADO = false;
function cargarExpediente(){
	var familias = GLOBAL_DATA.familias;
	var fams = familias.split(",");

	$("#formExpediente").get(0).reset();
	$("#divNombreNivel").html(GLOBAL_DATA.nombreNivel);

	$.each(fams, function(index, item, obj){
		$("#formExpediente [name='chkFamilia"+item+"']").prop('checked', true);
	});

	$("#formExpediente :input").on('change', function(){


		var objExpediente = {}
		objExpediente[0] = "N/A";

		var ids = new Array();
		ids.push(0)

		var idExp = 0;

		var checks = $("#formExpediente :input:checked");
		$.each(checks, function(indx, check, obj){
			idExp = $(check).attr('idexpediente');
			ids.push(idExp);
			objExpediente[idExp] = $(check).attr('nombreexpediente');
		});

		var idMaximo = Math.max.apply(Math, ids);
		var nombre = objExpediente[idMaximo];

		$("#formExpediente [name='idExpediente']").val(idMaximo);
		$("#divNombreNivel").html(nombre);

	});
}

function guardarExpediente(){
	var checks = $("#formExpediente :input:checked");
	var familias = new Array();

	$.each(checks, function(indx, check, obj){
		familias.push($(check).attr('idfamilia'));
	});

	var params = {
		idCliente		: ID_CLIENTE,
		familias		: familias.join(","),
		idExpediente	: $("#formExpediente [name='idExpediente']").val()
	}

	if(myTrim(params.familias) == ""){
		alert("Debe seleccionar por lo menos una familia");
		return false;
	}

	$.post(BASE_PATH + "/inc/Ajax/_Clientes/ConsultaCliente/guardarFamilias.php",
		params,
		function(response){
			if(showMsg(response)){
				alert(response.msg)
			}
			$('body').on('clienteloaded', function(){
				cargarExpediente();
			});
			loadCliente(ID_CLIENTE);
		},
		"json"
	);
}

function irANuevaBusqueda(){
	window.location = "../menuConsulta.php";
}



function verdoc(tipodoc){
    
   $.post(BASE_PATH + '/inc/Ajax/_Clientes/ConsultaCliente/rutadocumento.php',{tipo:tipodoc,rfc:rfccte},function(res){
     
       jQuery('#pdfdata').attr('data', '../../inc/ajax/pdfoutside.php?pdf='+res.ruta);
   
       $('#pdfvisor').css('display','block');
       
   },"JSON" );
   
    
    
}


function initInputFiles(){
    
    
		$(':input[type=file]').unbind('change');
		$(':input[type=file]').on('change', function(e){
			var input		= e.target;
			var nIdTipoDoc	= input.getAttribute('idtipodoc');
            var rfcxx = rfccte;
			var file = $(input).prop('files')[0];
	
     
			var formdata = new FormData();
			formdata.append('sFile',file);
			formdata.append('nIdTipoDoc', nIdTipoDoc);
			formdata.append('rfc', rfcxx);
            formdata.append('usr',usr);
            
             
            if(file.type != 'application/pdf'){
				alert('El archivo debe ser formato pdf');
				return;
            }else{
                
                var confdoc = confirm('Esta Accion cargara un documento nuevo sustituyendo el anterior, ¿Desea continuar?');
    
                if(confdoc == false){return;}
				$.ajax({
					url			: '../../inc/ajax/documentos.php',
					type		: 'POST',
                    
					contentType	: false,
					data		: formdata,
                    mimeType :"multipart/form-data",
					processData	: false,
					cache		: false,
					dataType	: 'json',
				})
				.done(function(resp){
					if(resp.idDocs > 0){
                       alert('Documento Cargado Exitosamente!!');
					}
					else{
					   alert(resp.idDocs);	
					}
				})
				.fail(function(){
					alert('Error al Intentar Subir el Archivo');
				});
            }
			
		});
	}