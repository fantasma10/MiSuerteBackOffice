function initViewTipoContacto() {
    var TipoContacto = {

        Consulta: function () {
            var settings = {
                "iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                "bProcessing": true,
                "bFilter": false, //no permite el filtrado caja de texto
                "bDestroy": true, // reinicializa la tabla 
                "oLanguage": {
                    "sZeroRecords": "No se encontraron registros",
                    "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sSearch": "Buscar:",
                    "sProcessing": "Cargando...",
                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                    "oPaginate": {
                        "sNext": "Siguiente",
                        "sPrevious": " Anterior"
                    }
                },
                "bSort": false
            };
            $("#data tbody").empty();
            var datos = $("#data").DataTable();
            datos.fnClearTable();
            datos.fnDestroy();
            document.getElementById('data').style.display = 'none';
            showSpinner();
            $.post(BASE_PATH + "/repay/administracion/ajax/tipoContacto.php",
                    {
                        tipo: 1
                    },
                    function (response) {
                        hideSpinner();
                        $('#btnBuscar').button('reset');
                        var obj = jQuery.parseJSON(response);
                        if (obj.oCodigo === 0 && obj.Data.length > 0) {
                            jQuery.each(obj.Data, function (index, value) {
                                $('#data tbody').append('<tr>' +
                                        '<td class="idTipoContacto"  data-idTipoContacto="' + obj.Data[index]['nIdTipoContacto'] + '">  ' + obj.Data[index]['nIdTipoContacto'] + '</td>' +
                                        '<td class="sNombre" data-sNombre="' + obj.Data[index]['sDescripcion'] + '" >' + obj.Data[index]['sDescripcion'] + '</td>' +
                                        '<td class="activo"       data-nActivo="' + obj.Data[index]['nActivo'] + '">          ' + obj.Data[index]['sActivo'] + '</td>' +
                                        '<td >' + obj.Data[index]['dFecRegistro'] + '</td>' +
                                        '<td >' + obj.Data[index]['dFecMovimiento'] + '</td>' +
                                        '</tr>');
                            });
                            datos.dataTable(settings);
                            $('#data').removeClass("table-striped");
                            $('#data tbody tr').removeClass("odd");
                            $('#data tbody tr').removeClass("even");
                            document.getElementById("data").style.display = "inline-table";
                            document.getElementById("data").style.width = "100%";
                            $('.nav-tabs a[href="#step1"]').tab('show');
                            $('#btnDatosTipoContactoEditar').addClass("disabled");
                            $('#btnAgregarTipoContacto').removeClass("disabled");
                            $('#btnEliminar').addClass("disabled");
                        } else {
                            document.getElementById("data").style.display = "inline-table";
                            document.getElementById("data").style.width = "100%";
                            jAlert(obj.sMensaje, 'Información al usuario');
                        }
                    })
                    .fail(function (resp) {
                        hideSpinner();
                        jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                    });
        },

        Alta_Editar: function () {
            $('#btnAgregar').button('loading');
            $('#btnEditar').button('loading');
            var _tipo = 0;
            var tipo = $('#tipo').val().length > 0 ? parseInt($('#tipo').val()) : 0;
            var nTipoContacto = $('#nTipoContacto').val().length > 0 ? parseInt($('#nTipoContacto').val()) : 0;
            var sNombre = $('#sNombre').val();
            var campos = "";
            var msg = (tipo == 1 ? " guardar los datos " : " modificar el tipo de contacto");

            if (sNombre === undefined || sNombre === 0 || sNombre === "") {
                campos += '* Nombre.\n';
            }

            if (campos !== null && campos !== "") {
                $('#btnAgregar').button('reset');
                $('#btnEditar').button('reset');
                var black = (campos !== "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                jConfirm('\u00BFDesea ' + msg + ' \u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        _tipo = tipo === 1 ? 2 : 3;
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/tipoContacto.php",
                                {
                                    tipo: _tipo,
                                    nTipoContacto: nTipoContacto,
                                    sNombre: sNombre
                                },
                                function (response) {
                                    hideSpinner();
                                    $('#btnAgregar').button('reset');
                                    $('#btnEditar').button('reset');
                                    var obj = jQuery.parseJSON(response);
                                    if (obj.oCodigo === 0) {
                                        $('#frmTipoContacto')[0].reset();
                                        jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                        TipoContacto.Consulta();
                                        $('.nav-tabs a[href="#step1"]').tab('show');
                                    } else {
                                        jAlert(obj.sMensaje, "Información al usuario");
                                        $('.nav-tabs a[href="#step1"]').tab('show');
                                        TipoContacto.Consulta();
                                    }
                                }).fail(function (resp) {
                            $('#btnAgregar').button('reset');
                            hideSpinner();
                            jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                            TipoContacto.Consulta();
                        });
                    } else {
                        $('#btnAgregar').button('reset');
                        $('#btnEditar').button('reset');
                    }
                });
            }

        },

        Eliminar: function (idTipoContacto, activo) {
            var msg = "";
            if (activo === 0) {
                msg = "Desea activar el registro";
            } else {
                msg = "Desea desactivar el registro";
            }
            if (idTipoContacto != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/tipoContacto.php",
                                {
                                    tipo: 4,
                                    nTipoContacto: idTipoContacto,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                TipoContacto.Consulta();
                            } else {
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            }
                        }).fail(function (res) {
                            hideSpinner();
                            jAlert("Error, intentelo mas tarde", "Información al usuario");
                            $('.nav-tabs a[href="#step1"]').tab('show');
                        });
                    } else {
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    }
                });
            } else {
                jAlert("Seleccione un registro", "Información al usuario");
            }
        },

        initAddColorRowTable: function () {
            $('#data tbody').click(function () {
                var table = document.getElementById('data');
                selected = table.getElementsByClassName('selected');
                table.onclick = colorFilaTbody;
            });

            function colorFilaTbody(e) {
                if (selected[0])
                    selected[0].className = '';
                e.target.parentNode.className = 'selected';
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
                var idTipoContacto = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idTipoContacto != null) {
                    $('#btnDatosTipoContactoEditar').removeClass("disabled");
                    $('#btnAgregarTipoContacto').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
            }

            // Aplicar color a los registros del thead
            $('#data thead').click(function () {
                var tabla = document.getElementById('data');
                select = tabla.getElementsByClassName('theadSelected');
                tabla.onclick = colorFilaThead;
            });

            function colorFilaThead(e) {
                if (select[0])
                    select[0].className = '';
                e.target.parentNode.className = 'theadSelected';
            }
        },

        ListarDatosTipoContactoAEditar: function () {
            var idTipoContacto = $('#data tbody tr.selected td.idTipoContacto').data("idtipocontacto");
            var sNombre = $('#data tbody tr.selected td.sNombre').data("snombre");
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
            if (indexActual == 0) {
                if (idTipoContacto != undefined) {
                    if (activo == 1) {
                        document.getElementById('btnEditar').style.display = 'block';
                        document.getElementById('btnAgregar').style.display = 'none';
                        document.getElementById('tituloEditar').style.display = 'block';
                        document.getElementById('tituloAgregar').style.display = 'none';
                        document.getElementById('verIdTipoContacto').style.display = 'block';
                        $('#tipo').val(2);
                        $('#sNombre').val(sNombre);
                        $('#nTipoContacto').val(idTipoContacto);
                        $('.nav-tabs a[href="#step2"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarTipoContacto').addClass("disabled");
                        $('#btnEliminar').addClass("disabled");
                        $('.nav-tabs a[href="#step3"]').tab('show');
                    } else {
                        jAlert("Para modificar el registro, debe estar activo", "Información al usuario");
                        return false;
                    }
                } else {
                    jAlert("Seleccione un registro", "Información al usuario");
                    return false;
                }
            } else {
                return false;
            }
        },

        cancelarProceso: function () {
            var nTipoContacto = $('#nTipoContacto').val().length > 0 ? parseInt($('#nTipoContacto').val()) : 0;
            var sNombre = $('#sNombre').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (nTipoContacto !== undefined && nTipoContacto !== 0 && nTipoContacto !== "") {
                campos += '* ID Tipo Contacto.\n';
            }
            if (sNombre !== undefined && sNombre !== 0 && sNombre !== "") {
                campos += '* Nombre.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect !== undefined && _rowSelect !== 0) {
                            $('#btnDatosTipoContactoEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarTipoContacto').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect !== undefined && _rowSelect !== 0) {
                    $('#btnDatosTipoContactoEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarTipoContacto').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode === 27) {
                    TipoContacto.cancelarProceso();
                }
            };

            $('#data').on('dblclick', 'tr td', function () {
                if (TipoContacto.ListarDatosTipoContactoAEditar() === false) {
                    return false;
                }
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                TipoContacto.Alta_Editar();
            });

            $('#btnAgregarTipoContacto').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    $('#tipo').val(1);
                    $('#frmTipoContacto')[0].reset();
                    document.getElementById('tituloEditar').style.display = 'none';
                    document.getElementById('tituloAgregar').style.display = 'block';
                    document.getElementById('btnAgregar').style.display = 'block';
                    document.getElementById('btnEditar').style.display = 'none';
                    document.getElementById('verIdTipoContacto').style.display = 'none';
                }
            });

            $('#btnDatosTipoContactoEditar').click(function () {
                if (TipoContacto.ListarDatosTipoContactoAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                TipoContacto.Alta_Editar();
            });

            $('#btnEliminar').click(function () {
                var idTipoContacto = $('#data tbody tr.selected td.idTipoContacto').data("idtipocontacto");
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
                if (indexActual == 0) {
                    if (idTipoContacto != undefined) {
                        TipoContacto.Eliminar(idTipoContacto, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                TipoContacto.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
            var idTipoContacto = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarTipoContacto, #btnDatosTipoContactoEditar', function () {
                if (indexActual == 0 && idTipoContacto != null) {
                    $('#btnConsultar').removeClass("disabled");
                    $('#btnAgregarTipoContacto').removeClass("disabled");
                    $('#btnDatosTipoContactoEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                } else {
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarTipoContacto').addClass("disabled");
                    $('#btnDatosTipoContactoEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocontacto");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    TipoContacto.Consulta();
                    $('#btnDatosTipoContactoEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });
        }
    };
    TipoContacto.Consulta();
    TipoContacto.initBotones();
    TipoContacto.initAddColorRowTable();
    TipoContacto.initEventos();
}