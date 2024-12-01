function initComponentes() {
	$("#idSub, #idCor").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑ",
		disallow: "¿¡°´¨~-",
		allowLatin: true,
		allowOtherCharSets: false
	});
	if($("#idSub").length){
		$("#idSub").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/getListaCategoria.php",
					{
						idCadena	: $("#ddlCad").val(),
						categoria	: 2,
						text		: request.term
					},
					function( response ) {
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idSub").val(ui.item.nombreSubCadena);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlSub").val(ui.item.idSubCadena);
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
	if($("#idSub").length){
		$("#idSub").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/getListaCategoria.php",
					{
						idCadena	: $("#ddlCad").val(),
						categoria	: 2,
						text		: request.term
					},
					function( response ) {
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idSub").val(ui.item.nombreSubCadena);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlSub").val(ui.item.idSubCadena);
				if ( ui.item.idCadena != 0 ) {
					$("#ddlCad").val(ui.item.idCadena);
				}
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
	if($("#txtTel").length){
		$("#txtTel").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/AutoCorresponsalTel.php",
					{
						term		: request.term
					},
					function( response ) {
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#txtTel").val(ui.item.label);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlCorresponsal").val(ui.item.id);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.append("<a>" + item.label + "</a>")
			.appendTo( ul );
		}
	}
	if($("#idCor").length){
		$("#idCor").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/getListaCategoria.php",
					{
						idCadena	: $("#ddlCad").val(),
						idSubCadena	: $("#ddlSub").val(),
						categoria	: 3,
						text		: request.term
					},
					function( response ) {
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idCor").val(ui.item.nombreCorresponsal);
				return false;
			},
			select: function( event, ui ) {
				$("#idCadena").val(ui.item.nombreCadena);
				$("#idSub").val(ui.item.nombreSubCadena);
				$("#ddlSub").val(ui.item.idSubCadena);
				$("#ddlCad").val(ui.item.idCadena);
				$("#ddlCorresponsal").val(ui.item.idCorresponsal);
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
	if ($("#txtMunicipio").length) {
		$("#txtMunicipio").prop('disabled', true);
		$("#txtMunicipio").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/getMunicipios.php",
					{
						idPais		: $("#idPais").val(),
						idEstado	: $("#ddlEstado").val(),
						text		: request.term
					},
					function( response ) {
						console.log("Municipio: " + response.codigo);
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#txtMunicipio").val(ui.item.descMunicipio);
				return false;
			},
			select: function( event, ui ) {
				$("#idMunicipio").val(ui.item.idMunicipio);
				$("#txtColonia").prop("disabled", false);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.append("<a>" + item.label + "</a>")
			.appendTo( ul );
		}

		$("#txtMunicipio").on('keydown', resetColonias);
		$("#txtMunicipio").on('keyup', resetColonias);
		$("#txtMunicipio").on('blur', resetColonias);

	}
	if ($("#txtColonia").length) {
		$("#txtColonia").prop('disabled', true);
		$("#txtColonia").autocomplete({
			source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Consultas/getColonias.php",
					{
						idPais		: $("#idPais").val(),
						idEstado	: $("#ddlEstado").val(),
						idMunicipio : $("#idMunicipio").val(),
						text		: request.term
					},
					function( response ) {
						console.log("Colonia: " + response.codigo);
						if ( response.codigo ) {
							if ( response.codigo == 9000 || response.codigo == 9500 ) {
								window.location = response.URL;
							} else {
								respond(response);
							}
						} else {
							respond(response);
						}
					}, "json" );
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#txtColonia").val(ui.item.descColonia);
				return false;
			},
			select: function( event, ui ) {
				$("#idColonia").val(ui.item.idColonia);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			.append("<a>" + item.label + "</a>")
			.appendTo( ul );
		}
	}

	$("#ddlEstado").on('change', function(event){
		var idEstado = $(this).val();

		console.log(idEstado);
		if(idEstado == undefined || myTrim(idEstado) == "" || idEstado <= 0){
			$("#txtMunicipio, #txtColonia").val("");
			$("#txtMunicipio, #txtColonia").prop("disabled", true);
			$("#idMunicipio, #idColonia").val("-1");
		}
		else{
			$("#txtMunicipio, #txtColonia").val("");
			$("#txtMunicipio").prop('disabled', false);
			$("#txtColonia").prop('disabled', true);
			$("#idMunicipio, #idColonia").val("-1");
		}
	});

	$("#idSub").keyup(function(){
		if($("#idSub").val() == '' || $("#idSub").val() == undefined){
			$("#ddlSub").val(-1);
		}
	});
	$("#idCor").keyup(function(){
		if($("#idCor").val() == '' || $("#idCor").val() == undefined){
			$("#ddlCorresponsal").val(-1);
		}
	});
	var idPais = $("#idPais").val();
	cargarEstados(idPais);
	$("#buscarCorresponsales").on("click", function(){
		cargarCorresponsales();
	});
}

$("#botonMovimientos").on("click", function(){
		
		$("#alerta").attr("class", "alert alert-movimientos");
		$("#alerta").html("");
		
		if($("#numCuenta").val()=="--Elige una Cuenta--"){
			$("#alerta").attr("class", "alert alert-danger");
			$("#alerta").html("<p>Debes elegir una cuenta</p>");
		}else if( $("#fechaInicio").val()=="" ){
			$("#alerta").attr("class", "alert alert-danger");
			$("#alerta").html("<p>Debes elegir la fecha de inicio del reporte.</p>");
		}else if( $("#fechaFin").val()=="" ){
			$("#alerta").attr("class", "alert alert-danger");
			$("#alerta").html("<p>Debes elegir la &uacute;ltima fecha del reporte.</p>");
		}else{
			cargarMovimientos();
		}
		
});

function resetColonias(event){
	var mun = $(this).val();
	console.log(mun);
	if(mun == undefined || myTrim(mun) == ""){
		$("#idColonia").val("-1");
		$("#txtColonia").val("");
		$("#txtColonia").prop("disabled", true);
	}
}

function initComponentesCorresponsal() {
	$("#nuevaBusqueda").on("click", function(){
		irANuevaBusqueda();
	});
	$(".archivo").on("change", function(){
		var tipoArchivo = $(this).attr("id").split("-")[0];
		$("#idTipoArchivo").val(tipoArchivo);
		var nombreArchivo = $(this).val();
		if ( validarExtensionArchivo(nombreArchivo) ) {
			$("#formDocumentacion").submit();
		} else {
			alert("Los documentos s\u00F3lo pueden ser JPG o PDF.");
		}
	});
	$(".eliminarArchivo").on("click", function(){
		var idArchivo = $(this).attr("id").split("-")[0];
		$("#idArchivoEliminar").val(idArchivo);
		$("#formDocumentacion").submit();
	});
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
	}
	var error = getParametro("e");
	if ( error != null && error != "" ) {
		alert("Hubo un error al tratar de subir el documento. Por favor contacte a soporte.");
	}
	cargarContactos();
	cargarDepositos();
	cargarUltimasOperaciones();
}

function cargarEstados(idPais){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeEstados.php", "ddlEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
}

function cargarMunicipios(idPais, idEstado){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeMunicipios.php", "ddlMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
}

function cargarColonias(idPais, idEstado, idMunicipio){
	cargarStore(BASE_PATH+"/inc/Ajax/stores/storeColonias.php", "ddlColonia", {idPais : idPais, idEstado : idEstado, idMunicipio : idMunicipio}, {text : 'descColonia', value : "idColonia"}, {}, 'coloniasloaded');
}

function buscaSelectCiudad(){
	var idPais = $("#idPais").val();
	var idEstado = $("#ddlEstado").val();
	cargarMunicipios( idPais, idEstado );
}

function buscaSelectColonia(){
	var idPais = $("#idPais").val();
	var idEstado = $("#ddlEstado").val();
	var idMunicipio = $("#ddlMunicipio").val();
	cargarColonias( idPais, idEstado, idMunicipio );
}

$("#consultar").on("click", function(){
	
	
	if (document.getElementById("idCorresponsal").value == "") {
		alert("Debes seleccionar un corresponsal.");
	}else{
		cargarReporte();
	}
	

	
	/*$("#alerta").attr("class", "alert alert-danger d ocultarSeccion");
	$("#alerta").html("");
	$("#contenedor").html("");
	
	if($("#corresponsal").val()==-2){
		$("#alerta").attr("class", "alert alert-danger d");
		$("#alerta").html("<p>Debes elegir una sucursal</p>");
	}else if(oficialSeguridad == 0){
		$("#alerta").attr("class", "alert alert-danger d");
		$("#alerta").html("<p>Estimado usuario: esta acci&oacute;n no est&aacute; permitida para oficiales de seguridad. Favor de contactar a soporte.</p>");
	}else{
		cargarReporte();
	}*/
	
});

function suspenderEquipo(idEquipo){
	if ( $("#reporteResumenDT").length ) {
		$("#reporteResumenDT").dataTable().fnDestroy();
		$("#reporteResumenDT").remove();
	}
	
	var tabla = "<table class=\"display\" id=\"reporteResumenDT\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>Numero</th>";
	tabla += "<th>C&oacute;digo de activaci&oacute;n</th>";
	tabla += "<th>Activaci&oacute;n</th>";
	tabla += "<th>Estatus</th>";
	tabla += "<th>&Uacute;ltimo acceso</th>";
	tabla += "<th>Acci&oacute;n</th>";
	tabla += "</tr>";
	tabla += "</thead>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#contenedor").append(tabla);
	
	var idCorresponsal = $("#idCorresponsal").val();
	
	alert("idCorresponsal: " + idCorresponsal);
	
	var nombreCorresponsal = $("#corresponsal option:selected").html();
	
	
	var params = {
		idCorresponsal: idCorresponsal,
		nombreCorresponsal: nombreCorresponsal,
		idEq: idEquipo,
		idAccionAEjecutar: 2
	}
	
	llenaDataTableMov("reporteResumenDT", params, BASE_PATH + "/inc/Ajax/_Administracion/AdministraEquipos.php");
}



function cargarReporte() {
	
	if ( $("#reporteResumenDT").length ) {
		$("#reporteResumenDT").dataTable().fnDestroy();
		$("#reporteResumenDT").remove();
	}
	
	var tabla = "<table class=\"display table table-bordered table-striped\" id=\"reporteResumenDT\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>N&uacute;mero</th>";
	tabla += "<th>ID</th>";
	tabla += "<th>Nombre</th>";
	tabla += "<th>C&oacute;digo</th>";
	tabla += "<th>Estatus</th>";
	tabla += "<th>Activaci&oacute;n</th>";
	tabla += "<th>Fecha</th>";
	tabla += "<th>Acci&oacute;n</th>";
	tabla += "</tr>";
	tabla += "</thead>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#contenedor").append(tabla);
	
	var idCorresponsal = $("#idCorresponsal").val();
	
	var params = {
		idCorresponsal: idCorresponsal,
		idAccionAEjecutar: 1
	}

	getCorresponsales("reporteResumenDT", params, "../../inc/Ajax/_Administracion/AdministraEquipos.php");
}

function cambiaEstatus(idEquipo, idCorr){
	
	$.post("../../inc/Ajax/_Administracion/ActualizarEstatusEquipo.php", { idEquipo: idEquipo, idCorresponsal: idCorr}, 
	function(respuesta){
		if (respuesta.codigo == 0){
			cargarReporte();
		}else{
			alert(respuesta.mensaje);
		}
	}, "json");
	
}

function getCorresponsales(id, obj, url){
		
		$('#'+id).dataTable({
			"iDisplayLength"	: 10,
			"bProcessing"		: false,
			"bServerSide"		: true,
			"sAjaxSource"		: "../../inc/Ajax/_Administracion/AdministraEquipos.php",
			"aoColumnDefs"		: [{ "sClass": "centrado", "aTargets": [7] }, 
									{ "sClass": "numero centrado", "aTargets": [0] }, 
									{ "sClass": "codigo", "aTargets": [3] },
									{ "sClass": "estatus", "aTargets": [4,5] }],
			"bFilter": false,
			"bSort": false,
			"bPaginate": false,
			//"sPaginationType"	: "full_numbers",
			/*"oLanguage"			: {
				"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
				"sZeroRecords"		: "No se ha encontrado nada",
				"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
				"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
				"sInfoFiltered"		: "(Filtrado de _MAX_ total de Registros)"
			},*/
			"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		},
			"fnPreDrawCallback"	: function() {
				Emergente();
			},
			"fnDrawCallback": function() {
				OcultarEmergente();
			},
			fnServerParams : function (aoData){
				$.each(obj, function(index, val){
					aoData.push({name : index, value : val });
				});
			}
		});
		
		
		
	}

function llenaDataTableMov(id, obj, url){
	
	

	dataTableObj = $("#" + id).dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: url,
		"bFilter": false,
		"bSort": false,
		"bPaginate": false,
		"bInfo": false,
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se han encontrado registros",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"oPaginate"			: {
									"sNext": "Siguiente",
									"sPrevious": "Anterior"
			},
			"sSearch"			: "Buscar"
		},
		"fnServerData" : function ( sSource, aoData, fnCallback, oSettings ) {
			oSettings.jqXHR = $.ajax( {
			"dataType": 'json', 
			"type": "GET", 
			"url": sSource, 
			"data": aoData, 
			"success": function( response ) {
				if ( response.codigo != null ) {
					if ( response.codigo == 9000 || response.codigo == 9500 ) {
						window.location = response.URL;
					}else if (response.codigo == 5000){	
						$("#alerta").attr("class", "alert alert-danger d");
						$("#alerta").html("<p>Estimado usuario: No se permite registrar equipos para sucursales bancarias.</p>");
						if ( $("#reporteResumenDT").length ) {
							$("#reporteResumenDT").dataTable().fnDestroy();
							$("#reporteResumenDT").remove();
						}
					} else {
						fnCallback(response);
					}
				} else {
					fnCallback(response);	
				}
			}
			} );		
		}		
		,"fnPreDrawCallback"	: function() {

		},
		"fnDrawCallback": function ( oSettings ) {

			console.log(oSettings);

			dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});

			dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			
			
			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
		
	});
	
	/*var table = $('#reporteResumenDT').DataTable();
	
	var counter = 1;     
	      
		table.row.add( [           
		counter +'.1',            
		counter +'.2',            
		counter +'.3',            
		counter +'.4',            
		counter +'.5',
		counter +'.5' 
		
	] ).draw(); */      
	    
	
}

/*$(document).ready(function(){

	var t = $("#miTabla").dataTable();
	var counter = 1;
	
	 $('#addRow').on( 'click', function () {
        t.row.add( [
            counter +'.1',
            counter +'.2',
            counter +'.3',
            counter +'.4',
            counter +'.5'
        ] ).draw();
 
        counter++;
    } );
	
	$('#addRow').click();
});*/

function verCorresponsal( idCorresponsal ) {
	$("#formBusquedaCorresponsal [id='idCorresponsal']").val( idCorresponsal );
	if ( idCorresponsal == -1 || idCorresponsal == 0 || idCorresponsal == "" || idCorresponsal == undefined ) {
		alert("Seleccione un Cliente");
	} else {
		$("#formBusquedaCorresponsal").submit();
	}
}

function irANuevaBusqueda(){
	window.location = BASE_PATH + "/_Cliente/ConsultaCorresponsal.php";
}

function llenaDataTableConsultaCorresponsal(id, obj, url){

	dataTableObj = $("#" + id).dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: url,
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se han encontrado registros",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"oPaginate"			: {
									"sNext": "Siguiente",
									"sPrevious": "Anterior"
			},
			"sSearch"			: "Buscar"
		},
		"fnServerData" : function ( sSource, aoData, fnCallback, oSettings ) {
			oSettings.jqXHR = $.ajax( {
			"dataType": 'json', 
			"type": "GET", 
			"url": sSource, 
			"data": aoData, 
			"success": function( response ) {
				if ( response.codigo != null ) {
					if ( response.codigo == 9000 || response.codigo == 9500 ) {
						window.location = response.URL;
					} else {
						fnCallback(response);
					}
				} else {
					fnCallback(response);	
				}
			}
			} );		
		},		
		"fnPreDrawCallback"	: function() {

		},
		"fnDrawCallback": function ( oSettings ) {

			dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});

			dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			
			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
}

function cargarContactos() {
	if ( $("#contactosDT").length ) {
		$("#contactosDT").dataTable().fnDestroy();
		$("#contactosDT").remove();
	}
	
	var tabla = "<table class=\"display\" id=\"contactosDT\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th class=\"\">Contacto</th>";
	tabla += "<th class=\"\">Tel&eacute;fono</th>";
	tabla += "<th class=\"\">Extensi&oacute;n</th>";
	tabla += "<th class=\"\">Correo</th>";
	tabla += "<th class=\"\">Tipo de contacto</th>";
	tabla += "</tr>";
	tabla += "</thead>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#contacto").html(tabla);
	
	var params = {
		idCliente : idCorresponsal,
		tipoContacto : 0,
		categoria : 3
	}
	
	llenaDataTableConsultaCorresponsal("contactosDT", params, BASE_PATH + "/inc/Ajax/_Consultas/getContactos.php");
}

function cargarDepositos() {
	if ( $("#depositosDT").length ) {
		$("#depositosDT").dataTable().fnDestroy();
		$("#depositosDT").remove();
	}
	
	var tabla = "<table class=\"display\" id=\"depositosDT\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>FOLIO</th>";
	tabla += "<th>Corresponsal</th>";
	tabla += "<th>No. Cuenta</th>";
	tabla += "<th>Importe</th>";
	tabla += "<th>Fecha Captura</th>";
	tabla += "<th>Autorizaci&oacute;n</th>";
	tabla += "<th>Usuario</th>";
	tabla += "<th>Estatus</th>";
	tabla += "<th>Fecha Aplicaci&oacute;n</th>";
	tabla += "</tr>";
	tabla += "</thead>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";
	
	$("#deposito").html(tabla);
	
	var params = {
		idCadena : idCadena,
		idSubcadena : idSubcadena,
		idCorresponsal : idCorresponsal,
		nombreCompletoCliente : nombreCorresponsal,
		tipoBusqueda: 2
	}

	llenaDataTableConsultaCorresponsal("depositosDT", params, BASE_PATH + "/inc/Ajax/_Consultas/getDepositos.php");
}

function llenaDataTableUltimasOperaciones(id, obj, url){

	dataTableObjOp = $("#" + id).dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: true,
		"bServerSide"		: true,
		"bSort"				: true,
		"sAjaxSource"		: url,
		"aoColumnDefs"		: [{ "sClass": "right", "aTargets": [6] }],
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se han encontrado registros.",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
			"oPaginate"			: {
									"sNext": "Siguiente",
									"sPrevious": "Anterior"
			},
			"sSearch"			: "Buscar",
			"sLoadingRecords"	: "Cargando...",
			"sProcessing"		: "Cargando..."
		},
		"fnServerData" : function ( sSource, aoData, fnCallback, oSettings ) {
			oSettings.jqXHR = $.ajax( {
			"dataType": 'json', 
			"type": "GET", 
			"url": sSource, 
			"data": aoData, 
			"success": function( response ) {
				if ( response.codigo != null ) {
					if ( response.codigo == 9000 || response.codigo == 9500 ) {
						window.location = response.URL;
					} else {
						fnCallback(response);
					}
				} else {
					fnCallback(response);	
				}
			}
			} );		
		}		
		,"fnPreDrawCallback"	: function() {

		},
		"fnDrawCallback": function ( oSettings ) {

			dataTableObjOp.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});

			dataTableObjOp.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			
			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
}

function cargarUltimasOperaciones() {
	if ( $("#ultimasOperacionesDT").length ) {
		$("#ultimasOperacionesDT").dataTable().fnDestroy();
		$("#ultimasOperacionesDT").remove();
	}
	
	var tabla = "<table class=\"display\" id=\"ultimasOperacionesDT\">";
	tabla += "<thead>";
	tabla += "<tr>";
	tabla += "<th>Folio</th>";
	tabla += "<th>Referencia</th>";
	tabla += "<th>Fecha</th>";
	tabla += "<th>Autorizaci&oacute;n</th>";
	tabla += "<th>Estatus</th>";
	tabla += "<th>Producto</th>";
	tabla += "<th>Importe</th>";
	tabla += "</tr>";
	tabla += "<tbody>";
	tabla += "</tbody>";
	tabla += "</table>";	
	tabla += "</thead>";
	
	$("#op").html(tabla);
	
	var params = {
		idCadena: idCadena,
		idSubcadena: idSubcadena,
		idCorresponsal: idCorresponsal
	};
	
	llenaDataTableUltimasOperaciones("ultimasOperacionesDT", params, BASE_PATH + "/inc/Ajax/_Consultas/getUltimasOperaciones.php");
}