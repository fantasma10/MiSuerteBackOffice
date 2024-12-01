
function enviarForm(idForm){
	$("#" + idForm).submit();
}

function initDatosGeneralesAfiliacion(){
	
	if(ID_CLIENTE > 0){
	//cargarPantalla(ID_NIVEL);
		loadAfiliacion(ID_CLIENTE);
	}
	else{
		$('body').on('prependHtmldone', function(){
			initComponents();
		});
		cargarPantalla(ID_NIVEL);
	}
}

function initComponents(){

	$(":input").bind('paste', function(){return false;});

	$("#txtRFC").prop('maxlength', 13);
	$("#txtRFC").attr('style', 'text-transform: uppercase;');

	$("#txtRFC").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	$('#cmbEstado, #cmbMunicipio').prop('disabled', true);

	$("[name='txtCadena'], [name='razonSocial']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ.-,',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 200
	});

	$("[name='nombrePersona']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$("[name='apPPersona'], [name='apMPersona']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='fecAltaRPPC']").datepicker({format : 'yyyy-mm-dd'});

	$('#txttelefono').prop('maxlength', 20);

	$("[name='email']").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 150
	});

	$("[name='calleDireccion']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='numeroIntDireccion']").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 10
	});

	$("[name='numeroExtDireccion']").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits			: 10
	});

	$('[name="nombreRepLegal"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('[name="apPRepreLegal"], [name="apMRepreLegal"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("[name='RFCRepreLegal']").prop('maxlength', 13);
	$("[name='RFCRepreLegal']").attr('style', 'text-transform: uppercase;');
	$("[name='RFCRepreLegal']").alphanum({
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

	$('#cmbTipoPersona').on('change', function(event){
											   
		var value = event.target.value;
		if(value == 1){
			$('.personafisica').show();
			$('.personafisica :input').prop('readonly', false);
			//$('.personamoral').hide();
			$('.personamoral').show();
			$('.personamoral2').hide();
			$('.personamoral :input').prop('readonly', true);
			$('.personamoral :input').val('');
			$('#txtRFC').prop('maxLength', 13);
		}
		if(value == 2){
			$('.personamoral').show();
			$('.personamoral2').show();
			$('.personamoral :input').prop('readonly', false);
			//$('.personamoral :input').val('');
			$('.personafisica').hide();
			$('.personafisica :input').prop('readonly', true);
			$('.personafisica :input').val('');
			$('#txtRFC').prop('maxLength', 12);
		}
		if(value == 3){
			$('.personamoral, .personamoral2, .personafisica').show();
			$('.personamoral :input, .personafisica :input').prop('readonly', false);
			
			if(myTrim($('[name="razonSocial"]').val()) != ""){
				$('.personafisica :input').prop('readonly', true);
			}
			else{
				if(myTrim($("[name='nombrePersona']").val()) != "" || myTrim($("[name='apPPersona']").val()) != "" || myTrim($("[name='apMPersona']").val()) != ""){
					$('.personamoral :input').prop('readonly', true);
				}
			}
			$('#txtRFC').prop('maxLength', 13);
		}
		if(value == -1){
			//$('.personafisica, .personamoral').hide();
			$('.personafisica').hide();
			$('.personamoral').show();
			$('.personamoral2').hide();
		}
	});

	tipoRFC = 0;
	$("[name='razonSocial']").on('keyup', function(event){
		var valor = event.target.value;

		if(valor.trim() != ""){
			tipoRFC = 2;
			$("[name='nombrePersona'], [name='apPPersona'], [name='apMPersona']").val('');
			$("[name='nombrePersona'], [name='apPPersona'], [name='apMPersona']").prop('readonly', true);

			$('#txtRFC').prop('maxLength', 12);
		}
		else{
			tipoRFC = 0;
			$("[name='nombrePersona'], [name='apPPersona'], [name='apMPersona']").prop('readonly', false);
		}
	});


	$("[name='nombrePersona'], [name='apPPersona'], [name='apMPersona']").on('keyup', function(event){
		var valor = event.target.value;

		var valor1 = $("[name='nombrePersona']").val();
		var valor2 = $("[name='apPPersona']").val();
		var valor3 = $("[name='apMPersona']").val();

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



	$("#txtCadena, #txtSubCadena, #txtCorresponsal, #txtPais").keyup(function(e){
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

	$("#txtPais").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets	: false,
		allowNumeric		: false
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

	/*if($("#ddlTipoCliente").length){
		$("#ddlTipoCliente").change(function(){
			var tipoC = this.value;
			if(tipoC > -1){*/
				$("#ddlTipoAcceso").on('accesosloaded', function(){
					$(this).val(3);
				});

				cargarStore("../../inc/Ajax/_Clientes/tipoAccesoOpciones.php", "ddlTipoAcceso", {idTipoCliente : -1}, {value : 'idTipoAcceso', text : 'descTipoAcceso'}, {}, 'accesosloaded');
			/*}
			else{
				limpiaStore("ddlTipoAcceso");
			}
		});
	}*/

	$("#formRepresentante :input").on('change', function(){
		$("#idRepLegal").val(0);
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
						simpleFillForm(response.data, 'formRepresentante', '');

						$("[name='figPolitica']").prop('checked', false);
						if(response.data.figPolitica == 1){
							$("[name='figPolitica']").prop('checked', true);
						}

						$("[name='famPolitica']").prop('checked', false);
						if(response.data.famPolitica == 1){
							$("[name='famPolitica']").prop('checked', true);
						}
					}
					else{
						//$('#formRepresentante').get(0).reset();
						//$('#txtRFCRep').val(valor);
						$('#idRepLegal').val(0);
					}
				},
				"json"
			);
		}
		else{
			//$('#formRepresentante').get(0).reset();
			//$('#txtRFCRep').val(valor);
			$('#idRepLegal').val(0);
		}
	});
	
	//alert("txtPais: " + $("#txtPais").val());
	autoCompletaGeneral('txtPais', 'idPais', BASE_PATH + '/inc/Ajax/_Clientes/getPaises.php', 'label', 'idPais', {}, null);
	$("#txtPais").val("M\u00E9xico");
	autoCompletaGeneral('txtCadena', 'idCadena', BASE_PATH + '/inc/Ajax/_Clientes/getListaCategoria.php', 'nombreCadena', 'idCadena', {idEstatus : 0, categoria : 1}, renderItemCadena);
	autoCompletarCalle();

	$("#txtCalle").on('keyup', function(event){
		var valor = event.target.value;

		if(valor.trim() == ""){
			//$("#formDireccion").get(0).reset();
			$("#idDireccion").val(0);
			$("#origen").val(1);
		}
	});

	$("#formDireccion :input").on('change', function(){
		$("#idDireccion").val(0);
		$("#origen").val(1);
	});

	// cargar store de grupos
	$("#cmbGrupo").on("gruposloaded", function(event){
		$(this).val(0);
	});
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeGrupos.php", "cmbGrupo", {}, {text : 'nombreGrupo', value : "idGrupo"}, {}, 'gruposloaded');
	// cargar store de regimen fiscal
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeRegimen.php", "cmbTipoPersona", {}, {text : 'nombre', value : "idTipoRegimen"}, {}, 'regimenloaded');
	// cargar store giro
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeGiros.php", "cmbGiro", {}, {text : 'nombreGiro', value : "idGiro"}, {}, 'giroloaded');
	// cargar store de referencias
	$("#cmbReferencia").on("referencialoaded", function(event){
		$(this).val(1);
	});
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeReferencias.php", "cmbReferencia", {}, {text : 'nombreReferencia', value : "idReferencia"}, {}, 'referencialoaded');

	if($('#cmbIdent').length){
		cargarStore(BASE_PATH+"/inc/Ajax/stores/storeTipoIdentificacion.php", "cmbIdent", {}, {text : 'descTipoIdentificacion', value : 'idTipoIdentificacion'}, {}, 'tipoidentloaded');
	}

	$("#btnAnterior").on('click', function(event){
		console.log(ID_AFILIACION);
		window.location = "newuser.php?idAfiliacion=" + ID_AFILIACION;
	});

	$('body').trigger('componentesiniciados');

	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	if(!ES_CONSULTA){
		$('.esconsulta').hide();
		$('.noesconsulta').show();
	}
	else{
		$('.esconsulta').show();
		$('.noesconsulta').hide();

		$("#btnRegresar").on('click', function(event){
			window.location = "Cliente.php?idCliente="+ID_CLIENTE;
		});
	}
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
			//$("#idDireccion").val("");
			return false;
		},
		select: function( event, ui ) {
			var id = ui.item.idDireccion;
			var origen = ui.item.origen;
			if ( origen == 1 ) {
				$("#idDireccion").val(id);
				$("#origen").val(origen);
			} else if ( origen == 0 ) {
				$("#idDireccion").val(id);
				$("#origen").val(origen);
			}
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

			return false;
		},
		close: function(event, ui){
			var valorId = $("#idDireccion").val();
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

function loadAfiliacion(idCliente){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/loadAfiliacion.php",
		{
			idAfiliacion : idCliente
		},
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}
			console.log(response);
			if(response.success == true){
				idExp = response.data.idNivel;

				

				$("[name='idNivel']").val(idExp);
				$('body').on('componentesiniciados', function(){
					cargarAfiliacion(response);
				});

				$('body').on('prependHtmldone', function(){
					initComponents();
				});

				cargarPantalla(idExp);
				
			}
		},
		"json"
	)
}

function guardarDatosGenerales(event){
	var deshabilitados = $(":disabled");
	$(deshabilitados).prop("disabled", false);
	
	var params = getParams($("form").serialize());

	deshabilitados.prop("disabled", true);

	if(params.idCliente == 0){
		if(params.familias == ""){
			alert("No seleccionó familias");
			return false;
		}
		if(params.idNivel == "" || params.idNivel <= 0){
			alert("No seleccionó Nivel");
			return false;
		}
	}


	var lack = "";
	var error = "";
	// validaciones de datos generales
	if(params.idCadena < 0 || params.idCadena == ""){
		lack += "- Cadena\n";
	}
	if(params.idGrupo <= -1 || myTrim(params.idGrupo) == ""){
		lack += "- Grupo\n";
	}
	if(params.idReferencia <= 0 || myTrim(params.idReferencia) == ""){
		lack += "- Referencia\n";
	}
	if(params.tipoPersona <= 0 || myTrim(params.tipoPersona) == ""){
		lack += "- R\u00E9gimen Fiscal \n";
	}
	else{
		switch(params.tipoPersona){
			case '1':
				if(myTrim(params.nombrePersona) == ""){
					lack += "- Nombre\n";
				}
				if(myTrim(params.apPPersona) == ""){
					lack += "- Apellido Paterno\n";
				}
				if(myTrim(params.apMPersona) == ""){
					lack += "- Apellido Materno\n";
				}
			break;
			case '2':
				if(myTrim(params.razonSocial) == ""){
					lack += "- Raz\u00F3n Social\n";
				}
			break;
			case '3':
				if( tipoRFC == 1 ){
					if(myTrim(params.nombrePersona) == ""){
						lack += "- Nombre\n";
					}
					if(myTrim(params.apPPersona) == ""){
						lack += "- Apellido Paterno\n";
					}
					if(myTrim(params.apMPersona) == ""){
						lack += "- Apellido Materno\n";
					}					
				} else if ( tipoRFC == 2 ) {
					if(myTrim(params.razonSocial) == ""){
						lack += "- Raz\u00F3n Social\n";
					}					
				} else {
					var r = myTrim(params.RFC);
					if(r == ""){
						if(myTrim(params.nombrePersona) == ""){
							lack += "- Nombre (En caso de ingresar RFC de Persona F\u00EDsica)\n";
						}
						if(myTrim(params.apPPersona) == ""){
							lack += "- Apellido Paterno (En caso de ingresar RFC de Persona F\u00EDsica)\n";
						}
						if(myTrim(params.apMPersona) == ""){
							lack += "- Apellido Materno (En caso de ingresar RFC de Persona F\u00EDsica)\n";
						}
						if(myTrim(params.razonSocial) == ""){
							lack += "- Raz\u00F3n Social (En caso de ingresar RFC de Persona Moral)\n";
						}
					} else if (r.length == 13) {
						if(myTrim(params.nombrePersona) == ""){
							lack += "- Nombre\n";
						}
						if(myTrim(params.apPPersona) == ""){
							lack += "- Apellido Paterno\n";
						}
						if(myTrim(params.apMPersona) == ""){
							lack += "- Apellido Materno\n";
						}						
					} else if (r.length == 12) {
						if(myTrim(params.razonSocial) == ""){
							lack += "- Raz\u00F3n Social\n";
						}						
					}
				}
			break;
		}
	}
	if(myTrim(params.RFC) == ""){
		lack += "- RFC \n";
	}
	else{
		var r = myTrim(params.RFC);

		if(params.tipoPersona != -1){
			switch(params.tipoPersona){
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
	if(params.idGiro <= -1 || myTrim(params.idGiro) == ""){
		lack += "- Giro\n";
	}
	if(params.idNivel > 1){
		if( (params.tipoPersona == 2) || (params.tipoPersona == 3 && r.length == 12)){
			var expR = /^\d{4}\-\d{2}\-\d{2}$/;
			if(!expR.test(params.fecAltaRPPC) || params.fecAltaRPPC == "0000-00-00"){
				lack += "- Fecha Constitutiva\n";
			}
			var d		= new Date();
			var anio	= d.getFullYear();
			var mes		= d.getMonth()+1;
			var dia		= d.getDate();
	
			if(mes < 10){
				mes = "0"+mes;
			}
	
			if(dia < 10){
				dia = "0"+dia;
			}
	
			var hoy =  anio + "-" + mes + "-" + dia;
	
			if(params.fecAltaRPPC >= hoy){
				error += "- La fecha no puede ser mayor al día de hoy\n";
			}
		}
	}
	if(myTrim(params.telefono) == ""){
		lack += "- Tel\u00E9fono\n";
	}
	else{
		if(!validaTelefono("txttelefono")){
			error += "- Introduzca un Tel\u00E9fono v\u00E1lido \n";
		}
	}
	if(myTrim(params.email) == ""){
		lack += "- Correo\n";
	}
	else{
		if(!validarEmail('txtemail')){
			error += "- El formato de Correo es Incorrecto\n";
		}
	}

	// validaciones de direccion
	if(params.idPais <= 0 || myTrim(params.idPais) == ""){
		lack += "- Pa\u00EDs\n";
	}
	if(myTrim(params.calleDireccion) == ""){
		lack += "- Calle\n";
	}
	/*if(myTrim(params.numeroIntDireccion) == ""){
		lack += "- N\u00FAmero Interior\n";
	}*/
	if(myTrim(params.numeroExtDireccion) == ""){
		lack += "- N\u00FAmero Exterior\n";
	}
	/*if(myTrim(params.numeroExtDireccion) == ""){
		lack += "- N\u00FAmero Exterior\n";
	}*/
	if(myTrim(params.cpDireccion) == ""){
		lack += "- C\u00F3digo Postal\n";
	}
	if(params.idcColonia <= 0 || myTrim(params.idcColonia) == "" || params.idcColonia == undefined){
		lack += "- Colonia\n";
	}
	if(params.idcEntidad <= 0 || myTrim(params.idcEntidad) == "" || params.idcEntidad == undefined){
		lack += "- Estado\n";
	}
	if(params.idcMunicipio <= 0 || myTrim(params.idcMunicipio) == "" || params.idcMunicipio == undefined){
		lack += "- Ciudad\n";
	}

	//var tipoC = $("#ddlTipoCliente").val();
	var tipoA = $("#ddlTipoAcceso").val();

	/*if(tipoC == -1 || tipoC == undefined){
		lack += " - Tipo de Cliente \n";
	}*/

	if(tipoA == -1 || tipoA == undefined){
		lack += " - Tipo de Acceso \n";
	}
	else{
		params.idTipoAcceso = tipoA;
	}

	// representante legal
	if(params.idNivel > 1){
		if(myTrim(params.nombreRepLegal) == ""){
			lack += "- Nombre de Representante Legal\n";
		}
		if(myTrim(params.apPRepreLegal) == ""){
			lack += "- Apellido Paterno de Representante Legal\n";
		}
		if(myTrim(params.apMRepreLegal) == ""){
			lack += "- Apellido Materno de Representante Legal\n";
		}
		if(myTrim(params.RFCRepreLegal) == ""){
			lack += "- RFC de Representate Legal\n";
		}
		else{
			if(params.RFCRepreLegal.length != 13){
				error += "- RFC de Representante Legal debe ser de 13 caracteres\n";
			}
			if(!validaRFC('txtRFCRep')){
				error += "- El RFC del Representante Legal es Incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX\n";
			}
		}
		if(params.idTipoIdent == -1){
			lack += "- Tipo de Identificaci\u00F3n\n";
		}
		if(myTrim(params.numIdentificacion) == ""){
			lack += "- N\u00FAmero de Identificaci\u00F3n\n";
		}
	}

	// form invalido
	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		var berror = (error != "")? "Los siguientes datos son Incorrectos : " : "";
		alert(black + "\n " + lack + "\n" + "\n" + berror + " \n " + error);
		event.preventDefault();
	}
	else{
		$.post(BASE_PATH + '/inc/Ajax/_Afiliaciones/guardarDatosGenerales.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				$("[name='idCliente']").val(response.data.idCliente);
				ID_CLIENTE = response.data.idCliente;
				if(!ES_CONSULTA){
					if(response.success == true){
						window.location = "NumeroSucursales.php?idCliente="+response.data.idCliente;
					}
				}
			},
			"json"
		);
	}
}

/*
**	Carga la pantalla segun el tipo de expediente
*/
function cargarPantalla(idExpediente){

	switch(idExpediente){
		case '1':
			prependHtml("generalesBasico.php", "htmlContent", {});
		break;

		case '2':
			prependHtml("generalesAvanzado.php", "htmlContent", {});
		break;

		case '3':
			prependHtml("generalesAvanzado.php", "htmlContent", {});
		break;

		default :
			//prependHtml("generalesAvanzado.php", "htmlContent", {});
			alert('El Tipo de Expediente es inv\u00E1lido');
		break;
	}
}


function cargarAfiliacion(obj){
	simpleFillForm(obj.data, "formGenerales", "");
	simpleFillForm(obj.data, "formRepresentante", "");
	simpleFillForm(obj.data, "formDireccion", "");


	$('#cmbGrupo').on('gruposloaded',function(){
		if(obj.data.idGrupo == "" || obj.data.idGrupo == null || obj.data.idGrupo == 0 || obj.data.idGrupo == -1){
			obj.data.idGrupo = 0;
		}
		$(this).val(obj.data.idGrupo);
	});

	$('#cmbTipoPersona').on('regimenloaded',function(){
		$(this).val(obj.data.tipoPersona).change();
	
		var value = obj.data.tipoPersona;

		if(value == 1){
			$('.personafisica').show();
			$('.personamoral').show();
			$('.personamoral2').hide();
			//$('.personamoral').hide();
			//$('.personamoral2').show();
			$('#txtRFC').prop('maxLength', 13);
		}
		if(value == 2){
			$('.personamoral').show();
			$('.personamoral2').show();
			$('.personafisica').hide();
			$('#txtRFC').prop('maxLength', 12);
		}
		if(value == 3){
			$('.personamoral').show();
			$('.personamoral2').show();
			$('.personafisica').show();

			$('.personamoral').css('display', 'block');
			$('.personafisica').css('display', 'block');

			if(myTrim(obj.data.razonSocial) == ""){
				$(".personamoral :input").prop('readonly', true);
				$(".personafisica :input").prop('readonly', false);
			}
			else{
				$(".personamoral :input").prop('readonly', false);
				$(".personafisica :input").prop('readonly', true);
			}

			$('#txtRFC').prop('maxLength', 13);
		}
		if(value == -1){
			//$('.personafisica, .personamoral').hide();
			$('.personafisica').hide();
			$('.personamoral').show();
			$('.personamoral2').hide();			
		}
	});

	$('#cmbGiro').on('giroloaded',function(){
		$(this).val(obj.data.idGiro);
	});

	$('#cmbReferencia').on('referencialoaded',function(){
		if(obj.data.idReferencia == "" || obj.data.idReferencia == null || obj.data.idReferencia == 0 || obj.data.idReferencia == -1){
			obj.data.idReferencia = 1;
		}
		$(this).val(obj.data.idReferencia);
	});

	if($('#cmbIdent').length){
		$('#cmbIdent').on('tipoidentloaded',function(){
			$(this).val(obj.data.idTipoIdent);
		});
	}

	if(obj.data.famPolitica == 1){
		$("[name='famPolitica']").attr('checked', true);
	}

	if(obj.data.figPolitica == 1){
		$("[name='figPolitica']").attr('checked', true);
	}

	$("#cmbEstado").on('estadosloaded', function(){
		$(this).val(obj.data.idcEntidad);
	});

	$("#cmbMunicipio").on('municipiosloaded', function(){
		$(this).val(obj.data.idcMunicipio);
	});

	$("#cmbColonia").on('ciudadesloaded', function(){
		//$(this).val(obj.data.idcColonia);
	});

	$('#ddlTipoAcceso').on('accesosloaded',function(){
		$(this).val(obj.data.idTipoAcceso);
	});

	cargarEstados(obj.data.idPais);
	cargarMunicipios(obj.data.idPais, obj.data.idcEntidad);

	$.post(BASE_PATH + '/inc/Ajax/_Clientes/buscarColonia.php',
		{
			codigoPostal : obj.data.cpDireccion
		},
		function(response){
			if(response.codigoDeRespuesta == 0){
				$("#cmbColonia").on('coloniascargadas', function(){
					$(this).val(obj.data.idcColonia);
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
	//appendList("cmbColonia", response.listaColonias, {text :'nombreColonia', value : 'idColonia'});
}


function cargarEstados(idPais){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeEstados.php", "cmbEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
}

function cargarMunicipios(idPais, idEstado){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeMunicipios.php", "cmbMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
}

function cargarColonias(idPais, idEstado, idMunicipio){
	//cargarStore(BASE_PATH+"/inc/Ajax/stores/storeColonias.php", "cmbColonia", {idPais : idPais, idEstado : idEstado, idMunicipio : idMunicipio}, {text : 'descColonia', value : "idColonia"}, {}, 'ciudadesloaded');
}

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}