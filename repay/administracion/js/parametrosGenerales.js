function initViewParametros() {
    var Parametros = {

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
            $.post(BASE_PATH + "/repay/administracion/ajax/parametrosGenerales.php",
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
                                '<td class="idParametro"  data-idParametro="' + obj.Data[index]['nIdParametro'] + '">  ' + obj.Data[index]['nIdParametro'] + '</td>' +
                                '<td >' + obj.Data[index]['sNombreProceso'] + '</td>' +
                                '<td >' + obj.Data[index]['sReferencia'] + '</td>' +
                                '<td >' + obj.Data[index]['sParametro'] + '</td>' +
                                '<td >' + obj.Data[index]['sTipoDato'] + '</td>' +
                                '<td >' + obj.Data[index]['sValorObligado'] + '</td>' +
                                '<td >' + obj.Data[index]['sValor'] + '</td>' +
//                                        '<td style="" >'+obj.Data[index]['sComentarios']+'</td>'+
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
                    $('#btnDatosParametroEditar').addClass("disabled");
                    $('#btnAgregarParametro').removeClass("disabled");
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
            var _tipo = 0;
            var tipo = $('#tipo').val().length > 0 ? parseInt($('#tipo').val()) : 0;
            var idParametro = $('#idParametro').val().length > 0 ? parseInt($('#idParametro').val()) : 0;
            var sNombreProceso = $('#sNombreProceso').val();
            var sReferencia = $('#sReferencia').val();
            var sParametro = $('#sParametro').val();
            var sComentarios = $('#sComentarios').val();
            var sTipoDato = $('#sTipoDato').val();
            var sValObligatorio = $('#sValObligatorio').prop('checked') ? 1 : 0;
            var sValor = $('#sValor').val();
            var campos = "";

            if (sNombreProceso === undefined || sNombreProceso === 0 || sNombreProceso === "") {
                campos += '* Nombre del proceso.\n';
            }
            if (sReferencia === undefined || sReferencia === 0 || sReferencia === "") {
                campos += '* Referencia.\n';
            }
            if (sParametro === undefined || sParametro === 0 || sParametro === "") {
                campos += '* Parametro.\n';
            }
            if (sValor === undefined || sValor === 0 || sValor === "") {
                campos += '* Valor.\n';
            }
            if (sComentarios === undefined || sComentarios === 0 || sComentarios === "") {
                campos += '* Comentarios.\n';
            }

            if (campos !== null && campos !== "") {
                $('#btnAgregar').button('reset');
                var black = (campos !== "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                _tipo = tipo === 1 ? 2 : 3;

                showSpinner();
                $.post(BASE_PATH + "/repay/administracion/ajax/parametrosGenerales.php",
                        {
                            tipo: _tipo,
                            nParametro: idParametro,
                            sNombreProceso: sNombreProceso,
                            sReferencia: sReferencia,
                            sParametro: sParametro,
                            sTipoDato: sTipoDato,
                            sValorObligado: sValObligatorio,
                            sValor: sValor,
                            sComentarios: sComentarios
                        },
                        function (response) {
                            hideSpinner();
                            $('#btnAgregar').button('reset');
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                $('#frmParametrosGrales')[0].reset();
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Parametros.Consulta();
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            } else {
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');
                                Parametros.Consulta();
                            }
                        }).fail(function (resp) {
                    $('#btnAgregar').button('reset');
                    hideSpinner();
                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                    Parametros.Consulta();
                });
            }

        },

        Eliminar: function (idParametro, activo) {
            var msg = "";
            if (activo == 0) {
                msg = "Desea activar el Parámetro";
            } else {
                msg = "Desea desactivar el Parámetro";
            }
            if (idParametro != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/parametrosGenerales.php",
                                {
                                    tipo: 4,
                                    nParametro: idParametro,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Parametros.Consulta();
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
                var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
                var idParametro = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idParametro != null) {
                    $('#btnDatosParametroEditar').removeClass("disabled");
                    $('#btnAgregarParametro').removeClass("disabled");
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

        ListarDatosParametroAEditar: function () {
            var idParametro = $('#data tbody tr.selected td.idParametro').data("idparametro");
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
            if (indexActual == 0) {
                if (idParametro != undefined) {
                    if (activo == 1) {
                        $('#frmParametrosGrales')[0].reset();
                        document.getElementById('btnEditar').style.display = 'block';
                        document.getElementById('btnAgregar').style.display = 'none';
                        document.getElementById('tituloEditar').style.display = 'block';
                        document.getElementById('tituloAgregar').style.display = 'none';
                        $('.nav-tabs a[href="#step2"]').tab('show');
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/parametrosGenerales.php",
                                {
                                    tipo: 1,
                                    nParametro: idParametro,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                obj = obj.Data;
                                $('#tipo').val(2);
                                $('#idParametro').val(obj[0]['nIdParametro']);
                                $('#sNombreProceso').val(obj[0]['sNombreProceso']);
                                $('#sReferencia').val(obj[0]['sReferencia']);
                                $('#sParametro').val(obj[0]['sParametro']);
                                $('#sTipoDato').val(obj[0]['sTipoDato']);
                                obj[0]['nValorObligado'] == 0 ? $('#sValObligatorio').prop("checked", false) : $('#sValObligatorio').prop('checked', true);
                                $('#sComentarios').val(obj[0]['sComentarios']);
                                $('#sValor').val(obj[0]['sValor']);
                            } else {
                                hideSpinner();
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');

                            }
                        }).fail(function () {

                        });
                        $('.nav-tabs a[href="#step3"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarParametro').addClass("disabled");
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
            var sNombreProceso = $('#sNombreProceso').val();
            var sReferencia = $('#sReferencia').val();
            var sParametro = $('#sParametro').val();
            var sValor = $('#sValor').val();
            var sComentarios = $('#sComentarios').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (sNombreProceso !== undefined && sNombreProceso !== 0 && sNombreProceso !== "") {
                campos += '* Nombre del proceso.\n';
            }
            if (sReferencia !== undefined && sReferencia !== 0 && sReferencia !== "") {
                campos += '* Referencia.\n';
            }
            if (sParametro !== undefined && sParametro !== 0 && sParametro !== "") {
                campos += '* Parametro.\n';
            }
            if (sValor !== undefined && sValor !== 0 && sValor !== "") {
                campos += '* Valor.\n';
            }
            if (sComentarios !== undefined && sComentarios !== 0 && sComentarios !== "") {
                campos += '* Comentarios.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect !== undefined && _rowSelect !== 0) {
                            $('#btnDatosParametroEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarParametro').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect !== undefined && _rowSelect !== 0) {
                    $('#btnDatosParametroEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarParametro').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode == 27) {
                    Parametros.cancelarProceso();
                }
            }

            $('#data').on('dblclick', 'tr td', function () {
                Parametros.ListarDatosParametroAEditar();
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                Parametros.Alta_Editar();
            });

            $('#btnAgregarParametro').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
                if (indexActual == 2) {
                    return false;
                } else {
                    $('#tipo').val(1);
                    document.getElementById('tituloEditar').style.display = 'none';
                    document.getElementById('tituloAgregar').style.display = 'block';

                    document.getElementById('btnAgregar').style.display = 'block';
                    document.getElementById('btnEditar').style.display = 'none'
                    $('#frmParametrosGrales')[0].reset();
                    $('#sComentarios').val("");
                }
            });

            $('#btnDatosParametroEditar').click(function () {
                if (Parametros.ListarDatosParametroAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                Parametros.Alta_Editar();
            });

            $('#btnEliminar').click(function () {
                var idParametro = $('#data tbody tr.selected td.idParametro').data("idparametro");
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
                if (indexActual == 0) {
                    if (idParametro != undefined) {
                        Parametros.Eliminar(idParametro, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                Parametros.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
            var idParametro = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarParametro, #btnDatosParametroEditar', function () {
                if (indexActual == 0 && idParametro !== null) {
                    $('#btnConsultar').removeClass("disabled");
                    $('#btnAgregarParametro').removeClass("disabled");
                    $('#btnDatosParametroEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                } else {
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarParametro').addClass("disabled");
                    $('#btnDatosParametroEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("parametro");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    Parametros.Consulta();
                    $('#btnDatosParametroEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
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
    Parametros.Consulta();
    Parametros.initBotones();
    Parametros.initAddColorRowTable();
    Parametros.initFormatoCampos();
    Parametros.initEventos();
}

function validaRFC(strRFC) {
    if (strRFC !== '') {
        var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
        return patt.test(strRFC);
    } else {
        return false;
    }
}
