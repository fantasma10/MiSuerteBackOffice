function initViewSucursales() {
    var Sucursales = {

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
            $.post(BASE_PATH + "/repay/administracion/ajax/sucursal.php",
                    {
                        tipo: 1
                    },
                    function (response) {
                        hideSpinner();
                        $('#btnBuscar').button('reset');
                        var obj = jQuery.parseJSON(response);
                        if (obj.oCodigo == 0 && obj.Data.length > 0) {
                            jQuery.each(obj.Data, function (index, value) {
                                var calle2 = obj.Data[index]['sCalle_2'] != 0 ? obj.Data[index]['sCalle_2'] : '';
                                $('#data tbody').append('<tr>' +
                                        '<td class="idSucursal"  data-idSucursal="' + obj.Data[index]['nIdSucursal'] + '">  ' + obj.Data[index]['nIdSucursal'] + '</td>' +
                                        '<td >' + obj.Data[index]['sNombreComercio'] + '</td>' +
                                        '<td >' + obj.Data[index]['sNombre'] + '</td>' +
                                        '<td >' + obj.Data[index]['sCalle_1'] + '</td>' +
                                        '<td >' + calle2 + '</td>' +
//                                        '<td >'+obj.Data[index]['sNumeroExterior']      +'</td>'+
                                        '<td >' + obj.Data[index]['sNumeroInterior'] + '</td>' +
//                                        '<td >'+obj.Data[index]['sPuntoReferencia']+'</td>'+
//                                        '<td >'+obj.Data[index]['nLatitud']+'</td>'+
//                                        '<td >'+obj.Data[index]['nLongitud']+'</td>'+
//                                        '<td >'+obj.Data[index]['nLimiteSucursal']+'</td>'+
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
                            $('#btnDatosSucursalEditar').addClass("disabled");
                            $('#btnAgregarSucursal').removeClass("disabled");
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
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var idSucursal = $('#idSucursal').val().length > 0 ? parseInt($('#idSucursal').val()) : 0;
            var cmbIdComercio = $('#cmbIdComercio').val();
            var sNombre = $('#sNombre').val();
            var puntoReferencia = $('#puntoReferencia').val();
            var calle1 = $('#calle1').val();
            var calle2 = $('#calle2').val();
            var nInterior = $('#nInterior').val();
            var nExterior = $('#nExterior').val();
            var latitud = $('#latitud').val();
            var longitud = $('#longitud').val();
            var limiteSucursales = $('#limiteSucursales').val();
            var campos = "";

            if (cmbIdComercio === undefined || cmbIdComercio === 0 || cmbIdComercio === "") {
                campos += '* Comercio.\n';
            }
            if (sNombre === undefined || sNombre === 0 || sNombre === "") {
                campos += '* Nombre.\n';
            }
            if (puntoReferencia === undefined || puntoReferencia === 0 || puntoReferencia === "") {
                campos += '* Punto de referencia.\n';
            }
            if (calle1 === undefined || calle1 === 0 || calle1 === "") {
                campos += '* Calle No 1.\n';
            }
            if (nInterior === undefined || nInterior === 0 || nInterior === "") {
                campos += '* No Interior.\n';
            }
            if (limiteSucursales === undefined || limiteSucursales === 0 || limiteSucursales === "") {
                campos += '* Limite de Sucursales.\n';
            }

            if (campos !== null && campos !== "") {
                $('#btnAgregar').button('reset');
                var black = (campos !== "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                _tipo = tipo === 1 ? 2 : 3;
                showSpinner();
                $.post(BASE_PATH + "/repay/administracion/ajax/sucursal.php",
                        {
                            tipo: _tipo,
                            idSucursal: idSucursal,
                            idComercio: cmbIdComercio,
                            sNombre: sNombre,
                            puntoReferencia: puntoReferencia,
                            calle1: calle1,
                            calle2: calle2,
                            nActivo:  activo,
                            nInterior: nInterior,
                            nExterior: nExterior,
                            latitud: latitud,
                            longitd: longitud,
                            limiteSucursales: limiteSucursales
                        },
                        function (response) {
                            hideSpinner();
                            $('#btnAgregar').button('reset');
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                $('#frmSucursales')[0].reset();
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Sucursales.Consulta();
                                $('.nav-tabs a[href="#step1"]').tab('show');
                            } else {
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');
                                Sucursales.Consulta();
                            }
                        }).fail(function (resp) {
                    $('#btnAgregar').button('reset');
                    hideSpinner();
                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                    Sucursales.Consulta();
                });
            }

        },

        Eliminar: function (idSucursal, activo) {
            var msg = "";
            if (activo == 0) {
                msg = "Desea activar el Parámetro";
            } else {
                msg = "Desea desactivar el Parámetro";
            }
            if (idSucursal != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/sucursal.php",
                                {
                                    tipo: 4,
                                    idSucursal: idSucursal,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                Sucursales.Consulta();
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
                var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
                var idSucursal = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idSucursal != null) {
                    $('#btnDatosSucursalEditar').removeClass("disabled");
                    $('#btnAgregarSucursal').removeClass("disabled");
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

        ListarDatosSucursalAEditar: function () {
            var idSucursal = $('#data tbody tr.selected td.idSucursal').data("idsucursal");
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
            if (indexActual == 0) {
                if (idSucursal != undefined) {
                    if (activo == 1) {
                        $('#frmSucursales')[0].reset();
                        document.getElementById('btnEditar').style.display = 'block';
                        document.getElementById('btnAgregar').style.display = 'none';
                        document.getElementById('tituloEditar').style.display = 'block';
                        document.getElementById('tituloAgregar').style.display = 'none';
                        $('.nav-tabs a[href="#step2"]').tab('show');
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/sucursal.php",
                                {
                                    tipo: 1,
                                    idSucursal: idSucursal,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                obj = obj.Data;
                                $('#tipo').val(2);
                                $('#idSucursal').val(obj[0]["nIdSucursal"]);
                                $('#cmbIdComercio').val(obj[0]["nIdComercio"]);
                                $('#sNombre').val(obj[0]["sNombre"]);
                                $('#puntoReferencia').val(obj[0]["sPuntoReferencia"]);
                                $('#calle1').val(obj[0]["sCalle_1"]);
                                $('#calle2').val(obj[0]["sCalle_2"]);
                                $('#nInterior').val(obj[0]["sNumeroInterior"]);
                                $('#nExterior').val(obj[0]["sNumeroExterior"]);
//                                    obj[0]["sCalle_2"] > 0 ? $('#calle2').val(obj[0]["sCalle_2"]) : $('#calle2').val("");
                                obj[0]["sNumeroExterior"] > 0 ? $('#nExterior').val(obj[0]["sNumeroExterior"]) : $('#nExterior').val("");
                                obj[0]["nLatitud"] > 0 ? $('#latitud').val(obj[0]["nLatitud"]) : $('#latitud').val("");
                                obj[0]["nLongitud"] != 0 ? $('#longitud').val(obj[0]["nLongitud"]) : $('#longitud').val("");
//                                    $('#longitud').val(obj[0]["nLongitud"]);
                                $('#limiteSucursales').val(obj[0]["nLimiteSucursal"]);
                                $('#cmbIdComercio').attr("disabled", true);
                            } else {
                                hideSpinner();
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');

                            }
                        }).fail(function () {

                        });
                        $('.nav-tabs a[href="#step3"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarSucursal').addClass("disabled");
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
            var cmbIdComercio = $('#cmbIdComercio').val();
            var sNombre = $('#sNombre').val();
            var puntoReferencia = $('#puntoReferencia').val();
            var calle1 = $('#calle1').val();
            var calle2 = $('#calle2').val();
            var nInterior = $('#nInterior').val();
            var nExterior = $('#nExterior').val();
            var latitud = $('#latitud').val();
            var longitud = $('#longitud').val();
            var limiteSucursales = $('#limiteSucursales').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (cmbIdComercio != undefined && cmbIdComercio != 0 && cmbIdComercio !== "") {
                campos += '* Comercio.\n';
            }
            if (sNombre != undefined && sNombre != 0 && sNombre !== "") {
                campos += '* Nombre.\n';
            }
            if (puntoReferencia != undefined && puntoReferencia != 0 && puntoReferencia !== "") {
                campos += '* Punto de referencia.\n';
            }
            if (calle1 != undefined && calle1 != 0 && calle1 !== "") {
                campos += '* Calle No 1.\n';
            }
            if (nInterior != undefined && nInterior != 0 && nInterior !== "") {
                campos += '* No Interior.\n';
            }
            if (limiteSucursales != undefined && limiteSucursales != 0 && limiteSucursales !== "") {
                campos += '* Limite de Sucursales.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect !== undefined && _rowSelect !== 0) {
                            $('#btnDatosSucursalEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarSucursal').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect !== undefined && _rowSelect !== 0) {
                    $('#btnDatosSucursalEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarSucursal').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode == 27) {
                    Sucursales.cancelarProceso();
                }
            }

            $('#data').on('dblclick', 'tr td', function () {
                Sucursales.ListarDatosSucursalAEditar();
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                Sucursales.Alta_Editar();
            });

            $('#btnAgregarSucursal').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
                if (indexActual == 2 || indexActual == 1) {
                    return false;
                } else {
                    $('#tipo').val(1);
                    document.getElementById('tituloEditar').style.display = 'none';
                    document.getElementById('tituloAgregar').style.display = 'block';

                    document.getElementById('btnAgregar').style.display = 'block';
                    document.getElementById('btnEditar').style.display = 'none'
                    $('#frmSucursales')[0].reset();
                    $('#cmbIdComercio').attr("disabled", false);
                }
            });

            $('#btnDatosSucursalEditar').click(function () {
                if (Sucursales.ListarDatosSucursalAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                Sucursales.Alta_Editar();
            });

            $('#btnEliminar').click(function () {
                var idSucursal = $('#data tbody tr.selected td.idSucursal').data("idsucursal");
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
                if (indexActual == 0) {
                    if (idSucursal != undefined) {
                        Sucursales.Eliminar(idSucursal, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                Sucursales.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
            var idSucursal = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarSucursal, #btnDatosSucursalEditar', function () {
                if (indexActual == 0 && (idSucursal == undefined || idSucursal == null)) {
//                            $('#btnConsultar').removeClass("disabled");
//                            $('#btnAgregarSucursal').removeClass("disabled");
//                            $('#btnDatosSucursalEditar').removeClass("disabled");
//                            $('#btnEliminar').removeClass("disabled");
//                        }else{
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarSucursal').addClass("disabled");
                    $('#btnDatosSucursalEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("sucursal");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    Sucursales.Consulta();
                    $('#btnDatosSucursalEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });
        },

        initCombos: function () {
//            $('#cmbIdComercio').empty();
            var listaTipoComercio = "";
            $.post(BASE_PATH + "/repay/administracion/ajax/sucursal.php",
                    {
                        tipo: 5
                    },
                    function (resp) {
                        var obj = jQuery.parseJSON(resp);
                        listaTipoComercio += "<option value='0'>Seleccione...</option>";

                        if (obj.oCodigo == 0) {
                            jQuery.each(obj.Data, function (index, val) {
                                listaTipoComercio += '<option value=' + obj.Data[index]['nIdComercio'] + '>' + obj.Data[index]['sNombreComercio'] + '</option>';
                            });

                            $('#cmbIdComercio').html(listaTipoComercio);
                        }
                    }).fail(function () {
                jAlert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde", "Informacion al usuario")
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
    Sucursales.Consulta();
    Sucursales.initCombos();
    Sucursales.initBotones();
    Sucursales.initAddColorRowTable();
    Sucursales.initFormatoCampos();
    Sucursales.initEventos();
}

function validaRFC(strRFC) {
    if (strRFC !== '') {
        var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
        return patt.test(strRFC);
    } else {
        return false;
    }
}
