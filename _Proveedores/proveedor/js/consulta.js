function initViewConsulta() {
	var dataTableObj;
	var Layout = {
		buscarProveedores: function () {
			var dataTableObj = $('#tabla_proveedores').dataTable({
				"iDisplayLength": 50, 	//numero de columnas a desplegar
				"bProcessing": true, 	// mensaje 
				"bServerSide": false, 	//procesamiento del servidor
				"bFilter": true, 		//no permite el filtrado caja de texto
				"bDestroy": true, 			// reinicializa la tabla 
				"sAjaxSource": "/_Proveedores/proveedor/ajax/consulta.php", //ajax que consulta la informacion		        
				"sServerMethod": 'POST', //Metodo para enviar la informacion
				"aaSorting": [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
				"oLanguage": {
					"sLengthMenu": "Mostrar _MENU_",
					"sZeroRecords": "No se ha encontrado información",
					"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
					"sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
					"sProcessing": "<div id=\"loaderEmisor\" class=\"loaderEmisor\"><div id=\"loader\" class=\"loader\"></div></div>",
					"sSearch": "Buscar",
					"oPaginate": {
						"sPrevious": "Anterior", // This is the link to the previous page
						"sNext": "Siguiente"
					}
				},
				"aoColumnDefs": [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
					{
						'aTargets': [0, 1, 2, 3, 4, 5],
						"bSortable": false,
					},
					{
						"mData": 'idProveedor',
						'aTargets': [0]
					},
					{
						"mData": 'RFC',
						'aTargets': [1]
					},
					{
						"mData": 'razonSocial',
						'aTargets': [2]
					},
					{
						"mData": 'tipo',
						'aTargets': [3]
					},
					{
						"mData": 'idEstatusProveedor',
						'aTargets': [4],
						'sClass': 'sizeColumn center'
					},
					{
						"mData": 'idProveedor',
						'aTargets': [5],
						'sClass': 'center',
						mRender: function (data, type, row) {
							if (ID_PERFIL == 1) {
								if (row.idEstatusProveedor == 0) {
									boton_desactivar = '<button id="confirmacionDesactivarProveedor" data-id=' + row.idProveedor + ' data-name="' + row.razonSocial + '" data-placement="top" rel="tooltip" title="Inhabilitar Emisor"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
								} else {
									boton_desactivar = '<button id="confirmacionActivarProveedor" data-id=' + row.idProveedor + ' data-name="' + row.razonSocial + '" data-placement="top" rel="tooltip" title="Habilitar Emisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
								}
								boton_comisiones = '<button id="comisonesProveedorProducto" onclick="editarComisiones(' + row.idProveedor + ",'" + row.razonSocial + "'" + ');" data-placement="top" rel="tooltip" title="Definir Comisiones"  class="btn habilitar btn-default btn-xs" data-title="Definir Comisiones"><span class="fa fa-usd"></span></button>';
							} else {
								boton_desactivar = "";
								boton_comisiones = "";
							}

							boton_edit = '<button id="confirmacionDesactivarProveedor" onclick="editarProveedor(' + row.idProveedor + ');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';
							boton_productos = '<button id="btnProductos" onclick="verProductos(' + row.idProveedor + ",'" + row.razonSocial + "'" + ');" data-placement="top" rel="tooltip" title="Ver Productos" class="btn habilitar btn-default btn-xs" data-title="Ver Productos"><span class="fa fa-eye"></span></button>';
							boton_bitacora = '<button id="bitacoraCLiente" onclick="verBitacoraCliente(' + row.idProveedor + ', \'dat_proveedor\', \'' + row.razonSocial + '\')" data-placement="top" rel="tooltip" title="Ver Bitácora" data-toggle="modal" data-target="#verBitacora" class="btn habilitar btn-default btn-xs" data-title="Ver Bitácora"><span class="fa fa-book"></span></button>';
							botones = "<center class='contenedorAccion'>" + boton_desactivar + boton_edit + boton_productos + boton_comisiones + boton_bitacora + "</center>";
							return botones;
						}

					},

				],
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
					var estatusCell = $(nRow).find('td:eq(4)');
					var estatusValue = estatusCell.text();

					if (estatusValue === '0') {
						estatusCell.text('Activo');
						estatusCell.css('background-color', '#dff0d8');
					} else if (estatusValue === '1') {
						estatusCell.text('Inactivo');
						estatusCell.css('background-color', '#f2dede');
					}
				},
				"fnPreDrawCallback": function () {
				},
				"fnDrawCallback": function (aoData) {
				},
				"fnServerParams": function (aoData) {//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
					var params = {};
					params['tipo'] = 1;
					params['perfil'] = ID_PERFIL;
					$.each(params, function (index, val) {
						aoData.push({ name: index, value: val });
					});
				}
			});
			$("#tabla_reportes").css("display", "inline-table");
			$("#tabla_reportes").css("width", "100%");
		}
	}

	Layout.buscarProveedores();
	//Layout.initBotones();
} // initViewConsulta

$(document).on('click', '#confirmacionDesactivarProveedor', function (e) {//pasa datos al modal para desactivar el proveedor
	var id = $(this).data("id");
	$("#idProveedor").val(id);
	$("#estatusProveedor").val(1);
	$('#confirmacion p').empty();
	var nombre = $(this).data("name");
	var texto = "Desea Desactivar este Proveedor: " + nombre;
	$('#confirmacion p').append(texto);
});

$(document).on('click', '#confirmacionActivarProveedor', function (e) {//pasa datos al modal para activa el preveedor
	var id = $(this).data("id");
	$("#idProveedor").val(id);
	$("#estatusProveedor").val(0);
	$('#confirmacion p').empty();
	var nombre = $(this).data("name");
	var texto = "Desea Activar este Proveedor: " + nombre;
	$('#confirmacion p').append(texto);
});

$(document).on('click', '#desactivarProveedor', function (e) {//activa o desactiva el proveedore
	var $this = $(this);
	$this.button('loading');
	id = $("#idProveedor").val();
	estatus = $("#estatusProveedor").val();
	$.post("/_Proveedores/proveedor/ajax/consulta.php", {
		idProveedor: id,
		estatus: estatus,
		tipo: 2
	},
		function (response) {
			var obj = jQuery.parseJSON(response);
			
			if (obj.showMessage == 0) {
				jAlert(obj.msg);
				$("#desactivarProveedor").button('reset');
				$("#confirmacion").modal("hide");
				setTimeout("location.reload()", 2000);
			} else {
				jAlert(obj.msg);
				$("#confirmacion").modal("hide");
				setTimeout("location.reload()", 2000);
			}
		}).fail(function (response) {
			$("#desactivarProveedor").button('reset');
			$("#confirmacion").modal("hide");
			alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
});

function editarProveedor(idProveedor) {
	var formProveedor = '<form action="afiliacionProveedor.php"  method="post" id="formProveedor"><input type="text" name="txtidProveedor"  value="' + idProveedor + '"/></form>'
	$('body').append(formProveedor);
	$("#formProveedor").submit();
}

function editarComisiones(idProveedor, nombreProveedor) {
	var formProveedor = '<form action="editarComisiones.php"  method="post" id="formComisiones"><input type="text" name="txtidProveedor"  value="' + idProveedor + '"/><input type="text" name="txtNombreProveedor" id="txtNombreProveedor"  value="' + nombreProveedor + '"/></form>'
	$('body').append(formProveedor);
	$("#formComisiones").submit();
}

function EditarRuta(idProveedor, nombreProveedor, idRuta) {
	var formEditarComisiones = '<form action="editarComisiones.php"  method="post" id="formEditarComisiones">' +
		'<input type="text" name="txtidProveedor"  value="' + idProveedor + '"/><input type="text" name="txtNombreProveedor" id="txtNombreProveedor"  value="' + nombreProveedor + '"/>' +
		'<input type="text" name="txtNombreProveedor" id="txtNombreProveedor"  value="' + nombreProveedor + '"/>' +
		'<input type="text" name="txtidRuta"  value="' + idRuta + '"/>' +
		'</form>';
	$('body').append(formEditarComisiones);
	$("#formEditarComisiones").submit();
	// alert(idProveedor+" "+idRuta+" "+nombreProveedor);
}

function verProductos(idProveedor, razonSocial) {

	var head_tabla = `
		<table id="tabla_proveedor_productos" class="display table table-bordered table-striped">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Descripción</th>
					<th>Abreviatura<br/>Producto</th>
					<th>SKU</th>
					<th>Importe<br/>Máximo<br/>Ruta</th>
					<th>Importe<br/>Mínimo<br/>Ruta</th>
					<th>Porcentaje<br/>Costo<br/>Ruta</th>
					<th>Importe<br/>Costo<br/>Ruta</th>
					<th>Porcentaje<br/>Comisión<br/>Cliente</th>
					<th>Importe<br/>Comisión<br/>Cliente</th>
					<th>Porcentaje<br/>Comisión<br/>Corresponsal</th>
					<th>Importe<br/>Comisión<br/>Corresponsal</th>
					<th>Porcentaje<br/>Pago<br/>Proveedor</th>
					<th>Importe<br/>Pago<br/>Proveedor</th>
					<th>Porcentaje<br/>Cobro<br/>Proveedor</th>
					<th>Importe<br/>Cobro<br/>Proveedor</th>
					<th>Porcentaje<br>Margen<br>RED</th>
					<th>Importe<br>Margen<br>RED</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>`;
	$('#gridbox_tabla').html(head_tabla);
	var dataTableObj = $('#tabla_proveedor_productos').dataTable({
		"iDisplayLength": 10, 	//numero de columnas a desplegar
		"bProcessing": true, 	// mensaje 
		"bServerSide": false, 	//procesamiento del servidor
		"bFilter": true, 		//no permite el filtrado caja de texto
		"bDestroy": true, 			// reinicializa la tabla 
		"sAjaxSource": "/_Proveedores/proveedor/ajax/consulta.php", //ajax que consulta la informacion		        
		"sServerMethod": 'POST', //Metodo para enviar la informacion
		//"aaSorting"     : [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_",
			"sZeroRecords": "No se ha encontrado información",
			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
			"sProcessing": "<div id=\"loaderEmisor\" class=\"loaderEmisor\"><div id=\"loader\" class=\"loader\"></div></div>",
			"sSearch": "Buscar",
			"oPaginate": {
				"sPrevious": "Anterior", // This is the link to the previous page
				"sNext": "Siguiente"
			}
		},
		"aoColumnDefs": [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
			{
				'aTargets': ['_all'],
				"bSortable": false,
			},
			{
				"mData": 'idRuta',
				'aTargets': [0],
				'sClass': 'center', mRender: function (data, type, row) {

					boton_editar_ruta = "";
					if (ID_PERFIL == 1) {
						boton_editar_ruta = '<button id="editarRuta" onclick="EditarRuta(' + idProveedor + ",'" + razonSocial + "'" + ',' + row.idRuta + ');" data-placement="top" rel="tooltip" title="Editar Ruta"  class="btn btn-default btn-xs" data-title="Editar Ruta"><span class="fa fa-pencil"></span></button>';
					}
					botones = "<center>" + boton_editar_ruta + "</center>";
					return botones;
				}
			},
			{
				"mData": 'idRuta',
				'aTargets': [1]
			},
			{
				"mData": 'descRuta',
				'aTargets': [2]
			},
			{
				"mData": 'abrevProducto',
				'aTargets': [3]
			},
			{
				"mData": 'skuProveedor',
				'aTargets': [4]
			},
			{
				"mData": 'impMaxRuta',
				"sClass": 'alignRight',
				'aTargets': [5]
			},
			{
				"mData": 'impMinRuta',
				"sClass": 'alignRight',
				'aTargets': [6]
			},
			{
				"mData": 'perCostoRuta',
				"sClass": 'alignRight',
				'aTargets': [7]
			},
			{
				"mData": 'impCostoRuta',
				"sClass": 'alignRight',
				'aTargets': [8]
			},
			{
				"mData": 'perComCliente',
				"sClass": 'alignRight',
				'aTargets': [9]
			},
			{
				"mData": 'impComCliente',
				"sClass": 'alignRight',
				'aTargets': [10]
			},
			{
				"mData": 'perComCorresponsal',
				"sClass": 'alignRight',
				'aTargets': [11]
			},
			{
				"mData": 'impComCorresponsal',
				"sClass": 'alignRight',
				'aTargets': [12]
			},
			{
				"mData": 'nPerPagoProveedor',
				"sClass": 'alignRight',
				'aTargets': [13]
			},
			{
				"mData": 'nImpPagoProveedor',
				"sClass": 'alignRight',
				'aTargets': [14]
			},
			{
				"mData": 'perComisionProducto',
				"sClass": 'alignRight',
				'aTargets': [15]
			},
			{
				"mData": 'impComisionProducto',
				"sClass": 'alignRight',
				'aTargets': [16]
			},
			{
				'mData': 'nPerMargen',
				'sClass': 'alignRight',
				'aTargets': [17]
			},
			{
				'mData': 'nImpMargen',
				'sClass': 'alignRight',
				'aTargets': [18]
			}
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
		},
		"fnPreDrawCallback": function () {
		},
		"fnDrawCallback": function (aoData) {
		},
		"fnServerParams": function (aoData) {//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
			var params = {};
			params['tipo'] = 3;
			params['idProveedor'] = idProveedor;
			$.each(params, function (index, val) {
				aoData.push({ name: index, value: val });
			});
		}
	});

	$("#tabla_proveedor_productos").css("display", "inline-table");
	$("#tabla_proveedor_productos").css("width", "100%");
	$("#nombreProveedor").html(razonSocial);
	$("#productos").modal();
}

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

function insertarSaltoLinea(str, maxLength) {
	var result = '';
	while (str.length > maxLength) {
	  result += str.substring(0, maxLength) + '\n';
	  str = str.substring(maxLength);
	}
	result += str;
	
	return result;
  }

function verBitacoraCliente(idRegistro, catalogo, nombre) {
	if (getBitacora != null) {
		getBitacora.abort();
		getBitacora = null;
	}

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
				$(".panelrgb").css("max-width", "100%");
				$(".panel").css("max-width", "100%");

				document.getElementById("consultaClientePanel").style.display = "none";
				document.getElementById("bitacoraClientePanel").style.display = "block";
			} else {
				alert('No hay datos en la bitácora.');
				return;
			}

			$('#labelID').text(idRegistro + ' ' + nombre);

			$.each(obj, function (key, objValue) {
				var data = JSON.parse(objValue.ultimosCambios);
				var index = 1;
				var table = $('#bitacoraClienteTable');

				var user = objValue.usuario == '' ? '-' : objValue.usuario;


				if (Object.keys(data.old).length <= 0) {
					$.each(data['new'], function (key, value) {
						var row = $('<tr>').append(
							$('<td>').text(objValue.catalogo),
							$('<td>').text(user).css('font-weight', 'bold'),
							$('<td>').text(key),
							$('<td class="ellipsis">').text(''),
							$('<td class="ellipsis" style="max-width: 300px !important; white-space: normal !important;">').text(value ? insertarSaltoLinea(value, 40) : ''),
							$('<td>').text(objValue.fechMovimiento)
						);
						if (row.text().trim().length > 0) {
							table.append(row);
							index++;
						}
					});
				} else {
					$.each(data['old'], function (key, value) {
						var row = $('<tr>').append(
							$('<td>').text(objValue.catalogo),
							$('<td>').text(user).css('font-weight', 'bold'),
							$('<td>').text(key),
							$('<td class="ellipsis">').text(value ? value : ''),
							$('<td class="ellipsis" style="max-width: 300px !important; white-space: normal !important;">').text(data['new'][key] ? insertarSaltoLinea(data['new'][key], 40) : ''),
							$('<td>').text(objValue.fechMovimiento)
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
			})


			$("#bitacoraClienteTable").DataTable(settingsBitacoraCliente);
			$("#bitacoraClienteTable").css("width", "100%");
		},
		error: function (error) {
			alert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde");
		}
	});
}

function volverBitacora() {
	document.getElementById("consultaClientePanel").style.display = "block";
	document.getElementById("bitacoraClientePanel").style.display = "none";
	$("#bitacoraClienteTable").DataTable().fnDestroy();
	$("#bitacoraClienteTable tbody").empty();
}

$(document).on('click', '#botonBuscar', function (e) {
	var estatus = $("#opcionEstastus").val();

	var dataTableObj = $('#tabla_proveedores').dataTable({
		"iDisplayLength": 50, 	//numero de columnas a desplegar
		"bProcessing": true, 	// mensaje 
		"bServerSide": false, 	//procesamiento del servidor
		"bFilter": true, 		//no permite el filtrado caja de texto
		"bDestroy": true, 			// reinicializa la tabla 
		"sAjaxSource": "/_Proveedores/proveedor/ajax/consulta.php", //ajax que consulta la informacion		        
		"sServerMethod": 'POST', //Metodo para enviar la informacion
		"aaSorting": [[0, 'desc']], //Como se sorteara la informacion numero de columna y tipo
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_",
			"sZeroRecords": "No se ha encontrado información",
			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered": "(filtrado de _MAX_ total de Registros)",
			"sProcessing": "<div id=\"loaderEmisor\" class=\"loaderEmisor\"><div id=\"loader\" class=\"loader\"></div></div>",
			"sSearch": "Buscar",
			"oPaginate": {
				"sPrevious": "Anterior", // This is the link to the previous page
				"sNext": "Siguiente"
			}
		},
		"aoColumnDefs": [ //Desplegado de informacion  target es la posicion en la que viene en la respuesta
			{
				'aTargets': [0, 1, 2, 3, 4, 5],
				"bSortable": false,
			},
			{
				"mData": 'idProveedor',
				'aTargets': [0]
			},
			{
				"mData": 'RFC',
				'aTargets': [1]
			},
			{
				"mData": 'razonSocial',
				'aTargets': [2]
			},
			{
				"mData": 'tipo',
				'aTargets': [3]
			},
			{
				"mData": 'idEstatusProveedor',
				'aTargets': [4],
				'sClass': 'sizeColumn center'
			},
			{
				"mData": 'idProveedor',
				'aTargets': [5],
				'sClass': 'center',
				mRender: function (data, type, row) {
					if (ID_PERFIL == 1) {
						if (row.idEstatusProveedor == 0) {
							boton_desactivar = '<button id="confirmacionDesactivarProveedor" data-id=' + row.idProveedor + ' data-name="' + row.razonSocial + '" data-placement="top" rel="tooltip" title="Inhabilitar Emisor"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
						} else {
							boton_desactivar = '<button id="confirmacionActivarProveedor" data-id=' + row.idProveedor + ' data-name="' + row.razonSocial + '" data-placement="top" rel="tooltip" title="Habilitar Emisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
						}
						boton_comisiones = '<button id="comisonesProveedorProducto" onclick="editarComisiones(' + row.idProveedor + ",'" + row.razonSocial + "'" + ');" data-placement="top" rel="tooltip" title="Definir Comisiones"  class="btn habilitar btn-default btn-xs" data-title="Definir Comisiones"><span class="fa fa-usd"></span></button>';
					} else {
						boton_desactivar = "";
						boton_comisiones = "";
					}

					boton_edit = '<button id="confirmacionDesactivarProveedor" onclick="editarProveedor(' + row.idProveedor + ');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';
					boton_productos = '<button id="btnProductos" onclick="verProductos(' + row.idProveedor + ",'" + row.razonSocial + "'" + ');" data-placement="top" rel="tooltip" title="Ver Productos" class="btn habilitar btn-default btn-xs" data-title="Ver Productos"><span class="fa fa-eye"></span></button>';
					boton_bitacora = '<button id="bitacoraCLiente" onclick="verBitacoraCliente(' + row.idProveedor + ', \'dat_proveedor\', \'' + row.razonSocial + '\')" data-placement="top" rel="tooltip" title="Ver Bitácora" data-toggle="modal" data-target="#verBitacora" class="btn habilitar btn-default btn-xs" data-title="Ver Bitácora"><span class="fa fa-book"></span></button>';
					botones = "<center class='contenedorAccion'>" + boton_desactivar + boton_edit + boton_productos + boton_comisiones + boton_bitacora + "</center>";
					return botones;
				}

			},

		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			var estatusCell = $(nRow).find('td:eq(4)');
			var estatusValue = estatusCell.text();

			if (estatusValue === '0') {
				estatusCell.text('Activo');
				estatusCell.css('background-color', '#dff0d8');
			} else if (estatusValue === '1') {
				estatusCell.text('Inactivo');
				estatusCell.css('background-color', '#f2dede');
			}
		},
		"fnPreDrawCallback": function () {
		},
		"fnDrawCallback": function (aoData) {
		},
		"fnServerParams": function (aoData) {//Funcion que se activa al buscar infromacion en la tabla o cambiar de pagina aoData contiene l ainfo del datatable		          
			var params = {};
			params['tipo'] = 4;
			params['estatus'] = estatus;
			$.each(params, function (index, val) {
				aoData.push({ name: index, value: val });
			});
		}
	});
	$("#tabla_reportes").css("display", "inline-table");
	$("#tabla_reportes").css("width", "100%");

});


