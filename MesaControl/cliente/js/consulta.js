var contDraw = 0;
var firstTime = false;
var cveUsuario = '';
var administradores = [];
var operadoresCliente = [];
const elemIdCliente = $('#nIdCliente');
const elemEstatusCliente = $('#nEstatusCliente');
const statusClient = {
	0: { 
		text: 'Activo', 
		backgroundCell: 'success', 
		iconButtonActionChangeStatus: 'fa-times',
		classButtonActionChangeStatus: 'inhabilitar',
		titleButtonActionChangeStatus: 'Inactivar cliente',
		invertStatus: 3
	},
	1: { 
		text: 'Prealta', 
		backgroundCell: 'warning',
		invertStatus: 1
	},
	3: { 
		text: 'Inactivo', 
		backgroundCell: 'danger',
		iconButtonActionChangeStatus: 'fa-check',
		classButtonActionChangeStatus: 'btn-primary',
		titleButtonActionChangeStatus: 'Activar cliente',
		invertStatus: 0
	},
};

const fullNameClient = (row) => {
	if (row.razonSocial == "") {
		return row.nombreCliente;
	}
	
	return row.razonSocial;
}

const showColumnEstatus = () => {
	return PREALTA == 0;
}

const isClientAuthorized = status => {
	return [0,3].includes(status); 
}

const setDataEstatus = (idCliente, estatus, razonSocial) => {
	if (!isClientAuthorized(estatus)) {
		return;
	}

	estatus = statusClient[estatus].invertStatus;
	
	elemIdCliente.val(idCliente);
	elemEstatusCliente.val(estatus);
	$('#mensajeCambioEstatus').html(`¿Esta seguro de <strong>${(estatus == 0) ? 'Activar' : ' Inactivar'}</strong> el siguiente cliente: <strong>${razonSocial}</strong>?`);
}

const chageStatusClient = () => {
	$.ajax({
		url: `${BASE_PATH}/MesaControl/cliente/ajax/actualizarEstatus.php`,
		data: {
			nIdCliente: elemIdCliente.val(),
			nEstatus: elemEstatusCliente.val()
		},
		type: 'POST',
		dataType: 'json',
		beforeSend: function() {
			$('#cambiarEstatusCliente').html(`Actualizando <i class="fa fa-spinner fa-spin"></i>`);
			$('#cambiarEstatusCliente').prop('disabled', true);
			$('#btnCancelarCambioEstatus').prop('disabled', true);
		},
		success: function (response) {
			$('#cambiarEstatusCliente').html(`Aceptar`);
			$('#cambiarEstatusCliente').prop('disabled', false);
			$('#btnCancelarCambioEstatus').prop('disabled', false);

			$('#modalEstatusCliente').modal('hide');

			if (response.nCodigo == 0) {
				jAlert('Registro actualizado satisfactoriamente.', 'Aviso');
				setTimeout(location.reload(), 200);
			} else {
				jAlert('No se pudo actualizar el registro.', 'Alerta');
			}
		}
	}).fail(function(){
		$('#cambiarEstatusCliente').html(`Aceptar`);
		$('#cambiarEstatusCliente').prop('disabled', false);
		$('#btnCancelarCambioEstatus').prop('disabled', false);

		$('#modalEstatusCliente').modal('hide');
		jAlert('Ha ocurrido un error, intente más tarde.', 'Alerta');
	});
}

$(document).ready(function () {
	var configDataTable = {
		"iDisplayLength": 50, 	//numero de columnas a desplegar
		"bProcessing": true, 	// mensaje 
		"bServerSide": false, 	//procesamiento del servidor
		"bFilter": true, 		//no permite el filtrado caja de texto
		"bDestroy": true, 			// reinicializa la tabla 
		"sAjaxSource": "/MesaControl/cliente/ajax/consulta.php", //ajax que consulta la informacion		        
		"sServerMethod": 'POST', //Metodo para enviar la informacion
		//"aaSorting"     : [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_",
			"sZeroRecords": "No se ha encontrado información",
			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
			"sProcessing": "<img src='" + BASE_PATH + "/img/cargando3.gif'> Loading...",
			"sSearch": "Buscar",
			"oPaginate": {
				"sPrevious": "Anterior", // This is the link to the previous page
				"sNext": "Siguiente"
			}
		},
		"aoColumnDefs": [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
			{
				'aTargets': [0, 1, 2, 3, 4],
				"bSortable": false,
			},
			{
				"mData": 'idCliente',
				'aTargets': [0]
			},
			{
				"mData": 'RFC',
				'aTargets': [1]
			},
			{
				"mData": 'razonSocial',
				'aTargets': [2],
				mRender: function (data, type, row) {
					return fullNameClient(row);
				}
			},
			{
				"mData"		: 'idEstatus',
				'aTargets'	: [3],
				"bVisible"	: showColumnEstatus(),
				'sClass'	: 'center',
				mRender		: function(data, type, row) {
					if (type === 'display') {
						return  `<span>${statusClient[data].text}</span>`;
					}

					return data;
				}
			},
			{
				"mData"   : 'idCliente',
				  'aTargets'  : [4],
				  'sClass'  	: 'center',
				  mRender: function(data, type, row){
					let buttonActiveOrInactive = '';

					  boton_edit='<button onclick="editarCliente('+row.idCliente+', \''+row.razonSocial+'\');" data-placement="top" rel="tooltip" title="Editar Información" class="btn habilitar btn-default btn-xs" data-title="Editar Información"><span class="fa fa-edit"></span></button>';
					 
					  if(ID_PERFIL == 1 || ID_PERFIL == 4){ // debe ser perfil 1 o 4 para poder migrar clientes hacia aquimispagos
						if(row.idMigracion == 1){
							if(row.idSubCadena >= 0){
								boton_migrar = `<button data-toggle="modal" data-target="#infoCliente" onclick="migrarAMP(${row.idCliente},${row.idSubCadena},${row.idCadena},'${row.razonSocial}');" data-placement="top" rel="tooltip" title="Migrar hacia Aquimispagos" class="btn habilitar btn-default btn-xs" data-title="Migrar hacia Aquimispagos"><span class="fa fa-upload"></span></button>`;
							}
							else{
								boton_migrar = '';
							}
						}
						else if(row.idMigracion == 2){
							boton_migrar = `<button data-toggle="modal" data-target="#infoClienteMigrado" onclick="migradoAMP(${row.numCuenta},${row.idSubCadena},'${row.razonSocial}');" data-placement="top" rel="tooltip" title="Cliente migrado" class="btn habilitar btn-default btn-xs" data-title="Cliente migrado" style="background-color: #00B400;"><span class="fa fa-eye"></span></button>`;
							// boton_migrar = `<button data-toggle="modal" data-target="#infoCliente" onclick="migrarAMP(${row.idCliente},${row.idSubCadena},${row.idCadena},'${row.razonSocial}');" data-placement="top" rel="tooltip" title="Migrar hacia Aquimispagos" class="btn habilitar btn-default btn-xs" data-title="Migrar hacia Aquimispagos"><span class="fa fa-upload"></span></button>`;
						}
						else{
							boton_migrar = '';
						}
					}else{
						boton_migrar = '';
					}

					if (ID_PERFIL == 1 || IS_AUTHORIZER == 1) {
						if (isClientAuthorized(row.idEstatus)) {
							buttonActiveOrInactive = `<button class="btn ${statusClient[row.idEstatus].classButtonActionChangeStatus} btn-xs" data-toggle="modal" data-target="#modalEstatusCliente" data-placement="top" data-backdrop="static" data-keyboard="false" onclick="setDataEstatus(${data}, ${row.idEstatus}, '${fullNameClient(row)}')" title="${statusClient[row.idEstatus].titleButtonActionChangeStatus}"><span class="fa ${statusClient[row.idEstatus].iconButtonActionChangeStatus}"></span></button>`;
						}
					}
					 
					boton_bitacora = '<button id="bitacoraCLiente" onclick="verBitacoraCliente(' + row.idCliente + ', \'' + row.razonSocial.replace(/'/g, "\\'") + '\')" data-placement="top" rel="tooltip" title="Ver Bitácora" data-toggle="modal" data-target="#verBitacora" class="btn habilitar btn-default btn-xs" data-title="Ver Bitácora"><span class="fa fa-book"></span></button>';

					botones = "<center>" + buttonActiveOrInactive + boton_edit + boton_migrar + boton_bitacora + "</center>";
					
					return botones;
				  }
			},
		],
		'fnRowCallback': function (nRow, aData, iDisplayIndex) {
			if (showColumnEstatus()) {
				let statusCell = $(nRow).find('td:eq(3)');

				statusCell.addClass(statusClient[aData.idEstatus].backgroundCell);
			}
		},
		"fnDrawCallback": function (aoData) {
			// Caso cuando regresa a la pagina y hay un estatus seleccionado
			if (contDraw > 0 && !firstTime) {
				contDraw = 0;
				firstTime = true;
				$('#cmbEstatus').trigger('change');
			} else {
				contDraw++;
			}
		},
		"fnServerParams": function (aoData) {//Funcion que se activa al buscar informacion en la tabla o cambiar de pagina aoData contiene la info del datatable
			var params = {};
			params['tipo'] = 1;
			params['perfil'] = ID_PERFIL;
			params['prealta'] = $("#prealta").val();
			$.each(params, function (index, val) {
				aoData.push({ name: index, value: val });
			});
		}
	}

	var dataTableObj = $('#tabla_clientes').dataTable(configDataTable);

	$("#tabla_clientes").css("display", "inline-table");
	$("#tabla_clientes").css("width", "100%");

	// Filtrar los datos por estatus
	$("#cmbEstatus").on('change', function () {
		if ($(this).val() != "-1") {
			dataTableObj.fnFilter($(this).val(), 3, true);
		} else {
			dataTableObj.fnFilter("", 3, true);
		}
	});
});

function editarCliente(idCliente, razonSocial) {
	var prealta = $("#prealta").val();
	var formCliente = '<form action="afiliacionCliente.php" method="post" id="formCliente" class="hidden">' +
			'<input type="text" name="txtidCliente"  value="' + idCliente + '"/>' +
			'<input type="text" name="txtRazonSocial" value="' + razonSocial + '"/>' +
			'<input type="text" name="prealta" value="' + prealta + '">' +
		'</form>'
	$('body').append(formCliente);
	$("#formCliente").submit();
}

function generarExcel() {
	var excelform =
		'<form id="formtoexcel" action="' + BASE_PATH + '/MesaControl/cliente/ajax/reporteConsultaXLS.php" method="post"><input type="text" name="data" /><input type="number" name="idEstatus" value="' + (PREALTA == 1 ? 1 : $("#cmbEstatus").val()) + '"/></form>';

	$("body").append(excelform);
	$("#formtoexcel").submit();
	$("#formtoexcel").remove();
}

$('#modalEstatusCliente').on('hidden.bs.modal', function (e) {
	elemIdCliente.val('');
	elemEstatusCliente.val('');
});

$('#cambiarEstatusCliente').on('click', () => {
	chageStatusClient();
});

var settingsBitacoraCliente = {
	iDisplayLength: 10, // configuracion del lenguaje del plugin de la tabla
	oLanguage: {
		sZeroRecords: "No se encontraron registros",
		sInfo: "Mostrando _TOTAL_ registros (_START_ de _END_)",
		sLengthMenu: "Mostrar _MENU_ registros",
		sSearch: "Buscar:",
		sInfoFiltered: " - filtrado de _MAX_ registros",
		oPaginate: {
			sNext: "Siguiente",
			sPrevious: " Anterior",
		},
	},
	bSort: false,
};

var usuarios = []
function formatDate(date) {
	var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
	var dateParts = date.split(" ")[0].split("-");
	var formattedDate = dateParts[2] + " " + months[parseInt(dateParts[1]) - 1] + " " + dateParts[0] + " " + date.split(" ")[1];
	return formattedDate;
}

function obtenerNombreUsuarios(id) {
	var nombreCompleto = '-';

	$.each(usuarios, function (i, obj) {
		if (obj.id === id) {
			nombreCompleto = obj.nombre;
			return false;
		}
	});

	return nombreCompleto;
}

function verBitacoraCliente(idRegistro, catalogo) {
	if (getBitacora != null) {
		getBitacora.abort();
		getBitacora = null;
	}

	$('#labelCatalogo').text('')
	$('#labelFechaMovimiento').text('')
	$('#labelUsuario').text('')
	$('#labelAccion').text('')

	var getBitacora = $.ajax({
		url: "../../../MesaControl/cliente/ajax/consultaBitacora.php",
		type: "POST",
		data: {
			tipo: 4,
			idRegistro,
			catalogo
		},
		success: function (response) {
			$("#bitacoraClienteTable").DataTable().fnDestroy();
			$("#bitacoraClienteTable tbody").empty();

			var obj = JSON.parse(response);
			if (obj.length !== 0) {
				document.getElementById("consultaCLientePanel").style.display = "none";
				document.getElementById("bitacoraClientePanel").style.display = "block";
			} else {
				alert('No existen datos disponibles en la tabla.')
				return
			}

			var nombreUsuario = obtenerNombreUsuarios(obj[0].id);

			$('#labelCatalogo').text(obj[0].catalogo)
			$('#labelFechaMovimiento').text(formatDate(obj[0].fechMovimiento))
			$('#labelUsuario').text(nombreUsuario)
			$('#labelAccion').text(obj[0].tipoAccion ? obj[0].tipoAccion : '')

			var data = JSON.parse(obj[0].ultimosCambios);
			var index = 1;
			var table = $('#bitacoraClienteTable');

			if (Object.keys(data.old).length <= 0) {
				$.each(data['new'], function (key, value) {
					var row = $('<tr>').append(
						$('<td>').text(index),
						$('<td>').text(key),
						$('<td class="ellipsis">').text('-'),
						$('<td class="ellipsis">').text(value),
					);
					if (row.text().trim().length > 0) {
						table.append(row);
						index++;
					}
				});
			} else {
				$.each(data['old'], function (key, value) {
					var row = $('<tr>').append(
						$('<td>').text(index),
						$('<td>').text(key),
						$('<td class="ellipsis">').text(value),
						$('<td class="ellipsis">').text(data['new'][key])
					);

					if (value !== data['new'][key]) {
						row.find('tr').removeClass('even');
						row.find('td').addClass('danger');
						table.find('tbody').prepend(row);
						index++;
					} else {
						table.find('tbody').append(row);
						index++;
					}
				});
			}

			$("#bitacoraClienteTable").DataTable(settingsBitacoraCliente);
			$("#bitacoraClienteTable").css("width", "100%");
		}
		,
		error: function (error) {
			alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
		}
	});
}

function volverBitacora() {
	document.getElementById("consultaCLientePanel").style.display = "block";
	document.getElementById("bitacoraClientePanel").style.display = "none";
	$("#bitacoraClienteTable").DataTable().fnDestroy();
	$("#bitacoraClienteTable tbody").empty();
}

function permisos(idCliente, razonSocial) {
	const formPermisos = `<form action="${BASE_PATH}/MesaControl/Permisos/" method="post" id="formPermisos">
		<input type="text" name="txtIdCliente" value="${idCliente}"></input>
		<input type="text" name="txtRazonSocial" value="${razonSocial}"></input>
	</form>`;
	$('body').append(formPermisos);
	$('#formPermisos').submit();
}

function migradoAMP(numCuenta,idSubCadena,sRazonSocial){
	$("#spnPestana2").html(sRazonSocial);

	// *** Consulta de informacion del cliente migrado en AMP
	let params={};
	params.opcion			= 5;
	params.numCuenta		= numCuenta;
	params.idSubCadena		= idSubCadena;

	showSpinner();

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json',
		success: function(resp) {
			if(resp[0] && resp[0] != 'undefined' && resp[0] != undefined){
				$("#sconfCadenaB").val(resp[0].NombreCadena);
				$("#sconfRazonSocialB").val(resp[0].RazonSocialCadena);
				$("#sconfCorresponsalB").val(resp[0].NombreSucursal);
				$("#sconfCantCorresponsalB").val(resp[0].cantSucursales);
				$("#sRFCB").val(resp[0].RFCCadena);
				$('input[name=nFiscalizadoB]').attr("disabled",true);
				$('input[name=nRegimenB]').attr("disabled",true);
				if(resp[0].IdTipoCadena == 1 || resp[0].IdTipoCadena == 2){
					$("#nFiscalizadoSiB").prop("checked", true);
					$("#nFiscalizadoNoB").prop("checked", false);

					if(resp[0].IdTipoCadena == 1){
						$("#nRegimenFisicoB").prop("checked", true);
						$("#nRegimenMoralB").prop("checked", false);
						$("#nRegimenSinRegimenB").prop("checked", false);
					}else{
						$("#nRegimenFisicoB").prop("checked", false);
						$("#nRegimenMoralB").prop("checked", true);
						$("#nRegimenSinRegimenB").prop("checked", false);
					}
				}else{
					$("#nFiscalizadoSiB").prop("checked", false);
					$("#nFiscalizadoNoB").prop("checked", true);

					$("#nRegimenFisicoB").prop("checked", false);
					$("#nRegimenMoralB").prop("checked", false);
					$("#nRegimenSinRegimenB").prop("checked", true);
				}
				$("#sconfCorreoB").val(resp[0].correoUsuario);
				$("#sconfTelefonoB").val(resp[0].telefonoSucursal);

				$("#sconfCantOperadoresB").val(resp[0].cantOperadores);
				$("#numCuentaCorresponsalB").val(resp[0].numCuenta);

				$("#referenciaB").val(resp[0].Referencia);
				$("#sconfNombreB").val(resp[0].NombreUsuario);
				$("#sconfPaternoB").val(resp[0].ApellidoPaternoUsuario);
				$("#sconfMaternoB").val(resp[0].ApellidoMaternoUsuario);
				$("#sconfUsuarioB").val(resp[0].Usuario);
				consultaOperadoresMigrados(resp[0].IdCadenaAMP);
			}
			else{
				jAlert("Hubo un error en el proceso de consulta del cliente migrado.", 'Mensaje');
			}
		}})
		.always(function(){
			hideSpinner();
		});
}

function consultaOperadoresMigrados(idCadenaAMP){

	$("#tdbody_operadoresB").html('');

	let params={};
	params.opcion			= 6;
	params.idCadenaAMP		= idCadenaAMP;

	showSpinner();

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(resp){
		operadoresAMP = resp;
		var tbodyOper = document.getElementById("tdbody_operadoresB");

		for(i=0; i<resp.length; i++){
			if(resp[i].IdUsuario == null || resp[i].IdUsuario=='null'){
				continue;
			}
			if(resp[i].sApellidoMaterno == null || resp[i].sApellidoMaterno == 'null')
			{
				resp[i].sApellidoMaterno = '';
			}
			var hilera = document.createElement("tr");
			
			var celdaIdOper = document.createElement("td");
			var textoCeldaOper = document.createTextNode(resp[i].IdUsuario);

			var celdaNombre = document.createElement("td");
			var textoCeldaNombre = document.createTextNode(resp[i].Nombre+' '+resp[i].ApellidoPaterno+' '+resp[i].sApellidoMaterno);

			var celdaUsuario = document.createElement("td");
			var textoCeldaUsuario = document.createTextNode(resp[i].sUsuario);

			var celdaAccion = document.createElement("td");
			var inputCeldaAccion = '';
			if(resp[i].IdPerfil == 1){
				inputCeldaAccion = document.createTextNode('SI');
			}else{
				inputCeldaAccion = document.createTextNode('NO');
			}

			celdaIdOper.appendChild(textoCeldaOper);
			celdaNombre.appendChild(textoCeldaNombre);
			celdaUsuario.appendChild(textoCeldaUsuario);
			celdaAccion.appendChild(inputCeldaAccion);

			hilera.appendChild(celdaIdOper);
			hilera.appendChild(celdaNombre);
			hilera.appendChild(celdaUsuario);
			hilera.appendChild(celdaAccion);
			
			tbodyOper.appendChild(hilera);
		}
	})
	.fail(function(){
		jAlert('Hubo un error al consultar la informacion de Aqui Mis Pagos.','Mensaje');
	})
	.always(function(){
		hideSpinner();
	});	
}


function migrarAMP(idCliente,idSubCadena,idCadena,sRazonSocial){
	$("#spnPestana").html(sRazonSocial);
	
	// Consulta de informacion previa de cliente seleccionado para migrar.
		let paramsOperadores={};
		paramsOperadores.opcion			=3;
		paramsOperadores.idCliente		=idCliente;

		$("#tdbody_operadores").html('');

		showSpinner();

		// Operadores
		$("#dTablaOperadores").show();
		$("#dTablaOperadores").html('Cargando...');
		$.ajax({
			data: paramsOperadores,
			type: 'POST',
			url: '../cliente/ajax/getClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(resp){
			operadoresCliente = resp;
			var tbodyOper = document.getElementById("tdbody_operadores");

			for(i=0; i<resp.length; i++){
				if(resp[i].idOperador == null || resp[i].idOperador=='null'){
					continue;
				}
				if(resp[i].maternoOperador == null || resp[i].maternoOperador == 'null')
				{
					resp[i].maternoOperador = '';
				}
				var hilera = document.createElement("tr");
				
				var celdaIdOper = document.createElement("td");
				var textoCeldaOper = document.createTextNode(resp[i].idOperador);

				var celdaNombre = document.createElement("td");
				var textoCeldaNombre = document.createTextNode(resp[i].nombreOperador+' '+resp[i].paternoOperador+' '+resp[i].maternoOperador);

				let sEstatus = '';
				if( resp[i].idEstatus == 1 ){ sEstatus = 'Activo'; }else{ sEstatus = 'Inactivo'; }
				var celdaEstatus = document.createElement("td");
				var textoCeldaEstatus = document.createTextNode(sEstatus);

				var celdaAccion = document.createElement("td");
				var inputCeldaAccion = document.createElement("input");
				inputCeldaAccion.type = "checkbox";
				inputCeldaAccion.value = resp[i].idOperador;
				inputCeldaAccion.id = 'adminChck'+i;

				celdaIdOper.appendChild(textoCeldaOper);
				celdaNombre.appendChild(textoCeldaNombre);
				celdaEstatus.appendChild(textoCeldaEstatus);
				celdaAccion.appendChild(inputCeldaAccion);

				hilera.appendChild(celdaIdOper);
				hilera.appendChild(celdaNombre);
				hilera.appendChild(celdaEstatus);
				hilera.appendChild(celdaAccion);
				
				tbodyOper.appendChild(hilera);
			}
		})
		.fail(function(){
			jAlert('Hubo un error al consultar la información de operadores. Intente de nuevo mas tarde', 'Mensaje');
		})
		.always(function(){
			hideSpinner();
			$("#btn_guardar").show();
			$("#hflagFinMigracion").val('0');
			$("#dTablaOperadores").hide();
		});
		
		let params={};
		params.opcion			=1;
		params.idCliente		=idCliente;
		params.idSubcadena		=idSubCadena;
		params.idCadena			=idCadena;
		// info cte.

		$.ajax({
			data: params,
			type: 'POST',
			url: '../cliente/ajax/getClienteMigracion.php',
			dataType: 'json',
		})
		.done(function(resp){
			if(resp[0]){
				// if( resp[0].nombreCliente && (resp[0].nombreCliente).trim() == '' || (resp[0].nombreCliente == null || resp[0].nombreCliente == 'null') ){
				// 	jAlert('No se encontró operador para este cliente.', 'Mensaje');
				// 	$("#rowTituloAdmin").show();
				// 	$("#rowNombreA").show();
				// 	$("#rowNombreB").show();
				// 	$("#rowUsuario").show();
				// }else{
				// 	$("#rowTituloAdmin").hide();
				// 	$("#rowNombreA").hide();
				// 	$("#rowNombreB").hide();
				// 	$("#rowUsuario").hide();
				// }

				if( resp[0].idOperador === null || resp[0].idOperador === 'null'){
					resp[0].idOperador = 0;
				}

				$('input[name=nFiscalizado]').attr("disabled",true);
				$('input[name=nRegimen]').attr("disabled",true);

				if(resp[0].idRegimenCliente == 1){
					$("#nFiscalizadoSi").prop("checked", true);
					$("#nFiscalizadoNo").prop("checked", false);

					$("#nRegimenFisico").prop("checked", true);
					$("#nRegimenMoral").prop("checked", false);
					$("#nRegimenSinRegimen").prop("checked", false);
				}
				else if(resp[0].idRegimenCliente == 2){
					$("#nFiscalizadoSi").prop("checked", true);
					$("#nFiscalizadoNo").prop("checked", false);

					$("#nRegimenFisico").prop("checked", false);
					$("#nRegimenMoral").prop("checked", true);
					$("#nRegimenSinRegimen").prop("checked", false);
				}else{
					$("#nFiscalizadoSi").prop("checked", false);
					$("#nFiscalizadoNo").prop("checked", true);

					$("#nRegimenFisico").prop("checked", false);
					$("#nRegimenMoral").prop("checked", false);
					$("#nRegimenSinRegimen").prop("checked", true);
				}

				$("#sconfCadena").val(resp[0].nombreCadena);
				$("#sconfRazonSocial").val(resp['razonSocial']);
				$("#sconfCorresponsal").val(resp[0].nombreCorresponsal);
				$("#sconfCantCorresponsal").val(resp[0].cantCorresponsales);
				$("#sconfNombre").val(resp[0].nombreCliente);
				$("#sconfPaterno").val(resp[0].apPaternoCliente);
				$("#sconfMaterno").val(resp[0].apMaternoCliente);
				$("#sconfCorreo").val(resp[0].correoCliente);
				$("#sconfTelefono").val(resp['telefono']);
				$("#sconfUsuario").val(resp['usuario']);
				$("#sconfContrasena").val(resp['contrasena']);
				$("#sconfCantOperadores").val(resp[0].cantOperadores);
				$("#numCuentaCorresponsal").val(resp[0].numCuentaCorresponsal);
				$("#referencia").val(resp[0].referencia);
				$("#sRFC").val(resp[0].RFC);

				$("#hnIdCadena").val(idCadena);
				$("#hnTipoPersona").val(resp[0].tipoPersona);
				$("#hsCURPCliente").val(resp[0].CURPCliente);
				$("#hnIdTipoIdentificacion").val(resp[0].idTipoIdentificacionCliente);
				$("#hsNumIdentificacion").val(resp[0].nNumIdentificacionCliente);
				$("#hnFigPolitica").val(resp[0].figPoliticaCliente);
				$("#hnIdTipoForeloCliente").val(resp[0].idTipoForeloCliente);
				$("#hnIdSubCadena").val(idSubCadena);
				$("#hnIdCorresponsal").val(resp[0].idCorresponsal);
				$("#hnIdOperador").val(resp[0].idOperador);
				$("#hcodigoAccesoCorresponsal").val(resp[0].codigoAccesoCorresponsal);
				$("#hnIdCliente").val(idCliente);
				$("#hnumCuentaCorresponsal").val(resp[0].numCuentaCorresponsal);
				$("#hreferencia").val(resp[0].referencia);
				$("#hSerie").val(resp[0].serie);

				$("#hVersionCliente").val(resp[0].versionCliente);

				$("#hidRegimen").val(resp[0].idRegimenCliente);
			}
			else{
				jAlert('No se recibio informacion de la consulta.', 'Mensaje');
			}
		}).fail(function(){
			jAlert('Hubo un error al consultar la información del cliente. Intente de nuevo mas tarde', 'Mensaje');
		}).always(function(){
			hideSpinner();
		});
	// *** *** ***
}

function confirmarDatos(){
	let flag = 0;
	let sCadena = ($("#sconfCadena").val()).trim();
	let sRazonSocial = ($("#sconfRazonSocial").val()).trim();
	let sCorresponsal = ($("#sconfCorresponsal").val()).trim();
	let sNombre = ($("#sconfNombre").val()).trim();
	let sPaterno = ($("#sconfPaterno").val()).trim();
	let sMaterno = ($("#sconfMaterno").val()).trim();
	let sCorreo = ($("#sconfCorreo").val()).trim();
	let telefono = ($("#sconfTelefono").val()).trim();
	let sUsuario = ($("#sconfUsuario").val()).trim();
	let sContrasena = ($("#sconfContrasena").val()).trim();
	let cantOperadores = parseInt( $("#sconfCantOperadores").val() );
	let referencia = $("#referencia").val(); //if( referencia.trim() == '' ){ referencia = '0'; }
	administradores = '';	administradores = [];

	if( sCadena == "" ){
		jAlert("El campo de 'Cadena' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	else if( sRazonSocial == "" ){
		jAlert("El campo de 'Razon Social' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	else if( sCorresponsal == "" ){
		jAlert("El campo de 'Corresponsal' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	
	else if( sCorreo == "" ){
		jAlert("El campo de 'Correo Electronico' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	else if( !validar_email( sCorreo ) ){
		jAlert('Correo Electr\u00F3nico No v\u00E1lido', 'Mensaje');
		flag = 1;
	}
	else if( telefono == "" ){
		jAlert("El campo de 'Telefono' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	else if( referencia.trim() == '' ){
		jAlert("El campo de 'Referencia' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}

	if(cantOperadores == 0){
		if( sNombre == "" ){
			jAlert("El campo de 'Nombre' no puede estar vacio.", 'Mensaje');
			flag = 1;
		}
		else if( sPaterno == "" ){
			jAlert("El campo de 'Apellido Paterno' no puede estar vacio.", 'Mensaje');
			flag = 1;
		}
		else if( sUsuario == "" ){
			jAlert("El campo de 'Usuario' no puede estar vacio.", 'Mensaje');
			flag = 1;
		}
		else if( sUsuario.lenght > 5 ){
			jAlert("El campo de 'Usuario' no puede mayor a 5 caracteres. Favor de corregir.", 'Mensaje');
			flag = 1;
		}
		else if( sContrasena == "" ){
			jAlert("El campo de 'Contrasena' no puede estar vacio.", 'Mensaje');
			flag = 1;
		}
	}
	
	let nIdOperadorRE = '0';
	let nombreSplit = '';
	let a=0;
	// condicionar el campo de texto de nombre apellido pat y mat del usuario administrador capturado.
	
		for(i=0; i<cantOperadores; i++){
			if( $('#adminChck'+i).prop('checked') ) {
				administradores.push( $("#adminChck"+i).val() );

				a++;
				if( sNombre == '' && sPaterno == '' ){
					if(a == 1){ 
						for(b=0; b<operadoresCliente.length; b++){
							if(operadoresCliente[b].idOperador == $("#adminChck"+i).val()){
								sNombre = operadoresCliente[b].nombreOperador.trim();
								sPaterno = operadoresCliente[b].paternoOperador.trim();
								if(operadoresCliente[b].maternoOperador != '' && operadoresCliente[b].maternoOperador != null && operadoresCliente[b].maternoOperador != 'null'){
									sMaterno = operadoresCliente[b].maternoOperador.trim();
								}else{
									sMaterno = '';
								}
	
								if(sMaterno == ''){
									sUsuario = sNombre.substring(0,1)+sPaterno.substring(0,1);
								}else{
									sUsuario = sNombre.substring(0,1)+sPaterno.substring(0,1)+sMaterno.substring(0,1);
								}
								sUsuario = sUsuario.toUpperCase();
							}
						}
						nIdOperadorRE = $("#adminChck"+i).val();
					}
				}
			}
		}

	
	if(administradores.length == 0 && sNombre == '' && sPaterno == ''){
		jAlert("Seleccione un administrador de la lista de operadores o capture uno en los campos correspondientes.", 'Mensaje');
		flag = 1;
	}
	else if(sNombre == ''){
		jAlert("El campo de 'Nombre' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	else if(sPaterno == ''){
		jAlert("El campo de 'Apellido Paterno' no puede estar vacio.", 'Mensaje');
		flag = 1;
	}
	

	if(flag == 0){
		let confirma = confirm(`¿Esta seguro de realizar la migración del cliente: ${$("#sconfRazonSocial").val()} ?`);
		if(confirma === true){
			// realiza proceso migracion
			showSpinner();
			jAlert('Procesando información.', 'Mensaje');
			$("#btn_guardar").hide();
			
			let CURP = $("#hsCURPCliente").val(); if( CURP.trim() == '' ){ CURP = '0'; }
			let hnIdTipoIdentificacion = $("#hnIdTipoIdentificacion").val(); if( hnIdTipoIdentificacion.trim() == '' ){ hnIdTipoIdentificacion = '0'; }
			let hsNumIdentificacion = $("#hsNumIdentificacion").val(); if( hsNumIdentificacion.trim() == '' ){ hsNumIdentificacion = '0'; }
			let hnIdTipoForeloCliente = $("#hnIdTipoForeloCliente").val(); if( hnIdTipoForeloCliente.trim() == '' ){ hnIdTipoForeloCliente = '0'; }
			let hcodigoAccesoCorresponsal = $("#hcodigoAccesoCorresponsal").val(); if( hcodigoAccesoCorresponsal.trim() == '' ){ hcodigoAccesoCorresponsal = '0'; }
			let numCuentaCorresponsal = $("#numCuentaCorresponsal").val(); if( numCuentaCorresponsal.trim() == '' ){ numCuentaCorresponsal = '0'; }
			let sRFC = $("#sRFC").val(); if( sRFC.trim() == '' ){ sRFC = '0'; }
			let hSerie = $("#hSerie").val(); if( hSerie.trim() == '' ){ hSerie = '0'; }
			let hnFigPolitica = $("#hnFigPolitica").val(); if( hnFigPolitica.trim() == '' ){ hnFigPolitica = '0'; }
			let hnTipoPersona = $("#hidRegimen").val(); if( hnTipoPersona.trim() == 0 ){ hnTipoPersona = '3'; }

			let params={};
			params.opcion					=1; // registro de cliente
			params.nidCadenaRE				=$("#hnIdCadena").val();
			params.sCadena					=sCadena;
			params.sRazonSocial				=sRazonSocial;
			params.sCorresponsal			=sCorresponsal;
			params.sNombre					=sNombre;
			params.sPaterno					=sPaterno;
			params.sMaterno					=sMaterno;
			params.sCorreo					=sCorreo;
			params.telefono					=telefono;
			params.sUsuario					=sUsuario;
			params.sContrasena				=sContrasena;
			params.tipoPersona				=hnTipoPersona;
			params.sCURP					=CURP;
			params.nIdTipoIdentif			=hnIdTipoIdentificacion;
			params.nNumIdentif				=hsNumIdentificacion;
			params.nFigPolitica				=hnFigPolitica;
			params.nIdTipoForeloCliente 	=hnIdTipoForeloCliente;
			params.codigoAccesoCorresponsal =hcodigoAccesoCorresponsal;
			params.nIdSubCadenaRE			=$("#hnIdSubCadena").val();
			params.nIdCorresponsalRE		=$("#hnIdCorresponsal").val();
			// params.nIdOperadorRE			=$("#hnIdOperador").val();
			params.nIdOperadorRE			=nIdOperadorRE;
			params.sNumCuenta				=numCuentaCorresponsal;
			params.sReferencia				=referencia;
			params.sRFC						=sRFC;
			params.nSerie					=hSerie;
			params.administradores 			= administradores;

			// *** consultar configuración cliente ***
				let paramsConfig={};
				paramsConfig.opcion 			= 7;
				paramsConfig.nIdSubCadenaRE 	= $("#hnIdSubCadena").val();
				paramsConfig.nIdCorresponsalRE 	= $("#hnIdCorresponsal").val();
				
				$.ajax({
					data: paramsConfig,
					type: 'POST',
					url: '../cliente/ajax/getClienteMigracion.php',
					dataType: 'json'
				})
				.done(function(resp){
					let respuesta = resp[0];
					if(respuesta.idAgente > 0){ // se encontro modalidad S. y R.
						// consultar mapeo AMP con valores encontrados
						selectMapeoAMP(respuesta,params);
					}
					else{
						// funcion migrar cliente Serv
						let confirma = confirm(`El cliente no tiene configuracion de Remesas. ¿Esta seguro de realizar la migración del cliente con Servicios?`);
						if(confirma === true){
							pasoMigrarClienteServ(params);
						}
						else{
							jAlert('Se canceló el proceso de migración para Aqui Mis Pagos.', 'Mensaje');
							hideSpinner();
							$("#btn_guardar").show();
						}
					}
				})
				.fail(function(){
					jAlert('Error al buscar la modalidad del cliente. Intente de nuevo.', 'Mensaje');
					hideSpinner();
					$("#btn_guardar").show();
				});
			// ***************************************
		}
	}
}

function selectMapeoAMP(params='',paramsRE=''){
	$("#hmigracion").val('');
	$("#hidAgente").val(params.idAgente);

	params.opcion = 8;

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(resp){
		let respuesta = resp;

		if(respuesta.IdCadenaAMP > 0 && respuesta.IdSucursalAMP == 0){
			let confirma = confirm(`El cliente se encontro mapeado en Aqui Mis Pagos con solo Remesas. ¿Esta seguro de realizar la migración del cliente para completar con Servicios?`);
			if(confirma === true){
				pasoMigrarSoloServ(params,paramsRE, respuesta);
			}
			else{
				jAlert('Se canceló el proceso de migración para Aqui Mis Pagos.', 'Mensaje');
				hideSpinner();
			}
		}
		else if(respuesta.IdSucursalAMP > 0 && respuesta.IdCadenaAMP == 0){
			let confirma = confirm(`El cliente se encontro mapeado en Aqui Mis Pagos con solo Servicios. ¿Esta seguro de realizar la migración del cliente para completar con Remesas?`);
			if(confirma === true){
				pasoMigrarSoloRem(params);
			}
			else{
				jAlert('Se canceló el proceso de migración para Aqui Mis Pagos.', 'Mensaje');
				hideSpinner();
			}
		}
		else if(respuesta.IdSucursalAMP == 0 && respuesta.IdCadenaAMP == 0){
			let confirma = confirm(`El cliente no se encontro mapeado en Aqui Mis Pagos. ¿Esta seguro de realizar la migración del cliente con Servicios y Remesas?`);
			if(confirma === true){
				paramsRE.migracion = 1; // flag indicador de migrar servicios y remesas.
				paramsRE.administradores = administradores;
				$("#hmigracion").val(1);
				pasoMigrarClienteServ(paramsRE);
			}
			else{
				jAlert('Se canceló el proceso de migración para Aqui Mis Pagos.', 'Mensaje');
				hideSpinner();
			}
		}
		else{
			jAlert('Se encontró mapeo completo previo en Aqui Mis Pagos.'+"\n"+'No se procesó la migración.', 'Mensaje');
			hideSpinner();
		}
	})
	.fail(function(resp){
		jAlert('Hubo un error al procesar la informacion de migracion.'+"\n"+'Codigo: f.selectMapeoAMP','Mensaje');
		hideSpinner();
	})
}

// *** Migrar solo Remesas cuando ya existen servicios ***
function pasoMigrarSoloRem(params=''){
	params='';
	if(params == ''){
		params = {};
		let idAgente = $("#hidAgente").val();
		params.opcion 		= 15;
		params.idAgente 	= idAgente;
		// params.idCadenaAMP 	= $("#hnIdCadenaAMP").val();
		// params.idClienteRE 	= $("#hnIdCliente").val();

		$.ajax({
			data: params,
			type: 'POST',
			url: '../cliente/ajax/setClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(resp){
			migrarProductos();
		})
		.fail(function(){
			jAlert('Fallo el proceso de remesas.','Mensaje');
			hideSpinner();
		})
	}
}

// *** Migrar solo servicios cuando ya existen remesas ***
function pasoMigrarSoloServ(params='',paramsRE='',respuesta){
	paramsRE.opcion = 11;
	paramsRE.idCadenaAMP = respuesta.IdCadenaAMP;
	paramsRE.idSucursalAMP = respuesta.IdSucursalAMP;
	paramsRE.idUsuarioAMP = respuesta.IdUsuarioAMP;

	let idcadenaAMPtemp = $("#hnIdCadenaAMP").val();
	if(idcadenaAMPtemp == '' || idcadenaAMPtemp == 0){
		$("#hnIdCadenaAMP").val(respuesta.IdCadenaAMP);
	}

	// si capturo un administrador, registrarlo.
	// 1. Registrar usuario en webpos
	// 2. registrar usuario en AMP
	// Los siguientes pasos de mapeo, los hace la funcion de mapeo operadores.
	
	let sconfNombre = $("#sconfNombre").val();
	let sconfPaterno = $("#sconfPaterno").val();
	let sconfMaterno = $("#sconfMaterno").val();
	let sTelefono = $("#sconfTelefono").val();
	let sCorreo = $("#sconfCorreo").val();
	let hnIdCadenaAMP = $("#hnIdCadenaAMP").val();
	let sconfUsuario = $("#sconfUsuario").val();
	let hnIdCorresponsal = $("#hnIdCorresponsal").val();

	if(sconfNombre != '' && sconfPaterno != '' && hnIdCorresponsal != '')
	{
		let sApellidos = sconfPaterno+" "+sconfMaterno;
		let paramsAdmin = {};
		paramsAdmin.opcion = 10;
		paramsAdmin.idCorresponsalRE = hnIdCorresponsal;
		paramsAdmin.sNombre = sconfNombre.toUpperCase().trim();
		paramsAdmin.sApellidos = sApellidos.toUpperCase().trim();

		// 1. Registrar usuario en webpos
		$.ajax({
			data: paramsAdmin,
			type: 'POST',
			url: '../cliente/ajax/setClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(respAdmin){

			if(respAdmin[0].ResultCode > 0){ // error
				jAlert('Codigo de error: '+respAdmin[0].ResultCode+' '+respAdmin[0].ResultMessage, 'Mensaje');
				hideSpinner();
			}
			else{
				// 2. Registrar usuario en AMP
				let paramsAdminAMP = {};
				let data = {};
				data.nombreOperador = sconfNombre;
				data.paternoOperador = sconfPaterno;
				data.maternoOperador = sconfMaterno;
				data.telefonoOperador = sTelefono;
				data.correoOperador = sCorreo;
				data.idCadenaAMP = hnIdCadenaAMP;
				data.idSucursalAMP = 0
				data.cveUsuario = sconfUsuario;
				data.idOperador = respAdmin[0].IdOperador;
				data.idAgente = params.idAgente;
				data.hnIdCorresponsal = hnIdCorresponsal;

				paramsAdminAMP.opcion = 16; // usuario
				paramsAdminAMP.data = data; 

				$.ajax({
					data: paramsAdminAMP,
					type: 'POST',
					url: '../cliente/ajax/setClienteMigracion.php',
					dataType: 'json'
				})
				.done(function(respAdminAMP){

					$.ajax({
						data: paramsRE,
						type: 'POST',
						url: '../cliente/ajax/setClienteMigracion.php', // registro cliente
						dataType: 'json'
					})
					.done(function(resp){
						if(resp[0].errorCode > 0){ // error
							jAlert('Codigo de error: '+resp[0].errorCode+' '+resp[0].msg, 'Mensaje');
							hideSpinner();
						}
						else{
							// Mapear sucursales
							$("#hnIdCadenaAMP").val(respuesta.IdCadenaAMP);
							mapearSucursales(paramsRE,params); // solo mapeo de sucursales para RE-AMP
							registroAccesoTerminal();
						}
					})
					.fail(function(resp){
						hideSpinner();
					})

				})
				.fail(function(){
					jAlert('Hubo un error al registrar el administrador en Aqui Mis Pagos.','Mensaje');
					hideSpinner();
				});
			}
		})
		.fail(function(respAdmin){
			jAlert('Hubo un error al registrar el administrador en Red Efectiva.','Mensaje');
			hideSpinner();
		})
	}
	else{
		$.ajax({
			data: paramsRE,
			type: 'POST',
			url: '../cliente/ajax/setClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(resp){
			if(resp[0].errorCode > 0){ // error
				jAlert('Codigo de error: '+resp[0].errorCode+' '+resp[0].msg, 'Mensaje');
				hideSpinner();
			}
			else{
				// Mapear sucursales
				$("#hnIdCadenaAMP").val(respuesta.IdCadenaAMP);
				mapearSucursales(paramsRE,params); // solo mapeo de sucursales para RE-AMP
				registroAccesoTerminal();
			}
		})
		.fail(function(resp){
			hideSpinner();
		})
	}
}

function pasoMigrarClienteServ(params=''){
		$.ajax({
			data: params,
			type: 'POST',
			url: '../cliente/ajax/setClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(resp){
			if( typeof resp[0] !== 'undefined'){
				if(resp[0].errorCode == 0 && resp[0].nIdCadenaAMP > 0 && resp[0].nIdSucursal > 0 && resp[0].nIdUsuario > 0){ // ok
					jAlert('Exito al registrar la información del cliente.', 'Mensaje');
					$("#hidUsuarioAMP").val(resp[0].nIdUsuario);
					cveUsuario = (resp[0].cveUsuario).trim();
					
					$("#hnIdCadenaAMP").val(resp[0].nIdCadenaAMP);

					if(resp[0].id_mapOperador == 0){
						registroOperador();
					}
					registroCodigoAcceso();
					registroAccesoTerminal();
				}
				else if(resp[0].errorCode == 999){
					jAlert('Error Code: '+resp[0].errorCode +"\n"+ resp[0].msg999, 'Error');
					hideSpinner();
				}
				else{
					jAlert('Error Code: '+resp[0].errorCode+"\n"+'Hubo un error al procesar la información de migración.'+"\n"+'Intente de nuevo.', 'Error');
					hideSpinner();
				}
			}
			else{
				jAlert('Error al recibir la información del proceso de migración.'+"\n"+'Intente de nuevo.', 'Error'); 
				hideSpinner();
			}
		})
		.fail(function(){
			jAlert('Error al ejecutar el proceso de migracion.'+"\n"+'Intente de nuevo.', 'Error');
			hideSpinner();
		})
	
}

function mapearSucursales(paramsRE='', params=''){
	// 1. Consultar corresponsales. OK
	// 2. Consultar corresponsales vs agencias de la tabla conf_acceso_agencia. OK
	// 3. Mapear solo los corresponsales de la tabla de conf_acceso_agencia. OK
	// 4. Registrar corresponsales que falten por dar de alta. OK
	// 5. Registrar su clave de acceso de TD en tabla conf_acceso_agencia. (pendiente)

	// idCadena AMP

	paramsRE.opcion 	= 2;
	paramsRE.idCliente 	= $("#hnIdCliente").val();
	paramsRE.flagMigRE 	= 1;

	$.ajax({
		data: paramsRE,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(resp){
		params.opcion = 9;
		//paramsRE.corresponsales = resp;
		let corresponsales = resp;

		$.ajax({
			data: params,
			type: 'POST',
			url: '../cliente/ajax/getClienteMigracion.php', // consulta mapeo de corresponsales y agencias en RE. (solo id's)
			dataType: 'json'
		})
		.done(function(resp){
			let sucursalesAMP = resp;
			let paramsMapeo={};
			if(resp[0].errorCode == 0){ // ok
				paramsMapeo.opcion = 12;
				paramsMapeo.resp = resp;

				$.ajax({
					data: paramsMapeo,
					type: 'POST',
					url: '../cliente/ajax/setClienteMigracion.php', // Registrar mapeo de las sucursales que ya existen.
					dataType: 'json'
				})
				.done(function(resp){
					let corresponsalesB = [];
					let flag = 0;
					// *** limpiar array de corresponsales ***
					for(i=0; i<corresponsales.length; i++)
					{
						flag = 0;
						for(a=0; a<sucursalesAMP.length; a++)
						{
							if(corresponsales[i].idCorresponsal == sucursalesAMP[a].idCorresponsal){
								flag = 1;
								break;
							}
						}
						if(flag == 0){
							corresponsalesB.push(corresponsales[i]);
						}
					}

					let paramsRegistro = {};

					paramsRegistro.opcion = 6;
					paramsRegistro.idCadenaAMP = $("#hnIdCadenaAMP").val();
					paramsRegistro.idCliente = $("#hnIdCliente").val();
					//paramsRegistro.data = corresponsalesB;
					$.ajax({
						data: paramsRegistro,
						type: 'POST',
						url: '../cliente/ajax/setClienteMigracion.php',
						dataType: 'json'
					})
					.done(function(resp){
						mapeoOperadoresComplementoRE();
					})
					.fail(function(resp){
						hideSpinner();
					})
				})
				.fail(function(resp){
					hideSpinner();
				})
			}
			else{ // error en sp
				jAlert('Codigo de error: '+resp[0].errorCode+' '+resp[0].msg, 'Mensaje');
				hideSpinner();
			}
		})
		.fail(function(resp){
			hideSpinner();
		})
	})
	.fail(function(resp){
		hideSpinner();
	})
}

function mapeoOperadoresComplementoRE(){
	// *** Mapeo de operadores complemento de RE ***
	/*
	1. Consultar usuarios de AMP.
	2. Consultar Operadores Webpos RE por nombre, cadenaRE, corresponsalRE.
	3. Registrar mapeo RE en AMP de los que se encontraron.
	4. Registrar usuarios Webpos de los que no se encontraron como nuevos para RE en catalogo y mapeo.
	*/

	let paramsUsuariosAMP = {};

	paramsUsuariosAMP.opcion = 10;
	paramsUsuariosAMP.idCadenaAMP = $("#hnIdCadenaAMP").val();

	$.ajax({
		data: paramsUsuariosAMP,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(respUsuAMP){
		// Consultar operadores de webpos.

		let paramsOperadoresWebpos = {};

		paramsOperadoresWebpos.opcion = 3;
		paramsOperadoresWebpos.idCliente = $("#hnIdCliente").val();

		$.ajax({
			data: paramsOperadoresWebpos,
			type: 'POST',
			url: '../cliente/ajax/getClienteMigracion.php',
			dataType: 'json'
		})
		.done(function(respOperWebpos){
			if(respUsuAMP.length > 0){ // registrar mapeo RE de los encontrados en AMP de TD
				setMapeoOperadoresREComplemento(respUsuAMP,respOperWebpos);	
			}
			else{ // ir a mapeo productos. Reusar funcion existente.
				migrarProductos();
			}
		})
		.fail(function(respOperWebpos){
			hideSpinner();
		})
	})
	.fail(function(respUsuAMP){
		hideSpinner();
	})
}

function setMapeoOperadoresREComplemento(respUsuAMP='',respOperWebpos=''){
	jAlert('Procesando información.'+"\n"+'Complemento de Operadores.', 'Mensaje');

	if(respUsuAMP.length > 0 && respOperWebpos.length > 0)
	{
		if(respUsuAMP[0].enc_value.nIdUsuario && respUsuAMP[0].enc_value.nIdUsuario > 0) // si existe id usuario
		{
			let paramsMapeo = {};
			paramsMapeo.opcion = 13;
			paramsMapeo.respUsuAMP = respUsuAMP;

			$.ajax({
				data: paramsMapeo,
				type: 'POST',
				url: '../cliente/ajax/setClienteMigracion.php',
				dataType: 'json'
			})
			.done(function(respMapOper){
				if( typeof(respMapOper[0].data[0].IdOperador) !== 'undefined' )
				{
					// mapear operador RE en AMP.
					mapeoOperadorREComplemento(respMapOper,respUsuAMP, respOperWebpos);
				}
				else{
					jAlert('1. Hubo un error en el proceso de alta de operador complemento en RE.', 'Mensaje');
					hideSpinner();
				}
			})
			.fail(function(respMapOper){
				jAlert('2. Hubo un error en el proceso de alta de operador complemento en RE.', 'Mensaje');
				hideSpinner();
			})
		}else{
			jAlert('3. Hubo un error en el conteo de la informacion de proceso de alta de operador complemento en RE.', 'Mensaje');
			hideSpinner();
		}
	}else{
		jAlert('4. Hubo un error en la informacion de proceso de alta de operador complemento en RE.', 'Mensaje');
		hideSpinner();
	}
}

function mapeoOperadorREComplemento(respMapOper='',respUsuAMP='', respOperWebpos=''){
	// funcion para solo mapear el operador en AMP por complemento de migracion previa de remesas con el agregado de servicios
	jAlert('Procesando información.'+"\n"+'Complemento de Operadores. Mapeo.', 'Mensaje');
	let params = {};
	params.opcion = 14;
	params.idCadenaAMP = $("#hnIdCadenaAMP").val();
	params.respMapOper = respMapOper;
	params.respUsuAMP = respUsuAMP;
	params.respOperWebpos = respOperWebpos;
	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/setClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(respMapOperB){
		// Migrar productos
		migrarProductos();
	})
	.fail(function(respMapOperB){
		jAlert('Hubo un error en el proceso de mapeo de operador complemento en RE.', 'Mensaje');
		hideSpinner();
	})
}

function registroOperador(){
	let params={};
	params.opcion				= 10; // registro operador en RE
	params.idCorresponsalRE 	= $("#hnIdCorresponsal").val();
	params.sNombre 				= ($("#sconfNombre").val()).trim();
	params.sApellidos 			= ($("#sconfPaterno").val()+' '+$("#sconfMaterno").val()).trim();

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/setClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(resp){
		if(typeof resp[0] !== 'undefined'){ // ok
			if(resp[0].ResultCode == 0 || resp[0].ResultCode == 2){
				mapeoOperador(resp[0].IdOperador);
			}
		}
	})
	.fail(function(resp){

	})
}

function mapeoOperador(nIdOperadorRE){
	let params={};
	params.opcion				= 4; // mapeo operador
	params.P_nIdOperadorRE		= nIdOperadorRE;
	params.P_nIdOperadorAMP		= $("#hidUsuarioAMP").val();
	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/setClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(resp){

	})
	.fail(function(resp){

	})
}

function registroCodigoAcceso(){
	let params={};
	params.opcion				=5; // Registro cod. acceso
	params.idCadenaRE			=$("#hnIdCadena").val();
	params.idSubCadenaRE		=$("#hnIdSubCadena").val(); 
	params.idCorresponsal		=$("#hnIdCorresponsal").val(); 
	params.codigoAcceso			=$("#hcodigoAccesoCorresponsal").val(); 

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/setClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(respE){
		if(typeof respE[0] !== 'undefined'){ // ok
			if(respE[0].errorCode == 0){
				jAlert(respE[0].msg, 'Mensaje');

				migrarSucursales();
			}
			else{
				jAlert('Hubo un error al registrar el codigo de acceso.', 'Mensaje');
				hideSpinner();
			}
		}
	})
	.fail(function(){
		jAlert('Hubo un error al registrar el codigo de acceso.', 'Mensaje');
		hideSpinner();
	})
}

function registroAccesoTerminal(){

	jAlert('Procesando información acceso terminal.', 'Mensaje');
	let idClienteRE = $("#hnIdCliente").val();
	
	// consultar corresponsales
	let paramsCorresponsales={};
	paramsCorresponsales.opcion 	= 2;
	paramsCorresponsales.idCliente 	= idClienteRE;
	paramsCorresponsales.flagMigRE 	= 2;

	$.ajax({
		data: paramsCorresponsales,
		type: 'POST',
		url: '../cliente/ajax/getClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(respCorresponsales){
		// Registrar accesos
		if(respCorresponsales.length > 0)
		{
			for(i=0; i<respCorresponsales.length; i++)
			{
				if(respCorresponsales[i].idCorresponsal && respCorresponsales[i].idCorresponsal > 0)
				{
					let params={};
					params.opcion				=9; // Registro acceso terminal
					params.idCadenaRE			=$("#hnIdCadena").val(); 
					params.idSubCadenaRE		=$("#hnIdSubCadena").val(); 
					params.idCorresponsal		=respCorresponsales[i].idCorresponsal; 

					setTimeout(function(){
						$.ajax({
							data: params,
							type: 'POST',
							url: '../cliente/ajax/setClienteMigracion.php',
							dataType: 'json'
						})
						.done(function(resp){
							if(typeof resp[0] !== 'undefined'){ // ok
								jAlert(resp[0].msg, 'Mensaje');
							}
						})
						.fail(function(){
							jAlert('1.Hubo un error al registrar el acceso de terminal.', 'Mensaje');
						})	
					},0.1);
				}
				else{
					jAlert('2.No se encontro informacion de corresponsal para activar su acceso.', 'Mensaje');
				}
			}
		}
		else{
			jAlert('3.No se encontro informacion de corresponsal para activar su acceso.', 'Mensaje');
		}
	})
	.fail(function(){
		jAlert('4.Hubo un error al registrar el acceso de terminal.', 'Mensaje');
	});
}

function migrarSucursales(){ // funcion para migración de cliente con servicios unicamente.
	jAlert('Procesando información sucursales.', 'Mensaje');
	// let params={};
	// //params.opcion				=2; // Consulta corresponsales
	// params.idCliente			=$("#hnIdCliente").val();

	// $.ajax({
	// 	data: params,
	// 	type: 'POST',
	// 	url: '../cliente/ajax/getClienteMigracion.php',
	// 	dataType: 'json'
	// })
	// .done(function(respF){
	// 	if(typeof respF[0] !== 'undefined') // ok
	// 	{
	// 		if(respF[0].errorCode == 0)
	// 		{
				//jAlert(respF[0].msg, 'Mensaje');

				let params={};
				params.opcion		=6; // Registro Sucursales
				params.idCadenaAMP 	=$("#hnIdCadenaAMP").val();
				params.idCliente	=$("#hnIdCliente").val();
				//params.data			=respF

				$.ajax({
					data: params,
					type: 'POST',
					url: '../cliente/ajax/setClienteMigracion.php',
					dataType: 'json'
				})
				.done(function(respG){

					if(typeof respG[0] !== 'undefined'){ // ok
				
						if(respG['errorCode'] == 0){
							jAlert('Exito al insertar información de las sucursales.', 'Mensaje');

							migrarOperadores();
						}
						else{
							jAlert('100: Hubo un error al registrar los corresponsales.', 'Mensaje');
							hideSpinner();
						}
					}
					else{
						jAlert('101: Hubo un error al procesar el registro de los corresponsales.', 'Mensaje');
						hideSpinner();
					}
				})
				.fail(function(){
					jAlert('102: Hubo un error al procesar el registro de los corresponsales.', 'Mensaje');
					hideSpinner();
				});
	// 		}
	// 		else{
	// 			jAlert('Hubo un error al consultar los corresponsales.', 'Mensaje');
	// 			hideSpinner();
	// 		}
	// 	}
	// 	else{
	// 		jAlert('103: Hubo un error al procesar la consulta de los corresponsales.', 'Mensaje');
	// 		hideSpinner();
	// 	}
	// })
	// .fail(function(){
	// 	jAlert('104: Hubo un error al procesar la consulta de los corresponsales.', 'Mensaje');
	// 	hideSpinner();
	// });
}

function migrarOperadores(){
	jAlert('Procesando información operadores.', 'Mensaje');
	let cantOperadores = $("#sconfCantOperadores").val();

	let configMigracion = '';
	configMigracion = $("#hmigracion").val();


	if(cantOperadores == 0){
		jAlert("No existen operadores por migrar.", 'Mensaje');

		if(configMigracion == 1){ // si la migracion contiene remesas
			pasoMigrarSoloRem();
		}
		else{
			migrarProductos();
		}
	}
	else{
		// let params={};
		// params.opcion		=3; // Consulta de Operadores
		// params.idCliente 	=$("#hnIdCliente").val();

		// $.ajax({
		// 	data: params,
		// 	type: 'POST',
		// 	url: '../cliente/ajax/getClienteMigracion.php',
		// 	dataType: 'json',
		// 	success: function(resp){
		// 		if(typeof resp[0] !== 'undefined'){ // ok
		// 			if(resp[0].errorCode == 0){
		// 				jAlert(resp[0].msg, 'Mensaje');

						let cantOperadores = $("#sconfCantOperadores").val();
						
						let params={};
						params.opcion			= 7; // Registro de Operadores
						params.idCliente 		= $("#hnIdCliente").val();
						params.idCadenaAMP 		= $("#hnIdCadenaAMP").val();
						params.administradores 	= administradores;
						//params.data 		= resp;

						$.ajax({
							data: params,
							type: 'POST',
							url: '../cliente/ajax/setClienteMigracion.php',
							dataType: 'json'
						})
						.done(function(respB){
							if( typeof respB[0] !== 'undefined'){ // ok
								jAlert(respB[0].msg, 'Mensaje');
								if(configMigracion == 1){ // si la migracion contiene remesas
									pasoMigrarSoloRem();
								}
								else{
									migrarProductos();
								}
							}
							else{
								jAlert('Hubo un error al procesar el registro de los operadores.', 'Mensaje');
								hideSpinner();
							}
						})
						.fail(function(){
							jAlert('Hubo un error al procesar el registro de los operadores.', 'Mensaje');
							hideSpinner();
						})
	// 				}
	// 				else{
	// 					jAlert('Hubo un error al consultar los operadores.', 'Mensaje');
	// 				}
	// 			}
	// 			else{
	// 				jAlert('Hubo un error al procesar la consulta de los operadores.', 'Mensaje');
	// 			}
	// 		},
	// 		error: function(resp){
	
	// 		}
	// 	});
	}
}

function migrarProductos(){
	jAlert('Procesando información productos.', 'Mensaje');

	let params={};
	//$("#sconfUsuario").val(cveUsuario);
	$("#d_usFinal").show();
	$("#s_usFinal").html(cveUsuario);

	params.opcion					= 8; // Registro de Productos
	params.idCadenaAMP 				= $("#hnIdCadenaAMP").val();
	params.idCadenaRE 				= $("#hnIdCadena").val();
	params.idSubCadenaRE 			= $("#hnIdSubCadena").val();
	params.idCorresponsalMigracion 	= $("#hnIdCorresponsal").val();
	params.idVersionCliente 		= $("#hVersionCliente").val();
	// params.data 					= resp;

	$.ajax({
		data: params,
		type: 'POST',
		url: '../cliente/ajax/setClienteMigracion.php',
		dataType: 'json'
	})
	.done(function(respB){
		if(typeof respB[0] !== 'undefined'){ // ok
			if(respB[0].errorCode == 0){
				//jAlert(respB[0][0].msg, 'Mensaje');
				jAlert('Migración de cliente finalizada.', 'Mensaje');
				$("#hflagFinMigracion").val('1');
			}
			else{
				jAlert('1.Hubo un error al registrar los productos.', 'Mensaje');
				hideSpinner();
			}
		}
		else{
			jAlert('2.Hubo un error al procesar el registro de productos.', 'Mensaje');
			hideSpinner();
		}
	})
	.fail(function(respB){
		jAlert('3.Hubo un error al procesar el registro de productos.', 'Mensaje');
		hideSpinner();
	})
	.always(function(){
		hideSpinner();
	});
}

function generarUsuario(){
	let sUsuario = [];
	let nombre = $("#sconfNombre").val();
	let paterno = $("#sconfPaterno").val();
	let materno = $("#sconfMaterno").val();

	let splitNombre = nombre.split(' ');

	for(i=0; i<splitNombre.length; i++){
		sUsuario+=splitNombre[i].substring(0,1);	
	}

	sUsuario+=paterno.substring(0,1);
	sUsuario+=materno.substring(0,1);
	sUsuario = sUsuario.toUpperCase();
	
	$("#sconfUsuario").val(sUsuario);
}

function validarTelefono(elemento) {
    var texto = $("#" + elemento).val();
    var trimedo = texto.trim();
    var telefono = Number(trimedo.replace(/(?!-)[^0-9.]/g, ""));
    $("#" + elemento).val(telefono);
}

function soloLetras(tag) {
	let valor = $("#"+tag).val();
	let numeros = [1,2,3,4,5,6,7,8,9,0];

	for(let i in numeros){
		valor = valor.replaceAll(numeros[i],"");
	}

	$("#"+tag).val(valor);
}

function cerrarModuloMig(){
	let valorMigracion = $("#hflagFinMigracion").val();
	if(valorMigracion == 1){
		window.location.reload();
	}
}
