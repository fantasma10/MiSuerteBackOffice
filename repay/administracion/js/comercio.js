function initViewComercio() {
    var Comercio = {

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
            $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
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
                                        '<td class="nIdComercio"  data-nIdComercio="' + obj.Data[index]['nIdComercio'] + '">  ' + obj.Data[index]['nIdComercio'] + '</td>' +
                                        '<td >' + obj.Data[index]['sTipoComercio'] + '</td>' +
                                        '<td >' + obj.Data[index]['sNombreComercio'] + '</td>' +
                                        '<td >' + obj.Data[index]['sRazonSocial'] + '</td>' +
                                        '<td >' + obj.Data[index]['sRFC'] + '</td>' +
//                                        '<td >'+obj.Data[index]['sToken']      +'</td>'+
                                        '<td class="activo"       data-nActivo="' + obj.Data[index]['nActivo'] + '">          ' + obj.Data[index]['sActivo'] + '</td>' +
                                        '<td >' + obj.Data[index]['dFechaRegistro'] + '</td>' +
                                        '<td >' + obj.Data[index]['dFechamovimiento'] + '</td>' +
                                        '</tr>');
                            });
                            datos.dataTable(settings);
                            $('#data').removeClass("table-striped");
                            $('#data tbody tr').removeClass("odd");
                            $('#data tbody tr').removeClass("even");
                            document.getElementById("data").style.display = "inline-table";
                            document.getElementById("data").style.width = "100%";
                            $('.nav-tabs a[href="#step1"]').tab('show');
                            $('#btnDatosComercioEditar').addClass("disabled");
                            $('#btnAgregarComercio').removeClass("disabled");
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
            var cmbTipoComercio = $('#cmbTipoComercio').val();
            var nombreComercio = $('#nombreComercio').val();
            var razonSocial = $('#razonSocial').val();
            var sRFC = $('#sRFC').val();
            var tipo = $('#tipo').val();
            var campos = "";

            if (cmbTipoComercio == undefined || cmbTipoComercio == 0) {
                campos += '* Tipo de Comercio.\n';
            }
            if (nombreComercio == undefined || nombreComercio == 0 && nombreComercio.trim() == '') {
                campos += '* Nombre del Comercio.\n';
            }
            if (razonSocial == undefined || razonSocial == 0 && razonSocial.trim() == '') {
                campos += '* Razon Social.\n';
            }
            if (sRFC.length != "" || sRFC != 0) {
                sRFC = myTrim(sRFC);

                if (sRFC.length < 12 || sRFC.length > 13) {
                    campos += '* Capture un RFC inválido.\n';
                } else if (!validaRFC(sRFC)) {
                    campos += '* Capture un RFC Inválido.\n';
                }
            }

            if (campos != null && campos != "") {
                $('#btnAgregar').button('reset');
                var black = (campos != "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                showSpinner();
                $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
                        {
                            tipo: 2,
                            cmbTipoComercio: cmbTipoComercio,
                            nombreComercio: nombreComercio,
                            razonSocial: razonSocial,
                            RFC: sRFC
                        },
                        function (response) {
                            hideSpinner();
                            $('#btnAgregar').button('reset');
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                $('#frmComercio')[0].reset();
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Comercio.Consulta();
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            } else {
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');
                                Comercio.Consulta();
                            }
                        }).fail(function (resp) {
                    $('#btnAgregar').button('reset');
                    hideSpinner();
                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                    Comercio.Consulta();
                });
            }

        },

        Editar: function () {
//            $('#btnEditar').button('loading');
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var idComercio = $('#idComercio').val();
            var cmbTipoComercio = $('#cmbTipoComercio').val();
            var nombreComercio = $('#nombreComercio').val();
            var razonSocial = $('#razonSocial').val();
            var sRFC = $('#sRFC').val();
            var tipo = $('#tipo').val();
            var campos = "";

            if (cmbTipoComercio == undefined || cmbTipoComercio == 0) {
                campos += '* Tipo de Comercio.\n';
            }
            if (nombreComercio == undefined || nombreComercio == 0 && nombreComercio.trim() == '') {
                campos += '* Nombre del Comercio.\n';
            }
            if (razonSocial == undefined || razonSocial == 0 && razonSocial.trim() == '') {
                campos += '* Razon Social.\n';
            }
            if (sRFC.length != "" || sRFC != 0) {
                sRFC = sRFC.toUpperCase();
                sRFC = myTrim(sRFC);

                if (sRFC.length < 12 || sRFC.length > 13) {
                    campos += '* Capture un RFC inválido.\n';
                } else if (!validaRFC(sRFC)) {
                    campos += '* Capture un RFC Inválido.\n';
                }
            }

            if (campos != null && campos != "") {
//                    $('#btnEditar').button('reset');
                var black = (campos != "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                jConfirm('\u00BFDesea modificar el comercio seleccionado\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $('#btnEditar').button('loading');
                        $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
                                {
                                    tipo: 3,
                                    cmbTipoComercio: cmbTipoComercio,
                                    nComercio: idComercio,
                                    nombreComercio: nombreComercio,
                                    razonSocial: razonSocial,
                                    RFC: sRFC,
                                    nActivo: activo
                                },
                                function (response) {
                                    $('#btnEditar').button('reset');
                                    hideSpinner();
                                    var obj = jQuery.parseJSON(response);
                                    if (obj.oCodigo == 0 && obj.Data.length > 0) {
                                        $('#frmComercio')[0].reset();
                                        jAlert(obj.Data[0].errorMsg, 'Información al usuario');
                                        Comercio.Consulta();
                                        $('.nav-tabs a[href="#step1"]').tab('show');
                                    } else {
                                        jAlert(obj.sMensaje, 'Información al usuario');
                                        $('.nav-tabs a[href="#step1"]').tab('show');
                                    }
                                })
                                .fail(function (resp) {
                                    hideSpinner();
                                    $('#btnEditar').button('reset');
                                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                                    $('.nav-tabs a[href="#step1"]').tab('show');
                                });
                    }
                });
            }
        },

        Eliminar: function (idComercio, activo) {
            var msg = "";
            if (activo == 0) {
                msg = "Desea activar el Comercio";
            } else {
                msg = "Desea desactivar el Comercio";
            }
            if (idComercio != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
                                {
                                    tipo: 4,
                                    nComercio: idComercio,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Comercio.Consulta();
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
                var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
                var idComercio = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idComercio != null) {
                    $('#btnDatosComercioEditar').removeClass("disabled");
                    $('#btnAgregarComercio').removeClass("disabled");
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
            var idComercio = $('#data tbody tr.selected td.nIdComercio').data("nidcomercio");
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
            if (indexActual == 0) {
                if (idComercio != undefined) {
                    if (activo == 1) {
                        $('#frmComercio')[0].reset();
                        document.getElementById('btnEditar').style.display = 'block';
                        document.getElementById('btnAgregar').style.display = 'none';
                        document.getElementById('tituloEditar').style.display = 'block';
                        document.getElementById('tituloAgregar').style.display = 'none';
                        document.getElementById('verToken').style.display = 'block';
                        $('#cmbTipoComercio').attr("disabled", true);
                        $('.nav-tabs a[href="#step2"]').tab('show');
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
                                {
                                    tipo: 6,
                                    nComercio: idComercio
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                obj = obj.Data;
                                $('#idComercio').val(obj[0]['nIdComercio']);
                                $('#cmbTipoComercio').val(obj[0]['nIdTipoComercio']);
                                $('#nombreComercio').val(obj[0]['sNombreComercio']);
                                $('#razonSocial').val(obj[0]['sRazonSocial']);
                                $('#sRFC').val(obj[0]['sRFC']);
                                $('#sTokenEditar').val(obj[0]['sToken']);
                            } else {
                                hideSpinner();
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');

                            }
                        }).fail(function () {

                        });
                        var nombreComercio = $("#data tbody tr.selected td.sTipoComercio").data("stipocomercio");
                        $('#idTipoComercioEdit').val(idComercio);
                        $('#nombreComercioEdit').val(nombreComercio);
                        $('.nav-tabs a[href="#step3"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarComercio').addClass("disabled");
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
            var cmbTipoComercio = $('#cmbTipoComercio').val();
            var comercio = $('#nombreComercio').val();
            var razonSocial = $('#razonSocial').val();
            var sRFC = $('#sRFC').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (cmbTipoComercio != undefined && cmbTipoComercio != 0) {
                campos += '* Tipo del comercio.\n';
            }
            if (comercio != undefined && comercio != 0 && comercio != "") {
                campos += '* Nombre del comercio.\n';
            }
            if (razonSocial != undefined && razonSocial != 0 && razonSocial != "") {
                campos += '* razon social.\n';
            }
            if (sRFC != undefined && sRFC != 0 && sRFC != "") {
                campos += '* RFC.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect != undefined && _rowSelect != 0) {
                            $('#btnDatosComercioEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarComercio').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect != undefined && _rowSelect != 0) {
                    $('#btnDatosComercioEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarComercio').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode == 27) {
                    Comercio.cancelarProceso();
                }
            }

            $('#data').on('dblclick', 'tr td', function () {
                Comercio.ListarDatosComercioAEditar();
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                Comercio.Alta();
            });

            $('#btnAgregarComercio').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
                if (indexActual == 2) {
                    return false;
                } else {
                    $('#nombreComercio').val("");
                    $('#frmComercio')[0].reset();
                    document.getElementById('tituloEditar').style.display = 'none';
                    document.getElementById('tituloAgregar').style.display = 'block';
                    document.getElementById('btnEditar').style.display = 'none';
                    document.getElementById('btnAgregar').style.display = 'block';
                    document.getElementById('verToken').style.display = 'none';
                    $('#cmbTipoComercio').attr("disabled", false);
                    $('#tipo').val(1);
                }
            });

            $('#btnDatosComercioEditar').click(function () {
                if (Comercio.ListarDatosComercioAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                Comercio.Editar();
            });

            $('#btnEliminar').click(function () {
                var idComercio = $('#data tbody tr.selected td.nIdComercio').data("nidcomercio");
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
                if (indexActual == 0) {
                    if (idComercio != undefined) {
                        Comercio.Eliminar(idComercio, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                Comercio.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
            var idComercio = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarComercio, #btnDatosComercioEditar', function () {
                if (indexActual == 0 && idComercio != null) {
                    $('#btnConsultar').removeClass("disabled");
                    $('#btnAgregarComercio').removeClass("disabled");
                    $('#btnDatosComercioEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                } else {
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarComercio').addClass("disabled");
                    $('#btnDatosComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("comercio");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    Comercio.Consulta();
                    $('#btnDatosComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });
        },

        initCombos: function () {
            $('#cmbTipoComercio').empty();
            var listaTipoComercio = "";
            $.post(BASE_PATH + "/repay/administracion/ajax/comercio.php",
                    {
                        tipo: 5
                    }, function (resp) {
                listaTipoComercio += "<option value='0'>Seleccione...</option>";
                var obj = jQuery.parseJSON(resp);
                if (obj.oCodigo == 0) {
                    obj = obj.Data;
                    jQuery.each(obj, function (index, val) {
                        listaTipoComercio += '<option value="' + obj[index]['nIdTipoComercio'] + '">' + obj[index]['sTipoComercio'] + '</option>';
                    });
                    $('#cmbTipoComercio').html(listaTipoComercio);
                }
            }).fail(function () {
                jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
            });
        },

        initFormatoCampos: function () {
            $('#sRFC, #sRFC').alphanum({
                allow: '-',
                allowSpace: false,
                allowOtherCharSets: false,
                maxLength: 13
            });
        },

    };
    Comercio.Consulta();
    Comercio.initCombos();
    Comercio.initBotones();
    Comercio.initAddColorRowTable();
    Comercio.initFormatoCampos();
    Comercio.initEventos();
}

function validaRFC(strRFC) {
    if (strRFC !== '') {
        var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
        return patt.test(strRFC);
    } else {
        return false;
    }
}
