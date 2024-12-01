function initViewContactoComercio() {
    var ContactoComercio = {

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
            $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
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
                                '<td class="idContactoComercio"  data-idContactoComercio="' + obj.Data[index]['nIdContactoComercio'] + '">  ' + obj.Data[index]['nIdContactoComercio'] + '</td>' +
                                '<td >' + obj.Data[index]['sNombreTipoContacto'] + '</td>' +
                                '<td >' + obj.Data[index]['sNombreComercio'] + '</td>' +
                                '<td >' + obj.Data[index]['sNombre'] + '</td>' +
                                '<td >' + obj.Data[index]['sApellidoPaterno'] + '</td>' +
                                '<td >' + obj.Data[index]['sApellidoMaterno'] + '</td>' +
                                '<td >' + obj.Data[index]['sCorreoElectronico'] + '</td>' +
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
                    $('#btnDatosContactoComercioEditar').addClass("disabled");
                    $('#btnAgregarContactoComercio').removeClass("disabled");
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
            var nIdContactoComercio = $('#idContactoComercio').val().length > 0 ? parseInt($('#idContactoComercio').val()) : 0;
            var cmbTipoContacto = $('#cmbTipoContacto').val().length > 0 ? parseInt($('#cmbTipoContacto').val()) : 0;
            var cmbIdComercio = $('#cmbIdComercio').val().length > 0 ? parseInt($('#cmbIdComercio').val()) : 0;
            var sNombre = $('#sNombre').val();
            var sApellidoP = $('#sApellidoP').val();
            var sApellidoM = $('#sApellidoM').val();
            var sCorreo = $('#sCorreo').val();
            var sContrasenia = $('#sContrasenia').val();
            var campos = "";

            if (cmbTipoContacto === undefined || cmbTipoContacto === 0 || cmbTipoContacto === "") {
                campos += '* Tipo Contacto.\n';
            }
            if (cmbIdComercio === undefined || cmbIdComercio === 0 || cmbIdComercio === "") {
                campos += '* Comercio.\n';
            }
            if (sNombre === undefined || sNombre === 0 || sNombre === "") {
                campos += '* Nombre.\n';
            }
            if (sApellidoP === undefined || sApellidoP === 0 || sApellidoP === "") {
                campos += '* Apellido Paterno.\n';
            }
            if (sApellidoM === undefined || sApellidoM === 0 || sApellidoM === "") {
                campos += '* Apellido Materno.\n';
            }

            //Validar contraseña
            var validPassword = validarPassword(sContrasenia);
            if (sContrasenia === undefined || sContrasenia === 0 || sContrasenia === "") {
                campos += '* Contraseña.\n';

            } else if ((sContrasenia.length < 8 || sContrasenia.length > 16) && tipo == 1) {
                campos += '* La Contraseña no cumple con la longitud requerida.\n';

            } else if (!validPassword && tipo == 1) {
                campos += '* Capture una contraseña valida.\n';
            }

            //Validar Correo
            var validacion = validarMail(sCorreo);
            if (sCorreo === undefined || sCorreo === 0 || sCorreo === "") {
                campos += '* Correo.\n';

            } else if (!validacion) {
                campos += '* Capture un correo Valido.\n';

            }

            if (campos !== null && campos !== "") {
                $('#btnAgregar').button('reset');
                var black = (campos !== "") ? "Error en Los siguientes datos:" : "";
                jAlert(black + '\n' + campos + '\n', "Información al usuario");
                event.preventDefault();
            } else {
                _tipo = tipo === 1 ? 2 : 3;
                showSpinner();
                $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
                {
                    tipo: _tipo,
                    idContactoComercio: nIdContactoComercio,
                    idTipoContacto: cmbTipoContacto,
                    idComercio: cmbIdComercio,
                    sNombre: sNombre,
                    sApellidoP: sApellidoP,
                    sApellidoM: sApellidoM,
                    sCorreo: sCorreo,
                    sContrasenia: sContrasenia
                },
                function (response) {
                    hideSpinner();
                    $('#btnAgregar').button('reset');
                    var obj = jQuery.parseJSON(response);

                    if (obj.oCodigo === 0) {
                        $('#frmContactoComercio')[0].reset();
                        jAlert(obj.Data[0].errorMsg, "Información al usuario");
                        ContactoComercio.Consulta();
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else if (obj.oCodigo == 2) {
                        jAlert(obj.sMensaje, "Información al usuario");

                    } else {
                        jAlert(obj.sMensaje, "Información al usuario");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                        ContactoComercio.Consulta();
                    }
                }).fail(function (resp) {
                    $('#btnAgregar').button('reset');
                    hideSpinner();
                    jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde', 'Información al usuario');
                    ContactoComercio.Consulta();
                });
            }

        },

        Eliminar: function (idContactoComercio, activo) {
            var msg = "";
            if (activo == 0) {
                msg = "Desea activar el Contacto-Comercio";
            } else {
                msg = "Desea desactivar el Contacto-Comercio";
            }
            if (idContactoComercio != undefined) {
                jConfirm('\u00BF' + msg + '\u003F', 'Seleccione una opción', function (confirmado) {
                    if (confirmado) {
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
                            {
                                tipo: 4,
                                idContactoComercio: idContactoComercio,
                                nActivo: activo
                            }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                jAlert(obj.Data[0].errorMsg, "Información al usuario");
                                ContactoComercio.Consulta();
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
                var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
                var idContactoComercio = $('#data tbody tr.selected td:first').html();
                if (indexActual == 0 && idContactoComercio != null) {
                    $('#btnDatosContactoComercioEditar').removeClass("disabled");
                    $('#btnAgregarContactoComercio').removeClass("disabled");
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

        ListarDatosContactoComercioAEditar: function () {
            var idContactoComercio = $('#data tbody tr.selected td.idContactoComercio').data("idcontactocomercio");
            var activo = $('#data tbody tr.selected td.activo').data("nactivo");
            var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
            if (indexActual == 0) {
                if (idContactoComercio != undefined) {
                    if (activo == 1) {
                        $('#frmContactoComercio')[0].reset();
                        document.getElementById('btnEditar').style.display = 'block';
                        document.getElementById('btnAgregar').style.display = 'none';
                        document.getElementById('tituloEditar').style.display = 'block';
                        document.getElementById('tituloAgregar').style.display = 'none';
                        $('.nav-tabs a[href="#step2"]').tab('show');
                        showSpinner();
                        $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
                                {
                                    tipo: 1,
                                    idContactoComercio: idContactoComercio,
                                    nActivo: activo
                                }, function (response) {
                            hideSpinner();
                            var obj = jQuery.parseJSON(response);
                            if (obj.oCodigo === 0) {
                                obj = obj.Data;
                                $('#tipo').val(2);
                                $('#idContactoComercio').val(obj[0]["nIdContactoComercio"]);
                                $('#cmbTipoContacto').val(obj[0]["nIdTipoContacto"]);
                                $('#cmbIdComercio').val(obj[0]["nIdComercio"]);
                                $('#sNombre').val(obj[0]["sNombre"]);
                                $('#sApellidoP').val(obj[0]["sApellidoPaterno"]);
                                $('#sApellidoM').val(obj[0]["sApellidoMaterno"]);
                                $('#sCorreo').val(obj[0]["sCorreoElectronico"]);
                                $('#sContrasenia').val(obj[0]["cContrasena"]);
                                $('#sContrasenia').attr("disabled", true);
                            } else {
                                hideSpinner();
                                jAlert(obj.sMensaje, "Información al usuario");
                                $('.nav-tabs a[href="#step1"]').tab('show');

                            }
                        }).fail(function () {

                        });
                        $('.nav-tabs a[href="#step3"]').tab('show');
                        $('#btnConsultar').addClass("disabled");
                        $('#btnAgregarContactoComercio').addClass("disabled");
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
            var cmbTipoContacto = $('#cmbTipoContacto').val().length > 0 ? parseInt($('#cmbTipoContacto').val()) : 0;
            var cmbIdComercio = $('#cmbIdComercio').val().length > 0 ? parseInt($('#cmbIdComercio').val()) : 0;
            var sNombre = $('#sNombre').val();
            var sApellidoP = $('#sApellidoP').val();
            var sApellidoM = $('#sApellidoM').val();
            var sCorreo = $('#sCorreo').val();
            var sContrasenia = $('#sContrasenia').val();
            var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
            var _rowSelect = $("#data tbody tr.selected td:first").html();
            var campos = "";

            if (cmbTipoContacto != undefined && cmbTipoContacto != 0) {
                campos += '* Tipo Contacto.\n';
            }
            if (cmbIdComercio != undefined && cmbIdComercio != 0) {
                campos += '* Comercio.\n';
            }
            if (sNombre != undefined && sNombre != 0 && sNombre != "") {
                campos += '* Nombre.\n';
            }
            if (sApellidoP != undefined && sApellidoP != 0 && sApellidoP != "") {
                campos += '* Apellido Paterno.\n';
            }
            if (sApellidoM != undefined && sApellidoM != 0 && sApellidoM != "") {
                campos += '* Apellido Materno.\n';
            }
            if (sContrasenia != undefined && sContrasenia != 0 && sContrasenia != "") {
                campos += '* Contraseña.\n';
            }
            if (sCorreo != undefined && sCorreo != 0 && sCorreo != "") {
                campos += '* Correo.\n';
            }

            if ((campos.length > 0) && indexActual === 1) {
                jConfirm('Se perderan los datos capturados', '\u00BFDesea salir\u003F', function (confirmado) {
                    if (confirmado) {
                        if (_rowSelect !== undefined && _rowSelect !== 0) {
                            $('#btnDatosContactoComercioEditar').removeClass("disabled");
                            $('#btnEliminar').removeClass("disabled");
                        }
                        $('#btnAgregarContactoComercio').removeClass("disabled");
                        $('.nav-tabs a[href="#step1"]').tab('show');
                    } else {
                        $('.nav-tabs a[href="#step2"]').tab('show');
                    }
                });
            } else {
                if (_rowSelect !== undefined && _rowSelect !== 0) {
                    $('#btnDatosContactoComercioEditar').removeClass("disabled");
                    $('#btnEliminar').removeClass("disabled");
                }
                $('#btnAgregarContactoComercio').removeClass("disabled");
                $('.nav-tabs a[href="#step1"]').tab('show');
            }
        },

        initEventos: function () {
            document.onkeydown = function (evt) {
                if (evt.keyCode == 27) {
                    ContactoComercio.cancelarProceso();
                }
            }

            $('#data').on('dblclick', 'tr td', function () {
                ContactoComercio.ListarDatosContactoComercioAEditar();
            });
        },

        initBotones: function () {
            $('#btnAgregar').click(function () {
                ContactoComercio.Alta_Editar();
            });

            $('#btnAgregarContactoComercio').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
                if (indexActual == 2 || indexActual == 1) {
                    return false;
                } else {
                    $('#tipo').val(1);
                    document.getElementById('tituloEditar').style.display = 'none';
                    document.getElementById('tituloAgregar').style.display = 'block';

                    document.getElementById('btnAgregar').style.display = 'block';
                    document.getElementById('btnEditar').style.display = 'none'
                    $('#frmContactoComercio')[0].reset();
                    $('#sContrasenia').attr("disabled", false);
                }
            });

            $('#btnDatosContactoComercioEditar').click(function () {
                if (ContactoComercio.ListarDatosContactoComercioAEditar() == false) {
                    return false;
                }
            });

            $('#btnEditar').click(function () {
                ContactoComercio.Alta_Editar();
            });

            $('#btnEliminar').click(function () {
                var idContactoComercio = $('#data tbody tr.selected td.idContactoComercio').data("idcontactocomercio");
                var activo = $('#data tbody tr.selected td.activo').data("nactivo");
                var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
                if (indexActual == 0) {
                    if (idContactoComercio != undefined) {
                        ContactoComercio.Eliminar(idContactoComercio, activo);
                    } else {
                        jAlert("Seleccione un registro", "Información al usuario");
                        return false;
                    }
                } else {
                    return false;
                }
            });

            $(document).on('click', '#btnCancelar', function () {
                ContactoComercio.cancelarProceso();
            });

            var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
            var idContactoComercio = $('#data tbody tr.selected td:first').html();

            $(document).on('click', '#btnAgregarContactoComercio, #btnDatosContactoComercioEditar', function () {
                if (indexActual == 0 && (idContactoComercio == undefined || idContactoComercio == null)) {
//                            $('#btnConsultar').removeClass("disabled");
//                            $('#btnAgregarContactoComercio').removeClass("disabled");
//                            $('#btnDatosContactoComercioEditar').removeClass("disabled");
//                            $('#btnEliminar').removeClass("disabled");
//                        }else{
                    $('#btnConsultar').addClass("disabled");
                    $('#btnAgregarContactoComercio').addClass("disabled");
                    $('#btnDatosContactoComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });

            $('#btnConsultar').click(function () {
                var indexActual = $('.wizard .nav-tabs li.active').data("contacto");
                if (indexActual == 1 || indexActual == 2) {
                    return false;
                } else {
                    ContactoComercio.Consulta();
                    $('#btnDatosContactoComercioEditar').addClass("disabled");
                    $('#btnEliminar').addClass("disabled");
                }
            });
        },

        initCombos: function () {

            var listaComercio = "";
            $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
                    {
                        tipo: 5
                    },
                    function (resp) {
                        var obj = jQuery.parseJSON(resp);
                        listaComercio += "<option value='0'>Seleccione...</option>";
                        if (obj.oCodigo == 0) {
                            jQuery.each(obj.Data, function (index, val) {
                                listaComercio += '<option value=' + obj.Data[index]['nIdComercio'] + '>' + obj.Data[index]['sNombreComercio'] + '</option>';
                            });
                            $('#cmbIdComercio').html(listaComercio);
                        }
                    }).fail(function () {
                jAlert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde", "Informacion al usuario");
            });

            var listaTipoContacto = "";
            $.post(BASE_PATH + "/repay/administracion/ajax/contactoComercio.php",
                    {
                        tipo: 6
                    },
                    function (resp) {
                        var obj = jQuery.parseJSON(resp);
                        listaTipoContacto += "<option value='0'>Seleccione...</option>";
                        if (obj.oCodigo === 0) {
                            jQuery.each(obj.Data, function (index, val) {
                                listaTipoContacto += '<option value=' + obj.Data[index]['nIdTipoContacto'] + '>' + obj.Data[index]['sDescripcion'] + '</opction>';
                            });
                        }
                        $('#cmbTipoContacto').html(listaTipoContacto);
                    }).fail(function (resp) {
                jAlert("Ha ocurrido un error, intente de nuevo m\u00E1s tarde", "Informacion al usuario");
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
    ContactoComercio.Consulta();
    ContactoComercio.initCombos();
    ContactoComercio.initBotones();
    ContactoComercio.initAddColorRowTable();
    ContactoComercio.initFormatoCampos();
    ContactoComercio.initEventos();
}
function validarMail(mail) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(mail);
}
function validarPassword(pass) {
    var retValue = true;

    var regexNum = /\d/g;
    var regexUpper = /[A-Z]/;

    if (pass.length < 8) {
        retValue = false;
    } else if (!regexNum.test(pass)) {
        retValue = false;
    } else if (!regexUpper.test(pass)) {
        retValue = false;
    }

    return retValue;
}

