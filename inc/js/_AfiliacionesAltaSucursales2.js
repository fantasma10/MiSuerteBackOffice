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
var contactoAgregado = 0; //0 es falso, 1 es verdadero
var permitirGuardarSucursal = true;

$(function(){
	$("#siguientePagina").on("click", function(){
		asignarReferenciasBancarias();
	});
	$("#guardarSucursal").on("click", function(){
		if ( permitirGuardarSucursal ) {
			if ( estadoGuardarSucursal == 0 ) {
				guardarSucursal();
			} else if ( estadoGuardarSucursal == 1 ) {
				actualizarSucursal( idSucursalContactoSeleccionada );
			}
		}
	});

	
	$("#agregarContacto").on("click", function(){
		if ( estadoAgregarContacto == 0 ) {
			agregarContactoTemporal();
		} else if ( estadoAgregarContacto == 1 ) {
			//console.log(contactos);
			if ( idSucursalContactoSeleccionada == "temp" ) {
				editarContactoTemporal( idContactoSeleccionado, idSucursalContactoSeleccionada );
			} else {
				editarContacto( idContactoSeleccionado, idSucursalContactoSeleccionada );
			}
		}
	});
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

function desplegarContactos( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/loadContactos.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			if ( respuesta.contactos.length > 0 ) {
				//contactos = new Array();
				var nodosHijoTabla = $("#infoContactos > tbody").children().length;
				var contenido = "";
				if ( nodosHijoTabla == 0 ) {
					$.each( contactos, function( index, contacto ){
						var tel = "";
						for ( var i = 0; i < contacto.telefono.length; i++ ) {
							if ( i % 2 == 0 && i != 0 ) {
								tel += "-" + contacto.telefono.charAt(i);
							} else {
								tel +=  contacto.telefono.charAt(i);
							}
						}						
						/*for ( var i = 0; i < contacto.telefono.length; i++ ) {
							if ( i % 2 == 0 && i != 0 && i != (contacto.telefono.length - 1) ) {
								tel += "-" + contacto.telefono.charAt(i);
							} else {
								tel +=  contacto.telefono.charAt(i);
							}
						}*/
						/*for ( var i = 0; i < contacto.telefono.length; i++ ) {
							if ( i == 2 || i == 5 || i == 8 ) {
								tel += "-" + contacto.telefono.charAt(i);
							} else {
								tel += contacto.telefono.charAt(i);
							}
						}*/
						contenido += "<tr id=\"temp" + "-" + index + "\">";
						contenido += "<td>" + contacto.nombre + " " + contacto.apellidoPaterno + " " + contacto.apellidoMaterno + "</td>";
						//contenido += "<td class=\"tdder\">" + contacto.telefono + "</td>";
						contenido += "<td class=\"tdder\">" + tel + "</td>";
						contenido += "<td class=\"tdder\">" + contacto.extension + "</td>";
						contenido += "<td>" + contacto.correo + "</td>";
						contenido += "<td>" + contacto.nombreTipoContacto + "</td>";
						contenido += "<td><i class=\"fa fa-pencil editarInfoContacto\"></i></td>";
						contenido += "<td><i class=\"fa fa-times eliminarInfoContacto\"></i></td>";
						contenido += "</tr>";
					});
				}
				$.each( respuesta.contactos, function( index, contacto ){
					var tel = "";
					for ( var i = 0; i < contacto.Telefono.length; i++ ) {
						if ( i % 2 == 0 && i != 0 ) {
							tel += "-" + contacto.Telefono.charAt(i);
						} else {
							tel +=  contacto.Telefono.charAt(i);
						}
					}					
					/*for ( var i = 0; i < contacto.Telefono.length; i++ ) {
						if ( i % 2 == 0 && i != 0 && i != (contacto.Telefono.length - 1) ) {
							tel += "-" + contacto.Telefono.charAt(i);
						} else {
							tel +=  contacto.Telefono.charAt(i);
						}
					}*/
					/*for ( var i = 0; i < contacto.Telefono.length; i++ ) {
						if ( i == 2 || i == 5 || i == 8 ) {
							tel += "-" + contacto.Telefono.charAt(i);
						} else {
							tel += contacto.Telefono.charAt(i);
						}
					}*/
					contenido += "<tr id=\"" + respuesta.idSucursal + "-" + contacto.id + "\">";
					contenido += "<td>" + contacto.Nombre + " " + contacto.Paterno + " " + contacto.Materno + "</td>";
					//contenido += "<td class=\"tdder\">" + contacto.Telefono + "</td>";
					contenido += "<td class=\"tdder\">" + tel + "</td>";
					contenido += "<td class=\"tdder\">" + contacto.Extension + "</td>";
					contenido += "<td>" + contacto.Correo + "</td>";
					contenido += "<td>" + contacto.descTipoContacto + "</td>";
					contenido += "<td><i class=\"fa fa-pencil editarInfoContacto\"></i></td>";
					contenido += "<td><i class=\"fa fa-times eliminarInfoContacto\"></i></td>";
					contenido += "</tr>";
					var contacto = 	{
						nombre: contacto.Nombre,
						apellidoPaterno: contacto.Paterno,
						apellidoMaterno: contacto.Materno,
						telefono: contacto.Telefono,
						extension: contacto.Extension,
						correo: contacto.Correo,
						tipoContactoID: contacto.idTipo,
						nombreTipoContacto : contacto.descTipoContacto,
						idSucursal: idSucursal,
						idContactoBD: contacto.id
					}
					if ( !existeContacto( contacto ) ) {
						//Agrega contacto al final del arreglo de contactos
						contactos.push(contacto);
					}
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
			//alert("idSucursal: " + idSucursal);
			//alert("idContacto: " + idContacto);
			if ( contactos != null && contactos.length > 0 ) {
				for ( var i = 0; i < contactos.length; i++ ) {
					if ( contactos[i].idSucursal != "temp" ) {
						if ( contactos[i].idContactoBD == idContacto ) {
							contactos.splice( i, 1 );
						}
					}
				}
				//contactos.splice( idContacto, 1 );
			}
			console.log("idContacto: " + idContacto);
			console.log(contactos);
			desplegarContactos( idSucursal );
			contactoAgregado = 0;
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function desplegarContactoInfo( idContacto, idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/getContacto.php",
	{ idContacto: idContacto, idAfiliacion: idAfiliacion, idSucursal: idSucursal },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			var tel = "";
			for ( var i = 0; i < respuesta.contacto.Telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 ) {
					tel += "-" + respuesta.contacto.Telefono.charAt(i);
				} else {
					tel +=  respuesta.contacto.Telefono.charAt(i);
				}
			}			
			/*for ( var i = 0; i < respuesta.contacto.Telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 && i != (respuesta.contacto.Telefono.length - 1) ) {
					tel += "-" + respuesta.contacto.Telefono.charAt(i);
				} else {
					tel +=  respuesta.contacto.Telefono.charAt(i);
				}
			}*/
			//alert("tel: " + tel);
			/*for ( var i = 0; i < respuesta.contacto.Telefono.length; i++ ) {
				if ( i == 2 || i == 5 || i == 8 ) {
					tel += "-" + respuesta.contacto.Telefono.charAt(i);
				} else {
					tel += respuesta.contacto.Telefono.charAt(i);
				}
			}*/			
			$("#txtNombreContacto").val( respuesta.contacto.Nombre );
			$("#txtApellidoPaternoContacto").val( respuesta.contacto.Paterno );
			$("#txtApellidoMaternoContacto").val( respuesta.contacto.Materno );
			//$("#txtTelefonoContacto").val( respuesta.contacto.Telefono );
			$("#txtTelefonoContacto").val( tel );
			$("#txtExtension").val( respuesta.contacto.Extension );
			$("#txtCorreo").val( respuesta.contacto.Correo );
			$("#cmbTipoContacto").val( respuesta.contacto.idTipo );
			$("#agregarContacto").html("Editar <i class=\"fa fa-plus\"></i>");
			estadoAgregarContacto = 1;
			idContactoSeleccionado = idContacto;
			idSucursalContactoSeleccionada = idSucursal;
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function cargarAfiliacion( idAfiliacion ) {
	$.post( "../../inc/Ajax/_Afiliaciones/loadAfiliacion.php",
	{ idAfiliacion: idAfiliacion },
	function( respuesta ){
		if ( respuesta.success ) {
			afiliacionInfo = respuesta.data;
			/*if ( respuesta.data.tipoPersona == 1 ) {
				$("#encabezadoCliente").html(respuesta.data.nombrePersona + " " + respuesta.data.apPPersona + " " + respuesta.data.apMPersona);
			} else if ( respuesta.data.tipoPersona == 2 ) {
				$("#encabezadoCliente").html(respuesta.data.razonSocial);
			}*/
			$("#encabezadoCliente").html(respuesta.data.nombreCompletoCliente);
			if ( respuesta.data.tipoForelo == 2 ) { //Individual
				desplegarFORELO();
				$("#anteriorPagina").on("click", function() {
					var URL = "NumeroSucursales.php?idCliente=" + idAfiliacion;
					window.location = URL;
				});
			} else if ( respuesta.data.tipoForelo == 1 ) { //Compartido
				$("#anteriorPagina").on("click", function() {
					var URL = "ConfiguracionCuenta.php?idCliente=" + idAfiliacion;
					window.location = URL;
				});
			}
			//desplegarContactos();
			if ( respuesta.data.numeroCorresponsales > 0 ) {
				//alert("idSucursal: " + idSucursal);
				//alert("TEST");
				//alert("idSUcurs");
				var idSucursalParam = getParametro("idSucursal");
				//alert("idSucursalParam: " + idSucursalParam);
				if ( idSucursalParam && idSucursalParam != 0 ) {
					$("#sucursalesInfo").attr("class", "adv-table ocultarSeccion");
				} else {
					$("#sucursalesInfo").attr("class", "adv-table");
				}
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

function initComponents() {
	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	if(!ES_CONSULTA){
		if(!ES_CONSULTA_SUC){
			$('.esconsultas').hide();
			$('.esconsulta').hide();
			$('.noesconsulta').show();
		}
		else{
			$('.esconsultas').show();
			$('.esconsulta').hide();
			$('.noesconsulta').hide();


			$("#formAgregarSucursal").remove();
			$("#divBtns").append('<a class="" href="#" id="guardarSucursalC"><button class="btn btn-xs btn-info pull-right"> Editar Sucursal</button></a>');

			$("#guardarSucursalC").on("click", function(){
				if(estadoGuardarSucursal == 0){
					guardarSucursal();
				}
				else if(estadoGuardarSucursal == 1){
					actualizarSucursal(idSucursalContactoSeleccionada);
				}
			});	
		}
	}
	else{
		$('.esconsulta').show();
		$('.esconsultas').hide();
		$('.noesconsulta').hide();
	}
	
	$('[name="nombreCorresponsal"]').alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 45
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
			//$("#" +arr[tip] + last).val(-1);
			$("#" +arr[tip] + last).val(0);
		}
		autoCompletaGeneral('txtPais', 'idPais', BASE_PATH + '/inc/Ajax/_Clientes/getPaises.php', 'label', 'idPais', {}, null);
	});
	
	$("#txtPais").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowOtherCharSets	: false,
		allowNumeric		: false
	});
	
	$("[name='calleDireccion']").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
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
	
	$('#txtTelefono').prop('maxlength', 20);
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
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('[name="apellidoPaternoContacto"]').alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
	$('[name="apellidoMaternoContacto"]').alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});
	
	$("[name='extension']").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		allowLatin			: false,
		maxLength			: 10
	});
	
	$("[name='correo']").alphanum({
		allow				: '_-@.',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$('#txtNombreContacto').prop('maxlength', 100);
	$('#txtApellidoPaternoContacto').prop('maxlength', 50);
	$('#txtApellidoMaternoContacto').prop('maxlength', 50);
	$('#txtTelefonoContacto').prop('maxlength', 20);
	//$('#txtTelefonoContacto').prop('maxlength', 15);
	$('#txtTelefonoContacto').alphanum({
		allow				: '-',
		allowLatin			: false,
		allowNumeric		: true,
		allowOtherCharSets	: false
	});
	
	$('#txtExtension').prop('maxlength', 10);
	$('#txtCorreo').prop('maxlength', 100);
	
	$("#txtCP").on('keyup', function(event){
		var value = event.target.value;
		value = value.trim();
		var idPais = $("#idPais").val();
		//alert("idPais: " + idPais);
		if(value.length == 5 && idPais > 0){
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
	
	$("#txtPais").on('keyup', function(event){
		var valor = event.target.value;
		if ( valor.trim() == "" ) {
			$("#txtPais").val(0);
		}
	});
	
	$("#calleDireccion").on('keyup', function(event){
		var valor = event.target.value;
		if(valor.trim() == ""){
			//$("#formGenerales :input[name!='telefono'][name!='nombreCorresponsal'][name!='idGiro']").val("");
			//$("[name='idcColonia']").val(-1);
			//$("[name='idcEntidad']").val(-1);
			//$("[name='idcMunicipio']").val(-1);
			$("#idDireccion").val(0);
			$("#origen").val(1);
		}
	});
	
	$("#formGenerales :input[name!='telefono'][name!='nombreCorresponsal'][name!='idGiro']").on('change', function(){
		$("#idDireccion").val(0);
		$("#origen").val(1);
		//alert("Hubo un cambio en la direccion y el origen es: " + $("#origen").val() + " la direccion debe ser nueva");
	});
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
			//$("#idDireccion").val("");
			return false;
		},
		select: function( event, ui ) {
			var id = ui.item.idDireccion;
			var origen = ui.item.origen;
			//alert("id: " + id);
			if ( origen == 1 ) {
				$("#idDireccion").val(id);
				$("#origen").val(origen);
			} else if ( origen == 0 ) {
				$("#idDireccion").val(id);
				$("#origen").val(origen);				
			}
			//$("#idDireccion").val(id);
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
			
			/*$("#formGenerales :input[name!='telefono'][name!='nombreCorresponsal'][name!='idGiro']").on('change', function(){
				$("#idDireccion").val(0);
				$("#origen").val(1);
			});*/

			return false;
		},
		close: function(event, ui){
			var valorId = $("#idDireccion").val();
			if(valorId == "" || valorId == undefined){
				//$("#calleDireccion").val("");
			}
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + item.calleDireccion + "</a>" )
		.appendTo( ul );
	};
}

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

function agregarContactoTemporal() {
	//Contacto
	var nombre = $("#txtNombreContacto").val();
	var apellidoPaterno = $("#txtApellidoPaternoContacto").val();
	var apellidoMaterno = $("#txtApellidoMaternoContacto").val();
	var telefono = $("#txtTelefonoContacto").val();
	var extension = $("#txtExtension").val();
	var correo = $("#txtCorreo").val();
	var tipoContactoID = $("#cmbTipoContacto").val();
	var tipoContactoDescripcion = $("#cmbTipoContacto option:selected").text();
	
	$("#formContacto").submit(false);
	
	if ( telefono.length < 10 ) {
		alert("La longitud del Tel\u00E9fono no puede ser menor a 10 digitos. Si ha escrito un n\u00FAmero local, favor de hacerlo con clave LADA.");
		return false;
	}	
	
	if ( !validaTelefonoAB('txtTelefonoContacto') ) {
		alert("El formato del Tel\u00E9fono del Contacto es incorrecto");
		return false;
	}	
	
	if ( !validarEmail('txtCorreo') ) {
		alert("El formato de Correo es incorrecto");
		return false;
	}
	
	if ( nombre == "" ) {
		alert("Favor de capturar el nombre del Contacto");
		return false;
	}
	
	if ( apellidoPaterno == "" ) {
		alert("Favor de capturar el apellido paterno del Contacto");
		return false;
	}
	
	if ( apellidoMaterno == "" ) {
		alert("Favor de capturar el apellido materno del Contacto");
		return false;
	}
	
	/*if ( extension == "" ) {
		alert("Favor de escribir la extens\u00F3n del Contacto");
		return false;
	}*/
	
	if ( tipoContactoID < 0 ) {
		alert("Favor de seleccionar el tipo del Contacto");
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
		tipoContactoID: tipoContactoID,
		nombreTipoContacto : tipoContactoDescripcion,
		idSucursal : "temp"
	}
	
	if ( !existeContacto( contacto ) ) {
		//Agrega contacto al final del arreglo de contactos
		contactos.push(contacto);
	}else{
		alert("Lo sentimos. Ese contacto ya existe para este cliente");
	}
	
	desplegarContactosTemporales( contactos );
	
	estadoAgregarContacto = 0;
	idContactoSeleccionado = 0;
	contactoAgregado = 1;
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

function desplegarContactoInfoTemporal( idContacto, idSucursal ) {
	$("#txtNombreContacto").val( contactos[idContacto].nombre );
	$("#txtApellidoPaternoContacto").val( contactos[idContacto].apellidoPaterno );
	$("#txtApellidoMaternoContacto").val( contactos[idContacto].apellidoMaterno );
	var telefono = contactos[idContacto].telefono;
	var tel = "";
	/*for ( var i = 0; i < telefono.length; i++ ) {
		if ( i == 2 || i == 5 || i == 8 ) {
			tel += "-" + telefono.charAt(i);
		} else {
			tel += telefono.charAt(i);
		}
	}*/
	/*for ( var i = 0; i < telefono.length; i++ ) {
		if ( i % 2 == 0 && i != 0 && i != (telefono.length - 1) ) {
			tel += "-" + telefono.charAt(i);
		} else {
			tel += telefono.charAt(i);
		}
	}*/
	for ( var i = 0; i < telefono.length; i++ ) {
		if ( i % 2 == 0 && i != 0 ) {
			tel += "-" + telefono.charAt(i);
		} else {
			tel += telefono.charAt(i);
		}
	}	
	$("#txtTelefonoContacto").val(tel);
	//$("#txtTelefonoContacto").val( contactos[idContacto].telefono );
	$("#txtExtension").val( contactos[idContacto].extension );
	$("#txtCorreo").val( contactos[idContacto].correo );
	$("#cmbTipoContacto").val( contactos[idContacto].tipoContactoID );
	$("#agregarContacto").html("Editar <i class=\"fa fa-plus\"></i>");
	estadoAgregarContacto = 1;
	idContactoSeleccionado = idContacto;
	idSucursalContactoSeleccionada = idSucursal;
}

function desplegarContactosTemporales( contactos ) {
	if ( contactos != null && contactos.length > 0 ) {
		var nodosHijoTabla = $("#infoContactos > tbody").children().length;
		var contenido = "";
		$.each( contactos, function( index, contacto ){
			var tel = "";
			for ( var i = 0; i < contacto.telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 ) {
					tel += "-" + contacto.telefono.charAt(i);
				} else {
					tel +=  contacto.telefono.charAt(i);
				}
			}			
			/*for ( var i = 0; i < contacto.telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 && i != (contacto.telefono.length - 1) ) {
					tel += "-" + contacto.telefono.charAt(i);
				} else {
					tel +=  contacto.telefono.charAt(i);
				}
			}*/
			/*for ( var i = 0; i < contacto.telefono.length; i++ ) {
				if ( i == 2 || i == 5 || i == 8 ) {
					tel += "-" + contacto.telefono.charAt(i);
				} else {
					tel += contacto.telefono.charAt(i);
				}
			}*/			
			contenido += "<tr id=\"temp" + "-" + index + "\">";
			contenido += "<td>" + contacto.nombre + " " + contacto.apellidoPaterno + " " + contacto.apellidoMaterno + "</td>";
			//contenido += "<td class=\"tdder\">" + contacto.telefono + "</td>";
			contenido += "<td class=\"tdder\">" + tel + "</td>";
			contenido += "<td class=\"tdder\">" + contacto.extension + "</td>";
			contenido += "<td>" + contacto.correo + "</td>";
			contenido += "<td>" + contacto.nombreTipoContacto + "</td>";
			contenido += "<td><i class=\"fa fa-pencil editarInfoContacto\"></i></td>";
			contenido += "<td><i class=\"fa fa-times eliminarInfoContacto\"></i></td>";
			contenido += "</tr>";
		});
		$("#infoContactos > tbody").html(contenido);
		$("#infoContactos").attr("class", "express");
		$("#agregarContacto").html("Agregar Contacto");
		estadoAgregarContacto = 0;
		idContactoSeleccionado = 0;
		$(".editarInfoContacto").on("click", function(){			
			var idNodo = $(this).parent().parent().attr("id");
			var idContacto = idNodo.split("-")[1];
			var idSucursal = idNodo.split("-")[0];
			desplegarContactoInfoTemporal( idContacto, idSucursal );
		});
		$(".eliminarInfoContacto").on("click", function(){
			var idNodo = $(this).parent().parent().attr("id");
			var idSucursal = idNodo.split("-")[0];
			var idContacto = idNodo.split("-")[1];
			if ( confirm("\u00BFRealmente desea borrar este contacto?") ) {
				eliminarContactoTemporal( idSucursal, idContacto );
			}
		});
		$("#txtNombreContacto").val("");
		$("#txtApellidoPaternoContacto").val("");
		$("#txtApellidoMaternoContacto").val("");
		$("#txtTelefonoContacto").val("");
		$("#txtExtension").val("");
		$("#txtCorreo").val("");
		$("#cmbTipoContacto").val(-1);
		totalContactos = contactos.length;
	} else {
		totalContactos = 0;
		$("#infoContactos").attr("class", "express ocultarSeccion");
	}
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
	
	if ( telefono.length < 10 ) {
		alert("La longitud del Tel\u00E9fono no puede ser menor a 10 digitos. Si ha escrito un n\u00FAmero local, favor de hacerlo con clave LADA.");
		return false;
	}	
	
	if ( !validaTelefonoAB('txtTelefonoContacto') ) {
		alert("El formato del Tel\u00E9fono del Contacto es incorrecto");
		return false;
	}
	
	if ( !validarEmail('txtCorreo') ) {
		alert("El formato de Correo es incorrecto");
		return false;
	}
	
	telefono = telefono.replace( /-/g, "" );
	
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

function editarContactoTemporal( idContacto ) {
	if ( contactos != null && contactos.length > 0 ) {
		var nombre = $("#txtNombreContacto").val();
		var apellidoPaterno = $("#txtApellidoPaternoContacto").val();
		var apellidoMaterno = $("#txtApellidoMaternoContacto").val();
		var telefono = $("#txtTelefonoContacto").val();
		var extension = $("#txtExtension").val();
		var correo = $("#txtCorreo").val();
		var tipoContactoID = $("#cmbTipoContacto").val();
		var tipoContactoDescripcion = $("#cmbTipoContacto option:selected").text();
		
		if ( telefono.length < 10 ) {
			alert("La longitud del Tel\u00E9fono no puede ser menor a 10 digitos. Si ha escrito un n\u00FAmero local, favor de hacerlo con clave LADA.");
			return false;
		}
		
		if ( !validaTelefonoAB('txtTelefonoContacto') ) {
			alert("El formato del Tel\u00E9fono del Contacto es incorrecto");
			return false;
		}	
		
		if ( !validarEmail('txtCorreo') ) {
			alert("El formato de Correo es incorrecto");
			return false;
		}
		
		if ( nombre == "" ) {
			alert("Favor de capturar el nombre del Contacto");
			return false;
		}
		
		if ( apellidoPaterno == "" ) {
			alert("Favor de capturar el apellido paterno del Contacto");
			return false;
		}
		
		if ( apellidoMaterno == "" ) {
			alert("Favor de capturar el apellido materno del Contacto");
			return false;
		}
		
		/*if ( extension == "" ) {
			alert("Favor de escribir la extens\u00F3n del Contacto");
			return false;
		}*/
		
		if ( tipoContactoID < 0 ) {
			alert("Favor de seleccionar el tipo del Contacto");
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
			tipoContactoID: tipoContactoID,
			nombreTipoContacto : tipoContactoDescripcion,
			idSucursal: "temp"
		}
		
		contactos[idContacto] = contacto;
		
		desplegarContactosTemporales( contactos );
	}
}

function eliminarContactoTemporal( idSucursal, idContacto ) {
	if ( contactos != null && contactos.length > 0 ) {
		contactos.splice( idContacto, 1 );
		desplegarContactosTemporales( contactos );
	}
}

function cargarSucursales( idAfiliacion ) {
	var tabla = "<table class=\"display table table-bordered table-striped dataTable\" id=\"tblListaCorresponsales\" aria-describedby=\"tblListaCorresponsales_info\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>Giro</th>";
	tabla += "<th>Nombre</th>";
	tabla += "<th>Direcci&oacute;n</th>";
	tabla += "<th>Tel&eacute;fono</th>";
	tabla += "<th>Editar</th>";
	tabla += "<th>Eliminar</th>";
	tabla += "</tr>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#sucursalesInfo").html(tabla);
	
	var params = {
		idCliente : idAfiliacion,
		vieneDeSucursal: VIENE_DE_NUEVA_SUCURSAL
	}
	
	llenaDataTable("tblListaCorresponsales", params, BASE_PATH + "/inc/Ajax/_Afiliaciones/getSucursales.php");
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
	var idDireccion = $("#idDireccion").val();
	var idLocalidad = $("#idLocalidad").val();
	var origen = $("#origen").val();

	if ( !idLocalidad ) {
		idLocalidad = 0;
	}

	//Comisiones y Reembolsos
	var comisiones = $("#cmbComisiones").val();
	var reembolso = $("#cmbReembolsos").val();
	var CLABE = $("[name='CLABE']").val();
	var idBanco = $("[name='idBanco']").val();
	var numCuenta = $("[name='numCuenta']").val();
	var beneficiario = $("[name='beneficiario']").val();
	var descripcion = $("[name='descripcion']").val();

	if ( VIENE_DE_NUEVA_SUCURSAL ) {
		var idSubcadena = idAfiliacion;
	} else {
		var idSubcadena = null;	
	}

	if ( telefono.length < 10 ) {
		alert("La longitud del Tel\u00E9fono no puede ser menor a 10 digitos. Si ha escrito un n\u00FAmero local, favor de hacerlo con clave LADA.");
		return false;
	}	

	if ( !validaTelefonoAB('txtTelefono') ) {
		alert("El formato del Tel\u00E9fono en Datos Generales es incorrecto");
		return false;
	}

	telefono = telefono.replace( /-/g, "" );
	permitirGuardarSucursal = false;

	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/guardarSucursal2.php",
	{ idCliente: idAfiliacion, nombreSucursal: nombreSucursal, idGiro: idGiro, idPais: idPais, calle: calle,
	numeroInterior: numeroInterior, numeroExterior: numeroExterior, codigoPostal: codigoPostal,
	idColonia: idColonia, idEstado: idEstado, idMunicipio: idMunicipio, telefono: telefono, idDireccion: idDireccion,
	origen: origen, comisiones: comisiones, reembolso: reembolso, CLABE: CLABE, idBanco: idBanco, numCuenta: numCuenta,
	beneficiario: beneficiario, descripcion: descripcion, contactos: contactos, totalContactos : totalContactos,
	idSubcadena: idSubcadena, idLocalidad: idLocalidad, esSubcadena: ES_SUBCADENA },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			if ( !VIENE_DE_NUEVA_SUCURSAL ) {
				if(ES_CONSULTA == true || ES_CONSULTA_SUC == true){
					$("#formRegresar").submit();
				} else {
					window.location = "formnew5.php?idCliente=" + idAfiliacion;
				}
			} else {
				window.location = "formnew5.php?idCliente=" + idAfiliacion + "&ns=" + 1 + "&ns2=" + ES_SUBCADENA;
			}
		} else {
			permitirGuardarSucursal = true;
			alert( respuesta.mensaje );
		}
	}, "json");
}

function editarSucursal( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/cargarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal, vieneDeNuevaSucursal: VIENE_DE_NUEVA_SUCURSAL, esSubcadena: ES_SUBCADENA },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var sucursal = respuesta.sucursal;
			var tel = "";
			$("#nombreCorresponsal").val( sucursal.NombreSucursal );
			//alert( "idGiro: " + sucursal.idGiro );
			$("#cmbGiro").val( sucursal.idGiro );
			//var girosOpciones = $("#cmbGiro").html();
			//console.log(girosOpciones);
			$("#idPais").val( sucursal.idPais );
			$("#calleDireccion").val( sucursal.Calle );
			$("#numeroIntDireccion").val( sucursal.NumInt );
			$("#numeroExtDireccion").val( sucursal.NumExt );
			$("#txtCP").val( sucursal.codigoPostal );
			$("#cmbColonia").val( sucursal.idColonia );
			$("#idLocalidad").val( sucursal.idLocalidad );
			
			/*for ( var i = 0; i < sucursal.Telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 && i != (sucursal.Telefono.length - 1) ) {
					tel += "-" + sucursal.Telefono.charAt(i);
				} else {
					tel +=  sucursal.Telefono.charAt(i);
				}
			}*/

			for ( var i = 0; i < sucursal.Telefono.length; i++ ) {
				if ( i % 2 == 0 && i != 0 ) {
					tel += "-" + sucursal.Telefono.charAt(i);
				} else {
					tel +=  sucursal.Telefono.charAt(i);
				}
			}

			//$("#txtTelefono").val( sucursal.Telefono );
			$("#txtTelefono").val( tel );
			$("#idDireccion").val( sucursal.idDireccion );
			
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
			
			contactos = new Array();
			desplegarContactos( idSucursal );
			
			if ( respuesta.tipoFORELO == 2 ) {
				//Comisiones y Reembolsos
				if ( sucursal.idComisiones != "NULL" && sucursal.idComisiones != "" ) {
					$("#cmbComisiones").val(sucursal.idComisiones);
				} else {
					$("#cmbComisiones").val(-1);
				}
				if ( sucursal.idReembolso != "NULL" && sucursal.idReembolso != "" ) {
					$("#cmbReembolsos").val(sucursal.idReembolso);
				} else {
					$("#cmbReembolsos").val(-1);
				}
				if ( sucursal.idComisiones == 1 || sucursal.idReembolso == 1 ) {
					$("[name='CLABE']").val(sucursal.CLABE);
					$("[name='idBanco']").val(sucursal.idBanco);
					$("[name='numCuenta']").val(sucursal.NumCuenta);
					$("[name='beneficiario']").val(sucursal.Beneficiario);
					$("[name='descripcion']").val(sucursal.Descripcion);
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
			
			$("#origen").val(0);
			
		} else {
			alert( respuesta.mensaje );	
		}
	}, "json");
}

function eliminarSucursal( idSucursal ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/eliminarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal, vieneDeNuevaSucursal: VIENE_DE_NUEVA_SUCURSAL, esSubcadena: ES_SUBCADENA },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
			if ( !VIENE_DE_NUEVA_SUCURSAL ) {
				if(ES_CONSULTA == true || ES_CONSULTA_SUC == true){
					$("#formRegresar").submit();
				} else {
					window.location = "formnew5.php?idCliente=" + idAfiliacion;
				}
			} else {
				window.location = "formnew5.php?idCliente=" + idAfiliacion + "&ns=" + 1 + "&ns2=" + ES_SUBCADENA;
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
	var idLocalidad = $("#idLocalidad").val();
	
	//Comisiones y Reembolsos
	var comisiones = $("#cmbComisiones").val();
	var reembolso = $("#cmbReembolsos").val();
	var CLABE = $("[name='CLABE']").val();
	var idBanco = $("[name='idBanco']").val();
	var numCuenta = $("[name='numCuenta']").val();
	var beneficiario = $("[name='beneficiario']").val();
	var descripcion = $("[name='descripcion']").val();
	
	var origen = $("#origen").val();
	
	/*alert("comisiones: " + comisiones);
	alert("reembolso: " + reembolso);
	alert("CLABE: " + CLABE);
	alert("idBanco: " + idBanco);
	alert("numCuenta: " + numCuenta);
	alert("beneficiario: " + beneficiario);
	alert("descripcion: " + descripcion);*/
	
	if ( telefono.length < 10 ) {
		alert("La longitud del Tel\u00E9fono no puede ser menor a 10 digitos. Si ha escrito un n\u00FAmero local, favor de hacerlo con clave LADA.");
		return false;
	}	
	
	if ( !validaTelefonoAB('txtTelefono') ) {
		alert("El formato del Tel\u00E9fono en Datos Generales es incorrecto");
		return false;
	}
	
	telefono = telefono.replace( /-/g, "" );
	
	if ( !contactoAgregado ) {
		contactos = new Array();
	}
	
	permitirGuardarSucursal = false;
	
	//alert("origen: " + origen);
	
	/*if ( origen == 0 ) {
		alert("Se debe editar actualizando la direccion actual");
	} else if ( origen == 1 ) {
		alert("Se debe editar creando una direccion nueva");
	}*/
	
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/actualizarSucursal.php",
	{ idAfiliacion: idAfiliacion, idSucursal: idSucursal, nombreSucursal: nombreSucursal, idGiro: idGiro, idPais: idPais, calle: calle,
	numeroInterior: numeroInterior, numeroExterior: numeroExterior, codigoPostal: codigoPostal,
	idColonia: idColonia, idEstado: idEstado, idMunicipio: idMunicipio, telefono: telefono,
	comisiones: comisiones, reembolso: reembolso, CLABE: CLABE, idBanco: idBanco, numCuenta: numCuenta,
	beneficiario: beneficiario, descripcion: descripcion, totalContactos : totalContactos, contactos: contactos, idLocalidad: idLocalidad,
	vieneDeNuevaSucursal: VIENE_DE_NUEVA_SUCURSAL, esSubcadena: ES_SUBCADENA, origen: origen },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			//window.location = "formnew5.php?idCliente=" + idAfiliacion;
			
			if ( !VIENE_DE_NUEVA_SUCURSAL ) {
				if(ES_CONSULTA == true || ES_CONSULTA_SUC == true){
					$("#formRegresar").submit();
				}
				else{
					window.location = "formnew5.php?idCliente=" + idAfiliacion;
				}
				//window.location = "formnew5.php?idCliente=" + idAfiliacion;
			} else {
				if(ES_CONSULTA == true || ES_CONSULTA_SUC == true){
					$("#formRegresar").submit();
				}
				else{
					window.location = "formnew5.php?idCliente=" + idAfiliacion + "&ns=" + 1 + "&ns2=" + ES_SUBCADENA;
				}
			}			
		} else {
			permitirGuardarSucursal = true;
			alert( respuesta.mensaje );
		}
	}, "json");
}

function asignarReferenciasBancarias() {
	if ( VIENE_DE_NUEVA_SUCURSAL ) {
		var idSucursalParam2 = getParametro("idSucursal");
		var URL = "Resumen2.php?idSubCadena=" + idAfiliacion + "&idCliente=" + idAfiliacion + "&idSucursal=" + idSucursalParam2 + "&ns=" + ns + "&ns2=" + ns2;
		$("#formSiguiente").attr("action", URL);
		$("#formSiguiente").submit();
	} else {
		var URL = BASE_PATH + "/_Clientes/Afiliaciones/TerminosYCondiciones.php?idCliente=" + idAfiliacion;
		window.location = URL;
	}
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
	contenido += "<label class=\"col-xs-3 control-label\">Descripci\u00F3n:</label>";
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

function initComponentsCuenta() {
	$("#cmbReembolsos, #cmbComisiones").on('change', function(event){
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
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$("[name='descripcion']").alphanum({
		allowNumeric		: true,
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1@-_.',
		allowOtherCharSets	: false,
		maxLength			: 30
	});

	$("#btnNext").on('click', function(){
		guardarConfiguracionCuenta();
	});	
}

function analizarCLABE(event){
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
	
	return CLABE.charAt(17) == digitoVerificador;
	
}

function validaTelefono1A(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guion  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		var txtInput = document.getElementById(txt);
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 5:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 8:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 11:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 14:
				if(tecla != separador && tecla != 8){
					var caracter = String.fromCharCode(tecla);
					txtInput.value = txtInput.value + "-" + caracter;
					return false;
				}
			break;
			case 17:
				if(tecla != separador && tecla != 8){
					var caracter = String.fromCharCode(tecla);
					txtInput.value = txtInput.value + "-" + caracter;					
					return false;
				}
			break;			
			default:
				if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}
				return true;
			break;
		}
		
		return true;
	}
	return false;
}
function validaTelefono2A(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla != 8){
		txtVal =  document.getElementById(txt).value;
			//if(txt.indexOf(".") > -1 && (tecla==45))
				//return false;
				//alert(txt.length);
		switch(txtVal.length){
			case 2:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 5:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 8:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 11:
				 document.getElementById(txt).value = txtVal + "-";
			break;			
			case 14:
				document.getElementById(txt).value = txtVal;
			break;
			case 17:
				document.getElementById(txt).value = txtVal;
			break;
		}
	}
}

function validaTelefonoAB(valor) {
	valor = document.getElementById(valor).value;
	var longitud = valor.length;
	var re;
	switch ( longitud ) {
		case 14:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}$/;
		break;
		case 17:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}$/;
		break;
		case 20:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{2}$/;
		break;		
		case 19:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
		default:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
	}
	if ( re.exec(valor) ) {
		//alert( "Si" );
		return true;
    } else {
		//alert( "No" );
		return false;
    }
}

/*function RellenarTelefonoContacto() {
	if ( document.getElementById("txtTelefonoContacto") ) {
		if ( txtValue("txtTelefonoContacto") == '' ) {
			document.getElementById("txtTelefonoContacto").value = "52-";
			$("#txtTelefonoContacto").putCursorAtEnd();
		}
	}	
}*/

function cargarDatosCliente( idCliente ) {
	//alert("TEST A");
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/getDatosClienteReal.php",
	{ idCliente : idCliente, esSubcadena : ES_SUBCADENA },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			$("#encabezadoCliente").html(respuesta.nombre);
			if ( respuesta.tipoForelo == 2 ) { //Individual
				desplegarFORELO();
				$("#anteriorPagina").on("click", function() {
					var URL = "nuevasucursal.php";
					window.location = URL;
				});
			} else if ( respuesta.tipoForelo == 1 ) { //Compartido
				$("#anteriorPagina").on("click", function() {
					var URL = "nuevasucursal.php";
					window.location = URL;
				});
			}			
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function cargarFamiliasCliente( idCliente ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/getFamiliasClienteReal.php",
	{ idCliente : idCliente, esSubcadena : ES_SUBCADENA },
	function( respuesta ){
		if ( respuesta.codigo == 0 ) {
			var totalFamilias = respuesta.familias.id.length;
			var resultado = "";
			for ( var i = 0; i < totalFamilias; i++ ) {
				if ( i != 0 && i != totalFamilias ) {
					resultado += ", " + respuesta.familias.nombre[i];
				} else {
					resultado += respuesta.familias.nombre[i];
				}
			}
			$("#encabezadoFamilias").html(resultado);
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}

function cargarFamiliasClienteNoReal( idCliente ) {
	$.post( BASE_PATH + "/inc/Ajax/_Afiliaciones/getFamiliasClienteNoReal.php",
	{ idCliente: idCliente },
	function( respuesta ) {
		if ( respuesta.codigo == 0 ) {
var totalFamilias = respuesta.familias.id.length;
			var resultado = "";
			for ( var i = 0; i < totalFamilias; i++ ) {
				if ( i != 0 && i != totalFamilias ) {
					resultado += ", " + respuesta.familias.nombre[i];
				} else {
					resultado += respuesta.familias.nombre[i];
				}
			}
			$("#textoFamilias").attr("class", "");
			$("#encabezadoFamilias").attr("class", "");
			$("#encabezadoFamilias").html(resultado);
		} else {
			alert( respuesta.mensaje );
		}
	}, "json");
}