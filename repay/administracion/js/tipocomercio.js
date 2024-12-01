function initViewTipocomercio() {
    var tipoComercio = {

        Consulta: function () {
            var settings = {
                "iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                "oLanguage": {
                    "sZeroRecords": "No se encontraron registros",
                    "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sSearch": "Buscar:",
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
            $.post(BASE_PATH + "/repay/administracion/ajax/tipocomercio.php",
                    {
                        tipo: 1
                    },
                    function (response) {
                        hideSpinner();
                        $('#btnBuscar').button('reset');
                        var obj = jQuery.parseJSON(response);
                        if (obj.oCodigo == 0 && obj.Data.length > 0) {
                            jQuery.each(obj.Data, function (index, value) {
                                $('#data tbody').append('<tr>' +
                                        '<td class="idTipoComercio" data-idEcuesta="' + obj.Data[index]['nIdTipoComercio'] + '">' + obj.Data[index]['nIdTipoComercio'] + '</td>' +
                                        '<td class="sTipoComercio"  data-stipocomercio="' + obj.Data[index]['sTipoComercio'] + '">  ' + obj.Data[index]['sTipoComercio'] + '</td>' +
                                        '<td class="activo"         data-nActivo="' + obj.Data[index]['nActivo'] + '">              ' + obj.Data[index]['sActivo'] + '</td>' +
                                        '<td > ' + obj.Data[index]['dFechaRegistro'] + '</td>' +
                                        '<td > ' + obj.Data[index]['dFechamovimiento'] + '</td>' +
                                        '</tr>');
                            });
                            datos.dataTable(settings);
                            $('#data').removeClass("table-striped");
                            $('#data tbody tr').removeClass("odd");
                            $('#data tbody tr').removeClass("even");
                            document.getElementById("data").style.display = "inline-table";
                            document.getElementById("data").style.width = "100%";
                            $('.nav-tabs a[href="#step1"]').tab('show');
                            $('#btnDatosTipoComercioEditar').addClass("disabled");
                            $('#btnAgregarTipoComercio').removeClass("disabled");
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

        Alta: function () {
            $('#btnAgregar').button('loading');
            var nombreTipocomercio = $('#nombreTipocomercio').val();
            var campos = "";

            if (nombreTipocomercio == undefined || nombreTipocomercio == 0 && nombreTipocomercio.trim() == '') {
                campos += '* Nombre del Tipo de Comercio.\n';
            }

            if (campos != null && campos != "") {
                $('#btnAgregar').button('reset');
                var black = (campos != "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                showSpinner();
                $.post(BASE_PATH + "/repay/administracion/ajax/tipocomercio.php",
                        {
                            tipo: 2,
                            nombreTipocomercio: nombreTipocomercio
                        },
                        function (response) {
                            hideSpinner();
                            $('#btnAgregar').button('reset');
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                $('#nombreTipocomercio').val();
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                tipoComercio.Consulta();
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            } else {
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');

                            }
                        }).fail(function (resp) {
                    $('#btnAgregar').button('reset');
                    hideSpinner();
                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                });
            }

        },

        Editar: function () {
            var idTipocomercio = $('#idTipoComercioEdit').val();
            var nombreTipocomercio = $('#nombreTipocomercioEdit').val();
            jConfirm('\u00BFDesea modificar la comercio seleccionada\u003F', 'Seleccione una opción', function (confirmado) {
                if (confirmado) {
                    showSpinner();
                    $.post(BASE_PATH + "/repay/administracion/ajax/tipocomercio.php",
                            {
                                tipo: 3,
                                nTipoComercio: idTipocomercio,
                                nombreTipocomercio: nombreTipocomercio
                            },
                            function (response) {
                                $('#btnAgregar').button('reset');
                                var obj = jQuery.parseJSON(response);
                                if (obj.oCodigo == 0 && obj.Data.length > 0) {
                                    jAlert(obj.Data[0].errorMsg, 'Información al usuario');
                                    tipoComercio.Consulta();
                                    $('.nav-tabs a[href="#step1"]').tab('show');
                                } else {
                                    jAlert(obj.Data[0].errorMsg, 'Información al usuario');
                                    $('.nav-tabs a[href="#step1"]').tab('show');
                                }
                            })
                            .fail(function (resp) {
                                hideSpinner();
                                $('#btnAgregar').button('reset');
                                jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            });
                }
            });
        },

        Eliminar: function (idTipocomercio, activo) {
            var msg = "";
            if (activo == 0) {
                msg = "Desea activar el Tipo de Comercio";
            } else {
                msg = "Desea desactivar el Tipo de Comercio";
            }
            if (idTipocomercio != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/tipocomercio.php",
                                {
                                    tipo: 4,
                                    nTipoComercio: idTipocomercio,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                tipoComercio.Consulta();
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
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
                var idComercio = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idComercio != null) {
                    $('#btnDatosTipoComercioEditar').removeClass("disabled");
                    $('#btnAgregarTipoComercio').removeClass("disabled");
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

        ListarDatosComercioAEditar: function () {
            var idTipocomercio = $('#data tbody tr.selected td:first').html();
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
            if (indexActual == 0) {
                if (idTipocomercio != undefined) {
                    if (activo == 1) {
                        var nombreTipocomercio = $("#data tbody tr.selected td.sTipoComercio").data("stipocomercio");
                        $('#idTipoComercioEdit').val(idTipocomercio);
                        $('#nombreTipocomercioEdit').val(nombreTipocomercio);
                        $('.nav-tabs a[href="#step3"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarTipoComercio').addClass("disabled");
                        $('#btnEliminar').addClass("disabled");
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
            var tipoComercio = $('#nombreTipocomercio').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (tipoComercio != undefined && tipoComercio != 0) {
                campos += '* Nombre del tipo de comercio.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect != undefined && _rowSelect != 0) {
                            $('#btnDatosTipoComercioEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarTipoComercio').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect != undefined && _rowSelect != 0) {
                    $('#btnDatosTipoComercioEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarTipoComercio').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode == 27) {
                    tipoComercio.cancelarProceso();
                }
            },

            $('#data').on('dblclick', 'tr td', function () {
                tipoComercio.ListarDatosComercioAEditar();
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                tipoComercio.Alta();
            });

            $('#btnAgregarTipoComercio').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
                if (indexActual == 2) {
                    return false;
                } else {
                    $('#nombreTipocomercio').val("");
                }
            });

            $('#btnDatosTipoComercioEditar').click(function () {
                if (tipoComercio.ListarDatosComercioAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                $('#btnAgregar').button('loading');
                var tipocomercio = $('#nombreTipocomercioEdit').val();
                var campos = "";

                if (tipocomercio == undefined || tipocomercio == 0 && tipocomercio.trim() == '') {
                    campos += '* Nombre del tipo de comercio.\n';
                }

                if (campos != null && campos != "") {
                    $('#btnAgregar').button('reset');
                    var black = (campos != "") ? "Error en Los siguientes datos:" : "";
                    jAlert(black + '\n' + campos + '\n', "Información al usuario");
                    event.preventDefault();
                } else {
                    tipoComercio.Editar();
                }

            });

            $('#btnEliminar').click(function () {
                var idTipocomercio = $('#data tbody tr.selected td:first').html();
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
                if (indexActual == 0) {
                    if (idTipocomercio != undefined) {
                        tipoComercio.Eliminar(idTipocomercio, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                tipoComercio.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
            var idComercio = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarTipoComercio, #btnDatosTipoComercioEditar', function () {
                if (indexActual == 0 && idComercio != null) {
                    $('#btnConsultar').removeClass("disabled");
                    $('#btnAgregarTipoComercio').removeClass("disabled");
                    $('#btnDatosTipoComercioEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                } else {
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarTipoComercio').addClass("disabled");
                    $('#btnDatosTipoComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("tipocomercio");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    tipoComercio.Consulta();
                    $('#btnDatosTipoComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });
        }

    };
    tipoComercio.Consulta();
    tipoComercio.initBotones();
    tipoComercio.initAddColorRowTable();
    tipoComercio.initEventos();
}