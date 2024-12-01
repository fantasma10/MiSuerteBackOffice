var idAfiliacion = 0;
var afiliacionInfo;
var estadoAgregarContacto = 0; //0 es Agregar y 1 es Editar
var estadoGuardarSucursal = 0; //0 es Agregar y 1 es Editar
var idContactoSeleccionado = 0; //0 significa que la variable no hay contacto seleccionado para Editar
var idSucursalContactoSeleccionada = 0; //0 significa que no hay sucursal para editar contacto
var minimoPuntos = 0;
var maximoPuntos = 0;
var totalContactos = 0;
var contactos = new Array(); //Guarda contactos en memoria de manera temporal

$(function(){
	$("#siguientePagina").on("click", function(){
		asignarReferenciasBancarias();
	});
	$("#guardarSucursal").on("click", function(){
		if ( estadoGuardarSucursal == 0 ) {
			guardarSucursal();
		} else if ( estadoGuardarSucursal == 1 ) {
			actualizarSucursal( idSucursalContactoSeleccionada );
		}
	});
	$("#agregarContacto").on("click", function(){
		if ( estadoAgregarContacto == 0 ) {
			agregarContacto();
		} else if ( estadoAgregarContacto == 1 ) {
			editarContacto( idContactoSeleccionado, idSucursalContactoSeleccionada );
		}
	});
	var idAfiliacionParam = getParametro("idCliente");
	if ( idAfiliacionParam ) {
		idAfiliacion = idAfiliacionParam;
		cargarAfiliacion(idAfiliacion);
	} else {
		idAfiliacion = 0;
	}
	/*$("#txtTelefono").on("focus", function(){
		RellenarTelefono();
	});
	$("#txtTelefonoContacto").on("focus", function(){
		RellenarTelefonoContacto();
	});*/
	$('body').on("tablaLlena", function(){
		$(".editarSucursal").on("click", function(){
			var id = $(this).attr("id");
			estadoGuardarSucursal = 1; //Estado cambia a Editar Sucursal
			idSucursalContactoSeleccionada = id;
			$("#guardarSucursal").html("Editar Sucursal");
			editarSucursal( id );
		});
		$(".eliminarSucursal").on("click", function(){
			if ( confirm("\u00BFRealmente desea borrar esta Sucursal?") ) {
				var id = $(this).attr("id");
				eliminarSucursal( id );
			}
		});										   
	});
});

function cargarAfiliacion( idAfiliacion ) {
	$.post( "../../inc/Ajax/_Afiliaciones/loadAfiliacion.php",
	{ idAfiliacion: idAfiliacion },
	function( respuesta ){
		if ( respuesta.success ) {
			afiliacionInfo = respuesta.data;
			if ( respuesta.data.tipoPersona == 1 ) {
				$("#encabezadoCliente").html(respuesta.data.nombrePersona + " " + respuesta.data.apPPersona + " " + respuesta.data.apMPersona);
			} else if ( respuesta.data.tipoPersona == 2 ) {
				$("#encabezadoCliente").html(respuesta.data.razonSocial);
			}
			if ( respuesta.data.tipoForelo == 2 ) { //Individual
				desplegarFORELO();
				$("#anteriorPagina").on("click", function() {
					var URL = "NumeroSucursales.php?idAfiliacion=" + idAfiliacion;
					window.location = URL;
				});
			} else if ( respuesta.data.tipoForelo == 1 ) { //Compartido
				$("#anteriorPagina").on("click", function() {
					var URL = "ConfiguracionCuenta.php?idAfiliacion=" + idAfiliacion;
					window.location = URL;
				});
			}
			desplegarContactos();
			if ( respuesta.data.numeroCorresponsales > 0 ) {
				$("#sucursalesInfo").attr("class", "adv-table");
			} else {
				$("#sucursalesInfo").attr("class", "adv-table ocultarSeccion");
			}
			minimoPuntos = respuesta.data.minimoPuntos;
			maximoPuntos = respuesta.data.maximoPuntos;
			cargarSucursales( idAfiliacion );
		} else {
			alert( respuesta.msg + " " + respuesta.errmsg );
		}
	}, "json");
}

function getParametro(val) {
	var result = null, tmp = [];
	location.search
	.substr(1)
		.split("&")
		.forEach(function (item) {
		tmp = item.split("=");
		if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
	});
	return result;
}

function desplegarFORELO() {
	var contenido = "<div class=\"titulosexpress-first\"><i class=\"fa fa-dollar\"></i> Comisiones y Reembolsos</div>";
	contenido += "<form class=\"form-horizontal\" name=\"formCuenta\" id=\"formCuenta\">";
	contenido += "<div class=\"form-group  margen\">";
	contenido += "<label class=\"col-xs-3 control-label\">Liquidaci&oacute;n de Comisiones:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<select class=\"form-control m-bot15\" name=\"comisiones\" id=\"cmbComisiones\">";
	contenido += "<option value=\"-1\">Seleccione</option>";
	contenido += "<option value=\"0\">FORELO</option>";
	contenido += "<option value=\"1\">Cuenta Bancaria</option>";
	contenido += "</select>";
	contenido += "</div>";
	contenido += "<label class=\"col-xs-3 control-label\">Reembolsos:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<select class=\"form-control m-bot15\" name=\"reembolso\" id=\"cmbReembolsos\">";
	contenido += "<option value=\"-1\">Seleccione</option>";
	contenido += "<option value=\"0\">FORELO</option>";
	contenido += "<option value=\"1\">Cuenta Bancaria</option>";
	contenido += "</select>";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "<div class=\"form-group confCuenta\">";
	contenido += "<label class=\"col-xs-3 control-label\">CLABE:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<input class=\"form-control m-bot15\" type=\"text\" name=\"CLABE\">";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "<div class=\"form-group confCuenta\">";
	contenido += "<label class=\"col-xs-3 control-label\">Banco:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<input class=\"form-control m-bot15\" name=\"idBanco\" type=\"hidden\" readonly=\"\" value=\"\">";
	contenido += "<input class=\"form-control m-bot15\" name=\"txtBanco\" type=\"text\" readonly=\"\">";
	contenido += "</div>";
	contenido += "<label class=\"col-xs-3 control-label\">Cuenta:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<input class=\"form-control m-bot15\" name=\"numCuenta\" type=\"text\" readonly=\"\">";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "<div class=\"form-group confCuenta\">";
	contenido += "<label class=\"col-xs-3 control-label\">Beneficiario:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<input class=\"form-control m-bot15\" name=\"beneficiario\" type=\"text\">";
	contenido += "</div>";
	contenido += "<label class=\"col-xs-3 control-label\">Descripción:</label>";
	contenido += "<div class=\"col-xs-3\">";
	contenido += "<input class=\"form-control m-bot15\" name=\"descripcion\" type=\"text\">";
	contenido += "</div>";
	contenido += "</div>";
	contenido += "</form>";
	contenido += "</div>";
	
	$("#seccionFORELO").html(contenido);
	$("#seccionFORELO").attr("class", "well");
	initComponentsCuenta();
}

function initDatosGeneralesSucursal() {
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeGiros.php", "cmbGiro", {}, {text : 'nombreGiro', value : "idGiro"}, {}, 'giroloaded');
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeTipoContacto.php", "cmbTipoContacto", {}, {text : 'descTipoContacto', value : "idTipoContacto"}, {}, 'tipocontactoloaded');
}

function cargarEstados(idPais){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeEstados.php", "cmbEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
}

function cargarMunicipios(idPais, idEstado){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeMunicipios.php", "cmbMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
}

function cargarColonias(idPais, idEstado, idMunicipio){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeColonias.php", "cmbColonia", {idPais : idPais, idEstado : idEstado, idMunicipio : idMunicipio}, {text : 'descColonia', value : "idColonia"}, {}, 'coloniasloaded');
}

function initComponents() {

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
	}

	$('[name="nombreCorresponsal"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 100
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
		autoCompletaGeneral('txtPais', 'idPais', BASE_PATH + '/inc/Ajax/_Clientes/getPaises.php', 'label', 'idPais', {}, null);
	});
	$("#txtPais").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑüÜ',
		allowOtherCharSets	: false,
		allowNumeric		: false
	});
	$("[name='calleDireccion']").alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});
	$("[name='numeroIntDireccion'], [name='numeroExtDireccion']").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});
	
	$('#txtTelefono').prop('maxlength', 15);
	$('#txtTelefono').alphanum({
		allow				: '-',
		allowLatin			: false,
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	
	$("#txtCP").prop('maxlength', 5);
	$("#txtCP").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$('[name="nombreContacto"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('[name="apellidoPaternoContacto"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
	$('[name="apellidoMaternoContacto"]').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
	$("[name='extension']").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 10
	});
	
	$("[name='correo']").alphanum({
		allow				: '-@.',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('#txtNombreContacto').prop('maxlength', 100);
	$('#txtApellidoPaternoContacto').prop('maxlength', 50);
	$('#txtApellidoMaternoContacto').prop('maxlength', 50);
	$('#txtTelefonoContacto').prop('maxlength', 15);
	$('#docComprobanteDomicilio').prop('maxlength', 45);
	$('#docCaratulaBanco').prop('maxlength', 45);
	$('#txtTelefonoContacto').alphanum({
		allow				: '-',
		allowLatin			: false,
		allowNumeric		: true,
		allowOtherCharSets	: false
	});	
	$('#txtExtension').prop('maxlength', 10);
	$('#txtCorreo').prop('maxlength', 100);

	$("#txtCP").on('keyup', function(){
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
						
						$("#cmbColonia").empty();
						$("#cmbColonia").append( "<option value=\"-1\">Seleccione</option>" );
						$.each( response.idColonia, function( index ) {
							$("#cmbColonia").append( "<option value=\"" + response.idColonia[index] + "\">" + response.nombre[index] + "</option>" );
						} );
						
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
	
	autoCompletarCalle();

	$("#calleDireccion").on('keyup', function(){
		var valor = event.target.value;

		if(valor.trim() == ""){
			$("#formGenerales").get(0).reset();
			$("#idDireccion").val(0);
		}
	});	
}

function initComponentsCuenta() {
	$("#cmbReembolsos, #cmbComisiones").on('change', function(){
		/* obtener id y valor del combo que ha sido cambiado su valor */
		var id = event.target.id;
		var value = event.target.value;

		var cfg = {
			cmbReembolsos : 'cmbComisiones',
			cmbComisiones : 'cmbReembolsos'
		}

		/* obtener valor del otro combo  */
		var cmb = eval("cfg."+id);
		var valor = $("#"+cmb).val();

		if(value == 1 || valor == 1){
			$(".confCuenta").show();
		}
		else{
			$(".confCuenta").hide();
		}
	});

	$("[name='CLABE']").numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		maxDigits			: 18
	});

	$(":input").bind("paste", function(){return false;});

	$("[name='CLABE']").unbind("paste");
	
	$("[name='CLABE']").bind('paste', analizarCLABE);
	$("[name='CLABE']").on('keyup', analizarCLABE);

	$("[name='numCuenta'], [name='idBanco'], [name='txtBanco']").prop('readonly', true);

	$("[name='numCuenta']").numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		maxDigits			: 11
	});

	$("[name='beneficiario']").alphanum({
		allowNumeric		: false,
		allow				: "áéíóúñÁÉÍÓÚÑ",
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$("[name='descripcion']").alphanum({
		allowNumeric		: true,
		allow				: "áéíóúñÁÉÍÓÚÑ@-_.",
		allowOtherCharSets	: false,
		maxLength			: 30
	});

	$("#btnNext").on('click', function(){
		guardarConfiguracionCuenta();
	});	
}

/*function RellenarTelefono() {
	if ( document.getElementById("txtTelefono") ) {
		if ( txtValue("txtTelefono") == '' ) {
			document.getElementById("txtTelefono").value = "52-";
			$("#txtTelefono").putCursorAtEnd();
		}
	}	
}

function RellenarTelefonoContacto() {
	if ( document.getElementById("txtTelefonoContacto") ) {
		if ( txtValue("txtTelefonoContacto") == '' ) {
			document.getElementById("txtTelefonoContacto").value = "52-";
			$("#txtTelefonoContacto").putCursorAtEnd();
		}
	}	
}*/

function existeContacto( contacto ) {
	var existe = false;
	for ( var i = 0; i < contactos.length; i++ ) {
		if ( contacto.nombre == contactos[i].nombre &&
		contacto.apellidoPaterno == contactos[i].apellidoPaterno &&
		contacto.apellidoMaterno == contactos[i].apellidoMaterno &&
		contacto.telefono == contactos[i].telefono &&
		contacto.extension == contactos[i].extension &&
		contacto.correo == contactos[i].correo &&
		contacto.tipoContacto == contactos[i].tipoContacto ) {
			existe = true;
			break;
		}
	}
	return existe;
}

function agregarContacto() {
	//Contacto
	var nombre = $("#txtNombreContacto").val();
	var apellidoPaterno = $("#txtApellidoPaternoContacto").val();
	var apellidoMaterno = $("#txtApellidoMaternoContacto").val();
	var telefono = $("#txtTelefonoContacto").val();
	var extension = $("#txtExtension").val();
	var correo = $("#txtCorreo").val();
	var tipoContacto = $("#cmbTipoContacto").val();
	
	$("#formContacto").submit(false);
	
	if ( !validaTelefono('txtTelefonoContacto') ) {
		alert("El formato del Tel\u00E9fono del Contacto es incorrecto");
		return false;
	}	
	
	if ( !validarEmail('txtCorreo') ) {
		alert("El formato de Correo es incorrecto");
		return false;
	}
	
	telefono = telefono.replace( /-/g, "" );

	var contacto = 	{
		nombre: nombre,
		apellidoPaterno: apellidoPaterno,
		apellidoMaterno: apellidoMaterno,
		telefono: telefono,
		extension: extension,
		correo: correo,
		tipoContacto: tipoContacto
	}
	
	if ( !existeContacto( contacto ) ) {
		//Agrega contacto al final del arreglo de contactos
		contactos.push(contacto);
	}
	
	/*$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/agregarContacto2.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursalContactoSeleccionada, nombre: nombre, apellidoPaterno: apellidoPaterno, apellidoMaterno: apellidoMaterno,
	telefono: telefono, extension: extension, correo: correo, tipo: tipoContacto },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			desplegarContactos( respuesta.idSucursal );
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");*/
}

function editarContacto( idContacto, idSucursal ) {
	//Contacto
	var nombre = $("#txtNombreContacto").val();
	var apellidoPaterno = $("#txtApellidoPaternoContacto").val();
	var apellidoMaterno = $("#txtApellidoMaternoContacto").val();
	var telefono = $("#txtTelefonoContacto").val();
	var extension = $("#txtExtension").val();
	var correo = $("#txtCorreo").val();
	var tipoContacto = $("#cmbTipoContacto").val();
	
	$("#formContacto").submit(false);
	
	if ( !validaTelefono('txtTelefonoContacto') ) {
		alert("El formato del Tel\u00E9fono del Contacto es incorrecto");
		return false;
	}	
	
	if ( !validarEmail('txtCorreo') ) {
		alert("El formato de Correo es incorrecto");
		return false;
	}
	
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/editarContacto.php",
	{ idContacto: idContacto, idAfiliacion: idAfiliacion, idSucursal: idSucursal, nombre: nombre, apellidoPaterno: apellidoPaterno, apellidoMaterno: apellidoMaterno,
	telefono: telefono, extension: extension, correo: correo, tipo: tipoContacto },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			desplegarContactos( idSucursal );
			cargarSucursales( idAfiliacion );
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");	
}

function desplegarContactoInfo( idContacto, idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/getContacto.php",
	{ idContacto: idContacto, idAfiliacion: idAfiliacion },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			$("#txtNombreContacto").val( respuesta.contacto.nombre );
			$("#txtApellidoPaternoContacto").val( respuesta.contacto.apPaterno );
			$("#txtApellidoMaternoContacto").val( respuesta.contacto.apMaterno );
			$("#txtTelefonoContacto").val( respuesta.contacto.telefono );
			$("#txtExtension").val( respuesta.contacto.extension );
			$("#txtCorreo").val( respuesta.contacto.correo );
			$("#cmbTipoContacto").val( respuesta.contacto.tipoContactoID );
			$("#agregarContacto").html("Editar <i class=\"fa fa-plus\"></i>");
			estadoAgregarContacto = 1;
			idContactoSeleccionado = idContacto;
			idSucursalContactoSeleccionada = idSucursal;
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function eliminarContacto( idSucursal, idContacto ) {
	//Contacto
	var nombre = $("#txtNombreContacto").val();
	var apellidoPaterno = $("#txtApellidoPaternoContacto").val();
	var apellidoMaterno = $("#txtApellidoMaternoContacto").val();
	var telefono = $("#txtTelefonoContacto").val();
	var extension = $("#txtExtension").val();
	var correo = $("#txtCorreo").val();
	var tipoContacto = $("#cmbTipoContacto").val();
	
	$("#formContacto").submit(false);
	
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/eliminarContacto.php",
	{ idContacto: idContacto, idAfiliacion: idAfiliacion, nombre: nombre, apellidoPaterno: apellidoPaterno, apellidoMaterno: apellidoMaterno,
	telefono: telefono, extension: extension, correo: correo, tipo: tipoContacto, idSucursal: idSucursal },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			desplegarContactos( idSucursal );
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function desplegarContactos( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/loadContactos.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			if ( respuesta.contactos.length > 0 ) {
				var nodosHijoTabla = $("#infoContactos > tbody").children().length;
				var contenido = "";
				$.each( respuesta.contactos, function( index, contacto ){
					contenido += "<tr id=\"" + respuesta.idSucursal + "-" + contacto.idContacto + "\">";
					contenido += "<td>" + contacto.nombre + " " + contacto.apellidoPaterno + " " + contacto.apellidoMaterno + "</td>";
					contenido += "<td class=\"tdder\">" + contacto.telefono + "</td>";
					contenido += "<td class=\"tdder\">" + contacto.extension + "</td>";
					contenido += "<td>" + contacto.correo + "</td>";
					contenido += "<td>" + contacto.descTipoContacto + "</td>";
					contenido += "<td><i class=\"fa fa-pencil editarInfoContacto\"></i></td>";
					contenido += "<td><i class=\"fa fa-times eliminarInfoContacto\"></i></td>";
					contenido += "</tr>";
				});
				$("#infoContactos > tbody").html(contenido);
				$("#infoContactos").attr("class", "express");
				$("#agregarContacto").html("Agregar <i class=\"fa fa-plus\"></i>");
				estadoAgregarContacto = 0;
				idContactoSeleccionado = 0;
				$(".editarInfoContacto").on("click", function(){			
					var idNodo = $(this).parent().parent().attr("id");
					var idContacto = idNodo.split("-")[1];
					var idSucursal = idNodo.split("-")[0];
					desplegarContactoInfo( idContacto, idSucursal );
				});
				$(".eliminarInfoContacto").on("click", function(){
					var idNodo = $(this).parent().parent().attr("id");
					var idSucursal = idNodo.split("-")[0];
					var idContacto = idNodo.split("-")[1];
					if ( confirm("\u00BFRealmente desea borrar este contacto?") ) {
						eliminarContacto( idSucursal, idContacto );
					}
				});
				$("#txtNombreContacto").val("");
				$("#txtApellidoPaternoContacto").val("");
				$("#txtApellidoMaternoContacto").val("");
				$("#txtTelefonoContacto").val("");
				$("#txtExtension").val("");
				$("#txtCorreo").val("");
				$("#cmbTipoContacto").val(-1);
				totalContactos = respuesta.contactos.length;
			} else {
				totalContactos = 0;
				$("#infoContactos").attr("class", "express ocultarSeccion");
			}
		} else {
			//alert( respuesta.mensaje );
		}
	}, "json");
}

function filtrarArchivos(file){
	var archivo = document.getElementById(file).value;
	var ext = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
	if(ext == ".jpg" || ext == ".pdf")
	   return true;
	return false;       
}

function guardarSucursal() {
	//Datos Generales
	var nombreSucursal = $("#nombreCorresponsal").val();
	var idGiro = $("#cmbGiro").val();
	var idPais = $("#idPais").val();
	var calle = $("#calleDireccion").val();
	var numeroInterior = $("#numeroIntDireccion").val();
	var numeroExterior = $("#numeroExtDireccion").val();
	var codigoPostal = $("#txtCP").val();
	var idColonia = $("#cmbColonia").val();
	var idEstado = $("#cmbEstado").val();
	var idMunicipio = $("#cmbMunicipio").val();
	var telefono = $("#txtTelefono").val();
	
	//Comisiones y Reembolsos
	var comisiones = $("#cmbComisiones").val();
	var reembolso = $("#cmbReembolsos").val();
	var CLABE = $("[name='CLABE']").val();
	var idBanco = $("[name='idBanco']").val();
	var numCuenta = $("[name='numCuenta']").val();
	var beneficiario = $("[name='beneficiario']").val();
	var descripcion = $("[name='descripcion']").val();
	
	if ( !validaTelefono('txtTelefono') ) {
		alert("El formato del Tel\u00E9fono en Datos Generales es incorrecto");
		return false;
	}
	
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/guardarSucursal.php",
	{ idAfiliacion: idAfiliacion, nombreSucursal: nombreSucursal, idGiro: idGiro, idPais: idPais, calle: calle,
	numeroInterior: numeroInterior, numeroExterior: numeroExterior, codigoPostal: codigoPostal,
	idColonia: idColonia, idEstado: idEstado, idMunicipio: idMunicipio, telefono: telefono,
	comisiones: comisiones, reembolso: reembolso, CLABE: CLABE, idBanco: idBanco, numCuenta: numCuenta,
	beneficiario: beneficiario, descripcion: descripcion, totalContactos : totalContactos },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var idSucursal = respuesta.idCorresponsal;
			var URL = $("#formDocumentacion").attr("action");
			URL += "?idAfiliacion=" + idAfiliacion + "&idSucursal=" + idSucursal;
			$("#formDocumentacion").attr( "action", URL );
			$("#formDocumentacion").submit();
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function analizarCLABE(){
	var CLABE = event.target.value;

	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("[name='idBanco']").val(banco.bancoID);
					$("[name='txtBanco']").val(banco.nombreBanco);
					$("[name='numCuenta']").val(CLABE.substring(6, 17));			
			});
		}
		else{
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
	}
}

function analizarCLABE2( CLABE ){
	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("[name='idBanco']").val(banco.bancoID);
					$("[name='txtBanco']").val(banco.nombreBanco);
					$("[name='numCuenta']").val(CLABE.substring(6, 17));			
			});
		}
		else{
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
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

	if ( digitoVerificador == 10 ) {
		digitoVerificador = 0;
	}

	return CLABE.charAt(17) == digitoVerificador;
	
}

function cargarSucursales( idAfiliacion ) {
	var tabla = "<table class=\"display table table-bordered table-striped dataTable\" id=\"tblListaCorresponsales\" aria-describedby=\"tblListaCorresponsales_info\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>Giro</th>";
	tabla += "<th>Nombre</th>";
	tabla += "<th>Direcci&oacute;n</th>";
	tabla += "<th>Tel&eacute;fono</th>";
	tabla += "<th>Contacto</th>";
	tabla += "<th>Editar</th>";
	tabla += "<th>Eliminar</th>";
	tabla += "</tr>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#sucursalesInfo").html(tabla);
	
	var params = {
		idAfiliacion : ID_AFILIACION
	}
	
	llenaDataTable("tblListaCorresponsales", params, BASE_PATH + "/inc/Ajax/_Afiliaciones/getSucursales.php");
}

function editarSucursal( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/cargarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var sucursal = respuesta.sucursal;
			$("#nombreCorresponsal").val( sucursal.nombre );
			$("#cmbGiro").val( sucursal.idGiro );
			$("#idPais").val( sucursal.idPais );
			$("#calleDireccion").val( sucursal.calleDireccion );
			$("#numeroIntDireccion").val( sucursal.numeroIntDireccion );
			$("#numeroExtDireccion").val( sucursal.numeroExtDireccion );
			$("#txtCP").val( sucursal.codigoPostal );
			$("#cmbColonia").val( sucursal.idColonia );
			$("#txtTelefono").val( sucursal.telefono );
			
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/buscarColonia.php',
				{
					codigoPostal : sucursal.codigoPostal
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
						
						$("#cmbColonia").empty();
						$("#cmbColonia").append( "<option value=\"-1\">Seleccione</option>" );
						$.each( response.idColonia, function( index ) {
							$("#cmbColonia").append( "<option value=\"" + response.idColonia[index] + "\">" + response.nombre[index] + "</option>" );
						} );
						
						$("#cmbColonia").val( sucursal.idColonia );
						
					}else{
						limpiaStore("cmbEstado");
						limpiaStore("cmbMunicipio");
						limpiaStore("cmbColonia");

						alert(response.mensajeDeRespuesta);
					}
				},
				"json"
			);			
			
			desplegarContactos( idSucursal );
			
			if ( respuesta.tipoFORELO == 2 ) {
				//Comisiones y Reembolsos
				$("#cmbComisiones").val(sucursal.comisiones);
				$("#cmbReembolsos").val(sucursal.reembolso);
				if ( sucursal.comisiones == 1 || sucursal.reembolso == 1 ) {
					$("[name='CLABE']").val(sucursal.CLABE);
					$("[name='idBanco']").val(sucursal.idBanco);
					$("[name='numCuenta']").val(sucursal.numCuenta);
					$("[name='beneficiario']").val(sucursal.beneficiario);
					$("[name='descripcion']").val(sucursal.descripcion);
					analizarCLABE2( sucursal.CLABE );
					$(".confCuenta").show();
				} else {
					$("[name='CLABE']").val("");
					$("[name='idBanco']").val("");
					$("[name='txtBanco']").val("");
					$("[name='numCuenta']").val("");
					$("[name='beneficiario']").val("");
					$("[name='descripcion']").val("");					
					$(".confCuenta").hide();
				}
			}
			
		} else {
			alert( respuesta.mensaje );	
		}
	}, "json");
}

function actualizarSucursal( idSucursal ) {
	//Datos Generales
	var nombreSucursal = $("#nombreCorresponsal").val();
	var idGiro = $("#cmbGiro").val();
	var idPais = $("#idPais").val();
	var calle = $("#calleDireccion").val();
	var numeroInterior = $("#numeroIntDireccion").val();
	var numeroExterior = $("#numeroExtDireccion").val();
	var codigoPostal = $("#txtCP").val();
	var idColonia = $("#cmbColonia").val();
	var idEstado = $("#cmbEstado").val();
	var idMunicipio = $("#cmbMunicipio").val();
	var telefono = $("#txtTelefono").val();
	
	//Comisiones y Reembolsos
	var comisiones = $("#cmbComisiones").val();
	var reembolso = $("#cmbReembolsos").val();
	var CLABE = $("[name='CLABE']").val();
	var idBanco = $("[name='idBanco']").val();
	var numCuenta = $("[name='numCuenta']").val();
	var beneficiario = $("[name='beneficiario']").val();
	var descripcion = $("[name='descripcion']").val();
	
	if ( !filtrarArchivos("docComprobanteDomicilio") ) {
		alert("Los documentos solo pueden ser PDF o JPG en los sig. archivos: Comprobante de Domicilio");
		return false;
	}
	
	if ( !filtrarArchivos("docCaratulaBanco") ) {
		alert("Los documentos solo pueden ser PDF o JPG en los sig. archivos: Car\u00E1tula de Banco");
		return false;
	}
	
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/actualizarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal, nombreSucursal: nombreSucursal, idGiro: idGiro, idPais: idPais, calle: calle,
	numeroInterior: numeroInterior, numeroExterior: numeroExterior, codigoPostal: codigoPostal,
	idColonia: idColonia, idEstado: idEstado, idMunicipio: idMunicipio, telefono: telefono,
	comisiones: comisiones, reembolso: reembolso, CLABE: CLABE, idBanco: idBanco, numCuenta: numCuenta,
	beneficiario: beneficiario, descripcion: descripcion, totalContactos : totalContactos },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var idSucursal = respuesta.idCorresponsal;
			var URL = BASE_PATH + "/inc/Ajax/_Afiliaciones/actualizarDocumentacion.php?idAfiliacion=" + idAfiliacion + "&idSucursal=" + idSucursalContactoSeleccionada;
			$("#formDocumentacion").attr( "action", URL );
			$("#formDocumentacion").submit();
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function eliminarSucursal( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/eliminarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			var URL = BASE_PATH + "/_Clientes/Afiliaciones/formnew5.php?idAfiliacion=" + idAfiliacion;
			$("#formDocumentacion").attr( "action", URL );
			$("#formDocumentation").removeAttr("enctype");
			$("#formDocumentacion").submit();
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function asignarReferenciasBancarias() {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/asignarReferenciasBancariasSucursal.php",
	{ idAfiliacion: idAfiliacion }, function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var URL = BASE_PATH + "/_Clientes/Afiliaciones/TerminosYCondiciones.php?idAfiliacion=" + idAfiliacion;
			window.location = URL;
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function autoCompletarCalle(){
	$("#calleDireccion").autocomplete({
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
			$("#calleDireccion").val(select);
			$("#idDireccion").val("");
			return false;
		},
		select: function( event, ui ) {
			var id = ui.item.idDireccion;
			$("#idDireccion").val(id);
			simpleFillForm(ui.item, "formGenerales", "");

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

			$("#formGenerales :input").on('change', function(){
				$("#idDireccion").val(0);
			});

			return false;
		},
		close: function(event, ui){
			var valorId = $("#idDireccion").val();
			if(valorId == "" || valorId == undefined){
				$("#calleDireccion").val("");
			}
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + item.calleDireccion + "</a>" )
		.appendTo( ul );
	};
}