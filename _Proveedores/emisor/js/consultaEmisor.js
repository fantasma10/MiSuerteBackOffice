var dataTableObj;
function initViewConsultaEmisores() {
    var Layout = {
        inicializatxt: function () {
            $("#abreviaturaEmisor").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 15
            });

            $("#descripcionEmisor").alphanum({
                allow: '-',
                allowNumeric: true,
                allowOtherCharSets: true,
                maxLength: 45
            });
        },
        buscaEmisores: function () {
            dataTableObj = $('#tabla_emisores').dataTable({
                "iDisplayLength": 50, 	//numero de columnas a desplegar
                "bProcessing": true, 	// mensaje 
                "bServerSide": false, 	//procesamiento del servidor
                "bFilter": true, 		//no permite el filtrado caja de texto
                "bDestroy": true, 			// reinicializa la tabla 
                "sAjaxSource": "/_Proveedores/emisor/ajax/consulta.php", //ajax que consulta la informacion		        
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
                        'aTargets': [0, 1, 2, 3, 4],
                        "bSortable": false,
                    },
                    {
                        "mData": 'idEmisor',
                        'aTargets': [0],
                        'sClass': 'center'
                    },
                    {
                        "mData": 'abrevNomEmivosr',
                        'aTargets': [1],
                        'sClass': 'center'
                    },
                    {
                        "mData": 'descEmisor',
                        'aTargets': [2],
                        'sClass': 'center'
                    },
                    {
                        "mData": 'idEstatusEmisor',
                        'aTargets': [3],
                        'sClass': 'center'
                    },
                    {
                        "mData": 'idEmisor',
                        'aTargets': [4],
                        'sClass': 'center',
                        mRender: function (data, type, row) {
                            if (row.idEstatusEmisor == 1) {
                                boton_desactivar = '<button id="confirmacionDesactivarProveedor" data-id=' + row.idEmisor + ' data-name="' + row.abrevNomEmivosr + '" data-placement="top" rel="tooltip" title="Inhabilitar Emisor"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
                            } else {
                                boton_desactivar = '<button id="confirmacionActivarProveedor" data-id=' + row.idEmisor + ' data-name="' + row.abrevNomEmivosr + '" data-placement="top" rel="tooltip" title="Habilitar Emisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
                            }
                            boton_edit = '<button id="editarEmisor" onclick="handleEditarEmisor(' + row.idEmisor + ');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';

                            botones = "<center>" + boton_desactivar + boton_edit + "</center>";
                            return botones;
                        }

                    },


                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var estatusCell = $(nRow).find('td:eq(3)');
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
            $("#tabla_emisores").css("display", "inline-table");
            $("#tabla_emisores").css("width", "100%");
        }
    }//Layout

    Layout.inicializatxt();
    Layout.buscaEmisores();
    obtenerDatosEmisor()
} // initViewConsultaEmisores

const showError = (input, mensaje, isInput = true) => {
    let formField = null;
    let error = null;

    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('success');
    formField.addClass('error');

    error.text(mensaje);
};

const showSuccess = (input, isInput = true) => {
    let formField = null;
    let error = null;
    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('error');
    formField.addClass('success');

    error.text('');
}

// const esObligatorio = value => ((value === '') || (value === '-1') || (value === null)) ? false : true;
const esObligatorio = value => (value === '' || value === -1 || value === '-1' || value === null) ? false : true;

const validarCampo = (input) => {
    let valido = false;
    // debugger
    let valor = input.val();
    valor = valor ? valor.trim() : valor;

    if (!esObligatorio(valor)) {
        showError(input, 'El campo es requerido.', true);
    } else {
        showSuccess(input, true);
        valido = true;
    }

    return valido;
};

$(document).on('click', '#botonBuscar', function (e) {
    var estatus = $("#opcionEstastus").val();
    var dataTableObj = $('#tabla_emisores').dataTable({
        "iDisplayLength": 50, 	//numero de columnas a desplegar
        "bProcessing": true, 	// mensaje 
        "bServerSide": false, 	//procesamiento del servidor
        "bFilter": true, 		//no permite el filtrado caja de texto
        "bDestroy": true, 			// reinicializa la tabla 
        "sAjaxSource": "/_Proveedores/emisor/ajax/consulta.php", //ajax que consulta la informacion		        
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
                'aTargets': [0, 1, 2, 3, 4],
                "bSortable": false,
            },
            {
                "mData": 'idEmisor',
                'aTargets': [0],
                'sClass': 'center'
            },
            {
                "mData": 'abrevNomEmivosr',
                'aTargets': [1],
                'sClass': 'center'
            },
            {
                "mData": 'descEmisor',
                'aTargets': [2],
                'sClass': 'center'
            },
            {
                "mData": 'idEstatusEmisor',
                'aTargets': [3],
                'sClass': 'center'
            },
            {
                "mData": 'idEmisor',
                'aTargets': [4],
                'sClass': 'center',
                mRender: function (data, type, row) {

                    if (row.idEstatusEmisor == 1) {
                        boton_desactivar = '<button id="confirmacionDesactivarProveedor" data-id=' + row.idEmisor + ' data-name="' + row.abrevNomEmivosr + '" data-placement="top" rel="tooltip" title="Inhabilitar Emisor"  data-toggle="modal"  data-target="#confirmacion" class="btn inhabilitar btn-default btn-xs" data-title="Editar Informacion"><span class="fa fa-times"></span></button>'
                    } else {
                        boton_desactivar = '<button id="confirmacionActivarProveedor" data-id=' + row.idEmisor + ' data-name="' + row.abrevNomEmivosr + '" data-placement="top" rel="tooltip" title="Habilitar Emisor" data-toggle="modal" data-target="#confirmacion" class="btn habilitar btn-primary btn-xs" data-title="Editar Informacion"><span class="fa fa-check"></span></button>'
                    }

                    boton_edit = '<button id="editarEmisor" onclick="handleEditarEmisor(' + row.idEmisor + ');" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>';

                    botones = "<center>" + boton_desactivar + boton_edit + "</center>";
                    return botones;
                }

            },


        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            var estatusCell = $(nRow).find('td:eq(3)');
            var estatusValue = estatusCell.text();

            if (estatusValue === '1') {
                estatusCell.text('Activo');
                estatusCell.css('background-color', '#dff0d8');
            } else if (estatusValue === '0') {
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
            params['tipo'] = 2;
            params['perfil'] = ID_PERFIL;
            params['estatus'] = estatus;
            $.each(params, function (index, val) {
                aoData.push({ name: index, value: val });
            });
        }
    });
    $("#tabla_emisores").css("display", "inline-table");
    $("#tabla_emisores").css("width", "100%");
})

$(document).on('click', '#btn-emisor', function (e) {
    let abreviatura = $('#abreviaturaEmisor').val();
    let descripcion = $('#descripcionEmisor').val();
    let e_idemisor = $("#e_idemisor").val();
    let idUsuario = $("#idUsuario").val();
    let opcionEstastus = $("#opcionEstastus").val();

    validarCampo($('#abreviaturaEmisor'))
    validarCampo($('#descripcionEmisor'))
    validarCampo($('#opcionEstastus'))
    
    if (abreviatura === undefined || abreviatura === null || abreviatura === '') return

    if (descripcion === undefined || descripcion === null || descripcion === '') return

    if (opcionEstastus === '-1') return

    const info = {
        e_idemisor: e_idemisor !== '' ? e_idemisor : 0,
        idUsuario: idUsuario,
        abreviatura: abreviatura,
        descripcion: descripcion,
        opcionEstastus: opcionEstastus
    }

    guardarDatosEmisor(info)
})

function guardarDatosEmisor(info) {
    let btnEmisor = $('#btn-emisor')
    btnEmisor.prop('disabled', true);

    $('#loading').css('display', 'block');
    $('#formularioEmisores').css('display', 'none')
    

    $.post("/_Proveedores/emisor/ajax/consulta.php", {
        tipo: 3,
        e_idemisor: info.e_idemisor,
        idUsuario: info.idUsuario,
        abreviatura: info.abreviatura,
        descripcion: info.descripcion,
        opcionEstastus: info.opcionEstastus
    },
        function (response) {
            var obj = jQuery.parseJSON(response);
            jAlert(obj.msg);
            $('#loading').css('display', 'none');
            $('#formularioEmisores').css('display', 'block');
            btnEmisor.prop('disabled', false);

            let ruta = './consulta.php';
            window.location.href = ruta;
        }).fail(function (response) {
            $('#loading').css('display', 'none');
            $('#formularioEmisores').css('display', 'block');
            btnEmisor.prop('disabled', false);
			alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

function handleEditarEmisor(idEmisor) {
    var formProveedor = '<form action="registro.php"  method="post" id="formProveedor"><input type="text" name="txtidEmisor"  value="' + idEmisor + '"/></form>'
    $('body').append(formProveedor);
    $("#formProveedor").submit();
}

function obtenerDatosEmisor() {
    let idEmisor = $("#e_idemisor").val();

    if (!idEmisor) return

    let btnEmisor = $('#btn-emisor')
    btnEmisor.html('Actualizar')
    btnEmisor.prop('disabled', true);

    $.post("/_Proveedores/emisor/ajax/consulta.php", {
        tipo: 4,
        e_idemisor: idEmisor,
    },
        function (response) {
            var obj = jQuery.parseJSON(response);

            $('#abreviaturaEmisor').val(obj.abrevNomEmivosr);
            $('#descripcionEmisor').val(obj.descEmisor);
            $("#opcionEstastus").val(obj.idEstatusEmisor);
            $('#labelEmisor').html(` - (${obj.idEmisor}) ${obj.abrevNomEmivosr}`)
            btnEmisor.prop('disabled', false);
        }).fail(function (response) {
            btnEmisor.prop('disabled', false);
			alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

$(document).on('click', '#confirmacionDesactivarProveedor', function (e) {//pasa datos al modal para desactivar el proveedor
	var id = $(this).data("id");
	$("#idEmisorModal").val(id);
	$("#estatusEmisor").val(0);
	$('#confirmacion p').empty();
	var nombre = $(this).data("name");
	var texto = "Desea Desactivar este Proveedor: " + nombre;
	$('#confirmacion p').append(texto);
});

$(document).on('click', '#confirmacionActivarProveedor', function (e) {//pasa datos al modal para activa el preveedor
	var id = $(this).data("id");
	$("#idEmisorModal").val(id);
	$("#estatusEmisor").val(1);
	$('#confirmacion p').empty();
	var nombre = $(this).data("name");
	var texto = "Desea Activar este Proveedor: " + nombre;
	$('#confirmacion p').append(texto);
});

$(document).on('click', '#desactivarProveedor', function (e) {//activa o desactiva el proveedore
	var $this = $(this);
	$this.button('loading');
	id = $("#idEmisorModal").val();
	estatus = $("#estatusEmisor").val();
	$.post("/_Proveedores/emisor/ajax/consulta.php", {
		idEmisorModal: id,
		estatus: estatus,
		tipo: 5
	},
		function (response) {
			var obj = jQuery.parseJSON(response);
			if (obj.code == 0) {
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

